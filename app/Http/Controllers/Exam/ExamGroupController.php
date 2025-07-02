<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\{StoreExamGroupRequest, UpdateExamGroupRequest, AddMemberToGroupRequest};
use App\Models\Exam\{ExamGroup, ExamSubject, ExamGroupMember, ExamMemberSubject, Document, DocumentType, Announcement};
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ExamGroupController extends Controller
{
    /* ----------------------------- CRUD ----------------------------- */

    public function index()
    {
        $groups = ExamGroup::withCount('members')->latest()->paginate(20);
        return view('admin.exam.exam_groups.index', compact('groups'));
    }

    public function create()
    {
//        dd('create');
        return view('admin.exam.exam_groups.create');
    }

    public function store(StoreExamGroupRequest $request)
    {
        $data    = $request->validated();
        $group   = ExamGroup::create($data);
        $members = $data['members'] ?? [];

        $this->syncMembers($group, $members, collect());
        return redirect()->route('exam.index')->with('success', 'Grupa uspešno kreirana!');
    }

    public function show(ExamGroup $examGroup)
    {
        $user = auth()->user();

        if (
            !$user->hasRole('super_admin')
            && !$examGroup->members->contains('user_id', $user->id)
        ) {
            abort(403, 'Nemate pristup ovoj grupi.');
        }

        $examGroup->load([
            'members.user.company',
            'members.user',
            'members.memberSubjects.subject',
        ]);

        $this->prepareMemberDocuments($examGroup);
        [$generalAnnouncements, $subjectAnnouncements] = $this->groupAnnouncements($examGroup->id);
        $documentsBySubject = $this->subjectDocuments($examGroup);

        return view('admin.exam.exam_groups.show', [
            'examGroup'            => $examGroup,
            'members'              => $examGroup->members,
            'generalAnnouncements' => $generalAnnouncements,
            'subjectAnnouncements' => $subjectAnnouncements,
            'documentsBySubject'   => $documentsBySubject,
        ]);
    }

    public function edit(ExamGroup $examGroup)
    {
        return view('admin.exam.exam_groups.edit', compact('examGroup'));
    }

    public function update(UpdateExamGroupRequest $request, ExamGroup $examGroup)
    {
        $examGroup->update($request->validated());
        return redirect()->route('exam.index')->with('success', 'Grupa izmenjena.');
    }

    public function destroy(ExamGroup $examGroup)
    {
        Announcement::where('exam_group_id', $examGroup->id)->delete();

        Document::where('exam_group_id', $examGroup->id)->delete();

        foreach ($examGroup->members as $member) {
            $member->memberSubjects()->delete();
            $member->delete();
        }

        $examGroup->delete();

        return redirect()->route('exam.index')->with('success', 'Grupa je obrisana.');
    }




    /* --------------------------- GROUP OPS -------------------------- */

    public function unlockSubject(ExamGroup $examGroup, ExamSubject $subject)
    {
        $examGroup->members
            ->flatMap->memberSubjects
            ->where('exam_subject_id', $subject->id)
            ->where('status', 'locked')
            ->each->update(['status' => 'unlocked', 'unlocked_at' => now()]);

        return back()->with('success', 'Predmet otključan za sve kandidate!');
    }

    public function materials(ExamGroup $examGroup, ExamSubject $subject)
    {
        $documents = Document::where([
            'exam_group_id'   => $examGroup->id,
            'exam_subject_id' => $subject->id,
        ])->latest()->get();

        $isAdmin = auth()->user()->hasRole('super_admin');
        return view('admin.exam.exam_groups.materials', compact('examGroup', 'subject', 'documents', 'isAdmin'));
    }

    /* -------------------------- AJAX HELPERS ------------------------ */

    public function usersNotInGroup($groupId)
    {
        $memberIds = ExamGroup::findOrFail($groupId)->members()->pluck('user_id');
        return response()->json(User::whereNotIn('id', $memberIds)->get(['id', 'name', 'email']));
    }

    public function addMember(AddMemberToGroupRequest $request, $groupId)
    {
        $group = ExamGroup::findOrFail($groupId);
        $userId = $request->validated('user_id');

        if ($group->members()->where('user_id', $userId)->exists()) {
            return response()->json(['error' => 'Već je član'], 422);
        }

        // Saznaj koji su predmeti već otključani unutar grupe
        $unlockedSubjectIds = ExamMemberSubject::whereIn('exam_group_member_id', $group->members()->pluck('id'))
            ->where('status', 'unlocked')
            ->pluck('exam_subject_id')
            ->unique();

        $this->syncMembers($group, [$userId], $unlockedSubjectIds);
        return response()->json(['success' => true]);
    }

    public function userSearch(Request $request, $groupId)
    {
        $q = $request->input('q');
        $members = ExamGroup::findOrFail($groupId)->members()->pluck('user_id');

        return response()->json(
            User::whereNotIn('id', $members)
                ->where(fn($query) => $query->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"))
                ->limit(20)
                ->get(['id', 'name', 'email'])
        );
    }

    public function globalUserSearch(Request $request)
    {
        $q = $request->input('q');

        $users = User::with('company')
            ->where(fn($query) => $query
                ->where('name', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%")
                ->orWhereHas('company', fn($q2) => $q2->where('name', 'like', "%{$q}%"))
            )
            ->latest('id')
            ->limit(20)
            ->get();

        return response()->json($users->map(fn($u) => [
            'id'      => $u->id,
            'name'    => $u->name,
            'email'   => $u->email,
            'company' => $u->company ? ['id' => $u->company->id, 'name' => $u->company->name] : null,
        ]));
    }

    /* ------------------------- PRIVATE HELPERS ---------------------- */

    private function syncMembers(ExamGroup $group, array $userIds, Collection $unlockedSubjectIds): void
    {
        foreach ($userIds as $id) {
            $member = $group->members()->create([
                'user_id'   => $id,
                'status'    => 'active',
                'joined_at' => now(),
            ]);

            $subjects = $this->subjectsForUser(User::find($id));
            $now      = now();

            $rows = $subjects->map(function ($s) use ($member, $unlockedSubjectIds, $now) {
                $isUnlocked = $unlockedSubjectIds->contains($s->id);
                return [
                    'exam_group_member_id' => $member->id,
                    'exam_subject_id'      => $s->id,
                    'status'               => $isUnlocked ? 'unlocked' : 'locked',
                    'unlocked_at'          => $isUnlocked ? $now : null,
                    'created_at'           => $now,
                    'updated_at'           => $now,
                ];
            });

            ExamMemberSubject::insert($rows->toArray());
        }
    }

    private function subjectsForUser(User $user): Collection
    {
        return ExamSubject::where('education_level', 'ALL')
            ->orWhere('education_level', $user->education_level)
            ->get();
    }

    private function prepareMemberDocuments(ExamGroup $examGroup): void
    {
        $allDocTypes = DocumentType::all();

        $examGroup->members->each(function ($member) use ($allDocTypes, $examGroup) {
            $docTypes = $member->user->company_id
                ? $allDocTypes->where('code', 'company_user_exam')
                : $allDocTypes->where('code', 'user_exam');

            $member->required_docs = $docTypes->values();
            $member->user_exam_documents = Document::where('user_id', $member->user_id)
                ->where('exam_group_id', $examGroup->id)
                ->get()
                ->keyBy('document_type_id');

            $member->company_exam_documents = $member->user->company_id
                ? Document::whereNull('user_id')
                    ->where('exam_group_id', $examGroup->id)
                    ->get()
                    ->keyBy('document_type_id')
                : collect();
        });
    }

    private function groupAnnouncements(int $groupId): array
    {
        $announcements = Announcement::where('exam_group_id', $groupId)->get();
        return [
            $announcements->whereNull('exam_subject_id'),
            $announcements->whereNotNull('exam_subject_id')
                ->groupBy(fn($a) => (string) $a->exam_subject_id)
                ->all(),
        ];
    }

    private function subjectDocuments(ExamGroup $examGroup): Collection
    {
        $subjectIds = $examGroup->members
            ->flatMap->memberSubjects
            ->pluck('exam_subject_id')
            ->unique();

        return Document::with('documentType')
            ->whereIn('exam_subject_id', $subjectIds)
            ->whereHas('documentType', fn($q) => $q->where('code', 'subject_pdf'))
            ->get()
            ->groupBy('exam_subject_id');
    }
}
