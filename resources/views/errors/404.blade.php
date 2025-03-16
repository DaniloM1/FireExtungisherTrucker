@extends('layouts-front.main')

@section('title', 'Stranica nije pronađena - Požarna Sigurnost - Inženjer Tim')
@section('meta_description', 'Stranica koju ste tražili nije pronađena. Vratite se na početnu ili kontaktirajte podršku.')
@section('meta_keywords', '404, stranica nije pronađena, greška, požarna sigurnost, inženjer tim')

@section('content')
    <!-- HERO Sekcija -->
    <section id="hero" class="relative h-[70vh] flex items-center overflow-hidden bg-gray-900">
        <div class="bg-lava"></div>
        <div class="absolute inset-0 bg-black opacity-70"></div>
        <div class="container mx-auto relative z-10 px-4 text-center">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-4">404</h1>
            <p class="text-2xl text-gray-300 mb-6">Stranica nije pronađena</p>
            <p class="text-lg text-gray-200 mb-8">
                Izvinjavamo se, ali stranica koju ste tražili ne postoji ili je premještena.
            </p>
            <a href="{{ route('home') }}" class="inline-block bg-red-600 text-white px-8 py-3 rounded-full hover:bg-red-700 transition duration-300">
                Vrati se na početnu
            </a>
        </div>
    </section>
@endsection
