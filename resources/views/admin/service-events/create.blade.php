<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kreiraj Service Event') }}
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
                                Kategorija
                            </label>
                            <select name="category" id="category" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="pp_device">Aparati</option>
                                <option value="hydrant">Hidranti</option>
                            </select>
                        </div>

                        <div>
                            <label for="service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Datum Servisa
                            </label>
                            <input type="date" name="service_date" id="service_date" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="next_service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Datum Sledećeg Servisa (auto 6 meseci kasnije)
                            </label>
                            <input type="date" name="next_service_date" id="next_service_date" readonly
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 bg-gray-200 cursor-not-allowed focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="evid_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Evid Broj
                            </label>
                            <input type="text" name="evid_number" id="evid_number" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <input type="hidden" name="user_id" id="user_id" required value="{{auth()->id()}}">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Opis
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500"></textarea>
                        </div>

                        <div>
                            <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Troškovi
                            </label>
                            <input type="number" step="0.01" name="cost" id="cost" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Companies & Locations Section -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Izaberi Kompanije i Lokacije</h3>

                        <!-- Company Selection -->
                        <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2 mb-4">
                            <select id="company-selector" class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">{{ __('Izaberi kompaniju') }}</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }} ({{ $company->city }})</option>
                                @endforeach
                            </select>
                            <button type="button" id="add-company" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 whitespace-nowrap">
                                Dodaj Kompaniju
                            </button>
                        </div>

                        <!-- Global Controls -->
                        <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex flex-wrap gap-2 items-center">
                                <input type="text" id="global-search" placeholder="Pretraži sve lokacije..."
                                       class="flex-1 min-w-48 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm dark:bg-gray-600 dark:text-gray-200">
                                <button type="button" id="global-select-all" class="px-3 py-2 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">
                                    Selektuj sve
                                </button>
                                <button type="button" id="global-deselect-all" class="px-3 py-2 bg-gray-500 text-white rounded text-sm hover:bg-gray-600">
                                    Deselektuj sve
                                </button>
                                <span id="global-selected-count" class="px-3 py-2 bg-green-100 text-green-800 rounded text-sm">
                                    Izabrano: 0
                                </span>
                            </div>
                        </div>

                        <!-- Companies Container -->
                        <div id="companies-container" class="space-y-4 max-h-96 overflow-y-auto">
                            <!-- Dinamički dodati blokovi kompanija će se prikazivati ovde -->
                        </div>
                    </div>

                    <!-- Form Submit -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('service-events.index') }}"
                           class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                            Otkaži
                        </a>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                            Kreiraj Service Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Auto-calculate next_service_date
            document.getElementById('service_date').addEventListener('change', function () {
                let serviceDate = new Date(this.value);
                if (!isNaN(serviceDate.getTime())) {
                    serviceDate.setMonth(serviceDate.getMonth() + 6);
                    document.getElementById('next_service_date').value = serviceDate.toISOString().split('T')[0];
                }
            });

            // Global search and count functionality
            function updateGlobalSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.location-checkbox:checked');
                document.getElementById('global-selected-count').textContent = `Izabrano: ${checkedBoxes.length}`;
            }

            function globalSearch() {
                const searchTerm = document.getElementById('global-search').value.toLowerCase();
                const locationLabels = document.querySelectorAll('.location-item');

                locationLabels.forEach(label => {
                    const locationName = label.getAttribute('data-location-name');
                    if (locationName && locationName.includes(searchTerm)) {
                        label.style.display = 'flex';
                    } else {
                        label.style.display = 'none';
                    }
                });

                // Hide/show company blocks based on visible locations
                const companyBlocks = document.querySelectorAll('[id^="company-block-"]');
                companyBlocks.forEach(block => {
                    const visibleLocations = block.querySelectorAll('.location-item:not([style*="display: none"])');
                    const locationsContainer = block.querySelector('.locations-list');
                    if (visibleLocations.length > 0) {
                        block.style.display = 'block';
                    } else {
                        block.style.display = 'none';
                    }
                });
            }

            // Global controls
            document.getElementById('global-search').addEventListener('input', globalSearch);

            document.getElementById('global-select-all').addEventListener('click', function() {
                const visibleCheckboxes = document.querySelectorAll('.location-item:not([style*="display: none"]) .location-checkbox');
                visibleCheckboxes.forEach(cb => cb.checked = true);
                updateGlobalSelectedCount();
            });

            document.getElementById('global-deselect-all').addEventListener('click', function() {
                const visibleCheckboxes = document.querySelectorAll('.location-item:not([style*="display: none"]) .location-checkbox');
                visibleCheckboxes.forEach(cb => cb.checked = false);
                updateGlobalSelectedCount();
            });

            // 2. Add company and load locations
            document.getElementById('add-company').addEventListener('click', function () {
                let companySelector = document.getElementById('company-selector');
                let companyId = companySelector.value;
                let companyName = companySelector.options[companySelector.selectedIndex].text;

                if (!companyId) {
                    alert("Molimo izaberite kompaniju");
                    return;
                }

                if (document.getElementById('company-block-' + companyId)) {
                    alert("Ova kompanija je već dodana");
                    return;
                }

                let container = document.getElementById('companies-container');
                let companyBlock = document.createElement('div');
                companyBlock.id = 'company-block-' + companyId;
                companyBlock.className = 'border rounded-lg p-4 bg-gray-50 dark:bg-gray-700';
                companyBlock.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">${companyName}</h4>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="company-select-all px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600" data-company-id="${companyId}">
                                Selektuj sve
                            </button>
                            <button type="button" class="company-collapse px-2 py-1 bg-gray-500 text-white rounded text-xs hover:bg-gray-600" data-company-id="${companyId}">
                                Sakrij
                            </button>
                            <button type="button" class="remove-company px-2 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600" data-company-id="${companyId}">
                                Ukloni
                            </button>
                        </div>
                    </div>
                    <div class="company-locations-container">
                        <div class="mb-3">
                            <input type="text" class="search-locations w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded text-sm dark:bg-gray-600 dark:text-gray-200"
                                   placeholder="Pretraži lokacije u ovoj kompaniji..." data-company-id="${companyId}">
                        </div>
                        <div class="locations-container">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Učitavam lokacije...</p>
                        </div>
                    </div>
                `;
                container.appendChild(companyBlock);

                // Fetch locations via AJAX
                fetch('/api/companies/' + companyId + '/locations')
                    .then(response => response.json())
                    .then(data => {
                        let locations = data.data ? data.data : data;
                        let locationsContainer = companyBlock.querySelector('.locations-container');

                        if (!locations.length) {
                            locationsContainer.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">Nema lokacija za ovu kompaniju.</p>';
                            return;
                        }

                        let html = `<div class="locations-list grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-64 overflow-y-auto">`;
                        locations.forEach(function(location) {
                            html += `
                                <label class="location-item flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded cursor-pointer"
                                       data-location-name="${(location.name + ' ' + location.city).toLowerCase()}">
                                    <input type="checkbox" name="locations[]" value="${location.id}"
                                           class="location-checkbox form-checkbox h-4 w-4 text-blue-600">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">${location.name} - ${location.city}</span>
                                </label>
                            `;
                        });
                        html += `</div>`;
                        locationsContainer.innerHTML = html;

                        // Add event listeners for new checkboxes
                        const newCheckboxes = companyBlock.querySelectorAll('.location-checkbox');
                        newCheckboxes.forEach(cb => {
                            cb.addEventListener('change', updateGlobalSelectedCount);
                        });

                        updateGlobalSelectedCount();
                    })
                    .catch(error => {
                        companyBlock.querySelector('.locations-container').innerHTML = '<p class="text-sm text-red-500">Greška pri učitavanju lokacija.</p>';
                        console.error('Error fetching locations:', error);
                    });

                // Reset selector
                companySelector.value = '';
            });

            // 3. Delegated listeners for various company actions
            document.getElementById('companies-container').addEventListener('input', function(e) {
                if (e.target.classList.contains('search-locations')) {
                    let block = e.target.closest('[id^="company-block-"]');
                    let term = e.target.value.toLowerCase();
                    let locationItems = block.querySelectorAll('.location-item');

                    locationItems.forEach(item => {
                        let name = item.getAttribute('data-location-name');
                        if (name && name.includes(term)) {
                            item.style.display = 'flex';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }
            });

            document.getElementById('companies-container').addEventListener('click', function(e) {
                // Remove company
                if (e.target.classList.contains('remove-company')) {
                    let companyId = e.target.getAttribute('data-company-id');
                    let block = document.getElementById('company-block-' + companyId);
                    if (block) {
                        block.remove();
                        updateGlobalSelectedCount();
                    }
                }

                // Company select all
                if (e.target.classList.contains('company-select-all')) {
                    let companyId = e.target.getAttribute('data-company-id');
                    let block = document.getElementById('company-block-' + companyId);
                    let visibleCheckboxes = block.querySelectorAll('.location-item:not([style*="display: none"]) .location-checkbox');
                    let allChecked = Array.from(visibleCheckboxes).every(cb => cb.checked);

                    visibleCheckboxes.forEach(cb => cb.checked = !allChecked);
                    e.target.textContent = allChecked ? 'Selektuj sve' : 'Deselektuj sve';
                    updateGlobalSelectedCount();
                }

                // Company collapse
                if (e.target.classList.contains('company-collapse')) {
                    let companyId = e.target.getAttribute('data-company-id');
                    let block = document.getElementById('company-block-' + companyId);
                    let container = block.querySelector('.company-locations-container');

                    if (container.style.display === 'none') {
                        container.style.display = 'block';
                        e.target.textContent = 'Sakrij';
                    } else {
                        container.style.display = 'none';
                        e.target.textContent = 'Prikaži';
                    }
                }
            });

            // Initial count update
            updateGlobalSelectedCount();
        });
    </script>
</x-app-layout>
