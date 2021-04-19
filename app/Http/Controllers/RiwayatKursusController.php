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
            'lokasi_tes' => 'required',
            'tanggal_tes' => 'required',
            'score' => 'required|numeric',
            'listening' => 'required|numeric',
            'structure' => 'required|numeric',
            'reading' => 'required|numeric',
            'writing' => 'required|numeric',
            'speaking' => 'required|numeric',
            'arsip_toefl' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

       $input['pegawai_id'] = $id;
       $input['lokasi_tes'] = $request->lokasi_tes;
       $input['tanggal_tes'] = $request->tanggal_tes;
       $input['score'] = $request->score;
       $input['listening'] = $request->listening;
       $input['structure'] = $request->structure;
       $input['reading'] = $request->reading;
       $input['writing'] = $request->writing;
       $input['speaking'] = $request->speaking;
       
       if($request->file('arsip_toefl')){
            $input['arsip_toefl'] = time().'.'.$request->arsip_toefl->getClientOriginalExtension();
            $request->arsip_toefl->move(public_path('upload/arsip_toefl'), $input['arsip_toefl']);
        }	
    
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
            'lokasi_tes' => 'required',
            'tanggal_tes' => 'required',
            'score' => 'required|numeric',
            'listening' => 'required|numeric',
            'structure' => 'required|numeric',
            'reading' => 'required|numeric',
            'writing' => 'required|numeric',
            'speaking' => 'required|numeric',
            'arsip_toefl' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('arsip_toefl') && $riwayat_kursus->arsip_toefl){
            $pathToYourFile = public_path('upload/arsip_toefl/'.$riwayat_kursus->arsip_toefl);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_kursus->fill($request->all());
       
        if($request->file('arsip_toefl')){
            $filename = time().'.'.$request->arsip_toefl->getClientOriginalExtension();
            $request->arsip_toefl->move(public_path('upload/arsip_toefl'), $filename);
            $riwayat_kursus->arsip_toefl = $filename;
        }
        
        $riwayat_kursus->user_id = Auth::user()->id;
        $riwayat_kursus->save();
    
        return redirect('/riwayat_kursus/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKursus $riwayat_kursus)
   {
        $pathToYourFile = public_path('upload/arsip_toefl/'.$riwayat_kursus->arsip_toefl);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }
        $riwayat_kursus->delete();
       
        return redirect('/riwayat_kursus/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
