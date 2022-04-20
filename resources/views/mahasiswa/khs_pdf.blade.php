@extends('mahasiswa.layout')

@section('content')
<div class="container mt-3">
    <div class="text-center">
        <h4>JURUSAN TEKNOLOGI INFORMASI POLITEKNIK NEGERI MALANG</h4>
    </div>
    <h2 class="text-center mt-4 mb-5">KARTU HASIL STUDI (KHS)</h2>
    <strong>Nama&nbsp;: </strong> {{$khs->mahasiswa->nama}}<br>
    <strong>NIM&nbsp;&nbsp;&nbsp;: </strong> {{$khs->mahasiswa->nim}}<br>
    <strong>Kelas&nbsp;&nbsp;: </strong> {{$khs->mahasiswa->kelas->nama_kelas}}<br><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach($khs as $mk)
            <tr>
                <td>{{$mk->matakuliah->nama_matkul}}</td>
                <td>{{$mk->matakuliah->sks}}</td>
                <td>{{$mk->matakuliah->semester}}</td>
                <td>{{$mk->nilai}}</td>
                
            </tr>-
            @endforeach
        </tbody>
    </table>
</div>
@endsection