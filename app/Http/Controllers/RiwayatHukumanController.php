<?php

namespace App\Http\Controllers;

use App\Models\RiwayatHukuman;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatHukumanController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_hukuman = RiwayatHukuman::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_hukuman.index',compact('riwayat_hukuman','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_hukuman = $request->get('search');
        $riwayat_hukuman = RiwayatHukuman::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_hukuman) {
                                $query->where('nama_hukuman', 'LIKE', '%'.$riwayat_hukuman.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_hukuman.index',compact('riwayat_hukuman','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_hukuman.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'nama_hukuman' => 'required',
        ]);

        $input['pegawai_id'] = $id;
        $input['nama_hukuman'] = $request->nama_hukuman;
        $input['uraian_hukuman'] = $request->uraian_hukuman;
        $input['no_sk'] = $request->no_sk;
        $input['tanggal_sk'] = $request->tanggal_sk;
        $input['pejabat'] = $request->pejabat;
        $input['user_id'] = Auth::user()->id;
    
        RiwayatHukuman::create($input);

        return redirect('/riwayat_hukuman/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatHukuman $riwayat_hukuman)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_hukuman.edit', compact('pegawai','riwayat_hukuman'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatHukuman $riwayat_hukuman)
   {
        $this->validate($request, [
            'nama_hukuman' => 'required',
        ]);

        $riwayat_hukuman->fill($request->all()); 
        $riwayat_hukuman->user_id = Auth::user()->id;
        $riwayat_hukuman->save();
    
        return redirect('/riwayat_hukuman/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatHukuman $riwayat_hukuman)
   {
        $riwayat_hukuman->delete();
       
        return redirect('/riwayat_hukuman/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
