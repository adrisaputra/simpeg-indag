<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAnak;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatAnakController extends Controller
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

        $riwayat_anak = RiwayatAnak::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);

        return view('admin.riwayat_anak.index',compact('riwayat_anak','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_anak = $request->get('search');
        
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $riwayat_anak = RiwayatAnak::where('pegawai_id',$id)
                        ->where(function ($query) use ($riwayat_anak) {
                            $query->where('nama_anak', 'LIKE', '%'.$riwayat_anak.'%')
                                ->orWhere('jenis_kelamin', 'LIKE', '%'.$riwayat_anak.'%')
                                ->orWhere('tanggal_lahir', 'LIKE', '%'.$riwayat_anak.'%')
                                ->orWhere('status', 'LIKE', '%'.$riwayat_anak.'%')
                                ->orWhere('pendidikan', 'LIKE', '%'.$riwayat_anak.'%');
                        })
                        ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        return view('admin.riwayat_anak.index',compact('riwayat_anak','pegawai'));
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

       $view=view('admin.riwayat_anak.create',compact('pegawai'));
       $view=$view->render();
       return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
       $this->validate($request, [
            'nama_anak' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'status' => 'required',
            'akta_kelahiran' => 'mimes:jpg,jpeg,png,pdf|max:500'
       ]);

       $input['pegawai_id'] = $id;
       $input['nama_anak'] = $request->nama_anak;
       $input['jenis_kelamin'] = $request->jenis_kelamin;
       $input['tanggal_lahir'] = $request->tanggal_lahir;
       $input['status'] = $request->status;
       $input['pendidikan'] = $request->pendidikan;
       
		if($request->file('akta_kelahiran')){
			$input['akta_kelahiran'] = time().'.'.$request->akta_kelahiran->getClientOriginalExtension();
			$request->akta_kelahiran->move(public_path('upload/akta_kelahiran'), $input['akta_kelahiran']);
    	}	
		
       $input['user_id'] = Auth::user()->id;
       
       RiwayatAnak::create($input);

       return redirect('/riwayat_anak/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatAnak $riwayat_anak)
   {
      
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

       $view=view('admin.riwayat_anak.edit', compact('pegawai','riwayat_anak'));
       $view=$view->render();
       return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatAnak $riwayat_anak)
   {
        $this->validate($request, [
            'nama_anak' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'status' => 'required',
            'akta_kelahiran' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('akta_kelahiran') && $riwayat_anak->akta_kelahiran){
            $pathToYourFile = public_path('upload/akta_kelahiran/'.$riwayat_anak->akta_kelahiran);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_anak->fill($request->all());
       
        if($request->file('akta_kelahiran')){
            $filename = time().'.'.$request->akta_kelahiran->getClientOriginalExtension();
            $request->akta_kelahiran->move(public_path('upload/akta_kelahiran'), $filename);
            $riwayat_anak->akta_kelahiran = $filename;
		}

        $riwayat_anak->user_id = Auth::user()->id;
        $riwayat_anak->save();
       
        return redirect('/riwayat_anak/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatAnak $riwayat_anak)
   {
        
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/akta_kelahiran/'.$riwayat_anak->akta_kelahiran);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_anak->delete();
       
        return redirect('/riwayat_anak/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
