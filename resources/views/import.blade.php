<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Import Excel</h2>
    </x-slot>

    <div class="max-w-lg mx-auto mt-10">
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('errors') && count(session('errors')))
            <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4">
                <b>Upozorenja / greške:</b>
                <ul class="list-disc pl-5">
                    @foreach(session('errors') as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('excel.import') }}" enctype="multipart/form-data"
              class="border p-6 rounded-lg bg-white shadow">
            @csrf
            <label class="block mb-2 font-medium">Izaberi .xlsx fajl:</label>
            <input type="file" name="excel_file" required class="mb-4"/>
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Import</button>
        </form>
    </div>
</x-app-layout>
