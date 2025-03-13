<footer class="bg-gray-900 text-gray-300 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Na mobilnim uređajima (do sm breakpoint) raspored u dva reda -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Kolona 1: O nama -->
            <div>
                <h5 class="text-white font-semibold mb-4">Inženjer Tim</h5>
                <p class="text-gray-400 text-sm">
                    Inženjer Tim je firma naša koja pruža vrhunske inženjerske usluge i rešenja za sve vaše potrebe.
                </p>
                <br>
                <p class="text-gray-400 text-sm">PIB: 2424242</p>

            </div>
            <!-- Kolona 2: Navigacija -->
            <div>
                <h5 class="text-white font-semibold mb-4">Navigacija</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white">Početna</a></li>
                    <li><a href="#" class="hover:text-white">O nama</a></li>
                    <li><a href="#" class="hover:text-white">Usluge</a></li>
                    <li><a href="#" class="hover:text-white">Kontakt</a></li>
                </ul>
            </div>
            <!-- Kolona 3: Resursi -->
            <div>
                <h5 class="text-white font-semibold mb-4">Resursi</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white">Blog</a></li>
                    <li><a href="#" class="hover:text-white">FAQ</a></li>
                    <li><a href="#" class="hover:text-white">Dokumentacija</a></li>
                </ul>
            </div>
            <!-- Kolona 4: Kontakt -->
            <div>
                <h5 class="text-white font-semibold mb-4">Kontakt</h5>
                <ul class="space-y-2 text-sm">
                    <li><a href="mailto:info@inzenjertim.com" class="hover:text-white">info@inzenjertim.com</a></li>
                    <li><a href="#" class="hover:text-white">+387 33 123 456</a></li>
                </ul>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="hover:text-white"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-4 text-center text-gray-500 text-xs">
            <p>&copy; {{ date('Y') }} Inženjer Tim. Sva prava pridržana.</p>
        </div>
    </div>
</footer>
