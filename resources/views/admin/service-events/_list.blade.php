<div class="py-6 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif --}}

        <!-- Button for Creating New Service Event -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('service-events.create') }}" class="text-lg font-bold text-gray-900 dark:text-gray-200">
                <i class="fas fa-plus"></i> {{ __('Kreiraj Servis') }}
            </a>
        </div>

        <!-- Service Events Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($serviceEvents as $event)
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                    <!-- Service Event Header -->
                    <div class="flex items-center justify-between">
                        <a href="{{ route('service-events.show', $event->id)}}">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                                #{{ $event->id }} - {{ ucfirst($event->evid_number) }}
                                <span class="ml-2 text-gray-500 dark:text-gray-400 italic text-base align-middle">
        {{ $event->category == 'pp_device' ? 'Aparati' : 'Hidranti' }}
    </span>
                            </h3>


                        </a>
                        <div class="flex space-x-3">
                            <a href="{{ route('service-events.edit', $event->id) }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('service-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-600 dark:text-gray-300 hover:text-gray-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="mt-2">
                        @php
                            $statusClasses = [
                                'active' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                'inactive' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                            ];
                            $statusKey = strtolower($event->status);
                            $statusClass = $statusClasses[$statusKey] ?? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
        {{ ucfirst($event->status) }}
    </span>
                    </div>

                    <!-- Service Event Info (Compact) -->
                    <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                        <p><strong>Date:</strong> {{ $event->service_date->format('Y-m-d') }}</p>
                        <p><strong>Next:</strong> {{ $event->next_service_date->format('Y-m-d') }}</p>
                        <p><strong>Cost:</strong> ${{ number_format($event->cost, 2) }}</p>
                        @if($event->description)
                            <p class="truncate"><strong>Note:</strong> {{ Str::limit($event->description, 50, '...') }}</p>
                        @endif
                    </div>

                    <!-- Accordion for Locations -->
                    @php
                        $groupedLocations = $event->locations->groupBy('company_id');
                    @endphp

                    @if($groupedLocations->isNotEmpty())
                        <div class="mt-4">
                            @php
                                $buttonClasses = 'w-full text-left font-medium';
                                // Dugme se boji po statusu servis događaja
                                $buttonClasses .= ($event->status == 'inactive')
                                    ? ' text-gray-500 dark:text-gray-500'
                                    : ' text-blue-600 dark:text-blue-300';
                            @endphp
                            <button onclick="toggleAccordion({{ $event->id }})" class="{{ $buttonClasses }}">
                                <i class="fas fa-map-marker-alt"></i> Locations ({{ $event->locations->count() }})
                            </button>

                            @php
                                // Ako je servis događaj inactive, posivi celokupni akordeon sadržaj.
                                $accordionClasses = 'hidden mt-2';
                                if ($event->status == 'inactive') {
                                    $accordionClasses .= ' opacity-50';
                                }
                            @endphp
                            <div id="accordion-{{ $event->id }}" class="{{ $accordionClasses }}">
                                @foreach($groupedLocations as $companyId => $locations)
                                    @php
                                        $company = $locations->first()->company;
                                    @endphp
                                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg mt-2">
                                        <h5 class="font-medium text-gray-700 dark:text-gray-300">
                                            @if($company)
                                                {{ $company->name }} <span class="text-sm text-gray-500 dark:text-gray-400">({{ $company->city }})</span>
                                            @else
                                                <em>Company deleted</em>
                                            @endif
                                        </h5>
                                        <ul class="list-disc pl-5 mt-1 text-xs text-gray-700 dark:text-gray-300">
                                            @foreach($locations as $location)
                                                @php
                                                    // Provera pivot podataka – ako je lokacija inactive, dodajemo sivu boju i oznaku
                                                    $locClasses = 'text-gray-700 dark:text-gray-300';
                                                    $inactiveLabel = '';
                                                    if(isset($location->pivot) && $location->pivot->status !== 'active'){
                                                        $locClasses = 'text-gray-500 dark:text-gray-500';
                                                        $inactiveLabel = ' <span class="text-xs">(inactive)</span>';
                                                    }
                                                @endphp
                                                <li class="{{ $locClasses }}">
                                                    {{ $location->name }} - {{ $location->city }}{!! $inactiveLabel !!}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
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
