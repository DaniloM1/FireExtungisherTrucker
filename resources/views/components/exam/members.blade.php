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

<div
    x-data="{
        // Dokument modal
        showModal: false, modalUserId: null, modalDocTypeId: null, modalDocTypeName: '', modalExamGroupId: null, modalAction: '',
        // Dodavanje ucesnika modal
        showAddUser: false, users: [], selectedUser: null, loading: false,
        async openAddMemberModal() {
            this.showAddUser = true;
            this.loading = true;
            let resp = await fetch('{{ route('exam.groups.not-in-group', $examGroup->id) }}');
            this.users = await resp.json();
            this.loading = false;
        },
        async addMember() {
            if (!this.selectedUser) return;
            await fetch('{{ route('exam.groups.add-member', $examGroup->id) }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: this.selectedUser })
            });
            this.showAddUser = false;
            window.location.reload();
        },
        showAddUser: false,
            search: '',
            results: [],
            selectedUser: null,
            loading: false,
            async searchUsers() {
                if(this.search.length < 2) {
                    this.results = [];
                    return;
                }
                this.loading = true;
                let resp = await fetch('{{ route('exam.groups.user-search', $examGroup->id) }}?q=' + encodeURIComponent(this.search));
                this.results = await resp.json();
                this.loading = false;
            },
            async addMember() {
                if (!this.selectedUser) return;
                await fetch('{{ route('exam.groups.add-member', $examGroup->id) }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_id: this.selectedUser })
                });
                this.showAddUser = false;
                window.location.reload();
            }

    }"
    class="rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 shadow-sm"
>
    <div class="p-4 flex items-center justify-between">
        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            @if($isAdmin)
                Učesnici grupe
            @else
                Vaši podaci za ovu grupu
            @endif
        </h3>
        @if($isAdmin)
            <a href="#" @click.prevent="openAddMemberModal()" class="bg-blue-600 text-white px-3 py-1 rounded-xl hover:bg-blue-700 text-sm shadow">
                + Dodaj učesnika
            </a>
        @endif
    </div>
    <div class="space-y-4">

        {{-- Direktno uključujemo moderni prikaz članova --}}
        @include('admin.exam.partials.members-table', [
            'members'       => $members,
            'isAdmin'       => $isAdmin,
            'currentUserId' => $currentUserId,
            'examGroup'     => $examGroup,
        ])

    </div>
    <!-- MODAL: Dodavanje Učesnika -->
    <div x-show="showAddUser" x-cloak class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-6 w-full max-w-md relative border border-gray-200 dark:border-gray-800">
            <button @click="showAddUser = false"
                    class="absolute top-2 right-2 text-gray-400 dark:text-gray-500 text-2xl hover:text-gray-600 dark:hover:text-gray-300 transition">
                &times;
            </button>
            <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Dodaj učesnika u grupu</h3>

            <div>
                <input
                    type="text"
                    x-model="search"
                    @input.debounce.500="searchUsers"
                    placeholder="Pretraži korisnike po imenu ili e-mailu..."
                    class="w-full border border-gray-300 dark:border-gray-700 rounded px-2 py-1 mb-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 transition"
                    autocomplete="off"
                >
                <template x-if="loading">
                    <div class="text-center text-gray-500 dark:text-gray-400 py-2">Učitavanje...</div>
                </template>
                <div x-show="results.length > 0"
                     class="border border-gray-300 dark:border-gray-700 rounded mb-2 max-h-56 overflow-y-auto bg-white dark:bg-gray-800">
                    <template x-for="user in results" :key="user.id">
                        <div
                            class="px-2 py-1 cursor-pointer hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-900 dark:hover:text-blue-200 text-gray-900 dark:text-gray-100 transition"
                            @click="selectedUser = user.id; search = user.name + ' (' + user.email + ')'; results = []"
                            x-text="user.name + ' (' + user.email + ')'"
                        ></div>
                    </template>
                </div>
                <button type="button"
                        @click="addMember"
                        :disabled="!selectedUser"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full disabled:opacity-50 transition">
                    Dodaj
                </button>
            </div>
        </div>
    </div>



    <!-- MODAL: Upload Dokumenta -->

