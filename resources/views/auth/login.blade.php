@extends('layouts.guest')

@section('title', 'Masuk - Sistem Pelayanan Bantuan Sosial')
@section('heading', 'Masuk ke Akun Anda')
@section('subheading', 'Akses sistem pelayanan bantuan sosial')

@section('content')
<form method="POST" action="{{ route('login') }}" class="space-y-6">
    @csrf

    <!-- Session Status -->
    @if (session('status'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
            {{ session('status') }}
        </div>
    @endif

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Email
        </label>
        <div class="mt-1">
            <input id="email" 
                   name="email" 
                   type="email" 
                   value="{{ old('email') }}"
                   required 
                   autofocus 
                   autocomplete="username"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        @error('email')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Password
        </label>
        <div class="mt-1">
            <input id="password" 
                   name="password" 
                   type="password" 
                   required 
                   autocomplete="current-password"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        @error('password')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember" 
                   name="remember" 
                   type="checkbox" 
                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                Ingat saya
            </label>
        </div>

        @if ($canResetPassword)
            <div class="text-sm">
                <a href="{{ route('password.request') }}" 
                   class="text-blue-600 hover:text-blue-500 dark:text-blue-400">
                    Lupa password?
                </a>
            </div>
        @endif
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit" 
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
            🔐 Masuk
        </button>
    </div>

    <!-- Register Link -->
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Belum memiliki akun?
            <a href="{{ route('register') }}" 
               class="text-blue-600 hover:text-blue-500 font-medium dark:text-blue-400">
                Daftar sekarang
            </a>
        </p>
    </div>
</form>
@endsection