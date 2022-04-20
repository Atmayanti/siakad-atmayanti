<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Mahasiswa_MataKuliah;
use Illuminate\Support\Facades\Storage;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (request('search')){
            $paginate = Mahasiswa::where('nim', 'like', '%'.request('search').'%')
                                    ->orwhere('nama', 'like', '%'.request('search').'%')
                                    ->orwhere('kelas', 'like', '%'.request('search').'%')
                                    ->orwhere('jurusan', 'like', '%'.request('search').'%')
                                    ->orwhere('jenis_kelamin', 'like', '%'.request('search').'%')
                                    ->orwhere('email', 'like', '%'.request('search').'%')
                                    ->orwhere('alamat', 'like', '%'.request('search').'%')
                                    ->orwhere('tanggal_lahir', 'like', '%'.request('search').'%')
                                    ->paginate(5);
            return view('mahasiswa.index', ['paginate'=>$paginate]);
        } else {
            //fungsi eloquent menampilkan data menggunakan pagination
            $mahasiswa = Mahasiswa::with('kelas')->get(); //mengambil semua isi tabel
            $paginate=Mahasiswa::orderBy('id_mahasiswa','asc')->paginate(3);
            return view('mahasiswa.index',['mahasiswa'=>$mahasiswa,'paginate'=>$paginate]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['kelas'=> $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Jenis_Kelamin' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        if ($request->file('image')) {
            $image_name = $request->file('image')->store('images', 'public');
        } else {
            $image_name = NULL;
        }

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->jenis_kelamin = $request->get('Jenis_Kelamin');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->foto = $image_name;

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika berhasi; ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa=Mahasiswa::where('nim', $nim)->first();
        return view('mahasiswa.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nim)
    {
        //melakukan validasi
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Jenis_Kelamin' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->jenis_kelamin = $request->get('Jenis_Kelamin');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->save();

        if ($mahasiswa->foto && file_exists(storage_path('app/public/'.$mahasiswa->foto))) {
            Storage::delete('public/'.$mahasiswa->foto);
        }
        if ($request->file('image')) {
            $image_name = $request->file('image')->store('images', 'public');
        } else {
            $image_name = NULL;
        }
        $mahasiswa->foto = $image_name;

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::where('nim', $nim)->delete();

        return redirect()->route('mahasiswa.index')
        ->with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function khs($id)
    {

        $khs = Mahasiswa_MataKuliah::where('mahasiswa_id', $id)->with('matakuliah')->get();
        $khs->mahasiswa = Mahasiswa::with('kelas')->where('id_mahasiswa', $id)->first();

        return view('mahasiswa.khs', compact('khs'));
    }
    
    public function cetak_khs($id)
    {
        $khs = Mahasiswa_MataKuliah::where('mahasiswa_id', $id)
            ->with('matakuliah')->get();
        $khs->mahasiswa = Mahasiswa::with('kelas')
            ->where('id_mahasiswa', $id)->first();

        $pdf = PDF::loadview('mahasiswa.khs_pdf', ['khs' => $khs]);
        return $pdf->stream();
    }
};