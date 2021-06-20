<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;   //nama model
use App\Models\Jabatan;   //nama model
use App\Models\Bidang;   //nama model
use App\Models\Seksi;   //nama model
use App\Models\User;   //nama model
use App\Models\RiwayatKepangkatan;   //nama model
use App\Models\RiwayatGaji;   //nama model
use App\Models\RiwayatKgb;   //nama model
use App\Imports\PegawaiImport;     // Import data Pegawai
use Maatwebsite\Excel\Facades\Excel; // Excel Library
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class PegawaiController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        if(Auth::user()->group==1){

            $pegawai = Pegawai::where('status_hapus', 0)->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
        
            $i=0;
            foreach($pegawai as $v){ 
                $absen = DB::table('absen_tbl')->where('pegawai_id',$v->id)->where('tanggal',date('Y-m-d'))->get()->toArray();
                if(count($absen)>0){
                    $status_kehadiran[$i] = $absen[0]->kehadiran;
                } else {
                    $status_kehadiran[$i] = "Belum Absen";       
                } 
                $i++;
            }	

            return view('admin.pegawai.index',compact('pegawai','status_kehadiran'));

        } else if(Auth::user()->group==3){
            $pegawai = DB::table('pegawai_tbl')->where('nip',Auth::user()->name)->orderBy('id','DESC')->get()->toArray();
            return view('admin.pegawai.index2',compact('pegawai'));
        }
    }

	## Tampilkan Data Search
	public function search(Request $request)
    {
        $pegawai = $request->get('search');
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('status_hapus', 0)
            ->where(function ($query) use ($pegawai) {
                $query->where('nip', 'LIKE', '%'.$pegawai.'%')
                    ->orWhere('nama_pegawai', 'LIKE', '%'.$pegawai.'%')
                    ->orWhere('golongan', 'LIKE', '%'.$pegawai.'%');
            })
            ->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
        } else if(Auth::user()->group==2){
            $pegawai = Pegawai::where('bidang_id', Auth::user()->bidang_id)->where('status_hapus', 0)->where('nama_pegawai', 'LIKE', '%'.$pegawai.'%')->orderBy('jabatan_id','ASC')->paginate(25)->onEachSide(1);
        }
        
        $i=0;
        if(count($pegawai)>0){
            foreach($pegawai as $v){ 
                $absen = DB::table('absen_tbl')->where('pegawai_id',$v->id)->where('tanggal',date('Y-m-d'))->get()->toArray();
                if(count($absen)>0){
                    $status_kehadiran[$i] = $absen[0]->kehadiran;
                } else {
                    $status_kehadiran[$i] = "Belum Absen";       
                } 
                $i++;
            }
        } else {
            $status_kehadiran[0] = "Belum Absen";   
        }	
        return view('admin.pegawai.index',compact('pegawai','status_kehadiran'));
    }
	
    ## Tampilkan Form Create
    public function create()
    {
        $jabatan = jabatan::get();
        $bidang = Bidang::get();
        $seksi = Seksi::get();
		$view=view('admin.pegawai.create', compact('jabatan','bidang','seksi'));
        $view=$view->render();
        return $view;
    }

    ## Simpan Data
    public function store(Request $request)
    {
        $this->validate($request, [
            'nip' => 'required|unique:pegawai_tbl|numeric|digits:18',
            'nama_pegawai' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'jabatan_id' => 'required',
            'bidang_id' => 'required',
            'seksi_id' => 'required_if:jabatan_id,4|required_if:jabatan_id,5|required_if:jabatan_id,7',
            'status' => 'required',
			'foto_formal' => 'mimes:jpg,jpeg,png|max:500',
			'foto_kedinasan' => 'mimes:jpg,jpeg,png|max:500',
            'no_ktp' => 'required|digits:16',
			'ktp' => 'mimes:jpg,jpeg,png|max:500',
            'no_bpjs' => 'required',
			'bpjs' => 'mimes:jpg,jpeg,png|max:500',
            'no_npwp' => 'required',
			'npwp' => 'mimes:jpg,jpeg,png|max:500',
            'no_karpeg' => 'required',
			'karpeg' => 'mimes:jpg,jpeg,png|max:500',
            'no_karsu' => 'required',
			'karsu' => 'mimes:jpg,jpeg,png|max:500'
        ]);

		$input['nip'] = $request->nip;
		$input['nama_pegawai'] = $request->nama_pegawai;
		$input['tempat_lahir'] = $request->tempat_lahir;
		$input['tanggal_lahir'] = $request->tanggal_lahir;
		$input['jenis_kelamin'] = $request->jenis_kelamin;
		$input['alamat'] = $request->alamat;
		$input['agama'] = $request->agama;
		$input['gol_darah'] = $request->gol_darah;
		$input['no_ktp'] = $request->no_ktp;
        $input['no_bpjs'] = $request->no_bpjs;
        $input['no_npwp'] = $request->no_npwp;
        $input['no_karpeg'] = $request->no_karpeg;
        $input['no_karsu'] = $request->no_karsu;
        $input['email'] = $request->email;
        $input['status'] = $request->status;
        $input['jabatan_id'] = $request->jabatan_id;
        if($request->jabatan_id==3 || $request->jabatan_id==5){
            $input['bidang_id'] = $request->bidang_id;
        }
        else if($request->jabatan_id==4){
            $input['seksi_id'] = $request->seksi_id;
        }
        else if($request->jabatan_id==7){
            $input['bidang_id'] = $request->bidang_id;
            $input['seksi_id'] = $request->seksi_id;
        }
        
		if($request->file('foto_formal')){
            $input['foto_formal'] = time().'.'.$request->file('foto_formal')->getClientOriginalExtension();
 
            $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai', $input['foto_formal']);
            $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai/thumbnail', $input['foto_formal']);
     
            $thumbnailpath = public_path('storage/upload/foto_formal_pegawai/thumbnail/'.$input['foto_formal']);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
        }
        
		if($request->file('foto_kedinasan')){
            $input['foto_kedinasan'] = time().'.'.$request->file('foto_kedinasan')->getClientOriginalExtension();
 
            $request->file('foto_kedinasan')->storeAs('public/upload/foto_kedinasan_pegawai', $input['foto_kedinasan']);
            $request->file('foto_kedinasan')->storeAs('public/upload/foto_kedinasan_pegawai/thumbnail', $input['foto_kedinasan']);
     
            $thumbnailpath = public_path('storage/upload/foto_kedinasan_pegawai/thumbnail/'.$input['foto_kedinasan']);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
        }
        
		if($request->file('ktp')){
            $input['ktp'] = time().'.'.$request->file('ktp')->getClientOriginalExtension();
 
            $request->file('ktp')->storeAs('public/upload/ktp', $input['ktp']);
            $request->file('ktp')->storeAs('public/upload/ktp/thumbnail', $input['ktp']);
     
            $thumbnailpath = public_path('storage/upload/ktp/thumbnail/'.$input['ktp']);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
        }
        
		if($request->file('bpjs')){
            $input['bpjs'] = time().'.'.$request->file('bpjs')->getClientOriginalExtension();
 
            $request->file('bpjs')->storeAs('public/upload/bpjs', $input['bpjs']);
            $request->file('bpjs')->storeAs('public/upload/bpjs/thumbnail', $input['bpjs']);
     
            $thumbnailpath = public_path('storage/upload/bpjs/thumbnail/'.$input['bpjs']);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
        }
        
		if($request->file('npwp')){
            $input['npwp'] = time().'.'.$request->file('npwp')->getClientOriginalExtension();
 
            $request->file('npwp')->storeAs('public/upload/npwp', $input['npwp']);
            $request->file('npwp')->storeAs('public/upload/npwp/thumbnail', $input['npwp']);
     
            $thumbnailpath = public_path('storage/upload/npwp/thumbnail/'.$input['npwp']);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
        }
        
		if($request->file('karpeg')){
            $input['karpeg'] = time().'.'.$request->file('karpeg')->getClientOriginalExtension();
 
            $request->file('karpeg')->storeAs('public/upload/karpeg', $input['karpeg']);
            $request->file('karpeg')->storeAs('public/upload/karpeg/thumbnail', $input['karpeg']);
     
            $thumbnailpath = public_path('storage/upload/karpeg/thumbnail/'.$input['karpeg']);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
        }
        
		if($request->file('karsu')){
            $input['karsu'] = time().'.'.$request->file('karsu')->getClientOriginalExtension();
 
            $request->file('karsu')->storeAs('public/upload/karsu', $input['karsu']);
            $request->file('karsu')->storeAs('public/upload/karsu/thumbnail', $input['karsu']);
     
            $thumbnailpath = public_path('storage/upload/karsu/thumbnail/'.$input['karsu']);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);
        }
        
		$input['user_id'] = Auth::user()->id;
		
        Pegawai::create($input);
        
		$input2['name'] = $request->nip;
		$input2['email'] = $request->nip.'@gmail.com';
		$input2['password'] = Hash::make($request->nip);
		$input2['group'] = 3;
        User::create($input2);
        
        
		return redirect('/pegawai')->with('status','Data Tersimpan');
    }

    ## Tampilkan Form Edit
    public function edit(Pegawai $pegawai)
    {
        $jabatan = jabatan::get();
        $bidang = Bidang::get();
        $seksi = Seksi::get();
        $view=view('admin.pegawai.edit', compact('pegawai','jabatan','bidang','seksi'));
        $view=$view->render();
        return $view;
    }

    ## Edit Data
    public function update(Request $request, Pegawai $pegawai)
    {
        $this->validate($request, [
            'nip' => 'required|numeric|digits:18',
            'nama_pegawai' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'jabatan_id' => 'required',
            'bidang_id' => 'required',
            'seksi_id' => 'required_if:jabatan_id,4|required_if:jabatan_id,5|required_if:jabatan_id,7',
            'status' => 'required',
			'foto_formal' => 'mimes:jpg,jpeg,png|max:500',
			'foto_kedinasan' => 'mimes:jpg,jpeg,png|max:500',
            'no_ktp' => 'required|digits:16',
			'ktp' => 'mimes:jpg,jpeg,png|max:500',
            'no_bpjs' => 'required',
			'bpjs' => 'mimes:jpg,jpeg,png|max:500',
            'no_npwp' => 'required',
			'npwp' => 'mimes:jpg,jpeg,png|max:500',
            'no_karpeg' => 'required',
			'karpeg' => 'mimes:jpg,jpeg,png|max:500',
            'no_karsu' => 'required',
			'karsu' => 'mimes:jpg,jpeg,png|max:500'
        ]);

        if($pegawai->foto_formal && $request->file('foto_formal')!=""){
            $image_path = public_path().'/storage/upload/foto_formal_pegawai/thumbnail/'.$pegawai->foto_formal;
            $image_path2 = public_path().'/storage/upload/foto_formal_pegawai/'.$pegawai->foto_formal;
            unlink($image_path);
            unlink($image_path2);
        }

        if($pegawai->foto_kedinasan && $request->file('foto_kedinasan')!=""){
            $image_path = public_path().'/storage/upload/foto_kedinasan_pegawai/thumbnail/'.$pegawai->foto_kedinasan;
            $image_path2 = public_path().'/storage/upload/foto_kedinasan_pegawai/'.$pegawai->foto_kedinasan;
            unlink($image_path);
            unlink($image_path2);
        }

        if($pegawai->ktp && $request->file('ktp')!=""){
            $image_path3 = public_path().'/storage/upload/ktp/thumbnail/'.$pegawai->ktp;
            $image_path4 = public_path().'/storage/upload/ktp/'.$pegawai->ktp;
            unlink($image_path3);
            unlink($image_path4);
        }

        if($pegawai->bpjs && $request->file('bpjs')!=""){
            $image_path5 = public_path().'/storage/upload/bpjs/thumbnail/'.$pegawai->bpjs;
            $image_path6 = public_path().'/storage/upload/bpjs/'.$pegawai->bpjs;
            unlink($image_path5);
            unlink($image_path6);
        }

        if($pegawai->npwp && $request->file('npwp')!=""){
            $image_path7 = public_path().'/storage/upload/npwp/thumbnail/'.$pegawai->npwp;
            $image_path8 = public_path().'/storage/upload/npwp/'.$pegawai->npwp;
            unlink($image_path7);
            unlink($image_path8);
        }

        if($pegawai->karpeg && $request->file('karpeg')!=""){
            $image_path9 = public_path().'/storage/upload/karpeg/thumbnail/'.$pegawai->karpeg;
            $image_path10 = public_path().'/storage/upload/karpeg/'.$pegawai->karpeg;
            unlink($image_path9);
            unlink($image_path10);
        }

        if($pegawai->karsu && $request->file('karsu')!=""){
            $image_path11 = public_path().'/storage/upload/karsu/thumbnail/'.$pegawai->karsu;
            $image_path12 = public_path().'/storage/upload/karsu/'.$pegawai->karsu;
            unlink($image_path11);
            unlink($image_path12);
        }

        $pegawai->fill($request->all());
        
		if($request->file('foto_formal')){

            $filename = time().'.'.$request->file('foto_formal')->getClientOriginalExtension();
           
            $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai', $filename);
            $request->file('foto_formal')->storeAs('public/upload/foto_formal_pegawai/thumbnail', $filename);
     
            $thumbnailpath = public_path('storage/upload/foto_formal_pegawai/thumbnail/'.$filename);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $pegawai->foto_formal = $filename;
        }
        
		if($request->file('ktp')){

            $filename = time().'.'.$request->file('ktp')->getClientOriginalExtension();
           
            $request->file('ktp')->storeAs('public/upload/ktp', $filename);
            $request->file('ktp')->storeAs('public/upload/ktp/thumbnail', $filename);
     
            $thumbnailpath = public_path('storage/upload/ktp/thumbnail/'.$filename);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $pegawai->ktp = $filename;
        }
        
		if($request->file('bpjs')){

            $filename = time().'.'.$request->file('bpjs')->getClientOriginalExtension();
           
            $request->file('bpjs')->storeAs('public/upload/bpjs', $filename);
            $request->file('bpjs')->storeAs('public/upload/bpjs/thumbnail', $filename);
     
            $thumbnailpath = public_path('storage/upload/bpjs/thumbnail/'.$filename);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $pegawai->bpjs = $filename;
        }
        
		if($request->file('npwp')){

            $filename = time().'.'.$request->file('npwp')->getClientOriginalExtension();
           
            $request->file('npwp')->storeAs('public/upload/npwp', $filename);
            $request->file('npwp')->storeAs('public/upload/npwp/thumbnail', $filename);
     
            $thumbnailpath = public_path('storage/upload/npwp/thumbnail/'.$filename);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $pegawai->npwp = $filename;
        }
        
		if($request->file('karpeg')){

            $filename = time().'.'.$request->file('karpeg')->getClientOriginalExtension();
           
            $request->file('karpeg')->storeAs('public/upload/karpeg', $filename);
            $request->file('karpeg')->storeAs('public/upload/karpeg/thumbnail', $filename);
     
            $thumbnailpath = public_path('storage/upload/karpeg/thumbnail/'.$filename);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $pegawai->karpeg = $filename;
        }
        
		if($request->file('karsu')){

            $filename = time().'.'.$request->file('karsu')->getClientOriginalExtension();
           
            $request->file('karsu')->storeAs('public/upload/karsu', $filename);
            $request->file('karsu')->storeAs('public/upload/karsu/thumbnail', $filename);
     
            $thumbnailpath = public_path('storage/upload/karsu/thumbnail/'.$filename);
            $img = Image::make($thumbnailpath)->resize(400, 150, function($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($thumbnailpath);

            $pegawai->karsu = $filename;
        }
        
        if($request->jabatan_id==4 || $request->jabatan_id==5 || $request->jabatan_id==7 || $request->jabatan_id==8){
            $pegawai->bidang_id = $request->bidang_id;
            if(!$request->seksi_id){
                $pegawai->seksi_id = 0;
            } else {
                $pegawai->seksi_id = $request->seksi_id;
            }
        } else {
            $pegawai->seksi_id = 0;
        }
		$pegawai->user_id = Auth::user()->id;
    	$pegawai->save();
		
		return redirect('/pegawai')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Pegawai $pegawai)
    {
        if(Request()->segment(2)=='pensiun'){
            $pegawai->status_hapus = 1;
        } else if(Request()->segment(1)=='meninggal'){
            $pegawai->status_hapus = 2;
        } else if(Request()->segment(2)=='pindah_tugas'){
            $pegawai->status_hapus = 3;
        } 
        $pegawai->user_id = Auth::user()->id;
    	$pegawai->save();

        return redirect('/pegawai')->with('status', 'Data Berhasil Dihapus');
    }

    public function import_excel(Request $request) 
	{
		// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move('file_pegawai',$nama_file);
 
		// import data
		Excel::import(new PegawaiImport, public_path('/file_pegawai/'.$nama_file));
 
        return redirect('/pegawai')->with('status', 'Data Pegawai Berhasil Diimport');
	}

    public function naik_pangkat()
    {
        $title = "Naik Pangkat";

        $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
        $pegawai->toArray();

        $pangkat = RiwayatKepangkatan::where('pegawai_id',$pegawai[0]->id)->orderBy('jenis_golongan','DESC')->get();
        $pangkat->toArray();

        if(count($pangkat)>0){
            $naikpangkat = RiwayatKepangkatan::select('*', DB::raw("tmt + INTERVAL '4' YEAR AS naikpangkat_berikutnya"), DB::raw(" DATEDIFF(tmt + INTERVAL '4' YEAR,CURDATE()) as hari"))
                            ->where('pegawai_id',$pegawai[0]->id)->where('jenis_golongan',$pangkat[0]->jenis_golongan)->get();	
            $naikpangkat->toArray();	

            if($naikpangkat[0]->golongan=="Golongan I/a"){
                $golongan_selanjutnya = "Golongan I/b";
            } else if($naikpangkat[0]->golongan=="Golongan I/b"){
                $golongan_selanjutnya = "Golongan I/c";
            } else if($naikpangkat[0]->golongan=="Golongan I/c"){
                $golongan_selanjutnya = "Golongan I/d";
            } else if($naikpangkat[0]->golongan=="Golongan I/d"){
                $golongan_selanjutnya = "Golongan II/a";
            } else if($naikpangkat[0]->golongan=="Golongan II/a"){
                $golongan_selanjutnya = "Golongan II/b";
            } else if($naikpangkat[0]->golongan=="Golongan II/b"){
                $golongan_selanjutnya = "Golongan II/c";
            } else if($naikpangkat[0]->golongan=="Golongan II/c"){
                $golongan_selanjutnya = "Golongan II/d";
            } else if($naikpangkat[0]->golongan=="Golongan II/d"){
                $golongan_selanjutnya = "Golongan III/a";
            } else if($naikpangkat[0]->golongan=="Golongan III/a"){
                $golongan_selanjutnya = "Golongan III/b";
            } else if($naikpangkat[0]->golongan=="Golongan III/b"){
                $golongan_selanjutnya = "Golongan III/c";
            } else if($naikpangkat[0]->golongan=="Golongan III/c"){
                $golongan_selanjutnya = "Golongan III/d";
            } else if($naikpangkat[0]->golongan=="Golongan III/d"){
                $golongan_selanjutnya = "Golongan IV/a";
            } else if($naikpangkat[0]->golongan=="Golongan IV/a"){
                $golongan_selanjutnya = "Golongan IV/b";
            } else if($naikpangkat[0]->golongan=="Golongan IV/b"){
                $golongan_selanjutnya = "Golongan IV/c";
            } else if($naikpangkat[0]->golongan=="Golongan IV/c"){
                $golongan_selanjutnya = "Golongan IV/d";
            } else if($naikpangkat[0]->golongan=="Golongan IV/d"){
                $golongan_selanjutnya = "Golongan IV/e";
            } 
        } else {
            $naikpangkat[0]="Tidak ada";
            $golongan_selanjutnya="Tidak ada";
        } 
        return view('admin.pegawai.naik_pangkat',compact('title','pegawai','naikpangkat','golongan_selanjutnya'));
    }

    public function pensiun()
    {
        $title = "Pensiun";

        $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
        $pegawai->toArray();

        $pensiun = Pegawai::select('*', DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) AS umur'), DB::raw("tanggal_lahir + INTERVAL '60' YEAR AS pensiun"))
                         ->where('nip',Auth::user()->name)->get();	
        $pensiun->toArray();	

        return view('admin.pegawai.pensiun',compact('title','pegawai','pensiun'));
    }

    public function kgb()
    {
        $title = "Kenaikan Gaji Berkala";

        if(Auth::user()->group==1){

            $pegawai = Pegawai::where('status_hapus', 0)
                    ->whereRaw('YEAR(kgb_saat_ini) = YEAR(DATE_SUB(CURDATE(), INTERVAL 2 YEAR))')
                    ->paginate(25)->onEachSide(1);
            
            $i=0;
            if(count($pegawai)>0){
                foreach($pegawai as $v){ 
                    $gaji[$i] = DB::table('riwayat_kgb_tbl')->where('pegawai_id',$v->id)->orderBy('kgb_saat_ini','DESC')->count();
                    
                    if($gaji[$i]>0){
                        $kgb = RiwayatKgb::select('*', DB::raw("kgb_saat_ini + INTERVAL '2' YEAR AS kgb_berikutnya"), DB::raw(" DATEDIFF(kgb_saat_ini + INTERVAL '2' YEAR,CURDATE()) as hari"))
                                     ->where('pegawai_id',$v->id)->orderBy('kgb_saat_ini','DESC')->get();	
                        $kgb->toArray();	
                        $kgb_terakhir[$i] = $kgb[0]->kgb_saat_ini;
                        $kgb_saat_ini[$i] = $kgb[0]->kgb_saat_ini;
                        $kgb_berikutnya[$i] = $kgb[0]->kgb_berikutnya;
                    } else {
                        $kgb_terakhir[$i] = "Tidak ada";   
                        $kgb_saat_ini[$i] = "Tidak ada";   
                        $kgb_berikutnya[$i] = "Tidak ada";   
                    } 
                    $i++;
                }	
            } else {
                $gaji[0]="0";
                $kgb_terakhir[0] = "Tidak ada";   
                $kgb_saat_ini[0] = "Tidak ada";   
                $kgb_berikutnya[0] = "Tidak ada";  
            }
            

        } else {
            $pegawai = Pegawai::where('nip',Auth::user()->name)->get();
            $pegawai->toArray();
    
            $gaji = RiwayatGaji::where('pegawai_id',$pegawai[0]->id)->orderBy('jenis_golongan','DESC')->get();
            $gaji->toArray();
    
            if(count($gaji)>0){
                $kgb = RiwayatGaji::select('*', DB::raw("tmt + INTERVAL '2' YEAR AS kgb_berikutnya"), DB::raw(" DATEDIFF(tmt + INTERVAL '2' YEAR,CURDATE()) as hari"))
                                 ->where('pegawai_id',$pegawai[0]->id)->where('jenis_golongan',$gaji[0]->jenis_golongan)->get();	
                $kgb->toArray();	
            } else {
                $kgb[0]="Tidak ada";
            } 
        }
        
        return view('admin.pegawai.kgb',compact('title','pegawai','gaji','kgb_terakhir','kgb_saat_ini','kgb_berikutnya',));
    }

    
}
