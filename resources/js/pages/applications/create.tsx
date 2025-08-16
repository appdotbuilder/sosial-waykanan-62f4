import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface AssistanceType {
    id: number;
    name: string;
    description: string;
    requirements: string | null;
    max_amount: number | null;
}

interface Props {
    assistanceTypes: AssistanceType[];
    [key: string]: unknown;
}



export default function CreateApplication({ assistanceTypes }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        assistance_type_id: '',
        applicant_name: '',
        nik: '',
        phone: '',
        address: '',
        village: '',
        district: '',
        requested_amount: '',
        reason: '',
    });

    const selectedAssistanceType = assistanceTypes.find(
        type => type.id.toString() === data.assistance_type_id
    );

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('applications.store'));
    };

    return (
        <AppShell>
            <Head title="Ajukan Bantuan Sosial Baru" />
            
            <div className="max-w-4xl mx-auto space-y-6">
                <div>
                    <h1 className="text-2xl font-bold text-gray-900">📝 Ajukan Bantuan Sosial Baru</h1>
                    <p className="text-gray-600">Lengkapi formulir di bawah ini untuk mengajukan bantuan sosial</p>
                </div>

                <form onSubmit={handleSubmit} className="space-y-6">
                    {/* Jenis Bantuan */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg">🎯 Jenis Bantuan</CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Jenis Bantuan *
                                </label>
                                <select
                                    value={data.assistance_type_id}
                                    onChange={(e) => setData('assistance_type_id', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                >
                                    <option value="">Pilih Jenis Bantuan...</option>
                                    {assistanceTypes.map((type) => (
                                        <option key={type.id} value={type.id}>
                                            {type.name}
                                        </option>
                                    ))}
                                </select>
                                {errors.assistance_type_id && (
                                    <p className="mt-1 text-sm text-red-600">{errors.assistance_type_id}</p>
                                )}
                            </div>

                            {selectedAssistanceType && (
                                <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <h4 className="font-medium text-blue-900 mb-2">
                                        {selectedAssistanceType.name}
                                    </h4>
                                    <p className="text-sm text-blue-800 mb-3">
                                        {selectedAssistanceType.description}
                                    </p>
                                    {selectedAssistanceType.max_amount && (
                                        <p className="text-sm text-green-700 font-medium mb-3">
                                            Maksimal: Rp {selectedAssistanceType.max_amount.toLocaleString('id-ID')}
                                        </p>
                                    )}
                                    {selectedAssistanceType.requirements && (
                                        <div>
                                            <h5 className="font-medium text-blue-900 mb-1">Persyaratan:</h5>
                                            <p className="text-sm text-blue-800">
                                                {selectedAssistanceType.requirements}
                                            </p>
                                        </div>
                                    )}
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    {/* Data Pemohon */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg">👤 Data Pemohon</CardTitle>
                        </CardHeader>
                        <CardContent className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Lengkap *
                                </label>
                                <input
                                    type="text"
                                    value={data.applicant_name}
                                    onChange={(e) => setData('applicant_name', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan nama lengkap sesuai KTP"
                                />
                                {errors.applicant_name && (
                                    <p className="mt-1 text-sm text-red-600">{errors.applicant_name}</p>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    NIK *
                                </label>
                                <input
                                    type="text"
                                    value={data.nik}
                                    onChange={(e) => setData('nik', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="16 digit NIK"
                                    maxLength={16}
                                />
                                {errors.nik && (
                                    <p className="mt-1 text-sm text-red-600">{errors.nik}</p>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Nomor Telepon *
                                </label>
                                <input
                                    type="tel"
                                    value={data.phone}
                                    onChange={(e) => setData('phone', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Contoh: 081234567890"
                                />
                                {errors.phone && (
                                    <p className="mt-1 text-sm text-red-600">{errors.phone}</p>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Jumlah Bantuan Diajukan
                                </label>
                                <input
                                    type="number"
                                    value={data.requested_amount}
                                    onChange={(e) => setData('requested_amount', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Jumlah dalam Rupiah"
                                    min="0"
                                />
                                {errors.requested_amount && (
                                    <p className="mt-1 text-sm text-red-600">{errors.requested_amount}</p>
                                )}
                                {selectedAssistanceType?.max_amount && (
                                    <p className="mt-1 text-sm text-gray-500">
                                        Maksimal: Rp {selectedAssistanceType.max_amount.toLocaleString('id-ID')}
                                    </p>
                                )}
                            </div>

                            <div className="md:col-span-2">
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Alamat Lengkap *
                                </label>
                                <textarea
                                    value={data.address}
                                    onChange={(e) => setData('address', e.target.value)}
                                    rows={3}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan alamat lengkap termasuk RT/RW"
                                />
                                {errors.address && (
                                    <p className="mt-1 text-sm text-red-600">{errors.address}</p>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Desa/Kelurahan *
                                </label>
                                <input
                                    type="text"
                                    value={data.village}
                                    onChange={(e) => setData('village', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Nama desa atau kelurahan"
                                />
                                {errors.village && (
                                    <p className="mt-1 text-sm text-red-600">{errors.village}</p>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Kecamatan *
                                </label>
                                <input
                                    type="text"
                                    value={data.district}
                                    onChange={(e) => setData('district', e.target.value)}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Nama kecamatan"
                                />
                                {errors.district && (
                                    <p className="mt-1 text-sm text-red-600">{errors.district}</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Alasan Permohonan */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg">📋 Alasan Permohonan</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-1">
                                    Jelaskan alasan Anda membutuhkan bantuan ini *
                                </label>
                                <textarea
                                    value={data.reason}
                                    onChange={(e) => setData('reason', e.target.value)}
                                    rows={6}
                                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Tuliskan dengan jelas kondisi dan alasan Anda membutuhkan bantuan sosial ini..."
                                />
                                {errors.reason && (
                                    <p className="mt-1 text-sm text-red-600">{errors.reason}</p>
                                )}
                            </div>
                        </CardContent>
                    </Card>

                    {/* Action Buttons */}
                    <div className="flex justify-end space-x-4 pt-6">
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => window.history.back()}
                        >
                            Batal
                        </Button>
                        <Button
                            type="submit"
                            disabled={processing}
                            className="min-w-[120px]"
                        >
                            {processing ? 'Menyimpan...' : 'Simpan Pengajuan'}
                        </Button>
                    </div>
                </form>

                <Card className="bg-yellow-50 border-yellow-200">
                    <CardContent className="p-4">
                        <div className="flex items-start space-x-3">
                            <div className="text-2xl">💡</div>
                            <div>
                                <h4 className="font-medium text-yellow-800 mb-1">Informasi Penting</h4>
                                <ul className="text-sm text-yellow-700 space-y-1">
                                    <li>• Pengajuan akan disimpan sebagai draft terlebih dahulu</li>
                                    <li>• Anda dapat mengedit pengajuan sebelum diajukan</li>
                                    <li>• Pastikan data yang diisi sudah benar dan lengkap</li>
                                    <li>• Siapkan dokumen pendukung sesuai persyaratan</li>
                                </ul>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppShell>
    );
}