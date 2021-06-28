<?php

namespace App\Http\Controllers;

use App\Models\RiwayatOrangTua;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatOrangTuaController extends Controller
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

         $riwayat_orang_tua = RiwayatOrangTua::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         return view('admin.riwayat_orang_tua.index',compact('riwayat_orang_tua','pegawai'));
     }
 
     ## Tampilkan Data Search
     public function search(Request $request, $id)
     {
         $riwayat_orang_tua = $request->get('search');

         if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

         $riwayat_orang_tua = RiwayatOrangTua::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_orang_tua) {
                                $query->where('orang_tua', 'LIKE', '%'.$riwayat_orang_tua.'%')
                                    ->orWhere('nama_orang_tua', 'LIKE', '%'.$riwayat_orang_tua.'%')
                                    ->orWhere('tanggal_lahir', 'LIKE', '%'.$riwayat_orang_tua.'%')
                                    ->orWhere('pekerjaan', 'LIKE', '%'.$riwayat_orang_tua.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
         return view('admin.riwayat_orang_tua.index',compact('riwayat_orang_tua','pegawai'));
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

		$view=view('admin.riwayat_orang_tua.create',compact('pegawai'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store($id, Request $request)
    {
        $this->validate($request, [
            'orang_tua' => 'required',
            'nama_orang_tua' => 'required',
            'kartu_keluarga' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

		$input['pegawai_id'] = $id;
		$input['orang_tua'] = $request->orang_tua;
		$input['nama_orang_tua'] = $request->nama_orang_tua;
		$input['tanggal_lahir'] = $request->tanggal_lahir;
		$input['pekerjaan'] = $request->pekerjaan;
        
		if($request->file('kartu_keluarga')){
			$input['kartu_keluarga'] = time().'.'.$request->kartu_keluarga->getClientOriginalExtension();
			$request->kartu_keluarga->move(public_path('upload/kartu_keluarga'), $input['kartu_keluarga']);
    	}	
		
		$input['user_id'] = Auth::user()->id;
		
        RiwayatOrangTua::create($input);

		return redirect('/riwayat_orang_tua/'.$id)->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($id, RiwayatOrangTua $riwayat_orang_tua)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $view=view('admin.riwayat_orang_tua.edit', compact('pegawai','riwayat_orang_tua'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, $id, RiwayatOrangTua $riwayat_orang_tua)
    {
        $this->validate($request, [
            'orang_tua' => 'required',
            'nama_orang_tua' => 'required',
            'kartu_keluarga' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('kartu_keluarga') && $riwayat_orang_tua->kartu_keluarga){
            $pathToYourFile = public_path('upload/kartu_keluarga/'.$riwayat_orang_tua->kartu_keluarga);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_orang_tua->fill($request->all());
       
        if($request->file('kartu_keluarga')){
            $filename = time().'.'.$request->kartu_keluarga->getClientOriginalExtension();
            $request->kartu_keluarga->move(public_path('upload/kartu_keluarga'), $filename);
            $riwayat_orang_tua->kartu_keluarga = $filename;
		}

		$riwayat_orang_tua->user_id = Auth::user()->id;
    	$riwayat_orang_tua->save();
		
		return redirect('/riwayat_orang_tua/'.$id)->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete($id, RiwayatOrangTua $riwayat_orang_tua)
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('id',$id)->get();
            $pegawai->toArray();
        } else {
            $id = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->value('id');
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
        }

        $pathToYourFile = public_path('upload/kartu_keluarga/'.$riwayat_orang_tua->kartu_keluarga);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

		$riwayat_orang_tua->delete();
		
        return redirect('/riwayat_orang_tua/'.$id)->with('status', 'Data Berhasil Dihapus');
    }


}
