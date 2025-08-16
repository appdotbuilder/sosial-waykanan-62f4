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
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo -->
            <div class="text-center">
                <div class="flex justify-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-xl">DS</span>
                    </div>
                </div>
                <h2 class="mt-6 text-center text-3xl font-bold text-gray-900 dark:text-white">
                    @yield('heading', 'Dinas Sosial Way Kanan')
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    @yield('subheading', 'Sistem Pelayanan Bantuan Sosial')
                </p>
            </div>

            <!-- Main content -->
            <div class="bg-white dark:bg-gray-800 py-8 px-4 shadow sm:rounded-lg sm:px-10">
                @yield('content')
            </div>

            <!-- Back to home -->
            <div class="text-center">
                <a href="{{ route('home') }}" 
                   class="text-blue-600 hover:text-blue-700 font-medium dark:text-blue-400">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>