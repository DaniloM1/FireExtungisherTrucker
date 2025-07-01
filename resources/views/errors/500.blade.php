<x-app-layout>
    <div class="min-h-[85vh] flex flex-col items-center justify-center bg-gradient-to-br from-orange-50 to-white dark:from-gray-800 dark:to-gray-900 p-6 transition-colors duration-300">
        <div class="text-center max-w-2xl mx-auto">
            <!-- Animated 500 number -->
            <div class="text-[120px] md:text-[140px] leading-none font-extrabold text-orange-600 dark:text-orange-400 mb-6 animate-pulse">
                500
            </div>

            <!-- Main heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                Greška na serveru
            </h1>

            <!-- Description with fade-in animation -->
            <div class="animate-fade-in">
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    Došlo je do neočekivane greške na serveru. Naš tim je obavešten i radi na rešavanju problema.
                    Pokušajte ponovo kasnije ili kontaktirajte podršku ako se problem nastavi.
                </p>
            </div>

            <!-- Button group -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <!-- Refresh button -->
                <button onclick="window.location.reload()"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white text-lg font-semibold rounded-xl shadow transition-all hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Osveži stranicu
                </button>

                <!-- Home button -->
                <a href="{{ route('home') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-100 text-lg font-semibold rounded-xl shadow transition-all hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Početna strana
                </a>
            </div>
        </div>
    </div>

    <style>
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>
