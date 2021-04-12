<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAnak;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatAnakController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_anak = RiwayatAnak::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_anak.index',compact('riwayat_anak','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_anak = $request->get('search');
        $riwayat_anak = RiwayatAnak::where('pegawai_id',$id)->where('nama_anak', 'LIKE', '%'.$riwayat_anak.'%')->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_anak.index',compact('riwayat_anak','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
       $pegawai = Pegawai::where('id',$id)->get();
       $pegawai->toArray();
       $view=view('admin.riwayat_anak.create',compact('pegawai'));
       $view=$view->render();
       return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
       $this->validate($request, [
           'nama_anak' => 'required'
       ]);

       $input['pegawai_id'] = $id;
       $input['nama_anak'] = $request->nama_anak;
       $input['tempat_lahir'] = $request->tempat_lahir;
       $input['tanggal_lahir'] = $request->tanggal_lahir;
       $input['user_id'] = Auth::user()->id;
       
       RiwayatAnak::create($input);

       return redirect('/riwayat_anak/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatAnak $riwayat_anak)
   {
       $pegawai = Pegawai::where('id',$id)->get();
       $pegawai->toArray();
       $view=view('admin.riwayat_anak.edit', compact('pegawai','riwayat_anak'));
       $view=$view->render();
       return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatAnak $riwayat_anak)
   {
       $this->validate($request, [
           'nama_anak' => 'required'
       ]);

       $riwayat_anak->fill($request->all());
       
       $riwayat_anak->user_id = Auth::user()->id;
       $riwayat_anak->save();
       
       return redirect('/riwayat_anak/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatAnak $riwayat_anak)
   {
       $riwayat_anak->delete();
       
       return redirect('/riwayat_anak/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
