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
                        {{ $location->nextServiceDateByCategory('pp_device')
                            ? $location->nextServiceDateByCategory('pp_device')->format('d-m-Y')
                            : 'Nema dostupnog datuma' }}
                    </p>

                    @hasrole('super_admin|admin')
                    <a href="{{ route('locations.devices.create', $location->id) }}"
                       class="flex items-center justify-end text-lg text-blue-600 dark:text-blue-400 hover:underline">
                        <i class="fas fa-plus mr-2"></i> {{ __('Dodaj Aparat') }}
                    </a>
                    @endhasrole
                </div>
            </div>
            <!-- Breadcrumb -->
            <div class="mt-4">
                <nav class="text-sm text-gray-500">
                    @if(auth()->user()->hasRole('company'))
                        <a href="{{ route('company.locations.show', $location->id) }}"
                           class="hover:underline">
                            Lokacija
                        </a>
                    @else
                        <a href="{{ route('locations.show', $location->id) }}"
                           class="hover:underline">
                            Lokacija
                        </a>
                    @endif
                    <span class="mx-2">&rarr;</span>
                    <span class="text-gray-700 dark:text-gray-300">
                        Aparati
                    </span>
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
        <form action="{{ route(auth()->user()->hasRole('company') ? 'company.locations.devices.index' : 'locations.devices.index', $location->id) }}" method="GET" class="flex">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('Pretrazi aparate..') }}"
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
                <h3 class="text-lg text-gray-800 dark:text-gray-200">{{ __('Lista Aparata') }}</h3>
                @hasrole('super_admin|admin')
                <a href="{{ route('locations.devices.create', $location->id) }}" class="text-lg text-gray-800 dark:text-gray-200 hover:underline">
                    <i class="fas fa-plus"></i> {{ __('Dodaj Aparat') }}
                </a>
                @endhasrole
            </div>

            <!-- Tablica uređaja (Desktop prikaz) -->
            <div class="overflow-x-auto">
                <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Seriski Broj') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Model') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Prozivodjac') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Datum Proizvdonje') }}
                        </th>
                        <!-- Zaglavlje s filterom/sortiranjem za Next Service Date -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <div class="flex items-center space-x-1">
                                <span>{{ __('HVP') }}</span>
                                @php
                                    $currentSort = request('sort');
                                    $nextSort = ($currentSort === 'next_service_date_asc') ? 'next_service_date_desc' : 'next_service_date_asc';
                                    if($currentSort === 'next_service_date_asc'){
                                        $icon = 'fas fa-arrow-up';
                                    } elseif($currentSort === 'next_service_date_desc'){
                                        $icon = 'fas fa-arrow-down';
                                    } else {
                                        $icon = 'fas fa-sort';
                                    }
                                @endphp
                                <a href="{{ route(auth()->user()->hasRole('company') ? 'company.locations.devices.index' : 'locations.devices.index', $location->id) }}?search={{ request('search') }}&sort={{ $nextSort }}">
                                    <i class="{{ $icon }}"></i>
                                </a>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Pozicija') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        @hasrole('super_admin|admin')
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Akcije') }}
                        </th>
                        @endhasrole
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($devices as $device)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $device->serial_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $device->model }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $device->manufacturer }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                {{ $device->manufacture_date ? \Carbon\Carbon::parse($device->manufacture_date)->format('Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                {{ $device->next_service_date ? \Carbon\Carbon::parse($device->next_service_date)->format('Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">{{ $device->position ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-gray-200">
                                <select name="status" data-device-id="{{ $device->id }}"
                                        class="status-dropdown border border-gray-300 dark:border-gray-600 rounded p-1 dark:bg-gray-700 dark:text-white"
                                        @if(auth()->user()->hasRole('company')) disabled @endif>
                                    <option value="active" {{ $device->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="inactive" {{ $device->status == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                    <option value="needs_service" {{ $device->status == 'needs_service' ? 'selected' : '' }}>{{ __('Needs Service') }}</option>
                                </select>
                            </td>
                            @hasrole('super_admin|admin')
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
                            @endhasrole
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->hasRole('super_admin|admin') ? 8 : 7 }}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                {{ __('No devices found.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Mobile prikaz -->
                <div class="block md:hidden">
                    @forelse ($devices as $device)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 mb-4 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                            <!-- Header with serial number and status -->
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-bold text-blue-800 dark:text-blue-300 text-lg">
                                    {{ $device->serial_number }}
                                </h3>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                      @if($device->status == 'active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                      @elseif($device->status == 'inactive') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                      @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                    {{ __(ucfirst($device->status)) }}
                </span>
                            </div>

                            <!-- Device details grid -->
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <!-- Model -->
                                <div class="col-span-2 flex items-start">
                                    <i class="fas fa-cube mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Model</p>
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $device->model ?? '-' }}</p>
                                    </div>
                                </div>

                                <!-- Manufacturer -->
                                <div class="flex items-start">
                                    <i class="fas fa-industry mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Proizvođač</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $device->manufacturer ?? '-' }}</p>
                                    </div>
                                </div>

                                <!-- Position -->
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Pozicija</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $device->position ?? '-' }}</p>
                                    </div>
                                </div>

                                <!-- Manufacture Date -->
                                <div class="flex items-start">
                                    <i class="fas fa-calendar-alt mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">God. proizvodnje</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $device->manufacture_date ? \Carbon\Carbon::parse($device->manufacture_date)->format('Y') : '-' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Next Service Date -->
                                <div class="flex items-start">
                                    <i class="fas fa-wrench mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">HVP</p>
                                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                                            {{ $device->next_service_date ? \Carbon\Carbon::parse($device->next_service_date)->format('Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            @hasrole('super_admin|admin')
                            <div class="flex justify-between items-center pt-3 border-t border-gray-200 dark:border-gray-700">
                                <!-- Status dropdown -->
                                <select name="status" data-device-id="{{ $device->id }}"
                                        class="status-dropdown text-sm rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1.5">
                                    <option value="active" {{ $device->status == 'active' ? 'selected' : '' }}>Aktivan</option>
                                    <option value="inactive" {{ $device->status == 'inactive' ? 'selected' : '' }}>Neaktivan</option>
                                    <option value="needs_service" {{ $device->status == 'needs_service' ? 'selected' : '' }}>Za servis</option>
                                </select>

                                <!-- Edit/Delete buttons -->
                                <div class="flex space-x-2">
                                    <a href="{{ route('devices.edit', $device->id) }}"
                                       class="p-2 rounded-md bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900 transition-colors"
                                       title="Uredi">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('devices.destroy', $device->id) }}" method="POST"
                                          onsubmit="return confirm('Da li ste sigurni da želite obrisati ovaj aparat?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="p-2 rounded-md bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900 transition-colors"
                                                title="Obriši">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endhasrole
                        </div>
                    @empty
                        <div class="text-center py-6 bg-white dark:bg-gray-800 rounded-xl shadow">
                            <i class="fas fa-fire-extinguisher text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                            <p class="text-gray-500 dark:text-gray-400">Nema pronađenih aparata.</p>
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

    @hasrole('super_admin|admin')
    <script>
        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
            dropdown.addEventListener('change', function() {
                const deviceId = this.getAttribute('data-device-id');
                const status = this.value;

                fetch(`/devices/${deviceId}/update-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: status })
                })
                    .then(response => {
                        if (response.ok) {
                            // Opcionalno: prikažite obavijest o uspjehu
                            console.log('Status uspješno ažuriran');
                        } else {
                            // Opcionalno: obradite grešku
                            console.error('Greška prilikom ažuriranja statusa');
                        }
                    })
                    .catch(error => {
                        console.error('Greška: ', error);
                    });
            });
        });
    </script>
    @endhasrole

</x-app-layout>
