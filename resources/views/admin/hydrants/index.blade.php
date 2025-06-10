<x-app-layout>
    <x-slot name="header">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg mb-6 p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                <div class="flex items-center w-full md:w-auto">
                    <i class="fas fa-faucet text-4xl mr-4 text-black dark:text-white"></i>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">
                            {{ $location->company->name }}
                        </h2>
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">
                            {{ $location->name }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ $location->address }}
                        </p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 text-right w-full md:w-auto">
                    <p class="text-gray-600 dark:text-gray-400 mb-2">
                        Next Service:
                        {{ $location->nextServiceDateByCategory('hydrant')
                            ? $location->nextServiceDateByCategory('hydrant')->format('d-m-Y')
                            : 'Nema dostupnog datuma' }}
                    </p>

                    <a href="#" class="flex items-center justify-end text-lg text-blue-600 dark:text-blue-400 hover:underline">
                        <i class="fas fa-plus mr-2"></i> {{ __('Create Service') }}
                    </a>
                </div>
            </div>
            <div class="mt-4">
                <nav class="text-sm text-gray-500">
                    Company <span class="mx-2">&rarr;</span> Location <span class="mx-2">&rarr;</span> Hydrants
                </nav>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg text-gray-800 dark:text-gray-200">{{ __('Hydrant List') }}</h3>
            <a href="{{ route('locations.hydrants.create', $location->id) }}" class="text-lg text-gray-800 dark:text-gray-200 hover:underline">
                <i class="fas fa-plus"></i> {{ __('Add Hydrant') }}
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 hidden md:table">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Serial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Manufacturer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">HVP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>

                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($hydrants as $hydrant)
                        <tr>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $hydrant->serial_number }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $hydrant->model }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $hydrant->type }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ $hydrant->manufacturer }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ optional($hydrant->next_service_date)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">{{ optional($hydrant->hvp)->format('Y-m-d') }}</td>
                            <td class="px-6 py-4">
                            <span class="inline-block px-2 py-1 text-xs rounded bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-100">
                                {{ $hydrant->status ?? '-' }}
                            </span>
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                <div class="flex space-x-2">
                                    <a href="#" class="text-black dark:text-white hover:underline"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="#" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 dark:text-gray-300">Nema hidranta.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Mobile prikaz -->
                <div class="block md:hidden">
                    @forelse ($hydrants as $hydrant)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <div class="font-semibold text-lg text-gray-800 dark:text-gray-200">
                                    {{ $hydrant->serial_number }}
                                </div>
                                <div class="flex space-x-2">
                                    <a href="#" class="text-black dark:text-white"><i class="fas fa-edit"></i></a>
                                    <form method="POST" action="#" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Model: {{ $hydrant->model }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Tip: {{ $hydrant->type }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Servis: {{ optional($hydrant->next_service_date)->format('Y-m-d') }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Status: {{ $hydrant->status }}</p>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 dark:text-gray-300">
                            Nema hidranta.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                {{ $hydrants->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
