<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Device to Group') }}: {{ $group->name }}
        </h2>
    </x-slot>

    <!-- Poruke o greškama -->
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

    <!-- Forma za odabir uređaja -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('groups.store-device', $group->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="device_id" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                        {{ __('Select Device') }}
                    </label>
                    <select name="device_id" id="device_id" required
                            class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                        <option value="">{{ __('-- Choose a Device --') }}</option>
                        @foreach($devices as $device)
                            <option value="{{ $device->id }}">
                                {{ $device->serial_number }} - {{ $device->model }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('groups.show', $group->id) }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('Add Device') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
