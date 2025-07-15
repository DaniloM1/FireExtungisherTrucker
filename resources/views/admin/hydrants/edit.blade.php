<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Uredi hidrantski uređaj za') }} {{ $location->name }}
        </h2>
    </x-slot>

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

    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('locations.hydrants.update', [$location, $hydrant]) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach([
    'serial_number'     => ['Serijski broj',     $hydrant->serial_number,     'text'],
    'type'              => ['Tip',               $hydrant->type,              'text'],
    'model'             => ['Model',             $hydrant->model,             'text'],
    'manufacturer'      => ['Proizvođač',        $hydrant->manufacturer,      'text'],
    'manufacture_date'  => ['Datum proizvodnje', $hydrant->manufacture_date,  'date'],
    'next_service_date' => ['Datum sledećeg servisa',$hydrant->next_service_date,'date'],
    'hvp'               => ['Datum HVP',         $hydrant->hvp,               'date'],
    'position'          => ['Pozicija',          $hydrant->position,          'text'],
    'static_pressure'   => ['Staticki pritisak', $hydrant->static_pressure,   'number'],
    'dynamic_pressure'  => ['Dinamički pritisak',$hydrant->dynamic_pressure,  'number'],
    'flow'              => ['Protok (l/min)',    $hydrant->flow,              'number'],
] as $field => [$label, $value, $type])

                        @php
                            // ako postoji stara vrednost (npr. nakon validate errore) koristi nju
                            $inputVal = old($field);

                            // ako nema "old", upotrebi vrednost iz modela
                            if ($inputVal === null && $value !== null) {
                                // formatiraj po tipu
                                if ($type === 'date') {
                                    $inputVal = $value instanceof \Carbon\Carbon
                                        ? $value->format('Y-m-d')
                                        : \Carbon\Carbon::parse($value)->format('Y-m-d');
                                } elseif ($type === 'number') {
                                    // zamenimo zarez tačkom ako treba
                                    $inputVal = str_replace(',', '.', $value);
                                } else {
                                    $inputVal = $value;
                                }
                            }
                        @endphp

                        <div>
                            <label for="{{ $field }}" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                                {{ __($label) }}
                            </label>

                            <input
                                type="{{ $type }}"
                                name="{{ $field }}"
                                id="{{ $field }}"
                                value="{{ $inputVal }}"
                                @if($type === 'number') step="0.01" @endif
                                class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white"
                            >
                        </div>
                    @endforeach


                    <div>
                        <label for="status" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">
                            {{ __('Status') }}
                        </label>
                        <select name="status" id="status"
                                class="w-full border-gray-300 dark:border-gray-600 rounded p-2 dark:bg-gray-700 dark:text-white">
                            <option value="active"        {{ old('status', $hydrant->status) == 'active' ? 'selected' : '' }}>{{ __('Aktivan') }}</option>
                            <option value="inactive"      {{ old('status', $hydrant->status) == 'inactive' ? 'selected' : '' }}>{{ __('Neaktivan') }}</option>
                            <option value="needs_service" {{ old('status', $hydrant->status) == 'needs_service' ? 'selected' : '' }}>{{ __('Za servis') }}</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <a href="{{ route('locations.hydrants.index', $location) }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                        {{ __('Otkaži') }}
                    </a>
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        {{ __('Sačuvaj izmene') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
