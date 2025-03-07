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
                <i class="fas fa-plus"></i> {{ __('Create New Service') }}
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
                            #{{ $event->id }} - {{ ucfirst($event->category) }}
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
                                'aktivan' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                'zavrseno' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                                'na cekanju' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                                'otkazan' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
                            ];
                            $statusClass = $statusClasses[strtolower($event->status)] ?? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300';
                        @endphp
                        {{-- <span class="px-3 py-1 rounded-full text-xs font-semibold zavrseno">
                            test
                        </span> --}}
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
                            <button onclick="toggleAccordion({{ $event->id }})" class="w-full text-left font-medium text-blue-600 dark:text-blue-300">
                                <i class="fas fa-map-marker-alt"></i> Locations ({{ $event->locations->count() }})
                            </button>
                            <div id="accordion-{{ $event->id }}" class="hidden mt-2">
                                @foreach($groupedLocations as $companyId => $locations)
                                    @php
                                        $company = $locations->first()->company;
                                    @endphp
                                    <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg mt-2">
                                        <h5 class="font-medium text-gray-700 dark:text-gray-300">
                                            {{ $company->name }} <span class="text-sm text-gray-500 dark:text-gray-400">({{ $company->city }})</span>
                                        </h5>
                                        <ul class="list-disc pl-5 mt-1 text-xs text-gray-700 dark:text-gray-300">
                                            @foreach($locations as $location)
                                                <li>{{ $location->name }} - {{ $location->city }}</li>
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
