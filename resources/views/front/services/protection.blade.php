@extends('layouts-front.main')

@section('title', 'Protivpožarni Sistemi - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Kompletno projektovanje, instalacija i održavanje protivpožarnih sistema. Koristimo najnoviju tehnologiju, vrhunske alarmne sisteme i 24/7 monitoring za maksimalnu bezbednost.')
@section('meta_keywords', 'protivpožarni sistemi, instalacija, alarmni sistemi, monitoring, projektovanje, bezbednost, tehnologija')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Protivpožarni <span class="text-red-500">Sistemi</span></h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Kompletna rešenja za zaštitu vašeg prostora uz najnoviju tehnologiju.
            </p>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Projektovanje, instalacija i monitoring sistema</h2>

                <div class="flex flex-col md:flex-row gap-6 mb-8">
                    <!-- Tekst -->
                    <div class="md:w-2/3">
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            Naša rešenja za protivpožarnu zaštitu obuhvataju kompletno projektovanje, instalaciju i održavanje sistema koji su prilagođeni specifičnostima svakog prostora. Koristimo vrhunske alarmne sisteme i napredne tehnologije za kontinuirani monitoring, čime osiguravamo da je vaš prostor uvek zaštićen od potencijalnih rizika.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            Naš tim stručnjaka detaljno analizira prostor, kreira kompletna tehnička rešenja, i vrši integraciju novih sistema sa postojećom infrastrukturom. Sa sistemom 24/7 monitoringa, odmah reagujemo na sve nepravilnosti, čime se značajno povećava bezbednost i pouzdanost sistema.
                        </p>
                    </div>

                    <!-- Slika (samo desktop) -->
                    <div class="hidden lg:flex lg:w-1/3 justify-end">
                        <img
                            src="{{ asset('images/protivpozarni-sistemi.png') }}"
                            alt="Protivpožarni sistemi"
                            class="w-40 lg:w-64 drop-shadow-md rounded-md"
                        />
                    </div>
                </div>

                <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                    <li><strong>Kompletno projektovanje:</strong> Prilagođena rešenja dizajnirana prema specifičnim potrebama vašeg prostora.</li>
                    <li><strong>Instalacija i integracija:</strong> Moderni alarmni sistemi i oprema, savršeno integrisani u postojeću infrastrukturu.</li>
                    <li><strong>24/7 monitoring:</strong> Neprekidan nadzor i brza intervencija kako bi se osigurala maksimalna bezbednost.</li>
                    <li><strong>Redovno održavanje:</strong> Preventivni pregledi i ažuriranja sistema u skladu sa najnovijim standardima.</li>
                </ul>

                <p class="text-gray-700 mb-8 leading-relaxed">
                    Investiranjem u naša rešenja, obezbeđujete dugoročnu zaštitu i sigurnost, smanjujući rizik od požara i omogućavajući nesmetan rad vašeg poslovanja.
                </p>

                <a href="{{ route('contact') }}" class="inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300">
                    Kontaktirajte nas
                </a>

                <!-- Slika (samo mobile) -->
                <div class="flex sm:hidden w-full justify-center mt-8">
                    <img
                        src="{{ asset('images/protivpozarni-sistemi.png') }}"
                        alt="Protivpožarni sistemi"
                        class="w-60 drop-shadow-md rounded-md"
                    />
                </div>
            </div>
        </div>
    </section>


    <section id="faq" class="py-16 bg-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Često postavljana pitanja</h2>
            <div class="max-w-4xl mx-auto space-y-4">
                <!-- FAQ Item 1 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Kako funkcioniše sistem 24/7 monitoringa?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Naš sistem koristi najnoviju tehnologiju za neprekidno praćenje alarmnih sistema, što omogućava momentalnu reakciju u slučaju bilo kakvih nepravilnosti.
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Da li je integracija sa postojećim sistemima moguća?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Naši protivpožarni sistemi su dizajnirani tako da se lako integrišu sa postojećom infrastrukturom, pružajući kompletna rešenja prilagođena specifičnim potrebama vašeg prostora.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Koliko traje proces instalacije?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Proces instalacije varira u zavisnosti od kompleksnosti sistema, ali obično traje od nekoliko dana do nedelju dana, u saradnji sa našim stručnim timom.
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
