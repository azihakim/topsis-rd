<?php

namespace App\Livewire;

use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\PenilaianDb;
use App\Models\SubKriteria;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class Penilaian extends Component
{
    public $karyawans;
    public $id_karyawan = [];
    public $nama_karyawan = [];
    public $divisi_karyawan = [];
    public $sub_kriteria = [];
    public $tgl_penilaian = 'p';
    public $bobot = [];
    public $data_penilaian;
    public $periode;
    // public $ket_kehadiran = 'Benefit';
    // public $ket_kinerja = 'Benefit';
    // public $ket_tanggung_jawab = 'Benefit';
    // public $ket_sikap = 'Benefit';



    public function mount()
    {
        $this->karyawans = Karyawan::all();
        $this->sub_kriteria = SubKriteria::all();

        foreach ($this->karyawans as $karyawan) {
            $this->id_karyawan[$karyawan->id] = $karyawan->id;
            $this->nama_karyawan[$karyawan->id] = $karyawan->nama;
            $this->divisi_karyawan[$karyawan->id] = $karyawan->divisi;
        }
    }

    public function render()
    {
        return view('livewire.penilaian');
    }

    public function calculateMultiplication($karyawanId, $subKriteriaId, $namaSubKriteria, $bobot)
    {
        sleep(0.5);
        // Ambil nilai dari input
        if (isset($this->bobot[$karyawanId][$subKriteriaId])) {
            $nilai = $this->bobot[$karyawanId][$subKriteriaId];
        } else {
            $nilai = 0;
        }
        // Inisialisasi $hasilPerkalian dengan nilai default
        $hasilPerkalian = 0;

        // Tentukan faktor perkalian berdasarkan nama sub kriteria
        if ($namaSubKriteria === 'Tepat Waktu') {
            if ($nilai > 20) {
                $this->addError('bobot.' . $karyawanId . '.' . $subKriteriaId, 'Penilaian harus tidak melebihi ' . $bobot . '.');
            } else {
                $hasilPerkalian = ($nilai * 0.015) * 100;
                $hasilPerkalian = intval($hasilPerkalian);
                $this->resetErrorBag('bobot.' . $karyawanId . '.' . $subKriteriaId);
            }
        } elseif ($namaSubKriteria === 'Total Jam Kerja') {
            if ($nilai > 150) {
                $this->addError('bobot.' . $karyawanId . '.' . $subKriteriaId, 'Penilaian harus tidak melebihi ' . $bobot . '.');
            } else {
                $hasilPerkalian = ($nilai * 0.00267) * 100;
                $hasilPerkalian = intval($hasilPerkalian);
                $this->resetErrorBag('bobot.' . $karyawanId . '.' . $subKriteriaId);
            }
        } elseif ($namaSubKriteria === 'Izin Kerja') {
            if ($nilai > 20) {
                $this->addError('bobot.' . $karyawanId . '.' . $subKriteriaId, 'Penilaian harus tidak melebihi ' . $bobot . '.');
            } else {
                $hasilPerkalian = ((20 - $nilai) * 0.015) * 100;
                $hasilPerkalian = intval($hasilPerkalian);
                $this->resetErrorBag('bobot.' . $karyawanId . '.' . $subKriteriaId);
            }
        } else {
            if ($nilai > $bobot) {
                $this->addError('bobot.' . $karyawanId . '.' . $subKriteriaId, 'Penilaian harus tidak melebihi ' . $bobot . '.');
            } else {
                $hasilPerkalian = $nilai * 1;
                $hasilPerkalian = intval($hasilPerkalian);
                $this->resetErrorBag('bobot.' . $karyawanId . '.' . $subKriteriaId);
            }
        }

        // Simpan hasil perkalian (misalnya ke dalam array atau model sesuai kebutuhan)
        $this->bobot[$karyawanId][$subKriteriaId] = $hasilPerkalian;
    }





    public function validateForm()
    {
        $isValid = true;

        foreach ($this->karyawans as $karyawan) {
            foreach ($this->sub_kriteria as $subKriteria) {
                $karyawanId = $karyawan->id;
                $subKriteriaId = $subKriteria->id;
                $namaSubKriteria = $subKriteria->nama_sub_kriteria;

                // Check if the specific sub kriteria needs validation

                // Check if the required field is empty or null
                if (!isset($this->bobot[$karyawanId][$subKriteriaId]) || $this->bobot[$karyawanId][$subKriteriaId] === null || $this->bobot[$karyawanId][$subKriteriaId] === 0) {
                    $this->addError('bobot.' . $karyawanId . '.' . $subKriteriaId, $namaSubKriteria . ' harus diisi.');
                    $isValid = false; // Set flag to false if there are validation errors
                } elseif ($this->bobot[$karyawanId][$subKriteriaId] < 0) {
                    $this->addError('bobot.' . $karyawanId . '.' . $subKriteriaId, $namaSubKriteria . ' tidak boleh bernilai negatif.');
                    $isValid = false; // Set flag to false if there are validation errors
                } else {
                    $isValid = true;
                }
            }
        }
        foreach ($this->karyawans as $karyawan) {
            foreach ($this->sub_kriteria as $item) {
                // Lakukan perhitungan seperti yang ada di calculateMultiplication
                // Ambil nilai dari input
                if (isset($this->bobot[$karyawan->id][$item->id])) {
                    $nilai = $this->bobot[$karyawan->id][$item->id];
                } else {
                    $nilai = 0;
                }

                // Inisialisasi $hasilPerkalian dengan nilai default
                $hasilPerkalian = 0;

                // Tentukan faktor perkalian berdasarkan nama sub kriteria
                if ($item->nama_sub_kriteria === 'Tepat Waktu') {
                    if ($nilai > 20) {
                        $this->addError('bobot.' . $karyawan->id . '.' . $item->id, 'Penilaian harus tidak melebihi ' . $item->bobot . '.');
                        $isValid = false;
                    } else {
                        $hasilPerkalian = $nilai;
                    }
                } elseif ($item->nama_sub_kriteria === 'Total Jam Kerja') {
                    if ($nilai > 150) {
                        $this->addError('bobot.' . $karyawan->id . '.' . $item->id, 'Penilaian harus tidak melebihi ' . $item->bobot . '.');
                        $isValid = false;
                    } else {
                        $hasilPerkalian = $nilai;
                    }
                } elseif ($item->nama_sub_kriteria === 'Izin Kerja') {
                    if ($nilai > 20) {
                        $this->addError('bobot.' . $karyawan->id . '.' . $item->id, 'Penilaian harus tidak melebihi ' . $item->bobot . '.');
                        $isValid = false;
                    } else {
                        $hasilPerkalian = $nilai;
                    }
                } else {
                    if ($nilai > $item->bobot) {
                        $this->addError('bobot.' . $karyawan->id . '.' . $item->id, 'Penilaian harus tidak melebihi ' . $item->bobot . '.');
                        $isValid = false;
                    } else {
                        $hasilPerkalian = $nilai;
                    }
                }

                // Simpan hasil perkalian (misalnya ke dalam array atau model sesuai kebutuhan)
                $this->bobot[$karyawan->id][$item->id] = $hasilPerkalian;
            }
        }

        return $isValid;
    }

    public function simpan()
    {
        if (!$this->validateForm()) {
            // Jika validasi gagal, kembalikan atau lakukan tindakan yang sesuai
            return redirect()->back()->with('error', 'Ada kesalahan validasi. Silakan lengkapi semua input yang diperlukan.');
        }
        // Lakukan iterasi untuk setiap karyawan
        foreach ($this->karyawans as $karyawan) {
            foreach ($this->sub_kriteria as $item) {
                // Lakukan perhitungan seperti yang ada di calculateMultiplication
                // Ambil nilai dari input
                if (isset($this->bobot[$karyawan->id][$item->id])) {
                    $nilai = $this->bobot[$karyawan->id][$item->id];
                } else {
                    $nilai = 0;
                }

                // Inisialisasi $hasilPerkalian dengan nilai default
                $hasilPerkalian = 0;

                // Tentukan faktor perkalian berdasarkan nama sub kriteria
                if ($item->nama_sub_kriteria === 'Tepat Waktu') {
                    if ($nilai > 20) {
                        $this->addError('bobot.' . $karyawan->id . '.' . $item->id, 'Penilaian harus tidak melebihi ' . $item->bobot . '.');
                    } else {
                        $hasilPerkalian = ($nilai * 0.015) * 100;
                        $hasilPerkalian = intval($hasilPerkalian);
                        $this->resetErrorBag('bobot.' . $karyawan->id . '.' . $item->id);
                    }
                } elseif ($item->nama_sub_kriteria === 'Total Jam Kerja') {
                    if ($nilai > 150) {
                        $this->addError('bobot.' . $karyawan->id . '.' . $item->id, 'Penilaian harus tidak melebihi ' . $item->bobot . '.');
                    } else {
                        $hasilPerkalian = ($nilai * 0.00267) * 100;
                        $hasilPerkalian = intval($hasilPerkalian);
                        $this->resetErrorBag('bobot.' . $karyawan->id . '.' . $item->id);
                    }
                } elseif ($item->nama_sub_kriteria === 'Izin Kerja') {
                    if ($nilai > 20) {
                        $this->addError('bobot.' . $karyawan->id . '.' . $item->id, 'Penilaian harus tidak melebihi ' . $item->bobot . '.');
                    } else {
                        $hasilPerkalian = ((20 - $nilai) * 0.015) * 100;
                        $hasilPerkalian = intval($hasilPerkalian);
                        $this->resetErrorBag('bobot.' . $karyawan->id . '.' . $item->id);
                    }
                } else {
                    if ($nilai > $item->bobot) {
                        $this->addError('bobot.' . $karyawan->id . '.' . $item->id, 'Penilaian harus tidak melebihi ' . $item->bobot . '.');
                    } else {
                        $hasilPerkalian = $nilai * 1;
                        $hasilPerkalian = intval($hasilPerkalian);
                        $this->resetErrorBag('bobot.' . $karyawan->id . '.' . $item->id);
                    }
                }

                // Simpan hasil perkalian (misalnya ke dalam array atau model sesuai kebutuhan)
                $this->bobot[$karyawan->id][$item->id] = $hasilPerkalian;
            }
        }

        // Setelah melakukan perhitungan, simpan data ke dalam database atau lakukan tindakan lainnya
        // Contoh penyimpanan ke database:


        $semuaPenilaian = [];
        $semuaData = [];
        $kriteria_totals = [];
        $kriteria_sqrt = [];

        foreach ($this->karyawans as $sub) {
            $penilaian = new PenilaianDb();
            $penilaian->karyawan_id = $sub->id;
            $penilaian->tgl_penilaian = $this->tgl_penilaian;
            $bobotArray = [];

            foreach ($this->bobot[$sub->id] as $subKriteriaId => $bobot) {
                $subKriteria = SubKriteria::find($subKriteriaId);
                $namaKriteria = $subKriteria->kriteria->nama_kriteria;
                $namaSubKriteria = $subKriteria->nama_sub_kriteria;

                if (!isset($bobotArray[$namaKriteria])) {
                    $bobotArray[$namaKriteria] = [];
                }

                if (!isset($bobotArray[$namaKriteria]['bobot_kriteria'])) {
                    $bobotArray[$namaKriteria]['bobot_kriteria'] = $subKriteria->kriteria->bobot;
                }

                $bobotArray[$namaKriteria][$namaSubKriteria] = $bobot;
            }

            foreach ($bobotArray as $kriteria => $subKriteria) {
                $total = 0; // Set total awal ke 0
                foreach ($subKriteria as $namaSubKriteria => $bobot) {
                    if ($namaSubKriteria !== 'bobot_kriteria') {
                        $total += $bobot;
                    }
                }
                $bobotArray[$kriteria]['total'] = $total;

                if (!isset($kriteria_totals[$kriteria])) {
                    $kriteria_totals[$kriteria] = 0;
                }
                $kriteria_totals[$kriteria] += pow($total, 2);
            }

            $penilaian->data = json_encode(['bobot' => $bobotArray]);
            array_push($semuaPenilaian, $penilaian);
        }
        // dd($penilaian);

        foreach ($semuaPenilaian as $penilaian) {
            $data = json_decode($penilaian->data, true);
            array_push($semuaData, $data);
        }
        // Menghitung akar kuadrat untuk setiap kriteria
        foreach ($kriteria_totals as $kriteria => $total) {
            $kriteria_sqrt[$kriteria] = sqrt($total);
        }


        // dd($semuaData);
        $data_r = $semuaData;
        foreach ($data_r as &$item) {
            foreach ($item['bobot'] as $kriteria => $nilai) {
                $item['bobot'][$kriteria]['total'] = $nilai['total'] / $kriteria_sqrt[$kriteria];
            }
        }
        // dd($data_r);

        $data_y = $data_r;
        // dd($data_y);
        // Normalisasi bobot
        foreach ($data_y as &$item) {
            foreach ($item['bobot'] as $kriteria => &$nilai) {
                $nilai['total'] *= $nilai['bobot_kriteria'];
            }
        }

        // dd($data_y);

        $data_ap = $data_y;
        // dd($data_ap);
        foreach ($data_ap as &$item) {
            // Mengumpulkan total nilai kriteria
            foreach ($kriteria_totals as $kriteria => &$totals) {
                if (isset($item['bobot'][$kriteria]['total'])) {
                    // Pastikan $totals adalah array sebelum menambahkan nilai
                    if (!is_array($totals)) {
                        $totals = [];
                    }
                    $totals[] = $item['bobot'][$kriteria]['total'];
                }
            }
        }
        // dd($kriteria_totals);
        // foreach ($kriteria_totals as $kriteria => &$totals) {
        //     if ($this->ket_kehadiran == 'Benefit') {
        //         $data_ap[$kriteria] = max(($totals));
        //     } else {
        //         $data_ap[$kriteria] = min(($totals));
        //     }
        // }
        // $data_ap = [];

        foreach ($kriteria_totals as $kriteria => &$totals) {
            // Dapatkan data kriteria dari database berdasarkan nama kriteria
            $data_kriteria = Kriteria::where('nama_kriteria', $kriteria)->first();

            // Tentukan keterangan kriteria berdasarkan data dari database
            if ($data_kriteria) {
                if ($data_kriteria->keterangan == 'Benefit') {
                    // Lakukan operasi untuk kriteria benefit
                    $data_ap[$kriteria] = max($totals);
                } elseif ($data_kriteria->keterangan == 'Cost') {
                    // Lakukan operasi untuk kriteria cost
                    $data_ap[$kriteria] = min($totals);
                } else {
                    // Jika keterangan tidak valid, atur default
                    $data_ap[$kriteria] = 'Keterangan tidak valid';
                }
            } else {
                // Jika data kriteria tidak ditemukan, atur default
                $data_ap[$kriteria] = 'Data kriteria tidak ditemukan';
            }
        }
        // dd($data_ap);

        // $data_am = [];
        // foreach ($kriteria_totals as $kriteria => &$totals) {
        //     if ($this->ket_kehadiran == 'Cost') {
        //         $data_am[$kriteria] = max(($totals));
        //     } else {
        //         $data_am[$kriteria] = min(($totals));
        //     }
        // }

        $data_am = [];

        foreach ($kriteria_totals as $kriteria => &$totals) {
            // Dapatkan data kriteria dari database berdasarkan nama kriteria
            $data_kriteria = Kriteria::where('nama_kriteria', $kriteria)->first();

            // Tentukan keterangan kriteria berdasarkan data dari database
            if ($data_kriteria) {
                if ($data_kriteria->keterangan == 'Cost') {
                    // Lakukan operasi untuk kriteria cost
                    $data_am[$kriteria] = max($totals);
                } elseif ($data_kriteria->keterangan == 'Benefit') {
                    // Lakukan operasi untuk kriteria benefit
                    $data_am[$kriteria] = min($totals);
                } else {
                    // Jika keterangan tidak valid, atur default
                    $data_am[$kriteria] = 'Keterangan tidak valid';
                }
            } else {
                // Jika data kriteria tidak ditemukan, atur default
                $data_am[$kriteria] = 'Data kriteria tidak ditemukan';
            }
        }
        // dd($data_am);


        // Mengambil semua karyawan
        foreach ($this->karyawans as $karyawan) {
            $nama_karyawan[] = $karyawan->nama; // Menambahkan nama karyawan ke dalam array
        }

        $data_dp = $data_y;

        foreach ($this->karyawans as $karyawan['id'] => $karyawan) {
            foreach ($data_dp as &$item) {
                $total_kuadrat = 0;
                foreach ($item['bobot'] as $kriteria => $detail_kriteria) {
                    $total_kuadrat += pow($data_ap[$kriteria] - $detail_kriteria['total'], 2);
                }
                $item['total_kuadrat'] = sqrt($total_kuadrat);
            }
        }
        // dd($data_dp);


        $data_dm = $data_y;

        foreach ($this->karyawans as $karyawan['id'] => $karyawan) {
            foreach ($data_dm as &$item) {
                $total_kuadrat = 0;
                foreach ($item['bobot'] as $kriteria => $detail_kriteria) {
                    $total_kuadrat += pow($data_am[$kriteria] - $detail_kriteria['total'], 2);
                }
                $item['total_kuadrat'] = sqrt($total_kuadrat);
            }
        }


        $data_v = [];

        // Hitung nilai data_v untuk setiap karyawan
        $total_kuadrat_dp = array_column($data_dp, 'total_kuadrat');
        $total_kuadrat_dm = array_column($data_dm, 'total_kuadrat');

        foreach ($this->karyawans as $index => &$karyawan) {
            $total_dp = $total_kuadrat_dp[$index];
            $total_dm = $total_kuadrat_dm[$index];
            $data_v[] = [
                'index' => $index,
                'value' => ($total_dm + $total_dp != 0) ? $total_dm / ($total_dm + $total_dp) : 0
            ];
        }
        // Urutkan array data_v secara descending berdasarkan nilai
        usort($data_v, function ($a, $b) {
            return $b['value'] <=> $a['value'];
        });
        dd('datav', $data_v);
        // Berikan peringkat kepada setiap karyawan
        $hasil_akhir = [];
        foreach ($data_v as $rank => $item) {
            $karyawan_index = $item['index'];
            $karyawan_nama = $nama_karyawan[$karyawan_index];
            $data_penilaian = [
                'nama_karyawan' => $karyawan_nama,
                'data_v' => $item['value'],
                'rank' => $rank + 1
            ];
            $hasil_akhir[] = $data_penilaian;
        }

        // dd($hasil_akhir);

        $semuaPenilaian = [];
        foreach ($hasil_akhir as $hasil) {
            // Cari ID karyawan berdasarkan nama karyawan
            $nama_karyawan = $hasil['nama_karyawan'];
            $karyawan = Karyawan::where('nama', $nama_karyawan)->first();

            // Buat entri baru dalam PenilaianDb jika karyawan ditemukan

            $penilaian = new PenilaianDb();
            $penilaian->periode_penilaian = $this->periode; // Masukkan ID karyawan
            $penilaian->nama_karyawan = $karyawan->nama; // Masukkan ID karyawan
            $penilaian->tgl_penilaian = Carbon::now()->format('Y-m-d');
            $penilaian->data = json_encode($hasil);
            $penilaian->save();

            $semuaPenilaian[] = $penilaian;
        }
        // $this->tgl_penilaian = $penilaian->tgl_penilaian;
        // $this->cetakLaporan($semuaPenilaian);
        return redirect()->route('penilaian.index');
    }





    public function cetakLaporan($semuaPenilaian)
    {
        // Ensure UTF-8 encoding for all strings
        array_walk_recursive($semuaPenilaian, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });

        $penilaian = $semuaPenilaian;
        $content = Pdf::loadView('penilaian.cetakLaporan', compact('penilaian'));

        // Set file name for the downloaded PDF
        $filename = 'Hasil Penilaian ' . $this->tgl_penilaian . '.pdf';

        return response()->streamDownload(
            function () use ($content) {
                echo $content->stream();
            },
            $filename
        );
    }
}
