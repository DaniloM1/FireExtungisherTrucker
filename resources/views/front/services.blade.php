@extends('layouts-front.main')

@section('title', 'Usluge - Požarna Sigurnost - inženjer Tim')
@section('meta_description', 'Kompletne protivpožarne usluge i sistemi zaštite. Inspekcije, instalacije, obuke i više.')
@section('meta_keywords', 'protivpožarne usluge, instalacija alarmnih sistema, vatrogasna obuka, servis aparata')

@section('content')
    <section id="hero" class="relative h-[50vh] flex items-center overflow-hidden bg-gray-900">
        <!-- Animirana pozadina -->
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-60"></div>

        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-slide-up">
                Naše <span class="text-red-500">Usluge</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Kompletne protivpožarne solucije prilagođene vašim potrebama
            </p>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                <!-- Inspekcija Aparata -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-fire-extinguisher text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Inspekcija Aparata</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Redovni pregledi opreme
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Dokumentovani izveštaji
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Savetovanje za održavanje
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{route('services.inspection')}}" class="text-red-600 hover:text-red-700 font-semibold">
                                Opširnije →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Protivpožarni Sistemi -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-shield-alt text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Protivpožarni Sistemi</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Projektovanje i instalacija
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Pametni alarmni sistemi
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                24/7 monitoring
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{route('services.protection')}}" class="text-red-600 hover:text-red-700 font-semibold">
                                Opširnije →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Evakuacijski Planovi -->
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-map-marked-alt text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Evakuacijski Planovi</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Analiza prostora
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Digitalna i fizička verzija
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Obuka osoblja
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{route("services.evacuation")}}" class="text-red-600 hover:text-red-700 font-semibold">
                                Opširnije →
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-tools text-red-600 text-2xl"></i>

                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Ugradnja i Servis</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Ugradnja PP aparata
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Periodican servis
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Dopuna i remont aparata
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{route("services.installation")}}" class="text-red-600 hover:text-red-700 font-semibold">
                                Opširnije →
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas fa-graduation-cap text-red-600 text-2xl"></i>

                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Polaganje Stručnog ispita</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Live predavanja
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Konsultacije
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Grupni popust
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{route("services.exam")}}" class="text-red-600 hover:text-red-700 font-semibold">
                                Opširnije →
                            </a>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                            <i class="fas  fa-bullhorn text-red-600 text-2xl"></i>

                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Obuke i Edukacija</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Obuke o koricenju PP opreme
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Edukacija
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check-circle text-red-500 mr-2"></i>
                                Obuka
                            </li>
                        </ul>
                        <div class="mt-6">
                            <a href="{{route("services.training")}}" class="text-red-600 hover:text-red-700 font-semibold">
                                Opširnije →
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Ostatak usluga (slična struktura) -->

            </div>

            <!-- CTA Sekcija -->
            <div class="mt-20 text-center bg-red-600 rounded-xl py-12 px-4">
                <h2 class="text-3xl font-bold text-white mb-4">Niste pronašli šta tražite?</h2>
                <p class="text-red-100 mb-8 max-w-xl mx-auto">
                    Naš tim stručnjaka je tu da vam pomogne sa svim vrstama protivpožarnih zaštita
                </p>
                <a href="/kontakt" class="inline-block bg-white text-red-600 px-8 py-3 rounded-full hover:bg-gray-100 transition duration-300">
                    <i class="fas fa-comments mr-2"></i> Konsultujte nas besplatno
                </a>
            </div>
        </div>
    </section>
@endsection
