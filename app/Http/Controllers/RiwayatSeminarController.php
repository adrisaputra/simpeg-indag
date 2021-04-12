<?php

namespace App\Http\Controllers;

use App\Models\RiwayatSeminar;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatSeminarController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_seminar = RiwayatSeminar::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_seminar.index',compact('riwayat_seminar','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_seminar = $request->get('search');
        $riwayat_seminar = RiwayatSeminar::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_seminar) {
                                $query->where('nama_seminar', 'LIKE', '%'.$riwayat_seminar.'%')
                                    ->orWhere('tingkat_seminar', 'LIKE', '%'.$riwayat_seminar.'%')
                                    ->orWhere('peranan', 'LIKE', '%'.$riwayat_seminar.'%')
                                    ->orWhere('tanggal', 'LIKE', '%'.$riwayat_seminar.'%')
                                    ->orWhere('penyelenggara', 'LIKE', '%'.$riwayat_seminar.'%')
                                    ->orWhere('tempat', 'LIKE', '%'.$riwayat_seminar.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_seminar.index',compact('riwayat_seminar','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_seminar.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'nama_seminar' => 'required',
            'tanggal' => 'required',
            'penyelenggara' => 'required',
            'tempat' => 'required',
            'arsip_sertifikat_seminar' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['nama_seminar'] = $request->nama_seminar;
        $input['tingkat_seminar'] = $request->tingkat_seminar;
        $input['peranan'] = $request->peranan;
        $input['tanggal'] = $request->tanggal;
        $input['penyelenggara'] = $request->penyelenggara;
        $input['tempat'] = $request->tempat;
        $input['arsip_sertifikat_seminar'] = $request->arsip_sertifikat_seminar;
        
		if($request->file('arsip_sertifikat_seminar')){
			$input['arsip_sertifikat_seminar'] = time().'.'.$request->arsip_sertifikat_seminar->getClientOriginalExtension();
			$request->arsip_sertifikat_seminar->move(public_path('upload/arsip_sertifikat_seminar'), $input['arsip_sertifikat_seminar']);
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatSeminar::create($input);

        return redirect('/riwayat_seminar/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatSeminar $riwayat_seminar)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_seminar.edit', compact('pegawai','riwayat_seminar'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatSeminar $riwayat_seminar)
   {
        $this->validate($request, [
            'nama_seminar' => 'required',
            'tanggal' => 'required',
            'penyelenggara' => 'required',
            'tempat' => 'required',
            'arsip_sertifikat_seminar' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);
        
        if($request->file('arsip_sertifikat_seminar') && $riwayat_seminar->arsip_sertifikat_seminar){
            $pathToYourFile = public_path('upload/arsip_sertifikat_seminar/'.$riwayat_seminar->arsip_sertifikat_seminar);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_seminar->fill($request->all());
       
        if($request->file('arsip_sertifikat_seminar')){
            $filename = time().'.'.$request->arsip_sertifikat_seminar->getClientOriginalExtension();
            $request->arsip_sertifikat_seminar->move(public_path('upload/arsip_sertifikat_seminar'), $filename);
            $riwayat_seminar->arsip_sertifikat_seminar = $filename;
		}

        $riwayat_seminar->user_id = Auth::user()->id;
        $riwayat_seminar->save();
       
        return redirect('/riwayat_seminar/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatSeminar $riwayat_seminar)
   {
        $pathToYourFile = public_path('upload/arsip_sertifikat_seminar/'.$riwayat_seminar->arsip_sertifikat_seminar);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_seminar->delete();
       
        return redirect('/riwayat_seminar/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
