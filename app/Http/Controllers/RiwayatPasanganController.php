<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPasangan;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatPasanganController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_pasangan = RiwayatPasangan::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_pasangan.index',compact('riwayat_pasangan','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_pasangan = $request->get('search');
        $riwayat_pasangan = RiwayatPasangan::where('pegawai_id',$id)->where('nama_pasangan', 'LIKE', '%'.$riwayat_pasangan.'%')->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_pasangan.index',compact('riwayat_pasangan','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
       $pegawai = Pegawai::where('id',$id)->get();
       $pegawai->toArray();
       $view=view('admin.riwayat_pasangan.create',compact('pegawai'));
       $view=$view->render();
       return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
       $this->validate($request, [
           'nama_pasangan' => 'required'
       ]);

       $input['pegawai_id'] = $id;
       $input['nama_pasangan'] = $request->nama_pasangan;
       $input['tempat_lahir'] = $request->tempat_lahir;
       $input['tanggal_lahir'] = $request->tanggal_lahir;
       $input['user_id'] = Auth::user()->id;
       
       RiwayatPasangan::create($input);

       return redirect('/riwayat_pasangan/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatPasangan $riwayat_pasangan)
   {
       $pegawai = Pegawai::where('id',$id)->get();
       $pegawai->toArray();
       $view=view('admin.riwayat_pasangan.edit', compact('pegawai','riwayat_pasangan'));
       $view=$view->render();
       return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatPasangan $riwayat_pasangan)
   {
       $this->validate($request, [
           'nama_pasangan' => 'required'
       ]);

       $riwayat_pasangan->fill($request->all());
       
       $riwayat_pasangan->user_id = Auth::user()->id;
       $riwayat_pasangan->save();
       
       return redirect('/riwayat_pasangan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatPasangan $riwayat_pasangan)
   {
       $riwayat_pasangan->delete();
       
       return redirect('/riwayat_pasangan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
