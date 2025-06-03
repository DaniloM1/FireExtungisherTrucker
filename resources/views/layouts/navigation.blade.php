<!-- Uveri se da Alpine.js učitava negde u glavnom layout-u, npr.: -->
<!-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> -->

<nav x-data="{
    open: false,
    darkMode: localStorage.getItem('darkMode') ? localStorage.getItem('darkMode') === 'true' : true,
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('darkMode', this.darkMode);
        if(this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}"
x-init="if(darkMode){ document.documentElement.classList.add('dark') }"
class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
<!-- Primary Navigation Menu -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
        <div class="flex">
            <template x-if="!darkMode">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo color="white"  class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </template>
            <template x-if="darkMode">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo color="black"  class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
            </template>
            <!-- Logo -->


            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                @hasrole('super_admin')
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('Users') }}
                </x-nav-link>
                <x-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
                    {{ __('Companies') }}
                </x-nav-link>
                <x-nav-link :href="route('service-events.index')" :active="request()->routeIs('service-events.*')">
                    {{ __('Servis') }}
                </x-nav-link>
                <x-nav-link :href="route('locations.test')" :active="request()->routeIs('locations.test')">
                    {{ __('Locations') }}
                </x-nav-link>
                <x-nav-link :href="route('location-groups.index')" :active="request()->routeIs('location-groups*')">
                    {{ __('Locations Groups') }}
                </x-nav-link>
                <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">
                    {{ __('Blog') }}
                </x-nav-link>
                @endhasrole
                @hasrole('company')
                <!-- Kompanijski korisnik vidi samo ovo -->
                <x-nav-link :href="route('company.service-events.index')" :active="request()->routeIs('company.service-events.index')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                @endhasrole
            </div>
        </div>

        <!-- Desna strana: Dugme za prebacivanje teme i Settings Dropdown -->
        <div class="flex items-center">
            <div class="flex items-center space-x-4">
                <!-- Dugme za prebacivanje teme sa ikonama -->
                <button @click="toggleTheme" class="px-3 py-2 flex items-center rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 focus:outline-none transition">
                    <template x-if="darkMode">
                        <!-- Ako je darkMode true, prikazujemo sunce (dugme nudi prelazak na svetli režim) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21 12.79A9 9 0 0111.21 3 7 7 0 0012 17a7 7 0 009-4.21z"/>
                        </svg>
                    </template>
                    <template x-if="!darkMode">
                        <!-- Ako je darkMode false, prikazujemo mesec (dugme nudi prelazak na tamni režim) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.364-6.364l-1.414 1.414M7.05 16.95l-1.414 1.414M16.95 16.95l-1.414 1.414M7.05 7.05L5.636 5.636"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                    </template>
                    <span x-text="darkMode ? '' : ''"></span>
                </button>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger (mobilni prikaz) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Responsive Navigation Menu -->
<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    @hasrole('super_admin')
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
    </div>
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')">
            {{ __('Companies') }}
        </x-responsive-nav-link>
    </div>
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
            {{ __('Users') }}
        </x-responsive-nav-link>
    </div>

    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('service-events.index')" :active="request()->routeIs('service-events.*')">
            {{ __('Servis') }}
        </x-responsive-nav-link>
    </div>
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('locations.test')" :active="request()->routeIs('locations.test')">
            {{ __('Locations') }}
        </x-responsive-nav-link>
    </div>
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('location-groups.index')" :active="request()->routeIs('location-groups.*')">
            {{ __('Locations Groups') }}
        </x-responsive-nav-link>
    </div>
    @endhasrole
    @hasrole('company')
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link :href="route('company.service-events.index')" :active="request()->routeIs('company.service-events.index')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
    </div>
@endhasrole
    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
        <div class="px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>
        <div class="mt-3 space-y-1">
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let darkMode = localStorage.getItem('darkMode') === "true";
            let theme = darkMode ? 'black' : 'white';
            const appLogo = document.getElementById('appLogo');
            if(appLogo) {
                appLogo.setAttribute('color', theme);
            }
        });
    </script>

</nav>
