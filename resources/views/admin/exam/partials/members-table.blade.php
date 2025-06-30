@props([
    'members' => [],
    'isAdmin' => false,
    'currentUserId' => null,
    'examGroup' => null,
])

@php
    $filteredMembers = $isAdmin
        ? collect($members)
        : collect($members)->filter(fn($m) => $m->user_id == $currentUserId)->values();
@endphp
<div x-data="membersTable()" class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 shadow-sm">
    <table class="w-full text-left text-[15px]">
        <thead>
        <tr>
            <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Ime</th>
            <th class="px-4 py-2 text-gray-600 dark:text-gray-300">E-mail</th>
            <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Kompanija</th>
            <th class="px-4 py-2 text-gray-600 dark:text-gray-300">Status</th>
            <th class="px-4 py-2 text-gray-600 dark:text-gray-300"></th>
        </tr>
        </thead>
        <tbody>
        @forelse($filteredMembers as $member)
            <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-blue-900 transition">
                <td class="px-4 py-2 text-gray-900 dark:text-gray-100 font-medium cursor-pointer"
                    @click="openRow === '{{ $member->user_id }}' ? openRow = null : openRow = '{{ $member->user_id }}'">
                    <span class="flex items-center">
                        <svg :class="openRow === '{{ $member->user_id }}' ? 'rotate-90' : ''" class="w-4 h-4 mr-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        {{ $member->user->name ?? '-' }}
                    </span>
                </td>
                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">
                    {{ $member->user->email ?? '-' }}
                </td>
                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">
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
                <td class="px-4 py-2">
                    <button @click.stop="openRow === '{{ $member->user_id }}' ? openRow = null : openRow = '{{ $member->user_id }}'"
                            class="text-blue-600 hover:text-blue-800 dark:text-blue-300 dark:hover:text-blue-400 font-semibold text-xs">
                        {{ __("Dokumenta") }}
                    </button>
                </td>
            </tr>
            <tr x-show="openRow === '{{ $member->user_id }}'" x-transition>
                <td colspan="5" class="bg-white dark:bg-gray-900 border-t border-b border-gray-200 dark:border-gray-800 px-6 py-4">
                    <div>
                        <h4 class="text-gray-700 dark:text-gray-200 font-semibold mb-1">Dokumenta korisnika</h4>
                        @if(!empty($member->required_docs))
                            <div class="grid md:grid-cols-2 gap-3">
                                @foreach($member->required_docs as $docType)
                                    @php
                                        $userDoc = $member->user_exam_documents->get($docType->id);
                                        $companyDoc = $member->company_exam_documents ? $member->company_exam_documents->get($docType->id) : null;
                                        $hasDoc = $userDoc || $companyDoc;
                                    @endphp
                                    <div class="flex items-center gap-2 px-2 py-1 rounded-lg
                                        @if($hasDoc)
                                            bg-green-50 dark:bg-green-900
                                        @else
                                            bg-gray-100 dark:bg-gray-800
                                        @endif
                                    ">
                                        <span class="font-medium text-gray-800 dark:text-gray-100 truncate">{{ $docType->name }}</span>
                                        @if($userDoc)
                                            <a class="text-blue-600 dark:text-blue-300 underline ml-2"
                                               href="{{ asset('storage/'.$userDoc->file_path) }}" target="_blank">
                                                (Korisnik)
                                            </a>
                                        @elseif($companyDoc)
                                            <a class="text-blue-500 dark:text-blue-200 underline ml-2"
                                               href="{{ asset('storage/'.$companyDoc->file_path) }}" target="_blank">
                                                (Firma)
                                            </a>
                                        @else
                                            <span class="text-xs text-red-400 font-semibold ml-2">(nedostaje)</span>
                                            @if($isAdmin)
                                                <a href="#"
                                                   @click.prevent="openDocumentModal('{{ $member->user_id }}', '{{ $docType->id }}', '{{ addslashes($docType->name) }}', '{{ $examGroup->id }}')"
                                                   class="ml-2 px-2 py-0.5 bg-yellow-200 dark:bg-yellow-700 rounded text-xs text-yellow-800 dark:text-yellow-200 font-semibold hover:bg-yellow-300">
                                                    Dodaj
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-500 dark:text-gray-400 text-sm">Nema definisanih dokumenata za ovog člana.</div>
                        @endif
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
    <!-- MODAL: Upload Dokumenta -->
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
                       class="block w-full border rounded px-2 py-1 mb-4 dark:bg-gray-800 dark:border-gray-700 text-gray-600 dark:text-gray-100"/>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Sačuvaj
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function membersTable() {
        return {
            openRow: null,
            showModal: false,
            modalUserId: null,
            modalDocTypeId: null,
            modalDocTypeName: '',
            modalExamGroupId: null,
            modalAction: '{{ route('documents.store') }}',

            openDocumentModal(userId, docTypeId, docTypeName, examGroupId) {
                this.modalUserId = userId;
                this.modalDocTypeId = docTypeId;
                this.modalDocTypeName = docTypeName;
                this.modalExamGroupId = examGroupId;
                this.showModal = true;
            }
        }
    }
</script>
