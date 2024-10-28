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
    /**
     * Seed the application's database.
     */
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
            'name' => 'budi',
            'role' => 'umkm',
            'username' => 'umkm',
            'password' => Hash::make('123'),
        ]);

        // DB::table('umkms')->insert([
        //     [
        //         'user_id' => 1, // ID user dari tabel users
        //         'status' => 'Cek Administrasi',
        //         'nama' => 'Konveksi Kain Nusantara',
        //         'email' => 'konveksi@nusantara.com',
        //         'alamat' => 'Jl. Kain No. 15, Bandung',
        //         'telepon' => '081298765432',
        //         'legalitas' => 'XX',
        //         'nama_produk' => 'Seragam Sekolah',
        //         'jenis_usaha' => 'Tekstil',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'user_id' => 1, // ID user dari tabel users
        //         'status' => 'Cek Administrasi',
        //         'nama' => 'Café Kopi Nusantara',
        //         'email' => 'kopi@nusantara.com',
        //         'alamat' => 'Jl. Kopi No. 7, Surabaya',
        //         'telepon' => '081234567891',
        //         'legalitas' => 'XX',
        //         'nama_produk' => 'Kopi Arabika',
        //         'jenis_usaha' => 'Minuman',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'user_id' => 1, // ID user dari tabel users
        //         'status' => 'Cek Administrasi',
        //         'nama' => 'Bengkel Motor Jaya',
        //         'email' => 'bengkel@motorjaya.com',
        //         'alamat' => 'Jl. Motor No. 20, Medan',
        //         'telepon' => '081234567892',
        //         'legalitas' => 'XX',
        //         'nama_produk' => 'Servis Motor',
        //         'jenis_usaha' => 'Otomotif',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'user_id' => 1, // ID user dari tabel users
        //         'nama' => 'Toko Elektronik Maju',
        //         'email' => 'elektronik@maju.com',
        //         'alamat' => 'Jl. Elektronik No. 25, Semarang',
        //         'telepon' => '081234567893',
        //         'legalitas' => 'XX',
        //         'nama_produk' => 'Peralatan Elektronik',
        //         'jenis_usaha' => 'Elektronik',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        //     [
        //         'user_id' => 1, // ID user dari tabel users
        //         'status' => 'Cek Administrasi',
        //         'nama' => 'Butik Fashion Modern',
        //         'email' => 'butik@fashionmodern.com',
        //         'alamat' => 'Jl. Fashion No. 30, Yogyakarta',
        //         'telepon' => '081234567894',
        //         'legalitas' => 'XX',
        //         'nama_produk' => 'Pakaian Wanita',
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
            [
                'nama_sub_kriteria' => 'Tepat Waktu',
                'bobot' => '30',
                'kriteria_id' => '1',
            ],
            [
                'nama_sub_kriteria' => 'Total Jam Kerja',
                'bobot' => '40',
                'kriteria_id' => '1',
            ],
            [
                'nama_sub_kriteria' => 'Izin Kerja',
                'bobot' => '30',
                'kriteria_id' => '1',
            ],
            [
                'nama_sub_kriteria' => 'Inisiatif Karyawan',
                'bobot' => '50',
                'kriteria_id' => '2',
            ],
            [
                'nama_sub_kriteria' => 'Kolaborasi Karyawan',
                'bobot' => '50',
                'kriteria_id' => '2',
            ],
            [
                'nama_sub_kriteria' => 'Tanggung Jawab',
                'bobot' => '100',
                'kriteria_id' => '3',
            ],
            [
                'nama_sub_kriteria' => 'Komunikasi',
                'bobot' => '50',
                'kriteria_id' => '4',
            ],
            [
                'nama_sub_kriteria' => 'kejujuran',
                'bobot' => '50',
                'kriteria_id' => '4',
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
