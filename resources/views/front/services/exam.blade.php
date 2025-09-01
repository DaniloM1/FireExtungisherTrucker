@extends('layouts-front.main')

@section('title', 'Polaganje stručnog ispita zaštite od požara – Online kurs i priprema | Inženjer Tim')
@section('meta_description', 'Priprema za stručni ispit zaštite od požara – 6 meseci kursa, online predavanja, konsultacije i praktična obuka uz stručne mentore.')
@section('meta_keywords', 'stručni ispit zaštite od požara, kurs zaštite od požara, obuka vatrogasci, online kurs, polaganje ispita, normativa, taktika, vatrogasna oprema, konsultacije, grupni popust, 6 meseci')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 mt-6">
                Polaganje <span class="text-red-500">stručnog ispita zaštite od požara</span>
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Pripremite se za stručni ispit zaštite od požara uz online predavanja, konsultacije i praktične radionice.
            </p>
        </div>
    </section>

    <!-- Sadržaj usluge - Opis kursa -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Priprema za stručni ispit zaštite od požara – online kurs</h2>

                <!-- Blok: Tekst + slika pored -->
                <div class="flex flex-col md:flex-row gap-6 mb-8">
                    <!-- Tekst -->
                    <div class="md:w-2/3">
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            Naš kurs za polaganje stručnog ispita iz oblasti zaštite od požara obuhvata <strong>online predavanja, konsultacije i praktičnu obuku</strong>. Kurs traje <strong>7 nedelja</strong> i osmišljen je da kandidatima pruži temeljno znanje iz sedam ključnih predmeta, uz interaktivne vežbe i rad sa opremom.
                        </p>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            Poseban akcenat stavljamo na praktičnu primenu znanja kroz <strong>realne simulacije</strong>. Kandidati stiču veštine za efikasno postupanje u hitnim situacijama, što im obezbeđuje sigurnost na ispitu i kasnije u profesionalnom radu.
                    </div>

                    <!-- Slika -->
                    <div class="hidden lg:flex lg:w-1/3 justify-end">
                        <img
                            src="{{ asset('images/exam.png') }}"
                            alt="Kurs za stručni ispit zaštite od požara – online obuka"
                            class="w-40 lg:w-64 drop-shadow-md rounded-md"
                        />
                    </div>
                </div>

                <!-- Blok: Lista predmeta -->
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Sadržaj kursa</h2>
                <ul class="list-disc pl-5 text-gray-700 mb-6 space-y-2">
                    <li><strong>Normativno uređenje zaštite od požara:</strong> Zakonski propisi i standardi.</li>
                    <li><strong>Opasne materije, požar i eksplozija:</strong> Hemijske opasnosti i preventivne mere.</li>
                    <li><strong>Preventivna zaštita od požara:</strong> Strategije za sprečavanje incidenata.</li>
                    <li><strong>Sredstva za gašenje požara:</strong> Tehnologija i pravilna upotreba opreme.</li>
                    <li><strong>Stabilni sistemi zaštite od požara:</strong> Integracija sistema za trajnu zaštitu.</li>
                    <li><strong>Vatrogasne sprave i oprema:</strong> Pregled opreme i njene primene.</li>
                    <li><strong>Taktika gašenja požara:</strong> Praktične tehnike i operativne procedure.</li>
                </ul>

                <!-- Zaključak -->
                <p class="text-gray-700 mb-8 leading-relaxed">
                    
                    Kurs je osmišljen tako da kandidati, pored teorijskog znanja, steknu i praktične veštine kroz realne simulacije i radionice. Cena kursa je vrlo povoljna, a nudimo i dodatne <strong>grupne popuste</strong>. Nakon uspešnog polaganja, dobijate priznato stručno zvanje u oblasti zaštite od požara.
                    <br>
                    Nakon uspešno završenog kursa, kandidati pristupaju polaganju stručnog ispita pred komisijom Sektora za vanredne situacije. Ispit se organizuje po grupama, u skladu sa zvaničnim pravilnicima i procedurama.                        </p>

                </p>

                <a href="{{ route('contact') }}" class="inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300">
                    Kontaktirajte nas
                </a>

                <!-- Slika za male ekrane -->
                <div class="flex sm:hidden w-full justify-center mt-8">
                    <img
                        src="{{ asset('images/exam.png') }}"
                        alt="Online kurs za stručni ispit zaštite od požara"
                        class="w-60 drop-shadow-md rounded-md"
                    />
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
                        <span class="text-xl font-medium text-gray-900">Koliko traje kurs i koliko su časovi?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Kurs traje 7 nedelja i uključuje predavanja i praktične radionice. Za svaki predmet je odvojen subota i nedelja po 2 sata online predavanja. Takođe postoje i konsultacije                    </div>
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
                        Kurs obuhvata 7 ključnih predmeta: normativa i propisi, opasne materije, preventivna zaštita, sredstva za gašenje, stabilni sistemi, vatrogasne sprave i taktika gašenja požara.
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
                        Nakon polaganja dobijate priznato stručno zvanje u oblasti zaštite od požara, što otvara mogućnosti zapošljavanja u javnom i privatnom sektoru.
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div x-data="{ open: false }" class="border border-gray-200 rounded-md">
                    <button @click="open = !open" class="flex justify-between items-center w-full px-4 py-3 text-left focus:outline-none">
                        <span class="text-xl font-medium text-gray-900">Da li nudite grupne popuste i dodatne konsultacije?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak class="px-4 pb-4 text-gray-700">
                        Da, nudimo dodatne konsultacije, pripremne kurseve i grupne popuste kako bismo obezbedili što pristupačniju pripremu.
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
                        Prijava se podnosi preko pravnog lica koje je sprovelo obuku, uz dostavljanje potrebne dokumentacije (izvod iz matične knjige rođenih, diploma, potvrda o radnom iskustvu).
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Schema Markup (SEO Rich Snippets) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "Koliko traje kurs i koliko su časovi?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Kurs traje 7 nedelja i uključuje predavanja i praktične radionice. Za svaki predmet je odvojen subota i nedelja po 2 sata online predavanja. Takođe postoje i konsultacije"
          }
        },
        {
          "@type": "Question",
          "name": "Koji predmeti su obuhvaćeni kursom?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Kurs obuhvata 7 predmeta: normativa i propisi, opasne materije, preventivna zaštita, sredstva za gašenje, stabilni sistemi, vatrogasne sprave i taktika gašenja požara."
          }
        },
        {
          "@type": "Question",
          "name": "Koje zvanje dobijam nakon uspešnog polaganja ispita?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Dobijate priznato stručno zvanje u oblasti zaštite od požara koje omogućava zaposlenje u javnom i privatnom sektoru."
          }
        },
        {
          "@type": "Question",
          "name": "Da li nudite grupne popuste i dodatne konsultacije?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Da, nudimo grupne popuste i dodatne konsultacije kako bi priprema bila pristupačnija i kvalitetnija."
          }
        },
        {
          "@type": "Question",
          "name": "Koji su uslovi prijave za ispit?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Prijava se podnosi preko pravnog lica koje je sprovelo obuku, uz potrebna dokumenta kao što su izvod iz matične knjige rođenih, diploma i potvrda o iskustvu."
          }
        }
      ]
    }
    </script>
@endsection
