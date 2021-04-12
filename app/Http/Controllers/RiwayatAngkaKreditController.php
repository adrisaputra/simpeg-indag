<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAngkaKredit;   //nama model
use App\Models\Pegawai;   //nama model
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RiwayatAngkaKreditController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    ## Tampikan Data
    public function index($id)
    {
        $riwayat_angka_kredit = RiwayatAngkaKredit::where('pegawai_id',$id)->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_angka_kredit.index',compact('riwayat_angka_kredit','pegawai'));
    }

    ## Tampilkan Data Search
    public function search(Request $request, $id)
    {
        $riwayat_angka_kredit = $request->get('search');
        $riwayat_angka_kredit = RiwayatAngkaKredit::where('pegawai_id',$id)
                            ->where(function ($query) use ($riwayat_angka_kredit) {
                                $query->where('jabatan', 'LIKE', '%'.$riwayat_angka_kredit.'%')
                                    ->orWhere('no_pak', 'LIKE', '%'.$riwayat_angka_kredit.'%')
                                    ->orWhere('tanggal_pak', 'LIKE', '%'.$riwayat_angka_kredit.'%')
                                    ->orWhere('pelaksanaan_tupok', 'LIKE', '%'.$riwayat_angka_kredit.'%')
                                    ->orWhere('pengembangan_profesi', 'LIKE', '%'.$riwayat_angka_kredit.'%')
                                    ->orWhere('unsur_penunjang', 'LIKE', '%'.$riwayat_angka_kredit.'%')
                                    ->orWhere('jumlah', 'LIKE', '%'.$riwayat_angka_kredit.'%')
                                    ->orWhere('tmt_angka_kredit', 'LIKE', '%'.$riwayat_angka_kredit.'%');
                            })
                            ->orderBy('id','DESC')->paginate(25)->onEachSide(1);
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        return view('admin.riwayat_angka_kredit.index',compact('riwayat_angka_kredit','pegawai'));
    }

   ## Tampilkan Form Create
   public function create($id)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_angka_kredit.create',compact('pegawai'));
        $view=$view->render();
        return $view;
   }

   ## Simpan Data
   public function store($id, Request $request)
   {
        $this->validate($request, [
            'jabatan' => 'required',
            'no_pak' => 'required',
            'tanggal_pak' => 'required',
            'pendidikan' => 'required|numeric',
            'pelaksanaan_tupok' => 'required|numeric',
            'pengembangan_profesi' => 'required|numeric',
            'unsur_penunjang' => 'required|numeric',
            'tmt_angka_kredit' => 'required',
            'sk' => 'required|mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        $input['pegawai_id'] = $id;
        $input['jabatan'] = $request->jabatan;
        $input['no_pak'] = $request->no_pak;
        $input['tanggal_pak'] = $request->tanggal_pak;
        $input['pendidikan'] = $request->pendidikan;
        $input['pelaksanaan_tupok'] = $request->pelaksanaan_tupok;
        $input['pengembangan_profesi'] = $request->pengembangan_profesi;
        $input['unsur_penunjang'] = $request->unsur_penunjang;
        $input['jumlah'] = $request->pendidikan+$request->pelaksanaan_tupok+$request->pengembangan_profesi+$request->unsur_penunjang;
        $input['tmt_angka_kredit'] = $request->tmt_angka_kredit;
        
		if($request->file('sk')){
			$input['sk'] = time().'.'.$request->sk->getClientOriginalExtension();
			$request->sk->move(public_path('upload/sk_angka_kredit'), $input['sk']);
    	}	
		
        $input['user_id'] = Auth::user()->id;
       
        RiwayatAngkaKredit::create($input);

        return redirect('/riwayat_angka_kredit/'.$id)->with('status','Data Tersimpan');
   }

   ## Tampilkan Form Edit
   public function edit($id, RiwayatAngkaKredit $riwayat_angka_kredit)
   {
        $pegawai = Pegawai::where('id',$id)->get();
        $pegawai->toArray();
        $view=view('admin.riwayat_angka_kredit.edit', compact('pegawai','riwayat_angka_kredit'));
        $view=$view->render();
        return $view;
   }

   ## Edit Data
   public function update(Request $request, $id, RiwayatAngkaKredit $riwayat_angka_kredit)
   {
        $this->validate($request, [
            'jabatan' => 'required',
            'no_pak' => 'required',
            'tanggal_pak' => 'required',
            'pendidikan' => 'required|numeric',
            'pelaksanaan_tupok' => 'required|numeric',
            'pengembangan_profesi' => 'required|numeric',
            'unsur_penunjang' => 'required|numeric',
            'tmt_angka_kredit' => 'required',
            'sk' => 'mimes:jpg,jpeg,png,pdf|max:500'
        ]);

        if($request->file('sk') && $riwayat_angka_kredit->sk){
            $pathToYourFile = public_path('upload/sk_angka_kredit/'.$riwayat_angka_kredit->sk);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
		}

        $riwayat_angka_kredit->fill($request->all());
       
        if($request->file('sk')){
            $filename = time().'.'.$request->sk->getClientOriginalExtension();
            $request->sk->move(public_path('upload/sk_angka_kredit'), $filename);
            $riwayat_angka_kredit->sk = $filename;
        }
        
        $riwayat_angka_kredit->jumlah = $request->pendidikan+$request->pelaksanaan_tupok+$request->pengembangan_profesi+$request->unsur_penunjang;
        $riwayat_angka_kredit->user_id = Auth::user()->id;
        $riwayat_angka_kredit->save();
       
        return redirect('/riwayat_angka_kredit/'.$id)->with('status', 'Data Berhasil Diubah');
   }

   ## Hapus Data
   public function delete($id, RiwayatAngkaKredit $riwayat_angka_kredit)
   {
        $pathToYourFile = public_path('upload/sk_angka_kredit/'.$riwayat_angka_kredit->sk);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

        $riwayat_angka_kredit->delete();
       
        return redirect('/riwayat_angka_kredit/'.$id)->with('status', 'Data Berhasil Dihapus');
   }
}
