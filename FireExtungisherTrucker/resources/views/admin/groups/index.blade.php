<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Groups for') }}
        </h2>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                {{ $location->company->name }}
            </h3>
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                {{ $location->name }}
            </h3>
            {{$location->address}}
        </div>
    </x-slot>

    <!-- Poruke o uspjehu i greškama -->
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

    <!-- Glavni box -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <!-- Header sa naslovom i Add Group linkom -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">{{ __('Group List') }}</h3>
                <a href="{{ route('locations.groups.create', $location->id) }}" class="hover:underline">
                    <i class="fas fa-plus"></i> {{ __('Add Group') }}
                </a>
            </div>

            <!-- Tablica grupa (Desktop prikaz) -->
            <div class="overflow-x-auto">
                <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Name') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Description') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Next Service Date') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($groups as $group)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $group->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $group->description ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $group->next_service_date ? \Carbon\Carbon::parse($group->next_service_date)->format('Y-m-d') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('groups.show', $group->id) }}"
                                       class="text-black dark:text-white hover:underline"
                                       title="{{ __('View Devices') }}">
                                        <i class="fas fa-fire-extinguisher"></i>
                                    </a>
                                    <!-- Dodavanje aparata u grupu -->
                                    <a href="{{ route('groups.add-device', $group->id) }}"
                                       class="text-black dark:text-white hover:underline"
                                       title="{{ __('Add Device') }}">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                    <a href="{{ route('groups.edit', $group->id) }}" class="text-black dark:text-white hover:underline" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-red-700" title="{{ __('Delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                {{ __('No groups found.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Mobile prikaz -->
                <div class="block md:hidden">
                    @forelse ($groups as $group)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-4">
                            <div class="font-semibold">{{ $group->name }}</div>
                            <div>{{ __('Description') }}: {{ $group->description ?? '-' }}</div>
                            <div>{{ __('Next Service Date') }}: {{ $group->next_service_date ? \Carbon\Carbon::parse($group->next_service_date)->format('Y-m-d') : '-' }}</div>
                            <div class="mt-4 flex items-center space-x-4">
                                <a href="{{ route('groups.show', $group->id) }}"
                                   class="text-black dark:text-white hover:underline"
                                   title="{{ __('View Devices') }}">
                                    <i class="fas fa-fire-extinguisher"></i
                                </a>
                                <!-- Dodavanje aparata u grupu -->
                                <a href="{{ route('groups.add-device', $group->id) }}"
                                   class="text-black dark:text-white hover:underline"
                                   title="{{ __('Add Device') }}">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                                <a href="{{ route('groups.edit', $group->id) }}" class="text-black dark:text-white hover:underline" title="{{ __('Edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="hover:text-red-700" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-300">
                            {{ __('No groups found.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $groups->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
