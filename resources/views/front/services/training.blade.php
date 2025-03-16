@extends('layouts-front.main')

@section('title', 'Obuke i Edukacija - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Obuke i edukacije o korišćenju protivpožarne opreme, sigurnosnim procedurama i praktičnim radionicama, prilagođene firmama i korporacijama.')
@section('meta_keywords', 'obuke, edukacija, protivpožarna oprema, sigurnost, radionice, firme, korporativna obuka')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 mt-6">Obuke i <span class="text-red-500">Edukacija</span></h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Edukacije i radionice za pravilno korišćenje protivpožarne opreme i sigurnosnih procedura, prilagođene potrebama firmi.
            </p>
        </div>
    </section>

    <!-- Sadržaj usluge - Opis obuka -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Praktične obuke i radionice po firmama</h2>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Naše obuke pokrivaju sve aspekte korišćenja protivpožarne opreme, sigurnosnih procedura i hitnih intervencija. Organizujemo obuke posebno prilagođene firmama i korporacijama, u kojima se kombinuje teorijska edukacija sa praktičnim radionicama. Programi se mogu prilagoditi specifičnim potrebama vašeg preduzeća, bilo da se radi o osnovnoj edukaciji zaposlenih ili o naprednim obukama za menadžere i timove za hitne situacije.
                </p>
                <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                    <li><strong>Obuka o korišćenju PP opreme:</strong> Praktične radionice za pravilnu upotrebu i održavanje opreme.</li>
                    <li><strong>Sigurnosne procedure:</strong> Detaljna edukacija o procedurama evakuacije i hitnim intervencijama.</li>
                    <li><strong>Korporativni programi:</strong> Prilagođeni kursevi za firme sa grupnim popustima i mogućnošću zakazivanja obuka na lokaciji.</li>
                </ul>
                <p class="text-gray-700 mb-6 leading-relaxed">
                    Naši instruktori sa višegodišnjim iskustvom u oblasti zaštite od požara pružaju praktične savete i demonstracije, osiguravajući da vaši zaposleni budu spremni da reaguju u vanrednim situacijama. Svi programi su dizajnirani tako da se lako integrišu u radni raspored firme.
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
                        <span class="text-xl font-medium text-gray-900">Kako se prilagođavaju obuke za firme?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Naše obuke se mogu potpuno prilagoditi potrebama vaše firme – od broja učesnika, vremenskog rasporeda, do specifičnih tema koje želite da obuhvatimo. Možemo organizovati obuku na lokaciji ili u našim centrima, uz mogućnost grupnih popusta.
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Koje teme obuhvata program obuke?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Program obuke obuhvata teme kao što su pravilna upotreba protivpožarne opreme, sigurnosne procedure, evakuacijski planovi, hitne intervencije i održavanje opreme. Takođe se pokrivaju i specifične situacije u industriji ili poslovnim sektorima vaše firme.
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Da li nudite grupne popuste za obuke?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Da, za veće grupe nudimo posebne popuste, a cene se mogu dodatno prilagoditi specifičnim zahtevima vaše firme. Kontaktirajte nas za detaljne informacije i ponudu.
                    </div>
                </div>
                <!-- FAQ Item 4 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Koja je trajnost i učestalost obuka?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Obuke se organizuju periodično, a možemo prilagoditi učestalost i trajanje treninga prema vašim potrebama – bilo da je to osnovna obuka za nove zaposlene ili periodične refresher radionice za postojeće timove.
                    </div>
                </div>
                <!-- FAQ Item 5 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Kako se upisujete i rezervišu termini za obuku?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Termin obuke se rezerviše putem naše kontakt forme ili telefonski. Naš tim će vam pomoći da izaberete termin koji najbolje odgovara vašoj firmi.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
