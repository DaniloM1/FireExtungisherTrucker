<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Požarna Sigurnost - Vaš Partner za Protivpožarne Usluge</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    />
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <!-- Swiper CSS (Slider) -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
    />

    <!-- Animacije za pozadinske elemente -->
    <style>
        /* Animacija koja pomiče element udesno i natrag */
        @keyframes moveRight {
            0% {
                transform: translateX(0);
                opacity: 0.5;
            }
            50% {
                transform: translateX(150px);
                opacity: 1;
            }
            100% {
                transform: translateX(0);
                opacity: 0.5;
            }
        }
        /* Animacija koja pomiče element ulijevo i natrag */
        @keyframes moveLeft {
            0% {
                transform: translateX(0);
                opacity: 0.2;
            }
            50% {
                transform: translateX(-150px);
                opacity: 0.5;
            }
            100% {
                transform: translateX(0);
                opacity: 0.2;
            }
        }
        /* Animacija koja pomiče element prema gore i natrag */
        @keyframes moveUp {
            0% {
                transform: translateY(0);
                opacity: 0.5;
            }
            50% {
                transform: translateY(-100px);
                opacity: 1;
            }
            100% {
                transform: translateY(0);
                opacity: 0.5;
            }
        }
        /* Animacija koja diagonalno pomiče element */
        @keyframes moveDiagonal {
            0% {
                transform: translate(0, 0);
                opacity: 0.2;
            }
            50% {
                transform: translate(-100px, -100px);
                opacity: 0.5;
            }
            100% {
                transform: translate(0, 0);
                opacity: 0.2;
            }
        }
        /* Primjena animacija */
        .animate-moveRight {
            animation: moveRight 15s linear infinite;
        }
        .animate-moveLeft {
            animation: moveLeft 15s linear infinite;
        }
        .animate-moveUp {
            animation: moveUp 15s linear infinite;
        }
        .animate-moveDiagonal {
            animation: moveDiagonal 20s linear infinite;
        }
    </style>
</head>
<body class="antialiased dark:bg-black dark:text-white/50">
<!-- Navigacija -->
<nav class="fixed w-full bg-white shadow-sm z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <img src="logo.png" alt="Logo" class="h-8 w-auto" />
                <!-- Desktop Menu -->
                <div class="hidden md:flex space-x-8 ml-10">
                    <a href="#" class="text-gray-700 hover:text-red-600 font-medium"
                    >Početna</a
                    >
                    <a href="#" class="text-gray-700 hover:text-red-600 font-medium"
                    >Usluge</a
                    >
                    <a href="#" class="text-gray-700 hover:text-red-600 font-medium"
                    >O nama</a
                    >
                    <a href="#" class="text-gray-700 hover:text-red-600 font-medium"
                    >Kontakt</a
                    >
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Dio za login/registraciju -->
                @if (Route::has('login'))
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-gray-700 ring-1 ring-transparent transition hover:text-gray-500 focus:outline-none focus-visible:ring-red-600"
                        >Dashboard</a
                        >
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-gray-700 ring-1 ring-transparent transition hover:text-gray-500 focus:outline-none focus-visible:ring-red-600"
                        >Log in</a
                        >

                    @endauth
                @endif

                <!-- Gumb "Zatraži Ponudu" -->
                <button
                    class="hidden md:block bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700"
                >
                    Zatraži Ponudu
                </button>
                <!-- Gumb za mobilni menu -->
                <button
                    id="mobile-menu-button"
                    class="md:hidden text-gray-700 hover:text-red-600 focus:outline-none"
                >
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobilni Navigacijski Menu -->
    <div id="mobile-menu" class="md:hidden hidden">
        <div class="px-4 pt-2 pb-4 space-y-1 bg-white shadow">
            <a href="#" class="block text-gray-700 hover:text-red-600 font-medium"
            >Početna</a
            >
            <a href="#" class="block text-gray-700 hover:text-red-600 font-medium"
            >Usluge</a
            >
            <a href="#" class="block text-gray-700 hover:text-red-600 font-medium"
            >O nama</a
            >
            <a href="#" class="block text-gray-700 hover:text-red-600 font-medium"
            >Kontakt</a
            >
            <button
                class="w-full bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700"
            >
                Zatraži Ponudu
            </button>
            <!-- Opcionalno: login linkovi i u mobilnom izborniku -->
            @if (Route::has('login'))
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="block text-gray-700 hover:text-red-600 font-medium"
                    >Dashboard</a
                    >
                @else
                    <a
                        href="{{ route('login') }}"
                        class="block text-gray-700 hover:text-red-600 font-medium"
                    >Log in</a
                    >
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="block text-gray-700 hover:text-red-600 font-medium"
                        >Register</a
                        >
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

<!-- Hero sekcija s animiranim pozadinskim elementima -->
<div class="  overflow-hidden pt-24 pb-12 bg-gradient-to-r from-red-500 to-red-600">
    <!-- Animirani pozadinski elementi -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute" style="top: 10%; left: -50px; opacity: 20%;">
            <i
                class="fas fa-fire-extinguisher text-white text-6xl opacity-30 animate-moveRight"
            ></i>
        </div>
        <div class="absolute" style="top: 40%; right: -50px; opacity: 30%;">
            <i
                class="fas fa-fire-extinguisher text-white text-4xl opacity-30 animate-moveLeft"
            ></i>
        </div>
        <div class="absolute" style="bottom: 10%; left: 20%; opacity: 30%;">
            <i
                class="fas fa-tools text-white text-5xl opacity-30 animate-moveUp"
            ></i>
        </div>
        <div class="absolute" style="bottom: 20%; right: 30%; opacity: 30%;">
            <i
                class="fas fa-fire-extinguisher text-white text-7xl opacity-30 animate-moveDiagonal"
            ></i>
        </div>
    </div>
    <div class="relative">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center"
        >
            <h1
                class="text-4xl md:text-6xl font-bold text-white mb-6"
            >
                Vaša Sigurnost, Naš Prioritet
            </h1>
            <p
                class="text-xl text-white opacity-90 mb-8 max-w-3xl mx-auto"
            >
                Profesionalne usluge inspekcije, ugradnje i održavanja protivpožarne
                opreme, kao i izrada evakuacijskih planova.
            </p>
            <div class="flex justify-center space-x-4">
                <button
                    class="bg-white text-red-600 px-8 py-3 rounded-full text-lg font-semibold hover:shadow-lg"
                >
                    Zatraži Ponudu
                </button>
                <button
                    class="border-2 border-white text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-white hover:text-red-600"
                >
                    Kontaktirajte Nas
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Usluge sekcija -->
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Naše Usluge</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Sve što je potrebno za sigurnost vašeg objekta
            </p>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Inspekcija protivpožarnih aparata -->
            <div
                class="p-6 bg-gray-50 rounded-xl hover:shadow-md transition-shadow"
            >
                <div
                    class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4"
                >
                    <i
                        class="fas fa-fire-extinguisher text-red-600 text-xl"
                    ></i>
                </div>
                <h3 class="text-xl text-black font-semibold mb-2">
                    Inspekcija Aparata
                </h3>
                <p class="text-gray-600">
                    Redovne preglede i inspekcije protivpožarne opreme kako bi uvijek
                    bila spremna za akciju.
                </p>
            </div>
            <!-- Ugradnja i servis -->
            <div
                class="p-6 bg-gray-50 rounded-xl hover:shadow-md transition-shadow"
            >
                <div
                    class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4"
                >
                    <i class="fas fa-tools text-orange-600 text-xl"></i>
                </div>
                <h3 class="text-xl text-black font-semibold mb-2">
                    Ugradnja i Servis
                </h3>
                <p class="text-gray-600">
                    Stručna ugradnja i redovno održavanje opreme od strane certificiranih
                    profesionalaca.
                </p>
            </div>
            <!-- Evakuacijski planovi -->
            <div
                class="p-6 bg-gray-50 rounded-xl hover:shadow-md transition-shadow"
            >
                <div
                    class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4"
                >
                    <i class="fas fa-map text-yellow-600 text-xl"></i>
                </div>
                <h3 class="text-xl text-black font-semibold mb-2">
                    Evakuacijski Planovi
                </h3>
                <p class="text-gray-600">
                    Izrada detaljnih i prilagođenih evakuacijskih planova za sigurnu
                    evakuaciju u hitnim slučajevima.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Sekcija Partneri sa sliderom -->
<div class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Partneri</h2>
            <p class="text-gray-600">
                Ponosno surađujemo s ovim vrhunskim firmama
            </p>
        </div>
        <!-- Swiper Slider -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div
                    class="swiper-slide flex justify-center items-center"
                >
                    <img
                        src="aman-logo.jpg"
                        alt="Firma 1"
                        class="object-contain"
                    />
                </div>
                <div
                    class="swiper-slide flex justify-center items-center"
                >
                    <img
                        src="aman-logo.jpg"
                        alt="Firma 2"
                        class="object-contain"
                    />
                </div>
                <div
                    class="swiper-slide flex justify-center items-center"
                >
                    <img
                        src="aman-logo.jpg"
                        alt="Firma 3"
                        class="object-contain"
                    />
                </div>
                <div
                    class="swiper-slide flex justify-center items-center"
                >
                    <img
                        src="aman-logo.jpg"
                        alt="Firma 4"
                        class="object-contain"
                    />
                </div>
                <div
                    class="swiper-slide flex justify-center items-center"
                >
                    <img
                        src="aman-logo.jpg"
                        alt="Firma 5"
                        class="object-contain"
                    />
                </div>
                <div
                    class="swiper-slide flex justify-center items-center"
                >
                    <img
                        src="aman-logo.jpg"
                        alt="Firma 6"
                        class="object-contain"
                    />
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials sekcija -->
<div class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Šta Naši Klijenti Kažu
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Pouzdani partneri u zaštiti vašeg poslovanja
            </p>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-sm">
                <p class="text-gray-600 mb-4">
                    "Izvrsna usluga i profesionalan pristup. Naši objekti su sada sigurniji
                    nego ikada!"
                </p>
                <div class="flex items-center">
                    <img
                        src="https://via.placeholder.com/50"
                        alt="Avatar"
                        class="w-12 h-12 rounded-full"
                    />
                    <div class="ml-4">
                        <h4 class="font-semibold">Marko Kovač</h4>
                        <p class="text-gray-600 text-sm">
                            Direktor, Poduzeće d.o.o.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-8 rounded-xl shadow-sm">
                <p class="text-gray-600 mb-4">
                    "Profesionalan tim i brza reakcija. Preporučujem njihove usluge svim
                    tvrtkama."
                </p>
                <div class="flex items-center">
                    <img
                        src="https://via.placeholder.com/50"
                        alt="Avatar"
                        class="w-12 h-12 rounded-full"
                    />
                    <div class="ml-4">
                        <h4 class="font-semibold">Ivana Horvat</h4>
                        <p class="text-gray-600 text-sm">Voditeljica sigurnosti</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Newsletter sekcija -->
<div class="py-16 bg-red-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-white">
            <h2 class="text-3xl font-bold mb-4">
                Budite Uvijek Informirani
            </h2>
            <p class="mb-8 max-w-xl mx-auto">
                Prijavite se za naš newsletter i saznajte najnovije informacije i savjete
                o protupožarnoj sigurnosti.
            </p>
            <div class="max-w-md mx-auto flex gap-4">
                <input
                    type="email"
                    placeholder="Unesite vašu email adresu"
                    class="flex-1 px-4 py-3 rounded-lg focus:outline-none text-gray-900"
                />
                <button
                    class="bg-white text-red-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100"
                >
                    Prijavi se
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-300 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <h5 class="text-white font-semibold mb-4">Kompanija</h5>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white">O nama</a></li>
                    <li><a href="#" class="hover:text-white">Karijere</a></li>
                    <li><a href="#" class="hover:text-white">Kontakt</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white font-semibold mb-4">Resursi</h5>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white">Dokumentacija</a></li>
                    <li><a href="#" class="hover:text-white">Blog</a></li>
                    <li><a href="#" class="hover:text-white">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white font-semibold mb-4">Pravni</h5>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white">Privatnost</a></li>
                    <li><a href="#" class="hover:text-white">Uvjeti korištenja</a></li>
                    <li><a href="#" class="hover:text-white">Sigurnost</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-white font-semibold mb-4">Kontakt</h5>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-12 pt-8 text-center">
            <p>&copy; 2023 Požarna Sigurnost. Sva prava pridržana.</p>
        </div>
    </div>
</footer>

<!-- Swiper JS (Slider) -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<!-- Burger Menu Toggle Script -->
<script>
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    mobileMenuButton.addEventListener("click", () => {
        mobileMenu.classList.toggle("hidden");
    });
</script>
<!-- Initialize Swiper Slider -->
<script>
    const swiper = new Swiper(".mySwiper", {
        loop: true,
        slidesPerView: 2,
        spaceBetween: 30,
        autoplay: {
            delay: 1000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 50,
            },
        },
    });
</script>
</body>
</html>
