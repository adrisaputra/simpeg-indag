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
                                $query->where('jenis_hukuman', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('mulai', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('selesai', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('no_sk', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('pejabat', 'LIKE', '%'.$riwayat_hukuman.'%')
                                ->orWhere('keterangan', 'LIKE', '%'.$riwayat_hukuman.'%');
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
            'jenis_hukuman' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'pejabat' => 'required',
            'arsip_hukuman' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['jenis_hukuman'] = $request->jenis_hukuman;
        $input['mulai'] = $request->mulai;
        $input['selesai'] = $request->selesai;
        $input['no_sk'] = $request->no_sk;
        $input['tanggal_sk'] = $request->tanggal_sk;
        $input['pejabat'] = $request->pejabat;
        $input['keterangan'] = $request->keterangan;
        
		if($request->file('arsip_hukuman')){
			$input['arsip_hukuman'] = time().'.'.$request->arsip_hukuman->getClientOriginalExtension();
			$request->arsip_hukuman->move(public_path('upload/arsip_hukuman'), $input['arsip_hukuman']);
    	}	
		
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
            'jenis_hukuman' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'pejabat' => 'required',
            'arsip_hukuman' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('arsip_hukuman') && $riwayat_hukuman->arsip_hukuman){
            $pathToYourFile = public_path('upload/arsip_hukuman/'.$riwayat_hukuman->arsip_hukuman);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_hukuman->fill($request->all());
       
        if($request->file('arsip_hukuman')){
            $filename = time().'.'.$request->arsip_hukuman->getClientOriginalExtension();
            $request->arsip_hukuman->move(public_path('upload/arsip_hukuman'), $filename);
            $riwayat_hukuman->arsip_hukuman = $filename;
		}

        $riwayat_hukuman->user_id = Auth::user()->id;
        $riwayat_hukuman->save();
    
        return redirect('/riwayat_hukuman/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatHukuman $riwayat_hukuman)
   {
        $pathToYourFile = public_path('upload/arsip_hukuman/'.$riwayat_hukuman->arsip_hukuman);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_hukuman->delete();
       
        return redirect('/riwayat_hukuman/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
