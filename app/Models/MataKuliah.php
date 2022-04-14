<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;
    protected $table='matakuliah';//Eloquent akan membuat model mahasiswa untuk menyimpan record
    
    public function mahasiswa_matakuliah(){
        return $this->hasMany(Mahasiswa_MataKuliah::class);
    }
}
