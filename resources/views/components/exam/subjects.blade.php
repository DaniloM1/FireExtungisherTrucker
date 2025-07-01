@props([
    'subjects' => collect(),
    'members' => collect(),
    'myMembership' => null,
    'isAdmin' => false,
    'examGroupId' => null,
    'subjectAnnouncements' => collect(),
    'documentsBySubject' => collect(),
])
@php
//dd($documentsBySubject);
    $subjectById = $subjects->keyBy('id');
    $defaultSubject = $subjects->first();
@endphp

<div
    x-data="{
        selected: '{{ $defaultSubject ? $defaultSubject->id : '' }}',
        showAddAnnouncement: false,
        showDetails(id) { this.selected = id },
        focusSubject(id) { this.selected = id; this.showAddAnnouncement = true; }
    }"
    @keydown.escape.window="showAddAnnouncement = false"
    class="flex flex-col sm:flex-row gap-4 mt-6"
>
    {{-- SIDEBAR --}}
    <aside class="sm:w-56 w-full bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-3 flex-shrink-0">
        <h3 class="text-base font-bold mb-3 text-gray-900 dark:text-gray-100">Predmeti</h3>
        <ul class="space-y-1">
            @foreach($subjects as $subject)
                @php
                    if($isAdmin) {
                        // Grupni status kao i do sad
                        $statuses = $members->map(function($member) use ($subject) {
                            return optional($member->memberSubjects->firstWhere('exam_subject_id', $subject->id))->status;
                        })->filter()->values();

                        if ($statuses->contains('locked')) {
                            $badgeText = 'Zaključan';
                            $badgeClass = 'bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                            $svg = '<svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>';
                        } elseif ($statuses->contains('unlocked')) {
                            $badgeText = 'Otključan';
                            $badgeClass = 'bg-blue-200 dark:bg-blue-900 text-blue-900 dark:text-blue-200';
                            $svg = '<svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="2" fill="none"/></svg>';
                        } elseif ($statuses->contains('failed')) {
                            $badgeText = 'Nije položen';
                            $badgeClass = 'bg-red-200 dark:bg-red-900 text-red-900 dark:text-red-200';
                            $svg = '<svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
                        } elseif ($statuses->every(fn($s) => $s === 'passed') && $statuses->count()) {
                            $badgeText = 'Položen';
                            $badgeClass = 'bg-green-200 dark:bg-green-900 text-green-900 dark:text-green-200';
                            $svg = '<svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                        } else {
                            $badgeText = '-';
                            $badgeClass = 'bg-gray-100 text-gray-500';
                            $svg = '';
                        }
                    } else {
                        // Status za trenutnog korisnika
                        $mySubject = $myMembership ? $myMembership->memberSubjects->firstWhere('exam_subject_id', $subject->id) : null;
                        $myStatus = $mySubject ? $mySubject->status : null;
                        if ($myStatus === 'passed') {
                            $badgeText = 'Položen';
                            $badgeClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                            $svg = '<svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                        } elseif ($myStatus === 'failed') {
                            $badgeText = 'Nije položen';
                            $badgeClass = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                            $svg = '<svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
                        } elseif ($myStatus === 'unlocked') {
                            $badgeText = 'Otključan';
                            $badgeClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                            $svg = '<svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="2" fill="none"/></svg>';
                        } elseif ($myStatus === 'locked') {
                            $badgeText = 'Zaključan';
                            $badgeClass = 'bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                            $svg = '<svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>';
                        } elseif ($mySubject) {
                            $badgeText = $myStatus; // fallback
                            $badgeClass = 'bg-gray-100 text-gray-500';
                            $svg = '';
                        } else {
                            // nema ovog predmeta
                            $badgeText = '';
                            $badgeClass = '';
                            $svg = '';
                        }
                    }
                @endphp
                <li>
                    <button type="button"
                            @click="showDetails('{{ $subject->id }}')"
                            :class="selected == '{{ $subject->id }}' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100'"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl transition font-medium text-left hover:bg-blue-500 hover:text-white cursor-pointer focus:outline-none"
                    >
                            {!! $svg !!}
                        <span class="truncate">{{ $subject->name }}</span>
                    </button>
                </li>
            @endforeach
        </ul>
    </aside>

    <section class="flex-1 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 min-h-[300px]">
        @foreach($subjects as $subject)
            <div x-show="selected == '{{ $subject->id }}'" x-transition>
                @php
                    $mySubject = !$isAdmin && $myMembership ? $myMembership->memberSubjects->firstWhere('exam_subject_id', $subject->id) : null;
                    $myStatus = $mySubject ? $mySubject->status : null;
                @endphp

                @if(!$isAdmin)
                    @if(!$mySubject)
                        <div class="flex flex-col items-center justify-center py-10">
                            <svg class="h-14 w-14 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div class="text-lg font-semibold text-gray-500 dark:text-gray-300 mb-2">Predmet nije dodeljen vama</div>
                            <div class="text-gray-400 text-sm">Nemate ovaj predmet u vašem planu.</div>
                        </div>
                    @elseif($myStatus === 'locked')
                        <div class="flex flex-col items-center justify-center py-10">
                            <svg class="h-14 w-14 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <div class="text-lg font-semibold text-gray-500 dark:text-gray-300 mb-2">Predmet je zaključan</div>
                            <div class="text-gray-400 text-sm">Ovaj predmet još nije otključan. Sačekajte da vam profesor omogući pristup.</div>
                        </div>
                    @else
                        @include('admin.exam.partials.exam-subject-details', [
                            'subject' => $subject,
                            'members' => $members,
                            'subjectAnnouncements' => $subjectAnnouncements,
                            'isAdmin' => $isAdmin,
                            'examGroupId' => $examGroupId,
                             'documentsBySubject' => $documentsBySubject, // ← dodaj ovo
                        ])
                    @endif
                @else
                    @include('admin.exam.partials.exam-subject-details', [
                        'subject' => $subject,
                        'members' => $members,
                        'subjectAnnouncements' => $subjectAnnouncements,
                        'isAdmin' => $isAdmin,
                        'examGroupId' => $examGroupId,
                         'documentsBySubject' => $documentsBySubject, // ← dodaj ovo
                    ])
                @endif
            </div>
        @endforeach

        @if($subjects->isEmpty())
            <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg font-medium">Nema predmeta u ovoj grupi</p>
            </div>
        @endif
    </section>

    <!-- MODAL za novo obaveštenje -->
    <div x-show="showAddAnnouncement"
         class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
        <!-- Modal container -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg w-full max-w-lg relative border border-gray-300 dark:border-gray-700">
            <!-- Close button -->
            <button @click="showAddAnnouncement = false"
                    class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl font-bold">
                &times;
            </button>

            <!-- Modal content -->
            <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Novo obaveštenje</h2>

            <form method="POST" action="{{ route('announcements.store', [$examGroupId]) }}">
                @csrf
                <div class="space-y-4">
                    <!-- Subject selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Predmet</label>
                        <select name="exam_subject_id" id="exam_subject_id" required
                                class="mt-1 w-full rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Za celu grupu --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" x-bind:selected="selected == '{{ $subject->id }}'">
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="exam_group_id" value="{{ $examGroupId }}">
                    </div>

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Naslov</label>
                        <input type="text" id="title" name="title" required maxlength="100"
                               class="mt-1 w-full rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Body -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tekst / Link (automatski će biti link)
                        </label>
                        <textarea id="body" name="body" required rows="3"
                                  class="mt-1 w-full rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Optional link -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Link (opciono)
                        </label>
                        <input type="url" id="link" name="link"
                               class="mt-1 w-full rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="https://teams.microsoft.com/...">
                    </div>

                    <!-- Email notification option -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="send_email" id="send_email"
                               class="rounded border-gray-400 dark:bg-gray-800 dark:text-gray-100">
                        <label for="send_email" class="text-sm text-gray-700 dark:text-gray-300">
                            Pošalji kao email svim učesnicima grupe
                        </label>
                    </div>
                </div>

                <!-- Form actions -->
                <div class="flex gap-2 justify-end mt-6">
                    <button type="button" @click="showAddAnnouncement = false"
                            class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                        Otkaži
                    </button>
                    <button type="submit"
                            class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">
                        Pošalji obaveštenje
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
