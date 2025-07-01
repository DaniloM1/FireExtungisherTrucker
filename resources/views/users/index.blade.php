<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Korisnici') }}
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
    <div class="max-w-7xl mx-auto ">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
            <form action="{{ route('users.index') }}" method="GET" class="flex mb-6">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Pretraga po imenu, e-mailu ili kompaniji"
                    class="flex-grow rounded-l-md border border-gray-300 dark:border-gray-600 p-2 focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white"
                />
                <button type="submit" class="rounded-none bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 focus:outline-none focus:ring">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l5.386 5.387a1 1 0 01-1.414 1.414l-5.386-5.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd" />
                    </svg>
                </button>
                <a href="{{ route('users.index') }}"
                   class="rounded-r-md bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-100 px-4 py-2 shadow-sm hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-red-400 transition flex items-center"
                   title="Poništi filtere">
                    <i class="fa-solid fa-filter-circle-xmark mr-2"></i>
                </a>
            </form>
        </div>
    </div>
    <!-- User List -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto">

            <!-- Primer: koristimo bg-gray-800 da prikažemo tamnu pozadinu u light modu, a dark:bg-gray-800 za dark -->
            <div class="bg-gray-100 dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header with Title and Add Button -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Lista Korisnika') }}</h3>

                        <a href="{{ route('users.create') }}"
                           class= hover:underline">
                            {{ __('+ Dodaj Korisnika')}}
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
                                    {{ __('Ime') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Email') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Rola') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Kompanija') }}
                                </th>

{{--                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">--}}
{{--                                    {{ __('Permissions') }}--}}
{{--                                </th>--}}
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Akcije') }}
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
                                        {{ $user->company->name ?? '' }}
                                    </td>
{{--                                    <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                                        @foreach ($user->getAllPermissions() as $permission)--}}
{{--                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">--}}
{{--                                                    {{ __($permission->name) }}--}}
{{--                                                </span>--}}
{{--                                        @endforeach--}}
{{--                                    </td>--}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="text-gray-400 mr-12">
                                            <i class="fa fa-edit"></i>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              class="inline"
                                              onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-gray-400 hover:text-red-600 ml-10">
                                                <i class="fa fa-trash"></i>
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
                                        <span class="font-semibold">Uloge:</span>
                                        @foreach ($user->roles as $role)
                                            <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-800">
                        {{ __($role->name) }}
                    </span>
                                        @endforeach
                                    </div>
                                    <div class="mt-2">
                                        <span class="font-semibold">Kompanija:</span>
                                        @if($user->company)
                                            <span class="text-xs px-2 py-1 rounded bg-gray-200 text-gray-800">
                        {{ $user->company->name }}
                    </span>
                                        @else
                                            <span class="text-xs px-2 py-1 rounded bg-gray-200 text-gray-500">
                        (nema kompaniju)
                    </span>
                                        @endif
                                    </div>
                                    <div class="mt-4 flex gap-2">
                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="text-gray-600 hover:text-indigo-900">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Da li ste sigurni?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-gray-600 hover:text-red-900">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-gray-300">
                                    Nema korisnika.
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
