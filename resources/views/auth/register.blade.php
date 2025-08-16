@extends('layouts.guest')

@section('title', 'Daftar - Sistem Pelayanan Bantuan Sosial')
@section('heading', 'Daftar Akun Baru')
@section('subheading', 'Buat akun untuk mengajukan bantuan sosial')

@section('content')
<form method="POST" action="{{ route('register') }}" class="space-y-6">
    @csrf

    <!-- Name -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Nama Lengkap <span class="text-red-500">*</span>
        </label>
        <div class="mt-1">
            <input id="name" 
                   name="name" 
                   type="text" 
                   value="{{ old('name') }}"
                   required 
                   autofocus 
                   autocomplete="name"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        @error('name')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Address -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Email <span class="text-red-500">*</span>
        </label>
        <div class="mt-1">
            <input id="email" 
                   name="email" 
                   type="email" 
                   value="{{ old('email') }}"
                   required 
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
            Password <span class="text-red-500">*</span>
        </label>
        <div class="mt-1">
            <input id="password" 
                   name="password" 
                   type="password" 
                   required 
                   autocomplete="new-password"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        @error('password')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Konfirmasi Password <span class="text-red-500">*</span>
        </label>
        <div class="mt-1">
            <input id="password_confirmation" 
                   name="password_confirmation" 
                   type="password" 
                   required 
                   autocomplete="new-password"
                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
        @error('password_confirmation')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <!-- Terms and Conditions -->
    <div class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
        <p>Dengan mendaftar, Anda menyetujui bahwa:</p>
        <ul class="list-disc list-inside mt-2 space-y-1">
            <li>Data yang Anda berikan adalah benar dan akurat</li>
            <li>Anda akan menggunakan sistem ini sesuai ketentuan yang berlaku</li>
            <li>Anda bertanggung jawab atas keamanan akun Anda</li>
        </ul>
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit" 
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
            🚀 Daftar Sekarang
        </button>
    </div>

    <!-- Login Link -->
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" 
               class="text-blue-600 hover:text-blue-500 font-medium dark:text-blue-400">
                Masuk di sini
            </a>
        </p>
    </div>
</form>
@endsection