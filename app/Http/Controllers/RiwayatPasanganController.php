<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPasangan;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatPasanganController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_pasangan = RiwayatPasangan::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_pasangan.index',compact('riwayat_pasangan','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_pasangan = $request->get('search');
        $riwayat_pasangan = RiwayatPasangan::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_pasangan) {
                                $query->where('nama_pasangan', 'LIKE', '%'.$riwayat_pasangan.'%')
                                    ->orWhere('tanggal_lahir', 'LIKE', '%'.$riwayat_pasangan.'%')
                                    ->orWhere('status', 'LIKE', '%'.$riwayat_pasangan.'%')
                                    ->orWhere('tanggal_nikah', 'LIKE', '%'.$riwayat_pasangan.'%')
                                    ->orWhere('tanggal_cerai', 'LIKE', '%'.$riwayat_pasangan.'%')
                                    ->orWhere('tanggal_meninggal', 'LIKE', '%'.$riwayat_pasangan.'%')
                                    ->orWhere('pekerjaan', 'LIKE', '%'.$riwayat_pasangan.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_pasangan.index',compact('riwayat_pasangan','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
       $pegawai = Pegawai::where('id',$id)->get();
       $pegawai->toArray();
       $view=view('admin.riwayat_pasangan.create',compact('pegawai'));
       $view=$view->render();
       return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'nama_pasangan' => 'required',
            'tanggal_lahir' => 'required',
            'status' => 'required',
            'tanggal_nikah' => 'required',
            'surat_nikah' => 'mimes:jpg,jpeg,png,pdf|max:500',
            'surat_cerai' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['nama_pasangan'] = $request->nama_pasangan;
        $input['tanggal_lahir'] = $request->tanggal_lahir;
        $input['status'] = $request->status;
        $input['tanggal_nikah'] = $request->tanggal_nikah;
        $input['tanggal_cerai'] = $request->tanggal_cerai;
        $input['tanggal_meninggal'] = $request->tanggal_meninggal;
        $input['pekerjaan'] = $request->pekerjaan;
       
		if($request->file('surat_nikah')){
			$input['surat_nikah'] = time().'.'.$request->surat_nikah->getClientOriginalExtension();
			$request->surat_nikah->move(public_path('upload/surat_nikah'), $input['surat_nikah']);
    	}	
		
		if($request->file('surat_cerai')){
			$input['surat_cerai'] = time().'.'.$request->surat_cerai->getClientOriginalExtension();
			$request->surat_cerai->move(public_path('upload/surat_cerai'), $input['surat_cerai']);
    	}	
		
        $input['user_id'] = Auth::user()->id;

        RiwayatPasangan::create($input);

        return redirect('/riwayat_pasangan/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatPasangan $riwayat_pasangan)
   {
       $pegawai = Pegawai::where('id',$id)->get();
       $pegawai->toArray();
       $view=view('admin.riwayat_pasangan.edit', compact('pegawai','riwayat_pasangan'));
       $view=$view->render();
       return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatPasangan $riwayat_pasangan)
   {
        $this->validate($request, [
            'nama_pasangan' => 'required',
            'tanggal_lahir' => 'required',
            'status' => 'required',
            'tanggal_nikah' => 'required',
            'surat_nikah' => 'mimes:jpg,jpeg,png,pdf|max:500',
            'surat_cerai' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('surat_nikah') && $riwayat_pasangan->surat_nikah){
            $pathToYourFile = public_path('upload/surat_nikah/'.$riwayat_pasangan->surat_nikah);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        if($request->file('surat_cerai') && $riwayat_pasangan->surat_cerai){
            $pathToYourFile = public_path('upload/surat_cerai/'.$riwayat_pasangan->surat_cerai);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_pasangan->fill($request->all());
        
        if($request->file('surat_nikah')){
            $filename = time().'.'.$request->surat_nikah->getClientOriginalExtension();
            $request->surat_nikah->move(public_path('upload/surat_nikah'), $filename);
            $riwayat_pasangan->surat_nikah = $filename;
		}

        if($request->file('surat_cerai')){
            $filename = time().'.'.$request->surat_cerai->getClientOriginalExtension();
            $request->surat_cerai->move(public_path('upload/surat_cerai'), $filename);
            $riwayat_pasangan->surat_cerai = $filename;
		}

        $riwayat_pasangan->user_id = Auth::user()->id;
        $riwayat_pasangan->save();
        
        return redirect('/riwayat_pasangan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatPasangan $riwayat_pasangan)
   {
        $pathToYourFile = public_path('upload/surat_nikah/'.$riwayat_pasangan->surat_nikah);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $pathToYourFile2 = public_path('upload/surat_cerai/'.$riwayat_pasangan->surat_cerai);
        if(file_exists($pathToYourFile2))
        {
            unlink($pathToYourFile2);
        }

        $riwayat_pasangan->delete();
       
        return redirect('/riwayat_pasangan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
