<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Service Event') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('service-events.update', $serviceEvent->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- Basic Fields -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kategorija
                            </label>
                            <select name="category" id="category" required
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                                <option value="pp_device" {{ $serviceEvent->category == 'pp_device' ? 'selected' : '' }}>Aparati</option>
                                <option value="hydrant"   {{ $serviceEvent->category == 'hydrant'   ? 'selected' : '' }}>Hidranti</option>
                            </select>
                        </div>
                        <div>
                            <label for="service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Datum Servisa
                            </label>
                            <input type="date" name="service_date" id="service_date"
                                   value="{{ $serviceEvent->service_date->format('Y-m-d') }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="next_service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Datum Sledećeg Servisa (auto 6 meseci kasnije)
                            </label>
                            <input type="date" name="next_service_date" id="next_service_date"
                                   value="{{ $serviceEvent->next_service_date->format('Y-m-d') }}"
                                   readonly
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 bg-gray-200 cursor-not-allowed focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="evid_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Evid Broj
                            </label>
                            <input type="text" name="evid_number" id="evid_number"
                                   value="{{ $serviceEvent->evid_number }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <input type="hidden" name="user_id" id="user_id" required value="{{auth()->id()}}">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Opis
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">{{ $serviceEvent->description }}</textarea>
                        </div>
                        <div>
                            <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Troškovi
                            </label>
                            <input type="number" step="0.01" name="cost" id="cost"
                                   value="{{ $serviceEvent->cost }}"
                                   required
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
                            <!-- Dinamički dodati blokovi kompanija i lokacija idu ovde -->
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
                            Sačuvaj Izmene
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const companiesDict = @json($companies->keyBy('id'));
        // --- Automatski sledeći servis ---
        document.getElementById('service_date').addEventListener('change', function () {
            let serviceDate = new Date(this.value);
            if (!isNaN(serviceDate.getTime())) {
                serviceDate.setMonth(serviceDate.getMonth() + 6);
                document.getElementById('next_service_date').value = serviceDate.toISOString().split('T')[0];
            }
        });

        // --- Inicijalno napuni kompanije iz eventa ---
        document.addEventListener('DOMContentLoaded', function () {
            const companiesInEvent = @json($serviceEvent->locations->groupBy('company_id')->keys());
            const locationsInEvent = @json($serviceEvent->locations->pluck('id')->toArray());
            const allLocations = @json($allLocations);

            companiesInEvent.forEach(companyId => {
                addCompanyBlock(companyId, true);
            });

            function addCompanyBlock(companyId, isInit = false) {
                // Prevent duplicate blocks
                if (document.getElementById('company-block-' + companyId)) return;

                // Find company in companies
                let company = companiesDict[companyId];

                if (!company) return;

                let companyName = `${company.name} (${company.city})`;
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

                // Load locations (from allLocations, not AJAX)
                let companyLocations = allLocations.filter(loc => loc.company_id == companyId);
                let locationsContainer = companyBlock.querySelector('.locations-container');

                if (!companyLocations.length) {
                    locationsContainer.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">Nema lokacija za ovu kompaniju.</p>';
                } else {
                    let html = `<div class="locations-list grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 max-h-64 overflow-y-auto">`;
                    companyLocations.forEach(location => {
                        let checked = '';
                        if ((isInit && locationsInEvent.includes(location.id)) ||
                            (!isInit && locationsInEvent.includes(location.id))) checked = 'checked';
                        html += `
                            <label class="location-item flex items-center space-x-2 p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded cursor-pointer"
                                data-location-name="${(location.name + ' ' + location.city).toLowerCase()}">
                                <input type="checkbox" name="locations[]" value="${location.id}"
                                    class="location-checkbox form-checkbox h-4 w-4 text-blue-600" ${checked}>
                                <span class="text-sm text-gray-700 dark:text-gray-300">${location.name} - ${location.city}</span>
                            </label>
                        `;
                    });
                    html += `</div>`;
                    locationsContainer.innerHTML = html;
                }
                // Add listeners for checkboxes
                const newCheckboxes = companyBlock.querySelectorAll('.location-checkbox');
                newCheckboxes.forEach(cb => {
                    cb.addEventListener('change', updateGlobalSelectedCount);
                });

                updateGlobalSelectedCount();
            }

            // --- Dodaj kompaniju AJAX ---
            document.getElementById('add-company').addEventListener('click', function () {
                let companySelector = document.getElementById('company-selector');
                let companyId = companySelector.value;
                if (!companyId) { alert('Izaberi kompaniju'); return; }
                addCompanyBlock(companyId, false);
                companySelector.value = '';
            });

            // --- Pretraga globalna ---
            function updateGlobalSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.location-checkbox:checked');
                document.getElementById('global-selected-count').textContent = `Izabrano: ${checkedBoxes.length}`;
            }
            window.updateGlobalSelectedCount = updateGlobalSelectedCount; // for company blocks

            document.getElementById('global-search').addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
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
                const companyBlocks = document.querySelectorAll('[id^=\"company-block-\"]');
                companyBlocks.forEach(block => {
                    const visibleLocations = block.querySelectorAll('.location-item:not([style*=\"display: none\"])');
                    if (visibleLocations.length > 0) block.style.display = 'block';
                    else block.style.display = 'none';
                });
            });

            // --- Global Select/Deselect ---
            document.getElementById('global-select-all').addEventListener('click', function() {
                const visibleCheckboxes = document.querySelectorAll('.location-item:not([style*=\"display: none\"]) .location-checkbox');
                visibleCheckboxes.forEach(cb => cb.checked = true);
                updateGlobalSelectedCount();
            });

            document.getElementById('global-deselect-all').addEventListener('click', function() {
                const visibleCheckboxes = document.querySelectorAll('.location-item:not([style*=\"display: none\"]) .location-checkbox');
                visibleCheckboxes.forEach(cb => cb.checked = false);
                updateGlobalSelectedCount();
            });

            // --- Delegated events for company block ---
            document.getElementById('companies-container').addEventListener('input', function(e) {
                if (e.target.classList.contains('search-locations')) {
                    let block = e.target.closest('[id^=\"company-block-\"]');
                    let term = e.target.value.toLowerCase();
                    let locationItems = block.querySelectorAll('.location-item');
                    locationItems.forEach(item => {
                        let name = item.getAttribute('data-location-name');
                        if (name && name.includes(term)) item.style.display = 'flex';
                        else item.style.display = 'none';
                    });
                }
            });

            document.getElementById('companies-container').addEventListener('click', function(e) {
                // Remove company
                if (e.target.classList.contains('remove-company')) {
                    let companyId = e.target.getAttribute('data-company-id');
                    let block = document.getElementById('company-block-' + companyId);
                    if (block) { block.remove(); updateGlobalSelectedCount(); }
                }

                // Company select all
                if (e.target.classList.contains('company-select-all')) {
                    let companyId = e.target.getAttribute('data-company-id');
                    let block = document.getElementById('company-block-' + companyId);
                    let visibleCheckboxes = block.querySelectorAll('.location-item:not([style*=\"display: none\"]) .location-checkbox');
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
                        container.style.display = 'block'; e.target.textContent = 'Sakrij';
                    } else {
                        container.style.display = 'none'; e.target.textContent = 'Prikaži';
                    }
                }
            });

            // Count on check change
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('location-checkbox')) {
                    updateGlobalSelectedCount();
                }
            });

            // Initial
            updateGlobalSelectedCount();
        });
    </script>
</x-app-layout>
