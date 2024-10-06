<?php

namespace App\Livewire;

use App\Models\Kriteria;
use App\Models\Penilaiandb;
use App\Models\Umkm;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Penilaian extends Component
{
    public $step = 1;
    public $umkms = [];
    public $kriterias = [];
    public $kriteriaPenilaian = [];
    public $bobot = [];
    public $kriteriaTypes = [
        1 => 'benefit',
        2 => 'benefit',
        3 => 'benefit',
        4 => 'benefit',
        5 => 'benefit',
        6 => 'cost'
    ];
    public $penilaianData = [];

    public $tgl_penilaian = '';


    public function mount()
    {
        $this->tgl_penilaian = Carbon::now()->format('Y-m-d');
        $this->getDataAwal();
        $this->getKriteriaPenilaian();
        // dd($this->getKriteriaPenilaian());
    }

    public function getDataAwal()
    {
        $this->umkms = Umkm::all();
        $this->kriterias = Kriteria::all();
        $this->bobot = Kriteria::pluck('bobot')->toArray();
    }

    public function getKriteriaPenilaian()
    {
        $kriteriaPenilaian = Kriteria::all();

        $kriteriaPenilaianArray = $kriteriaPenilaian->toArray();
        // dd($kriteriaPenilaianArray);
        $this->kriteriaPenilaian = $kriteriaPenilaianArray;
        return $this->kriteriaPenilaian;
    }

    public function getPenialaianList()
    {
        // Inisialisasi array penilaian
        $penilaianData = [];

        // Loop melalui umkms (pelanggan) yang ada
        foreach ($this->umkms as $umkm) {
            $umkm = Umkm::find($umkm['id']);
            // Set pelanggan_id untuk penilaian
            $penilaianData[$umkm['id']] = [
                'umkm_id' => $umkm['id'],
                'umkm_nama' => $umkm['nama'],
                'kriteria' => [],
            ];

            // Loop melalui kriteria penilaian
            foreach ($this->kriteriaPenilaian as $kriteria) {
                // Ambil nilai dari input yang dimodelkan dengan wire:model
                $selectedBobot = $this->penilaianData[$umkm['id']][$kriteria['id']] ?? null;
                // Masukkan ke dalam array penilaianData
                $penilaianData[$umkm['id']]['kriteria'][$kriteria['id']] = [
                    'kriteria_id' => $kriteria['id'],
                    'nilai' => $selectedBobot, // Nilai yang diinput user
                ];
            }
        }

        // Set penilaianData menjadi array hasil
        $this->penilaianData = $penilaianData;

        // Return data penilaian untuk diproses lebih lanjut jika diperlukan
        return $penilaianData;
    }

    function calculatePembagi($data, $jumlah_kriteria)
    {
        // Inisialisasi array untuk menampung nilai pembagi tiap kriteria
        $pembagi = array_fill(1, $jumlah_kriteria, 0);

        // Loop melalui setiap pelanggan dan kumpulkan nilai kuadrat untuk setiap kriteria
        foreach ($data as $pelanggan) {
            foreach ($pelanggan['kriteria'] as $kriteria_id => $kriteria) {
                // Tambahkan nilai kuadrat untuk kriteria tertentu
                $pembagi[$kriteria_id] += pow($kriteria['nilai'], 2);
            }
        }

        // Hitung akar kuadrat dari penjumlahan kuadrat tiap kriteria
        foreach ($pembagi as $kriteria_id => $total_nilai_kuadrat) {
            $pembagi[$kriteria_id] = sqrt($total_nilai_kuadrat);
        }

        return $pembagi;
    }
    public function calculateMatriksTernormalisasi($penilaianData, $pembagi)
    {
        // Inisialisasi array untuk menampung matriks ternormalisasi
        $matriksTernormalisasi = [];

        // Iterasi melalui setiap pelanggan dan nilai kriteria mereka
        foreach ($penilaianData as $umkm_id => $pelanggan) {
            // Buat array untuk menyimpan nilai ternormalisasi dari pelanggan ini
            $matriksTernormalisasi[$umkm_id] = [
                'umkm_id' => $umkm_id,
                'kriteria' => [],
            ];

            // Iterasi melalui setiap kriteria untuk pelanggan ini
            foreach ($pelanggan['kriteria'] as $kriteria_id => $kriteria) {
                $nilai = $kriteria['nilai'];

                // Lakukan normalisasi nilai dengan membaginya oleh pembagi yang sesuai
                $nilaiTernormalisasi = ($pembagi[$kriteria_id] != 0) ? $nilai / $pembagi[$kriteria_id] : 0;

                // Simpan nilai yang sudah ternormalisasi
                $matriksTernormalisasi[$umkm_id]['kriteria'][$kriteria_id] = [
                    'kriteria_id' => $kriteria_id,
                    'nilai_ternormalisasi' => $nilaiTernormalisasi,
                ];
            }
        }

        return $matriksTernormalisasi;
    }
    public function calculateMatriksTerbobot($matriksTernormalisasi, $bobot)
    {
        // Inisialisasi array untuk menyimpan matriks terbobot (Y)
        $matriksTerbobot = [];

        // Iterasi melalui setiap pelanggan
        foreach ($matriksTernormalisasi as $umkm_id => $pelanggan) {
            // Buat array untuk menyimpan nilai terbobot dari pelanggan ini
            $matriksTerbobot[$umkm_id] = [
                'umkm_id' => $umkm_id,
                'kriteria' => [],
            ];

            // Iterasi melalui setiap kriteria untuk pelanggan ini
            foreach ($pelanggan['kriteria'] as $kriteria_id => $kriteria) {
                $nilaiTernormalisasi = $kriteria['nilai_ternormalisasi'];

                // Pastikan indeks bobot ada dan cocok dengan kriteria_id
                if (isset($bobot[$kriteria_id - 1])) {
                    // Hitung nilai terbobot dengan mengalikan nilai ternormalisasi dengan bobot kriteria
                    $nilaiTerbobot = $nilaiTernormalisasi * $bobot[$kriteria_id - 1];

                    // Simpan nilai yang sudah terbobot
                    $matriksTerbobot[$umkm_id]['kriteria'][$kriteria_id] = [
                        'kriteria_id' => $kriteria_id,
                        'nilai_terbobot' => $nilaiTerbobot,
                    ];
                }
            }
        }

        return $matriksTerbobot;
    }

    public function calculateSolusiIdealPositif($matriksTerbobot, $kriteriaTypes)
    {
        // Inisialisasi array untuk menyimpan solusi ideal positif
        $solusiIdealPositif = [];

        // Iterasi setiap kriteria
        foreach ($kriteriaTypes as $kriteria_id => $type) {
            $nilaiKriteria = [];

            // Ambil semua nilai terbobot untuk kriteria ini
            foreach ($matriksTerbobot as $pelanggan) {
                $nilaiKriteria[] = $pelanggan['kriteria'][$kriteria_id]['nilai_terbobot'];
            }

            // Jika tipe kriteria adalah 'benefit', ambil nilai maksimum
            if ($type == 'benefit') {
                $solusiIdealPositif[$kriteria_id] = max($nilaiKriteria);
            }
            // Jika tipe kriteria adalah 'cost', ambil nilai minimum
            else if ($type == 'cost') {
                $solusiIdealPositif[$kriteria_id] = min($nilaiKriteria);
            }
        }

        return $solusiIdealPositif;
    }
    public function calculateSolusiIdealNegatif($matriksTerbobot, $kriteriaTypes)
    {
        // Inisialisasi array untuk menyimpan solusi ideal negatif
        $solusiIdealNegatif = [];

        // Iterasi setiap kriteria
        foreach ($kriteriaTypes as $kriteria_id => $type) {
            $nilaiKriteria = [];

            // Ambil semua nilai terbobot untuk kriteria ini
            foreach ($matriksTerbobot as $pelanggan) {
                $nilaiKriteria[] = $pelanggan['kriteria'][$kriteria_id]['nilai_terbobot'];
            }

            // Jika tipe kriteria adalah 'benefit', ambil nilai minimum
            if ($type == 'benefit') {
                $solusiIdealNegatif[$kriteria_id] = min($nilaiKriteria);
            }
            // Jika tipe kriteria adalah 'cost', ambil nilai maksimum
            else if ($type == 'cost') {
                $solusiIdealNegatif[$kriteria_id] = max($nilaiKriteria);
            }
        }

        return $solusiIdealNegatif;
    }
    public function calculateJarakSolusi($matriksTerbobot, $solusiIdealPositif, $solusiIdealNegatif)
    {
        // Inisialisasi array untuk menyimpan jarak solusi
        $jarakSolusi = [];

        // Iterasi melalui setiap alternatif (pelanggan)
        foreach ($matriksTerbobot as $pelanggan_id => $pelanggan) {
            $sumPositif = 0; // Untuk menyimpan penjumlahan kuadrat selisih ke solusi ideal positif
            $sumNegatif = 0; // Untuk menyimpan penjumlahan kuadrat selisih ke solusi ideal negatif

            // Iterasi setiap kriteria
            foreach ($pelanggan['kriteria'] as $kriteria_id => $kriteria) {
                // Ambil nilai terbobot
                $nilaiTerbobot = $kriteria['nilai_terbobot'];

                // Hitung selisih kuadrat dengan solusi ideal positif
                $sumPositif += pow($nilaiTerbobot - $solusiIdealPositif[$kriteria_id], 2);

                // Hitung selisih kuadrat dengan solusi ideal negatif
                $sumNegatif += pow($nilaiTerbobot - $solusiIdealNegatif[$kriteria_id], 2);
            }

            // Hitung akar kuadrat dari penjumlahan kuadrat selisih
            $jarakSolusi[$pelanggan_id] = [
                'jarakPositif' => sqrt($sumPositif),
                'jarakNegatif' => sqrt($sumNegatif),
            ];
        }

        return $jarakSolusi;
    }
    public function calculatePreferensi($jarakSolusi)
    {
        $nilaiPreferensi = [];

        foreach ($jarakSolusi as $pelanggan_id => $jarak) {
            $jarakPositif = $jarak['jarakPositif'];
            $jarakNegatif = $jarak['jarakNegatif'];

            // Hitung nilai preferensi (V)
            $nilaiPreferensi[$pelanggan_id] = $jarakNegatif / ($jarakPositif + $jarakNegatif);
        }

        return $nilaiPreferensi;
    }

    public function dataHasil()
    {
        $penilaianData = $this->getPenialaianList();
        $pembagi = $this->calculatePembagi($penilaianData, count($this->kriteriaPenilaian));
        $matriksTernormalisasi = $this->calculateMatriksTernormalisasi($penilaianData, $pembagi);
        $matriksTerbobot = $this->calculateMatriksTerbobot($matriksTernormalisasi, $this->bobot);
        $solusiIdealPositif = $this->calculateSolusiIdealPositif($matriksTerbobot, $this->kriteriaTypes);
        $solusiIdealNegatif = $this->calculateSolusiIdealNegatif($matriksTerbobot, $this->kriteriaTypes);
        $calculateJarakSolusi = $this->calculateJarakSolusi($matriksTerbobot, $solusiIdealPositif, $solusiIdealNegatif);
        $nilaiPreferensi = $this->calculatePreferensi($calculateJarakSolusi);

        $nilaiPreferensiDenganNama = [];
        foreach ($nilaiPreferensi as $umkmId => $nilai) {
            $umkm = Umkm::find($umkmId); // Ambil data UMKM dari model
            $nilaiPreferensiDenganNama[] = [
                'umkm_id' => $umkmId,
                'nama_umkm' => $umkm->nama ?? 'Tidak Diketahui',
                'nilai_preferensi' => $nilai
            ];
        }

        foreach ($penilaianData as $key => $data) {
            // Query untuk mendapatkan data UMKM berdasarkan umkm_id
            $umkm = Umkm::find($data['umkm_id']);

            // Tambahkan data UMKM ke array
            if ($umkm) {
                $penilaianData[$key]['umkm_nama'] = $umkm->nama;
            }
        }

        // Loop melalui penilaianData untuk menambahkan kode kriteria
        foreach ($penilaianData as &$umkmData) {
            foreach ($umkmData['kriteria'] as $kriteria_id => &$kriteriaData) {
                // Query untuk mendapatkan kode kriteria berdasarkan kriteria_id
                $kriteria = Kriteria::find($kriteriaData['kriteria_id']);

                // Jika kriteria ditemukan, tambahkan kode_kriteria ke dalam array
                if ($kriteria) {
                    $kriteriaData['kode_kriteria'] = $kriteria->kode;
                }
            }
        }

        // Loop melalui array pembagi dan tambahkan kode kriteria
        foreach ($pembagi as $kriteria_id => $nilai_pembagi) {
            // Query untuk mendapatkan kode kriteria berdasarkan kriteria_id
            $kriteria = Kriteria::find($kriteria_id);

            // Tambahkan kode kriteria ke array jika kriteria ditemukan
            if ($kriteria) {
                $pembagi[$kriteria_id] = [
                    'nilai_pembagi' => $nilai_pembagi,
                    'kode_kriteria' => $kriteria->kode,
                ];
            }
        }

        // Loop melalui array matriksTernormalisasi dan tambahkan nama UMKM serta kode kriteria
        foreach ($matriksTernormalisasi as $umkm_key => $data) {
            // Query untuk mendapatkan nama UMKM berdasarkan umkm_id
            $umkm = Umkm::find($data['umkm_id']);

            // Tambahkan nama UMKM jika ditemukan
            if ($umkm) {
                $matriksTernormalisasi[$umkm_key]['nama_umkm'] = $umkm->nama;
            }

            // Loop melalui kriteria untuk mendapatkan kode kriteria
            foreach ($data['kriteria'] as $kriteria_key => $kriteria_data) {
                $kriteria = Kriteria::find($kriteria_data['kriteria_id']);

                // Tambahkan kode kriteria jika ditemukan
                if ($kriteria) {
                    $matriksTernormalisasi[$umkm_key]['kriteria'][$kriteria_key]['kode_kriteria'] = $kriteria->kode;
                }
            }
        }

        // Loop melalui array matriksTerbobot dan tambahkan nama UMKM serta kode kriteria
        foreach ($matriksTerbobot as $umkm_key => $data) {
            // Query untuk mendapatkan nama UMKM berdasarkan umkm_id
            $umkm = Umkm::find($data['umkm_id']);

            // Tambahkan nama UMKM jika ditemukan
            if ($umkm) {
                $matriksTerbobot[$umkm_key]['nama_umkm'] = $umkm->nama;
            }

            // Loop melalui kriteria untuk mendapatkan kode kriteria
            foreach ($data['kriteria'] as $kriteria_key => $kriteria_data) {
                $kriteria = Kriteria::find($kriteria_data['kriteria_id']);

                // Tambahkan kode kriteria jika ditemukan
                if ($kriteria) {
                    $matriksTerbobot[$umkm_key]['kriteria'][$kriteria_key]['kode_kriteria'] = $kriteria->kode;
                }
            }
        }

        // Loop melalui solusiIdealPositif dan tambahkan kode kriteria
        foreach ($solusiIdealPositif as $kriteria_id => $nilai) {
            // Query untuk mendapatkan kode kriteria berdasarkan kriteria_id
            $kriteria = Kriteria::find($kriteria_id);

            // Tambahkan kode kriteria ke dalam array jika ditemukan
            if ($kriteria) {
                $solusiIdealPositif[$kriteria_id] = [
                    'nilai' => $nilai,
                    'kode_kriteria' => $kriteria->kode
                ];
            }
        }

        // Loop melalui solusiIdealNegatif dan tambahkan kode kriteria
        foreach ($solusiIdealNegatif as $kriteria_id => $nilai) {
            // Query untuk mendapatkan kode kriteria berdasarkan kriteria_id
            $kriteria = Kriteria::find($kriteria_id);

            // Tambahkan kode kriteria ke dalam array jika ditemukan
            if ($kriteria) {
                $solusiIdealNegatif[$kriteria_id] = [
                    'nilai' => $nilai,
                    'kode_kriteria' => $kriteria->kode
                ];
            }
        }

        // Loop melalui calculateJarakSolusi dan tambahkan nama UMKM
        foreach ($calculateJarakSolusi as $umkm_id => $jarak) {
            // Query untuk mendapatkan nama UMKM berdasarkan umkm_id
            $umkm = Umkm::find($umkm_id);

            // Tambahkan nama UMKM ke dalam array jika ditemukan
            if ($umkm) {
                $calculateJarakSolusi[$umkm_id]['nama_umkm'] = $umkm->nama;
            }
        }

        // Sortir array berdasarkan nilai_preferensi dalam urutan menurun
        usort($nilaiPreferensiDenganNama, function ($a, $b) {
            return $b['nilai_preferensi'] <=> $a['nilai_preferensi'];
        });

        // Tambahkan ranking
        foreach ($nilaiPreferensiDenganNama as $index => &$item) {
            $item['ranking'] = $index + 1; // Ranking dimulai dari 1
        }

        // Ensure UTF-8 encoding for all strings in arrays
        array_walk_recursive($penilaianData, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($pembagi, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($matriksTernormalisasi, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($matriksTerbobot, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($solusiIdealPositif, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($solusiIdealNegatif, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($calculateJarakSolusi, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($nilaiPreferensiDenganNama, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });

        return [
            'penilaianData' => $penilaianData,
            'pembagi' => $pembagi,
            'matriksTernormalisasi' => $matriksTernormalisasi,
            'matriksTerbobot' => $matriksTerbobot,
            'solusiIdealPositif' => $solusiIdealPositif,
            'solusiIdealNegatif' => $solusiIdealNegatif,
            'calculateJarakSolusi' => $calculateJarakSolusi,
            'nilaiPreferensiDenganNama' => $nilaiPreferensiDenganNama,
        ];
    }

    public function storeData()
    {
        $data = $this->dataHasil();
        Penilaiandb::create([
            'periode' => $this->tgl_penilaian,
            'data' => json_encode($data),
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Data berhasil disimpan');
    }

    public function render()
    {
        return view('livewire.penilaian');
    }
}
