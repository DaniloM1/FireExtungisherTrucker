@props([
'announcements' => [],
'isAdmin' => false,
'examGroup' => null,
])

@php
// AlpineJS state izolovan
$modalId = 'ann-modal-' . ($examGroup ? $examGroup->id : 'x');
@endphp

<div class="rounded-2xl bg-gradient-to-r from-blue-600 to-blue-800 dark:from-gray-800 dark:to-gray-900 shadow-md mb-8">
    <div class="p-6" x-data="{ open: false }" id="{{ $modalId }}">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-bold text-white dark:text-blue-200 flex items-center">
                <svg class="w-6 h-6 mr-2 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 11 3 12a9 9 0 0118 0z" />
                </svg>
                Obaveštenja za grupu
            </h3>
            @if($isAdmin)
            <button
                @click="open = true"
                class="ml-2 inline-flex items-center px-3 py-1 bg-blue-700 dark:bg-gray-700 text-white dark:text-gray-200 rounded-xl text-xs hover:bg-blue-800 dark:hover:bg-gray-800 transition"
            >
                + Novo obaveštenje
            </button>
            @endif
        </div>
        <div class="mt-4 space-y-3">
            @forelse($announcements as $ann)
            <div class="rounded-xl bg-white/90 dark:bg-gray-900/80 border border-blue-100 dark:border-gray-700 px-4 py-3 shadow">
                <div class="flex items-center gap-2">
                    <span class="text-lg font-semibold text-blue-900 dark:text-blue-300">{{ $ann->title }}</span>
                    <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">
                            @if($ann->creator)
                                | <span class="text-gray-400">Objavio:</span> {{ $ann->creator->name }}
                            @endif
                        </span>
                </div>
                <div class="mt-1 text-gray-700 dark:text-gray-200 text-sm">
                    {!! nl2br(e($ann->body)) !!}
                </div>
            </div>
            @empty
            <div class="rounded-xl bg-white/80 dark:bg-gray-900/60 border border-dashed border-blue-300 dark:border-gray-700 px-4 py-4 text-center text-gray-400 dark:text-gray-500">
                Nema obaveštenja za ovu grupu.
            </div>
            @endforelse
        </div>

        {{-- Modal za novo obaveštenje --}}
        <template x-if="open">
            <div class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg w-full max-w-lg relative">
                    <button @click="open = false" class="absolute top-3 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-2xl font-bold">
                        &times;
                    </button>
                    <h2 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">Novo obaveštenje za grupu</h2>
                    <form method="POST" action="{{ route('announcements.store') }}">
                        @csrf
                        <input type="hidden" name="exam_group_id" value="{{ $examGroup?->id }}">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naslov</label>
                            <input type="text" name="title" required class="mt-1 w-full rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tekst obaveštenja</label>
                            <textarea name="body" rows="4" required class="mt-1 w-full rounded border-gray-300 dark:bg-gray-800 dark:text-gray-100 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div class="mb-4 flex items-center gap-2">
                            <input type="checkbox" name="send_email" id="send_email" class="rounded border-gray-400 dark:bg-gray-800 dark:text-gray-100">
                            <label for="send_email" class="text-sm text-gray-700 dark:text-gray-300">Pošalji kao email svim učesnicima grupe</label>
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" @click="open = false" class="px-4 py-2 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                Otkaži
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow">
                                Pošalji obaveštenje
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</div>
