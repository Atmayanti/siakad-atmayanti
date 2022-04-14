<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mahasiswa = [
            [
                'nim' => '2041720016',	
                'nama' => 'Atmayanti',
                'jurusan' => 'Teknologi Informasi',
                'jenis_kelamin' => 'Perempuan',	
                'email' => 'mayablue74@gmail.com',	
                'alamat' => 'Jalan Jalan jauh',
                'tanggal_lahir' => '2001-11-14', 
            ],
            [
                'nim' => '2041720061',	
                'nama' => 'Cici Rania',
                'jurusan' => 'Teknologi Informasi',
                'jenis_kelamin' => 'Perempuan',	
                'email' => 'cicicici74@gmail.com',	
                'alamat' => 'Jalan Jalan dekat',
                'tanggal_lahir' => '2001-11-14', 
            ],
            [
                'nim' => '2041720116',	
                'nama' => 'Budi Budi',
                'jurusan' => 'Teknologi Informasi',
                'jenis_kelamin' => 'Laki-Laki',	
                'email' => 'mayablue74@gmail.com',	
                'alamat' => 'Jalan Jalan jauh',
                'tanggal_lahir' => '2001-11-14', 
            ],
            [
                'nim' => '2041720216',	
                'nama' => 'Salto Salto',
                'jurusan' => 'Teknologi Informasi',
                'jenis_kelamin' => 'Laki-Laki',	
                'email' => 'mayablue74@gmail.com',	
                'alamat' => 'Jalan Jalan jauh',
                'tanggal_lahir' => '2001-11-14', 
            ],
        ];
        DB::table('mahasiswa')->insert($mahasiswa);
    }
}
