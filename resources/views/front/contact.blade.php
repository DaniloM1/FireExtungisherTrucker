@extends('layouts-front.main')

@section('title', 'Kontakt - Inženjer Tim')
@section('meta_description', 'Kontaktirajte Inženjer Tim za sva pitanja, konsultacije i ponude. Brza i profesionalna podrška na dohvat ruke.')
@section('meta_keywords', 'kontakt, inženjer tim, konsultacije, podrška, ponude')

@section('content')

    <!-- Hero Sekcija -->
    <section id="hero" class="relative h-[50vh] flex items-center overflow-hidden bg-gray-900">
        <!-- Animirana pozadina -->
        <div class="bg-lava"></div>
        <!-- Lagani overlay -->
        <div class="absolute inset-0 bg-black opacity-60"></div>

        <div class="container mx-auto relative z-10 px-4 text-center flex flex-col justify-center h-full">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4 animate-slide-up transition-transform duration-500 hover:scale-105">
                Kontakt
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Imate pitanje ili želite saradnju? Kontaktirajte nas i naš tim stručnjaka će vam se javiti u najkraćem roku.
            </p>
        </div>
    </section>

    <!-- Kontakt Info i Forma Sekcija -->
    <section id="kontakt-forma" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Kontakt Informacije -->
                <div class="flex flex-col justify-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Kontakt Informacije</h2>
                    <p class="text-gray-700 text-base md:text-lg mb-6 leading-relaxed">
                        Bilo da imate pitanje, sugestiju ili zahtev za konsultacije, naš tim je ovde da vam pomogne.
                        Javite nam se putem telefona, emaila ili popunjavanjem formulara.
                    </p>
                    <ul class="text-gray-700 space-y-4">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-600 mr-3"></i>
                           Orasac
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone text-red-600 mr-3"></i>
                            <a href="tel:+381642645425" >+381 64 2645 425</a>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope text-red-600 mr-3"></i>
                            <a href="mailto:inzenjer.tim@gmail.com" class="text-decoration: underline;">inzenjer.tim@gmail.com</a>
                                                </li>
                    </ul>
                    <!-- Mali logo ispod kontakta -->
                    <div class="mt-10 flex justify-center lg:justify-start">
                        <img src="/images/logo.svg" alt="Logo Inženjer Tim" class="w-32 h-auto object-contain">
                    </div>
                </div>

                <!-- Kontakt Forma -->
                <div>
                    <div class="bg-gray-50 rounded-xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Pošaljite poruku</h3>
                        <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                            @if(session('success'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @csrf
                            <div>
                                <label for="name" class="block text-gray-700 font-medium mb-2">Ime i Prezime</label>
                                <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Vaše ime i prezime" required>
                            </div>
                            <div>
                                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                                <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Vaš email" required>
                            </div>
                            <div>
                                <label for="subject" class="block text-gray-700 font-medium mb-2">Naslov Poruke</label>
                                <input type="text" name="subject" id="subject" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Naslov" required>
                            </div>
                            <div>
                                <label for="message" class="block text-gray-700 font-medium mb-2">Poruka</label>
                                <textarea name="message" id="message" rows="5" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-600" placeholder="Vaša poruka" required></textarea>
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-full hover:bg-red-700 transition duration-300">
                                    Pošalji Poruku
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="map" class="py-10 bg-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Naša Lokacija</h2>
            <div class="w-full h-64 md:h-96 rounded-xl overflow-hidden shadow-lg border border-gray-300">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1212.4735296523934!2d20.601814663984204!3d44.340927125322395!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4750b2e3eaf0019d%3A0x76da90bb65c5ba4e!2z0JLQvtC20LTQsCDQmtCw0YDQsNGS0L7RgNGS0LAgNzEsINCe0YDQsNGI0LDRhg!5e1!3m2!1ssr!2srs!4v1742155338933!5m2!1ssr!2srs"
                    width="100%"
                    height="100%"
                    style="border:0; filter: grayscale(20%) brightness(80%);"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>

@endsection
