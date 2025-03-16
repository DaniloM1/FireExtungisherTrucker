@extends('layouts-front.main')

@section('title', 'Inspekcija Aparata - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Detaljna inspekcija protivpožarne opreme sa redovnim pregledima svakih 6 meseci, kompletni izveštaji i stručno savetovanje za održavanje. Osigurajte sigurnost vašeg prostora.')
@section('meta_keywords', 'inspekcija aparata, protivpožarna oprema, redovni pregledi, izveštaji, održavanje, 6 meseci, bezbednost')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <div class="container mx-auto relative z-10 px-4 text-center ">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Inspekcija <span class="text-red-500">Aparata</span></h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Redovni pregledi i stručno održavanje za sigurnost vašeg prostora.
            </p>
        </div>
    </section>

    <!-- Sadržaj usluge -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Sveobuhvatna inspekcija i održavanje aparata</h2>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Naša usluga inspekcije aparata predstavlja temelj bezbednosti na radu, jer redovni pregledi svake 6 meseci osiguravaju da vaša protivpožarna oprema funkcioniše optimalno. Naši sertifikovani tehničari detaljno pregledaju sve komponente, identifikuju eventualne nepravilnosti i daju precizne preporuke za preventivno održavanje.
                </p>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Time ne samo da se ispunjavaju važeći sigurnosni standardi, već se i značajno smanjuje rizik od neželjenih incidenata. Uz sveobuhvatne izveštaje i stručno savetovanje, naši klijenti imaju potpunu kontrolu i mir, znajući da je njihova oprema uvek spremna za hitne situacije.
                </p>
                <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                    <li><strong>Redovni pregledi:</strong> Svakih 6 meseci, uz detaljnu proveru svih ključnih komponenti.</li>
                    <li><strong>Kompletni izveštaji:</strong> Transparentno dokumentovani rezultati sa jasnim preporukama za održavanje.</li>
                    <li><strong>Stručno savetovanje:</strong> Praktični saveti za popravke i preventivno održavanje, prilagođeni vašim potrebama.</li>
                    <li><strong>Brza intervencija:</strong> Spremni smo da reagujemo odmah u hitnim situacijama.</li>
                </ul>
                <p class="text-gray-700 mb-8 leading-relaxed">
                    Investirajte u redovnu inspekciju i osigurajte dugoročnu pouzdanost i sigurnost vaše opreme – jer kada je reč o bezbednosti, detalji su ključni.
                </p>
                <a href="{{ route('contact') }}" class="inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300">
                    Kontaktirajte nas
                </a>
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
                        <span class="text-xl font-medium text-gray-900">Koliko često treba da se vrši inspekcija aparata?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Preporučuje se da se inspekcija aparata vrši najmanje svake 6 meseci, što garantuje da je oprema uvek u funkciji i spremna za hitne situacije.
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Ko je odgovoran za održavanje opreme?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Naša firma nudi kompletnu uslugu održavanja, a naši sertifikovani tehničari brinu se o redovnim pregledima i servisiranju aparata kako bi se osigurala maksimalna sigurnost.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Da li nudite hitne intervencije?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Da, naš tim je dostupan 24/7 za hitne intervencije. Na taj način brzo reagujemo kako bismo osigurali neprekidnu funkcionalnost vaše opreme.
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
