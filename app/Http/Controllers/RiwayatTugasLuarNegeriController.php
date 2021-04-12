<?php

namespace App\Http\Controllers;

use App\Models\RiwayatTugasLuarNegeri;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatTugasLuarNegeriController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_tugas_luar_negeri = RiwayatTugasLuarNegeri::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_tugas_luar_negeri.index',compact('riwayat_tugas_luar_negeri','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_tugas_luar_negeri = $request->get('search');
        $riwayat_tugas_luar_negeri = RiwayatTugasLuarNegeri::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_tugas_luar_negeri) {
                                $query->where('tujuan', 'LIKE', '%'.$riwayat_tugas_luar_negeri.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_tugas_luar_negeri.index',compact('riwayat_tugas_luar_negeri','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_tugas_luar_negeri.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'tujuan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);

        $input['pegawai_id'] = $id;
        $input['tujuan'] = $request->tujuan;
        $input['tanggal_mulai'] = $request->tanggal_mulai;
        $input['tanggal_selesai'] = $request->tanggal_selesai;
        $input['no_sk'] = $request->no_sk;
        $input['tanggal_sk'] = $request->tanggal_sk;
        $input['pejabat'] = $request->pejabat;
        $input['user_id'] = Auth::user()->id;
    
        RiwayatTugasLuarNegeri::create($input);

        return redirect('/riwayat_tugas_luar_negeri/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatTugasLuarNegeri $riwayat_tugas_luar_negeri)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_tugas_luar_negeri.edit', compact('pegawai','riwayat_tugas_luar_negeri'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatTugasLuarNegeri $riwayat_tugas_luar_negeri)
   {
        $this->validate($request, [
            'tujuan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
        ]);

        $riwayat_tugas_luar_negeri->fill($request->all()); 
        $riwayat_tugas_luar_negeri->user_id = Auth::user()->id;
        $riwayat_tugas_luar_negeri->save();
    
        return redirect('/riwayat_tugas_luar_negeri/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatTugasLuarNegeri $riwayat_tugas_luar_negeri)
   {
        $riwayat_tugas_luar_negeri->delete();
       
        return redirect('/riwayat_tugas_luar_negeri/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
