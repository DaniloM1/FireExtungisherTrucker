<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dodaj novi hidrantski uređaj za') }} {{ $location->name }}
        </h2>
    </x-slot>

    <!-- Prikaz grešaka validacije -->
    <div class="max-w-7xl mx-auto mt-4">
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Forma za dodavanje hidranta -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('locations.hydrants.store', $location->id) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="serial_number" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Serijski broj') }}
                        </label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="type" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Tip') }}
                        </label>
                        <input type="text" name="type" id="type" value="{{ old('type') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="model" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Model') }}
                        </label>
                        <input type="text" name="model" id="model" value="{{ old('model') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="manufacturer" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Proizvođač') }}
                        </label>
                        <input type="text" name="manufacturer" id="manufacturer" value="{{ old('manufacturer') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="manufacture_date" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Datum proizvodnje') }}
                        </label>
                        <input type="date" name="manufacture_date" id="manufacture_date" value="{{ old('manufacture_date') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="next_service_date" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Datum sledećeg servisa') }}
                        </label>
                        <input type="date" name="next_service_date" id="next_service_date" value="{{ old('next_service_date') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="hvp" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Datum HVP') }}
                        </label>
                        <input type="date" name="hvp" id="hvp" value="{{ old('hvp') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="position" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Pozicija') }}
                        </label>
                        <input type="text" name="position" id="position" value="{{ old('position') }}"
                               placeholder="npr. Hodnik A3, Ispred ulaza"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="static_pressure" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Statički pritisak') }}
                        </label>
                        <input type="number" step="0.1" name="static_pressure" id="static_pressure" value="{{ old('static_pressure') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="dynamic_pressure" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Dinamički pritisak') }}
                        </label>
                        <input type="number" step="0.1" name="dynamic_pressure" id="dynamic_pressure" value="{{ old('dynamic_pressure') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="flow" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Protok (l/min)') }}
                        </label>
                        <input type="number" step="0.1" name="flow" id="flow" value="{{ old('flow') }}"
                               class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="status" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Status') }}
                        </label>
                        <select name="status" id="status"
                                class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Aktivan') }}</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Neaktivan') }}</option>
                            <option value="needs_service" {{ old('status') == 'needs_service' ? 'selected' : '' }}>{{ __('Za servis') }}</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('locations.hydrants.index', $location->id) }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                        {{ __('Otkaži') }}
                    </a>
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('Sačuvaj hidrantski uređaj') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
