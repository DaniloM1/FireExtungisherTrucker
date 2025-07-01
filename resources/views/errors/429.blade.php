<x-app-layout>
    <div class="min-h-[85vh] flex flex-col items-center justify-center bg-gradient-to-br from-purple-50 to-white dark:from-gray-800 dark:to-gray-900 p-6">
        <div class="text-center max-w-2xl mx-auto">
            <div class="text-[120px] md:text-[140px] leading-none font-extrabold text-purple-600 dark:text-purple-400 mb-6 animate-wiggle">
                429
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                Previše zahteva
            </h1>

            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                Poslali ste previše zahteva u kratkom vremenskom periodu.
                Sačekajte nekoliko minuta pre ponovnog pokušaja.
            </p>

            <div class="flex justify-center gap-4">
                <button onclick="window.location.reload()"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white text-lg font-semibold rounded-xl shadow transition-all hover:shadow-lg hover:-translate-y-0.5">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Pokušaj ponovo
                </button>
            </div>
        </div>
    </div>

    <style>
        .animate-wiggle {
            animation: wiggle 2s ease-in-out infinite;
        }
        @keyframes wiggle {
            0%, 100% { transform: rotate(-3deg); }
            50% { transform: rotate(3deg); }
        }
    </style>
</x-app-layout>
