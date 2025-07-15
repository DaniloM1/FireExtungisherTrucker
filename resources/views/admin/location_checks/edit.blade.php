<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fas fa-edit mr-2 text-blue-500"></i>
            Izmena pregleda / testa
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <a href="{{ route('location_checks.show', $locationCheck) }}"
               class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                <i class="fas fa-arrow-left mr-2"></i> Nazad na detalje
            </a>

            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 p-4 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('location_checks.update', $locationCheck) }}" class="bg-white dark:bg-gray-800 shadow rounded-xl p-8 space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Lokacija -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Lokacija
                        </label>
                        <select name="location_id"
                                class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}"
                                    {{ $loc->id == old('location_id', $locationCheck->location_id) ? 'selected' : '' }}>
                                    {{ $loc->company->name }} – {{ $loc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tip -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Tip
                        </label>
                        <select name="type" class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                            <option value="inspection" {{ old('type', $locationCheck->type) === 'inspection' ? 'selected' : '' }}>
                                Inspekcija
                            </option>
                            <option value="test" {{ old('type', $locationCheck->type) === 'test' ? 'selected' : '' }}>
                                Test
                            </option>
                        </select>
                    </div>

                    <!-- Naziv -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Naziv
                        </label>
                        <input type="text" name="name" value="{{ old('name', $locationCheck->name) }}"
                               class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <!-- Datumi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Poslednji termin
                        </label>
                        <input type="date" name="last_performed_date"
                               value="{{ old('last_performed_date', optional($locationCheck->last_performed_date)->format('Y-m-d')) }}"
                               class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Sledeći termin
                        </label>
                        <input type="date" name="next_due_date"
                               value="{{ old('next_due_date', optional($locationCheck->next_due_date)->format('Y-m-d')) }}"
                               class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                    </div>

                    <!-- Inspektor -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Inspektor
                        </label>
                        <select name="inspector_id"
                                class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">
                            <option value="">— Nije dodeljen —</option>
                            @foreach($inspectors as $ins)
                                <option value="{{ $ins->id }}"
                                    {{ $ins->id == old('inspector_id', $locationCheck->inspector_id) ? 'selected' : '' }}>
                                    {{ $ins->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Opis -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Opis
                        </label>
                        <textarea name="description" rows="4"
                                  class="w-full rounded border-gray-300 dark:bg-gray-700 dark:text-gray-200">{{ old('description', $locationCheck->description) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-semibold">
                        Sačuvaj izmene
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
