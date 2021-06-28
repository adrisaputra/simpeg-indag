<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKompetensi;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatKompetensiController extends Controller
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

        $riwayat_kompetensi = RiwayatKompetensi::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_kompetensi.index',compact('riwayat_kompetensi','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_kompetensi = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_kompetensi = RiwayatKompetensi::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_kompetensi) {
                                $query->where('nama_kegiatan', 'LIKE', '%'.$riwayat_kompetensi.'%')
                                    ->orWhere('tanggal', 'LIKE', '%'.$riwayat_kompetensi.'%')
                                    ->orWhere('tempat', 'LIKE', '%'.$riwayat_kompetensi.'%')
                                    ->orWhere('angkatan', 'LIKE', '%'.$riwayat_kompetensi.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_kompetensi.index',compact('riwayat_kompetensi','pegawai'));
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

        $view=view('admin.riwayat_kompetensi.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'nama_kegiatan' => 'required',
            'tanggal' => 'required',
            'tempat' => 'required',
            'angkatan' => 'required',
            'arsip_kompetensi' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['nama_kegiatan'] = $request->nama_kegiatan;
        $input['tanggal'] = $request->tanggal;
        $input['tempat'] = $request->tempat;
        $input['angkatan'] = $request->angkatan;

		if($request->file('arsip_kompetensi')){
			$input['arsip_kompetensi'] = time().'.'.$request->arsip_kompetensi->getClientOriginalExtension();
			$request->arsip_kompetensi->move(public_path('upload/arsip_kompetensi'), $input['arsip_kompetensi']);
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatKompetensi::create($input);

        return redirect('/riwayat_kompetensi/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatKompetensi $riwayat_kompetensi)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_kompetensi.edit', compact('pegawai','riwayat_kompetensi'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatKompetensi $riwayat_kompetensi)
   {
        $this->validate($request, [
            'nama_kegiatan' => 'required',
            'tanggal' => 'required',
            'tempat' => 'required',
            'angkatan' => 'required',
            'arsip_kompetensi' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);
        
        if($request->file('arsip_kompetensi') && $riwayat_kompetensi->arsip_kompetensi){
            $pathToYourFile = public_path('upload/arsip_kompetensi/'.$riwayat_kompetensi->arsip_kompetensi);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_kompetensi->fill($request->all());
       
        if($request->file('arsip_kompetensi')){
            $filename = time().'.'.$request->arsip_kompetensi->getClientOriginalExtension();
            $request->arsip_kompetensi->move(public_path('upload/arsip_kompetensi'), $filename);
            $riwayat_kompetensi->arsip_kompetensi = $filename;
		}

        $riwayat_kompetensi->user_id = Auth::user()->id;
        $riwayat_kompetensi->save();
       
        return redirect('/riwayat_kompetensi/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKompetensi $riwayat_kompetensi)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_kompetensi/'.$riwayat_kompetensi->arsip_kompetensi);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_kompetensi->delete();
       
        return redirect('/riwayat_kompetensi/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
