<?php

namespace App\Http\Controllers;

use App\Models\RiwayatJabatan;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatJabatanController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_jabatan = RiwayatJabatan::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_jabatan.index',compact('riwayat_jabatan','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_jabatan = $request->get('search');
        $riwayat_jabatan = RiwayatJabatan::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_jabatan) {
                                $query->where('jabatan', 'LIKE', '%'.$riwayat_jabatan.'%')
                                    ->orWhere('nama_sekolah', 'LIKE', '%'.$riwayat_jabatan.'%')
                                    ->orWhere('jurusan', 'LIKE', '%'.$riwayat_jabatan.'%')
                                    ->orWhere('no_ijazah', 'LIKE', '%'.$riwayat_jabatan.'%')
                                    ->orWhere('tahun_ijazah', 'LIKE', '%'.$riwayat_jabatan.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_jabatan.index',compact('riwayat_jabatan','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_jabatan.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'status_mutasi_instansi' => 'required',
            'tipe_jabatan' => 'required',
            'jenjang' => 'required',
            'status_mutasi_pegawai' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'tmt_mulai' => 'required',
            'tmt_selesai' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'tunjangan' => 'required',
            'esselon' => 'required',
            'arsip_jabatan' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        // if($request->jabatan=="Struktural"){
        //    $input['jenis_jabatan'] = 1;
        // } else if($request->jabatan=="Fungsional Tertentu"){
        //    $input['jenis_jabatan'] = 2;
        // } else if($request->jabatan=="Fungsional Umum"){
        //    $input['jenis_jabatan'] = 3;
        // }   

        $input['status_mutasi_instansi'] = $request->status_mutasi_instansi;
        $input['tipe_jabatan'] = $request->tipe_jabatan;
        $input['jenjang'] = $request->jenjang;
        $input['status_mutasi_pegawai'] = $request->status_mutasi_pegawai;
        $input['jabatan'] = $request->jabatan;
        $input['status'] = $request->status;
        $input['instansi_asal'] = $request->instansi_asal;
        $input['tmt_mulai'] = $request->tmt_mulai;
        $input['tmt_selesai'] = $request->tmt_selesai;
        $input['no_sk'] = $request->no_sk;
        $input['tanggal_sk'] = $request->tanggal_sk;
        $input['tunjangan'] = str_replace(".", "", $request->tunjangan);
        $input['esselon'] = $request->esselon;
        $input['keterangan'] = $request->keterangan;
        
		if($request->file('arsip_jabatan')){
			$input['arsip_jabatan'] = time().'.'.$request->arsip_jabatan->getClientOriginalExtension();
			$request->arsip_jabatan->move(public_path('upload/arsip_jabatan'), $input['arsip_jabatan']);
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatJabatan::create($input);

        return redirect('/riwayat_jabatan/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatJabatan $riwayat_jabatan)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_jabatan.edit', compact('pegawai','riwayat_jabatan'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatJabatan $riwayat_jabatan)
   {
        $this->validate($request, [
            'status_mutasi_instansi' => 'required',
            'tipe_jabatan' => 'required',
            'jenjang' => 'required',
            'status_mutasi_pegawai' => 'required',
            'jabatan' => 'required',
            'status' => 'required',
            'tmt_mulai' => 'required',
            'tmt_selesai' => 'required',
            'no_sk' => 'required',
            'tanggal_sk' => 'required',
            'tunjangan' => 'required',
            'esselon' => 'required',
            'arsip_jabatan' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('arsip_jabatan') && $riwayat_jabatan->arsip_jabatan){
            $pathToYourFile = public_path('upload/arsip_jabatan/'.$riwayat_jabatan->arsip_jabatan);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_jabatan->fill($request->all());
       
		if($request->file('arsip_jabatan')){
            $filename = time().'.'.$request->arsip_jabatan->getClientOriginalExtension();
            $request->arsip_jabatan->move(public_path('upload/arsip_jabatan'), $filename);
            $riwayat_jabatan->arsip_jabatan = $filename;
		}
        $riwayat_jabatan->tunjangan = str_replace(".", "", $request->tunjangan);
        $riwayat_jabatan->user_id = Auth::user()->id;
        $riwayat_jabatan->save();
       
        return redirect('/riwayat_jabatan/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatJabatan $riwayat_jabatan)
   {
        $pathToYourFile = public_path('upload/arsip_jabatan/'.$riwayat_jabatan->arsip_jabatan);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_jabatan->delete();
       
        return redirect('/riwayat_jabatan/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
