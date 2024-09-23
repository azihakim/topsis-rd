<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\User;
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
        // dd($request->all());
        $user = auth()->user()->id;
        Umkm::create([
            'user_id' => $user,
            'nama' => $request->nama,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'legalitas' => $request->legalitas,
            'nama_produk' => $request->nama_produk,
            'jenis_usaha' => $request->jenis_usaha,
            'perizinan_usaha' => $request->perizinan_usaha,
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
}
