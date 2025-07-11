<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <!-- Poruke o uspehu i greškama -->
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Kontejner sa podrškom za light/dark temu -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('New User Form') }}</h3>
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Name') }}
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name') }}"
                                autocomplete="off"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Email') }}
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                autocomplete="off"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                value="{{ old('email') }}"
                                required

                            >
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Password') }}
                            </label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- Password Confirmation Field -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Confirm Password') }}
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- Company Selection Field with Modal Trigger -->
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Company') }}
                            </label>
                            <div class="flex items-center gap-4 mt-1">
                                <input
                                    type="text"
                                    id="company_name"
                                    name="company_name"
                                    placeholder="{{ __('Optional: Select a Company') }}"
                                    class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 cursor-pointer"
                                    readonly
                                    onclick="openModal()"
                                >
                                <button
                                    type="button"
                                    onclick="openModal()"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    {{ __('Select') }}
                                </button>
                            </div>
                            <input type="hidden" name="company_id" id="company_id">
                        </div>

                        <!-- Company Selection Modal -->
                        <div id="companyModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                            <div class="flex items-center justify-center min-h-screen">
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-md w-full">
                                    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                                        {{ __('Select a Company') }}
                                    </h2>
                                    <input
                                        type="text"
                                        id="companySearch"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                        placeholder="{{ __('Search for a company...') }}"
                                        oninput="filterCompanies()"
                                    >
                                    <ul id="companyList" class="max-h-60 overflow-y-auto mt-2">
                                        @foreach ($companies as $company)
                                            <li
                                                class="cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100"
                                                onclick="selectCompany('{{ $company->id }}', '{{ $company->name }}')"
                                            >
                                                {{ $company->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <button
                                        class="mt-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                        onclick="closeModal()"
                                    >
                                        {{ __('Close') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <script>
                            function openModal() {
                                document.getElementById('companyModal').classList.remove('hidden');
                            }
                            function closeModal() {
                                document.getElementById('companyModal').classList.add('hidden');
                            }
                            function selectCompany(id, name) {
                                document.getElementById('company_id').value = id;
                                document.getElementById('company_name').value = name;
                                closeModal();
                            }
                            function filterCompanies() {
                                const search = document.getElementById('companySearch').value.toLowerCase();
                                const companies = document.getElementById('companyList').children;
                                Array.from(companies).forEach(company => {
                                    company.style.display = company.textContent.toLowerCase().includes(search) ? '' : 'none';
                                });
                            }
                        </script>

                        <!-- Roles Field -->
                        <div class="mb-4">
                            <label for="roles" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Roles') }}
                            </label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach ($roles as $role)
                                    <label class="inline-flex items-center">
                                        <input
                                            type="checkbox"
                                            name="roles[]"
                                            value="{{ $role->name }}"
                                            class="rounded text-blue-500 focus:ring-blue-500"
                                            {{ (is_array(old('roles')) && in_array($role->name, old('roles'))) ? 'checked' : '' }}
                                        >
                                        <span class="ml-2">{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create') }}
                            </button>
                            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
