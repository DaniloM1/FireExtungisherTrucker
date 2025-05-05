@extends('layouts-front.main')

@section('title', 'Ugradnja i Servis - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Profesionalna ugradnja i redovan servis protivpožarne opreme. Osigurajte pouzdanost vaših sistema uz preventivno održavanje i brze intervencije.')
@section('meta_keywords', 'ugradnja i servis, protivpožarna oprema, redovan servis, održavanje, instalacija, preventivno održavanje, remont')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Ugradnja i <span class="text-red-500">Servis</span></h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Profesionalna instalacija i redovan servis protivpožarne opreme za maksimalnu pouzdanost vaših sistema.
            </p>
        </div>
    </section>

    <!-- Sadržaj usluge -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Instalacija i redovan servis</h2>

                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Tekstualni sadržaj -->
                    <div class="flex-1">
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            Naša usluga obuhvata stručnu ugradnju protivpožarne opreme, redovan servis i održavanje, kao i dopune i remont aparata. Naš cilj je da vam omogućimo bezbedan i pouzdan sistem zaštite, uz preventivno održavanje koje produžava vek trajanja opreme.
                        </p>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            Kroz detaljnu instalaciju i redovne preglede, naši tehničari osiguravaju da svaki uređaj funkcioniše optimalno. Naša rešenja su prilagođena vašim specifičnim potrebama, a brza intervencija garantuje da su svi eventualni kvarovi odmah otklonjeni.
                        </p>
                        <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                            <li><strong>Stručna instalacija PP opreme:</strong> Precizno postavljanje i integracija sa postojećom infrastrukturom.</li>
                            <li><strong>Redovan servis i održavanje:</strong> Preventivni pregledi i održavanje prema utvrđenim standardima.</li>
                            <li><strong>Dopune i remont aparata:</strong> Ažuriranje i popravke kako bi sistem ostao uvek pouzdan.</li>
                        </ul>

                        <a
                            href="{{ route('contact') }}"
                            class="mt-4 inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300"
                        >
                            Kontaktirajte nas
                        </a>
                    </div>

                    <div class="md:col-span-1  justify-center md:justify-end">
                        <img
                            src="{{ asset('images/ugradnja_i_servis.png') }}"
                            alt="Ugradnja i servis"
                            class="   md:w-full max-w-xs drop-shadow-md rounded-md mx-auto "
                        />
                    </div>

                </div>
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
                        <span class="text-xl font-medium text-gray-900">Kako funkcioniše redovan servis i održavanje?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Naš tim vrši preventivne preglede opreme prema definisanom rasporedu, identifikujući eventualne kvarove i osiguravajući da svi uređaji funkcionišu optimalno. Redovan servis omogućava pravovremenu intervenciju i smanjenje rizika od kvara.
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Koja je garancija na instaliranu opremu?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Pružamo garanciju na instaliranu opremu i redovan servis, uz uslove definisane u ugovoru. Naša politika uključuje brzu intervenciju i tehničku podršku, što garantuje dugoročnu pouzdanost sistema.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Kako se vrši integracija sa postojećim sistemima?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Naši tehničari pažljivo planiraju i realizuju integraciju nove opreme sa vašim postojećim sistemima, osiguravajući da svi elementi funkcionišu kao jedinstven, pouzdan sistem zaštite.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
