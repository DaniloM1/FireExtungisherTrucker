<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Device for') }} {{ $location->name }}
        </h2>
    </x-slot>

    <!-- Prikaz grešaka validacije -->
    <div class="max-w-7xl mx-auto mt-4">
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

    <!-- Forma za dodavanje uređaja -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('locations.devices.store', $location->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="serial_number" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Serial Number') }}
                    </label>
                    <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" required
                           class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="model" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Model') }}
                    </label>
                    <input type="text" name="model" id="model" value="{{ old('model') }}" required
                           class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="manufacturer" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Manufacturer') }}
                    </label>
                    <input type="text" name="manufacturer" id="manufacturer" value="{{ old('manufacturer') }}" required
                           class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="manufacture_date" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Manufacture Date') }}
                    </label>
                    <input type="date" name="manufacture_date" id="manufacture_date" value="{{ old('manufacture_date') }}"
                           class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="next_service_date" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Expires at') }}
                    </label>
                    <input type="date" name="next_service_date" id="next_service_date" value="{{ old('next_service_date') }}"
                           class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="position" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Position') }}
                    </label>
                    <input type="text" name="position" id="position" value="{{ old('position') }}"
                           placeholder="{{ __('Enter device position (e.g., Room 101, 3rd floor)') }}"
                           class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Status') }}
                    </label>
                    <select name="status" id="status" required
                            class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        <option value="needs_service" {{ old('status') == 'needs_service' ? 'selected' : '' }}>{{ __('Needs Service') }}</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="group_id" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Group') }}
                    </label>
                    <select name="group_id" id="group_id"
                            class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                        <option value="">{{ __('None') }}</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('locations.devices.index', $location->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('Save Device') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
