<x-app-layout>
    <!-- Header -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <!-- Success/Error Poruke (opcionalno) -->
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

    <!-- Pretraga -->

    <div class="max-w-7xl mx-auto ">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-4">
            <form action="{{ route('companies.index') }}" method="GET" class="flex">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="{{ __('Search companies...') }}"
                    class="flex-grow rounded-l-md border border-gray-300 dark:border-gray-600 p-2 focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white"
                />
                <button type="submit" class="rounded-r-md bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 focus:outline-none focus:ring">
                    <!-- Ikonica za pretragu -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l5.386 5.387a1 1 0 01-1.414 1.414l-5.386-5.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>
    </div>


    <!-- Sadržaj stranice -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class=" shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Header sa naslovom i Add Company linkom (kao u lokacijama) -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">{{ __('Company List') }}</h3>
                        <a href="{{ route('companies.create') }}"
                           class= hover:underline">
                            <i class="fas fa-plus"></i> {{ __('Add Company') }}
                        </a>
                    </div>

                    <!-- Responzivni prikaz tablice -->
                    <div class="overflow-x-auto">
                        <!-- Desktop View -->
                        <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Email') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Phone') }}
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($companies as $company)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->contact_email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $company->contact_phone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <!-- View Locations -->
                                            <a href="{{ route('companies.locations', $company->id) }}"
                                               class="text-black dark:text-white hover:underline"
                                               title="{{ __('View Locations') }}">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </a>
                                            <!-- Edit -->
                                            <a href="{{ route('companies.edit', $company->id) }}"
                                               class="text-black dark:text-white hover:underline"
                                               title="{{ __('Edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <!-- Delete -->
                                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class=" hover:text-red-700" title="{{ __('Delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                        {{ __('No companies found.') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                        <!-- Mobile View -->
                        <div class="block md:hidden">
                            @forelse ($companies as $company)
                                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-4">
                                    <div class="text-lg font-semibold">{{ $company->name }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $company->contact_email }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">{{ $company->contact_phone }}</div>
                                    <div class="mt-4 flex items-center space-x-4">
                                        <a href="{{ route('companies.locations', $company->id) }}"
                                           class="text-black dark:text-white hover:underline"
                                           title="{{ __('View Locations') }}">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </a>
                                        <a href="{{ route('companies.edit', $company->id) }}"
                                           class="text-black dark:text-white hover:underline"
                                           title="{{ __('Edit') }}">
                                            <i class="fas fa-edit" ></i>
                                        </a>
                                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white hover:text-white" title="{{ __('Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 dark:text-gray-300">
                                    {{ __('No companies found.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
