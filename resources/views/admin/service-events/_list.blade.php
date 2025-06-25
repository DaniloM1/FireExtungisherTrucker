<div class="py-6 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @hasanyrole('super_admin|admin|manager')
        <div class="flex justify-end mb-6">
            <a href="{{ route('service-events.create') }}" class="text-lg font-bold text-gray-900 dark:text-gray-200">
                <i class="fas fa-plus"></i> {{ __('Kreiraj Servis') }}
            </a>
        </div>
        @endhasanyrole

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($serviceEvents as $event)
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <a href="@role('super_admin|admin'){{ route('service-events.show', $event->id) }}@else{{ route('company.service-events.show', $event->id) }}@endrole">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                                #{{ $event->id }} - {{ ucfirst($event->evid_number) }}
                                <span class="ml-2 text-gray-500 dark:text-gray-400 italic text-base align-middle">
                                {{ $event->category == 'pp_device' ? 'Aparati' : 'Hidranti' }}
                            </span>
                            </h3>
                        </a>
                        @hasanyrole('super_admin|admin|manager')
                        <div class="flex space-x-3">
                            <a href="{{ route('service-events.edit', $event->id) }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="{{ route('service-report.generate', $event->id) }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900">
                                <i class="fas fa-print"></i>
                            </a>
                            <form action="{{ route('service-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-600 dark:text-gray-300 hover:text-gray-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endhasanyrole
                    </div>

                    <div class="mt-2">
                        @php
                            $statusClasses = [
                                'active' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                'inactive' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                            ];
                            $statusClass = $statusClasses[strtolower($event->status)] ?? $statusClasses['active'];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                        {{ ucfirst($event->status) }}
                    </span>
                    </div>

                    <div class="mt-3 space-y-1 text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-day"></i>
                            <span><span class="font-semibold">Datum servisa:</span> {{ optional($event->service_date)->format('d.m.Y.') ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar-check"></i>
                            <span><span class="font-semibold">Sledeći servis:</span> {{ optional($event->next_service_date)->format('d.m.Y.') ?? '-' }}</span>
                        </div>
                        @if($event->description)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-align-left"></i>
                                <span>
                            <span class="font-semibold">Napomena:</span>
                            <span class="truncate" title="{{ $event->description }}" style="max-width: 300px; display: inline-block; vertical-align: bottom;">
                                {{ \Illuminate\Support\Str::limit($event->description, 80, '...') }}
                            </span>
                        </span>
                            </div>
                        @endif
                    </div>

                    @php
                        $groupedLocations = $event->locations->groupBy('company_id');
                        $filteredLocations = $event->locations->filter(function($loc) {
                            return auth()->user()->hasRole('company')
                                ? $loc->company_id == auth()->user()->company_id
                                : true;
                        });
                        $accordionClasses = 'hidden mt-2' . ($event->status == 'inactive' ? ' opacity-50' : '');
                    @endphp

                    @if($groupedLocations->isNotEmpty())
                        <div class="mt-4">
                            @php
                                $buttonClasses = 'w-full text-left font-medium' .
                                    ($event->status == 'inactive'
                                        ? ' text-gray-500 dark:text-gray-500'
                                        : ' text-blue-600 dark:text-blue-300');
                            @endphp
                            <button onclick="toggleAccordion({{ $event->id }})" class="{{ $buttonClasses }}">
                                <i class="fas fa-map-marker-alt"></i>
                                Lokacije ({{ $filteredLocations->count() }})
                            </button>

                            <div id="accordion-{{ $event->id }}" class="{{ $accordionClasses }}">
                                @if(auth()->user()->hasRole('company'))
                                    @php
                                        $companyId = auth()->user()->company_id ?? null;
                                        $companyLocations = $groupedLocations[$companyId] ?? collect();
                                        $company = $companyLocations->first()->company ?? null;
                                    @endphp
                                    @if($company)
                                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg mt-2">
                                            <h5 class="font-medium text-gray-700 dark:text-gray-300">
                                                {{ $company->name }} <span class="text-sm text-gray-500 dark:text-gray-400">({{ $company->city }})</span>
                                            </h5>
                                            <ul class="list-disc pl-5 mt-1 text-xs text-gray-700 dark:text-gray-300">
                                                @foreach($companyLocations as $location)
                                                    <li class="{{ $location->pivot?->status !== 'active' ? 'text-gray-500 dark:text-gray-500' : 'text-gray-700 dark:text-gray-300' }}">
                                                        {{ $location->name }} - {{ $location->city }}
                                                        @if($location->pivot?->status !== 'active')
                                                            <span class="text-xs">(inactive)</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <div class="text-gray-400 text-xs italic mt-2">Nema vezanih lokacija za vašu firmu.</div>
                                    @endif
                                @else
                                    @foreach($groupedLocations as $companyId => $locations)
                                        @php $company = $locations->first()->company; @endphp
                                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg mt-2">
                                            <h5 class="font-medium text-gray-700 dark:text-gray-300">
                                                {{ $company?->name ?? 'Company deleted' }}
                                                @if($company)
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">({{ $company->city }})</span>
                                                @endif
                                            </h5>
                                            <ul class="list-disc pl-5 mt-1 text-xs text-gray-700 dark:text-gray-300">
                                                @foreach($locations as $location)
                                                    <li class="{{ $location->pivot?->status !== 'active' ? 'text-gray-500 dark:text-gray-500' : 'text-gray-700 dark:text-gray-300' }}">
                                                        {{ $location->name }} - {{ $location->city }}
                                                        @if($location->pivot?->status !== 'active')
                                                            <span class="text-xs">(inactive)</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $serviceEvents->links() }}
        </div>
    </div>
</div>

<script>
    function toggleAccordion(eventId) {
        let element = document.getElementById('accordion-' + eventId);
        element.classList.toggle('hidden');
    }
</script>
