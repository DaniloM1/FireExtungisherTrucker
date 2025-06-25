@extends('layouts-front.main')

@section('title', 'Početna - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Dobrodošli na Požarnu Sigurnost, vašeg partnera za protivpožarne usluge.')
@section('meta_keywords', 'požarna sigurnost, protivpožarne usluge, zaštita, sigurnost, overa pp aparata')

@section('content')

    <section id="hero" class="relative h-[70vh] flex items-center overflow-hidden">
        <!-- Animirana pozadina -->
        <div class="bg-lava"></div>

        <!-- Lagani overlay -->
        <div class="absolute inset-0 bg-black opacity-60"></div>

        <div class="container mx-auto relative z-10 px-4">
            <div class="flex flex-col md:flex-row items-center justify-between h-full">

                <!-- LEVA STRANA: Naslov i tekst -->
                <div class="md:w-1/2 flex flex-col justify-center text-center md:text-left mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 transition duration-500 ease-in-out transform hover:scale-105">
                        Ne dozvolite da vam <span class="text-red-500">posao</span>  postane  <span class="text-red-500">pepeo</span>
                    </h1>
                    <p class="text-base md:text-lg lg:text-xl text-gray-200 mb-8">
                        Proizvodna i uslužna radnja za bezbednost i zdravlje na radu.
                    </p>
                    <div class="space-y-4 md:space-y-0 md:space-x-4  md:flex-row justify-center md:justify-start">
                        <a href="{{route('services')}}" class="bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 transition duration-300 inline-block">
                            <i class="fas fa-fire"></i> Naše Usluge
                        </a>
                        <a href="{{route('contact')}}" class="bg-white text-red-600 px-6 py-3 rounded-full hover:bg-gray-200 transition duration-300 inline-block">
                            <i class="fas fa-phone"></i> Kontakt
                        </a>
                    </div>
                </div>

                <div class="md:w-1/2 flex flex-col items-center justify-center md:justify-end md:-mt-8">
                    <!-- Ilustracija -->
                    <img src="/images/logo-white.svg"
                         alt="Ilustracija protupožarne zaštite"
                         class="w-3/4 md:w-4/12 max-w-sm object-contain hidden md:block">
                    <!-- Tekst ispod slike -->
                    <h1 class="hidden md:block text-2xl md:text-2xl lg:text-4xl text-gray-200 mt-4 font-bold">
                        INŽENJER <span class="text-red-500">TIM</span>
                    </h1>
                </div>


            </div>
        </div>
    </section>


    <section id="usluge" class="py-10 md:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grid: 1 kolona na mobitelu, 3 kolone na desktopu -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">

                <!-- Lijeva kolona: zauzima 1 kolonu na desktopu -->
                <div class="md:col-span-1 flex flex-col justify-center">
                    <!-- Na mobilu manji font i razmak, na desktopu veći -->
                    <h2 class="text-xs md:text-sm font-bold text-red-500 uppercase mb-2">Naše Usluge</h2>
                    <h3 class="text-2xl md:text-4xl font-bold text-gray-900 mb-3 md:mb-4">
                        Pružamo mnogo sjajnih usluga
                    </h3>
                    <p class="text-gray-600 mb-4 md:mb-6 text-sm md:text-base">
                        Far far away, behind the word mountains, daleko od zemalja Vokalia i Consonantia,
                        nalaze se tekstovi koji će obogatiti Vaš projekat...
                    </p>
                    <a href="{{ route('services') }}"
                       class="inline-flex items-center bg-red-600 text-white px-4 py-2 md:px-6 md:py-2 rounded-full hover:bg-red-700 transition duration-300 text-sm md:text-lg">
                        Saznaj Više <i class="fa fa-long-arrow-right ml-2"></i>
                    </a>

                </div>

                <!-- Desna kolona: zauzima 2 kolone na desktopu, unutra grid za usluge -->
                <!-- Manji razmak (gap) i font na mobilu, veći na većim ekranima -->
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">

                    <!-- Usluga 1 -->
                    <div class="p-4 md:p-6 bg-gray-50 rounded-xl text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-fire-extinguisher text-red-600 text-xl"></i>
                        </div>
                        <h4 class="text-base md:text-lg font-semibold text-black mb-2">Inspekcija Aparata</h4>
                        <p class="text-gray-600 text-xs md:text-sm">
                            Redovne preglede i inspekcije protivpožarne opreme kako bi uvijek bila spremna.
                        </p>
                    </div>

                    <!-- Usluga 2 -->
                    <div class="p-4 md:p-6 bg-gray-50 rounded-xl text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-tools text-red-600 text-xl"></i>
                        </div>
                        <h4 class="text-base md:text-lg font-semibold text-black mb-2">Ugradnja i Servis</h4>
                        <p class="text-gray-600 text-xs md:text-sm">
                            Stručna ugradnja i održavanje opreme od strane certificiranih profesionalaca.
                        </p>
                    </div>

                    <!-- Usluga 3 -->
                    <div class="p-4 md:p-6 bg-gray-50 rounded-xl text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-map text-red-600 text-xl"></i>
                        </div>
                        <h4 class="text-base md:text-lg font-semibold text-black mb-2">Evakuacijski Planovi</h4>
                        <p class="text-gray-600 text-xs md:text-sm">
                            Izrada detaljnih i prilagođenih planova za siguran izlazak u slučaju opasnosti.
                        </p>
                    </div>

                    <!-- Usluga 4 -->
                    <div class="p-4 md:p-6 bg-gray-50 rounded-xl text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-graduation-cap text-red-600 text-xl"></i>
                        </div>
                        <h4 class="text-base md:text-lg font-semibold text-black mb-2">Polaganje Stručnog Ispita</h4>
                        <p class="text-gray-600 text-xs md:text-sm">
                            Priprema i polaganje stručnog ispita uz profesionalno savetovanje i podršku.
                        </p>
                    </div>

                    <!-- Usluga 5 -->
                    <div class="p-4 md:p-6 bg-gray-50 rounded-xl text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shield-alt text-red-600 text-xl"></i>
                        </div>
                        <h4 class="text-base md:text-lg font-semibold text-black mb-2">Protivpožarni Sistemi</h4>
                        <p class="text-gray-600 text-xs md:text-sm">
                            Implementacija i održavanje sistema za zaštitu od požara.
                        </p>
                    </div>

                    <!-- Usluga 6 -->
                    <div class="p-4 md:p-6 bg-gray-50 rounded-xl text-center hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-bullhorn text-red-600 text-xl"></i>
                        </div>
                        <h4 class="text-base md:text-lg font-semibold text-black mb-2">Obuke i Edukacije</h4>
                        <p class="text-gray-600 text-xs md:text-sm">
                            Organizacija praktičnih obuka i edukacija o pravilnoj upotrebi zaštitne opreme.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mt-16 bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-8 md:p-12 bg-gradient-to-r from-red-600 to-red-800 text-white">
                        <h3 class="text-2xl font-bold mb-4">Naša stručnost</h3>
                        <p class="mb-6">Tim iskusnih inženjera i tehničara sa decenijama iskustva u oblasti požarne zaštite i sigurnosti na radu.</p>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-red-200 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Certifikovani stručnjaci</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-red-200 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Najsavremenija oprema</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-5 w-5 text-red-200 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Kontinuirano usavršavanje</span>
                            </li>
                        </ul>
                    </div>
                    <div class="p-8 md:p-12">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Zašto izabrati nas?</h3>
                        <p class="text-gray-600 mb-6">Kombinacija iskustva, najnovijih tehnologija i individualnog pristupa svakom klijentu čini nas liderom u oblasti.</p>
                        <div class="space-y-4">
                            <div>
                                <h4 class="font-medium text-gray-900">Širok spektar usluga</h4>
                                <p class="text-gray-600 text-sm">Od projektovanja do održavanja - kompletnu rešenja pod jednim krovom</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Brz i pouzdan odgovor</h4>
                                <p class="text-gray-600 text-sm">Reagujemo brzo na sve zahteve i hitne intervencije</p>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Transparentnost</h4>
                                <p class="text-gray-600 text-sm">Jasne i fer cene bez skrivenih troškova</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Naši Partneri Sekcija -->
    <section id="partneri" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-xs md:text-sm font-bold text-red-500 uppercase tracking-wider">Poverenje kompanija</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Naši partneri i klijenti</h2>
                <p class="mt-4 max-w-2xl text-gray-600 mx-auto">
                    Saradnja sa vodećim kompanijama iz različitih industrija dokaz našeg kvaliteta i pouzdanosti
                </p>
            </div>

            <!-- Logos grid sa hover efektima -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12">
                <!-- Partner 1 -->
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300 border border-gray-100">
                    <img src="{{ asset('images/aman-logo.jpg') }}" alt="Aman logo" class="h-12 object-contain opacity-80 hover:opacity-100 transition-opacity">
                </div>

                <!-- Partner 2 -->
                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300 border border-gray-100">
                    <img src="{{ asset('images/knjaz-logo.png') }}" alt="Knjaz Miloš logo" class="h-12 object-contain opacity-80 hover:opacity-100 transition-opacity">
                </div>

{{--                <!-- Partner 3 -->--}}
{{--                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300 border border-gray-100">--}}
{{--                    <img src="{{ asset('images/partner3.png') }}" alt="Partner logo" class="h-12 object-contain opacity-80 hover:opacity-100 transition-opacity">--}}
{{--                </div>--}}

{{--                <!-- Partner 4 -->--}}
{{--                <div class="flex items-center justify-center p-4 bg-gray-50 rounded-xl hover:bg-white hover:shadow-lg transition-all duration-300 border border-gray-100">--}}
{{--                    <img src="{{ asset('images/partner4.png') }}" alt="Partner logo" class="h-12 object-contain opacity-80 hover:opacity-100 transition-opacity">--}}
{{--                </div>--}}
{{--            </div>--}}

            <!-- Testimonials -->
{{--            <div class="mt-16 bg-red-50 rounded-xl p-8 md:p-12">--}}
{{--                <div class="max-w-3xl mx-auto text-center">--}}
{{--                    <svg class="h-12 w-12 text-red-400 mx-auto" fill="currentColor" viewBox="0 0 32 32">--}}
{{--                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>--}}
{{--                    </svg>--}}
{{--                    <blockquote class="mt-6">--}}
{{--                        <p class="text-lg md:text-xl font-medium text-gray-900">--}}
{{--                            "Inženjer Tim je pokazao visok nivo profesionalizma u saradnji na našim projektima. Njihovo znanje i posvećenost sigurnosti su neuporedivi."--}}
{{--                        </p>--}}
{{--                    </blockquote>--}}
{{--                    <div class="mt-6">--}}
{{--                        <p class="text-base font-medium text-red-600">Milan Petrović</p>--}}
{{--                        <p class="text-sm font-medium text-gray-500">Direktor bezbednosti, AMAN doo</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </section>

    <!-- Naša Ekspertiza Sekcija -->
    <section id="expertiza" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <span class="text-xs md:text-sm font-bold text-red-500 uppercase tracking-wider">Naše brojke</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-4">Brojke koje govore same za sebe</h2>
                <p class="mt-4 max-w-2xl text-gray-600 ">
                    Kroz godine rada stekli smo poverenje brojnih klijenata i iskustvo koje nas čini liderima u oblasti
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Stat 1 -->
                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <div class="text-5xl font-extrabold text-red-600 mb-4" x-data="{ count: 0 }"
                             x-init="() => { let start = 0; const end = 100; const duration = 2000;
                         const step = (timestamp) => { if (!start) start = timestamp;
                         const progress = Math.min((timestamp - start) / duration, 1);
                         count = Math.floor(progress * end); if (progress < 1) window.requestAnimationFrame(step); };
                         window.requestAnimationFrame(step); }">
                            <span x-text="count">0</span>+
                        </div>
                        <div class="text-lg font-medium text-gray-900">Zadovoljnih klijenata</div>
                        <div class="mt-2 text-sm text-gray-500">Širom Srbije i regiona</div>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <div class="text-5xl font-extrabold text-red-600 mb-4" x-data="{ count: 0 }"
                             x-init="() => { let start = 0; const end = 10; const duration = 2000;
                         const step = (timestamp) => { if (!start) start = timestamp;
                         const progress = Math.min((timestamp - start) / duration, 1);
                         count = Math.floor(progress * end); if (progress < 1) window.requestAnimationFrame(step); };
                         window.requestAnimationFrame(step); }">
                            <span x-text="count">0</span>+
                        </div>
                        <div class="text-lg font-medium text-gray-900">Godina iskustva</div>
                        <div class="mt-2 text-sm text-gray-500">U oblasti požarne zaštite</div>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <div class="text-5xl font-extrabold text-red-600 mb-4" x-data="{ count: 0 }"
                             x-init="() => { let start = 0; const end = 500; const duration = 2000;
                         const step = (timestamp) => { if (!start) start = timestamp;
                         const progress = Math.min((timestamp - start) / duration, 1);
                         count = Math.floor(progress * end); if (progress < 1) window.requestAnimationFrame(step); };
                         window.requestAnimationFrame(step); }">
                            <span x-text="count">0</span>+
                        </div>
                        <div class="text-lg font-medium text-gray-900">Projekata</div>
                        <div class="mt-2 text-sm text-gray-500">Uspešno realizovanih</div>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <div class="text-5xl font-extrabold text-red-600 mb-4" x-data="{ count: 0 }"
                             x-init="() => { let start = 0; const end = 20; const duration = 2000;
                         const step = (timestamp) => { if (!start) start = timestamp;
                         const progress = Math.min((timestamp - start) / duration, 1);
                         count = Math.floor(progress * end); if (progress < 1) window.requestAnimationFrame(step); };
                         window.requestAnimationFrame(step); }">
                            <span x-text="count">0</span>+
                        </div>
                        <div class="text-lg font-medium text-gray-900">Certifikata</div>
                        <div class="mt-2 text-sm text-gray-500">Međunarodno priznatih</div>
                    </div>
                </div>
            </div>

            <!-- Dodatni blok sa opisom ekspertize -->

        </div>
    </section>
    <!-- Kontakt Sekcija -->
    <section id="kontakt" class="md:py-20 bg-gray-200 ">
        <div class="container mx-auto text-center ">
            <h2 class="text-4xl font-bold text-red-600 mb-4">Spremni za saradnju?</h2>
            <p class="text-gray-700 mb-8 max-w-xl mx-auto">
                Kontaktirajte nas danas i zajedno osigurajmo sigurnost vašeg prostora.
            </p>
            <a href="/kontakt" class="bg-red-600 text-white px-8 py-3 mb-6 rounded-full hover:bg-red-700 transition duration-300">
                <i class="fas fa-envelope"></i> Kontaktirajte Nas
            </a>
        </div>
    </section>
@endsection
