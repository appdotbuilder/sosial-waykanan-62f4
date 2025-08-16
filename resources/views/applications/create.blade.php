@extends('layouts.app')

@section('title', 'Ajukan Bantuan Baru - Sistem Pelayanan Bantuan Sosial')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('applications.index') }}" 
                   class="text-blue-600 hover:text-blue-700 font-medium dark:text-blue-400">
                    ← Kembali ke Daftar Pengajuan
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mt-4 dark:text-white">📝 Ajukan Bantuan Sosial</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">
                Lengkapi formulir di bawah ini untuk mengajukan bantuan sosial.
            </p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow dark:bg-gray-800">
            <form action="{{ route('applications.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">ℹ️ Informasi Dasar</h2>
                </div>

                <div class="px-6 space-y-6">
                    <!-- Assistance Type -->
                    <div>
                        <label for="assistance_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jenis Bantuan <span class="text-red-500">*</span>
                        </label>
                        <select name="assistance_type_id" 
                                id="assistance_type_id" 
                                required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Pilih Jenis Bantuan</option>
                            @foreach($assistanceTypes as $type)
                                <option value="{{ $type->id }}" {{ old('assistance_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} - Maksimal Rp {{ number_format($type->max_amount, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('assistance_type_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Applicant Name -->
                    <div>
                        <label for="applicant_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Lengkap Pemohon <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="applicant_name" 
                               id="applicant_name" 
                               value="{{ old('applicant_name', auth()->user()->name) }}"
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('applicant_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nik" 
                               id="nik" 
                               value="{{ old('nik') }}"
                               required
                               maxlength="16"
                               pattern="[0-9]{16}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <p class="text-sm text-gray-500 mt-1">Masukkan 16 digit NIK sesuai KTP</p>
                        @error('nik')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               name="phone" 
                               id="phone" 
                               value="{{ old('phone') }}"
                               required
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">📍 Alamat</h2>
                </div>

                <div class="px-6 space-y-6">
                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" 
                                  id="address" 
                                  rows="3"
                                  required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Village -->
                        <div>
                            <label for="village" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Desa/Kelurahan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="village" 
                                   id="village" 
                                   value="{{ old('village') }}"
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('village')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- District -->
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kecamatan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="district" 
                                   id="district" 
                                   value="{{ old('district') }}"
                                   required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('district')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">💰 Detail Bantuan</h2>
                </div>

                <div class="px-6 space-y-6">
                    <!-- Requested Amount -->
                    <div>
                        <label for="requested_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jumlah Bantuan yang Diminta <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500 dark:text-gray-400">Rp</span>
                            <input type="number" 
                                   name="requested_amount" 
                                   id="requested_amount" 
                                   value="{{ old('requested_amount') }}"
                                   required
                                   min="1"
                                   class="w-full border border-gray-300 rounded-lg pl-12 pr-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Masukkan jumlah bantuan yang Anda butuhkan</p>
                        @error('requested_amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Alasan Mengajukan Bantuan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="reason" 
                                  id="reason" 
                                  rows="4"
                                  required
                                  placeholder="Jelaskan kondisi yang membuat Anda membutuhkan bantuan sosial..."
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 rounded-b-lg">
                    <div class="flex justify-between">
                        <a href="{{ route('applications.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            Batal
                        </a>
                        
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            💾 Simpan Pengajuan
                        </button>
                    </div>
                    
                    <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        <p><strong>Catatan:</strong> Setelah disimpan, pengajuan akan berstatus "Draft". Anda dapat mengedit dan melengkapi dokumen sebelum mengajukan untuk ditinjau.</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection