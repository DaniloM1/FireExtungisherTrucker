@extends('layouts-front.main')

@section('title', 'Evakuacijski Planovi - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Izrada detaljnih evakuacijskih planova za sigurnost vašeg prostora. Analiza prostora, štampanje, postavljanje planova i obuka osoblja.')
@section('meta_keywords', 'evakuacijski planovi, analiza prostora, obuka, sigurnost, planiranje, štampanje, postavljanje')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Evakuacioni <span class="text-red-500">Planovi</span></h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Pripremite vaš prostor za hitne situacije sa detaljnim evakuacionim planovima.
            </p>
        </div>
    </section>

    <!-- Sadržaj usluge -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Planiranje evakuacije, štampanje i postavljanje planova</h2>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Naš tim kreira precizne evakuacijske planove prilagođene vašem prostoru, osiguravajući efikasnu evakuaciju u hitnim situacijama. Pored digitalnih rešenja, nudimo i usluge profesionalnog štampanja planova na visokokvalitetnom materijalu, kao i postavljanja istih na strateškim lokacijama unutar objekta.
                </p>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Na ovaj način osiguravamo da svi u prostoru imaju pristup jasnim i vidljivim uputstvima za evakuaciju, dok je obuka osoblja dodatna garancija da svi znaju kako da postupaju u vanrednim situacijama.
                </p>
                <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                    <li><strong>Detaljna analiza prostora:</strong> Identifikujemo ključne zone i eventualne prepreke.</li>
                    <li><strong>Digitalni i fizički planovi:</strong> Izrađujemo precizne planove u više formata.</li>
                    <li><strong>Štampanje i postavljanje:</strong> Profesionalno štampamo planove i postavljamo ih na optimalna mesta.</li>
                    <li><strong>Obuka osoblja:</strong> Organizujemo obuke kako bi svi znali kako da reaguju u hitnim situacijama.</li>
                </ul>
                <a href="{{ route('contact') }}" class="inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300">
                    Kontaktirajte nas
                </a>
            </div>
        </div>
    </section>

    <!-- FAQ Sekcija -->
    <section id="faq" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Često postavljana pitanja</h2>
            <div class="max-w-4xl mx-auto space-y-4">
                <!-- FAQ Item 1 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Kako se vrši analiza prostora?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Naš tim koristi napredne tehnike i softverske alate za detaljnu analizu prostora, identifikujući ključne evakuacijske rute i eventualne prepreke kako bi plan bio što precizniji.
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Kako se štampaju i postavljaju evakuacijski planovi?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Planovi se štampaju na visokokvalitetnom materijalu, a zatim se postavljaju na strateškim i lako dostupnim lokacijama unutar objekta, osiguravajući da svi zaposleni imaju jasan uvid u evakuacijske rute.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Koliko često treba ažurirati evakuacijske planove?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Preporučujemo ažuriranje evakuacijskih planova najmanje jednom godišnje, ili češće u slučaju značajnih promena u strukturi objekta ili organizacionoj strukturi.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
