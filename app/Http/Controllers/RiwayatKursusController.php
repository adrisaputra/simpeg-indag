<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKursus;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatKursusController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_kursus = RiwayatKursus::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_kursus.index',compact('riwayat_kursus','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_kursus = $request->get('search');
        $riwayat_kursus = RiwayatKursus::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_kursus) {
                                $query->where('nama_kursus', 'LIKE', '%'.$riwayat_kursus.'%')
                                    ->orWhere('tempat', 'LIKE', '%'.$riwayat_kursus.'%')
                                    ->orWhere('penyelenggara', 'LIKE', '%'.$riwayat_kursus.'%')
                                    ->orWhere('no_sertifikat', 'LIKE', '%'.$riwayat_kursus.'%')
                                    ->orWhere('tanggal_sertifikat', 'LIKE', '%'.$riwayat_kursus.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_kursus.index',compact('riwayat_kursus','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_kursus.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'nama_kursus' => 'required',
            'tempat' => 'required',
            'penyelenggara' => 'required',
            'no_sertifikat' => 'required',
            'tanggal_sertifikat' => 'required'
        ]);

       $input['pegawai_id'] = $id;
       $input['nama_kursus'] = $request->nama_kursus;
       $input['tempat'] = $request->tempat;
       $input['penyelenggara'] = $request->penyelenggara;
       $input['no_sertifikat'] = $request->no_sertifikat;
       $input['tanggal_sertifikat'] = $request->tanggal_sertifikat;
       $input['user_id'] = Auth::user()->id;
   
       RiwayatKursus::create($input);

       return redirect('/riwayat_kursus/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatKursus $riwayat_kursus)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_kursus.edit', compact('pegawai','riwayat_kursus'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatKursus $riwayat_kursus)
   {
        $this->validate($request, [
            'nama_kursus' => 'required',
            'tempat' => 'required',
            'penyelenggara' => 'required',
            'no_sertifikat' => 'required',
            'tanggal_sertifikat' => 'required'
        ]);

        $riwayat_kursus->fill($request->all()); 
        $riwayat_kursus->user_id = Auth::user()->id;
        $riwayat_kursus->save();
    
        return redirect('/riwayat_kursus/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKursus $riwayat_kursus)
   {
        $riwayat_kursus->delete();
       
        return redirect('/riwayat_kursus/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
