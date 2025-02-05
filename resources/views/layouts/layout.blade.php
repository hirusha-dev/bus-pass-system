<!-- resources/views/layouts/layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Laravel App')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/bus.png') }}" type="image/png">

    <!-- Include CSS -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <!-- TailwindCSS -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <!-- Flowbite -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script> --}}

    {{-- font awsome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    @stack('styles')
</head>

<body class="">

    <!-- Include Header -->
    @include('components.header')

    <!-- Page Content -->
    @yield('content')

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script> --}}
</body>

</html>
