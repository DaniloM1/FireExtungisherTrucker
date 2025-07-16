<div>
    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Izaberi Kompaniju i Lokaciju</h3>
    <div class="flex items-center space-x-2">
        <select id="company-selector" class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
            <option value="">{{ __('Izaberi Kompaniju') }}</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->name }} ({{ $company->city }})</option>
            @endforeach
        </select>
        <button type="button" id="add-company" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
            Add Company
        </button>
    </div>

    <div id="companies-container" class="mt-4 space-y-4">
        @php
            $existingCompanies = $selectedLocationsGrouped ?? collect([]);
        @endphp
        @foreach($existingCompanies as $companyId => $locations)
            @php
                $company = $locations->first()->company;
            @endphp
            <div id="company-block-{{ $companyId }}" class="border p-4 rounded-md bg-gray-50 dark:bg-gray-700">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                        {{ $company->name }} ({{ $company->city }})
                    </h4>
                    <button type="button" class="text-red-600 dark:text-red-400 hover:underline remove-company" data-company-id="{{ $companyId }}">
                        Remove
                    </button>
                </div>
                <div class="locations-container">
                    @foreach($locations as $location)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="locations[]" value="{{ $location->id }}" class="form-checkbox h-4 w-4 text-blue-600" checked>
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $location->name }} - {{ $location->city }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.getElementById('add-company').addEventListener('click', function () {
            const companySelector = document.getElementById('company-selector');
            const companyId = companySelector.value;
            const companyName = companySelector.options[companySelector.selectedIndex].text;

            if (!companyId) {
                alert("Please select a company");
                return;
            }
            if (document.getElementById('company-block-' + companyId)) {
                alert("This company is already added");
                return;
            }

            const container = document.getElementById('companies-container');
            const companyBlock = document.createElement('div');
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

            fetch('/api/companies/' + companyId + '/locations')
                .then(response => response.json())
                .then(data => {
                    const locations = data.data ? data.data : data;
                    const locationsContainer = companyBlock.querySelector('.locations-container');

                    if (locations.length === 0) {
                        locationsContainer.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">No locations found for this company.</p>';
                        return;
                    }

                    let html = '';
                    locations.forEach(location => {
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

        document.getElementById('companies-container').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-company')) {
                const companyId = e.target.getAttribute('data-company-id');
                const block = document.getElementById('company-block-' + companyId);
                if (block) block.remove();
            }
        });
    </script>
</div>
