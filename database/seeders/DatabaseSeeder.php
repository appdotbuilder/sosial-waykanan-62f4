<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        \App\Models\User::factory()->create([
            'name' => 'Admin Dinas Sosial',
            'email' => 'admin@dinsos.go.id',
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jalan Pemda No. 1, Way Kanan',
            'village' => 'Way Kanan',
            'district' => 'Blambangan Umpu',
        ]);

        // Create officer users
        \App\Models\User::factory()->create([
            'name' => 'Petugas Survey',
            'email' => 'petugas@dinsos.go.id',
            'role' => 'officer',
            'phone' => '081234567891',
            'address' => 'Jalan Pemda No. 2, Way Kanan',
            'village' => 'Way Kanan',
            'district' => 'Blambangan Umpu',
        ]);

        // Create sample citizen
        \App\Models\User::factory()->create([
            'name' => 'Warga Contoh',
            'email' => 'warga@example.com',
            'role' => 'citizen',
            'phone' => '081234567892',
            'address' => 'Desa Sumber Agung, RT 01 RW 02',
            'village' => 'Sumber Agung',
            'district' => 'Blambangan Umpu',
        ]);

        // Seed assistance types
        $this->call([
            AssistanceTypeSeeder::class,
        ]);
    }
}
