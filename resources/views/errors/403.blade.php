<x-app-layout>
    <div class="min-h-[85vh] flex flex-col items-center justify-center bg-gradient-to-br from-red-50 to-white dark:from-gray-800 dark:to-gray-900 p-6 transition-colors duration-300">
        <div class="text-center max-w-2xl mx-auto">
            <!-- Animated 403 number -->
            <div class="text-[120px] md:text-[140px] leading-none font-extrabold text-red-600 dark:text-red-400 mb-6 animate-bounce">
                403
            </div>

            <!-- Main heading -->
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                Pristup zabranjen
            </h1>

            <!-- Description with fade-in animation -->
            <div class="animate-fade-in">
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                    Niste ovlašćeni da pristupite ovoj stranici ili funkcionalnosti.
                    Ako mislite da je ovo greška, kontaktirajte administratora.
                </p>
            </div>

            <!-- Button group -->
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <!-- Back button -->
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold rounded-xl shadow transition-all hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Vrati se nazad
                </a>

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
        .animate-bounce {
            animation: bounce 1s ease infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
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
