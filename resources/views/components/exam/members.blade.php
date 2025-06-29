@props([
    'members' => [],
    'isAdmin' => false,
    'currentUserId' => null,
    'examGroup' => null,
])

@php
    // Ako nije admin, prikazi samo samog korisnika
    $filteredMembers = $isAdmin
        ? $members
        : collect($members)->filter(fn($m) => $m->user_id == $currentUserId)->values();
@endphp
<div class="block lg:hidden px-4 space-y-4 py-4">
    @foreach($filteredMembers as $member)
        <div class="bg-white dark:bg-gray-800 border rounded-xl shadow p-4">
            <div class="font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $member->user->name ?? '-' }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-300">Email: {{ $member->user->email ?? '-' }}</div>
            <div class="text-sm text-gray-600 dark:text-gray-300">
                Kompanija:
                @if($member->user->company)
                    <div class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $member->user->company->name }}</div>
                    <div class="text-xs text-gray-400">PIB: {{ $member->user->company->pib }}</div>
                @else
                    <div class="text-xs text-gray-400">Nema</div>
                @endif
            </div>
            <div class="text-sm mt-2">
                <span class="font-semibold text-gray-700 dark:text-gray-200">Status:</span>
                @if($member->status == 'passed')
                    <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded text-xs">Položio</span>
                @elseif($member->status == 'failed')
                    <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-2 py-1 rounded text-xs">Nije položio</span>
                @else
                    <span class="bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 px-2 py-1 rounded text-xs">Aktivan</span>
                @endif
            </div>

            <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                <div class="font-semibold mb-1">Dokumenta:</div>
                <div class="flex flex-col gap-1 max-h-32 overflow-y-auto pr-2">
                    @foreach($member->required_docs as $docType)
                        @php
                            $userDoc = $member->user_exam_documents->get($docType->id);
                            $companyDoc = $member->company_exam_documents?->get($docType->id);
                            $hasDoc = $userDoc || $companyDoc;
                            $displayName = strlen($docType->name) > 28 ? Str::limit($docType->name, 28) . '…' : $docType->name;
                        @endphp
                        <div class="flex items-center gap-2 px-2 py-1 rounded-lg text-xs
                            @if($hasDoc) bg-green-50 dark:bg-green-900
                            @else bg-gray-100 dark:bg-gray-800 @endif">
                            @if($userDoc || $companyDoc)
                                <svg class="h-4 w-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <a class="text-blue-600 dark:text-blue-300 underline truncate max-w-[10rem]"
                                   href="{{ asset('storage/'.($userDoc?->file_path ?? $companyDoc?->file_path)) }}"
                                   target="_blank"
                                   title="{{ $docType->name }}">
                                    {{ $displayName }}
                                </a>
                                <span class="ml-1 text-gray-400">
                                    ({{ $userDoc ? 'Korisnik' : 'Firma' }})
                                </span>
                            @else
                                <span class="text-gray-600 dark:text-gray-300">{{ $displayName }}</span>
                                <span class="ml-1 text-red-500">(nedostaje)</span>
                                @if($isAdmin || $currentUserId == $member->user_id)
                                    <a href="#"
                                       @click.prevent="
                                           showModal = true;
                                           modalUserId = '{{ $member->user_id }}';
                                           modalDocTypeId = '{{ $docType->id }}';
                                           modalDocTypeName = '{{ addslashes($docType->name) }}';
                                           modalExamGroupId = '{{ $examGroup->id }}';
                                           docName = '{{addslashes($docType->name)}}';
                                           modalAction = '{{ route('documents.store') }}';
                                       "
                                       class="ml-2 px-2 py-0.5 bg-yellow-200 dark:bg-yellow-700 rounded text-yellow-800 dark:text-yellow-200 font-semibold">
                                        Dodaj
                                    </a>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>

<div x-data="{ showModal: false, modalUserId: null, modalDocTypeId: null, modalDocTypeName: '', modalExamGroupId: null, modalAction: '', modalDocTypeName: '' }"
     class="rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-sm">

    <div class="p-4 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            @if($isAdmin)
                Učesnici grupe
            @else
                Vaši podaci za ovu grupu
            @endif
        </h3>
        @if($isAdmin)
            <a href="#" class="bg-blue-600 text-white px-3 py-1 rounded-xl hover:bg-blue-700 text-sm shadow">
                + Dodaj učesnika
            </a>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-[15px]">
            <thead>
            <tr>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300 whitespace-nowrap">Ime</th>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300 whitespace-nowrap">E-mail</th>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300 whitespace-nowrap">Kompanija</th>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300 whitespace-nowrap">Status</th>
                <th class="px-4 py-2 text-gray-600 dark:text-gray-300 w-72">Dokumenta</th>
            </tr>
            </thead>
            <tbody>
            @forelse($filteredMembers as $member)
                <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <td class="px-4 py-2 text-gray-900 dark:text-gray-100 font-medium whitespace-nowrap">
                        {{ $member->user->name ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                        {{ $member->user->email ?? '-' }}
                    </td>
                    <td class="px-4 py-2 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                        @if($member->user->company)
                            <div class="flex flex-col">
                                <span class="font-semibold">{{ $member->user->company->name }}</span>
                                <span class="text-xs text-gray-400">PIB: {{ $member->user->company->pib }}</span>
                            </div>
                        @else
                            <span class="text-xs text-gray-400">Nema</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @if($member->status == 'passed')
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded">Položio</span>
                        @elseif($member->status == 'failed')
                            <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-2 py-1 rounded">Nije položio</span>
                        @else
                            <span class="bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 px-2 py-1 rounded">Aktivan</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 align-top">
                        <div class="flex flex-col gap-2 max-h-36 overflow-y-auto pr-2">
                            @foreach($member->required_docs as $docType)
                                @php
                                    $userDoc = $member->user_exam_documents->get($docType->id);
                                    $companyDoc = $member->company_exam_documents ? $member->company_exam_documents->get($docType->id) : null;
                                    $hasDoc = $userDoc || $companyDoc;
                                    // Tooltip za dugačak naziv
                                    $displayName = strlen($docType->name) > 28 ? Str::limit($docType->name, 28) . '…' : $docType->name;
                                @endphp
                                <div class="flex items-center gap-2 px-2 py-1 rounded-lg
                                    @if($hasDoc)
                                        bg-green-50 dark:bg-green-900
                                    @else
                                        bg-gray-100 dark:bg-gray-800
                                    @endif
                                ">
                                    @if($userDoc)
                                        <svg class="h-4 w-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <a class="text-blue-600 dark:text-blue-300 underline font-medium truncate max-w-[11rem]"
                                           href="{{ asset('storage/'.$userDoc->file_path) }}"
                                           target="_blank"
                                           title="{{ $docType->name }}">
                                            {{ $displayName }}
                                        </a>
                                        <span class="ml-1 text-xs text-gray-400">(Korisnik)</span>
                                    @elseif($companyDoc)
                                        <svg class="h-4 w-4 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <a class="text-blue-600 dark:text-blue-300 underline font-medium truncate max-w-[11rem]"
                                           href="{{ asset('storage/'.$companyDoc->file_path) }}"
                                           target="_blank"
                                           title="{{ $docType->name }}">
                                            {{ $displayName }}
                                        </a>
                                        <span class="ml-1 text-xs text-gray-400">(Firma)</span>
                                    @else
                                        <svg class="h-4 w-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636L5.636 18.364M6 6h.01M6 18h.01M18 6h.01M18 18h.01"/>
                                        </svg>
                                        <span class="text-gray-700 dark:text-gray-300 font-medium truncate max-w-[11rem]"
                                              title="{{ $docType->name }}">
                                            {{ $displayName }}
                                        </span>
                                        <span class="ml-1 text-xs text-red-400 font-semibold">(nedostaje)</span>
                                        @if($isAdmin || $currentUserId == $member->user_id)
                                            <a href="#"
                                               @click.prevent="
                                                   showModal = true;
                                                   modalUserId = '{{ $member->user_id }}';
                                                   modalDocTypeId = '{{ $docType->id }}';
                                                   modalDocTypeName = '{{ addslashes($docType->name) }}';
                                                   modalExamGroupId = '{{ $examGroup->id }}';
                                                   modalAction = '{{ route('documents.store') }}'
                                               "
                                               class="ml-2 px-2 py-0.5 bg-yellow-200 dark:bg-yellow-700 rounded text-xs text-yellow-800 dark:text-yellow-200 font-semibold hover:bg-yellow-300">
                                                Dodaj
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-10 text-center text-gray-400 dark:text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-lg font-medium">Nema podataka</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal za upload dokumenta -->
    <div
        x-show="showModal"
        x-cloak
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 w-full max-w-md relative">
            <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 dark:hover:text-gray-300 text-2xl leading-none">&times;</button>
            <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-gray-100">Dodaj dokument</h3>
            <form :action="modalAction" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" :value="modalUserId">
                <input type="hidden" name="document_type_id" :value="modalDocTypeId">
                <input type="hidden" name="exam_group_id" :value="modalExamGroupId">
                <input type="hidden" name="name" :value="modalDocTypeName">
                <label class="block mb-2 text-sm font-semibold text-gray-800 dark:text-gray-100">Tip dokumenta</label>
                <div class="mb-4 text-gray-800 dark:text-gray-100" x-text="modalDocTypeName"></div>

                <input type="file" name="file" required
                       class="block w-full border rounded px-2 py-1 mb-4 dark:bg-gray-800 dark:border-gray-700"/>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Sačuvaj
                </button>
            </form>
        </div>
    </div>
</div>
