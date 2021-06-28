<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKgb;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatKgbController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_kgb = RiwayatKgb::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_kgb.index',compact('riwayat_kgb','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_kgb = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_kgb = RiwayatKgb::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_kgb) {
                                $query->where('dasar', 'LIKE', '%'.$riwayat_kgb.'%')
                                    ->orWhere('gaji_lama', 'LIKE', '%'.$riwayat_kgb.'%')
                                    ->orWhere('gaji_baru', 'LIKE', '%'.$riwayat_kgb.'%')
                                    ->orWhere('kgb_terakhir', 'LIKE', '%'.$riwayat_kgb.'%')
                                    ->orWhere('kgb_saat_ini', 'LIKE', '%'.$riwayat_kgb.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_kgb.index',compact('riwayat_kgb','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_kgb.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'dasar' => 'required',
            'gaji_lama' => 'required',
            'gaji_baru' => 'required',
            'kgb_terakhir' => 'required',
            'kgb_saat_ini' => 'required',
            'arsip_kgb' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['dasar'] = $request->dasar;
        $input['gaji_lama'] = str_replace(".", "", $request->gaji_lama);
        $input['gaji_baru'] = str_replace(".", "", $request->gaji_baru);
        $input['kgb_terakhir'] = $request->kgb_terakhir;
        $input['kgb_saat_ini'] = $request->kgb_saat_ini;

		if($request->file('arsip_kgb')){
			$input['arsip_kgb'] = time().'.'.$request->arsip_kgb->getClientOriginalExtension();
			$request->arsip_kgb->move(public_path('upload/arsip_kgb'), $input['arsip_kgb']);
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatKgb::create($input);

        $kgb_saat_ini = RiwayatKgb::where('pegawai_id',$id)->orderBy('kgb_saat_ini','DESC')->limit(1)->get();
        $kgb_saat_ini->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->kgb_saat_ini = $kgb_saat_ini[0]->kgb_saat_ini;
        $pegawai->save();
        
        return redirect('/riwayat_kgb/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatKgb $riwayat_kgb)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_kgb.edit', compact('pegawai','riwayat_kgb'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatKgb $riwayat_kgb)
   {
        $this->validate($request, [
            'dasar' => 'required',
            'gaji_lama' => 'required',
            'gaji_baru' => 'required',
            'kgb_terakhir' => 'required',
            'kgb_saat_ini' => 'required',
            'arsip_kgb' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);
        
        if($request->file('arsip_kgb') && $riwayat_kgb->arsip_kgb){
            $pathToYourFile = public_path('upload/arsip_kgb/'.$riwayat_kgb->arsip_kgb);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_kgb->fill($request->all());
       
        if($request->file('arsip_kgb')){
            $filename = time().'.'.$request->arsip_kgb->getClientOriginalExtension();
            $request->arsip_kgb->move(public_path('upload/arsip_kgb'), $filename);
            $riwayat_kgb->arsip_kgb = $filename;
		}

        $riwayat_kgb->gaji_lama = str_replace(".", "", $request->gaji_lama);
        $riwayat_kgb->gaji_baru = str_replace(".", "", $request->gaji_baru);
        $riwayat_kgb->user_id = Auth::user()->id;
        $riwayat_kgb->save();
       
        $kgb_saat_ini = RiwayatKgb::where('pegawai_id',$id)->orderBy('kgb_saat_ini','DESC')->limit(1)->get();
        $kgb_saat_ini->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->kgb_saat_ini = $kgb_saat_ini[0]->kgb_saat_ini;
    	$pegawai->save();

        return redirect('/riwayat_kgb/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKgb $riwayat_kgb)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        if($riwayat_kgb->arsip_kgb){
            $pathToYourFile = public_path('upload/arsip_kgb/'.$riwayat_kgb->arsip_kgb);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_kgb->delete();
       
        $kgb_saat_ini = RiwayatKgb::where('pegawai_id',$id)->orderBy('kgb_saat_ini','DESC')->limit(1)->get();
        $kgb_saat_ini->toArray();
        
        if(count($kgb_saat_ini)>0){
            $pegawai = Pegawai::find($id);
            $pegawai->kgb_saat_ini = $kgb_saat_ini[0]->kgb_saat_ini;
            echo "a";
        } else {
            $pegawai = Pegawai::find($id);
            $pegawai->kgb_saat_ini = '';
            echo "b";
        }

        $pegawai->save();
        

        return redirect('/riwayat_kgb/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
