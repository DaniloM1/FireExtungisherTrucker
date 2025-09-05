<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Location Check') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('location_checks.store') }}">
                @csrf

                <!-- Company select -->
                <div class="mb-4">
                    <label for="company_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Kompanija') }}
                    </label>
                    <select name="company_id" id="company_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                <option value="">{{ __('-- Izaberi kompaniju --') }}</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}"
                        {{ (string)old('company_id', request('company_id')) === (string)$company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
            
                </div>

                <!-- Location select, options će se menjati JS-om na osnovu kompanije -->
                <div class="mb-4">
                    <label for="location_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Lokacija') }}
                    </label>
                    <select name="location_id" id="location_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">{{ __('-- Prvo izaberi kompaniju --') }}</option>
                        {{-- Opcije se učitavaju JS-om --}}
                    </select>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Naziv inspekcije/testa') }}
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" />
                </div>

                <!-- Type -->
                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Tip') }}
                    </label>
                    <select name="type" id="type" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        <option value="inspection" {{ old('type') == 'inspection' ? 'selected' : '' }}>{{ __('Inspekcija') }}</option>
                        <option value="test" {{ old('type') == 'test' ? 'selected' : '' }}>{{ __('Test') }}</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Opis') }}
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="last_performed_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Datum poslednje inspekcije') }}
                        </label>
                        <input type="date" name="last_performed_date" id="last_performed_date" value="{{ old('last_performed_date') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <!-- Izmena: ispod last_performed_date inputa -->
                    <p id="autoNextDueInfo" class="text-sm text-gray-500 dark:text-gray-400 mt-1 italic">
                        Sledeći termin će biti automatski izračunat na osnovu poslednjeg datuma i tipa.
                    </p>

                    <!-- Script za automatsko računanje sledećeg termina -->
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const lastDateInput = document.getElementById('last_performed_date');
                            const nextDueInput = document.getElementById('next_due_date');
                            const typeSelect = document.getElementById('type');

                            function updateNextDueDate() {
                                const lastDateVal = lastDateInput.value;
                                const typeVal = typeSelect.value;
                                if (!lastDateVal || !typeVal) {
                                    nextDueInput.value = '';
                                    return;
                                }

                                let yearsToAdd = (typeVal === 'inspection') ? 3 : 5;

                                const lastDate = new Date(lastDateVal);
                                if (isNaN(lastDate)) {
                                    nextDueInput.value = '';
                                    return;
                                }

                                lastDate.setFullYear(lastDate.getFullYear() + yearsToAdd);

                                const yyyy = lastDate.getFullYear();
                                const mm = String(lastDate.getMonth() + 1).padStart(2, '0');
                                const dd = String(lastDate.getDate()).padStart(2, '0');

                                nextDueInput.value = `${yyyy}-${mm}-${dd}`;
                            }

                            lastDateInput.addEventListener('change', updateNextDueDate);
                            typeSelect.addEventListener('change', updateNextDueDate);
                        });
                    </script>


                </div>

                <!-- Inspector -->
                <div class="mb-4">
                    <label for="inspector_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Inspektor') }}
                    </label>
                    <select name="inspector_id" id="inspector_id"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        <option value="">{{ __('-- Izaberi inspektora --') }}</option>
                        @foreach ($inspectors as $inspector)
                            <option value="{{ $inspector->id }}" {{ old('inspector_id') == $inspector->id ? 'selected' : '' }}>
                                {{ $inspector->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Kreiraj') }}
                    </button>
                    <a href="{{ route('location_checks.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Otkaži') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const companySelect = document.getElementById('company_id');
            const locationSelect = document.getElementById('location_id');

            companySelect.addEventListener('change', function () {
                const companyId = this.value;
                locationSelect.innerHTML = '<option value="">{{ __("Učitavanje...") }}</option>';
                if (!companyId) {
                    locationSelect.innerHTML = '<option value="">{{ __("Prvo izaberi kompaniju") }}</option>';
                    return;
                }

                fetch(`/api/companies/${companyId}/locations`)
                    .then(response => response.json())
                    .then(data => {
                        locationSelect.innerHTML = '<option value="">{{ __("Izaberi lokaciju") }}</option>';
                        data.forEach(loc => {
                            const opt = document.createElement('option');
                            opt.value = loc.id;
                            opt.textContent = loc.name;
                            locationSelect.appendChild(opt);
                        });
                    })
                    .catch(() => {
                        locationSelect.innerHTML = '<option value="">{{ __("Greška pri učitavanju") }}</option>';
                    });
            });
        });
document.addEventListener('DOMContentLoaded', function () {
    const companySelect  = document.getElementById('company_id');
    const locationSelect = document.getElementById('location_id');

    // Prefill vrednosti (od old() ili od query parametara)
    const prefillCompanyId  = "{{ (string)old('company_id', request('company_id')) }}";
    const prefillLocationId = "{{ (string)old('location_id', request('location_id')) }}";

    // Funkcija koja popunjava <select> lokacija za zadatu kompaniju
    async function loadLocations(companyId, selectedLocationId = null) {
        locationSelect.innerHTML = '<option value="">{{ @__("Učitavanje...") }}</option>';

        if (!companyId) {
            locationSelect.innerHTML = '<option value="">{{ @__("Prvo izaberi kompaniju") }}</option>';
            return;
        }

        try {
            const res  = await fetch(`/api/companies/${companyId}/locations`);
            const data = await res.json();

            // Napuni opcije
            locationSelect.innerHTML = '<option value="">{{ @__("Izaberi lokaciju") }}</option>';

            data.forEach(loc => {
                const opt = document.createElement('option');
                opt.value = String(loc.id);
                opt.textContent = loc.name;
                locationSelect.appendChild(opt);
            });

            // Ako imamo preselektovanu lokaciju, setuj je
            if (selectedLocationId) {
                locationSelect.value = String(selectedLocationId);
            }
        } catch (e) {
            locationSelect.innerHTML = '<option value="">{{ @__("Greška pri učitavanju") }}</option>';
        }
    }

    // Ako smo stigli sa prosleđenom kompanijom, odmah je postavi i učitaj lokacije.
    if (prefillCompanyId) {
        companySelect.value = String(prefillCompanyId);
        loadLocations(prefillCompanyId, prefillLocationId);
    }

    // Inače se oslanjamo na postojeći "change" handler da učita lokacije dinamički
    companySelect.addEventListener('change', function () {
        loadLocations(this.value, null);
    });
});
</script>

  

</x-app-layout>
