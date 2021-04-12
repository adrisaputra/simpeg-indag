<?php

namespace App\Http\Controllers;

use App\Models\RiwayatDiklat;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatDiklatController extends Controller
{
     ## Cek Login
     public function __construct()
     {
         $this->middleware('auth');
     }
     
     ## Tampikan Data
     public function index($id)
     {
         $riwayat_diklat = RiwayatDiklat::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         $pegawai = Pegawai::where('id',$id)->get();
         $pegawai->toArray();
         return view('admin.riwayat_diklat.index',compact('riwayat_diklat','pegawai'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request, $id)
     {
         $riwayat_diklat = $request->get('search');
         $riwayat_diklat = RiwayatDiklat::where('pegawai_id',$id)
                             ->where(function ($query) use ($riwayat_diklat) {
                                 $query->where('diklat', 'LIKE', '%'.$riwayat_diklat.'%')
                                     ->orWhere('nama_sekolah', 'LIKE', '%'.$riwayat_diklat.'%')
                                     ->orWhere('jurusan', 'LIKE', '%'.$riwayat_diklat.'%')
                                     ->orWhere('no_ijazah', 'LIKE', '%'.$riwayat_diklat.'%')
                                     ->orWhere('tahun_ijazah', 'LIKE', '%'.$riwayat_diklat.'%');
                             })
                             ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         $pegawai = Pegawai::where('id',$id)->get();
         $pegawai->toArray();
         return view('admin.riwayat_diklat.index',compact('riwayat_diklat','pegawai'));
     }
 
    ## Tampilkan Form Create
    public function create($id)
    {
         $pegawai = Pegawai::where('id',$id)->get();
         $pegawai->toArray();
         $view=view('admin.riwayat_diklat.create',compact('pegawai'));
         $view=$view->render();
         return $view;
    }
 
    ## Simpan Data
    public function store($id, Request $request)
    {
        $this->validate($request, [
            'diklat' => 'required',
            'nama_diklat' => 'required',
            'tempat' => 'required',
            'penyelenggara' => 'required',
            'no_sertifikat' => 'required',
            'tanggal_sertifikat' => 'required',
            'jam' => 'numeric'
        ]);

        $input['pegawai_id'] = $id;
        $input['diklat'] = $request->diklat;
        
        if($request->diklat=="Diklat Fungsional"){
            $input['jenis_diklat'] = 1;
        } else if($request->diklat=="Diklat Struktural"){
            $input['jenis_diklat'] = 2;
        } else if($request->diklat=="Diklat Teknis"){
            $input['jenis_diklat'] = 3;
        }  else if($request->diklat=="Diklat Pradiklat"){
            $input['jenis_diklat'] = 4;
        }  
 
        $input['nama_diklat'] = $request->nama_diklat;
        $input['tempat'] = $request->tempat;
        $input['penyelenggara'] = $request->penyelenggara;
        $input['no_sertifikat'] = $request->no_sertifikat;
        $input['tanggal_sertifikat'] = $request->tanggal_sertifikat;
        $input['tanggal_mulai'] = $request->tanggal_mulai;
        $input['tanggal_selesai'] = $request->tanggal_selesai;
        $input['jam'] = $request->jam;
        $input['angkatan'] = $request->angkatan;
        $input['user_id'] = Auth::user()->id;
    
        RiwayatDiklat::create($input);

        return redirect('/riwayat_diklat/'.$id)->with('status','Data Tersimpan');
    }
 
    ## Tampilkan Form Edit
    public function edit($id, RiwayatDiklat $riwayat_diklat)
    {
         $pegawai = Pegawai::where('id',$id)->get();
         $pegawai->toArray();
         $view=view('admin.riwayat_diklat.edit', compact('pegawai','riwayat_diklat'));
         $view=$view->render();
         return $view;
    }
 
    ## Edit Data
    public function update(Request $request, $id, RiwayatDiklat $riwayat_diklat)
    {
        $this->validate($request, [
            'diklat' => 'required',
            'nama_diklat' => 'required',
            'tempat' => 'required',
            'penyelenggara' => 'required',
            'no_sertifikat' => 'required',
            'tanggal_sertifikat' => 'required',
            'jam' => 'numeric'
        ]);
 
         $riwayat_diklat->fill($request->all());
         
        if($request->diklat=="Diklat Fungsional"){
            $riwayat_diklat->jenis_diklat = 1;
        } else if($request->diklat=="Diklat Struktural"){
            $riwayat_diklat->jenis_diklat = 2;
        } else if($request->diklat=="Diklat Teknis"){
            $riwayat_diklat->jenis_diklat = 3;
        }  else if($request->diklat=="Diklat Pradiklat"){
            $riwayat_diklat->jenis_diklat = 4;
        }  
  
        $riwayat_diklat->user_id = Auth::user()->id;
        $riwayat_diklat->save();
    
        return redirect('/riwayat_diklat/'.$id)->with('status', 'Data Berhasil Diubah');
    }
 
    ## Hapus Data
    public function delete($id, RiwayatDiklat $riwayat_diklat)
    {
         $riwayat_diklat->delete();
        
         return redirect('/riwayat_diklat/'.$id)->with('status', 'Data Berhasil Dihapus');
    }
}
