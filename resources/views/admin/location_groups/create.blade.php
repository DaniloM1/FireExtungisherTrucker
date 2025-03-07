<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Location Group') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('location-groups.store') }}">
                    @csrf

                    <!-- Basic Fields -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Group Name
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- Companies & Locations Section -->
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Select Companies & Locations</h3>
                        <div class="flex items-center space-x-2">
                            <select id="company-selector" class="block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                <option value="">{{ __('Select a Company') }}</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }} ({{ $company->city }})</option>
                                @endforeach
                            </select>
                            <button type="button" id="add-company" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Add Company
                            </button>
                        </div>
                        <div id="companies-container" class="mt-4 space-y-4">
                            <!-- Dinamički dodati blokovi kompanija će se prikazivati ovdje -->
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
                            Create Location Group
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript za dinamičko upravljanje kompanijama i lokacijama -->
    <script>
        // Listener za dugme "Add Company"
        document.getElementById('add-company').addEventListener('click', function () {
            let companySelector = document.getElementById('company-selector');
            let companyId = companySelector.value;
            let companyName = companySelector.options[companySelector.selectedIndex].text;
            if (!companyId) {
                alert("Please select a company");
                return;
            }

            // Provjera da li je kompanija već dodata
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

            // Učitavanje lokacija za odabranu kompaniju putem AJAX-a
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
