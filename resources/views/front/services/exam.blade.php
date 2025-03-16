@extends('layouts-front.main')

@section('title', 'Polaganje Stručnog ispita - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Priprema za polaganje stručnog ispita iz oblasti zaštite od požara uz live predavanja, konsultacije, pristupačne cene i grupne popuste. Kurs obuhvata sedam ključnih predmeta i praktičnu obuku.')
@section('meta_keywords', 'polaganje ispita, stručni ispit, zaštita od požara, normativa, taktika, vatrogasna oprema, kurs, konsultacije, grupni popust, 6 meseci')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 mt-6">
                Polaganje <span class="text-red-500">Stručnog ispita</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Pripremite se za stručni ispit iz zaštite od požara uz sveobuhvatnu obuku i podršku naših eksperata.
            </p>
        </div>
    </section>

    <!-- Sadržaj usluge - Opis kursa -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Sveobuhvatna priprema i live predavanja</h2>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Naš kurs za polaganje stručnog ispita iz oblasti zaštite od požara obuhvata live predavanja, konsultacije i praktičnu obuku. Kurs traje 6 meseci i osmišljen je da kandidatima pruži temeljno znanje iz sedam ključnih predmeta:
                </p>
                <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                    <li><strong>Normativno uređenje zaštite od požara:</strong> Zakonski propisi i standardi.</li>
                    <li><strong>Opasne materije, požar i eksplozija:</strong> Osnove hemijskih opasnosti i preventivnih mera.</li>
                    <li><strong>Preventivna zaštita od požara:</strong> Metode i strategije za sprečavanje incidenata.</li>
                    <li><strong>Sredstva za gašenje požara:</strong> Tehnologija i pravilna upotreba opreme.</li>
                    <li><strong>Stabilni sistemi zaštite od požara:</strong> Integracija sistema za stalnu zaštitu.</li>
                    <li><strong>Vatrogasne sprave i oprema:</strong> Pregled opreme i njenih mogućnosti.</li>
                    <li><strong>Taktika gašenja požara:</strong> Praktične tehnike i operativne procedure.</li>
                </ul>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Kurs je osmišljen tako da kandidati, pored teorijskog znanja, steknu i praktične veštine kroz realne simulacije i radionice. Cena kursa je vrlo povoljna, a nudimo i dodatne grupne popuste. Nakon uspešnog polaganja, dobijate priznato stručno zvanje u oblasti zaštite od požara, što vam otvara nove profesionalne mogućnosti.
                </p>
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
                        <span class="text-xl font-medium text-gray-900">Koliko traje kurs i koliko su časovi?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Kurs traje 6 meseci, a nastava se sastoji iz predavanja i praktičnih radionica prema utvrđenim nastavnim planovima. Na primer, normativno uređenje obuhvata 16 časova, dok taktika gašenja požara može imati i do 30 časova, u zavisnosti od stepena obrazovanja kandidata.
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Koji predmeti su obuhvaćeni kursom?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Ispit obuhvata sedam ključnih predmeta: normativa i propisi, opasne materije, preventivna zaštita, sredstva za gašenje, stabilni sistemi, vatrogasne sprave i taktika gašenja požara. Pored toga, prakticni deo posebne obuke obuhvata rad sa opremom i simulacije stvarnih hitnih situacija.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Koje zvanje dobijam nakon uspešnog polaganja ispita?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Nakon uspešnog polaganja, kandidat dobija priznato stručno zvanje u oblasti zaštite od požara, što potvrđuje njegovu stručnost i otvara mogućnosti za zaposlenje u javnom i privatnom sektoru.
                    </div>
                </div>
                <!-- FAQ Item 4 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Da li se nude grupni popusti i dodatne radionice?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Da, nudimo dodatne radionice, pripremne kurseve i grupne popuste kako bismo obezbedili što pristupačniju pripremu za stručni ispit.
                    </div>
                </div>
                <!-- FAQ Item 5 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Koji su uslovi prijave za ispit?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Prijava se podnosi preko pravnog lica koje je sprovelo posebnu obuku, uz dostavljanje potrebne dokumentacije (izvod iz matične knjige rođenih, overena diploma, potvrda o radnom iskustvu i slično). Kandidati moraju ispuniti uslove iz Pravilnika.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
