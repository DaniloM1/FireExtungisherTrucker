<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
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
            <!-- Kontejner prilagođen dark/light temi -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Edit User Form') }}</h3>
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium">
                                {{ __('Name') }}
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium">
                                {{ __('Email') }}
                            </label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                                required
                            >
                        </div>

                        <!-- Password Field (Optional) -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium">
                                {{ __('Password (optional)') }}
                            </label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <!-- Password Confirmation Field (Optional) -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium">
                                {{ __('Confirm Password') }}
                            </label>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <!-- Roles Field -->
                        <div class="mb-4">
                            <label for="roles" class="block text-sm font-medium">
                                {{ __('Roles') }}
                            </label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach ($roles as $role)
                                    <label class="inline-flex items-center">
                                        <input
                                            type="checkbox"
                                            name="roles[]"
                                            value="{{ $role->name }}"
                                            {{ (is_array(old('roles')) && in_array($role->name, old('roles')))
                                                ? 'checked'
                                                : ($user->hasRole($role->name) ? 'checked' : '') }}
                                            class="rounded text-blue-500 focus:ring-blue-500"
                                        >
                                        <span class="ml-2">{{ $role->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Permissions Field -->
                        <div class="mb-4">
                            <label for="permissions" class="block text-sm font-medium">
                                {{ __('Permissions') }}
                            </label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                @foreach ($permissions as $permission)
                                    <label class="inline-flex items-center">
                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            {{ (is_array(old('permissions')) && in_array($permission->name, old('permissions')))
                                                ? 'checked'
                                                : ($user->hasPermissionTo($permission->name) ? 'checked' : '') }}
                                            class="rounded text-green-500 focus:ring-green-500"
                                        >
                                        <span class="ml-2">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Update') }}
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
