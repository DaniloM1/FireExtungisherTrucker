<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Management') }}
            </h2>

        </div>
    </x-slot>

    <!-- Success and Error Messages -->
    <div class="max-w-7xl mx-auto mt-4">
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

    <!-- User List -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <!-- Primer: koristimo bg-gray-800 da prikažemo tamnu pozadinu u light modu, a dark:bg-gray-800 za dark -->
            <div class="bg-gray-100 dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header with Title and Add Button -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('User List') }}</h3>
                        <a href="{{ route('users.create') }}"
                           class= hover:underline">
                            {{ __('+ Add User') }}
                        </a>
                    </div>

                    <!-- Responsive Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('#') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Email') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Roles') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Permissions') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach ($user->roles as $role)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ __($role->name) }}
                                                </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @foreach ($user->getAllPermissions() as $permission)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    {{ __($permission->name) }}
                                                </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900 mr-2">
                                            {{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              class="inline"
                                              onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                        {{ __('No users found.') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <!-- Mobile View -->
                        <div class="block md:hidden">
                            @forelse ($users as $user)
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                    <div class="text-lg font-semibold">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $user->email }}</div>
                                    <div class="mt-2">
                                        <span class="font-semibold">{{ __('Roles:') }}</span>
                                        @foreach ($user->roles as $role)
                                            <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-800">
                                                {{ __($role->name) }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="mt-2">
                                        <span class="font-semibold">{{ __('Permissions:') }}</span>
                                        @foreach ($user->getAllPermissions() as $permission)
                                            <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-800">
                                                {{ __($permission->name) }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <div class="mt-4 flex gap-2">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="text-indigo-600 hover:text-indigo-900">
                                            {{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-gray-300">
                                    {{ __('No users found.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
