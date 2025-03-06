<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Company') }}
        </h2>
    </x-slot>
    <style>
        #city-suggestions {
            position: absolute;
            width: 100%;
            max-height: 200px; /* Ograničava visinu */
            overflow-y: auto; /* Omogućava skrolovanje ako ima previše opcija */
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            z-index: 50; /* Postavlja na vrh */
        }

    </style>
    <!-- Poruke o uspehu i greškama -->
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
    </div>

    <!-- Glavni sadržaj stranice -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <h3 class="text-lg font-semibold mb-4">{{ __('New Company Form') }}</h3>
                    <form method="POST" action="{{ route('companies.store') }}">
                        @csrf

                        <!-- Company Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Company Name') }}
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Email') }}
                            </label>
                            <input type="email" name="contact_email" id="email" value="{{ old('contact_email') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Phone Field -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Phone') }}
                            </label>
                            <input type="text" name="contact_phone" id="phone" value="{{ old('contact_phone') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="pib" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('PIB') }}
                            </label>
                            <input type="number" name="pib" id="pib" value="{{ old('pib') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Address') }}
                            </label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="maticni_broj" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Maticni Broj') }}
                            </label>
                            <input type="text" name="maticni_broj" id="maticni_broj" value="{{ old('maticni_broj') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div class="mb-4">
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Websajt') }}
                            </label>
                            <input type="text" name="website" id="website" value="{{ old('website') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- City Field sa pretragom -->
                        <div class="mb-4 relative">
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('City') }}
                            </label>
                            <input type="text" id="city" name="city" placeholder="{{ __('Type at least 3 letters') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500" autocomplete="off">
                            <!-- Kontejner za sugestije -->
                            <ul id="city-suggestions" class="absolute z-10 w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md mt-1 hidden"></ul>
                        </div>

                        <!-- Submit i Cancel dugmad -->
                        <div class="flex gap-4">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create Company') }}
                            </button>
                            <a href="{{ route('companies.index') }}"
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript za pretragu gradova -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cityInput = document.getElementById('city');
            const suggestionsList = document.getElementById('city-suggestions');

            let searchTimeout = null;

            cityInput.addEventListener('input', function () {
                const query = cityInput.value.trim();
                clearTimeout(searchTimeout);

                if (query.length < 3) {
                    suggestionsList.classList.add('hidden');
                    suggestionsList.innerHTML = '';
                    return;
                }

                // Delay pretrage radi optimizacije
                searchTimeout = setTimeout(() => {
                    fetch(`/api/cities/search?query=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsList.innerHTML = '';

                            if (data.cities && data.cities.length > 0) {
                                data.cities.forEach(city => {
                                    const li = document.createElement('li');
                                    li.textContent = city.name;
                                    li.classList.add('cursor-pointer', 'px-4', 'py-2', 'hover:bg-gray-200', 'dark:hover:bg-gray-600', 'border-b', 'last:border-none');
                                    li.addEventListener('click', function () {
                                        cityInput.value = city.name;
                                        suggestionsList.innerHTML = '';
                                        suggestionsList.classList.add('hidden');
                                    });
                                    suggestionsList.appendChild(li);
                                });

                                // Osiguraj da se predlozi ispravno prikazuju
                                suggestionsList.style.left = `${cityInput.offsetLeft}px`;
                                suggestionsList.style.top = `${cityInput.offsetTop + cityInput.offsetHeight}px`;
                                suggestionsList.classList.remove('hidden');
                            } else {
                                suggestionsList.classList.add('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Error searching cities:', error);
                        });
                }, 200); // 200ms delay
            });

            // Sakrivanje liste kada korisnik klikne van nje
            document.addEventListener('click', function (e) {
                if (!cityInput.contains(e.target) && !suggestionsList.contains(e.target)) {
                    suggestionsList.classList.add('hidden');
                }
            });
        });

    </script>


</x-app-layout>
