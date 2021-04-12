<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPendidikan;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatPendidikanController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_pendidikan.index',compact('riwayat_pendidikan','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_pendidikan = $request->get('search');
        $riwayat_pendidikan = RiwayatPendidikan::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_pendidikan) {
                                $query->where('pendidikan', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('nama_sekolah', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('jurusan', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('no_ijazah', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('tahun_ijazah', 'LIKE', '%'.$riwayat_pendidikan.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_pendidikan.index',compact('riwayat_pendidikan','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_pendidikan.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'pendidikan' => 'required',
            'nama_sekolah' => 'required',
            'tahun_ijazah' => 'required|digits:4'
        ]);

        $input['pegawai_id'] = $id;
        $input['pendidikan'] = $request->pendidikan;
        if($request->pendidikan=="SD"){
            $input['jenis_pendidikan'] = 1;
        } else if($request->pendidikan=="SLTP"){
            $input['jenis_pendidikan'] = 2;
        } else if($request->pendidikan=="SLTP Kejuruan"){
            $input['jenis_pendidikan'] = 3;
        } else if($request->pendidikan=="SLTA"){
            $input['jenis_pendidikan'] = 4;
        } else if($request->pendidikan=="SLTA Kejuruan"){
            $input['jenis_pendidikan'] = 5;
        } else if($request->pendidikan=="SLTA Keguruan"){
            $input['jenis_pendidikan'] = 6;
        } else if($request->pendidikan=="Diploma I"){
            $input['jenis_pendidikan'] = 7;
        } else if($request->pendidikan=="Diploma II"){
            $input['jenis_pendidikan'] = 8;
        } else if($request->pendidikan=="Diploma III / Sarjana Muda"){
            $input['jenis_pendidikan'] = 9;
        } else if($request->pendidikan=="Diploma IV"){
            $input['jenis_pendidikan'] = 10;
        } else if($request->pendidikan=="S1 / Sarjana"){
            $input['jenis_pendidikan'] = 11;
        } else if($request->pendidikan=="S2"){
            $input['jenis_pendidikan'] = 12;
        } else if($request->pendidikan=="S3 / Doktor"){
            $input['jenis_pendidikan'] = 13;
        }   

        $input['nama_sekolah'] = $request->nama_sekolah;
        $input['jurusan'] = $request->jurusan;
        $input['no_ijazah'] = $request->no_ijazah;
        $input['tahun_ijazah'] = $request->tahun_ijazah;
        $input['user_id'] = Auth::user()->id;
       
        RiwayatPendidikan::create($input);

        return redirect('/riwayat_pendidikan/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatPendidikan $riwayat_pendidikan)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_pendidikan.edit', compact('pegawai','riwayat_pendidikan'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatPendidikan $riwayat_pendidikan)
   {
        $this->validate($request, [
            'pendidikan' => 'required',
            'nama_sekolah' => 'required',
            'tahun_ijazah' => 'required|digits:4'
        ]);

        $riwayat_pendidikan->fill($request->all());
       
        if($request->pendidikan=="SD"){
            $riwayat_pendidikan->jenis_pendidikan = 1;
        } else if($request->pendidikan=="SLTP"){
            $riwayat_pendidikan->jenis_pendidikan = 2;
        } else if($request->pendidikan=="SLTP Kejuruan"){
            $riwayat_pendidikan->jenis_pendidikan = 3;
        } else if($request->pendidikan=="SLTA"){
            $riwayat_pendidikan->jenis_pendidikan = 4;
        } else if($request->pendidikan=="SLTA Kejuruan"){
            $riwayat_pendidikan->jenis_pendidikan = 5;
        } else if($request->pendidikan=="SLTA Keguruan"){
            $riwayat_pendidikan->jenis_pendidikan = 6;
        } else if($request->pendidikan=="Diploma I"){
            $riwayat_pendidikan->jenis_pendidikan = 7;
        } else if($request->pendidikan=="Diploma II"){
            $riwayat_pendidikan->jenis_pendidikan = 8;
        } else if($request->pendidikan=="Diploma III / Sarjana Muda"){
            $riwayat_pendidikan->jenis_pendidikan = 9;
        } else if($request->pendidikan=="Diploma IV"){
            $riwayat_pendidikan->jenis_pendidikan = 10;
        } else if($request->pendidikan=="S1 / Sarjana"){
            $riwayat_pendidikan->jenis_pendidikan = 11;
        } else if($request->pendidikan=="S2"){
            $riwayat_pendidikan->jenis_pendidikan = 12;
        } else if($request->pendidikan=="S3 / Doktor"){
            $riwayat_pendidikan->jenis_pendidikan = 13;
        }   
        
        $riwayat_pendidikan->user_id = Auth::user()->id;
        $riwayat_pendidikan->save();
       
        return redirect('/riwayat_pendidikan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatPendidikan $riwayat_pendidikan)
   {
        $riwayat_pendidikan->delete();
       
        return redirect('/riwayat_pendidikan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
