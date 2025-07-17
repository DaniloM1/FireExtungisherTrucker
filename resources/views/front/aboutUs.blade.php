@extends('layouts-front.main')

@section('title', 'O nama - Protivpožarna zašita | Inženjer Tim')
@section('meta_description', 'Upoznajte naš stručni inženjerski tim specijalizovan za protivpožarnu zaštitu i sigurnost. Posvećenost, inovacija i profesionalizam u svakom projektu.')
@section('meta_keywords', 'o nama, inženjerski tim, protivpožarna zaštita, sigurnost, profesionalni inženjeri, inovacija, misija, vizija, kontakt')

@section('content')

    <!-- Hero Sekcija -->
    <section id="hero" class="relative h-[50vh] flex items-center overflow-hidden bg-gray-900">
        <!-- Animirana pozadina -->
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-60"></div>

        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 animate-slide-up">
                O <span class="text-red-500">nama</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Upoznajte naš tim stručnjaka sa dugogodišnjim iskustvom i posvećenošću kvalitetu.
            </p>
        </div>
    </section>

    <section id="nasaprica" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <!-- LEVA KOLONA: Tekst -->
                <div class="bg-white rounded-xl p-8 transition-shadow duration-300">
                    <h2 class="text-xs md:text-sm font-bold text-red-500 uppercase mb-2">Naša Priča</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Inovacija i Stručnost u Svakom Koraku
                    </h3>
                    <p class="text-gray-600 text-base md:text-lg mb-8 leading-relaxed">
                        Naš stručni tim specijalizovan za protivpožarnu zaštitu i sigurnost na radu osnovan je sa jasnim ciljem – pružanje vrhunskih usluga kroz inovativna i prilagođena rešenja. Kroz višegodišnje iskustvo, okupili smo profesionalce iz različitih oblasti inženjerstva, omogućavajući nam da kreiramo efikasne i sigurne sisteme zaštite koji zadovoljavaju specifične potrebe svakog klijenta.
                    </p>
                </div>

                <!-- DESNA KOLONA: Logo centriran -->
                <div class="flex flex-col justify-center items-center">
                    <img src="/images/logo.svg" width="300" height="350" alt="Logo Inženjer Tim" class="max-w-full h-auto">
                    <h1 class="mt-4 text-2xl md:text-2xl lg:text-4xl text-black-200 font-bold">
                        INŽENJER <span class="text-red-500">TIM</span>
                    </h1>
                </div>


            </div>
        </div>
    </section>

    <!-- Misija i Vizija Sekcija -->
    <section id="misija-vizija" class="py-16 bg-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Naša Misija -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xs md:text-sm font-bold text-red-500 uppercase mb-2">Naša Misija</h3>
                    <h4 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Posvećenost i Inovacija</h4>
                    <p class="text-gray-600 text-base md:text-lg">
                        Naša misija je pružanje kvalitetnih usluga kroz kontinuirano unapređenje procesa i inovativna rješenja, osiguravajući maksimalnu sigurnost i pouzdanost.
                    </p>
                </div>
                <!-- Naša Vizija -->
                <div class="bg-white rounded-xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300">
                    <h3 class="text-xs md:text-sm font-bold text-red-500 uppercase mb-2">Naša Vizija</h3>
                    <h4 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">Vodstvo u Industriji</h4>
                    <p class="text-gray-600 text-base md:text-lg">
                        Težimo da budemo lider u industriji, pružajući inovativna rješenja koja postavljaju standarde kvaliteta i sigurnosti, te stvarajući dugoročne partnerske odnose.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontakt Sekcija -->
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
