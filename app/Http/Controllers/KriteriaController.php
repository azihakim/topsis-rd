<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kriteria::all();
        return view('kriteria.kriteria', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('kriteria.addKriteria');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kriteria = new Kriteria;
        $kriteria->nama_kriteria = $request->nama_kriteria;
        $kriteria->bobot = $request->bobot;
        $kriteria->keterangan = 'Benefit';
        $kriteria->save();

        // Hitung total bobot semua kriteria kecuali kriteria yang baru saja ditambahkan
        $totalBobotLain = Kriteria::where('id', '!=', $kriteria->id)->sum('bobot');

        // Total bobot termasuk kriteria baru
        $totalBobotSekarang = $totalBobotLain + $kriteria->bobot;

        // Normalisasi bobot jika total bobot termasuk kriteria baru melebihi 100
        if ($totalBobotSekarang > 100) {
            // Hitung selisih total bobot dengan 100
            $selisih = $totalBobotSekarang - 100;

            // Bagikan selisih kepada kriteria yang sudah ada (kecuali kriteria baru)
            $kriteriaLain = Kriteria::where('id', '!=', $kriteria->id)->get();
            $totalBobotTerbagi = 0;

            foreach ($kriteriaLain as $kriteriaItem) {
                $bobotLama = $kriteriaItem->bobot;
                $bobotBaru = $bobotLama - ($bobotLama / $totalBobotLain) * $selisih;

                // Pastikan bobot baru tidak kurang dari 0.01
                if ($bobotBaru < 0.01) {
                    $bobotBaru = 0.01;
                }

                $kriteriaItem->bobot = $bobotBaru;
                $kriteriaItem->save();
                $totalBobotTerbagi += $bobotBaru;
            }
        }
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kriteria = Kriteria::find($id);
        return view('kriteria.editKriteria', compact('kriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Temukan kriteria yang akan diubah
        $kriteria = Kriteria::find($id);

        if ($kriteria) {
            // Dapatkan bobot lama dari kriteria
            $bobotLama = $kriteria->bobot;

            // Update kriteria dengan data baru
            $kriteria->nama_kriteria = $request->nama_kriteria;
            $kriteria->bobot = $request->bobot;
            $kriteria->keterangan = 'Benefit';
            $kriteria->save();

            // Hitung total bobot semua kriteria kecuali kriteria yang baru saja diubah
            $totalBobotLain = Kriteria::where('id', '!=', $kriteria->id)->sum('bobot');

            // Total bobot termasuk kriteria yang diubah
            $totalBobotSekarang = $totalBobotLain + $kriteria->bobot;

            // Normalisasi bobot jika total bobot termasuk kriteria yang diubah melebihi 100
            if ($totalBobotSekarang > 100) {
                // Hitung selisih total bobot dengan 100
                $selisih = $totalBobotSekarang - 100;

                // Bagikan selisih kepada kriteria yang sudah ada (kecuali kriteria yang diubah)
                $kriteriaLain = Kriteria::where('id', '!=', $kriteria->id)->get();
                foreach ($kriteriaLain as $kriteriaItem) {
                    $bobotLama = $kriteriaItem->bobot;
                    $bobotBaru = $bobotLama - ($bobotLama / $totalBobotLain) * $selisih;

                    // Pastikan bobot baru tidak kurang dari 0.01
                    if ($bobotBaru < 0.01) {
                        $bobotBaru = 0.01;
                    }

                    $kriteriaItem->bobot = $bobotBaru;
                    $kriteriaItem->save();
                }
            } elseif ($totalBobotSekarang < 100) {
                // Jika total bobot kurang dari 100, hitung selisih yang perlu ditambahkan
                $selisih = 100 - $totalBobotSekarang;

                // Bagikan selisih kepada kriteria yang sudah ada (kecuali kriteria yang diubah)
                $kriteriaLain = Kriteria::where('id', '!=', $kriteria->id)->get();
                foreach ($kriteriaLain as $kriteriaItem) {
                    $bobotLama = $kriteriaItem->bobot;
                    $bobotBaru = $bobotLama + ($bobotLama / $totalBobotLain) * $selisih;

                    // Pastikan bobot baru tidak lebih dari 100
                    if ($bobotBaru > 100) {
                        $bobotBaru = 100;
                    }

                    $kriteriaItem->bobot = $bobotBaru;
                    $kriteriaItem->save();
                }
            }

            return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diubah');
        } else {
            return redirect()->route('kriteria.index')->with('error', 'Kriteria tidak ditemukan');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan kriteria yang akan dihapus
        $kriteria = Kriteria::find($id);

        if ($kriteria) {
            // Cek apakah kriteria memiliki relasi dengan tabel subkriteria
            if ($kriteria->subkriteria()->count() > 0) {
                return redirect()->route('kriteria.index')->with('error', 'Kriteria tidak bisa dihapus karena memiliki subkriteria terkait.');
            }

            // Dapatkan bobot dari kriteria yang akan dihapus
            $bobotHapus = $kriteria->bobot;

            // Hapus kriteria dari database
            $kriteria->delete();

            // Hitung total bobot semua kriteria yang tersisa
            $totalBobotSisa = Kriteria::sum('bobot');

            // Normalisasi bobot jika total bobot sisa kurang dari 100
            if ($totalBobotSisa < 100) {
                // Hitung selisih yang perlu ditambahkan
                $selisih = 100 - $totalBobotSisa;

                // Bagikan selisih kepada kriteria yang tersisa
                $kriteriaSisa = Kriteria::all();
                foreach ($kriteriaSisa as $kriteriaItem) {
                    $bobotLama = $kriteriaItem->bobot;
                    $bobotBaru = $bobotLama + ($bobotLama / $totalBobotSisa) * $selisih;

                    // Pastikan bobot baru tidak lebih dari 100
                    if ($bobotBaru > 100) {
                        $bobotBaru = 100;
                    }

                    $kriteriaItem->bobot = $bobotBaru;
                    $kriteriaItem->save();
                }
            }

            return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus');
        } else {
            return redirect()->route('kriteria.index')->with('error', 'Kriteria tidak ditemukan');
        }
    }
}
