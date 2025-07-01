<x-app-layout>
    <div class="min-h-[85vh] flex flex-col items-center justify-center bg-gradient-to-br from-amber-50 to-white dark:from-gray-800 dark:to-gray-900 p-6">
        <div class="text-center max-w-2xl mx-auto">
            <div class="text-[120px] md:text-[140px] leading-none font-extrabold text-amber-600 dark:text-amber-400 mb-6 animate-spin-slow">
                419
            </div>

            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                Sesija je istekla
            </h1>

            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                Vaša sesija je istekla zbog neaktivnosti. Osvežite stranicu
                i pokušajte ponovo.
            </p>

            <button onclick="window.location.reload()"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white text-lg font-semibold rounded-xl shadow transition-all hover:shadow-lg hover:-translate-y-0.5 mx-auto">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Osveži stranicu
            </button>
        </div>
    </div>

    <style>
        .animate-spin-slow {
            animation: spin 8s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</x-app-layout>
