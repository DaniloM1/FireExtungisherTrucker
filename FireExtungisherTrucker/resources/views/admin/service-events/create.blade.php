<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Service Event') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('service-events.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 gap-4">
                        <!-- Ostala polja (Category, Service Date, Next Service Date, Evid Number, User ID, Description, Cost) -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Category
                            </label>
                            <select name="category" id="category" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="pp_device">PP Device</option>
                                <option value="hydrant">Hydrant</option>
                            </select>
                        </div>

                        <div>
                            <label for="service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Service Date
                            </label>
                            <input type="date" name="service_date" id="service_date" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="next_service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Next Service Date
                            </label>
                            <input type="date" name="next_service_date" id="next_service_date" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="evid_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Evid Number
                            </label>
                            <input type="text" name="evid_number" id="evid_number" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                User ID
                            </label>
                            <input type="number" name="user_id" id="user_id" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <div>
                            <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Cost
                            </label>
                            <input type="number" step="0.01" name="cost" id="cost" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Odabir kompanije -->
                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select Company
                            </label>
                            <select id="company" name="company_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="">{{ __('Select a Company') }}</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dinamičko učitavanje lokacija za odabranu kompaniju -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select Locations
                            </label>
                            <div id="locations-container" class="mt-2 space-y-2">
                                <!-- Ovde će se dinamički učitavati checkboksevi za lokacije -->
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Please select a company to load locations.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('service-events.index') }}"
                           class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            Create Service Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript za dinamičko učitavanje lokacija -->
    <script>
        document.getElementById('company').addEventListener('change', function () {
            let companyId = this.value;
            let container = document.getElementById('locations-container');
            container.innerHTML = '';

            if (!companyId) {
                container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">Please select a company to load locations.</p>';
                return;
            }

            // Pozivamo API endpoint da dobijemo lokacije za odabranu kompaniju
            fetch('http://localhost:8000/api/companies/' + companyId + '/locations')
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.length === 0) {
                        container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">No locations found for this company.</p>';
                        return;
                    }

                    data.data.forEach(function(location) {
                        // Kreiramo checkbox i label za svaku lokaciju
                        let label = document.createElement('label');
                        label.className = "flex items-center space-x-2";

                        let checkbox = document.createElement('input');
                        checkbox.type = "checkbox";
                        checkbox.name = "locations[]";
                        checkbox.value = location.id;
                        checkbox.className = "form-checkbox h-4 w-4 text-blue-600";

                        let span = document.createElement('span');
                        span.className = "text-sm text-gray-700 dark:text-gray-300";
                        span.textContent = location.name + " - " + location.city;

                        label.appendChild(checkbox);
                        label.appendChild(span);
                        container.appendChild(label);
                    });
                })
                .catch(error => {
                    console.error('Error fetching locations:', error);
                    container.innerHTML = '<p class="text-sm text-red-500">Error loading locations.</p>';
                });
        });
    </script>
</x-app-layout>
