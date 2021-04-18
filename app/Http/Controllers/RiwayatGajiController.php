<?php

namespace App\Http\Controllers;

use App\Models\RiwayatGaji;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatGajiController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_gaji = RiwayatGaji::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_gaji.index',compact('riwayat_gaji','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_gaji = $request->get('search');
        $riwayat_gaji = RiwayatGaji::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_gaji) {
                                $query->where('jenis_golongan', 'LIKE', '%'.$riwayat_gaji.'%')
                                ->orWhere('golongan', 'LIKE', '%'.$riwayat_gaji.'%')
                                ->orWhere('nama_pangkat', 'LIKE', '%'.$riwayat_gaji.'%')
                                ->orWhere('masa_kerja', 'LIKE', '%'.$riwayat_gaji.'%')
                                ->orWhere('tmt', 'LIKE', '%'.$riwayat_gaji.'%')
                                ->orWhere('gaji', 'LIKE', '%'.$riwayat_gaji.'%')
                                ->orWhere('sk_pejabat', 'LIKE', '%'.$riwayat_gaji.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_gaji.index',compact('riwayat_gaji','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_gaji.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'golongan' => 'required',
            'masa_kerja' => 'required|numeric',
            'tmt' => 'required',
            'gaji' => 'required',
            'sk_pejabat' => 'required',
            'arsip_gaji' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
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

        $input['masa_kerja'] = $request->masa_kerja;
        $input['tmt'] = $request->tmt;
        $input['gaji'] = str_replace(".", "", $request->gaji);
        $input['sk_pejabat'] = $request->sk_pejabat;

        if($request->file('arsip_gaji')){
            $input['arsip_gaji'] = time().'.'.$request->arsip_gaji->getClientOriginalExtension();
            $request->arsip_gaji->move(public_path('upload/arsip_gaji'), $input['arsip_gaji']);
        }	
		
        $input['user_id'] = Auth::user()->id;
    
        RiwayatGaji::create($input);

        return redirect('/riwayat_gaji/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatGaji $riwayat_gaji)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_gaji.edit', compact('pegawai','riwayat_gaji'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatGaji $riwayat_gaji)
   {
        $this->validate($request, [
            'golongan' => 'required',
            'masa_kerja' => 'required|numeric',
            'tmt' => 'required',
            'gaji' => 'required',
            'sk_pejabat' => 'required',
            'arsip_gaji' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('arsip_gaji') && $riwayat_gaji->arsip_gaji){
            $pathToYourFile = public_path('upload/arsip_gaji/'.$riwayat_gaji->arsip_gaji);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_gaji->fill($request->all());

        if($request->golongan=="Golongan I/a"){
            $riwayat_gaji->jenis_golongan = 1;
            $riwayat_gaji->nama_pangkat = 'Juru Muda';
        } else if($request->golongan=="Golongan I/b"){
            $riwayat_gaji->jenis_golongan = 2;
            $riwayat_gaji->nama_pangkat = 'Juru Muda Tingkat 1';
        } else if($request->golongan=="Golongan I/c"){
            $riwayat_gaji->jenis_golongan = 3;
            $riwayat_gaji->nama_pangkat = 'Juru';
        } else if($request->golongan=="Golongan I/d"){
            $riwayat_gaji->jenis_golongan = 4;
            $riwayat_gaji->nama_pangkat = 'Juru Tingkat 1';
        } else if($request->golongan=="Golongan II/a"){
            $riwayat_gaji->jenis_golongan = 5;
            $riwayat_gaji->nama_pangkat = 'Pengatur Muda';
        } else if($request->golongan=="Golongan II/b"){
            $riwayat_gaji->jenis_golongan = 6;
            $riwayat_gaji->nama_pangkat = 'Pengatur Muda Tingkat 1';
        } else if($request->golongan=="Golongan II/c"){
            $riwayat_gaji->jenis_golongan = 7;
            $riwayat_gaji->nama_pangkat = 'Pengatur';
        } else if($request->golongan=="Golongan II/d"){
            $riwayat_gaji->jenis_golongan = 8;
            $riwayat_gaji->nama_pangkat = 'Pengatur Tingkat 1';
        } else if($request->golongan=="Golongan III/a"){
            $riwayat_gaji->jenis_golongan = 9;
            $riwayat_gaji->nama_pangkat = 'Penata Muda';
        } else if($request->golongan=="Golongan III/b"){
            $riwayat_gaji->jenis_golongan = 10;
            $riwayat_gaji->nama_pangkat = 'Penata Muda Tingkat 1';
        } else if($request->golongan=="Golongan III/c"){
            $riwayat_gaji->jenis_golongan = 11;
            $riwayat_gaji->nama_pangkat = 'Penata';
        } else if($request->golongan=="Golongan III/d"){
            $riwayat_gaji->jenis_golongan = 12;
            $riwayat_gaji->nama_pangkat = 'Penata Tingkat 1';
        } else if($request->golongan=="Golongan IV/a"){
            $riwayat_gaji->jenis_golongan = 13;
            $riwayat_gaji->nama_pangkat = 'Pembina';
        } else if($request->golongan=="Golongan IV/b"){
            $riwayat_gaji->jenis_golongan = 14;
            $riwayat_gaji->nama_pangkat = 'Pembina Tingkat 1';
        } else if($request->golongan=="Golongan IV/c"){
            $riwayat_gaji->jenis_golongan = 15;
            $riwayat_gaji->nama_pangkat = 'Pembina Utama Muda';
        } else if($request->golongan=="Golongan IV/d"){
            $riwayat_gaji->jenis_golongan = 16;
            $riwayat_gaji->nama_pangkat = 'Pembina Utama Madya';
        } else if($request->golongan=="Golongan IV/e"){
            $riwayat_gaji->jenis_golongan = 17;
            $riwayat_gaji->nama_pangkat = 'Pembina Utama';
        }   

        if($request->file('arsip_gaji')){
            $filename = time().'.'.$request->arsip_gaji->getClientOriginalExtension();
            $request->arsip_gaji->move(public_path('upload/arsip_gaji'), $filename);
            $riwayat_gaji->arsip_gaji = $filename;
		}

        
        $riwayat_gaji->gaji = str_replace(".", "", $request->gaji);
        $riwayat_gaji->user_id = Auth::user()->id;
        $riwayat_gaji->save();
    
        return redirect('/riwayat_gaji/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatGaji $riwayat_gaji)
   {
        $pathToYourFile = public_path('upload/arsip_gaji/'.$riwayat_gaji->arsip_gaji);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_gaji->delete();
       
        return redirect('/riwayat_gaji/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
