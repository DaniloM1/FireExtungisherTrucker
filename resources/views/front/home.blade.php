@extends('layouts-front.main')

@section('title', 'Početna - Požarna Sigurnost')
@section('meta_description', 'Dobrodošli na Požarnu Sigurnost, vašeg partnera za protivpožarne usluge.')
@section('meta_keywords', 'požarna sigurnost, protivpožarne usluge, zaštita, sigurnost')

@section('content')
    <style>
        .bg-lava {
            /* Osnovne (desktop) dimenzije i stil */
            background: url('/images/hero-background.jpg') center/cover no-repeat;
            position: absolute;
            width: 120%;
            height: 120%;
            top: -10%;
            left: -5%;
            animation: lavaMove 17s ease-in-out infinite;
        }

        /* Keyframes animacije */
        @keyframes lavaMove {
            0% {
                transform: translate(0,0) scale(1) rotate(0deg);
            }
            25% {
                transform: translate(-2%, -1%) scale(1.03) rotate(-1deg);
            }
            50% {
                transform: translate(-3%, -3%) scale(1.05) rotate(1deg);
            }
            75% {
                transform: translate(-2%, -2%) scale(1.04) rotate(-2deg);
            }
            100% {
                transform: translate(0,0) scale(1) rotate(0deg);
            }
        }

        /* Za mobilne telefone (max-width: 640px ili 768px) -
           biraj breakpoint u zavisnosti od projekta */
        @media (max-width: 640px) {
            .bg-lava {
                /* Povećaj dimenzije i pomeri još malo */
                width: 150%;
                height: 140%;
                top: -15%;
                left: -10%;
            }
        }


    </style>

    <section id="hero" class="relative h-[80vh] flex items-center overflow-hidden">
        <!-- Animirana pozadina -->
        <div class="bg-lava"></div>

        <!-- Lagani overlay -->
        <div class="absolute inset-0 bg-black opacity-60"></div>

        <div class="container mx-auto relative z-10 px-4">
            <div class="flex flex-col md:flex-row items-center justify-between h-full">

                <!-- LEVA STRANA: Naslov i tekst -->
                <div class="md:w-1/2 flex flex-col justify-center text-center md:text-left mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 transition duration-500 ease-in-out transform hover:scale-105">
                        Ne dozvolite da vam posao postane  <span class="text-red-500">pepeo</span>
                    </h1>
                    <p class="text-base md:text-lg lg:text-xl text-gray-200 mb-8">
                        Proizvodna i uslužna radnja za bezbednost i zdravlje na radu.
                    </p>
                    <div class="space-y-4 md:space-y-0 md:space-x-4 flex flex-col md:flex-row justify-center md:justify-start">
                        <a href="#usluge" class="bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 transition duration-300 inline-block">
                            <i class="fas fa-fire"></i> Naše Usluge
                        </a>
                        <a href="#kontakt" class="bg-white text-red-600 px-6 py-3 rounded-full hover:bg-gray-200 transition duration-300 inline-block">
                            <i class="fas fa-phone"></i> Kontakt
                        </a>
                    </div>
                </div>

                <div class="md:w-1/2 flex flex-col items-center justify-center md:justify-end md:-mt-8">
                    <!-- Ilustracija -->
                    <img src="/images/logo-white.svg"
                         alt="Ilustracija protupožarne zaštite"
                         class="w-3/4 md:w-full max-w-sm object-contain hidden md:block">
                    <!-- Tekst ispod slike -->
                    <h1 class="hidden md:block text-4xl md:text-3xl lg:text-4xl text-gray-200 mt-4 font-bold">
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
                    <a
                        href="#vise"
                        class="inline-block bg-red-600 text-white px-4 py-2 md:px-6 md:py-2 rounded-full hover:bg-red-700 transition duration-300 text-sm md:text-lg"
                    >
                        Saznaj Više
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

    <!-- Naši Partneri Sekcija -->
    <section id="partneri" class="py-10 md:py-20 bg-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Grid: Na mobilu jedna kolona, na desktopu dve kolone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                <!-- Logos blok: Na mobilu se prikazuje kao drugi element, a na desktopu kao prvi (levo) -->
                <div class="order-2 md:order-1">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 items-center">
                        <!-- Logo 1 -->
                        <div class="flex justify-center">
                            <img src="{{ asset('images/aman-logo.jpg') }}" alt="Partner Logo" class="object-contain h-16">
                        </div>
                        <!-- Logo 2 -->
                        <div class="flex justify-center">
                            <img src="{{ asset('images/knjaz-logo.png') }}" alt="Partner Logo" class="object-contain h-16">
                        </div>
                        <!-- Logo 3 -->
                        <div class="flex justify-center">
                            <img src="{{ asset('images/aman-logo.jpg') }}" alt="Partner Logo" class="object-contain h-16">
                        </div>
                        <!-- Logo 4 -->
                        <div class="flex justify-center">
                            <img src="{{ asset('images/knjaz-logo.png') }}" alt="Partner Logo" class="object-contain h-16">
                        </div>
                        <!-- Dodajte još logotipa po potrebi -->
                    </div>
                </div>

                <!-- Tekstualni blok: Na mobilu se prikazuje kao prvi element, a na desktopu kao drugi (desno) -->
                <div class="order-1 md:order-2 text-left md:text-left">
                    <h2 class="text-xs md:text-sm font-bold text-red-500 uppercase mb-2">Naši Partneri</h2>
                    <h3 class="text-2xl md:text-4xl font-bold text-gray-900 mb-3 md:mb-4">
                        Saradnja koja donosi rezultate
                    </h3>
                    <p class="text-gray-600 mb-4 md:mb-6 text-sm md:text-base">
                        Ponosno sarađujemo s vrhunskim partnerima kako bismo našim klijentima ponudili najbolje rešenje.
                    </p>
                    <a href="#partneri" class="inline-block bg-red-600 text-white px-4 py-2 md:px-6 md:py-2 rounded-full hover:bg-red-700 transition duration-300 text-sm md:text-lg">
                        Saznaj Više
                    </a>
                </div>

            </div>
        </div>
    </section>




    <!-- Kontakt Sekcija -->
    <section id="kontakt" class="py-16 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold text-red-600 mb-4">Spremni za saradnju?</h2>
            <p class="text-gray-700 mb-8 max-w-xl mx-auto">
                Kontaktirajte nas danas i zajedno osigurajmo sigurnost vašeg prostora.
            </p>
            <a href="/kontakt" class="bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300">
                <i class="fas fa-envelope"></i> Kontaktirajte Nas
            </a>
        </div>
    </section>
@endsection
