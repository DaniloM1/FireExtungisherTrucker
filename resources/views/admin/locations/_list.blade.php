<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($locations as $location)
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-5 flex flex-col h-full">

            <a href="@role('super_admin|admin')
                                 {{ route('locations.show', $location->id) }}
                             @else
                                 {{ route('company.locations.show', $location->id) }}
                             @endrole"
               class="text-lg font-bold text-blue-700 dark:text-blue-400 hover:underline">
                {{ $location->name }}
            </a>
            @hasrole('super_admin|admin')
            @if($location->company)
                <a href="{{ route('companies.show', $location->company->id) }}"
                   class="text-sm text-gray-700 dark:text-gray-300 hover:text-blue-500 dark:hover:text-blue-300 block mt-1 mb-2">
                    <i class="fa fa-building text-xs mr-1"></i>
                    {{ $location->company->name }}
                </a>
            @endif
            @endrole


            <p class="text-xs text-gray-500 dark:text-gray-400">
                <i class="fa fa-map-marker-alt mr-1"></i>
                {{ $location->address }}, {{ $location->city }}
            </p>
            <div class="flex items-center gap-4 mt-3">
                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-md text-xs font-medium">
                                Aparati: <span class="font-bold">{{ $location->devices_count ?? $location->devices->count() }}</span>
                            </span>
                <span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-md text-xs font-medium">
                                Hidranti: <span class="font-bold">{{ $location->hydrants_count ?? $location->hydrants->count() }}</span>
                            </span>
            </div>

            @php
                $nextServiceEvent = $location->serviceEvents()
                    ->where('service_events.status', 'active')
                    ->where('service_events.next_service_date', '>=', now())
                    ->orderBy('service_events.next_service_date')
                    ->first();
            @endphp
            <div class="mt-3">
                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                <strong>Sledeći servis:</strong>
                                @if($nextServiceEvent)
                                    <a href="{{ auth()->user()->hasRole('super_admin|admin')
                                        ? route('service-events.show', $nextServiceEvent->id)
                                        : route('company.service-events.show', $nextServiceEvent->id) }}"
                                    class="text-blue-700 dark:text-blue-400 underline hover:no-underline font-semibold"
                                       title="Prikaži servisni događaj">
                                        {{ \Carbon\Carbon::parse($nextServiceEvent->next_service_date)->format('d.m.Y') }}
                                    </a>
                                @else
                                    <span class="text-gray-400">Nema dostupnog datuma</span>
                                @endif
                            </span>
            </div>
        </div>
    @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-gray-500 dark:text-gray-300">
            Nema pronađenih lokacija.
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $locations->appends(request()->query())->links() }}
</div>
