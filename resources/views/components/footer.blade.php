<footer class="bg-gray-900 text-gray-300 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <!-- Kolona 1: O nama -->
            <div>
                <h5 class="text-white font-semibold mb-4">Inženjer Tim</h5>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Profesionalne protivpožarne usluge i saveti za sigurnost na radu. Pružamo vrhunska inženjerska rešenja prilagođena vašim potrebama.
                </p>
                <br>
                <p class="text-gray-400 text-sm">PIB: 113864578</p>
                <p class="text-gray-400 text-sm">MB: 21937274</p>
            </div>

            <!-- Kolona 2: Navigacija -->
            <div>
                <h5 class="text-white font-semibold mb-4">Navigacija</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Početna</a></li>
                    <li><a href="{{ route('aboutUs') }}" class="hover:text-white">O nama</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-white">Usluge</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Kontakt</a></li>
                </ul>
            </div>

            <!-- Kolona 3: Kontakt -->
            <div>
                <h5 class="text-white font-semibold mb-4">Kontakt</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="mailto:inzenjer.tim@gmail.com" class="hover:text-white">inzenjer.tim@gmail.com</a></li>
                    <li><a href="tel:+381642645425" class="hover:text-white">+381 64 2645 425</a></li>
                </ul>
                {{-- <div class="flex space-x-4 mt-4">
                    <a href="#" class="hover:text-white" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-white" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-white" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div> --}}
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-4 text-center text-gray-500 text-xs">
            <p>&copy; {{ date('Y') }} Inženjer Tim. Sva prava pridržana.</p>
        </div>
    </div>
</footer>
