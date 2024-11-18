<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Data;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'name' => 'Admin',
            'role' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'name' => 'Reviewer',
            'role' => 'Reviewer',
            'username' => 'reviewer',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'name' => 'Kabid',
            'role' => 'Kabid',
            'username' => 'kabid',
            'password' => Hash::make('123'),
        ]);

        User::create([
            'name' => 'budi',
            'role' => 'umkm',
            'username' => 'umkm',
            'password' => Hash::make('123'),
        ]);

        // DB::table('umkms')->insert([
        //     [
        //         'user_id' => 1,
        //         'status' => 'Cek Administrasi',
        //         'nama' => 'Konveksi Kain Nusantara',
        //         'email' => 'konveksi@nusantara.com',
        //         'alamat' => 'Jl. Kain No. 15, Bandung',
        //         'telepon' => '081298765432',
        //         'legalitas' => 'XX',
        //         'jenis_usaha' => 'Tekstil',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'user_id' => 1,
        //         'status' => 'Cek Administrasi',
        //         'nama' => 'Café Kopi Nusantara',
        //         'email' => 'kopi@nusantara.com',
        //         'alamat' => 'Jl. Kopi No. 7, Surabaya',
        //         'telepon' => '081234567891',
        //         'legalitas' => 'XX',
        //         'jenis_usaha' => 'Minuman',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'user_id' => 1,
        //         'status' => 'Cek Administrasi',
        //         'nama' => 'Bengkel Motor Jaya',
        //         'email' => 'bengkel@motorjaya.com',
        //         'alamat' => 'Jl. Motor No. 20, Medan',
        //         'telepon' => '081234567892',
        //         'legalitas' => 'XX',
        //         'jenis_usaha' => 'Otomotif',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'user_id' => 1,
        //         'nama' => 'Toko Elektronik Maju',
        //         'email' => 'elektronik@maju.com',
        //         'alamat' => 'Jl. Elektronik No. 25, Semarang',
        //         'telepon' => '081234567893',
        //         'legalitas' => 'XX',
        //         'jenis_usaha' => 'Elektronik',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'user_id' => 1,
        //         'status' => 'Cek Administrasi',
        //         'nama' => 'Butik Fashion Modern',
        //         'email' => 'butik@fashionmodern.com',
        //         'alamat' => 'Jl. Fashion No. 30, Yogyakarta',
        //         'telepon' => '081234567894',
        //         'legalitas' => 'XX',
        //         'jenis_usaha' => 'Fashion',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        // ]);

        $kriteria = [
            [
                'nama_kriteria' => 'Tujuan Mulia',
                'bobot' => '0.1',
                'keterangan' => 'Benefit'
            ],
            [
                'nama_kriteria' => 'Produk',
                'bobot' => '0.2',
                'keterangan' => 'Benefit'
            ],
            [
                'nama_kriteria' => 'Konsumen Potensial',
                'bobot' => '0.2',
                'keterangan' => 'Benefit'
            ],
            [
                'nama_kriteria' => 'Pemasaran',
                'bobot' => '0.2',
                'keterangan' => 'Benefit'
            ],
            [
                'nama_kriteria' => 'SDM',
                'bobot' => '0.2',
                'keterangan' => 'Benefit'
            ],
            [
                'nama_kriteria' => 'Keuangan',
                'bobot' => '0.1',
                'keterangan' => 'Benefit'
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create([
                'nama_kriteria' => $k['nama_kriteria'],
                'bobot' => $k['bobot'],
                'keterangan' => $k['keterangan'],
            ]);
        }

        $sub_kriteria = [
            // Tujuan Mulia
            [
                'nama_sub_kriteria' => 'Kontribusi Sosial Tinggi',
                'bobot' => '40',
                'kriteria_id' => '1',
            ],
            [
                'nama_sub_kriteria' => 'Kontribusi Sosial Baik',
                'bobot' => '30',
                'kriteria_id' => '1',
            ],
            [
                'nama_sub_kriteria' => 'Kontribusi Sosial Cukup',
                'bobot' => '30',
                'kriteria_id' => '1',
            ],

            // Produk
            [
                'nama_sub_kriteria' => 'Sangat Berkualitas',
                'bobot' => '50',
                'kriteria_id' => '2',
            ],
            [
                'nama_sub_kriteria' => 'Berkualitas',
                'bobot' => '30',
                'kriteria_id' => '2',
            ],
            [
                'nama_sub_kriteria' => 'Cukup Berkualitas',
                'bobot' => '20',
                'kriteria_id' => '2',
            ],

            // Konsumen Potensial
            [
                'nama_sub_kriteria' => 'Target Pasar Sangat Jelas',
                'bobot' => '40',
                'kriteria_id' => '3',
            ],
            [
                'nama_sub_kriteria' => 'Target Pasar Jelas',
                'bobot' => '35',
                'kriteria_id' => '3',
            ],
            [
                'nama_sub_kriteria' => 'Target Pasar Cukup Jelas',
                'bobot' => '25',
                'kriteria_id' => '3',
            ],

            // Pemasaran
            [
                'nama_sub_kriteria' => 'Sangat Efektif',
                'bobot' => '50',
                'kriteria_id' => '4',
            ],
            [
                'nama_sub_kriteria' => 'Efektif',
                'bobot' => '30',
                'kriteria_id' => '4',
            ],
            [
                'nama_sub_kriteria' => 'Cukup Efektif',
                'bobot' => '20',
                'kriteria_id' => '4',
            ],

            // SDM
            [
                'nama_sub_kriteria' => 'Sangat Kompeten',
                'bobot' => '50',
                'kriteria_id' => '5',
            ],
            [
                'nama_sub_kriteria' => 'Kompeten',
                'bobot' => '30',
                'kriteria_id' => '5',
            ],
            [
                'nama_sub_kriteria' => 'Cukup Kompeten',
                'bobot' => '20',
                'kriteria_id' => '5',
            ],

            // Keuangan
            [
                'nama_sub_kriteria' => 'Sangat Baik',
                'bobot' => '50',
                'kriteria_id' => '6',
            ],
            [
                'nama_sub_kriteria' => 'Baik',
                'bobot' => '30',
                'kriteria_id' => '6',
            ],
            [
                'nama_sub_kriteria' => 'Cukup Baik',
                'bobot' => '20',
                'kriteria_id' => '6',
            ],
        ];

        foreach ($sub_kriteria as $sk) {
            SubKriteria::create([
                'nama_sub_kriteria' => $sk['nama_sub_kriteria'],
                'bobot' => $sk['bobot'],
                'kriteria_id' => $sk['kriteria_id'],
            ]);
        }
    }
}
