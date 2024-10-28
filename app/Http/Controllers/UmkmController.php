<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index()
    {
        $data = Umkm::all();
        return view('umkm.index', compact('data'));
    }

    public function dashboard()
    {
        $data = Umkm::where('user_id', auth()->user()->id)->get();
        return view('umkm.dashboard', compact('data'));
    }

    public function regist(Request $request)
    {
        return view('umkm.regist');
    }

    public function addUsaha()
    {
        return view('umkm.addUsaha');
    }

    public function storeUsaha(Request $request)
    {

        // Proses Upload File Proposal
        if ($request->hasFile('proposal')) {
            $namaUsaha = $request->nama;
            $randomNumber = rand(100, 999);
            $filename = "Proposal - {$namaUsaha} - {$randomNumber}." . $request->file('proposal')->getClientOriginalExtension();
            $request->file('proposal')->storeAs('proposals', $filename, 'public');
        } else {
            $filename = null; // Jika tidak ada file yang di-upload
        }


        // Simpan data ke database
        $user = auth()->user()->id;
        $legalitas = $request->nama_legalitas . ' - ' . $request->legalitas;

        Umkm::create([
            'user_id' => $user,
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'legalitas' => $legalitas,
            'nama_produk' => $request->nama_produk,
            'jenis_usaha' => $request->jenis_usaha,
            'proposal' => $filename,
        ]);

        return redirect()->route('umkm.dashboard')->with('success', 'Data berhasil disimpan');
    }


    public function storeRegist(Request $request)
    {
        // dd($request->all());

        User::create([
            'name' => $request->name,
            'username' => $request->email,
            'domisili' => $request->domisili,
            'no_hp' => $request->no_hp,
            'role' => 'umkm',
            'password' => bcrypt($request->no_hp),
        ]);

        return redirect()->route('umkm.index')->with('success', 'Data berhasil disimpan');
    }

    public function dashboardAdmin()
    {
        $data = Umkm::all();
        return view('umkm.dashboardAdmin', compact('data'));
    }

    public function umkmDetail($id)
    {
        $data = Umkm::find($id);
        return view('umkm.detail', compact('data'));
    }

    public function umkmStatus($id, Request $request)
    {
        // dd($request->all());
        $data = Umkm::find($id);
        $data->status = $request->status;
        $data->save();
        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function cetakPendaftaran($id)
    {
        $data = Umkm::with('user')->find($id);
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('cetak.pendaftaran', compact('data'));
        return $pdf->download('hasil_pendaftaran_' . $data->id . '.pdf');
    }
}
