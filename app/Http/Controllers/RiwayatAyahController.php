<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAyah;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatAyahController extends Controller
{
     ## Cek Login
     public function __construct()
     {
         $this->middleware('auth');
     }
     
     ## Tampikan Data
     public function index($id)
     {
         $riwayat_ayah = RiwayatAyah::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         $pegawai = Pegawai::where('id',$id)->get();
         $pegawai->toArray();
         return view('admin.riwayat_ayah.index',compact('riwayat_ayah','pegawai'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request, $id)
     {
         $riwayat_ayah = $request->get('search');
         $riwayat_ayah = RiwayatAyah::where('pegawai_id',$id)->where('nama_ayah', 'LIKE', '%'.$riwayat_ayah.'%')->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         $pegawai = Pegawai::where('id',$id)->get();
         $pegawai->toArray();
         return view('admin.riwayat_ayah.index',compact('riwayat_ayah','pegawai'));
     }

    ## Tampilkan Form Create
    public function create($id)
    {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
		$view=view('admin.riwayat_ayah.create',compact('pegawai'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store($id, Request $request)
    {
        $this->validate($request, [
            'nama_ayah' => 'required'
        ]);

		$input['pegawai_id'] = $id;
		$input['nama_ayah'] = $request->nama_ayah;
		$input['tempat_lahir'] = $request->tempat_lahir;
		$input['tanggal_lahir'] = $request->tanggal_lahir;
		$input['user_id'] = Auth::user()->id;
		
        RiwayatAyah::create($input);

		return redirect('/riwayat_ayah/'.$id)->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($id, RiwayatAyah $riwayat_ayah)
    {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_ayah.edit', compact('pegawai','riwayat_ayah'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $id, RiwayatAyah $riwayat_ayah)
    {
        $this->validate($request, [
            'nama_ayah' => 'required'
        ]);

        $riwayat_ayah->fill($request->all());
        
		$riwayat_ayah->user_id = Auth::user()->id;
    	$riwayat_ayah->save();
		
		return redirect('/riwayat_ayah/'.$id)->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($id, RiwayatAyah $riwayat_ayah)
    {
		$riwayat_ayah->delete();
		
        return redirect('/riwayat_ayah/'.$id)->with('status', 'Data Berhasil Dihapus');
    }


}
