@extends('layouts.app')

@section('title', 'Detail Pengajuan - Sistem Pelayanan Bantuan Sosial')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('applications.index') }}" 
                       class="text-blue-600 hover:text-blue-700 font-medium dark:text-blue-400">
                        ← Kembali ke Daftar Pengajuan
                    </a>
                </div>
                
                <div class="flex items-center space-x-3">
                    @if($application->status === 'draft' && $application->user_id === auth()->id())
                        <a href="{{ route('applications.edit', $application) }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            ✏️ Edit
                        </a>
                        
                        <form action="{{ route('applications.update', $application) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="submit" value="true">
                            <button type="submit" 
                                    onclick="return confirm('Yakin ingin mengajukan bantuan ini? Setelah diajukan, Anda tidak dapat mengeditnya lagi.')"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                🚀 Ajukan untuk Ditinjau
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <div class="flex items-center space-x-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $application->application_number }}</h1>
                    <div class="px-4 py-2 rounded-full text-sm font-medium
                        @if($application->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($application->status === 'rejected') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @elseif($application->status === 'submitted') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($application->status === 'field_survey') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                        @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                        @endif">
                        @if($application->status === 'approved') ✅ {{ $application->status_label }}
                        @elseif($application->status === 'rejected') ❌ {{ $application->status_label }}
                        @elseif($application->status === 'submitted') 📨 {{ $application->status_label }}
                        @elseif($application->status === 'field_survey') 🔍 {{ $application->status_label }}
                        @elseif($application->status === 'under_review') 👀 {{ $application->status_label }}
                        @elseif($application->status === 'completed') 🎉 {{ $application->status_label }}
                        @else 📝 {{ $application->status_label }}
                        @endif
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Dibuat pada {{ $application->created_at->format('d F Y, H:i') }}
                </p>
            </div>
        </div>

        <!-- Application Details -->
        <div class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">ℹ️ Informasi Dasar</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pemohon</label>
                            <p class="text-gray-900 dark:text-white">{{ $application->applicant_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIK</label>
                            <p class="text-gray-900 dark:text-white">{{ $application->nik }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Telepon</label>
                            <p class="text-gray-900 dark:text-white">{{ $application->phone }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Bantuan</label>
                            <p class="text-gray-900 dark:text-white">{{ $application->assistanceType->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">📍 Alamat</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Lengkap</label>
                        <p class="text-gray-900 dark:text-white">{{ $application->address }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Desa/Kelurahan</label>
                            <p class="text-gray-900 dark:text-white">{{ $application->village }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kecamatan</label>
                            <p class="text-gray-900 dark:text-white">{{ $application->district }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assistance Details -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">💰 Detail Bantuan</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Bantuan Diminta</label>
                            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($application->requested_amount, 0, ',', '.') }}</p>
                        </div>
                        @if($application->approved_amount)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Bantuan Disetujui</label>
                                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($application->approved_amount, 0, ',', '.') }}</p>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Mengajukan Bantuan</label>
                        <p class="text-gray-900 dark:text-white mt-2 leading-relaxed">{{ $application->reason }}</p>
                    </div>
                </div>
            </div>

            <!-- Status Information -->
            @if($application->status !== 'draft')
                <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">📋 Status Pengajuan</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($application->submitted_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Pengajuan</label>
                                    <p class="text-gray-900 dark:text-white">{{ $application->submitted_at->format('d F Y, H:i') }}</p>
                                </div>
                            @endif
                            @if($application->reviewed_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Review</label>
                                    <p class="text-gray-900 dark:text-white">{{ $application->reviewed_at->format('d F Y, H:i') }}</p>
                                </div>
                            @endif
                            @if($application->approved_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Persetujuan</label>
                                    <p class="text-gray-900 dark:text-white">{{ $application->approved_at->format('d F Y, H:i') }}</p>
                                </div>
                            @endif
                            @if($application->rejected_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Penolakan</label>
                                    <p class="text-gray-900 dark:text-white">{{ $application->rejected_at->format('d F Y, H:i') }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($application->reviewer_notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan Reviewer</label>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white">{{ $application->reviewer_notes }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($application->rejection_reason)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Penolakan</label>
                                <div class="mt-2 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                                    <p class="text-red-800 dark:text-red-200">{{ $application->rejection_reason }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Documents Section -->
            @if($application->documents && count($application->documents) > 0)
                <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">📄 Dokumen Pendukung</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($application->documents as $document)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="text-2xl">📎</div>
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 dark:text-white">{{ $document->document_type }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $document->original_name }}</p>
                                        </div>
                                        <a href="{{ Storage::url($document->file_path) }}" 
                                           target="_blank"
                                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm transition-colors">
                                            Lihat
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Field Survey Section -->
            @if($application->fieldSurvey)
                <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">🔍 Hasil Survey Lapangan</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Survey</label>
                                <p class="text-gray-900 dark:text-white">{{ $application->fieldSurvey->survey_date->format('d F Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Surveyor</label>
                                <p class="text-gray-900 dark:text-white">{{ $application->fieldSurvey->surveyor->name }}</p>
                            </div>
                        </div>
                        
                        @if($application->fieldSurvey->findings)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hasil Temuan</label>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white">{{ $application->fieldSurvey->findings }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($application->fieldSurvey->photos && count($application->fieldSurvey->photos) > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Foto Survey</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($application->fieldSurvey->photos as $photo)
                                        <img src="{{ Storage::url($photo->file_path) }}" 
                                             alt="{{ $photo->description }}"
                                             class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection