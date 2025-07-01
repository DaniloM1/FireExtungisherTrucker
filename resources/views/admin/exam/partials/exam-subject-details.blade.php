@php
    // Status badge i ikonice za admina
    $statuses = $members->map(function($member) use ($subject) {
        return optional($member->memberSubjects->firstWhere('exam_subject_id', $subject->id))->status;
    })->filter()->values();
    if ($statuses->contains('locked')) {
        $badgeText = 'Zaključan';
        $badgeClass = 'bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
        $svg = '<svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>';
        $showUnlock = true;
    } elseif ($statuses->contains('unlocked')) {
        $badgeText = 'Otključan';
        $badgeClass = 'bg-blue-200 dark:bg-blue-900 text-blue-900 dark:text-blue-200';
        $svg = '<svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="2" fill="none"/></svg>';
        $showUnlock = false;
    } elseif ($statuses->contains('failed')) {
        $badgeText = 'Nije položen';
        $badgeClass = 'bg-red-200 dark:bg-red-900 text-red-900 dark:text-red-200';
        $svg = '<svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
        $showUnlock = false;
    } elseif ($statuses->every(fn($s) => $s === 'passed') && $statuses->count()) {
        $badgeText = 'Položen';
        $badgeClass = 'bg-green-200 dark:bg-green-900 text-green-900 dark:text-green-200';
        $svg = '<svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
        $showUnlock = false;
    } else {
        $badgeText = '-';
        $badgeClass = 'bg-gray-100 text-gray-500';
        $svg = '';
        $showUnlock = false;
    }
@endphp

<div class="mb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
    <div>
        <div class="flex items-center gap-2">
            <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $subject->name }}</h4>

            {{-- ADMIN STATUS BADGE --}}
            @if($isAdmin)
                <span class="flex items-center gap-1 text-xs px-2 py-0.5 rounded {{ $badgeClass }}">
                    {!! $svg !!} {{ $badgeText }}
                </span>
                @if($showUnlock)
                    <form method="POST" action="{{ route('exam-groups.subjects.unlock', [$examGroupId, $subject->id]) }}" class="inline ml-2">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-3 py-1 rounded-xl bg-blue-500 text-white text-xs font-semibold hover:bg-blue-700 transition"
                                onclick="return confirm('Otključati predmet &quot;{{ $subject->name }}&quot; svim članovima?')"
                        >
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                            </svg>
                            Otključaj za sve
                        </button>
                    </form>
                @endif
            @else
                {{-- STUDENTU badge status --}}
                @php
                    $mySubject = $myMembership ? $myMembership->memberSubjects->firstWhere('exam_subject_id', $subject->id) : null;
                    $myStatus = $mySubject ? $mySubject->status : null;
                    $stClass = '';
                    $stText = '';
                    if ($myStatus === 'passed') {
                        $stClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                        $stText = 'Položen';
                    } elseif ($myStatus === 'failed') {
                        $stClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                        $stText = 'Nije položen';
                    } elseif ($myStatus === 'unlocked') {
                        $stClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                        $stText = 'Otključan';
                    } else {
                        $stClass = 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                        $stText = 'Zaključan';
                    }
                @endphp
                <span class="flex items-center gap-1 text-xs px-2 py-0.5 rounded {{ $stClass }}">
                    {{ $stText }}
                </span>
            @endif
        </div>
        <div class="text-gray-500 dark:text-gray-400 mb-2 text-sm">{{ $subject->description ?? '' }}</div>
    </div>
    @if($isAdmin)
        <div class="flex flex-col gap-2 items-end">
{{--            <a href="{{ route('exam-groups.materials', [$examGroupId, $subject]) }}"--}}
{{--               class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd" /></svg>--}}
{{--                Materijali i predavanja--}}
{{--            </a>--}}
            <button @click="focusSubject('{{ $subject->id }}')"
                    class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-800 transition"
                    type="button">
                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Dodaj obaveštenje
            </button>
        </div>
    @endif
</div>

{{-- Ostatak detalja (obaveštenja, predavanja, materijali) --}}
@php
    $announcements = collect();
    foreach ([$subject->id, (string)$subject->id, (int)$subject->id] as $k) {
        if (isset($subjectAnnouncements[$k])) {
            $announcements = $subjectAnnouncements[$k];
            break;
        }
    }
@endphp

@if($announcements->count())
    <div class="mb-6 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/70 dark:bg-gray-900/60 shadow p-5 flex flex-col gap-2">
        <div class="flex items-center gap-2 mb-2">
            <svg class="h-5 w-5 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1 4h.01M12 6v2m0 4v2m8-2a8 8 0 11-16 0 8 8 0 0116 0z"/>
            </svg>
            <h5 class="text-base font-bold text-gray-900 dark:text-gray-100">
                Obaveštenje za predmet
            </h5>
        </div>
        <ul class="space-y-2">
            @foreach($announcements as $a)
                <li>
                    <div class="font-semibold text-gray-900 dark:text-gray-100">{{ $a->title }}</div>
                    <div class="text-sm text-gray-700 dark:text-gray-200 leading-relaxed">
                        {!! \Illuminate\Support\Str::of($a->body)->replaceMatches('/https?:\/\/[^\s]+/', function ($match) {
                            $url = $match[0];
                            return '<a href="'.$url.'" target="_blank" class="text-blue-600 underline">'.$url.'</a>';
                        }) !!}
                    </div>
                    @if($a->created_at)
                        <div class="text-xs text-gray-400 mt-1">
                            Objavljeno: {{ \Carbon\Carbon::parse($a->created_at)->format('d.m.Y H:i') }}
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Predavanja --}}
<div class="mb-4">
    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">Predavanja</h5>
    @if(isset($subject->lectures) && count($subject->lectures))
        <ul class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($subject->lectures as $lecture)
                <li class="py-2 flex items-center gap-2">
                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $lecture['date'] ?? '' }}</span>
                    @if(!empty($lecture['professor']))
                        <span class="text-sm text-gray-400">({{ $lecture['professor'] }})</span>
                    @endif
                    @if(!empty($lecture['teams_link']))
                        <a href="{{ $lecture['teams_link'] }}" target="_blank" class="text-xs text-blue-600 dark:text-blue-300 underline ml-2">Teams</a>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-gray-400 text-sm">Nema predavanja.</div>
    @endif
</div>

{{-- Materijali --}}
@php
    $subjectDocs = $documentsBySubject[$subject->id] ?? collect();
@endphp

<div>
    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">Materijali</h5>
    @if($subjectDocs->isNotEmpty())
        <ul class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($subjectDocs as $doc)
                <li class="py-2 flex items-center gap-2">
                    <svg class="h-4 w-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M7 7h10M7 11h10M7 15h10M5 5v14h14V5H5z"/>
                    </svg>

                    <a href="{{ Storage::url($doc->file_path) }}" class="text-blue-600 dark:text-blue-300 underline" target="_blank">
                        {{ $doc->name ?? 'Materijal' }}
                    </a>
                    @if($doc->description)
                        <span class="text-sm text-gray-400">– {{ $doc->description }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-gray-400 text-sm">Nema materijala.</div>
    @endif
</div>
