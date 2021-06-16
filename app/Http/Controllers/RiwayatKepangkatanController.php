<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKepangkatan;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatKepangkatanController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_kepangkatan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_kepangkatan.index',compact('riwayat_kepangkatan','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_kepangkatan = $request->get('search');
        $riwayat_kepangkatan = RiwayatKepangkatan::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_kepangkatan) {
                                $query->where('periode_kp', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('golongan', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('status', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('nama_pangkat', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('tmt', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('mk_tahun', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('mk_bulan', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('no_sk', 'LIKE', '%'.$riwayat_kepangkatan.'%')
                                    ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_kepangkatan.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_kepangkatan.index',compact('riwayat_kepangkatan','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_kepangkatan.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'periode_kp' => 'required',
            'periode_kp_sebelumnya' => 'required',
            'periode_kp_saat_ini' => 'required',
            'golongan' => 'required',
            'tmt' => 'required',
            'mk_bulan' => 'required|numeric',
            'mk_tahun' => 'required|numeric',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'pejabat' => 'required',
            'arsip_kepangkatan' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['periode_kp'] = $request->periode_kp;
        $input['periode_kp_sebelumnya'] = $request->periode_kp_sebelumnya;
        $input['periode_kp_saat_ini'] = $request->periode_kp_saat_ini;
        $input['golongan'] = $request->golongan;
        if($request->golongan=="Golongan I/a"){
            $input['jenis_golongan'] = 1;
            $input['nama_pangkat'] = 'Juru Muda';
        } else if($request->golongan=="Golongan I/b"){
            $input['jenis_golongan'] = 2;
            $input['nama_pangkat'] = 'Juru Muda  Tingkat 1';
        } else if($request->golongan=="Golongan I/c"){
            $input['jenis_golongan'] = 3;
            $input['nama_pangkat'] = 'Juru';
        } else if($request->golongan=="Golongan I/d"){
            $input['jenis_golongan'] = 4;
            $input['nama_pangkat'] = 'Juru Tingkat 1';
        } else if($request->golongan=="Golongan II/a"){
            $input['jenis_golongan'] = 5;
            $input['nama_pangkat'] = 'Pengatur Muda';
        } else if($request->golongan=="Golongan II/b"){
            $input['jenis_golongan'] = 6;
            $input['nama_pangkat'] = 'Pengatur Muda Tingkat 1';
        } else if($request->golongan=="Golongan II/c"){
            $input['jenis_golongan'] = 7;
            $input['nama_pangkat'] = 'Pengatur';
        } else if($request->golongan=="Golongan II/d"){
            $input['jenis_golongan'] = 8;
            $input['nama_pangkat'] = 'Pengatur Tingkat 1';
        } else if($request->golongan=="Golongan III/a"){
            $input['jenis_golongan'] = 9;
            $input['nama_pangkat'] = 'Penata Muda';
        } else if($request->golongan=="Golongan III/b"){
            $input['jenis_golongan'] = 10;
            $input['nama_pangkat'] = 'Penata Muda Tingkat 1';
        } else if($request->golongan=="Golongan III/c"){
            $input['jenis_golongan'] = 11;
            $input['nama_pangkat'] = 'Penata';
        } else if($request->golongan=="Golongan III/d"){
            $input['jenis_golongan'] = 12;
            $input['nama_pangkat'] = 'Penata Tingkat 1';
        } else if($request->golongan=="Golongan IV/a"){
            $input['jenis_golongan'] = 13;
            $input['nama_pangkat'] = 'Pembina';
        } else if($request->golongan=="Golongan IV/b"){
            $input['jenis_golongan'] = 14;
            $input['nama_pangkat'] = 'Pembina Tingkat 1';
        } else if($request->golongan=="Golongan IV/c"){
            $input['jenis_golongan'] = 15;
            $input['nama_pangkat'] = 'Pembina Utama Muda';
        } else if($request->golongan=="Golongan IV/d"){
            $input['jenis_golongan'] = 16;
            $input['nama_pangkat'] = 'Pembina Utama Madya';
        }  else if($request->golongan=="Golongan IV/e"){
            $input['jenis_golongan'] = 17;
            $input['nama_pangkat'] = 'Pembina Utama';
        }   

        $input['tmt'] = $request->tmt;
        $input['mk_tahun'] = $request->mk_tahun;
        $input['mk_bulan'] = $request->mk_bulan;
        $input['no_sk'] = $request->no_sk;
        $input['tanggal_sk'] = $request->tanggal_sk;
        $input['pejabat'] = $request->pejabat;

		if($request->file('arsip_kepangkatan')){
			$input['arsip_kepangkatan'] = time().'.'.$request->arsip_kepangkatan->getClientOriginalExtension();
			$request->arsip_kepangkatan->move(public_path('upload/arsip_kepangkatan'), $input['arsip_kepangkatan']);
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatKepangkatan::create($input);

        $golongan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('jenis_golongan','DESC')->limit(1)->get();
        $golongan->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->golongan = $golongan[0]->golongan;
        $pegawai->save();
        
        return redirect('/riwayat_kepangkatan/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatKepangkatan $riwayat_kepangkatan)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_kepangkatan.edit', compact('pegawai','riwayat_kepangkatan'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatKepangkatan $riwayat_kepangkatan)
   {
        $this->validate($request, [
            'periode_kp' => 'required',
            'golongan' => 'required',
            'tmt' => 'required',
            'mk_bulan' => 'required|numeric',
            'mk_tahun' => 'required|numeric',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'pejabat' => 'required',
            'arsip_kepangkatan' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);
        
        if($request->file('arsip_kepangkatan') && $riwayat_kepangkatan->arsip_kepangkatan){
            $pathToYourFile = public_path('upload/arsip_kepangkatan/'.$riwayat_kepangkatan->arsip_kepangkatan);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_kepangkatan->fill($request->all());
       
        if($request->golongan=="Golongan I/a"){
            $riwayat_kepangkatan->jenis_golongan = 1;
            $riwayat_kepangkatan->nama_pangkat = 'Juru Muda';
        } else if($request->golongan=="Golongan I/b"){
            $riwayat_kepangkatan->jenis_golongan = 2;
            $riwayat_kepangkatan->nama_pangkat = 'Juru Muda Tingkat 1';
        } else if($request->golongan=="Golongan I/c"){
            $riwayat_kepangkatan->jenis_golongan = 3;
            $riwayat_kepangkatan->nama_pangkat = 'Juru';
        } else if($request->golongan=="Golongan I/d"){
            $riwayat_kepangkatan->jenis_golongan = 4;
            $riwayat_kepangkatan->nama_pangkat = 'Juru Tingkat 1';
        } else if($request->golongan=="Golongan II/a"){
            $riwayat_kepangkatan->jenis_golongan = 5;
            $riwayat_kepangkatan->nama_pangkat = 'Pengatur Muda';
        } else if($request->golongan=="Golongan II/b"){
            $riwayat_kepangkatan->jenis_golongan = 6;
            $riwayat_kepangkatan->nama_pangkat = 'Pengatur Muda Tingkat 1';
        } else if($request->golongan=="Golongan II/c"){
            $riwayat_kepangkatan->jenis_golongan = 7;
            $riwayat_kepangkatan->nama_pangkat = 'Pengatur';
        } else if($request->golongan=="Golongan II/d"){
            $riwayat_kepangkatan->jenis_golongan = 8;
            $riwayat_kepangkatan->nama_pangkat = 'Pengatur Tingkat 1';
        } else if($request->golongan=="Golongan III/a"){
            $riwayat_kepangkatan->jenis_golongan = 9;
            $riwayat_kepangkatan->nama_pangkat = 'Penata Muda';
        } else if($request->golongan=="Golongan III/b"){
            $riwayat_kepangkatan->jenis_golongan = 10;
            $riwayat_kepangkatan->nama_pangkat = 'Penata Muda Tingkat 1';
        } else if($request->golongan=="Golongan III/c"){
            $riwayat_kepangkatan->jenis_golongan = 11;
            $riwayat_kepangkatan->nama_pangkat = 'Penata';
        } else if($request->golongan=="Golongan III/d"){
            $riwayat_kepangkatan->jenis_golongan = 12;
            $riwayat_kepangkatan->nama_pangkat = 'Penata Tingkat 1';
        } else if($request->golongan=="Golongan IV/a"){
            $riwayat_kepangkatan->jenis_golongan = 13;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina';
        } else if($request->golongan=="Golongan IV/b"){
            $riwayat_kepangkatan->jenis_golongan = 14;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina Tingkat 1';
        } else if($request->golongan=="Golongan IV/c"){
            $riwayat_kepangkatan->jenis_golongan = 15;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina Utama Muda';
        } else if($request->golongan=="Golongan IV/d"){
            $riwayat_kepangkatan->jenis_golongan = 16;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina Utama Madya';
        } else if($request->golongan=="Golongan IV/e"){
            $riwayat_kepangkatan->jenis_golongan = 17;
            $riwayat_kepangkatan->nama_pangkat = 'Pembina Utama';
        }   

        if($request->file('arsip_kepangkatan')){
            $filename = time().'.'.$request->arsip_kepangkatan->getClientOriginalExtension();
            $request->arsip_kepangkatan->move(public_path('upload/arsip_kepangkatan'), $filename);
            $riwayat_kepangkatan->arsip_kepangkatan = $filename;
		}

        $riwayat_kepangkatan->user_id = Auth::user()->id;
        $riwayat_kepangkatan->save();
       
        $golongan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('jenis_golongan','DESC')->limit(1)->get();
        $golongan->toArray();
        
        $pegawai = Pegawai::find($id);
        $pegawai->golongan = $golongan[0]->golongan;
    	$pegawai->save();

        return redirect('/riwayat_kepangkatan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKepangkatan $riwayat_kepangkatan)
   {
        if($riwayat_kepangkatan->arsip_kepangkatan){
            $pathToYourFile = public_path('upload/arsip_kepangkatan/'.$riwayat_kepangkatan->arsip_kepangkatan);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_kepangkatan->delete();
       
        $golongan = RiwayatKepangkatan::where('pegawai_id',$id)->orderBy('jenis_golongan','DESC')->limit(1)->get();
        $golongan->toArray();
        
        if(count($golongan)>0){
            
            if($golongan){
                $pegawai = Pegawai::find($id);
                $pegawai->golongan = $golongan[0]->golongan;
            } else {
                $pegawai = Pegawai::find($id);
                $pegawai->golongan = '';
            }

            $pegawai->save();
        
        }

        return redirect('/riwayat_kepangkatan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }

}