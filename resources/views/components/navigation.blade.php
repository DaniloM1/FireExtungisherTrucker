<nav id="main-nav" class="fixed w-full z-50 bg-transparent backdrop-blur-sm transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}">
                    <img id="logo-white" src="{{ asset('images/logo-white.svg') }}" alt="Logo" class="h-10 w-auto block">
                    <img id="logo-black" src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-10 w-auto hidden">
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                   class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('home') ? 'text-red-400 border-red-400' : '' }}">
                    Početna
                    @if(request()->routeIs('home'))
                        <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                    @endif
                </a>

                <!-- Usluge sa podmenijima -->
                <div class="relative group">
                    <a href="{{ route('services') }}"
                       class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('services') ? 'text-red-400 border-red-400' : '' }}">
                        Usluge
                        @if(request()->routeIs('services'))
                            <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                        @endif
                    </a>
                    <!-- Dropdown podmeni -->
                    <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-50">
                        <a href="/service1" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Service 1</a>
                        <a href="/service2" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Service 2</a>
                        <a href="/service3" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Service 3</a>
                    </div>
                </div>

                <a href="#o-nama"
                   class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->is('#o-nama') ? 'text-red-400 border-red-400' : '' }}">
                    O nama
                </a>
                <a href="#kontakt"
                   class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->is('#kontakt') ? 'text-red-400 border-red-400' : '' }}">
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
                <button id="offer-btn" class="hidden md:inline-block bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition duration-300">
                    Zatraži Ponudu
                </button>
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
               class="block toggle-color relative transition-colors duration-300 text-white hover:text-red-400 {{ request()->routeIs('home') ? 'text-red-400' : '' }}">
                Početna
                @if(request()->routeIs('home'))
                    <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                @endif
            </a>

            <div class="relative">
                <a href="{{ route('services') }}"
                   class="block toggle-color relative transition-colors duration-300 text-white hover:text-red-400 {{ request()->routeIs('services') ? 'text-red-400' : '' }}">
                    Usluge
                    @if(request()->routeIs('services'))
                        <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                    @endif
                </a>
                <div class="ml-4 mt-2 space-y-2">
                    <a href="/service1" class="block text-gray-300 hover:text-red-400">Service 1</a>
                    <a href="/service2" class="block text-gray-300 hover:text-red-400">Service 2</a>
                    <a href="/service3" class="block text-gray-300 hover:text-red-400">Service 3</a>
                </div>
            </div>

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
                <button class="mt-2 w-full bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition duration-300">
                    Zatraži Ponudu
                </button>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const nav = document.getElementById('main-nav');
        const hero = document.getElementById('hero');
        const toggleElements = document.querySelectorAll('.toggle-color');
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        const logoWhite = document.getElementById('logo-white');
        const logoBlack = document.getElementById('logo-black');

        // Mobile menu toggle
        menuButton.addEventListener('click', function () {
            const isOpen = mobileMenu.classList.toggle('hidden');
            hamburgerIcon.classList.toggle('hidden', !isOpen);
            closeIcon.classList.toggle('hidden', isOpen);
        });

        // Nav color change on scroll
        function updateNavColor() {
            const shouldChangeColor = window.scrollY > hero.offsetHeight - nav.offsetHeight;

            logoWhite.classList.toggle('hidden', shouldChangeColor);
            logoBlack.classList.toggle('hidden', !shouldChangeColor);

            toggleElements.forEach(el => {
                el.classList.toggle('text-white', !shouldChangeColor);
                el.classList.toggle('text-black', shouldChangeColor);
            });
        }

        window.addEventListener('scroll', updateNavColor);
        updateNavColor();

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!menuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    });
</script>
