<?php

namespace App\Http\Controllers;

use App\Models\RiwayatKaryaIlmiah;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatKaryaIlmiahController extends Controller
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

        $riwayat_karya_ilmiah = RiwayatKaryaIlmiah::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_karya_ilmiah.index',compact('riwayat_karya_ilmiah','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_karya_ilmiah = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_karya_ilmiah = RiwayatKaryaIlmiah::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_karya_ilmiah) {
                                $query->where('jenis_buku', 'LIKE', '%'.$riwayat_karya_ilmiah.'%')
                                    ->orWhere('judul_buku', 'LIKE', '%'.$riwayat_karya_ilmiah.'%')
                                    ->orWhere('jenis_kegiatan', 'LIKE', '%'.$riwayat_karya_ilmiah.'%')
                                    ->orWhere('peranan', 'LIKE', '%'.$riwayat_karya_ilmiah.'%')
                                    ->orWhere('tahun', 'LIKE', '%'.$riwayat_karya_ilmiah.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_karya_ilmiah.index',compact('riwayat_karya_ilmiah','pegawai'));
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

        $view=view('admin.riwayat_karya_ilmiah.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'jenis_buku' => 'required',
            'judul_buku' => 'required',
            'jenis_kegiatan' => 'required',
            'peranan' => 'required',
            'tahun' => 'required|numeric',
            'arsip_karya_ilmiah' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['jenis_buku'] = $request->jenis_buku;
        $input['judul_buku'] = $request->judul_buku;
        $input['jenis_kegiatan'] = $request->jenis_kegiatan;
        $input['peranan'] = $request->peranan;
        $input['tahun'] = $request->tahun;
        
        if($request->file('arsip_karya_ilmiah')){
            $input['arsip_karya_ilmiah'] = time().'.'.$request->arsip_karya_ilmiah->getClientOriginalExtension();
            $request->arsip_karya_ilmiah->move(public_path('upload/arsip_karya_ilmiah'), $input['arsip_karya_ilmiah']);
        }	
        
        $input['user_id'] = Auth::user()->id;
       
        RiwayatKaryaIlmiah::create($input);

        return redirect('/riwayat_karya_ilmiah/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatKaryaIlmiah $riwayat_karya_ilmiah)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_karya_ilmiah.edit', compact('pegawai','riwayat_karya_ilmiah'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatKaryaIlmiah $riwayat_karya_ilmiah)
   {
        $this->validate($request, [
            'jenis_buku' => 'required',
            'judul_buku' => 'required',
            'jenis_kegiatan' => 'required',
            'peranan' => 'required',
            'tahun' => 'required|numeric',
            'arsip_karya_ilmiah' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);
        
        if($request->file('arsip_karya_ilmiah') && $riwayat_karya_ilmiah->arsip_karya_ilmiah){
            $pathToYourFile = public_path('upload/arsip_karya_ilmiah/'.$riwayat_karya_ilmiah->arsip_karya_ilmiah);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_karya_ilmiah->fill($request->all());
       
        if($request->file('arsip_karya_ilmiah')){
            $filename = time().'.'.$request->arsip_karya_ilmiah->getClientOriginalExtension();
            $request->arsip_karya_ilmiah->move(public_path('upload/arsip_karya_ilmiah'), $filename);
            $riwayat_karya_ilmiah->arsip_karya_ilmiah = $filename;
        }

        $riwayat_karya_ilmiah->user_id = Auth::user()->id;
        $riwayat_karya_ilmiah->save();
       
        return redirect('/riwayat_karya_ilmiah/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatKaryaIlmiah $riwayat_karya_ilmiah)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_karya_ilmiah/'.$riwayat_karya_ilmiah->arsip_karya_ilmiah);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_karya_ilmiah->delete();
       
        return redirect('/riwayat_karya_ilmiah/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
