<?php

namespace App\Http\Controllers;

use App\Models\RiwayatPajak;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatPajakController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_pajak = RiwayatPajak::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_pajak.index',compact('riwayat_pajak','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_pajak = $request->get('search');
        $riwayat_pajak = RiwayatPajak::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_pajak) {
                                $query->where('nama_pajak', 'LIKE', '%'.$riwayat_pajak.'%')
                                    ->orWhere('tempat', 'LIKE', '%'.$riwayat_pajak.'%')
                                    ->orWhere('penyelenggara', 'LIKE', '%'.$riwayat_pajak.'%')
                                    ->orWhere('no_sertifikat', 'LIKE', '%'.$riwayat_pajak.'%')
                                    ->orWhere('tanggal_sertifikat', 'LIKE', '%'.$riwayat_pajak.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_pajak.index',compact('riwayat_pajak','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_pajak.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'no_npwp' => 'required',
            'jenis_spt' => 'required',
            'tahun' => 'required|numeric',
            'pembetulan' => 'required|numeric',
            'status' => 'required',
            'jumlah' => 'required|numeric',
            'arsip_spt' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

       $input['pegawai_id'] = $id;
       $input['no_npwp'] = $request->no_npwp;
       $input['jenis_spt'] = $request->jenis_spt;
       $input['tahun'] = $request->tahun;
       $input['pembetulan'] = $request->pembetulan;
       $input['status'] = $request->status;
       $input['jumlah'] = $request->jumlah;
       
       if($request->file('arsip_spt')){
            $input['arsip_spt'] = time().'.'.$request->arsip_spt->getClientOriginalExtension();
            $request->arsip_spt->move(public_path('upload/arsip_spt'), $input['arsip_spt']);
        }	
    
        $input['user_id'] = Auth::user()->id;
    
        RiwayatPajak::create($input);

        return redirect('/riwayat_pajak/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatPajak $riwayat_pajak)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_pajak.edit', compact('pegawai','riwayat_pajak'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatPajak $riwayat_pajak)
   {
        $this->validate($request, [
            'no_npwp' => 'required',
            'jenis_spt' => 'required',
            'tahun' => 'required|numeric',
            'pembetulan' => 'required|numeric',
            'status' => 'required',
            'jumlah' => 'required|numeric',
            'arsip_spt' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('arsip_spt') && $riwayat_pajak->arsip_spt){
            $pathToYourFile = public_path('upload/arsip_spt/'.$riwayat_pajak->arsip_spt);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $riwayat_pajak->fill($request->all());
       
        if($request->file('arsip_spt')){
            $filename = time().'.'.$request->arsip_spt->getClientOriginalExtension();
            $request->arsip_spt->move(public_path('upload/arsip_spt'), $filename);
            $riwayat_pajak->arsip_spt = $filename;
        }
        
        $riwayat_pajak->user_id = Auth::user()->id;
        $riwayat_pajak->save();
    
        return redirect('/riwayat_pajak/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatPajak $riwayat_pajak)
   {
        $pathToYourFile = public_path('upload/arsip_spt/'.$riwayat_pajak->arsip_spt);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }
        $riwayat_pajak->delete();
       
        return redirect('/riwayat_pajak/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
