<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Location') }}
        </h2>
    </x-slot>

    <!-- Poruke o uspjehu i greškama -->
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
                    <h3 class="text-lg font-semibold mb-4">{{ __('New Location Form') }}</h3>
                    <form method="POST" action="{{ route('locations.store', ['company' => $company->id]) }}">
                        @csrf

                        <!-- Prikaz kompanije (read-only) -->
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Company') }}
                            </label>
                            <input type="text" name="company_name" id="company_name" value="{{ $company->name }}" readonly
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                            <!-- Skriveni input za company_id -->
                            <input type="hidden" name="company_id" value="{{ $company->id }}">
                        </div>

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Location Name') }}
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="off" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Address Field -->
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Address') }}
                            </label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" autocomplete="off" required
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Latitude Field -->
                        <div class="mb-4">
                            <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Latitude') }}
                            </label>
                            <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" autocomplete="off"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Longitude Field -->
                        <div class="mb-4">
                            <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('Longitude') }}
                            </label>
                            <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" autocomplete="off"
                                   class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Submit i Cancel dugmad -->
                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Create Location') }}
                            </button>
                            <a href="{{ route('companies.locations', ['company' => $company->id]) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
