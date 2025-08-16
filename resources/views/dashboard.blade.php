@extends('layouts.app')

@section('title', 'Dashboard - Sistem Pelayanan Bantuan Sosial')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                @if($userRole === 'citizen')
                    Selamat datang, {{ auth()->user()->name }}! Berikut adalah ringkasan pengajuan bantuan Anda.
                @else
                    Panel administrasi untuk mengelola pengajuan bantuan sosial.
                @endif
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @if($userRole === 'citizen')
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="text-3xl text-blue-600">📝</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_applications'] }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Total Pengajuan</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="text-3xl text-orange-600">⏳</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_applications'] }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Sedang Diproses</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="text-3xl text-green-600">✅</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['approved_applications'] }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Disetujui</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="text-3xl text-purple-600">🎯</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['completed_applications'] }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Selesai</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="text-3xl text-blue-600">📋</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_applications'] }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Total Pengajuan</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="text-3xl text-red-600">🔍</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['pending_review'] }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Perlu Review</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="text-3xl text-yellow-600">📊</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['under_survey'] }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Survey Lapangan</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="text-3xl text-green-600">👥</div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_citizens'] }}</div>
                            <div class="text-gray-600 dark:text-gray-400">Total Warga</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                <h2 class="text-xl font-semibold text-gray-900 mb-4 dark:text-white">Aksi Cepat</h2>
                <div class="flex flex-wrap gap-4">
                    @if($userRole === 'citizen')
                        <a href="{{ route('applications.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            ➕ Ajukan Bantuan Baru
                        </a>
                        <a href="{{ route('applications.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            📋 Lihat Semua Pengajuan
                        </a>
                    @else
                        <a href="{{ route('applications.index', ['status' => 'submitted']) }}" 
                           class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            🔍 Review Pengajuan Baru
                        </a>
                        <a href="{{ route('applications.index', ['status' => 'field_survey']) }}" 
                           class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            📊 Survey Lapangan
                        </a>
                        <a href="{{ route('applications.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            📋 Semua Pengajuan
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        @if($recentApplications && count($recentApplications) > 0)
            <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        @if($userRole === 'citizen')
                            📋 Pengajuan Terbaru Anda
                        @else
                            🔥 Pengajuan yang Perlu Ditindaklanjuti
                        @endif
                    </h2>
                </div>
                
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentApplications as $application)
                        <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <div>
                                            @if($userRole === 'citizen')
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $application['assistance_type'] }}</div>
                                                <div class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $application['application_number'] }}
                                                    @if(isset($application['requested_amount']))
                                                        • Rp {{ number_format($application['requested_amount'], 0, ',', '.') }}
                                                    @endif
                                                </div>
                                            @else
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $application['applicant_name'] }}</div>
                                                <div class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $application['application_number'] }} • {{ $application['assistance_type'] }}
                                                    @if(isset($application['village']) && isset($application['district']))
                                                        • {{ $application['village'] }}, {{ $application['district'] }}
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        <div class="px-3 py-1 rounded-full text-sm font-medium
                                            @if($application['status'] === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($application['status'] === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @elseif($application['status'] === 'submitted') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @elseif($application['status'] === 'field_survey') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                            @endif">
                                            {{ $application['status_label'] }}
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">{{ $application['created_at'] }}</div>
                                    </div>
                                    
                                    <a href="{{ route('applications.show', $application['id']) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                    <a href="{{ route('applications.index') }}" 
                       class="text-blue-600 hover:text-blue-700 font-medium text-sm dark:text-blue-400">
                        Lihat semua pengajuan →
                    </a>
                </div>
            </div>
        @endif

        <!-- Monthly Stats Chart (for officers only) -->
        @if($userRole !== 'citizen' && isset($monthlyStats))
            <div class="mt-8">
                <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 dark:text-white">📈 Statistik Bulanan</h2>
                    <div class="space-y-4">
                        @foreach($monthlyStats as $stat)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 dark:text-gray-300">{{ $stat['month'] }}</span>
                                <div class="flex items-center space-x-4">
                                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm dark:bg-blue-900 dark:text-blue-200">
                                        {{ $stat['applications'] }} pengajuan
                                    </div>
                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm dark:bg-green-900 dark:text-green-200">
                                        {{ $stat['approved'] }} disetujui
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection