<?php

namespace App\Http\Controllers;

use App\Models\RiwayatCuti;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatCutiController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_cuti = RiwayatCuti::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_cuti.index',compact('riwayat_cuti','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_cuti = $request->get('search');
        $riwayat_cuti = RiwayatCuti::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_cuti) {
                                $query->where('jenis_cuti', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('keterangan', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('mulai', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('selesai', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('no_sk', 'LIKE', '%'.$riwayat_cuti.'%')
                                    ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_cuti.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_cuti.index',compact('riwayat_cuti','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_cuti.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
       $this->validate($request, [
           'jenis_cuti' => 'required',
           'mulai' => 'required',
           'selesai' => 'required',
           'no_sk' => 'required',
           'tanggal_sk' => 'required',
           'arsip_cuti' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
       ]);

       $input['pegawai_id'] = $id;
       $input['jenis_cuti'] = $request->jenis_cuti;
       $input['keterangan'] = $request->keterangan;
       $input['mulai'] = $request->mulai;
       $input['selesai'] = $request->selesai;
       $input['no_sk'] = $request->no_sk;
       $input['tanggal_sk'] = $request->tanggal_sk;
       
		if($request->file('arsip_cuti')){
			$input['arsip_cuti'] = time().'.'.$request->arsip_cuti->getClientOriginalExtension();
			$request->arsip_cuti->move(public_path('upload/arsip_cuti'), $input['arsip_cuti']);
    	}	
		
       $input['user_id'] = Auth::user()->id;
   
       RiwayatCuti::create($input);

       return redirect('/riwayat_cuti/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatCuti $riwayat_cuti)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_cuti.edit', compact('pegawai','riwayat_cuti'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatCuti $riwayat_cuti)
   {
        $this->validate($request, [
            'jenis_cuti' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'arsip_cuti' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('arsip_cuti') && $riwayat_cuti->arsip_cuti){
            $pathToYourFile = public_path('upload/arsip_cuti/'.$riwayat_cuti->arsip_cuti);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_cuti->fill($request->all());
       
        if($request->file('arsip_cuti')){
            $filename = time().'.'.$request->arsip_cuti->getClientOriginalExtension();
            $request->arsip_cuti->move(public_path('upload/arsip_cuti'), $filename);
            $riwayat_cuti->arsip_cuti = $filename;
		}

        $riwayat_cuti->user_id = Auth::user()->id;
        $riwayat_cuti->save();
    
        return redirect('/riwayat_cuti/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatCuti $riwayat_cuti)
   {
        $pathToYourFile = public_path('upload/arsip_cuti/'.$riwayat_cuti->arsip_cuti);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_cuti->delete();
       
        return redirect('/riwayat_cuti/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
