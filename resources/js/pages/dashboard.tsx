import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface Application {
    id: number;
    application_number: string;
    applicant_name?: string;
    assistance_type: string;
    status: string;
    status_label: string;
    created_at: string;
    requested_amount?: number;
    village?: string;
    district?: string;
}

interface Stats {
    total_applications?: number;
    pending_applications?: number;
    approved_applications?: number;
    completed_applications?: number;
    pending_review?: number;
    under_survey?: number;
    approved_today?: number;
    total_citizens?: number;
    active_assistance_types?: number;
}



interface Props {
    userRole: string;
    stats: Stats;
    recentApplications: Application[];
    [key: string]: unknown;
}

export default function Dashboard({ userRole, stats, recentApplications }: Props) {
    const getStatusBadgeColor = (status: string) => {
        switch (status) {
            case 'draft':
                return 'bg-gray-100 text-gray-800';
            case 'submitted':
                return 'bg-blue-100 text-blue-800';
            case 'under_review':
                return 'bg-yellow-100 text-yellow-800';
            case 'field_survey':
                return 'bg-purple-100 text-purple-800';
            case 'approved':
                return 'bg-green-100 text-green-800';
            case 'rejected':
                return 'bg-red-100 text-red-800';
            case 'completed':
                return 'bg-emerald-100 text-emerald-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <AppShell>
            <Head title="Dashboard" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">
                            📊 Dashboard {userRole === 'citizen' ? 'Warga' : 'Petugas'}
                        </h1>
                        <p className="text-gray-600">
                            {userRole === 'citizen' 
                                ? 'Pantau pengajuan bantuan sosial Anda'
                                : 'Kelola dan pantau pengajuan bantuan sosial'
                            }
                        </p>
                    </div>
                    {userRole === 'citizen' && (
                        <Link href={route('applications.create')}>
                            <Button>+ Ajukan Bantuan Baru</Button>
                        </Link>
                    )}
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {userRole === 'citizen' ? (
                        <>
                            <Card>
                                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                    <CardTitle className="text-sm font-medium">Total Pengajuan</CardTitle>
                                    <div className="text-2xl">📝</div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold">{stats.total_applications || 0}</div>
                                    <p className="text-xs text-muted-foreground">Semua pengajuan Anda</p>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                    <CardTitle className="text-sm font-medium">Sedang Diproses</CardTitle>
                                    <div className="text-2xl">⏳</div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold text-orange-600">{stats.pending_applications || 0}</div>
                                    <p className="text-xs text-muted-foreground">Menunggu review</p>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                    <CardTitle className="text-sm font-medium">Disetujui</CardTitle>
                                    <div className="text-2xl">✅</div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold text-green-600">{stats.approved_applications || 0}</div>
                                    <p className="text-xs text-muted-foreground">Bantuan disetujui</p>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                    <CardTitle className="text-sm font-medium">Selesai</CardTitle>
                                    <div className="text-2xl">🎯</div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold text-blue-600">{stats.completed_applications || 0}</div>
                                    <p className="text-xs text-muted-foreground">Bantuan diterima</p>
                                </CardContent>
                            </Card>
                        </>
                    ) : (
                        <>
                            <Card>
                                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                    <CardTitle className="text-sm font-medium">Total Pengajuan</CardTitle>
                                    <div className="text-2xl">📊</div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold">{stats.total_applications || 0}</div>
                                    <p className="text-xs text-muted-foreground">Semua pengajuan</p>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                    <CardTitle className="text-sm font-medium">Perlu Review</CardTitle>
                                    <div className="text-2xl">🔍</div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold text-orange-600">{stats.pending_review || 0}</div>
                                    <p className="text-xs text-muted-foreground">Menunggu review</p>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                    <CardTitle className="text-sm font-medium">Survey Lapangan</CardTitle>
                                    <div className="text-2xl">🏠</div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold text-purple-600">{stats.under_survey || 0}</div>
                                    <p className="text-xs text-muted-foreground">Perlu survey</p>
                                </CardContent>
                            </Card>

                            <Card>
                                <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                                    <CardTitle className="text-sm font-medium">Disetujui Hari Ini</CardTitle>
                                    <div className="text-2xl">✨</div>
                                </CardHeader>
                                <CardContent>
                                    <div className="text-2xl font-bold text-green-600">{stats.approved_today || 0}</div>
                                    <p className="text-xs text-muted-foreground">Hari ini</p>
                                </CardContent>
                            </Card>
                        </>
                    )}
                </div>

                {/* Recent Applications */}
                <Card>
                    <CardHeader className="flex flex-row items-center justify-between">
                        <CardTitle className="text-lg">
                            🕐 {userRole === 'citizen' ? 'Pengajuan Terbaru Anda' : 'Pengajuan Masuk'}
                        </CardTitle>
                        <Link href={route('applications.index')}>
                            <Button variant="outline" size="sm">
                                Lihat Semua
                            </Button>
                        </Link>
                    </CardHeader>
                    <CardContent className="space-y-4">
                        {recentApplications.length === 0 ? (
                            <div className="text-center py-8">
                                <div className="text-4xl mb-2">📝</div>
                                <p className="text-gray-600">
                                    {userRole === 'citizen' 
                                        ? 'Belum ada pengajuan. Ajukan bantuan sosial sekarang!'
                                        : 'Tidak ada pengajuan baru saat ini.'
                                    }
                                </p>
                                {userRole === 'citizen' && (
                                    <Link href={route('applications.create')} className="inline-block mt-4">
                                        <Button>Ajukan Bantuan</Button>
                                    </Link>
                                )}
                            </div>
                        ) : (
                            recentApplications.map((application) => (
                                <div key={application.id} className="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div className="flex-1">
                                        <div className="flex items-center space-x-4">
                                            <div>
                                                <h4 className="font-medium text-gray-900">
                                                    {userRole === 'citizen' ? application.assistance_type : application.applicant_name}
                                                </h4>
                                                <p className="text-sm text-gray-600">
                                                    {application.application_number}
                                                    {userRole === 'officer' && application.village && (
                                                        <> • {application.village}, {application.district}</>
                                                    )}
                                                </p>
                                                {userRole === 'officer' && (
                                                    <p className="text-sm text-gray-800 mt-1">
                                                        {application.assistance_type}
                                                    </p>
                                                )}
                                                {application.requested_amount && (
                                                    <p className="text-sm text-green-600">
                                                        Rp {application.requested_amount.toLocaleString('id-ID')}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                    <div className="text-right">
                                        <span className={`px-3 py-1 rounded-full text-sm font-medium ${getStatusBadgeColor(application.status)}`}>
                                            {application.status_label}
                                        </span>
                                        <p className="text-sm text-gray-500 mt-2">
                                            {application.created_at}
                                        </p>
                                        <Link 
                                            href={route('applications.show', application.id)}
                                            className="inline-block mt-2"
                                        >
                                            <Button variant="outline" size="sm">
                                                Detail
                                            </Button>
                                        </Link>
                                    </div>
                                </div>
                            ))
                        )}
                    </CardContent>
                </Card>

                {/* Quick Actions */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {userRole === 'citizen' ? (
                        <>
                            <Card className="bg-blue-50 border-blue-200 hover:shadow-md transition-shadow cursor-pointer">
                                <Link href={route('applications.create')}>
                                    <CardContent className="p-6 text-center">
                                        <div className="text-3xl mb-2">➕</div>
                                        <h3 className="font-semibold text-blue-900 mb-1">Ajukan Bantuan Baru</h3>
                                        <p className="text-sm text-blue-700">Buat pengajuan bantuan sosial</p>
                                    </CardContent>
                                </Link>
                            </Card>

                            <Card className="bg-green-50 border-green-200 hover:shadow-md transition-shadow cursor-pointer">
                                <Link href={route('applications.index')}>
                                    <CardContent className="p-6 text-center">
                                        <div className="text-3xl mb-2">📋</div>
                                        <h3 className="font-semibold text-green-900 mb-1">Lihat Pengajuan</h3>
                                        <p className="text-sm text-green-700">Pantau status pengajuan Anda</p>
                                    </CardContent>
                                </Link>
                            </Card>

                            <Card className="bg-purple-50 border-purple-200 hover:shadow-md transition-shadow cursor-pointer">
                                <Link href={route('assistance-types.index')}>
                                    <CardContent className="p-6 text-center">
                                        <div className="text-3xl mb-2">📖</div>
                                        <h3 className="font-semibold text-purple-900 mb-1">Info Bantuan</h3>
                                        <p className="text-sm text-purple-700">Jenis bantuan tersedia</p>
                                    </CardContent>
                                </Link>
                            </Card>
                        </>
                    ) : (
                        <>
                            <Card className="bg-orange-50 border-orange-200 hover:shadow-md transition-shadow cursor-pointer">
                                <Link href={route('applications.index', { status: 'submitted' })}>
                                    <CardContent className="p-6 text-center">
                                        <div className="text-3xl mb-2">🔍</div>
                                        <h3 className="font-semibold text-orange-900 mb-1">Review Pengajuan</h3>
                                        <p className="text-sm text-orange-700">Tinjau pengajuan baru</p>
                                    </CardContent>
                                </Link>
                            </Card>

                            <Card className="bg-purple-50 border-purple-200 hover:shadow-md transition-shadow cursor-pointer">
                                <Link href={route('applications.index', { status: 'field_survey' })}>
                                    <CardContent className="p-6 text-center">
                                        <div className="text-3xl mb-2">🏠</div>
                                        <h3 className="font-semibold text-purple-900 mb-1">Survey Lapangan</h3>
                                        <p className="text-sm text-purple-700">Lakukan survey ke lokasi</p>
                                    </CardContent>
                                </Link>
                            </Card>

                            <Card className="bg-blue-50 border-blue-200 hover:shadow-md transition-shadow cursor-pointer">
                                <Link href={route('assistance-types.index')}>
                                    <CardContent className="p-6 text-center">
                                        <div className="text-3xl mb-2">⚙️</div>
                                        <h3 className="font-semibold text-blue-900 mb-1">Kelola Bantuan</h3>
                                        <p className="text-sm text-blue-700">Atur jenis bantuan sosial</p>
                                    </CardContent>
                                </Link>
                            </Card>
                        </>
                    )}
                </div>
            </div>
        </AppShell>
    );
}