@extends('layouts.app')

@section('title', 'Sistem Pelayanan Bantuan Sosial - Dinas Sosial Kabupaten Way Kanan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Hero Section -->
    <section class="py-20 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 dark:text-white">
                🤝 <span class="text-blue-600">Sistem Pelayanan</span><br>
                Bantuan Sosial
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto dark:text-gray-300">
                Platform digital untuk mempercepat dan mempermudah akses bantuan sosial bagi masyarakat Kabupaten Way Kanan
            </p>
            
            <!-- Stats -->
            @if($stats)
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-12">
                    <div class="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_applications'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Pengajuan</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                        <div class="text-2xl font-bold text-orange-600">{{ $stats['pending_applications'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Sedang Diproses</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['approved_applications'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Disetujui</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                        <div class="text-2xl font-bold text-purple-600">{{ $stats['total_citizens'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Warga Terdaftar</div>
                    </div>
                    <div class="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                        <div class="text-2xl font-bold text-indigo-600">{{ $stats['assistance_types'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Jenis Bantuan</div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" 
                       class="border border-blue-600 text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-lg text-lg font-semibold transition-colors dark:hover:bg-blue-900/20">
                        Masuk ke Sistem
                    </a>
                @else
                    <a href="{{ route('applications.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                        Ajukan Bantuan Baru
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12 dark:text-white">
                ✨ Fitur Unggulan
            </h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $features = [
                        [
                            'icon' => '📝',
                            'title' => 'Pengajuan Online',
                            'description' => 'Ajukan bantuan sosial secara online tanpa perlu datang ke kantor'
                        ],
                        [
                            'icon' => '📄',
                            'title' => 'Upload Dokumen',
                            'description' => 'Unggah dokumen pendukung dengan mudah dan aman'
                        ],
                        [
                            'icon' => '🔍',
                            'title' => 'Lacak Status',
                            'description' => 'Pantau perkembangan pengajuan bantuan Anda secara real-time'
                        ],
                        [
                            'icon' => '✅',
                            'title' => 'Verifikasi Cepat',
                            'description' => 'Proses verifikasi dan survey lapangan yang transparan'
                        ]
                    ];
                @endphp
                
                @foreach($features as $feature)
                    <div class="bg-gray-50 rounded-lg p-6 text-center hover:shadow-lg transition-shadow dark:bg-gray-700">
                        <div class="text-4xl mb-4">{{ $feature['icon'] }}</div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 dark:text-white">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Assistance Types -->
    <section class="py-16 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12 dark:text-white">
                📋 Jenis Bantuan Sosial
            </h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $assistanceTypes = [
                        ['name' => '💰 Bantuan Sosial Tunai (BST)', 'max' => 'Hingga Rp 2.000.000'],
                        ['name' => '👨‍👩‍👧‍👦 Program Keluarga Harapan (PKH)', 'max' => 'Hingga Rp 3.000.000'],
                        ['name' => '🍚 Bantuan Pangan Non Tunai (BPNT)', 'max' => 'Hingga Rp 200.000'],
                        ['name' => '♿ Bantuan Anak Berkebutuhan Khusus', 'max' => 'Hingga Rp 5.000.000'],
                        ['name' => '👴 Bantuan Sosial Lansia', 'max' => 'Hingga Rp 1.500.000'],
                        ['name' => '🏠 Bantuan Rehabilitasi Rumah', 'max' => 'Hingga Rp 15.000.000'],
                    ];
                @endphp
                
                @foreach($assistanceTypes as $type)
                    <div class="bg-white rounded-lg p-6 hover:shadow-lg transition-shadow dark:bg-gray-800">
                        <h3 class="text-base font-semibold text-gray-900 mb-2 dark:text-white">{{ $type['name'] }}</h3>
                        <p class="text-green-600 font-semibold">{{ $type['max'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Recent Applications -->
    @if($recentApplications && count($recentApplications) > 0)
        <section class="py-16 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12 dark:text-white">
                    🕐 Pengajuan Terbaru
                </h2>
                <div class="space-y-4">
                    @foreach($recentApplications as $application)
                        <div class="bg-gray-50 rounded-lg p-6 hover:shadow-md transition-shadow dark:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-semibold text-lg text-gray-900 dark:text-white">{{ $application['applicant_name'] }}</div>
                                    <div class="text-gray-600 dark:text-gray-400">
                                        {{ $application['application_number'] }} • {{ $application['assistance_type'] }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="px-3 py-1 rounded-full text-sm font-medium 
                                        @if($application['status'] === 'approved') bg-green-100 text-green-800
                                        @elseif($application['status'] === 'rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ $application['status_label'] }}
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">{{ $application['created_at'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- CTA -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl font-bold mb-4">
                Siap Mendapatkan Bantuan Sosial?
            </h2>
            <p class="text-xl mb-8">
                Daftarkan diri Anda dan ajukan bantuan sosial yang Anda butuhkan hari ini
            </p>
            @guest
                <a href="{{ route('register') }}" 
                   class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    Mulai Sekarang
                </a>
            @else
                <a href="{{ route('applications.index') }}" 
                   class="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors">
                    Lihat Pengajuan Saya
                </a>
            @endguest
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush