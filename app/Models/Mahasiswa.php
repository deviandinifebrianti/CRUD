<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\Mahasiswa as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kelas;
use App\Models\Mahasiswa_matakuliah;

class Mahasiswa extends Model
{
    //use HasFactory;
    protected $table="mahasiswas"; // Eloquent akan membuat model mahasiswa menyimpan record di tabel mahasiswas
    public $timestamps= false;
    protected $primaryKey = 'Nim'; // Memanggil isi DB Dengan primarykey
    /**
    * The attributes that are mass assignable.
    **
@var array
*/
protected $fillable = [
    'Nim',
    'Nama',
    'Foto',
    // 'Kelas',
    'kelas_id',
    'Jurusan',
    'No_Handphone',
    'Email',
    'Tanggal_Lahir',
    ];

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    }

    public function matakuliah() {
        return $this->belongsToMany(MataKuliah::class, "mahasiswa_matakuliah", "mahasiswa_id", "matakuliah_id")->withPivot('nilai');
    }
}
