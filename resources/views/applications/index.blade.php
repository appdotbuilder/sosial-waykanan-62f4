@extends('layouts.app')

@section('title', 'Daftar Pengajuan - Sistem Pelayanan Bantuan Sosial')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">📋 Daftar Pengajuan</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        @if(auth()->user()->role === 'citizen')
                            Kelola pengajuan bantuan sosial Anda.
                        @else
                            Kelola semua pengajuan bantuan sosial dari warga.
                        @endif
                    </p>
                </div>
                
                @if(auth()->user()->role === 'citizen')
                    <a href="{{ route('applications.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        ➕ Ajukan Bantuan Baru
                    </a>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-8 dark:bg-gray-800">
            <form method="GET" action="{{ route('applications.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:space-x-4">
                <!-- Search -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pencarian</label>
                    <input type="text" 
                           name="search" 
                           id="search"
                           value="{{ $filters['search'] ?? '' }}"
                           placeholder="Cari berdasarkan nomor pengajuan atau nama pemohon..."
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" 
                            id="status"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ ($filters['status'] ?? '') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="submitted" {{ ($filters['status'] ?? '') === 'submitted' ? 'selected' : '' }}>Diajukan</option>
                        <option value="under_review" {{ ($filters['status'] ?? '') === 'under_review' ? 'selected' : '' }}>Sedang Ditinjau</option>
                        <option value="field_survey" {{ ($filters['status'] ?? '') === 'field_survey' ? 'selected' : '' }}>Survey Lapangan</option>
                        <option value="approved" {{ ($filters['status'] ?? '') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <!-- Assistance Type Filter -->
                <div>
                    <label for="assistance_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Bantuan</label>
                    <select name="assistance_type" 
                            id="assistance_type"
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">Semua Jenis</option>
                        @foreach($assistanceTypes as $type)
                            <option value="{{ $type->id }}" {{ ($filters['assistance_type'] ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        🔍 Filter
                    </button>
                    <a href="{{ route('applications.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Applications List -->
        <div class="bg-white rounded-lg shadow dark:bg-gray-800">
            @if($applications->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($applications as $application)
                        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-3xl">
                                            @if($application->status === 'approved') ✅
                                            @elseif($application->status === 'rejected') ❌
                                            @elseif($application->status === 'submitted') 📨
                                            @elseif($application->status === 'field_survey') 🔍
                                            @elseif($application->status === 'under_review') 👀
                                            @elseif($application->status === 'completed') 🎉
                                            @else 📝
                                            @endif
                                        </div>
                                        
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    {{ $application->application_number }}
                                                </h3>
                                                <div class="px-3 py-1 rounded-full text-xs font-medium
                                                    @if($application->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                    @elseif($application->status === 'submitted') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @elseif($application->status === 'field_survey') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                    @endif">
                                                    {{ $application->status_label }}
                                                </div>
                                            </div>
                                            
                                            <div class="mt-1">
                                                <p class="text-gray-900 font-medium dark:text-white">{{ $application->applicant_name }}</p>
                                                <p class="text-gray-600 dark:text-gray-400">{{ $application->assistanceType->name }}</p>
                                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span>📅 {{ $application->created_at->format('d M Y') }}</span>
                                                    @if($application->requested_amount)
                                                        <span>💰 Rp {{ number_format($application->requested_amount, 0, ',', '.') }}</span>
                                                    @endif
                                                    @if(auth()->user()->role !== 'citizen')
                                                        <span>📍 {{ $application->village }}, {{ $application->district }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('applications.show', $application) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        Detail
                                    </a>
                                    
                                    @if($application->status === 'draft' && $application->user_id === auth()->id())
                                        <a href="{{ route('applications.edit', $application) }}" 
                                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                            Edit
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                    {{ $applications->appends(request()->query())->links('pagination.custom') }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="text-6xl mb-4">📋</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2 dark:text-white">Belum Ada Pengajuan</h3>
                    <p class="text-gray-600 mb-6 dark:text-gray-400">
                        @if(auth()->user()->role === 'citizen')
                            Anda belum mengajukan bantuan sosial apapun.
                        @else
                            Belum ada pengajuan yang sesuai dengan filter yang dipilih.
                        @endif
                    </p>
                    
                    @if(auth()->user()->role === 'citizen')
                        <a href="{{ route('applications.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            ➕ Ajukan Bantuan Pertama
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection