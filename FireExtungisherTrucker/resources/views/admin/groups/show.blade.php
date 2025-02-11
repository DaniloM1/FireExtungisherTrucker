<x-app-layout>
{{--    {{dd($group->location->company)}}--}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Group Details') }}: {{ $group->name }}
        </h2>
    </x-slot>

    <!-- Detalji grupe -->
    <div class="max-w-7xl mx-auto mt-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6  text-black dark:text-white">
            <p class="mb-2"><strong>{{ __('Description:') }}</strong> {{ $group->description ?? '-' }}</p>
            <p class="mb-2">
                <strong>{{ __('Next Service Date:') }}</strong>
                {{ $group->next_service_date ? \Carbon\Carbon::parse($group->next_service_date)->format('Y-m-d') : '-' }}
            </p>
            <p class="mb-2"><strong>{{ __('Location:') }}</strong> {{ $group->location->name }}</p>
        </div>
    </div>

    <!-- Popis uređaja unutar grupe -->
    <div class="max-w-7xl mx-auto mt-6">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6  text-black dark:text-white">
            <h3 class="text-lg font-semibold">{{ __('Devices in this Group') }}</h3>
            @if($group->devices->count())
                <ul class="mt-4 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($group->devices as $device)
                        <li class="py-2">
                            <span class="font-bold">{{ $device->serial_number }}</span> -
                            {{ $device->model }} ({{ ucfirst($device->status) }})
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-4 text-gray-500 dark:text-gray-300">{{ __('No devices in this group.') }}</p>
            @endif
        </div>
    </div>
</x-app-layout>
