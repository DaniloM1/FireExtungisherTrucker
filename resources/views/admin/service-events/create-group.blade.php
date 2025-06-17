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

                    <!-- Service Event Basic Fields -->
                    <div class="grid grid-cols-1 gap-4">
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
                            <input type="date" name="next_service_date" id="next_service_date"  readonly
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
                            <input type="hidden" name="user_id" id="user_id" required value="{{auth()->id()}}">


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
                    </div>

                    <!-- Companies & Locations Section -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Kompanije i lokacije (iz grupe)</h3>


                        @if(!empty($selectedCompanyIds))
                            @foreach($companies->whereIn('id', $selectedCompanyIds) as $company)
                                @php
                                    $companyLocations = $allLocations
                                        ->where('company_id', $company->id)
                                        ->whereIn('id', $selectedLocationIds);
                                @endphp
                                <div class="border p-4 rounded-md bg-gray-50 dark:bg-gray-700 mb-4" id="company-block-{{ $company->id }}">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                                            {{ $company->name }} ({{ $company->city }})
                                        </h4>
                                    </div>
                                    <div class="locations-container">
                                        @forelse($companyLocations as $loc)
                                            <input type="hidden" name="locations[]" value="{{ $loc->id }}">
                                            <label class="flex items-center gap-2 mb-1 opacity-70">
                                                <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600" checked disabled>
                                                <span class="text-sm text-gray-700 dark:text-gray-300">
                            {{ $loc->name }} - {{ $loc->city }}
                        </span>
                                            </label>
                                        @empty
                                            <span class="text-gray-400 dark:text-gray-500 text-sm">Nema lokacija.</span>
                                        @endforelse
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- Info poruka --}}
                        <div class="text-xs text-gray-500 dark:text-gray-400 italic mt-2">
                            Lokacije i kompanije su definisane grupom i ne mogu se menjati.
                        </div>
                    </div>


                    <!-- Form Submit -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('location-groups.index') }}"
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

    <!-- JavaScript za dinamičko učitavanje i upravljanje kompanijama i lokacijama -->
    <!-- Ostali deo koda ostaje nepromenjen -->

    <!-- Postavi listener odmah nakon učitavanja stranice -->
    <script>
        // Listener za promenu service_date
        document.getElementById('service_date').addEventListener('change', function () {
            let serviceDate = new Date(this.value);
            if (!isNaN(serviceDate.getTime())) { // Provera da li je validan datum
                serviceDate.setMonth(serviceDate.getMonth() + 6); // Dodaj 6 meseci
                document.getElementById('next_service_date').value = serviceDate.toISOString().split('T')[0]; // Format u yyyy-mm-dd
            }
        });

        // Listener za dugme "Add Companyf"
        document.getElementById('add-company').addEventListener('click', function () {
            let companySelector = document.getElementById('company-selector');
            let companyId = companySelector.value;
            let companyName = companySelector.options[companySelector.selectedIndex].text;
            if (!companyId) {
                alert("Please select a company");
                return;
            }

            // Proveri da li je kompanija već dodata
            if (document.getElementById('company-block-' + companyId)) {
                alert("This company is already added");
                return;
            }

            let container = document.getElementById('companies-container');
            let companyBlock = document.createElement('div');
            companyBlock.id = 'company-block-' + companyId;
            companyBlock.className = 'border p-4 rounded-md bg-gray-50 dark:bg-gray-700';
            companyBlock.innerHTML = `
            <div class="flex justify-between items-center mb-2">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">${companyName}</h4>
                <button type="button" class="text-red-600 dark:text-red-400 hover:underline remove-company" data-company-id="${companyId}">
                    Remove
                </button>
            </div>
            <div class="locations-container">
                <p class="text-sm text-gray-500 dark:text-gray-400">Loading locations...</p>
            </div>
        `;
            container.appendChild(companyBlock);

            // Učitaj lokacije za odabranu kompaniju putem AJAX-a
            fetch('/api/companies/' + companyId + '/locations')
                .then(response => response.json())
                .then(data => {
                    let locations = data.data ? data.data : data;
                    let locationsContainer = companyBlock.querySelector('.locations-container');
                    if (locations.length === 0) {
                        locationsContainer.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">No locations found for this company.</p>';
                        return;
                    }
                    let html = '';
                    locations.forEach(function(location) {
                        html += `
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="locations[]" value="${location.id}" class="form-checkbox h-4 w-4 text-blue-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">${location.name} - ${location.city}</span>
                        </label>
                    `;
                    });
                    locationsContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error fetching locations:', error);
                    companyBlock.querySelector('.locations-container').innerHTML = '<p class="text-sm text-red-500">Error loading locations.</p>';
                });
        });

        // Uklanjanje bloka kompanije
        document.getElementById('companies-container').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-company')) {
                let companyId = e.target.getAttribute('data-company-id');
                let block = document.getElementById('company-block-' + companyId);
                if (block) block.remove();
            }
        });
    </script>

</x-app-layout>
