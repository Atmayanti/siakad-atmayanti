<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model; //Model Eloquent

class Mahasiswa extends Model
{
    protected $table='mahasiswa';//Eloquent akan membuat model mahasiswa untuk menyimpan record
    protected $primaryKey = 'id_mahasiswa'; // Memanggi; isi DB dengan primarykey

    protected $fillable = [
        'Nim',
        'Nama',
        'Kelas',
        'Jurusan',
        'Jenis_Kelamin',
        'Email',
        'Alamat',
        'Tanggal_Lahir',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }
}
