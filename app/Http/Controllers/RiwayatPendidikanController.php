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
                                $query->where('tingkat', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('lembaga', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('jurusan', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('no_sttb', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('tanggal_sttb', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('tanggal_kelulusan', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('tanggal_kelulusan', 'LIKE', '%'.$riwayat_pendidikan.'%')
                                    ->orWhere('ipk', 'LIKE', '%'.$riwayat_pendidikan.'%');
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
            'tingkat' => 'required',
            'lembaga' => 'required',
            'arsip_ijazah' => 'required|mimes:jpg,jpeg,png,pdf|max:500',
            'arsip_transkrip_nilai' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        if($request->tingkat=="SD"){
            $input['jenis_pendidikan'] = 1;
        } else if($request->tingkat=="SLTP"){
            $input['jenis_pendidikan'] = 2;
        } else if($request->tingkat=="SLTP Kejuruan"){
            $input['jenis_pendidikan'] = 3;
        } else if($request->tingkat=="SLTA"){
            $input['jenis_pendidikan'] = 4;
        } else if($request->tingkat=="SLTA Kejuruan"){
            $input['jenis_pendidikan'] = 5;
        } else if($request->tingkat=="SLTA Keguruan"){
            $input['jenis_pendidikan'] = 6;
        } else if($request->tingkat=="Diploma I"){
            $input['jenis_pendidikan'] = 7;
        } else if($request->tingkat=="Diploma II"){
            $input['jenis_pendidikan'] = 8;
        } else if($request->tingkat=="Diploma III / Sarjana Muda"){
            $input['jenis_pendidikan'] = 9;
        } else if($request->tingkat=="Diploma IV"){
            $input['jenis_pendidikan'] = 10;
        } else if($request->tingkat=="S1 / Sarjana"){
            $input['jenis_pendidikan'] = 11;
        } else if($request->tingkat=="S2"){
            $input['jenis_pendidikan'] = 12;
        } else if($request->tingkat=="S3 / Doktor"){
            $input['jenis_pendidikan'] = 13;
        }   

        $input['tingkat'] = $request->tingkat;
        $input['lembaga'] = $request->lembaga;
        $input['fakultas'] = $request->fakultas;
        $input['jurusan'] = $request->jurusan;
        $input['no_sttb'] = $request->no_sttb;
        $input['tanggal_sttb'] = $request->tanggal_sttb;
        $input['tanggal_kelulusan'] = $request->tanggal_kelulusan;
        $input['ipk'] = $request->ipk;
        
		if($request->file('arsip_ijazah')){
			$input['arsip_ijazah'] = time().'.'.$request->arsip_ijazah->getClientOriginalExtension();
			$request->arsip_ijazah->move(public_path('upload/arsip_ijazah'), $input['arsip_ijazah']);
    	}	
		
		if($request->file('arsip_transkrip_nilai')){
			$input['arsip_transkrip_nilai'] = time().'.'.$request->arsip_transkrip_nilai->getClientOriginalExtension();
			$request->arsip_transkrip_nilai->move(public_path('upload/arsip_transkrip_nilai'), $input['arsip_transkrip_nilai']);
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatPendidikan::create($input);

        $pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('jenis_pendidikan','DESC')->limit(1)->get();
        $pendidikan->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->pendidikan = $pendidikan[0]->tingkat;
        $pegawai->save();
        
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
            'tingkat' => 'required',
            'lembaga' => 'required',
            'arsip_ijazah' => 'mimes:jpg,jpeg,png,pdf|max:500',
            'arsip_transkrip_nilai' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);
        
        if($request->file('arsip_ijazah') && $riwayat_pendidikan->arsip_ijazah){
            $pathToYourFile = public_path('upload/arsip_ijazah/'.$riwayat_pendidikan->arsip_ijazah);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        if($request->file('arsip_transkrip_nilai') && $riwayat_pendidikan->arsip_transkrip_nilai){
            $pathToYourFile = public_path('upload/arsip_transkrip_nilai/'.$riwayat_pendidikan->arsip_transkrip_nilai);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_pendidikan->fill($request->all());
       
        if($request->tingkat=="SD"){
            $riwayat_pendidikan->jenis_pendidikan = 1;
        } else if($request->tingkat=="SLTP"){
            $riwayat_pendidikan->jenis_pendidikan = 2;
        } else if($request->tingkat=="SLTP Kejuruan"){
            $riwayat_pendidikan->jenis_pendidikan = 3;
        } else if($request->tingkat=="SLTA"){
            $riwayat_pendidikan->jenis_pendidikan = 4;
        } else if($request->tingkat=="SLTA Kejuruan"){
            $riwayat_pendidikan->jenis_pendidikan = 5;
        } else if($request->tingkat=="SLTA Keguruan"){
            $riwayat_pendidikan->jenis_pendidikan = 6;
        } else if($request->tingkat=="Diploma I"){
            $riwayat_pendidikan->jenis_pendidikan = 7;
        } else if($request->tingkat=="Diploma II"){
            $riwayat_pendidikan->jenis_pendidikan = 8;
        } else if($request->tingkat=="Diploma III / Sarjana Muda"){
            $riwayat_pendidikan->jenis_pendidikan = 9;
        } else if($request->tingkat=="Diploma IV"){
            $riwayat_pendidikan->jenis_pendidikan = 10;
        } else if($request->tingkat=="S1 / Sarjana"){
            $riwayat_pendidikan->jenis_pendidikan = 11;
        } else if($request->tingkat=="S2"){
            $riwayat_pendidikan->jenis_pendidikan = 12;
        } else if($request->tingkat=="S3 / Doktor"){
            $riwayat_pendidikan->jenis_pendidikan = 13;
        }   
        
        if($request->file('arsip_ijazah')){
            $filename = time().'.'.$request->arsip_ijazah->getClientOriginalExtension();
            $request->arsip_ijazah->move(public_path('upload/arsip_ijazah'), $filename);
            $riwayat_pendidikan->arsip_ijazah = $filename;
		}

        if($request->file('arsip_transkrip_nilai')){
            $filename = time().'.'.$request->arsip_transkrip_nilai->getClientOriginalExtension();
            $request->arsip_transkrip_nilai->move(public_path('upload/arsip_transkrip_nilai'), $filename);
            $riwayat_pendidikan->arsip_transkrip_nilai = $filename;
		}

        $riwayat_pendidikan->user_id = Auth::user()->id;
        $riwayat_pendidikan->save();
       
        $pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('jenis_pendidikan','DESC')->limit(1)->get();
        $pendidikan->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->pendidikan = $pendidikan[0]->tingkat;
    	$pegawai->save();

        return redirect('/riwayat_pendidikan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatPendidikan $riwayat_pendidikan)
   {
        $pathToYourFile = public_path('upload/arsip_ijazah/'.$riwayat_pendidikan->arsip_ijazah);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $pathToYourFile2 = public_path('upload/arsip_transkrip_nilai/'.$riwayat_pendidikan->arsip_transkrip_nilai);
        if(file_exists($pathToYourFile2))
        {
            unlink($pathToYourFile2);
        }

        $riwayat_pendidikan->delete();
       
        $pendidikan = RiwayatPendidikan::where('pegawai_id',$id)->orderBy('jenis_pendidikan','DESC')->limit(1)->get()->toArray();
        
        if($pendidikan){
            $pegawai = Pegawai::find($id);
            $pegawai->pendidikan = $pendidikan[0]->tingkat;
        } else {
            $pegawai = Pegawai::find($id);
            $pegawai->pendidikan = '';
        }
        
    	$pegawai->save();

        return redirect('/riwayat_pendidikan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
