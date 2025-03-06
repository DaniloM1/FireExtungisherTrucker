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

                    <!-- Advanced Filter Fields -->
                    <!-- Ako URL sadrži napredne parametre, ovi polja neće imati klasu hidden -->
                    <div id="advanced-fields" class="{{ (request()->has('year') || request()->has('month') || request('category') || request('next_service_date') || request('company') || request('location')) ? '' : 'hidden' }}">
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
                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Year
                                </label>
                                <select name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    <option value="">{{ __('Select Year') }}</option>
                                    <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>{{ __('2024') }}</option>
                                    <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>{{ __('2025') }}</option>
                                    <option value="2026" {{ request('year') == '2026' ? 'selected' : '' }}>{{ __('2026') }}</option>
                                </select>
                                
                            </div>
                            <div>
                                <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Month
                        <select name="month" id="month" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <option value="">{{ __('Select Month') }}</option>
                            <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>{{ __('January') }}</option>
                            <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>{{ __('February') }}</option>
                            <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>{{ __('March') }}</option>
                            <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>{{ __('April') }}</option>
                            <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>{{ __('May') }}</option>
                            <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>{{ __('June') }}</option>
                            <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>{{ __('July') }}</option>
                            <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>{{ __('August') }}</option>
                            <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>{{ __('September') }}</option>
                            <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>{{ __('October') }}</option>
                            <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>{{ __('November') }}</option>
                            <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>{{ __('December') }}</option>
                        </select>
                    </div>
                </div>
                        
                        <!-- Hidden inputs za year i month -->
                        @if(request()->has('year'))
                            <input type="hidden" name="year" value="{{ request('year') }}">
                        @endif
                        @if(request()->has('month'))
                            <input type="hidden" name="month" value="{{ request('month') }}">
                        @endif
                    </div>

                    <!-- Dugmad za Advanced Filters i Reset -->
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
                            <i class="fa fa-search"></i> Search
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

        // Reset filters: redirect to base route (bez query parametara)
        document.getElementById('reset-filters').addEventListener('click', function() {
            window.location.href = "{{ route('service-events.index') }}";
        });

        // AJAX: Učitavanje lokacija kada se promeni kompanija
        document.getElementById('company').addEventListener('change', function () {
            var companyId = this.value;
            var locationSelect = document.getElementById('location');
            locationSelect.innerHTML = '<option value="">{{ __("All Locations") }}</option>';
            if (!companyId) return;
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

        // Automatski otvori advanced fields ako URL sadrži napredne filter parametre
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            console.log("Detected query parameters:", Array.from(urlParams.entries())); // Debug ispis
            var advancedFields = document.getElementById('advanced-fields');
            if (!advancedFields) {
                console.error("Element with id 'advanced-fields' not found!");
                return;
            }
            if(urlParams.has('year') || urlParams.has('month') || urlParams.has('category') || urlParams.has('next_service_date') || urlParams.has('company') || urlParams.has('location')) {
                advancedFields.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
