<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- THÊM DÒNG NÀY -->

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @stack('styles')



</head>

<body>

    {{-- HEADER --}}
    @if (empty($header))
    @include('partials.header')
    @endif
    {{-- MAIN CONTENT --}}
    @yield('content')

    {{-- FOOTER --}}
    @include('partials.footer')


    <!-- JavaScript Libraries -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    @vite([
    'resources/js/app.js',
    'resources/js/confirm.js',
    'resources/js/filter.js',
    'resources/js/easing/easing.min.js',
    'resources/js/waypoints/waypoints.min.js',
    'resources/js/owlcarousel/owl.carousel.min.js',
    'resources/js/main.js'
    ])

    @if(session('toastMessage'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            showToast("{{ session('toastMessage') }}", "{{ session('toastRedirect') }}");
        });
    </script>
    @endif
</body>

</html>