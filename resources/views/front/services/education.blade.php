@extends('layouts-front.main')

@section('title', 'Evakuacijski Planovi - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Izrada detaljnih evakuacijskih planova za sigurnost vašeg prostora. Analiza prostora i obuka osoblja.')
@section('meta_keywords', 'evakuacijski planovi, analiza prostora, obuka, sigurnost, planiranje')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[40vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-4">Evakuacijski <span class="text-red-500">Planovi</span></h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Pripremite vaš prostor za hitne situacije sa detaljnim evakuacijskim planovima.
            </p>
        </div>
    </section>

    <!-- Sadržaj usluge -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Planiranje evakuacije i obuka osoblja</h2>
                <p class="text-gray-700 mb-6">
                    Naš tim kreira precizne evakuacijske planove prilagođene vašem prostoru, osiguravajući efikasnu evakuaciju u hitnim situacijama. Nudimo analizu prostora, izradu digitalnih i fizičkih planova, te obuku vašeg osoblja.
                </p>
                <ul class="list-disc pl-5 text-gray-700 mb-6">
                    <li>Detaljna analiza prostora</li>
                    <li>Digitalni i fizički planovi</li>
                    <li>Obuka osoblja za hitne situacije</li>
                </ul>
                <a href="{{ route('contact') }}" class="inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300">
                    Kontaktirajte nas
                </a>
            </div>
        </div>
    </section>
@endsection
