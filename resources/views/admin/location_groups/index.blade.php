<x-app-layout>
    <x-slot name="header">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
            <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                Location Groups
            </h3>
            <p class="text-gray-600 dark:text-gray-400">
                Overview of location groups.
            </p>
        </div>
        <div class="mt-4">
            <nav class="text-sm text-gray-500">
                Dashboard <span class="mx-2">&rarr;</span> Location Groups
            </nav>
        </div>
    </x-slot>
    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Link za kreiranje nove lokacijske grupe -->
            <div class="flex justify-end mb-6">
                <a href="{{ route('location-groups.create') }}" class="text-lg font-bold text-gray-900 dark:text-gray-200">
                    <i class="fas fa-plus"></i> {{ __('Create New Location Group') }}
                </a>
            </div>

            <!-- Grid kartica za lokacijske grupe -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($locationGroups as $group)
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-4">
                        <!-- Header: naziv i akcije -->
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-200">
                                {{ $group->name }}
                            </h3>
                            <div class="flex space-x-3">
                                <a href="{{ route('location-groups.edit', $group->id) }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900" title="{{ __('Edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('location-groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-600 dark:text-gray-300 hover:text-gray-900" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Opis grupe -->
                        @if($group->description)
                            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                <p>{{ $group->description }}</p>
                            </div>
                        @endif

                        <!-- Accordion za prikaz lokacija unutar grupe -->
                        @if($group->locations->count())
                            <div class="mt-4">
                                <button onclick="toggleAccordion({{ $group->id }})" class="w-full text-left font-medium text-blue-600 dark:text-blue-300">
                                    <i class="fas fa-map-marker-alt"></i> Locations ({{ $group->locations->count() }})
                                </button>
                                <div id="accordion-{{ $group->id }}" class="hidden mt-2">
                                    @php
                                        // Grupiramo lokacije po kompaniji
                                        $groupedLocations = $group->locations->groupBy('company_id');
                                    @endphp
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
                {{ $locationGroups->links() }}
            </div>
        </div>
    </div>

    <script>
        function toggleAccordion(groupId) {
            var element = document.getElementById('accordion-' + groupId);
            element.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
