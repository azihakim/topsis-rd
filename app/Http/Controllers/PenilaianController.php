<?php

namespace App\Http\Controllers;

use App\Models\PenilaianDb;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menyaring data penilaian berdasarkan tanggal
        $penilaian = PenilaianDb::orderBy('periode')->get();

        // Mengembalikan view dengan data yang telah disaring
        return view('penilaian.index', compact('penilaian'));
    }


    public function create()
    {
        return view('penilaian.penilaian');
    }

    public function show($id)
    {
        $penilaian = PenilaianDb::find($id);

        // Decode JSON yang tersimpan dalam kolom `data`
        $data = json_decode($penilaian->data, true);

        // Kirim data ke view
        return view('penilaian.show', compact('data'));
    }
}
