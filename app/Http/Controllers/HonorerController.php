<?php

namespace App\Http\Controllers;

use App\Models\Honorer;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HonorerController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Pegawai Honorer";
		$honorer = DB::table('honorer_tbl')->orderBy('id','DESC')->paginate(10);
		return view('admin.honorer.index',compact('title','honorer'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Pegawai Honorer";
        $honorer = $request->get('search');
		$honorer = Honorer::
                where(function ($query) use ($honorer) {
                    $query->where('nama_pegawai', 'LIKE', '%'.$honorer.'%')
                        ->orWhere('tempat_lahir', 'LIKE', '%'.$honorer.'%')
                        ->orWhere('tanggal_lahir', 'LIKE', '%'.$honorer.'%')
                        ->orWhere('jenis_kelamin', 'LIKE', '%'.$honorer.'%')
                        ->orWhere('agama', 'LIKE', '%'.$honorer.'%')
                        ->orWhere('gol_darah', 'LIKE', '%'.$honorer.'%')
                        ->orWhere('email', 'LIKE', '%'.$honorer.'%')
                        ->orWhere('pendidikan', 'LIKE', '%'.$honorer.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.honorer.index',compact('title','honorer'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Pegawai Honorer";
        $view=view('admin.honorer.create', compact('title'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
		$this->validate($request, [
            'nama_pegawai' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'email' => 'email'
		]);

        $input['nama_pegawai'] = $request->nama_pegawai;
        $input['tempat_lahir'] = $request->tempat_lahir;
        $input['tanggal_lahir'] = $request->tanggal_lahir;
        $input['jenis_kelamin'] = $request->jenis_kelamin;
        $input['alamat'] = $request->alamat;
        $input['agama'] = $request->agama;
        $input['gol_darah'] = $request->gol_darah;
        $input['email'] = $request->email;
        $input['pendidikan'] = $request->pendidikan;
        $input['user_id'] = Auth::user()->id;

        Honorer::create($input);
		
		return redirect('/honorer')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(Honorer $honorer)
    {
        $title = "Pegawai Honorer";
        $view=view('admin.honorer.edit', compact('title','honorer'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, Honorer $honorer)
    {
		$this->validate($request, [
            'nama_pegawai' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'email' => 'email'
		]);
		
        $honorer->fill($request->all());
        $honorer->user_id = Auth::user()->id;
        $honorer->save();
    
		return redirect('/honorer')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Honorer $honorer)
    {
		$honorer->delete();
		
		return redirect('/honorer')->with('status', 'Data Berhasil Dihapus');
    }
}
