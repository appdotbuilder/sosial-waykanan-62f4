import React from 'react';
import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';

interface Props {
    stats?: {
        total_applications: number;
        pending_applications: number;
        approved_applications: number;
        total_citizens: number;
        assistance_types: number;
    };
    recentApplications?: Array<{
        id: number;
        application_number: string;
        applicant_name: string;
        assistance_type: string;
        status: string;
        status_label: string;
        created_at: string;
    }>;
    [key: string]: unknown;
}

export default function Welcome({ stats, recentApplications }: Props) {
    const { auth } = usePage<SharedData>().props;

    const features = [
        {
            icon: '📝',
            title: 'Pengajuan Online',
            description: 'Ajukan bantuan sosial secara online tanpa perlu datang ke kantor'
        },
        {
            icon: '📄',
            title: 'Upload Dokumen',
            description: 'Unggah dokumen pendukung dengan mudah dan aman'
        },
        {
            icon: '🔍',
            title: 'Lacak Status',
            description: 'Pantau perkembangan pengajuan bantuan Anda secara real-time'
        },
        {
            icon: '✅',
            title: 'Verifikasi Cepat',
            description: 'Proses verifikasi dan survey lapangan yang transparan'
        }
    ];

    const assistanceTypes = [
        { name: '💰 Bantuan Sosial Tunai (BST)', max: 'Hingga Rp 2.000.000' },
        { name: '👨‍👩‍👧‍👦 Program Keluarga Harapan (PKH)', max: 'Hingga Rp 3.000.000' },
        { name: '🍚 Bantuan Pangan Non Tunai (BPNT)', max: 'Hingga Rp 200.000' },
        { name: '♿ Bantuan Anak Berkebutuhan Khusus', max: 'Hingga Rp 5.000.000' },
        { name: '👴 Bantuan Sosial Lansia', max: 'Hingga Rp 1.500.000' },
        { name: '🏠 Bantuan Rehabilitasi Rumah', max: 'Hingga Rp 15.000.000' },
    ];

    return (
        <>
            <Head title="Sistem Pelayanan Bantuan Sosial - Dinas Sosial Kabupaten Way Kanan">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
                {/* Navigation */}
                <nav className="bg-white/95 backdrop-blur-sm shadow-sm sticky top-0 z-50 dark:bg-gray-900/95">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-3">
                                <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <span className="text-white font-bold text-sm">DS</span>
                                </div>
                                <div>
                                    <h1 className="text-lg font-semibold text-gray-900 dark:text-white">Dinas Sosial</h1>
                                    <p className="text-xs text-gray-500 dark:text-gray-400">Kabupaten Way Kanan</p>
                                </div>
                            </div>
                            <div className="flex items-center space-x-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <div className="flex space-x-3">
                                        <Link
                                            href={route('login')}
                                            className="text-gray-700 hover:text-blue-600 px-3 py-2 font-medium transition-colors dark:text-gray-300"
                                        >
                                            Masuk
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                                        >
                                            Daftar
                                        </Link>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </nav>

                {/* Hero Section */}
                <section className="py-20 px-4">
                    <div className="max-w-7xl mx-auto text-center">
                        <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6 dark:text-white">
                            🤝 <span className="text-blue-600">Sistem Pelayanan</span><br />
                            Bantuan Sosial
                        </h1>
                        <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto dark:text-gray-300">
                            Platform digital untuk mempercepat dan mempermudah akses bantuan sosial bagi masyarakat Kabupaten Way Kanan
                        </p>
                        
                        {/* Stats */}
                        {stats && (
                            <div className="grid grid-cols-2 md:grid-cols-5 gap-4 mb-12">
                                <div className="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                                    <div className="text-2xl font-bold text-blue-600">{stats.total_applications}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">Total Pengajuan</div>
                                </div>
                                <div className="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                                    <div className="text-2xl font-bold text-orange-600">{stats.pending_applications}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">Sedang Diproses</div>
                                </div>
                                <div className="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                                    <div className="text-2xl font-bold text-green-600">{stats.approved_applications}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">Disetujui</div>
                                </div>
                                <div className="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                                    <div className="text-2xl font-bold text-purple-600">{stats.total_citizens}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">Warga Terdaftar</div>
                                </div>
                                <div className="bg-white rounded-lg p-4 shadow-sm dark:bg-gray-800">
                                    <div className="text-2xl font-bold text-indigo-600">{stats.assistance_types}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">Jenis Bantuan</div>
                                </div>
                            </div>
                        )}

                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            {!auth.user && (
                                <>
                                    <Link
                                        href={route('register')}
                                        className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors"
                                    >
                                        Daftar Sekarang
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="border border-blue-600 text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-lg text-lg font-semibold transition-colors dark:hover:bg-blue-900/20"
                                    >
                                        Masuk ke Sistem
                                    </Link>
                                </>
                            )}
                            {auth.user && (
                                <Link
                                    href={route('applications.create')}
                                    className="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-semibold transition-colors"
                                >
                                    Ajukan Bantuan Baru
                                </Link>
                            )}
                        </div>
                    </div>
                </section>

                {/* Features */}
                <section className="py-16 bg-white dark:bg-gray-800">
                    <div className="max-w-7xl mx-auto px-4">
                        <h2 className="text-3xl font-bold text-center text-gray-900 mb-12 dark:text-white">
                            ✨ Fitur Unggulan
                        </h2>
                        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                            {features.map((feature, index) => (
                                <Card key={index} className="text-center hover:shadow-lg transition-shadow">
                                    <CardHeader>
                                        <div className="text-4xl mb-2">{feature.icon}</div>
                                        <CardTitle className="text-lg">{feature.title}</CardTitle>
                                    </CardHeader>
                                    <CardContent>
                                        <CardDescription>{feature.description}</CardDescription>
                                    </CardContent>
                                </Card>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Assistance Types */}
                <section className="py-16 px-4">
                    <div className="max-w-7xl mx-auto">
                        <h2 className="text-3xl font-bold text-center text-gray-900 mb-12 dark:text-white">
                            📋 Jenis Bantuan Sosial
                        </h2>
                        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {assistanceTypes.map((type, index) => (
                                <Card key={index} className="hover:shadow-lg transition-shadow">
                                    <CardHeader>
                                        <CardTitle className="text-base">{type.name}</CardTitle>
                                        <CardDescription className="text-green-600 font-semibold">
                                            {type.max}
                                        </CardDescription>
                                    </CardHeader>
                                </Card>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Recent Applications */}
                {recentApplications && recentApplications.length > 0 && (
                    <section className="py-16 bg-white dark:bg-gray-800">
                        <div className="max-w-7xl mx-auto px-4">
                            <h2 className="text-3xl font-bold text-center text-gray-900 mb-12 dark:text-white">
                                🕐 Pengajuan Terbaru
                            </h2>
                            <div className="space-y-4">
                                {recentApplications.map((application) => (
                                    <Card key={application.id} className="hover:shadow-md transition-shadow">
                                        <CardContent className="p-6">
                                            <div className="flex items-center justify-between">
                                                <div>
                                                    <div className="font-semibold text-lg">{application.applicant_name}</div>
                                                    <div className="text-gray-600 dark:text-gray-400">
                                                        {application.application_number} • {application.assistance_type}
                                                    </div>
                                                </div>
                                                <div className="text-right">
                                                    <div className={`px-3 py-1 rounded-full text-sm font-medium ${
                                                        application.status === 'approved' ? 'bg-green-100 text-green-800' :
                                                        application.status === 'rejected' ? 'bg-red-100 text-red-800' :
                                                        'bg-yellow-100 text-yellow-800'
                                                    }`}>
                                                        {application.status_label}
                                                    </div>
                                                    <div className="text-sm text-gray-500 mt-1">{application.created_at}</div>
                                                </div>
                                            </div>
                                        </CardContent>
                                    </Card>
                                ))}
                            </div>
                        </div>
                    </section>
                )}

                {/* CTA */}
                <section className="py-16 bg-blue-600 text-white">
                    <div className="max-w-4xl mx-auto text-center px-4">
                        <h2 className="text-3xl font-bold mb-4">
                            Siap Mendapatkan Bantuan Sosial?
                        </h2>
                        <p className="text-xl mb-8">
                            Daftarkan diri Anda dan ajukan bantuan sosial yang Anda butuhkan hari ini
                        </p>
                        {!auth.user && (
                            <Link
                                href={route('register')}
                                className="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors"
                            >
                                Mulai Sekarang
                            </Link>
                        )}
                        {auth.user && (
                            <Link
                                href={route('applications.index')}
                                className="bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-colors"
                            >
                                Lihat Pengajuan Saya
                            </Link>
                        )}
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-gray-900 text-white py-12">
                    <div className="max-w-7xl mx-auto px-4 text-center">
                        <div className="flex items-center justify-center space-x-3 mb-4">
                            <div className="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <span className="text-white font-bold text-sm">DS</span>
                            </div>
                            <div>
                                <h3 className="text-lg font-semibold">Dinas Sosial Kabupaten Way Kanan</h3>
                            </div>
                        </div>
                        <p className="text-gray-400 mb-4">
                            Melayani dengan sepenuh hati untuk kesejahteraan masyarakat Way Kanan
                        </p>
                        <div className="text-sm text-gray-500">
                            © 2024 Dinas Sosial Kabupaten Way Kanan. Semua hak dilindungi.
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}