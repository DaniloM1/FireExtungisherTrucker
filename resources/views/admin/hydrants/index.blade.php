<x-app-layout>
    <x-slot name="header">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <!-- Leva strana -->
                <div class="flex items-center w-full md:w-auto">
                    <i class="fas fa-faucet text-4xl mr-4 text-black dark:text-white"></i>
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
                @php
                    // Pronađi sledeći servis event za hidrante
                    $nextServiceEvent = $location->serviceEvents()
                        ->where('category', 'hydrant')
                        ->wherePivot('status', 'active')
                        ->where('next_service_date', '>=', now())
                        ->orderBy('next_service_date', 'asc')
                        ->first();
                @endphp
                <!-- Desna strana -->
                <div class="mt-4 md:mt-0 text-right w-full md:w-auto">
{{--                    <a href="{{route('service-event.show')}}"></a>--}}
                    <p class="text-gray-600 dark:text-gray-400 mb-2">
                        Sledeći servis:
                        @if($nextServiceEvent)
                            <a
                                href="{{ route('company.service-events.show', $nextServiceEvent->id) }}"
                                class="text-blue-700 dark:text-blue-400 underline hover:no-underline font-semibold"
                                title="Prikaži servisni događaj"
                            >
                                {{ \Carbon\Carbon::parse($nextServiceEvent->next_service_date)->format('d.m.Y') }}
                            </a>
                        @else
                            Nema dostupnog datuma
                        @endif
                    </p>
                    @hasrole('super_admin|admin')
                    <a href="{{ route('locations.hydrants.create', $location->id) }}"
                       class="flex items-center justify-end text-lg text-blue-600 dark:text-blue-400 hover:underline">
                        <i class="fas fa-plus mr-2"></i> Dodaj hidrantski uređaj
                    </a>
                    @endhasrole
                </div>
            </div>
            <!-- Breadcrumb -->
            <div class="mt-4">
                <nav class="text-sm text-gray-500">
                    @if(auth()->user()->hasRole('company'))
                        <a href="{{ route('company.locations.show', $location->id) }}"
                           class="hover:underline">Lokacija</a>
                    @else
                        <a href="{{ route('locations.show', $location->id) }}"
                           class="hover:underline">Lokacija</a>
                    @endif
                    <span class="mx-2">&rarr;</span>
                    <span class="text-gray-700 dark:text-gray-300">
                        Hidranti
                    </span>
                </nav>
            </div>
        </div>
    </x-slot>

    <!-- Poruke -->
    <div class="max-w-7xl mx-auto mt-4 mb-4">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <!-- Naslov i dugme -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg text-gray-800 dark:text-gray-200">Lista hidrantskih uređaja</h3>
                @hasrole('super_admin|admin')
                <a href="{{ route('locations.hydrants.create', $location->id) }}"
                   class="text-lg text-gray-800 dark:text-gray-200 hover:underline">
                    <i class="fas fa-plus"></i> Dodaj hidrantski uređaj
                </a>
                @endhasrole
            </div>

            <div class="overflow-x-auto">
                <!-- Desktop prikaz -->
                <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Serijski broj</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Tip</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Proizvođač</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Datum servisa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">HVP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        @hasrole('super_admin|admin')
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Akcije</th>
                        @endhasrole
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($hydrants as $hydrant)
                        <tr>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $hydrant->serial_number }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $hydrant->model }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $hydrant->type }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $hydrant->manufacturer }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                {{ $hydrant->next_service_date ? \Carbon\Carbon::parse($hydrant->next_service_date)->format('d.m.Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                {{ $hydrant->hvp ? \Carbon\Carbon::parse($hydrant->hvp)->format('d.m.Y') : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 text-xs rounded
                                    @if($hydrant->status=='active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($hydrant->status=='inactive') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                    {{ ucfirst($hydrant->status ?? '-') }}
                                </span>
                            </td>
                            @hasrole('super_admin|admin')
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                <div class="flex space-x-2">
                                    <a href="{{ route('locations.hydrants.edit', [$location->id, $hydrant->id]) }}"
                                       class="hover:underline" title="Uredi">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('locations.hydrants.destroy', [$location->id, $hydrant->id]) }}"
                                          method="POST" onsubmit="return confirm('Da li ste sigurni?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400">
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
                                Nema hidranta.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Mobilni prikaz -->
                <div class="block md:hidden">
                    @forelse($hydrants as $hydrant)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 mb-4 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-bold text-lg text-gray-800 dark:text-gray-200">{{ $hydrant->serial_number }}</h3>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold
                                    @if($hydrant->status=='active') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($hydrant->status=='inactive') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                    {{ ucfirst($hydrant->status ?? '-') }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div class="flex items-start col-span-2">
                                    <i class="fas fa-cube mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Model</p>
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $hydrant->model ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Tip</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $hydrant->type ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-industry mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Proizvođač</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $hydrant->manufacturer ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-calendar-check mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Servis</p>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $hydrant->next_service_date ? \Carbon\Carbon::parse($hydrant->next_service_date)->format('d.m.Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-wrench mt-1 mr-2 text-gray-500 dark:text-gray-400"></i>
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">HVP</p>
                                        <p class="text-sm text-blue-600 dark:text-blue-400">
                                            {{ $hydrant->hvp ? \Carbon\Carbon::parse($hydrant->hvp)->format('d.m.Y') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @hasrole('super_admin|admin')
                            <div class="flex justify-end space-x-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('locations.hydrants.edit', [$location->id, $hydrant->id]) }}"
                                   class="p-2 rounded-md bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900 transition-colors"
                                   title="Uredi">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('locations.hydrants.destroy', [$location->id, $hydrant->id]) }}"
                                      method="POST" onsubmit="return confirm('Da li ste sigurni?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-md bg-gray-100 dark:bg-gray-700 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900 transition-colors"
                                            title="Obriši">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endhasrole
                        </div>
                    @empty
                        <div class="text-center py-6 bg-white dark:bg-gray-800 rounded-xl shadow">
                            <i class="fas fa-faucet text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                            <p class="text-gray-500 dark:text-gray-400">Nema pronađenih hidranta.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <!-- Paginacija -->
            <div class="mt-6">
                {{ $hydrants->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
