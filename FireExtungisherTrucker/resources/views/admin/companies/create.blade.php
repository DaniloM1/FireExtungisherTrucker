<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Company') }}
        </h2>
    </x-slot>

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
                            <label for="maticni_brojs" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
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

                        <!-- Address Field -->

                        <!-- City Field (dinamičko popunjavanje putem API-ja) -->
{{--                        <div class="mb-4">--}}
{{--                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">--}}
{{--                                {{ __('City') }}--}}
{{--                            </label>--}}
{{--                            <select name="city" id="city" required--}}
{{--                                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">--}}
{{--                                <option value="">{{ __('Select City') }}</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}

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

    <!-- JavaScript za popunjavanje gradova putem API-ja -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetchCities();
        });

        function fetchCities() {
            // Promenite URL ispod na stvarni endpoint koji vraća gradove u Srbiji
            fetch('/api/cities')
                .then(response => response.json())
                .then(data => {
                    const citySelect = document.getElementById('city');
                    // Očekuje se da API vraća niz objekata sa poljima 'id' i 'name'
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching cities:', error);
                });
        }
    </script>
</x-app-layout>
