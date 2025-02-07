<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Device Details') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto mt-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <div class="mb-4">
                <strong>{{ __('Serial Number:') }}</strong> {{ $device->serial_number }}
            </div>
            <div class="mb-4">
                <strong>{{ __('Model:') }}</strong> {{ $device->model }}
            </div>
            <div class="mb-4">
                <strong>{{ __('Manufacturer:') }}</strong> {{ $device->manufacturer }}
            </div>
            <div class="mb-4">
                <strong>{{ __('Manufacture Date:') }}</strong> {{ $device->manufacture_date ? \Carbon\Carbon::parse($device->manufacture_date)->format('Y-m-d') : '-' }}
            </div>
            <div class="mb-4">
                <strong>{{ __('Next Service Date:') }}</strong> {{ $device->next_service_date ? \Carbon\Carbon::parse($device->next_service_date)->format('Y-m-d') : '-' }}
            </div>
            <div class="mb-4">
                <strong>{{ __('Position:') }}</strong> {{ $device->position ?? '-' }}
            </div>
            <div class="mb-4">
                <strong>{{ __('Status:') }}</strong> {{ ucfirst($device->status) }}
            </div>
            @if($device->group)
                <div class="mb-4">
                    <strong>{{ __('Group:') }}</strong> {{ $device->group->name }}
                </div>
            @endif

            <div class="flex justify-end">
                <a href="{{ route('devices.edit', $device->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">
                    {{ __('Edit Device') }}
                </a>
                <a href="{{ route('locations.devices.index', $device->location_id) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    {{ __('Back to Devices') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
