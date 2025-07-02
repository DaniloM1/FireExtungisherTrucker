<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 leading-tight">
            Izmena grupe: {{ $examGroup->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow p-6 border border-gray-200 dark:border-gray-700">
            <form action="{{ route('exam-groups.update', $examGroup) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naziv grupe</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $examGroup->name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Datum početka</label>
                    <input type="date" name="start_date" id="start_date" required value="{{ old('start_date', $examGroup->start_date) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div class="mb-6">
                    <label for="exam_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Datum ispita</label>
                    <input type="date" name="exam_date" id="exam_date" value="{{ old('exam_date', optional($examGroup->exam_date)->format('Y-m-d')) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('exam.index') }}" class="mr-4 text-sm text-gray-600 dark:text-gray-400 hover:underline">
                        Otkaži
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-xl font-semibold text-sm text-white tracking-wide hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150 shadow-md">
                        Sačuvaj izmene
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
