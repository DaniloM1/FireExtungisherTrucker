
<nav id="main-nav" class="fixed w-full z-50 bg-transparent backdrop-blur-sm transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="{{ route('home') }}">
                    <img id="logo-white" src="{{ asset('images/logo-white.svg') }}" alt="Logo" class="h-10 w-auto block">
                    <img id="logo-black" src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-10 w-auto hidden">
                </a>
            </div>

            <div class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                   class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('home') ? 'text-red-400 border-red-400' : '' }}">
                    Početna
                    @if(request()->routeIs('home'))
                        <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                    @endif
                </a>

                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" @click.away="open = false">
                    <a href="{{ route('services') }}"
                       class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('services') || request()->routeIs('services.*') ? 'text-red-400 border-red-400' : '' }}">
                        Usluge
                        @if(request()->routeIs('services') || request()->routeIs('services.*'))
                            <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                        @endif
                    </a>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg z-50">
                        <a href="{{ route('services.inspection') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 {{ request()->routeIs('services.inspection') ? 'bg-gray-200 font-bold' : '' }}">Inspekcija Aparata</a>
                        <a href="{{ route('services.protection') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 {{ request()->routeIs('services.protection') ? 'bg-gray-200 font-bold' : '' }}">Protivpožarni Sistemi</a>
                        <a href="{{ route('services.evacuation') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 {{ request()->routeIs('services.evacuation') ? 'bg-gray-200 font-bold' : '' }}">Evakuacijski Planovi</a>
                        <a href="{{ route('services.installation') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 {{ request()->routeIs('services.installation') ? 'bg-gray-200 font-bold' : '' }}">Ugradnja i Servis</a>
                        <a href="{{ route('services.exam') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 {{ request()->routeIs('services.exam') ? 'bg-gray-200 font-bold' : '' }}">Polaganje Stručnog Ispita</a>
                        <a href="{{ route('services.training') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-200 {{ request()->routeIs('services.training') ? 'bg-gray-200 font-bold' : '' }}">Obuke i Edukacija</a>
                    </div>
                </div>

                <a href="{{ route('aboutUs') }}"
                   class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('aboutUs') ? 'text-red-400 border-red-400' : '' }}">
                    O nama
                    @if(request()->routeIs('aboutUs'))
                        <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                    @endif
                </a>
                <a href="{{ route('blog.index') }}"
                   class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('blog.*') ? 'text-red-400 border-red-400' : '' }}">
                    Blog
                    @if(request()->routeIs('blog.*'))
                        <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                    @endif
                </a>
                <a href="{{ route('contact') }}"
                   class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('contact') ? 'text-red-400 border-red-400' : '' }}">
                  Kontakt
                    @if(request()->routeIs('contact'))
                        <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                    @endif
                </a>
            </div>

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
                <button  onclick="window.location='{{ route('contact') }}'"
                    id="offer-btn" class="hidden md:inline-block bg-red-600 text-white px-5 py-2 rounded-full hover:bg-red-700 transition duration-300">
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

    <div id="mobile-menu" class="md:hidden hidden transition-all duration-300">
        <div class="px-4 pt-4 pb-4 space-y-2 bg-black/70 backdrop-blur-md shadow-lg">
            <a href="{{ route('home') }}"
               class="block  relative transition-colors duration-300 text-white hover:text-red-400 {{ request()->routeIs('home') ? 'text-red-400' : '' }}">
                Početna
                @if(request()->routeIs('home'))
                    <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                @endif
            </a>



            <div x-data="{ openServices: {{ request()->routeIs('services.*') ? 'true' : 'false' }} }" class="relative">
                <button @click="openServices = !openServices" class="flex items-center focus:outline-none w-full">
                    <a href="{{ route('services') }}"
                       class="block relative transition-colors duration-300 text-white hover:text-red-400 {{ (request()->routeIs('services') || request()->routeIs('services.*')) ? 'text-red-400 border-b-2 border-red-400' : '' }}">
                        Usluge
                    </a>
                    <i class="fas fa-chevron-down text-white transition-transform duration-300 transform ml-1"
                       :class="{ 'rotate-180': openServices }"></i>
                </button>
                <div x-show="openServices" x-cloak x-transition class="mt-2 ml-4 space-y-2">
                    <a href="{{ route('services.inspection') }}"
                       class="block transition-colors duration-300 text-gray-300 hover:text-red-400 {{ request()->routeIs('services.inspection') ? 'font-bold text-red-400' : '' }}">
                        Inspekcija Aparata
                    </a>
                    <a href="{{ route('services.protection') }}"
                       class="block transition-colors duration-300 text-gray-300 hover:text-red-400 {{ request()->routeIs('services.protection') ? 'font-bold text-red-400' : '' }}">
                        Protivpožarni Sistemi
                    </a>
                    <a href="{{ route('services.evacuation') }}"
                       class="block transition-colors duration-300 text-gray-300 hover:text-red-400 {{ request()->routeIs('services.evacuation') ? 'font-bold text-red-400' : '' }}">
                        Evakuacijski Planovi
                    </a>
                    <a href="{{ route('services.installation') }}"
                       class="block transition-colors duration-300 text-gray-300 hover:text-red-400 {{ request()->routeIs('services.installation') ? 'font-bold text-red-400' : '' }}">
                        Ugradnja i Servis
                    </a>
                    <a href="{{ route('services.exam') }}"
                       class="block transition-colors duration-300 text-gray-300 hover:text-red-400 {{ request()->routeIs('services.exam') ? 'font-bold text-red-400' : '' }}">
                        Polaganje Ispita
                    </a>
                    <a href="{{ route('services.training') }}"
                       class="block transition-colors duration-300 text-gray-300 hover:text-red-400 {{ request()->routeIs('services.training') ? 'font-bold text-red-400' : '' }}">
                        Obuke i Edukacija
                    </a>
                </div>
            </div>



            <a href="{{ route('blog.index') }}"
            class="nav-link toggle-color relative transition-colors duration-300 text-white hover:text-red-400 border-b-2 border-transparent {{ request()->routeIs('blog.*') ? 'text-red-400 border-red-400' : '' }}">
             Blog
             @if(request()->routeIs('blog.*'))
                 <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
             @endif
         </a>
            <a href="{{ route('aboutUs') }}"
               class="block  relative transition-colors duration-300 text-white hover:text-red-400 {{ request()->routeIs('aboutUs') ? 'text-red-400' : '' }}">
                O nama
                @if(request()->routeIs('aboutUs'))
                    <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                @endif
            </a>
           
            <a href="{{ route('contact') }}"
               class="block  relative transition-colors duration-300 text-white hover:text-red-400 {{ request()->routeIs('contact') ? 'text-red-400' : '' }}">
                Kontakt
                @if(request()->routeIs('contact'))
                    <span class="absolute left-0 -bottom-1 w-full h-0.5 bg-red-400"></span>
                @endif
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
                    <button
                        onclick="window.location='{{ route('contact') }}'"
                        class="mt-2 w-full bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition duration-300"
                    >
                        Zatraži Ponudu
                    </button>

            </div>
        </div>
    </div>
</nav>

<script>

</script>
