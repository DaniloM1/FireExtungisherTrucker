@extends('layouts-front.main')

@section('title', 'Početna - Požarna Sigurnost | Inženjer Tim')
@section('meta_description', 'Inženjer Tim – stručnjak za protivpožarnu zaštitu i sigurnost na radu. Inspekcija, ugradnja, edukacija i više.')
@section('meta_keywords', 'požarna zaštita, protivpožarne usluge, sigurnost na radu, inspekcija aparata, evakuacijski planovi')

@section('content')

    <!-- HERO SECTION -->
    <section id="hero" class="relative h-[70vh] flex items-center overflow-hidden">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-60"></div>

        <div class="container mx-auto relative z-10 px-4">
            <div class="flex flex-col md:flex-row items-center justify-between h-full">
                <!-- Left: Headline -->
                <div class="md:w-1/2 flex flex-col justify-center text-center md:text-left mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 transition transform hover:scale-105">
                        Ne dozvolite da vam <span class="text-red-600">posao</span> postane <span class="text-red-600">pepeo</span>
                    </h1>
                    <p class="text-lg text-gray-200 mb-8 max-w-xl">
                        Profesionalne protivpožarne usluge i saveti za sigurnost na radu.
                    </p>
                    <div class="flex flex-row sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('services') }}" class="bg-red-600 text-white px-6 py-3 rounded-full hover:bg-red-700 transition flex items-center gap-2 whitespace-nowrap">
                            <i class="fas fa-fire"></i> Naše Usluge
                        </a>
                        <a href="{{ route('contact') }}" class="bg-white text-red-600 px-6 py-3 rounded-full hover:bg-gray-200 transition flex items-center gap-2 whitespace-nowrap">
                            <i class="fas fa-phone"></i> Kontakt
                        </a>
                    </div>

                </div>

                <!-- Right: Logo & Tagline -->
                <div class="md:w-1/2 flex flex-col items-center justify-center md:justify-end md:-mt-8">
                    <img src="/images/logo-white.svg"
                         alt="Inženjer Tim logo"
                         class="w-3/4 md:w-4/12 max-w-sm object-contain hidden md:block" />
                    <h2 class="hidden md:block text-3xl lg:text-4xl text-gray-200 mt-4 font-bold tracking-wide">
                        INŽENJER <span class="text-red-600">TIM</span>
                    </h2>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section id="usluge" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 sm:px-8 lg:px-10">
            <!-- Heading -->
            <div class="text-center mb-12 max-w-xl mx-auto">
                <span class="block text-xs font-semibold tracking-widest text-red-600 uppercase mb-2">
                    Naše Usluge
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                    Sveobuhvatna zaštita od požara
                </h2>
                <p class="mt-3 text-gray-600 text-sm md:text-base">
                    Od redovnih pregleda i inspekcija aparata do izrade evakuacionih planova i edukacije – sve za vašu bezbednost.
                </p>
            </div>

            @php
                $services = [
                    ['route'=>'services.inspection',   'icon'=>'fa-fire-extinguisher', 'title'=>'Inspekcija Aparata',   'text'=>'Redovni pregledi i testovi protivpožarne opreme.'],
                    ['route'=>'services.installation', 'icon'=>'fa-tools',             'title'=>'Ugradnja i Servis',    'text'=>'Profesionalna ugradnja i održavanje sistema.'],
                    ['route'=>'services.evacuation',   'icon'=>'fa-map',               'title'=>'Evakuacioni Planovi',  'text'=>'Prilagođeni planovi za brzu i sigurnu evakuaciju.'],
                    ['route'=>'services.exam',         'icon'=>'fa-graduation-cap',   'title'=>'Stručni Ispiti',       'text'=>'Priprema i polaganje ispita iz požarne zaštite.'],
                    ['route'=>'services.protection',   'icon'=>'fa-shield-alt',       'title'=>'Protivpožarni Sistemi','text'=>'Projektovanje i implementacija zaštitnih sistema.'],
                    ['route'=>'services.training',     'icon'=>'fa-bullhorn',         'title'=>'Obuke i Edukacije',    'text'=>'Praktične obuke o rukovanju opremom i prvoj pomoći.'],
                ];
            @endphp

                <!-- Services Grid -->
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($services as $s)
                    <a href="{{ route($s['route']) }}" class="group block rounded-xl bg-white p-8 shadow-md ring-1 ring-gray-200 hover:ring-red-400 hover:shadow-lg transition-transform duration-300 hover:-translate-y-2">
                        <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mb-6 text-red-600 text-2xl">
                            <i class="fas {{ $s['icon'] }}"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $s['title'] }}</h3>
                        <p class="text-gray-700 text-base leading-relaxed mb-4">{{ $s['text'] }}</p>
                        <span class="inline-flex items-center text-sm font-semibold text-red-600 group-hover:text-red-700 transition">
                            Detaljnije
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="5" y1="12" x2="19" y2="12"/>
                                <polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </span>
                    </a>
                @endforeach
            </div>

            <!-- Action Button -->
            <div class="text-center mt-16">
                <a href="{{ route('services') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-10 py-3 rounded-full transition">
                    Pogledaj sve usluge
                    <i class="fa fa-long-arrow-right ml-3"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- EXPERTISE & WHY CHOOSE US -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white shadow-lg rounded-xl overflow-hidden">
                <!-- Expertise -->
                <div class="p-10 bg-gradient-to-r from-red-600 to-red-800 text-white rounded-l-xl flex flex-col justify-center">
                    <h3 class="text-2xl font-bold mb-6">Naša Stručnost</h3>
                    <p class="mb-8 text-lg leading-relaxed">Iskusni inženjeri i tehničari sa višegodišnjom praksom u požarnoj zaštiti i sigurnosti na radu.</p>
                    <ul class="space-y-5">
                        @php
                            $expertiseItems = [
                                'Certifikovani stručnjaci' => 'fa-certificate',
                                'Najsavremenija oprema' => 'fa-tools',
                                'Kontinuirano usavršavanje' => 'fa-graduation-cap',
                            ];
                        @endphp
                        @foreach($expertiseItems as $text => $icon)
                            <li class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-700 bg-opacity-30 flex items-center justify-center">
                                    <i class="fas {{ $icon }} text-white text-lg"></i>
                                </div>
                                <span class="text-white text-lg font-medium">{{ $text }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Why Choose Us -->
                <div class="p-10 rounded-r-xl flex flex-col justify-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Zašto Izabrati Nas?</h3>
                    <p class="text-gray-700 mb-10 text-lg leading-relaxed">Spoj iskustva, tehnologije i personalizovanog pristupa klijentu čini nas liderom u industriji.</p>
                    <div class="space-y-8">
                        @php
                            $whyChooseItems = [
                                ['title'=>'Kompletna Rešenja', 'desc'=>'Od projektovanja do servisiranja – sve na jednom mestu.'],
                                ['title'=>'Brza Reakcija', 'desc'=>'Hitni odgovori i intervencije 24/7.'],
                                ['title'=>'Transparentne Cene', 'desc'=>'Jasni uslovi bez skrivenih troškova.'],
                            ];
                        @endphp
                        @foreach($whyChooseItems as $item)
                            <div>
                                <h4 class="font-semibold text-gray-900 text-xl mb-2">{{ $item['title'] }}</h4>
                                <p class="text-gray-600 text-base">{{ $item['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- STATS -->
    <section id="expertiza" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 text-center mb-12">
            <span class="text-sm font-semibold text-red-600 uppercase tracking-wide">Naše Brojke</span>
            <h2 class="text-4xl font-extrabold text-gray-900 mt-3">Rezultati Koji Govore</h2>
            <p class="text-gray-600 mt-4 max-w-3xl mx-auto">Poverenje stotina klijenata i desetine uspešnih projekata.</p>
        </div>

        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @php
                $stats = [
                    ['end'=>100,'label'=>'Zadovoljnih Klijenata','sub'=>'Širom regiona', 'icon'=>'fa-smile'],
                    ['end'=>10,'label'=>'Godina Iskustva','sub'=>'U industriji', 'icon'=>'fa-briefcase'],
                    ['end'=>500,'label'=>'Projekata','sub'=>'Uspešno realizovanih', 'icon'=>'fa-check-circle'],
                    ['end'=>20,'label'=>'Certifikata','sub'=>'Međunarodno priznatih', 'icon'=>'fa-certificate'],
                ];
            @endphp

            @foreach($stats as $s)
                <div
                    x-data="{ count: 0, observer: null }"
                    x-init="observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const duration = 2000;
                            let start = null;
                            const step = timestamp => {
                                if (!start) start = timestamp;
                                const progress = Math.min((timestamp - start) / duration, 1);
                                count = Math.floor(progress * {{ $s['end'] }});
                                if (progress < 1) window.requestAnimationFrame(step);
                            };
                            window.requestAnimationFrame(step);
                            observer.disconnect();
                        }
                    });
                });
                observer.observe($el);"
                    class="bg-white rounded-lg shadow-md p-8 flex flex-col items-center text-center hover:shadow-xl transition duration-300"
                >
                    <div class="flex items-center justify-center w-16 h-16 mb-5 rounded-full bg-red-100 text-red-600 text-3xl">
                        <i class="fas {{ $s['icon'] }}"></i>
                    </div>
                    <div class="text-5xl font-extrabold text-red-600">
                        <span x-text="count">0</span>+
                    </div>
                    <div class="mt-4 text-xl font-semibold text-gray-900">{{ $s['label'] }}</div>
                    <div class="mt-1 text-sm text-gray-600">{{ $s['sub'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- CONTACT CTA -->
    <section id="kontakt" class="py-16 bg-gray-200 text-center">
        <div class="max-w-xl mx-auto px-6 sm:px-8">
            <h2 class="text-4xl font-extrabold text-red-600 mb-5">Spremni Za Saradnju?</h2>
            <p class="text-gray-700 mb-10 max-w-lg mx-auto text-lg leading-relaxed">Javite nam se danas i osigurajmo zajedno sigurnost vašeg objekta.</p>
            <a href="{{ route('contact') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold px-10 py-3 rounded-full transition duration-300">
                <i class="fas fa-envelope mr-2"></i> Kontaktirajte Nas
            </a>
        </div>
    </section>

@endsection
