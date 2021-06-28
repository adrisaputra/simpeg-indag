<?php

namespace App\Http\Controllers;

use App\Models\RiwayatLhkpn;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatLhkpnController extends Controller
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

        $riwayat_lhkpn = RiwayatLhkpn::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_lhkpn.index',compact('riwayat_lhkpn','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_lhkpn = $request->get('search');

        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_lhkpn = RiwayatLhkpn::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_lhkpn) {
                                $query->where('periode_kp', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('golongan', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('status', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('nama_pangkat', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('tmt_mulai', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('tmt_selesai', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('mk_tahun', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('mk_bulan', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('no_sk', 'LIKE', '%'.$riwayat_lhkpn.'%')
                                    ->orWhere('tanggal_sk', 'LIKE', '%'.$riwayat_lhkpn.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_lhkpn.index',compact('riwayat_lhkpn','pegawai'));
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

        $view=view('admin.riwayat_lhkpn.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'nama_lhkpn' => 'required',
            'tanggal_lapor' => 'required',
            'jenis_pelaporan' => 'required',
            'jabatan' => 'required',
            'status_laporan' => 'required',
            'arsip_lhkpn' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['nama_lhkpn'] = $request->nama_lhkpn;
        $input['tanggal_lapor'] = $request->tanggal_lapor;
        $input['jenis_pelaporan'] = $request->jenis_pelaporan;
        $input['jabatan'] = $request->jabatan;
        $input['status_laporan'] = $request->status_laporan;

		if($request->file('arsip_lhkpn')){
			$input['arsip_lhkpn'] = time().'.'.$request->arsip_lhkpn->getClientOriginalExtension();
			$request->arsip_lhkpn->move(public_path('upload/arsip_lhkpn'), $input['arsip_lhkpn']);
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatLhkpn::create($input);

        return redirect('/riwayat_lhkpn/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatLhkpn $riwayat_lhkpn)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_lhkpn.edit', compact('pegawai','riwayat_lhkpn'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatLhkpn $riwayat_lhkpn)
   {
        $this->validate($request, [
            'nama_lhkpn' => 'required',
            'tanggal_lapor' => 'required',
            'jenis_pelaporan' => 'required',
            'jabatan' => 'required',
            'status_laporan' => 'required',
            'arsip_lhkpn' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);
        
        if($request->file('arsip_lhkpn') && $riwayat_lhkpn->arsip_lhkpn){
            $pathToYourFile = public_path('upload/arsip_lhkpn/'.$riwayat_lhkpn->arsip_lhkpn);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_lhkpn->fill($request->all());
       
        if($request->file('arsip_lhkpn')){
            $filename = time().'.'.$request->arsip_lhkpn->getClientOriginalExtension();
            $request->arsip_lhkpn->move(public_path('upload/arsip_lhkpn'), $filename);
            $riwayat_lhkpn->arsip_lhkpn = $filename;
		}

        $riwayat_lhkpn->user_id = Auth::user()->id;
        $riwayat_lhkpn->save();
       
        return redirect('/riwayat_lhkpn/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatLhkpn $riwayat_lhkpn)
   {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/arsip_lhkpn/'.$riwayat_lhkpn->arsip_lhkpn);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_lhkpn->delete();
       
        return redirect('/riwayat_lhkpn/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
