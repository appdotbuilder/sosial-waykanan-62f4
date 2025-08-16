<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Sistem Pelayanan Bantuan Sosial - Dinas Sosial Kabupaten Way Kanan')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.tsx'])

    <!-- Additional head content -->
    @stack('head')
</head>
<body class="font-sans antialiased h-full bg-gray-50 dark:bg-gray-900">
    <div class="min-h-full">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg dark:bg-red-900/20 dark:border-red-800 dark:text-red-200">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Main content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>