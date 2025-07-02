<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 leading-tight">Nova grupa</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('exam-groups.store') }}" method="POST" x-data="groupForm()" @submit.prevent="submit">
                @csrf

                <!-- Naziv grupe -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naziv grupe</label>
                    <input type="text" name="name" id="name" x-model="form.name" required
                           class="mt-1 block w-full rounded-md dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 sm:text-sm">
                </div>

                <!-- Datum početka -->
                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Datum početka</label>
                    <input type="date" name="start_date" id="start_date" x-model="form.start_date"
                           class="mt-1 block w-full rounded-md dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 sm:text-sm">
                </div>

                <!-- Datum ispita -->
                <div class="mb-6">
                    <label for="exam_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Datum ispita</label>
                    <input type="date" name="exam_date" id="exam_date" x-model="form.exam_date"
                           class="mt-1 block w-full rounded-md dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 sm:text-sm">
                </div>

                <!-- Dodavanje članova -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dodaj članove</label>
                    <input type="text" placeholder="Pretraga po imenu, emailu ili kompaniji..." x-model="search"
                           @input.debounce.500ms="fetchUsers"
                           class="w-full mb-3 rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 sm:text-sm">

                    <template x-if="filteredUsers.length === 0 && search">
                        <div class="text-sm text-gray-400">Nema rezultata.</div>
                    </template>

                    <div class="grid sm:grid-cols-2 gap-2 max-h-64 overflow-y-auto">
                        <template x-for="user in filteredUsers" :key="user.id">
                            <button type="button" @click="addMember(user)"
                                    class="bg-gray-100 dark:bg-gray-700 text-left rounded-lg p-2 text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                <div class="font-semibold text-gray-800 dark:text-gray-200" x-text="user.name"></div>
                                <div class="text-gray-500 dark:text-gray-400 text-xs" x-text="user.email"></div>
                                <div class="text-gray-500 dark:text-gray-400 text-xs" x-show="user.company" x-text="'Kompanija: ' + user.company?.name"></div>
                            </button>
                        </template>
                    </div>

                    <template x-if="form.members.length">
                        <div class="mt-4">
                            <h4 class="text-sm font-semibold mb-2 text-gray-800 dark:text-gray-200">Izabrani članovi:</h4>
                            <ul class="space-y-1">
                                <template x-for="(user, index) in form.members.slice().reverse()" :key="user.id">
                                    <li class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 rounded px-3 py-1">
                                        <span class="text-sm text-gray-800 dark:text-gray-200">
                                            <span x-text="user.name"></span>
                                            (<span x-text="user.email"></span>)
                                            <template x-if="user.company">
                                                <span class="ml-2 text-xs text-gray-400" x-text="'[' + user.company.name + ']'"></span>
                                            </template>
                                        </span>
                                        <button type="button" @click="removeMember(index)"
                                                class="text-red-600 hover:text-red-800 text-xs">Ukloni</button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </template>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('exam-groups.index') }}"
                       class="mr-4 text-sm text-gray-600 dark:text-gray-400 hover:underline">Otkaži</a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150 shadow-md">
                        Sačuvaj grupu
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function groupForm() {
            return {
                form: {
                    name: '',
                    start_date: '',
                    exam_date: '',
                    members: [],
                },
                search: '',
                filteredUsers: [],
                async fetchUsers() {
                    if (this.search.length < 2) return;
                    let res = await fetch(`/exam-groups/user-search?q=${encodeURIComponent(this.search)}`);
                    this.filteredUsers = await res.json();
                },
                addMember(user) {
                    if (!this.form.members.find(u => u.id === user.id)) {
                        this.form.members.push(user);
                    }
                },
                removeMember(index) {
                    this.form.members.splice(this.form.members.length - 1 - index, 1); // reversed
                },
                async submit() {
                    const payload = {
                        name: this.form.name,
                        start_date: this.form.start_date,
                        exam_date: this.form.exam_date,
                        members: this.form.members.map(u => u.id)
                    };

                    const res = await fetch(`{{ route('exam-groups.store') }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    if (res.ok) {
                        window.location.href = `{{ route('exam.index') }}`;
                    } else {
                        alert('Greška pri čuvanju.');
                    }
                }
            }
        }
    </script>
</x-app-layout>
