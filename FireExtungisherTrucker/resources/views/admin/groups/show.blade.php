<x-app-layout>
    <x-slot name="header">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 flex items-center p-6">
            <i class="fas fa-layer-group text-4xl mr-4 text-black dark:text-white"></i>
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">
                    {{ __('Group Details') }}: {{ $group->name }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400">{{ $group->location->name }}</p>
            </div>
        </div>
    </x-slot>

    <!-- Detalji grupe -->
    <div class="max-w-7xl mx-auto mt-4">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-black dark:text-white">
            <p class="mb-2"><strong>{{ __('Description:') }}</strong> {{ $group->description ?? '-' }}</p>
            <p class="mb-2"><strong>{{ __('Next Service Date:') }}</strong>
                {{ $group->next_service_date ? \Carbon\Carbon::parse($group->next_service_date)->format('Y-m-d') : '-' }}
            </p>
        </div>
    </div>

    <!-- Pretraga -->
    <div class="max-w-7xl mx-auto mb-4 mt-6">
        <form
{{--            action="{{ route('groups.devices.index', $group->id) }}" method="GET" class="flex">--}}
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="{{ __('Search devices...') }}"
                   class="flex-grow rounded-l-md border border-gray-300 dark:border-gray-600 p-2 focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white" />
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-r-md">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <!-- Lista uređaja u grupi -->
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-6">{{ __('Devices in this Group') }}</h3>
            <div class="overflow-x-auto">
                <!-- Desktop prikaz -->
                <table class="min-w-full hidden md:table divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Serial Number') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Model') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($group->devices as $device)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $device->serial_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $device->model }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($device->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('devices.edit', $device->id) }}" class="text-black dark:text-white hover:underline" title="{{ __('Edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('devices.destroy', $device->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="hover:text-red-700" title="{{ __('Delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">
                                {{ __('No devices found.') }}
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Mobile prikaz -->
                <div class="block md:hidden">
                    @forelse ($group->devices as $device)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-4">
                            <div class="font-semibold">{{ $device->serial_number }}</div>
                            <div>{{ __('Model') }}: {{ $device->model }}</div>
                            <div>{{ __('Status') }}: {{ ucfirst($device->status) }}</div>
                            <div class="mt-4 flex items-center space-x-4">
                                <a href="{{ route('devices.edit', $device->id) }}" class="text-black dark:text-white hover:underline" title="{{ __('Edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('devices.destroy', $device->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="hover:text-red-700" title="{{ __('Delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-300">
                            {{ __('No devices found.') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
