<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'My Laravel App')</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <style>
        /* Custom teal navbar background */
        .navbar-teal {
            background-color: #008080; /* teal */
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

<!-- Navbar -->
@include('partials.navbar')

<main class="container mx-auto px-4 mt-6">
    @yield('content')
</main>

<!-- Footer -->
@include('partials.footer')

<!-- Custom JS -->
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
