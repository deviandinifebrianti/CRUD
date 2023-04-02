<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $data=[[
            'Nim'=>'2141702893',
            'Nama'=> 'Cantika',
            'Kelas'=> '2B',
            'Jurusan'=>'Teknik Informatika',
            'No_Handphone'=>'08193267332',
            'Email'=>'cantik@gmail.com',
            'Tanggal_Lahir'=>'22 Maret 2004'
        ],
        [
            'Nim'=>'214098732',
            'Nama'=> 'Maulana',
            'Kelas'=> '3A',
            'Jurusan'=>'Manajemen Pemasaran',
            'No_Handphone'=>'08213173627',
            'Email'=>'maul@gmail.com',
            'Tanggal_Lahir'=>'7 September 2002'
        ],
        [
            'Nim'=>'2141720189',
            'Nama'=> 'Devi Andini F',
            'Kelas'=> '2G',
            'Jurusan'=>'Teknologi Informasi',
            'No_Handphone'=>'081936791863',
            'Email'=>'dv.andinifebrianti@gmail.com',
            'Tanggal_Lahir'=>'28 Februari 2003'
        ],
        [
            'Nim'=>'2142038342',
            'Nama'=> 'Abdul',
            'Kelas'=> '1G',
            'Jurusan'=>'Kedokteran',
            'No_Handphone'=>'08976282692',
            'Email'=>'abdul@gmail.com',
            'Tanggal_Lahir'=>'22 Maret 2003'
        ]];
        DB::table('mahasiswas')->insert($data);
    }
}