<!-- Vaš HTML kod -->
<nav id="main-nav" class="fixed w-full z-50 bg-transparent backdrop-blur-sm transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}">
                    <!-- Bijeli logo se prikazuje na početku -->
                    <img id="logo-white" src="{{ asset('images/logo-white.svg') }}" alt="Logo" class="h-10 w-auto block">
                    <!-- Crni logo je inicijalno skriven -->
                    <img id="logo-black" src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-10 w-auto hidden">
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                   class="nav-link toggle-color transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('home') ? 'text-red-400 border-red-400' : '' }}">
                    Početna
                </a>
                <a href="#usluge" class="nav-link toggle-color transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent">
                    Usluge
                </a>
                <a href="#o-nama" class="nav-link toggle-color transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent">
                    O nama
                </a>
                <a href="#kontakt" class="nav-link toggle-color transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent">
                    Kontakt
                </a>
            </div>
            <!-- Akcije i Mobile Toggle -->
            <div class="flex items-center space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="hidden md:inline-block toggle-color px-4 py-2 rounded-md text-white hover:bg-white/10 transition duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="hidden md:inline-block toggle-color px-4 py-2 rounded-md text-white hover:bg-white/10 transition duration-300">
                            Log in
                        </a>
                    @endauth
                @endif
                <!-- Dugme Zatraži Ponudu nema toggle-color, ostaje belo -->
                <button id="offer-btn" class="hidden md:inline-block bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition duration-300">
                    Zatraži Ponudu
                </button>
                <!-- Mobile Menu Toggle - ikonice postavljene na crnu -->
                <button id="mobile-menu-button" class="md:hidden focus:outline-none">
                    <svg id="hamburger-icon" class="w-6 h-6 text-black toggle-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                    </svg>
                    <svg id="close-icon" class="w-6 h-6 text-black hidden toggle-color" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden transition-all duration-300">
        <div class="px-4 pt-4 pb-4 space-y-2 bg-black/70 backdrop-blur-md shadow-lg">
            <a href="{{ route('home') }}"
               class="block toggle-color transition-colors duration-300 text-white hover:text-red-400 {{ request()->routeIs('home') ? 'text-red-400' : '' }}">
                Početna
            </a>
            <a href="#usluge" class="block transition-colors duration-300 text-white hover:text-red-400">
                Usluge
            </a>
            <a href="#o-nama" class="block transition-colors duration-300 text-white hover:text-red-400">
                O nama
            </a>
            <a href="#kontakt" class="block transition-colors duration-300 text-white hover:text-red-400">
                Kontakt
            </a>
            <div class="mt-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block transition-colors duration-300 text-white hover:text-red-400">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block transition-colors duration-300 text-white hover:text-red-400">
                            Log in
                        </a>
                    @endauth
                @endif
                <!-- Dugme Zatraži Ponudu ovde nema toggle-color -->
                <button class="mt-2 w-full bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition duration-300">
                    Zatraži Ponudu
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- JavaScript za toggle mobilnog menija, ikonica i promenu boje nakon hero sekcije -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nav = document.getElementById('main-nav');
        const hero = document.getElementById('hero'); // Hero sekcija mora imati id="hero"
        const toggleElements = document.querySelectorAll('.toggle-color');
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        const logoWhite = document.getElementById('logo-white');
        const logoBlack = document.getElementById('logo-black');

        // Toggle mobilnog menija
        menuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
            hamburgerIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });

        // Funkcija za promjenu boje teksta i prebacivanje logotipa na scroll
        function updateNavColor() {
            if (window.scrollY > hero.offsetHeight - nav.offsetHeight) {
                // Prikaz crnog logotipa, sakrivanje bijelog
                logoWhite.classList.add('hidden');
                logoBlack.classList.remove('hidden');

                toggleElements.forEach(el => {
                    el.classList.remove('text-white');
                    el.classList.add('text-black');
                });
            } else {
                // Prikaz bijelog logotipa, sakrivanje crnog
                logoWhite.classList.remove('hidden');
                logoBlack.classList.add('hidden');

                toggleElements.forEach(el => {
                    el.classList.remove('text-black');
                    el.classList.add('text-white');
                });
            }
        }

        // Provera prilikom scrolla
        window.addEventListener('scroll', updateNavColor);
        updateNavColor(); // Inicijalna provera
    });

</script>
