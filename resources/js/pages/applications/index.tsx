import React from 'react';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface Application {
    id: number;
    application_number: string;
    applicant_name: string;
    assistance_type: {
        name: string;
    };
    status: string;
    status_label: string;
    created_at: string;
    requested_amount: number | null;
}

interface AssistanceType {
    id: number;
    name: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface PaginationMeta {
    current_page: number;
    total: number;
    per_page: number;
    last_page: number;
}

interface Props {
    applications: {
        data: Application[];
        links: PaginationLink[];
        meta: PaginationMeta;
    };
    assistanceTypes: AssistanceType[];
    filters: {
        status?: string;
        assistance_type?: string;
        search?: string;
    };
    [key: string]: unknown;
}

export default function ApplicationsIndex({ applications, assistanceTypes, filters }: Props) {
    const { auth } = usePage<{ auth: { user: { role: string } } }>().props;

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

    const handleSearch = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        const formData = new FormData(e.currentTarget);
        const search = formData.get('search') as string;
        const status = formData.get('status') as string;
        const assistance_type = formData.get('assistance_type') as string;

        router.get(route('applications.index'), {
            search: search || undefined,
            status: status || undefined,
            assistance_type: assistance_type || undefined,
        });
    };

    return (
        <AppShell>
            <Head title="Daftar Pengajuan Bantuan" />
            
            <div className="space-y-6">
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">📋 Daftar Pengajuan Bantuan</h1>
                        <p className="text-gray-600">Kelola dan pantau pengajuan bantuan sosial</p>
                    </div>
                    {auth.user.role === 'citizen' && (
                        <Link href={route('applications.create')}>
                            <Button>+ Ajukan Bantuan Baru</Button>
                        </Link>
                    )}
                </div>

                {/* Filters */}
                <Card>
                    <CardHeader>
                        <CardTitle className="text-lg">🔍 Filter & Pencarian</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form onSubmit={handleSearch} className="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Pencarian
                                </label>
                                <input
                                    type="text"
                                    name="search"
                                    defaultValue={filters.search || ''}
                                    placeholder="No. pengajuan atau nama..."
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Status
                                </label>
                                <select
                                    name="status"
                                    defaultValue={filters.status || ''}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="submitted">Diajukan</option>
                                    <option value="under_review">Sedang Ditinjau</option>
                                    <option value="field_survey">Survey Lapangan</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="rejected">Ditolak</option>
                                    <option value="completed">Selesai</option>
                                </select>
                            </div>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Jenis Bantuan
                                </label>
                                <select
                                    name="assistance_type"
                                    defaultValue={filters.assistance_type || ''}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">Semua Jenis</option>
                                    {assistanceTypes.map((type) => (
                                        <option key={type.id} value={type.id}>
                                            {type.name}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            <div className="flex items-end">
                                <Button type="submit" className="w-full">
                                    Cari
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>

                {/* Applications List */}
                <div className="space-y-4">
                    {applications.data.length === 0 ? (
                        <Card>
                            <CardContent className="py-12 text-center">
                                <div className="text-6xl mb-4">📝</div>
                                <h3 className="text-lg font-semibold text-gray-900 mb-2">
                                    Belum ada pengajuan
                                </h3>
                                <p className="text-gray-600 mb-6">
                                    {auth.user.role === 'citizen' 
                                        ? 'Anda belum memiliki pengajuan bantuan sosial.'
                                        : 'Belum ada pengajuan yang sesuai dengan filter yang dipilih.'
                                    }
                                </p>
                                {auth.user.role === 'citizen' && (
                                    <Link href={route('applications.create')}>
                                        <Button>Ajukan Bantuan Sekarang</Button>
                                    </Link>
                                )}
                            </CardContent>
                        </Card>
                    ) : (
                        <>
                            {applications.data.map((application) => (
                                <Card key={application.id} className="hover:shadow-md transition-shadow">
                                    <CardContent className="p-6">
                                        <div className="flex items-center justify-between">
                                            <div className="flex-1">
                                                <div className="flex items-center space-x-4">
                                                    <div>
                                                        <h3 className="font-semibold text-lg text-gray-900">
                                                            {application.applicant_name}
                                                        </h3>
                                                        <p className="text-sm text-gray-600">
                                                            {application.application_number}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div className="mt-2">
                                                    <p className="text-sm text-gray-800 font-medium">
                                                        {application.assistance_type.name}
                                                    </p>
                                                    {application.requested_amount && (
                                                        <p className="text-sm text-green-600">
                                                            Rp {application.requested_amount.toLocaleString('id-ID')}
                                                        </p>
                                                    )}
                                                </div>
                                            </div>
                                            <div className="text-right">
                                                <span className={`px-3 py-1 rounded-full text-sm font-medium ${getStatusBadgeColor(application.status)}`}>
                                                    {application.status_label}
                                                </span>
                                                <p className="text-sm text-gray-500 mt-2">
                                                    {new Date(application.created_at).toLocaleDateString('id-ID')}
                                                </p>
                                                <Link 
                                                    href={route('applications.show', application.id)}
                                                    className="inline-block mt-3"
                                                >
                                                    <Button variant="outline" size="sm">
                                                        Detail
                                                    </Button>
                                                </Link>
                                            </div>
                                        </div>
                                    </CardContent>
                                </Card>
                            ))}

                            {/* Pagination */}
                            {applications.links && (
                                <div className="flex justify-center space-x-2 mt-6">
                                    {applications.links.map((link: PaginationLink, index: number) => (
                                        <button
                                            key={index}
                                            onClick={() => link.url && router.get(link.url)}
                                            disabled={!link.url}
                                            className={`px-3 py-2 text-sm rounded-md ${
                                                link.active
                                                    ? 'bg-blue-600 text-white'
                                                    : link.url
                                                    ? 'bg-white text-gray-700 border hover:bg-gray-50'
                                                    : 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                            }`}
                                            dangerouslySetInnerHTML={{ __html: link.label }}
                                        />
                                    ))}
                                </div>
                            )}
                        </>
                    )}
                </div>
            </div>
        </AppShell>
    );
}