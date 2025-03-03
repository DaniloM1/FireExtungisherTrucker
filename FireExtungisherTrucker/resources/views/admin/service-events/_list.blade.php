<div class="py-6 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Success poruka -->
{{--        @if(session('success'))--}}
{{--            <div class="bg-green-600 text-white p-4 rounded mb-4">--}}
{{--                {{ session('success') }}--}}
{{--            </div>--}}
{{--        @endif--}}

        <!-- Dugme za kreiranje novog servisnog događaja -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('service-events.create') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                Create New Service Event
            </a>
        </div>

        <!-- Lista servisnih događaja -->
        <div class="space-y-6">
            @foreach($serviceEvents as $event)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <!-- Zaglavlje servisnog događaja -->
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-200">
                            Service Event #{{ $event->id }}
                        </h3>
                        <div class="mt-4 sm:mt-0 flex space-x-3">
                            <a href="{{ route('service-events.edit', $event->id) }}"
                               class="text-black dark:text-white hover:underline>">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('service-events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"  class="text-black dark:text-white hover:underline">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Podaci o servisnom događaju -->
                    <div class="mt-4 space-y-2 text-gray-700 dark:text-gray-300 text-sm">
                        <p><strong>Category:</strong> {{ ucfirst($event->category) }}</p>
                        <p><strong>Service Date:</strong> {{ $event->service_date->format('Y-m-d') }}</p>
                        <p><strong>Next Service Date:</strong> {{ $event->next_service_date->format('Y-m-d') }}</p>
                        <p><strong>Evid Number:</strong> {{ $event->evid_number }}</p>
                        <p><strong>Cost:</strong> {{ $event->cost }}</p>
                        @if($event->description)
                            <p><strong>Description:</strong> {{ $event->description }}</p>
                        @endif
                    </div>

                    <!-- Grupisanje lokacija po kompanijama -->
                    @php
                        $groupedLocations = $event->locations->groupBy('company_id');
                    @endphp

                    @if($groupedLocations->isNotEmpty())
                        <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                                Companies & Locations
                            </h4>
                            @foreach($groupedLocations as $companyId => $locations)
                                @php
                                    // Pretpostavljamo da svaki location ima definisan odnos company
                                    $company = $locations->first()->company;
                                @endphp
                                <div class="mt-4">
                                    <h5 class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                        {{ $company->name }} <span class="text-sm text-gray-500 dark:text-gray-400">({{ $company->city }})</span>
                                    </h5>
                                    <ul class="list-disc pl-5 mt-1 text-sm text-gray-700 dark:text-gray-300">
                                        @foreach($locations as $location)
                                            <li>{{ $location->name }} - {{ $location->city }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                            No locations assigned to this service event.
                        </p>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination (ako je primenljivo) -->
        <div class="mt-6">
            {{ $serviceEvents->links() }}
        </div>
    </div>
</div>
