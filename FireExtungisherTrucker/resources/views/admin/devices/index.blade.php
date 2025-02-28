
<x-app-layout>
    <x-slot name="header">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <!-- Left side: Icon, Company, Location, Address -->
                <div class="flex items-center w-full md:w-auto">
                    <i class="fas fa-fire-extinguisher text-4xl mr-4 text-black dark:text-white"></i>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                            {{ $location->company->name }}
                        </h2>
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                            {{ $location->name }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ $location->address }}
                        </p>
                    </div>
                </div>
                <!-- Right side: Next Service and Create Service Link -->
                <div class="mt-4 md:mt-0 text-right w-full md:w-auto">
                    <p class="text-gray-600 dark:text-gray-400 mb-2">
                        Next Service:
                        {{ optional($location->serviceEvents->first())->next_service_date
                            ? optional($location->serviceEvents->first())->next_service_date->format('d-m-Y')
                            : 'Nema dostupnog datuma' }}
                    </p>
                    <a href="" class="flex items-center justify-end text-lg text-blue-600 dark:text-blue-400 hover:underline">
                        <i class="fas fa-plus mr-2"></i> {{ __('Create Service') }}
                    </a>
                </div>
            </div>
            <!-- Breadcrumb -->
            <div class="mt-4">
                <nav class="text-sm text-gray-500">
                    Company <span class="mx-2">&rarr;</span> Location <span class="mx-2">&rarr;</span> Devices
                </nav>
            </div>
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

    <!-- Pretraga i filter -->
    <div class="max-w-7xl mx-auto mb-4">
        <form action="{{ route('locations.devices.index', $location->id) }}" method="GET" class="flex">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('Search devices...') }}"
                class="flex-grow rounded-l-md border border-gray-300 dark:border-gray-600 p-2 focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white"
            />
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md">
                <!-- Ikonica za pretragu -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>
    </div>

    <!-- Glavni box s popisom uređaja -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

        <!-- Header sa naslovom i Add Device linkom -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg text-gray-800 dark:text-gray-200">{{ __('Device List') }}</h3>

                <a href="{{ route('locations.devices.create', $location->id) }}" class="text-lg text-gray-800 dark:text-gray-200 hover:underline">
                    <i class="fas fa-plus"></i> {{ __('Add Device') }}
                </a>
            </div>

            <!-- Tablica uređaja (Desktop prikaz) -->
            <div class="overflow-x-auto">
                <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Serial Number') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Model') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Manufacturer') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Manufacture Date') }}
                        </th>
                        <!-- Zaglavlje s filterom/sortiranjem za Next Service Date -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>{{ __('Next Service Date') }}</span>
                                @php
                                    $currentSort = request('sort');
                                    // Ako je trenutačni sort asc, postavi idući na desc, inače na asc
                                    $nextSort = ($currentSort === 'next_service_date_asc') ? 'next_service_date_desc' : 'next_service_date_asc';
                                    // Odredi koju ikonicu prikazati
                                    if($currentSort === 'next_service_date_asc'){
                                        $icon = 'fas fa-arrow-up';
                                    } elseif($currentSort === 'next_service_date_desc'){
                                        $icon = 'fas fa-arrow-down';
                                    } else {
                                        $icon = 'fas fa-sort';
                                    }
                                @endphp
                                <a href="{{ route('locations.devices.index', $location->id) }}?search={{ request('search') }}&sort={{ $nextSort }}">
                                    <i class="{{ $icon }}"></i>
                                </a>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Position') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($devices as $device)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $device->serial_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $device->model }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $device->manufacturer }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                {{ $device->manufacture_date ? \Carbon\Carbon::parse($device->manufacture_date)->format('Y-m-d') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                {{ $device->next_service_date ? \Carbon\Carbon::parse($device->next_service_date)->format('Y-m-d') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $device->position ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ ucfirst($device->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                <div class="flex items-center space-x-4">

                                    <a href="{{ route('devices.edit', $device->id) }}" class="text-black dark:text-white hover:underline" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('devices.destroy', $device->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
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
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                {{ __('No devices found.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Mobile prikaz -->
                <div class="block md:hidden">
                    @forelse ($devices as $device)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-4">
                            <div class="font-semibold">{{ $device->serial_number }}</div>
                            <div>{{ __('Model') }}: {{ $device->model }}</div>
                            <div>{{ __('Manufacturer') }}: {{ $device->manufacturer }}</div>
                            <div>{{ __('Manufacture Date') }}: {{ $device->manufacture_date ? \Carbon\Carbon::parse($device->manufacture_date)->format('Y-m-d') : '-' }}</div>
                            <div>{{ __('Next Service Date') }}: {{ $device->next_service_date ? \Carbon\Carbon::parse($device->next_service_date)->format('Y-m-d') : '-' }}</div>
                            <div>{{ __('Position') }}: {{ $device->position ?? '-' }}</div>
                            <div>{{ __('Status') }}: {{ ucfirst($device->status) }}</div>
                            <div class="mt-4 flex items-center space-x-4">
                                <a href="{{ route('devices.edit', $device->id) }}" class="text-black dark:text-white hover:underline" title="{{ __('Edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('devices.destroy', $device->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
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
                            {{ __('No devices found.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $devices->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
