<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $pageTitle = trim($__env->yieldContent('title')) ?: 'Požarna Sigurnost';
        $pageDescription = trim($__env->yieldContent('meta_description')) ?: 'Default meta description';
        $pageKeywords = trim($__env->yieldContent('meta_keywords')) ?: 'default, keywords';
    @endphp

    <x-seo-meta
        title="{{ $pageTitle }}"
        meta_description="{{ $pageDescription }}"
        meta_keywords="{{ $pageKeywords }}"
    />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased dark:bg-black dark:text-white/50">
@include('components.navigation')

<main>
    @yield('content')
</main>

<!-- Dugme za povratak na vrh -->
<button id="back-to-top" class="hidden fixed bottom-8 right-8 bg-red-600 text-white p-3 rounded-xl shadow-lg hover:bg-red-700 transition duration-300">
    <i class="fas fa-arrow-up sm"></i>
</button>
@include('components.footer')
<!-- Skripta za prikaz dugmeta i glatko skrolovanje -->
<script>
    const backToTopButton = document.getElementById('back-to-top');

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.classList.remove('hidden');
        } else {
            backToTopButton.classList.add('hidden');
        }
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
</body>
</html>
