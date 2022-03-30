<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

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
            $mahasiswa = Mahasiswa::all(); //mengambil semua isi tabel
            $paginate=Mahasiswa::orderBy('id_mahasiswa','asc')->paginate(5);
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
        return view('mahasiswa.create');
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

        //fungsi eloquent untuk menambahkan data
        Mahasiswa::create($request->all());

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
        $Mahasiswa=DB::table('mahasiswa')->where('nim', $nim)->first();
        return view('mahasiswa.edit', compact('Mahasiswa'));
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

        //fungsi eloquent untuk mengupdate data inputan
        Mahasiswa::where('nim', $nim)
        ->update([
            'nim'=>$request->Nim,
            'nama'=>$request->Nama,
            'kelas'=>$request->Kelas,
            'jurusan'=>$request->Jurusan,
            'jenis_kelamin'=>$request->Jenis_Kelamin,
            'email'=>$request->Email,
            'alamat'=>$request->Alamat,
            'tanggal_lahir'=>$request->Tanggal_Lahir,
        ]);

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
};
