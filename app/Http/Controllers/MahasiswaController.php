<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $user = Auth::user();
        $mahasiswa = Mahasiswa::paginate(5);
        return view('mahasiswas.index', compact('mahasiswa'))
        ->with('i', (request()->input('page', 1) -1) *5);

        // //fungsi eloquent menampilkan data menggunakan pagination
        // $mahasiswas = Mahasiswa::all(); // Mengambil semua isi tabel
        // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        // return view('mahasiswas.index', compact('mahasiswas'))
        // ->with('i', (request()->input('page', 1) - 1) * 5);

        // menampilkan 5 data teratas sesuai dengan desc
        if($request->has('search')){
            $mahasiswas = Mahasiswa::where('Nim', 'LIKE', '%' . request('search') . '%')
                ->orWhere('Nama', 'LIKE', '%' . request('search') . '%')
                ->orWhere('Kelas', 'LIKE', '%' . request('search') . '%')
                ->orWhere('Jurusan', 'LIKE', '%' . request('search') . '%')
                ->orWhere('No_Handphone', 'LIKE', '%' . request('search') . '%')
                ->orWhere('Email', 'LIKE', '%' . request('search') . '%')
                ->orWhere('Tanggal_Lahir', 'LIKE', '%' . request('search') . '%')
                ->paginate(5);
    
            return view('mahasiswas.index', ['mahasiswas' => $mahasiswas]);
        }else{
            $mahasiswas = Mahasiswa::orderBy('Nim', 'desc')->paginate(5);
            return view('mahasiswas.index', compact('mahasiswas'))->with('i', (request()->input('page', 1) - 1) * 5);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswas.create', ['kelas' =>$kelas]);
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
            'kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
            ]);

            if ($request->file('image')) {
                $image_name = $request->file('image')->store('mahasiswa', 'public');
            }

            //fungsi eloquent untuk menambah data
            // Mahasiswa::create($request->all());
            $mahasiswa = new Mahasiswa;
            $mahasiswa->Nim=$request ->get('Nim');
            $mahasiswa->Nama=$request ->get('Nama');
            $mahasiswa->Foto =$image_name;
            $mahasiswa->Jurusan=$request ->get('Jurusan');
            $mahasiswa->No_Handphone=$request ->get('No_Handphone');
            $mahasiswa->Email=$request ->get('Email');
            $mahasiswa->Tanggal_Lahir=$request ->get('Tanggal_Lahir');
            // $mahasiswa->save();

            //fungsi eloquent untuk menambah data dengan relasi belongs to
            $kelas = new Kelas;
            $kelas->id=$request->get('kelas');

            $mahasiswa->kelas()->associate($kelas);
            $mahasiswa->save();

            //jika data berhasil ditambahkan, akan kembali ke halaman utama
            return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::find($Nim);
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
            'Tanggal_Lahir' => 'required',
            ]);

            // //fungsi eloquent untuk mengupdate data inputan kita
            // Mahasiswa::find($Nim)->update($request->all());

            // //jika data berhasil diupdate, akan kembali ke halaman utama
            // return redirect()->route('mahasiswas.index')
            // ->with('success', 'Mahasiswa Berhasil Diupdate');

            $Mahasiswas = Mahasiswa::with('kelas')->where('Nim',$Nim)->first();
        
            if ($Mahasiswas->Foto && file_exists(storage_path('app/public/' . $Mahasiswas->Foto))) {
            Storage::delete('public/' . $Mahasiswas->Foto);  
            }

            $image_name = $request->file('image')->store('mahasiswa', 'public');

            //Fungsi eloquent untuk tambah data
        $mahasiswas=Mahasiswa::with('kelas')->where('Nim',$Nim)->first();
        $mahasiswas->Nim=$request->get('Nim');
        $mahasiswas->Nama=$request->get('Nama');
        $mahasiswas->Foto =$image_name;
        $mahasiswas->Jurusan=$request->get('Jurusan');
        $mahasiswas->No_Handphone=$request->get('No_Handphone');
        $mahasiswas->Email=$request->get('Email');
        $mahasiswas->Tanggal_Lahir=$request->get('Tanggal_Lahir');
        $mahasiswas->save();

        //Unutk menambahkan dengan relasi belongs to
        $kelas = new Kelas;
        $kelas->id = $request->get('kelas');

        $mahasiswas->kelas()->associate($kelas);
        $mahasiswas->save();

        //jika data berhasil
        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $Nim
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        // fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function nilai($Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswas.nilai', compact('Mahasiswa'));
    }

    public function cetak_khs($Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim);
        $cetak_khs = PDF::loadView('mahasiswas.khs_pdf', ['Mahasiswa' => $Mahasiswa]);
        return $cetak_khs->stream();
    }
}
