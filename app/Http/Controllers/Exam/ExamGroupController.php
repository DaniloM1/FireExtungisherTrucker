<?php

namespace App\Http\Controllers\Exam;

use App\Models\Exam\ExamGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Exam\ExamSubject;
use App\Models\Exam\Announcement;

class ExamGroupController extends Controller
{
    public function index()
    {
        $groups = ExamGroup::withCount('members')->orderByDesc('created_at')->paginate(20);
//        dd($groups);
        return view('admin.exam.exam_groups.index', compact('groups'));
    }

    public function create()
    {
        return view('exam_groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'start_date' => 'required|date',
            'exam_date'  => 'nullable|date|after_or_equal:start_date',
        ]);

        ExamGroup::create($validated);
        return redirect()->route('exam_groups.index')->with('success', 'Grupa je uspešno dodata!');
    }

    public function show(ExamGroup $examGroup)
    {
        $examGroup->load([
            'members.user.company',
            'members.user',
            'members.memberSubjects.subject',
        ]);

        $allDocTypes = \App\Models\Exam\DocumentType::all();

        foreach ($examGroup->members as $member) {
            $user = $member->user;
            $companyId = $user->company_id;

            // Svi potrebni tipovi za ovog membera
            if ($companyId) {
                $requiredDocs = $allDocTypes->where('code', 'company_user_exam')->values();
            } else {
                $requiredDocs = $allDocTypes->where('code', 'user_exam')->values();
            }
            $member->required_docs = $requiredDocs;

            // Dokumenti koje je user postavio (za ovu grupu)
            $userDocs = \App\Models\Exam\Document::where('user_id', $user->id)
                ->where('exam_group_id', $examGroup->id)
                ->get();

            // Dokumenti koje je firma postavila (za ovu grupu)
            $companyDocs = ($companyId)
                ? \App\Models\Exam\Document::whereNull('user_id')
                    ->where('exam_group_id', $examGroup->id)
                    ->get()
                : collect();

            // Mapiranje: tip_dokumenta_id => dokument
            $member->user_exam_documents = $userDocs->keyBy('document_type_id');
            $member->company_exam_documents = $companyDocs->keyBy('document_type_id');
        }

        $allAnnouncements = Announcement::where('exam_group_id', $examGroup->id)->get();


        $generalAnnouncements = $allAnnouncements->where('exam_subject_id', null);


        $subjectAnnouncements = $allAnnouncements
            ->whereNotNull('exam_subject_id')
            ->groupBy(fn($a) => (string) $a->exam_subject_id)
            ->all();
        $subjects = $examGroup->members
            ->flatMap(fn($m) => $m->memberSubjects)
            ->pluck('subject')
            ->unique('id');

        $documents = \App\Models\Exam\Document::with('documentType')
            ->whereIn('exam_subject_id', $subjects->pluck('id'))
            ->whereHas('documentType', fn($q) => $q->where('code', 'subject_pdf'))
            ->get()
            ->groupBy('exam_subject_id');
        return view('admin.exam.exam_groups.show', [
            'examGroup' => $examGroup,
            'members'   => $examGroup->members,
            'generalAnnouncements' => $generalAnnouncements,
            'subjectAnnouncements' => $subjectAnnouncements,
            'documentsBySubject' => $documents,
        ]);
    }


    public function edit(ExamGroup $examGroup)
    {
        return view('exam_groups.edit', compact('examGroup'));
    }

    public function update(Request $request, ExamGroup $examGroup)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'start_date' => 'required|date',
            'exam_date'  => 'nullable|date|after_or_equal:start_date',
        ]);
        $examGroup->update($validated);

        return redirect()->route('exam_groups.index')->with('success', 'Grupa izmenjena.');
    }

    public function destroy(ExamGroup $examGroup)
    {
        $examGroup->delete();
        return redirect()->route('exam_groups.index')->with('success', 'Grupa je obrisana.');
    }
    public function unlockSubject(ExamGroup $examGroup, ExamSubject $subject)
    {
        foreach ($examGroup->members as $member) {
            $ms = $member->memberSubjects->firstWhere('exam_subject_id', $subject->id);
            if ($ms && $ms->status == 'locked') {
                $ms->update(['status' => 'unlocked', 'unlocked_at' => now()]);
            }
        }
        return back()->with('success', 'Predmet otključan za sve kandidate!');
    }
    public function materials(\App\Models\Exam\ExamGroup $examGroup, \App\Models\Exam\ExamSubject $subject)
    {
        // Svi materijali za dati predmet u ovoj grupi
        $documents = \App\Models\Document::where('exam_group_id', $examGroup->id)
            ->where('exam_subject_id', $subject->id)
            ->latest()
            ->get();

        $isAdmin = auth()->user()->hasRole('super_admin');

        return view('admin.exam.exam_groups.materials', compact('examGroup', 'subject', 'documents', 'isAdmin'));
    }
    public function usersNotInGroup($groupId)
    {
        $group = ExamGroup::findOrFail($groupId);
        // Pronađi ID-jeve članova grupe
        $memberIds = $group->members()->pluck('user_id');
        // Nađi korisnike koji NISU članovi te grupe
        $users = \App\Models\User::whereNotIn('id', $memberIds)->get(['id', 'name', 'email']);
        return response()->json($users);
    }
    public function addMember(Request $request, $groupId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // 1. Provera da li je već član
        $exists = \App\Models\Exam\ExamGroupMember::where([
            'exam_group_id' => $groupId,
            'user_id' => $request->user_id
        ])->exists();
        if ($exists) {
            return response()->json(['error' => 'Već je član'], 422);
        }

        // 2. Kreiraj članstvo
        $member = \App\Models\Exam\ExamGroupMember::create([
            'exam_group_id' => $groupId,
            'user_id' => $request->user_id,
            'status' => 'active',
            'joined_at' => now(),
        ]);

        // 3. Pronađi usera da saznaš education_level
        $user = \App\Models\User::findOrFail($request->user_id);

        // 4. Izaberi sve predmete koji pripadaju toj grupi i korisniku po nivou
        $subjects = \App\Models\Exam\ExamSubject::where(function($q) use ($user) {
            $q->where('education_level', 'ALL')
                ->orWhere('education_level', $user->education_level);
        })->get();

        // 5. Bulk insert u exam_member_subjects
        $now = now();
        $data = [];
        foreach ($subjects as $subject) {
            $data[] = [
                'exam_group_member_id' => $member->id,
                'exam_subject_id'      => $subject->id,
                'status'               => 'locked', // ili 'unlocked' ako odmah treba da bude otključan
                'unlocked_at'          => null,
                'result_date'          => null,
                'created_at'           => $now,
                'updated_at'           => $now,
            ];
        }
        \App\Models\Exam\ExamMemberSubject::insert($data);

        return response()->json(['success' => true]);
    }

    public function userSearch(Request $request, $groupId)
    {
        $q = $request->input('q');
        $group = ExamGroup::findOrFail($groupId);

        $members = $group->members()->pluck('user_id');
        $users = \App\Models\User::whereNotIn('id', $members)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            })
            ->limit(20)
            ->get(['id', 'name', 'email']);

        return response()->json($users);
    }


}

