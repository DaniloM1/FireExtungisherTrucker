<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <div>
                <div class="text-xl font-bold text-blue-700 dark:text-blue-300 tracking-tight">
                    Kompanija:
                    <span class="ml-2 text-gray-800 dark:text-gray-100">{{ $location->company->name }}</span>
                </div>
                @hasrole('super_admin')
                <nav class=" sm:block text-xs text-gray-400 dark:text-gray-500" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1">
                        <li>
                            <a href="{{ route('companies.locations.index', $location->company_id) }}" class="hover:underline">
                                Kompanija
                            </a>
                        </li>
                        <svg class="w-3 h-3 inline mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        <li>
                            <a href="{{ route('companies.locations.index', $location->company_id) }}" class="hover:underline">
                                Lokacija
                            </a>
                        </li>
                    </ol>
                </nav>
                @endhasrole
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Location Info + Attachments -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6 flex flex-col md:flex-row gap-6 border border-gray-200 dark:border-gray-700">
                <div class="flex-1 space-y-3">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100"><i class="fas fa-location mr-2 text-blue-500"></i>{{ $location->name }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-2 text-base leading-relaxed">
                        @if ($location->city)
                            <div class="flex flex-col text-gray-600 dark:text-gray-300">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-city text-blue-500 w-5"></i>
                                    <span class="font-semibold">Grad:</span>
                                    <span>{{ $location->city }}</span>
                                </div>
                                @if ($location->address)
                                    <div class="flex items-center gap-2 ml-7 mt-0.5 text-sm text-gray-400 dark:text-gray-400">
                                        <i class="fas fa-map-marker-alt text-gray-400 w-4"></i>
                                        <span>{{ $location->address }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif


                    @if ($location->pib)
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                <i class="fas fa-file-invoice text-blue-500 w-5"></i>
                                <span class="font-semibold">PIB:</span>
                                <span>{{ $location->pib }}</span>
                            </div>
                        @endif

                        @if ($location->maticni)
                            <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                <i class="fas fa-id-card text-blue-500 w-5"></i>
                                <span class="font-semibold">Matični broj:</span>
                                <span>{{ $location->maticni }}</span>
                            </div>
                        @endif

                            @if ($location->contact)
                                <div class="flex flex-col text-gray-600 dark:text-gray-300">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-user text-blue-500 w-5"></i>
                                        <span class="font-semibold">Kontakt:</span>
                                        <span>{{ $location->contact }}</span>
                                    </div>
                                    @if ($location->kontakt_broj)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $location->kontakt_broj) }}"
                                           class="ml-7 mt-0.5 text-sm text-gray-400 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition group select-text">
                                            {{ $location->kontakt_broj }}
                                            <i class="fas fa-arrow-up-right-from-square text-xs opacity-60 ml-1 group-hover:opacity-100"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif



                    </div>


                    <div class="flex items-center mb-4">
                        <i class="fas fa-paperclip text-blue-500 mr-2"></i>
                        <span class="font-semibold text-gray-700 dark:text-gray-200">Prilozi za lokaciju</span>
                    </div>

                    <div class="space-y-2 mb-4 max-h-60 overflow-y-auto pr-2">
                        @forelse($generalAttachments as $file)
    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg px-4 py-3 group hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
        <div class="flex items-center min-w-0">
            <i class="far fa-file-alt text-xl mr-3 text-gray-500 dark:text-gray-300"></i>
            <div class="min-w-0">
                <a href="{{ route('attachments.view', $file) }}" target="_blank"
                   class="text-blue-600 dark:text-blue-300 font-medium hover:underline truncate block">
                    {{ $file->name }}
                </a>
                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $file->type }}</span>
            </div>
        </div>
        @hasrole('super_admin')
        <form action="{{ route('attachments.destroy', $file) }}" method="POST"
              onsubmit="return confirm('Obrisati prilog?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 px-2 py-1 rounded hover:bg-red-50 dark:hover:bg-gray-600 transition-colors">
                <i class="fas fa-trash"></i>
            </button>
        </form>
        @endhasrole
    </div>
@empty
    <div class="text-gray-400 dark:text-gray-500 text-sm py-3 text-center">Nema priloga.</div>
@endforelse

                    </div>
                    @hasrole('super_admin')
                    <!-- Upload Form -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                        <form action="{{ route('locations.attachments.store', $location) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div>
                                <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Odaberite fajl</label>
                                <input type="file" name="attachment" id="attachment" required
                                       class="block w-full text-sm text-gray-700 dark:text-gray-300
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              dark:file:bg-blue-900 dark:file:text-blue-200
                                              hover:file:bg-blue-100 dark:hover:file:bg-blue-800
                                              transition-colors cursor-pointer" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Naziv dokumenta</label>
                                    <input type="text" name="name" id="name" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-blue-500 dark:focus:ring-blue-600"
                                           placeholder="Npr. Faktura">
                                </div>
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tip dokumenta</label>
                                    <input type="text" name="type" id="type" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-blue-500 dark:focus:ring-blue-600"
                                           placeholder="Npr. Račun">
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                <i class="fas fa-upload mr-2"></i> Dodaj prilog
                            </button>
                        </form>

                        @if($errors->any())
                            <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                @foreach($errors->all() as $error)
                                    <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @endhasrole
                </div>

                <div class="w-full px-2 md:px-0 md:w-1/2 max-w-lg mx-auto">
                    <x-map-card
                        :locations="[$location]"
                        title="Lokacija"
                        width="max-w-s"
                        height="h-64 sm:h-64 md:h-200"

                    />

                </div>
            </div>

            <!-- Devices Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 ">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <i class="fas fa-fire-extinguisher mr-2 text-blue-500"></i>
                        Aparati ({{ $location->devices->count() }})
                        @hasrole('super_admin|admin')
                        <a href="{{ route('locations.devices.index', $location->id) }}"
                           class="ml-3 text-blue-600 dark:text-blue-400 hover:underline flex items-center"
                           title="Vidi sve aparate">
                            <i class="fas fa-arrow-right"></i>
                            <span class="ml-1">Vidi aparate</span>
                        </a>
                        @endhasrole
                        @hasrole('company')
                        <a href="{{ route('company.locations.devices.index',  $location->id) }}"
                           class="ml-3 text-blue-600 dark:text-blue-400 hover:underline flex items-center"
                           title="Vidi sve aparate">
                            <i class="fas fa-arrow-right"></i>
                            <span class="ml-1">Vidi aparate</span>
                        </a>
                        @endhasrole
                    </h3>

                    @hasrole('super_admin')  <a href="{{route('locations.devices.create',$location->id)}}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">+ Dodaj aparat</a>@endhasrole
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($location->devices->take(6) as $device)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-blue-700 dark:text-blue-300">
                                        {{ $device->model ?? 'Model nepoznat' }}
                                    </h4>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span class="font-medium">Serijski broj:</span> {{ $device->serial_number ?? '-' }}
                                    </div>
                                </div>
                                @if($device->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Aktivan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Neaktivan
                                    </span>
                                @endif
                            </div>

                            <div class="mt-3 space-y-1 text-sm">
                                <div class="flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-industry mr-2 text-gray-400 w-4"></i>
                                    <span class="font-medium">Proizvođač:</span>
                                    <span class="ml-1 truncate max-w-[10rem] block" title="{{ $device->manufacturer }}">
    {{ $device->manufacturer ?? '-' }}
</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-map-pin mr-2 text-gray-400 w-4"></i>
                                    <span class="font-medium">Pozicija:</span>
                                    <span class="ml-1">{{ $device->position ?? '-' }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-calendar-check mr-2 text-gray-400 w-4"></i>
                                    <span class="font-medium">HVP:</span>
                                    <span class="ml-1">{{ optional($device->next_service_date)->format('Y') ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-6">
                            <p class="text-gray-500 dark:text-gray-400">Nema registrovanih aparata.</p>
                        </div>
                    @endforelse

                    @if($location->devices->count() > 6)
                        <div class="col-span-2 text-center py-3">
                            <p class="text-gray-500 dark:text-gray-400">
                                Prikazano 6 od {{ $location->devices->count() }} aparata.
                                <a href="{{ route('locations.devices.index', $location->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    Pogledaj sve
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Hydrants Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <i class="fas fa-faucet mr-2 text-cyan-500"></i>
                        Hidranti ({{ $location->hydrants->count() }})
                        @hasrole('super_admin|admin')
                        <a href="{{ route('locations.hydrants.index', $location->id) }}"
                           class="ml-3 text-blue-600 dark:text-blue-400 hover:underline flex items-center"
                           title="Vidi sve hidrante">
                            <i class="fas fa-arrow-right"></i>
                            <span class="ml-1">Vidi Hidrante</span>
                        </a>
                        @endhasrole
                        @hasrole('company')
                        <a href="{{ route('company.locations.hydrants.index',  $location->id) }}"
                           class="ml-3 text-blue-600 dark:text-blue-400 hover:underline flex items-center"
                           title="Vidi sve hidrante">
                            <i class="fas fa-arrow-right"></i>
                            <span class="ml-1">Vidi Hidrante</span>
                        </a>
                        @endhasrole
                    </h3>
                    @hasrole('super_admin')<a href="{{route('locations.hydrants.create', $location->id)}}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">+ Dodaj hidrant</a>@endhasrole
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($location->hydrants->take(6) as $hydrant)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-cyan-700 dark:text-cyan-300">
                                        {{ $hydrant->type ?? 'Tip nepoznat' }}
                                        @if($hydrant->model)
                                            <span class="text-gray-500 dark:text-gray-400">/</span> {{ $hydrant->model }}
                                        @endif
                                    </h4>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        <span class="font-medium">Serijski broj:</span> {{ $hydrant->serial_number ?? '-' }}
                                    </div>
                                </div>
                                @if($hydrant->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Aktivan
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        Neaktivan
                                    </span>
                                @endif
                            </div>

                            <div class="mt-3 space-y-1 text-sm">
                                <div class="flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-industry mr-2 text-gray-400 w-4"></i>
                                    <span class="font-medium">Proizvođač:</span>
                                    <span class="ml-1">{{ $hydrant->manufacturer ?? '-' }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-map-pin mr-2 text-gray-400 w-4"></i>
                                    <span class="font-medium">Pozicija:</span>
                                    <span class="ml-1">{{ $hydrant->position ?? '-' }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-calendar-check mr-2 text-gray-400 w-4"></i>
                                    <span class="font-medium">Sledeći servis:</span>
                                    <span class="ml-1">{{ optional($hydrant->next_service_date)->format('d.m.Y') ?? '-' }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-tachometer-alt mr-2 text-gray-400 w-4"></i>
                                    <span class="font-medium">Statički pritisak:</span>
                                    <span class="ml-1">{{ $hydrant->static_pressure ?? '-' }}</span>
                                </div>
                                <div class="flex items-center text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-tint mr-2 text-gray-400 w-4"></i>
                                    <span class="font-medium">Protok:</span>
                                    <span class="ml-1">{{ $hydrant->flow ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-6">
                            <p class="text-gray-500 dark:text-gray-400">Nema registrovanih hidranta.</p>
                        </div>
                    @endforelse

                    @if($location->hydrants->count() > 6)
                        <div class="col-span-2 text-center py-3">
                            <p class="text-gray-500 dark:text-gray-400">
                                Prikazano 6 od {{ $location->hydrants->count() }} hidranta.
                                <a href="{{ route('locations.hydrants.index', $location->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    Pogledaj sve
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Service Events Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <i class="fas fa-tools mr-2 text-purple-500"></i>
                        Servisi ({{ $location->serviceEvents->count() }})
                    </h3>
                    @hasrole('super_admin') <a href="{{route('service-events.create')}}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">+ Dodaj servis</a>@endhasrole
                </div>

                <div class="space-y-4">
                    @forelse($location->serviceEvents->sortByDesc('service_date')->take(6) as $service)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <h4 class="font-bold text-purple-700 dark:text-purple-300 flex items-center gap-2">
                                        <i class="fas fa-calendar-day"></i>
                                        @hasrole('super_admin')
                                        <a href="{{ route('service-events.show', $service->id) }}" class="hover:underline text-blue-600 dark:text-blue-400">
                                            <span>{{$service->evid_number}}</span> |
                                            {{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d.m.Y') : 'Datum nepoznat' }}
                                        </a>
                                        @elsehasrole('company')
                                        <a href="{{ route('company.service-events.show', $service->id) }}" class="hover:underline text-blue-600 dark:text-blue-400">
                                            <span>{{$service->evid_number}}</span> |
                                            {{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d.m.Y') : 'Datum nepoznat' }}
                                        </a>
                                        @else
                                            {{ $service->service_date ? \Carbon\Carbon::parse($service->service_date)->format('d.m.Y') : 'Datum nepoznat' }}
                                            @endhasrole

                                            @if($service->next_service_date)
                                                <span class="ml-3 text-xs text-blue-500 dark:text-blue-300 bg-blue-50 dark:bg-blue-900 rounded px-2 py-1">
                                                Sledeći: {{ \Carbon\Carbon::parse($service->next_service_date)->format('d.m.Y') }}
                                            </span>
                                            @endif
                                    </h4>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-1">
                                        @if($service->user)
                                            <i class="fas fa-user mr-1"></i> {{ $service->user->name }}
                                        @endif
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 ml-2">
                                {{ ['pp_device' => 'Aparati', 'hydrants' => 'Hidranti'][$service->category] ?? ucfirst($service->category) }}

                                </span>
                            </div>

                            @if($service->description)
                                <div class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                    {{ $service->description }}
                                </div>
                            @endif

                            @if($service->attachments && $service->attachments->where('location_id', $location->id)->count())
                            <div class="mt-3">
                                <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                    <i class="fas fa-paperclip mr-2"></i>
                                    Prilozi uz servis (za ovu lokaciju):
                                </div>
                                <div class="space-y-2">
                                    @foreach($service->attachments->where('location_id', $location->id) as $att)
                                        <div class="flex items-center justify-between bg-white dark:bg-gray-600 rounded px-3 py-2">
                                            <div class="flex items-center min-w-0">
                                                <i class="far fa-file-alt text-gray-500 dark:text-gray-300 mr-2"></i>
                                                <a href="{{ route('attachments.view', $att) }}" target="_blank"
                                                   class="text-blue-600 dark:text-blue-300 hover:underline truncate">
                                                    {{ $att->name }}
                                                </a>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 ml-2 whitespace-nowrap">{{ $att->type }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        


                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-gray-500 dark:text-gray-400">Nema registrovanih servisa.</p>
                        </div>
                    @endforelse

                    @if($location->serviceEvents->count() > 6)
                        <div class="text-center py-3">
                            <p class="text-gray-500 dark:text-gray-400">
                                Prikazano 6 od {{ $location->serviceEvents->count() }} servisa.
                                <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    Pogledaj sve
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Inspections (Location Checks) Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700 mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                        <i class="fas fa-clipboard-check mr-2 text-green-500"></i>
                        Inspekcije i Testovi ({{ $location->locationChecks->count() }})
                    </h3>
                    @hasrole('super_admin')
                    <a href="{{ route('location_checks.create') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        + Dodaj inspekciju/test
                    </a>
                    @endhasrole
                </div>

                <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
                    @forelse($location->locationChecks->sortByDesc('last_performed_date') as $check)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-bold text-green-700 dark:text-green-300 flex items-center gap-2">
                                        <i class="fas fa-clipboard-list"></i>
                                        <a href="{{ route('location_checks.show', $check->id) }}" class="" title="Izmeni">
                                        <span>{{ $check->name }}</span>
                                        </a>

                                    </h4>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Poslednja inspekcija: {{ $check->last_performed_date ? \Carbon\Carbon::parse($check->last_performed_date)->format('d.m.Y') : '-' }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        Sledeći termin: {{ $check->next_due_date ? \Carbon\Carbon::parse($check->next_due_date)->format('d.m.Y') : '-' }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2 mt-1">
                                        <i class="fas fa-user mr-1"></i> {{ $check->inspector->name ?? 'Nije dodeljen' }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
            {{ ['inspection' => 'Elektro Inspekcija', 'test' => 'Testovi'][$check->type] ?? ucfirst($check->type) }}
        </span>

{{--                                    <a href="{{ route('location_checks.edit', $check->id) }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" title="Izmeni">--}}
{{--                                        <i class="fas fa-edit"></i>--}}
{{--                                    </a>--}}
                                </div>
                            </div>


                        @if($check->description)
                                <div class="text-sm text-gray-600 dark:text-gray-300 mt-2 whitespace-pre-line">
                                    {{ $check->description }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-400 py-6">
                            Nema registrovanih inspekcija ili testova za ovu lokaciju.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            /* Custom scrollbar for dark mode */
            .dark ::-webkit-scrollbar {
                width: 8px;
            }
            .dark ::-webkit-scrollbar-track {
                background: #374151;
            }
            .dark ::-webkit-scrollbar-thumb {
                background: #4B5563;
                border-radius: 4px;
            }
            .dark ::-webkit-scrollbar-thumb:hover {
                background: #6B7280;
            }
        </style>
    @endpush
</x-app-layout>
