<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 flex items-center">
            <i class="fas fa-paperclip mr-2"></i>
            Prilozi za servisni događaj ({{ $serviceEvent->attachments->count() }})
        </h3>
    </div>
    <div class="p-6">

        @php
            $generalAttachments = $serviceEvent->attachments->whereNull('location_id');
            $localAttachments = $serviceEvent->attachments->where('location_id', $loc->id);
            $companyAttachments = $generalAttachments->merge($localAttachments);
        @endphp

        @role('company')
        @if($companyAttachments->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($companyAttachments as $attachment)
                    <div class="flex flex-col justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 mb-2">
                        @if($attachment->location)
                            <div class="mb-1">
                                <span class="inline-block bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-3 py-1 rounded-full font-semibold">
                                    Lokacija: {{ $attachment->location->name }}
                                    @if($attachment->location->city)
                                        ({{ $attachment->location->city }})
                                    @endif
                                </span>
                            </div>
                        @endif
                        <div class="flex items-center justify-between">
                            <div class="flex items-center min-w-0">
                                <i class="far fa-file-alt text-2xl text-gray-500 dark:text-gray-400 mr-3"></i>
                                <div class="min-w-0">
                                    <a href="{{ route('attachments.view', $attachment) }}" target="_blank"
                                       class="text-blue-600 dark:text-blue-400 font-medium hover:underline truncate block">
                                        {{ $attachment->name }}
                                    </a>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $attachment->type }}</span>
                                </div>
                            </div>
                            {{-- Nema brisanja za company --}}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-paperclip text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                <p class="text-gray-500 dark:text-gray-400">Nema priloga za ovaj servis.</p>
            </div>
        @endif

        @else
            {{-- ADMIN: prikazuje sve kao do sada --}}
            @if($serviceEvent->attachments->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($serviceEvent->attachments as $attachment)
                        <div class="flex flex-col justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 mb-2">
                            @if($attachment->location)
                                <div class="mb-1">
                                    <span class="inline-block bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-3 py-1 rounded-full font-semibold">
                                        Lokacija: {{ $attachment->location->name }}
                                        @if($attachment->location->city)
                                            ({{ $attachment->location->city }})
                                        @endif
                                    </span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between">
                                <div class="flex items-center min-w-0">
                                    <i class="far fa-file-alt text-2xl text-gray-500 dark:text-gray-400 mr-3"></i>
                                    <div class="min-w-0">
                                        <a href="{{ route('attachments.view', $attachment) }}" target="_blank"
                                           class="text-blue-600 dark:text-blue-400 font-medium hover:underline truncate block">
                                            {{ $attachment->name }}
                                        </a>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $attachment->type }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('attachments.view', $attachment) }}" target="_blank"
                                       class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 p-1 rounded hover:bg-blue-50 dark:hover:bg-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @hasrole('super_admin|admin')
                                    <form action="{{ route('attachments.destroy', $attachment) }}" method="POST"
                                          onsubmit="return confirm('Da li ste sigurni da želite obrisati ovaj prilog?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 p-1 rounded hover:bg-red-50 dark:hover:bg-gray-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endhasrole
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-paperclip text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                    <p class="text-gray-500 dark:text-gray-400">Nema priloga za ovaj servis.</p>
                </div>
            @endif

            @hasrole('super_admin|admin')
            {{-- Forma za upload --}}
            <form action="{{ route('service-events.attachments.store', $serviceEvent) }}" method="POST" enctype="multipart/form-data" class="mt-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Odaberite fajl</label>
                        <input type="file" name="attachment" id="attachment" required
                               class="block w-full text-sm text-gray-700 dark:text-gray-300
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      dark:file:bg-blue-900 dark:file:text-blue-200
                                      hover:file:bg-blue-100 dark:hover:bg-blue-800
                                      transition-colors cursor-pointer" />
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Naziv</label>
                        <input type="text" name="name" id="name" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-blue-500 dark:focus:ring-blue-600"
                               placeholder="Naziv dokumenta">
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tip</label>
                        <input type="text" name="type" id="type" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-blue-500 dark:focus:ring-blue-600"
                               placeholder="Tip dokumenta">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                        <i class="fas fa-upload mr-2"></i> Dodaj prilog
                    </button>
                </div>
                @if($errors->any())
                    <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                        @foreach($errors->all() as $error)
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
            @endhasrole

        @endrole

    </div>
</div>
