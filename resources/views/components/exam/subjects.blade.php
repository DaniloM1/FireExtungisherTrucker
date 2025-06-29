@props([
    'subjects' => collect(),
    'members' => collect(),
    'myMembership' => null,
    'isAdmin' => false,
    'examGroupId' => null,
    'subjectAnnouncements' => collect(), // [subject_id => Collection]
])
@php
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
                    $userSubjectStatus = $myMembership
                        ? optional($myMembership->memberSubjects->firstWhere('exam_subject_id', $subject->id))->status
                        : null;
                @endphp
                <li>
                    <button type="button"
                            @click="showDetails('{{ $subject->id }}')"
                            :class="selected == '{{ $subject->id }}' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100'"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl transition font-medium text-left hover:bg-blue-500 hover:text-white cursor-pointer focus:outline-none"
                    >
                        <span>
                            @if($userSubjectStatus === 'passed')
                                <svg class="h-4 w-4 text-green-500 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            @elseif($userSubjectStatus === 'unlocked')
                                <svg class="h-4 w-4 text-blue-500 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="6" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                            @elseif($userSubjectStatus === 'locked')
                                <svg class="h-4 w-4 text-red-400 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            @else
                                <svg class="h-4 w-4 text-gray-400 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" /></svg>
                            @endif
                        </span>
                        <span class="truncate">{{ $subject->name }}</span>
                    </button>
                </li>
            @endforeach
        </ul>
    </aside>

    {{-- MAIN: DETALJI PREDMETA --}}
    <section class="flex-1 bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 min-h-[300px]">
        @foreach($subjects as $subject)
            <div x-show="selected == '{{ $subject->id }}'" x-transition>
                <div class="mb-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $subject->name }}</h4>
                            @php
                                $userSubjectStatus = $myMembership
                                    ? optional($myMembership->memberSubjects->firstWhere('exam_subject_id', $subject->id))->status
                                    : null;
                            @endphp
                            @if($userSubjectStatus === 'passed')
                                <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-0.5 rounded text-xs">Položen</span>
                            @elseif($userSubjectStatus === 'failed')
                                <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-2 py-0.5 rounded text-xs">Nije položen</span>
                            @elseif($userSubjectStatus === 'unlocked')
                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-0.5 rounded text-xs">Otključan</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 px-2 py-0.5 rounded text-xs">Zaključan</span>
                            @endif
                            @if($isAdmin && $userSubjectStatus === 'locked')
                                <form method="POST" action="{{ route('exam-groups.subjects.unlock', [$examGroupId, $subject->id]) }}" class="inline ml-2">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1 rounded-xl bg-blue-500 text-white text-xs font-semibold hover:bg-blue-700 transition"
                                            onclick="return confirm('Otključati predmet \"{{ $subject->name }}\"?')"
                                    >
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                    </svg>
                                    Otključaj
                                    </button>
                                </form>
                            @endif
                            @if($isAdmin)
                                <button @click="focusSubject('{{ $subject->id }}')"
                                        class="mb-4 inline-flex items-center px-3 py-1.5 rounded-xl bg-yellow-500 text-white text-sm font-semibold hover:bg-yellow-600 transition"
                                        type="button">
                                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Dodaj obaveštenje
                                </button>
                            @endif
                        </div>
                        <div class="text-gray-500 dark:text-gray-400 mb-2 text-sm">{{ $subject->description ?? '' }}</div>
                    </div>
                    @if($isAdmin)
                        <div>
                            <a href="{{ route('exam-groups.materials', [$examGroupId, $subject]) }}"
                               class="inline-flex items-center px-3 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v3a1 1 0 102 0v-3zm2-3a1 1 0 011 1v5a1 1 0 11-2 0v-5a1 1 0 011-1zm4-1a1 1 0 10-2 0v7a1 1 0 102 0V8z" clip-rule="evenodd" /></svg>
                                Materijali i predavanja
                            </a>
                        </div>
                    @endif
                </div>
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

                {{-- MATERIJALI, PREDAVANJA, DATUMI --}}
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
                <div>
                    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">Materijali</h5>
                    @if(isset($subject->materials) && count($subject->materials))
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($subject->materials as $material)
                                <li class="py-2 flex items-center gap-2">
                                    <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7v10M17 7v10M7 7h10M7 17h10" /></svg>
                                    <a href="{{ asset('storage/'.$material['file_path']) }}" class="text-blue-600 dark:text-blue-300 underline" target="_blank">{{ $material['name'] ?? 'Materijal' }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-gray-400 text-sm">Nema materijala.</div>
                    @endif
                </div>
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
