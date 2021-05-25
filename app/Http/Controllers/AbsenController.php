<?php

namespace App\Http\Controllers;

use App\Models\Absen;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AbsenController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = 'ABSENSI';
        $cek_absen = DB::table('absen_tbl')->where('bidang_id', Auth::user()->bidang_id)->groupBy('tanggal')->orderBy('tanggal','DESC')->get()->toArray();
        $absen = Absen::where('bidang_id', Auth::user()->bidang_id)->groupBy('tanggal')->orderBy('tanggal','DESC')->paginate(25)->onEachSide(1);
        return view('admin.absen.index',compact('cek_absen','title','absen'));
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $user = $request->get('search');
		$user = User::where('name', 'LIKE', '%'.$user.'%')->orderBy('id','DESC')->paginate(10);
		return view('admin.user.index',compact('user'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = 'ABSENSI';
        $pegawai = Pegawai::where('bidang_id', Auth::user()->bidang_id)->where('status_hapus', 0)->orderBy('id','DESC')->get();
        $view=view('admin.absen.create',compact('title','pegawai'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $count = count($request->pegawai_id);
        $n = 0;
        for($i=0;$i<$count;$i++) {
            $input['pegawai_id'] = $request->pegawai_id[$i];
            $input['nip'] = $request->nip[$i];
            $input['nama_pegawai'] = $request->nama_pegawai[$i];
            $input['bidang_id'] = Auth::user()->bidang_id;
            $input['kehadiran'] = $request->kehadiran[$i];

            $input['keterangan'] = $request->keterangan[$i];
            if($request->kehadiran[$i]=='H'){
                $input['jam_datang'] = $request->jam_datang[$i];
                if(date('H:i:s')>="16:00:00" && date('H:i:s')<="17:00:00"){
                    $input['jam_pulang'] = $request->jam_pulang[$i];
                }
            }
            else {
                $input['jam_datang'] = "";
                if(date('H:i:s')>="16:00:00" && date('H:i:s')<="17:00:00"){
                    $input['jam_pulang'] = $request->jam_pulang[$i];
                }
            }
            
            $input['tanggal'] = date('Y-m-d');
            $input['user_id'] = Auth::user()->id;
            Absen::create($input);
        }

    }

    ## Simpan Data
    public function buat_absen()
    {
        $pegawai = Pegawai::where('bidang_id', Auth::user()->bidang_id)->where('status_hapus', 0)->orderBy('id','DESC')->get();
        foreach($pegawai as $v){
            $input['pegawai_id'] = $v->id;
            $input['nip'] = $v->nip;
            $input['nama_pegawai'] = $v->nama_pegawai;
            $input['bidang_id'] = Auth::user()->bidang_id;
            $input['tanggal'] = date('Y-m-d');
            $input['user_id'] = Auth::user()->id;
            Absen::create($input);
        }
        
        return redirect('/absen')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit($tanggal)
    {
        $title = 'ABSENSI';
        $absen = Absen::where('bidang_id', Auth::user()->bidang_id)->where('tanggal',$tanggal)->get();
        $view=view('admin.absen.edit', compact('title','absen'));
        $view=$view->render();
		return $view;
    }

    ## Edit Data
    public function update(Request $request)
    {

        $count = count($request->pegawai_id);
        $n = 0;
        for($i=0;$i<$count;$i++) {

            DB::table('absen_tbl')
            ->where('pegawai_id', $request->pegawai_id[$i])
            ->where('tanggal', $request->tanggal[$i])
            ->delete();
        
            $input['pegawai_id'] = $request->pegawai_id[$i];
            $input['nip'] = $request->nip[$i];
            $input['nama_pegawai'] = $request->nama_pegawai[$i];
            $input['bidang_id'] = Auth::user()->bidang_id;
            $input['kehadiran'] = $request->kehadiran[$i];

            $input['keterangan'] = $request->keterangan[$i];
            if($request->kehadiran[$i]=='H'){
                $input['jam_datang'] = $request->jam_datang[$i];
                if(date('H:i:s')>="16:00:00" && date('H:i:s')<="17:00:00"){
                    $input['jam_pulang'] = $request->jam_pulang[$i];
                }
            }
            else {
                $input['jam_datang'] = "";
                if(date('H:i:s')>="16:00:00" && date('H:i:s')<="17:00:00"){
                    $input['jam_pulang'] ="";
                }
            }
            
            $input['tanggal'] = $request->tanggal[$i];
            $input['user_id'] = Auth::user()->id;
            Absen::create($input);
        }
        
		return redirect('/absen')->with('status', 'Data Berhasil Diubah');
    }
	
}
