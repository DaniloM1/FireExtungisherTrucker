<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Service Events') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-600 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Unified Filter Form -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('service-events.index') }}" id="combined-search-form" class="space-y-4">
                    <!-- Basic Filter Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="evid_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Evid Number
                            </label>
                            <input type="text" name="evid_number" id="evid_number" value="{{ request('evid_number') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                   placeholder="Enter evidence number">
                        </div>
                        <div>
                            <label for="service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Service Date
                            </label>
                            <input type="date" name="service_date" id="service_date" value="{{ request('service_date') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        </div>
                    </div>

                    <!-- Toggle Advanced Filter & Reset Buttons -->


                    <!-- Advanced Filter Fields (hidden by default) -->
                    <div id="advanced-fields" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Category
                                </label>
                                <select name="category" id="category"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">{{ __('All Categories') }}</option>
                                    <option value="pp_device" {{ request('category') == 'pp_device' ? 'selected' : '' }}>PP Device</option>
                                    <option value="hydrant" {{ request('category') == 'hydrant' ? 'selected' : '' }}>Hydrant</option>
                                </select>
                            </div>
                            <div>
                                <label for="next_service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Next Service Date
                                </label>
                                <input type="date" name="next_service_date" id="next_service_date" value="{{ request('next_service_date') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            </div>
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Company
                                </label>
                                <select name="company" id="company"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">{{ __('All Companies') }}</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ request('company') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Location
                                </label>
                                <select name="location" id="location"
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">{{ __('All Locations') }}</option>
                                    <!-- Lokacije će se učitavati AJAX-om kad se izabere kompanija -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Single Search Button for Entire Form -->
                    <div class="flex justify-between mt-4">
                        <div class="flex space-x-2">
                            <button type="button" id="toggle-advanced-fields" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none">
                                <i class="fas fa-filter"></i>
                            </button>
                            <button type="button" id="reset-filters" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none">
                                <i class="fa-solid fa-filter-circle-xmark"></i>
                            </button>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">

                            <i class="fa fa-search"></i>Search
                        </button>
                    </div>

                </form>
            </div>

            <!-- Service Events List Partial -->
            @include('admin.service-events._list')
        </div>
    </div>

    <script>
        // Toggle advanced filter fields visibility
        document.getElementById('toggle-advanced-fields').addEventListener('click', function() {
            var advancedFields = document.getElementById('advanced-fields');
            advancedFields.classList.toggle('hidden');
        });

        // Reset filters: redirect to base route without query parameters
        document.getElementById('reset-filters').addEventListener('click', function() {
            window.location.href = "{{ route('service-events.index') }}";
        });

        // AJAX: When company is selected in the advanced filter, load its locations
        document.getElementById('company').addEventListener('change', function () {
            var companyId = this.value;
            var locationSelect = document.getElementById('location');
            locationSelect.innerHTML = '<option value="">{{ __("All Locations") }}</option>'; // reset

            if (!companyId) return; // No company selected

            // Adjust the URL below to your API endpoint
            fetch('/api/companies/' + companyId + '/locations')
                .then(response => response.json())
                .then(data => {
                    var locations = data.data ? data.data : data;
                    locations.forEach(function (location) {
                        var option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.name + ' - ' + location.city;
                        locationSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching locations:', error);
                });
        });
    </script>
</x-app-layout>
