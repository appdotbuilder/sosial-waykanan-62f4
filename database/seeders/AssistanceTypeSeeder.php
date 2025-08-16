<?php

namespace Database\Seeders;

use App\Models\AssistanceType;
use Illuminate\Database\Seeder;

class AssistanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assistanceTypes = [
            [
                'name' => 'Bantuan Sosial Tunai (BST)',
                'description' => 'Bantuan sosial berupa uang tunai untuk keluarga miskin dan rentan',
                'requirements' => 'KTP, KK, SKTM dari Kelurahan, Surat Keterangan Penghasilan',
                'max_amount' => 2000000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Program Keluarga Harapan (PKH)',
                'description' => 'Bantuan sosial bersyarat untuk keluarga sangat miskin',
                'requirements' => 'KTP, KK, SKTM, Surat Keterangan Hamil/Sekolah',
                'max_amount' => 3000000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Bantuan Pangan Non Tunai (BPNT)',
                'description' => 'Bantuan sembako untuk keluarga kurang mampu',
                'requirements' => 'KTP, KK, SKTM dari Kelurahan',
                'max_amount' => 200000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Bantuan Sosial Anak Berkebutuhan Khusus',
                'description' => 'Bantuan khusus untuk anak-anak berkebutuhan khusus',
                'requirements' => 'KTP, KK, Surat Keterangan Dokter/Psikolog, Surat Keterangan Sekolah',
                'max_amount' => 5000000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Bantuan Sosial Lansia',
                'description' => 'Bantuan sosial untuk lanjut usia tidak produktif',
                'requirements' => 'KTP, KK, SKTM, Surat Keterangan Kesehatan',
                'max_amount' => 1500000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Bantuan Rehabilitasi Rumah',
                'description' => 'Bantuan untuk perbaikan rumah tidak layak huni',
                'requirements' => 'KTP, KK, SKTM, Foto Kondisi Rumah, Surat Kepemilikan Tanah',
                'max_amount' => 15000000.00,
                'is_active' => true,
            ],
        ];

        foreach ($assistanceTypes as $type) {
            AssistanceType::create($type);
        }
    }
}