import React from 'react';
import { Head, Link, router, usePage } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface Application {
    id: number;
    application_number: string;
    applicant_name: string;
    nik: string;
    phone: string;
    address: string;
    village: string;
    district: string;
    requested_amount: number | null;
    reason: string;
    status: string;
    status_label: string;
    notes: string | null;
    rejection_reason: string | null;
    created_at: string;
    submitted_at: string | null;
    approved_at: string | null;
    completed_at: string | null;
    user: {
        id: number;
        name: string;
        email: string;
    };
    assistance_type: {
        id: number;
        name: string;
        description: string;
        requirements: string | null;
        max_amount: number | null;
    };
    reviewer: {
        id: number;
        name: string;
    } | null;
    documents: Array<{
        id: number;
        document_type: string;
        original_name: string;
        file_path: string;
        is_verified: boolean;
        verification_notes: string | null;
        created_at: string;
    }>;
    field_survey: {
        id: number;
        surveyor: {
            name: string;
        };
        survey_date: string;
        findings: string;
        recommendations: string;
        recommendation_status: string;
        photos: Array<{
            id: number;
            photo_path: string;
            description: string | null;
            photo_type: string | null;
        }>;
    } | null;
}

interface Props {
    application: Application;
    [key: string]: unknown;
}

export default function ShowApplication({ application }: Props) {
    const { auth } = usePage<{ auth: { user: { id: number } } }>().props;

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

    const handleSubmit = () => {
        if (confirm('Apakah Anda yakin ingin mengajukan permohonan ini? Setelah diajukan, data tidak dapat diedit lagi.')) {
            router.patch(route('applications.update', application.id), { submit: 'true' });
        }
    };

    const isOwner = auth.user.id === application.user.id;
    const canEdit = isOwner && application.status === 'draft';
    const canSubmit = isOwner && application.status === 'draft';
    const canDelete = isOwner && application.status === 'draft';

    return (
        <AppShell>
            <Head title={`Detail Pengajuan ${application.application_number}`} />
            
            <div className="max-w-4xl mx-auto space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold text-gray-900">
                            📄 Detail Pengajuan
                        </h1>
                        <p className="text-gray-600">{application.application_number}</p>
                    </div>
                    <div className="flex space-x-3">
                        {canEdit && (
                            <Link href={route('applications.edit', application.id)}>
                                <Button variant="outline">✏️ Edit</Button>
                            </Link>
                        )}
                        {canSubmit && (
                            <Button onClick={handleSubmit} className="bg-blue-600 hover:bg-blue-700">
                                📤 Ajukan
                            </Button>
                        )}
                        <Link href={route('applications.index')}>
                            <Button variant="outline">← Kembali</Button>
                        </Link>
                    </div>
                </div>

                {/* Status Card */}
                <Card className="bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200">
                    <CardContent className="p-6">
                        <div className="flex items-center justify-between">
                            <div>
                                <h3 className="text-lg font-semibold text-gray-900 mb-2">Status Pengajuan</h3>
                                <span className={`px-4 py-2 rounded-full text-sm font-medium ${getStatusBadgeColor(application.status)}`}>
                                    {application.status_label}
                                </span>
                                <div className="mt-3 text-sm text-gray-600">
                                    <p>Dibuat: {new Date(application.created_at).toLocaleDateString('id-ID', { 
                                        weekday: 'long', 
                                        year: 'numeric', 
                                        month: 'long', 
                                        day: 'numeric',
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    })}</p>
                                    {application.submitted_at && (
                                        <p>Diajukan: {new Date(application.submitted_at).toLocaleDateString('id-ID', { 
                                            weekday: 'long', 
                                            year: 'numeric', 
                                            month: 'long', 
                                            day: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        })}</p>
                                    )}
                                    {application.approved_at && (
                                        <p>Disetujui: {new Date(application.approved_at).toLocaleDateString('id-ID', { 
                                            weekday: 'long', 
                                            year: 'numeric', 
                                            month: 'long', 
                                            day: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        })}</p>
                                    )}
                                </div>
                            </div>
                            <div className="text-right">
                                {application.reviewer && (
                                    <div className="text-sm text-gray-600">
                                        <p className="font-medium">Ditinjau oleh:</p>
                                        <p>{application.reviewer.name}</p>
                                    </div>
                                )}
                            </div>
                        </div>
                    </CardContent>
                </Card>

                {/* Rejection Reason */}
                {application.status === 'rejected' && application.rejection_reason && (
                    <Card className="bg-red-50 border-red-200">
                        <CardHeader>
                            <CardTitle className="text-lg text-red-800">❌ Alasan Penolakan</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <p className="text-red-700">{application.rejection_reason}</p>
                        </CardContent>
                    </Card>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Application Info */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg">📋 Informasi Pengajuan</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div>
                                <label className="text-sm font-medium text-gray-600">Jenis Bantuan</label>
                                <p className="text-gray-900 font-medium">{application.assistance_type.name}</p>
                                <p className="text-sm text-gray-600 mt-1">{application.assistance_type.description}</p>
                            </div>
                            {application.requested_amount && (
                                <div>
                                    <label className="text-sm font-medium text-gray-600">Jumlah Bantuan Diajukan</label>
                                    <p className="text-lg font-semibold text-green-600">
                                        Rp {application.requested_amount.toLocaleString('id-ID')}
                                    </p>
                                </div>
                            )}
                            <div>
                                <label className="text-sm font-medium text-gray-600">Alasan Permohonan</label>
                                <p className="text-gray-900 whitespace-pre-wrap">{application.reason}</p>
                            </div>
                        </CardContent>
                    </Card>

                    {/* Personal Info */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg">👤 Data Pemohon</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div>
                                <label className="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                <p className="text-gray-900">{application.applicant_name}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-gray-600">NIK</label>
                                <p className="text-gray-900">{application.nik}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-gray-600">Nomor Telepon</label>
                                <p className="text-gray-900">{application.phone}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-gray-600">Alamat Lengkap</label>
                                <p className="text-gray-900">{application.address}</p>
                            </div>
                            <div className="grid grid-cols-2 gap-4">
                                <div>
                                    <label className="text-sm font-medium text-gray-600">Desa/Kelurahan</label>
                                    <p className="text-gray-900">{application.village}</p>
                                </div>
                                <div>
                                    <label className="text-sm font-medium text-gray-600">Kecamatan</label>
                                    <p className="text-gray-900">{application.district}</p>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Requirements */}
                {application.assistance_type.requirements && (
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg">📝 Persyaratan</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <p className="text-gray-700">{application.assistance_type.requirements}</p>
                        </CardContent>
                    </Card>
                )}

                {/* Documents */}
                <Card>
                    <CardHeader>
                        <CardTitle className="text-lg">📎 Dokumen Pendukung</CardTitle>
                    </CardHeader>
                    <CardContent>
                        {application.documents.length === 0 ? (
                            <div className="text-center py-8 bg-gray-50 rounded-lg">
                                <div className="text-4xl mb-2">📁</div>
                                <p className="text-gray-600 mb-4">
                                    Belum ada dokumen yang diunggah
                                </p>
                                {canEdit && (
                                    <Link href={route('applications.edit', application.id)}>
                                        <Button>Upload Dokumen</Button>
                                    </Link>
                                )}
                            </div>
                        ) : (
                            <div className="space-y-3">
                                {application.documents.map((document) => (
                                    <div key={document.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div className="flex items-center space-x-3">
                                            <div className="text-2xl">📄</div>
                                            <div>
                                                <p className="font-medium text-gray-900">{document.original_name}</p>
                                                <p className="text-sm text-gray-600">{document.document_type}</p>
                                                {document.verification_notes && (
                                                    <p className="text-sm text-gray-500 mt-1">
                                                        Catatan: {document.verification_notes}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                        <div className="text-right">
                                            <span className={`px-2 py-1 text-xs rounded-full ${
                                                document.is_verified 
                                                    ? 'bg-green-100 text-green-800' 
                                                    : 'bg-yellow-100 text-yellow-800'
                                            }`}>
                                                {document.is_verified ? 'Terverifikasi' : 'Belum Verifikasi'}
                                            </span>
                                            <p className="text-xs text-gray-500 mt-1">
                                                {new Date(document.created_at).toLocaleDateString('id-ID')}
                                            </p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </CardContent>
                </Card>

                {/* Field Survey */}
                {application.field_survey && (
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg">🏠 Hasil Survey Lapangan</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label className="text-sm font-medium text-gray-600">Surveyor</label>
                                    <p className="text-gray-900">{application.field_survey.surveyor.name}</p>
                                </div>
                                <div>
                                    <label className="text-sm font-medium text-gray-600">Tanggal Survey</label>
                                    <p className="text-gray-900">
                                        {new Date(application.field_survey.survey_date).toLocaleDateString('id-ID')}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-gray-600">Temuan Lapangan</label>
                                <p className="text-gray-900 whitespace-pre-wrap">{application.field_survey.findings}</p>
                            </div>
                            <div>
                                <label className="text-sm font-medium text-gray-600">Rekomendasi</label>
                                <p className="text-gray-900 whitespace-pre-wrap">{application.field_survey.recommendations}</p>
                                <span className={`inline-block mt-2 px-3 py-1 text-sm rounded-full ${
                                    application.field_survey.recommendation_status === 'approve' 
                                        ? 'bg-green-100 text-green-800' 
                                        : application.field_survey.recommendation_status === 'reject'
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-yellow-100 text-yellow-800'
                                }`}>
                                    {application.field_survey.recommendation_status === 'approve' ? 'Direkomendasikan' :
                                     application.field_survey.recommendation_status === 'reject' ? 'Tidak Direkomendasikan' :
                                     'Perlu Revisi'}
                                </span>
                            </div>

                            {/* Survey Photos */}
                            {application.field_survey.photos.length > 0 && (
                                <div>
                                    <label className="text-sm font-medium text-gray-600 block mb-3">Foto Survey</label>
                                    <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        {application.field_survey.photos.map((photo) => (
                                            <div key={photo.id} className="bg-gray-100 rounded-lg p-2">
                                                <div className="aspect-square bg-gray-200 rounded-md mb-2 flex items-center justify-center">
                                                    <span className="text-gray-500">📷</span>
                                                </div>
                                                {photo.description && (
                                                    <p className="text-sm text-gray-600">{photo.description}</p>
                                                )}
                                                {photo.photo_type && (
                                                    <p className="text-xs text-gray-500">{photo.photo_type}</p>
                                                )}
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </CardContent>
                    </Card>
                )}

                {/* Notes */}
                {application.notes && (
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg">📝 Catatan</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <p className="text-gray-700 whitespace-pre-wrap">{application.notes}</p>
                        </CardContent>
                    </Card>
                )}

                {/* Action Buttons */}
                {(canEdit || canDelete) && (
                    <Card className="bg-gray-50 border-gray-200">
                        <CardContent className="p-4">
                            <div className="flex justify-between items-center">
                                <div>
                                    <h4 className="font-medium text-gray-900">Tindakan</h4>
                                    <p className="text-sm text-gray-600">Kelola pengajuan Anda</p>
                                </div>
                                <div className="flex space-x-3">
                                    {canDelete && (
                                        <Button
                                            variant="destructive"
                                            onClick={() => {
                                                if (confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')) {
                                                    router.delete(route('applications.destroy', application.id));
                                                }
                                            }}
                                        >
                                            🗑️ Hapus
                                        </Button>
                                    )}
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                )}
            </div>
        </AppShell>
    );
}