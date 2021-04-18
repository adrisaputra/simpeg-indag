<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPenghargaan;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatPenghargaanController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_penghargaan = RiwayatPenghargaan::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_penghargaan.index',compact('riwayat_penghargaan','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_penghargaan = $request->get('search');
        $riwayat_penghargaan = RiwayatPenghargaan::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_penghargaan) {
                                $query->where('nama_penghargaan', 'LIKE', '%'.$riwayat_penghargaan.'%')
                                    ->orWhere('no_sk', 'LIKE', '%'.$riwayat_penghargaan.'%')
                                    ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_penghargaan.'%')
                                    ->orWhere('keterangan', 'LIKE', '%'.$riwayat_penghargaan.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_penghargaan.index',compact('riwayat_penghargaan','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_penghargaan.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
       $this->validate($request, [
           'nama_penghargaan' => 'required',
           'no_sk' => 'required',
           'tanggal_sk' => 'required',
           'arsip_penghargaan' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
       ]);

       $input['pegawai_id'] = $id;
       $input['nama_penghargaan'] = $request->nama_penghargaan;
       $input['no_sk'] = $request->no_sk;
       $input['tanggal_sk'] = $request->tanggal_sk;
       $input['keterangan'] = $request->keterangan;
       
		if($request->file('arsip_penghargaan')){
			$input['arsip_penghargaan'] = time().'.'.$request->arsip_penghargaan->getClientOriginalExtension();
			$request->arsip_penghargaan->move(public_path('upload/arsip_penghargaan'), $input['arsip_penghargaan']);
    	}	
		
       $input['user_id'] = Auth::user()->id;
   
       RiwayatPenghargaan::create($input);

       return redirect('/riwayat_penghargaan/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatPenghargaan $riwayat_penghargaan)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_penghargaan.edit', compact('pegawai','riwayat_penghargaan'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatPenghargaan $riwayat_penghargaan)
   {
        $this->validate($request, [
            'nama_penghargaan' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'arsip_penghargaan' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('arsip_penghargaan') && $riwayat_penghargaan->arsip_penghargaan){
            $pathToYourFile = public_path('upload/arsip_penghargaan/'.$riwayat_penghargaan->arsip_penghargaan);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_penghargaan->fill($request->all());
       
        if($request->file('arsip_penghargaan')){
            $filename = time().'.'.$request->arsip_penghargaan->getClientOriginalExtension();
            $request->arsip_penghargaan->move(public_path('upload/arsip_penghargaan'), $filename);
            $riwayat_penghargaan->arsip_penghargaan = $filename;
		}

        $riwayat_penghargaan->user_id = Auth::user()->id;
        $riwayat_penghargaan->save();
    
        return redirect('/riwayat_penghargaan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatPenghargaan $riwayat_penghargaan)
   {
        $pathToYourFile = public_path('upload/arsip_penghargaan/'.$riwayat_penghargaan->arsip_penghargaan);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_penghargaan->delete();
       
        return redirect('/riwayat_penghargaan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
