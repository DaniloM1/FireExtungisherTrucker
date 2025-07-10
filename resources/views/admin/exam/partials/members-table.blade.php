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

<div
    x-data="membersPanel()"
    x-init="
        init();
        @if(!$isAdmin && $filteredMembers->count() === 1)
            openRow = '{{ $filteredMembers->first()->user_id }}';
        @endif
    "
    class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 shadow-sm"
>
    <!-- Toolbar -->
    <div class="p-4 flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
        <input x-model="query" type="search" placeholder="Pretraži članove…" autocomplete="off"
               class="w-full sm:max-w-xs rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 text-sm px-3 py-2" />
        <span class="text-sm text-gray-500 dark:text-gray-400 select-none">
            Prikaženo <span x-text="shown"></span>/<span x-text="total"></span>
        </span>
    </div>

    <!-- Scrollable list -->
    <ul class="divide-y divide-gray-200 dark:divide-gray-700 max-h-[70vh] overflow-y-auto" x-ref="list">
        @foreach($filteredMembers as $index => $member)
            @php
                $search = strtolower(
                    trim(
                        ($member->user->name ?? '') . ' ' .
                        ($member->user->email ?? '') . ' ' .
                        ($member->user->company->name ?? '')
                    )
                );
            @endphp
            <li
                x-data="{ search: '{{ addslashes($search) }}', idx: {{ $index }} }"
                x-show="matches(search) && idx < limit"
                class="bg-white dark:bg-gray-900 hover:bg-blue-50 dark:hover:bg-blue-800/60 transition"
            >
                <!-- Row header -->
                <button @click="toggle('{{ $member->user_id }}')"
                        class="w-full p-4 flex items-start justify-between text-left gap-4">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $member->user->name ?? '-' }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $member->user->email ?? '-' }}</p>
                        @if($member->user->company)
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                {{ $member->user->company->name }}<span class="ml-1 text-[10px]">(PIB {{ $member->user->company->pib }})</span>
                            </p>
                        @endif
                    </div>
                    <!-- Status badge + chevron -->
                    <div class="flex-shrink-0 flex items-center gap-3">
                        @php
                            $color = match($member->status) {
                                'passed' => 'green',
                                'failed' => 'red',
                                default => 'gray',
                            };
                            $statusLabel = match($member->status) {
                                'passed' => 'Položio',
                                'failed' => 'Nije položio',
                                default => 'Aktivan',
                            };
                        @endphp
                        <span class="inline-block rounded px-2 py-1 text-xs bg-{{ $color }}-100 dark:bg-{{ $color }}-900 text-{{ $color }}-800 dark:text-{{ $color }}-200">
                            {{ $statusLabel }}
                        </span>
                        <svg :class="openRow === '{{ $member->user_id }}' ? 'rotate-90' : ''" class="w-4 h-4 text-gray-500 dark:text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </button>

                <!-- Expanded details -->
                <div x-show="openRow === '{{ $member->user_id }}'" x-transition>
                    <div class="border-t border-gray-200 dark:border-gray-700 px-6 py-4 space-y-2 bg-gray-50 dark:bg-gray-900/40">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Dokumenta</h4>
                        @if(!empty($member->required_docs))
                            <div class="grid md:grid-cols-2 gap-3">
                                @foreach($member->required_docs as $docType)
                                    @php
                                        $userDoc    = $member->user_exam_documents->get($docType->id);
                                        $companyDoc = $member->company_exam_documents?->get($docType->id);
                                        $hasDoc     = $userDoc || $companyDoc;
                                    @endphp
                                    <div class="flex items-center gap-2 px-2 py-1 rounded-lg {{ $hasDoc ? 'bg-green-50 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-800' }}">
                                        <span class="font-medium text-gray-800 dark:text-gray-100 truncate">{{ $docType->name }}</span>
                                        @if($userDoc)
                                            <a class="text-blue-600 dark:text-blue-400 underline ml-2"
                                               href="{{ route('private.documents.show', basename($userDoc->file_path)) }}" target="_blank">(Korisnik)</a>
                                        @elseif($companyDoc)
                                            <a class="text-blue-600 dark:text-blue-400 underline ml-2"
                                               href="{{ route('private.documents.show', basename($companyDoc->file_path)) }}" target="_blank">(Firma)</a>
                                        @else

                                        <span class="text-xs text-red-500 ml-2 font-semibold">nedostaje</span>
                                            @if($isAdmin)
                                                <button @click.prevent="openDocumentModal('{{ $member->user_id }}', '{{ $docType->id }}', '{{ addslashes($docType->name) }}', '{{ $examGroup->id }}')"
                                                        class="ml-1 px-2 py-0.5 bg-yellow-200 dark:bg-yellow-700 text-yellow-800 dark:text-yellow-200 text-xs rounded">
                                                    +
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Nema definisanih dokumenata.</p>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

    <!-- Load more button -->
    <button x-show="hasMore" @click="loadMore" class="w-full py-3 bg-gray-100 dark:bg-gray-800 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
        Prikaži još …
    </button>

    <!-- Modal for upload -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 w-full max-w-md relative">
            <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 text-2xl leading-none">&times;</button>
            <h3 class="text-lg font-bold mb-3 text-gray-900 dark:text-gray-100">Dodaj dokument</h3>
            <form :action="modalAction" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id"        :value="modalUserId">
                <input type="hidden" name="document_type_id" :value="modalDocTypeId">
                <input type="hidden" name="exam_group_id"   :value="modalExamGroupId">
                <input type="hidden" name="name"            :value="modalDocTypeName">
                <div class="mb-4">
                    <label class="block mb-1 text-sm font-semibold text-gray-800 dark:text-gray-100">Tip dokumenta</label>
                    <div class="text-gray-800 dark:text-gray-100" x-text="modalDocTypeName"></div>
                </div>
                <input type="file" name="file" required
                       class="block w-full border rounded px-2 py-1 mb-4 dark:bg-gray-800 dark:border-gray-700 text-gray-600 dark:text-gray-100" />
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">Sačuvaj</button>
            </form>
        </div>
    </div>
</div>

<script>
    function membersPanel() {
        return {
            query: '',
            limit: 50,
            increment: 50,
            get hasMore() { return this.limit < this.total; },
            loadMore() { this.limit += this.increment; this.refreshCount(); },

            openRow: null,
            toggle(id) { this.openRow = this.openRow === id ? null : id; },

            showModal: false,
            modalUserId: null,
            modalDocTypeId: null,
            modalDocTypeName: '',
            modalExamGroupId: null,
            modalAction: '{{ route('documents.store') }}',
            openDocumentModal(u, d, n, g) {
                Object.assign(this, { modalUserId: u, modalDocTypeId: d, modalDocTypeName: n, modalExamGroupId: g, showModal: true });
            },

            total: {{ $filteredMembers->count() }},
            shown: 0,
            matches(text) {
                const q = this.query.toLowerCase();
                return !q || text.includes(q);
            },
            init() {
                this.refreshCount();
                this.$watch('query', () => this.refreshCount());
                this.$watch('limit', () => this.refreshCount());
            },
            refreshCount() {
                this.shown = [...this.$refs.list.children].filter(li => !li.hidden).length;
            }
        };
    }
</script>
