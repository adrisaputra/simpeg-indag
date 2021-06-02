<?php

namespace App\Http\Controllers;

use App\Models\Arsip;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ArsipController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
        $title = "Arsip";
		$arsip = DB::table('arsip_tbl')->orderBy('id','DESC')->paginate(10);
		return view('admin.arsip.index',compact('title','arsip'));
    }
	
	## Tampilkan Data Search
	public function search(Request $request)
    {
        $title = "Arsip";
        $arsip = $request->get('search');
		$arsip = Arsip::
                where(function ($query) use ($arsip) {
                    $query->where('no_surat', 'LIKE', '%'.$arsip.'%')
                        ->orWhere('perihal', 'LIKE', '%'.$arsip.'%')
                        ->orWhere('tanggal', 'LIKE', '%'.$arsip.'%');
                })
                ->orderBy('id','DESC')->paginate(10);
		return view('admin.arsip.index',compact('title','arsip'));
    }
	
	## Tampilkan Form Create
	public function create()
    {
        $title = "Arsip";
        $view=view('admin.arsip.create', compact('title'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
		$this->validate($request, [
            'no_surat' => 'required',
            'tanggal' => 'required',
            'perihal' => 'required',
            'file_arsip' => 'required|mimes:pdf|max:500'
		]);
		
        $input['no_surat'] = $request->no_surat;
        $input['tanggal'] = $request->tanggal;
        $input['perihal'] = $request->perihal;

        if($request->file('file_arsip')){
            $input['file_arsip'] = time().'.'.$request->file_arsip->getClientOriginalExtension();
            $request->file_arsip->move(public_path('upload/file_arsip'), $input['file_arsip']);
        }	
		
        $input['user_id'] = Auth::user()->id;
        Arsip::create($input);
		
		return redirect('/arsip')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(Arsip $arsip)
    {
        $title = "Arsip";
        $view=view('admin.arsip.edit', compact('title','arsip'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, Arsip $arsip)
    {
		$this->validate($request, [
            'no_surat' => 'required',
            'tanggal' => 'required',
            'perihal' => 'required',
            'file_arsip' => 'mimes:pdf|max:500'
		]);
		
        if($request->file('file_arsip') && $arsip->file_arsip){
            $pathToYourFile = public_path('upload/file_arsip/'.$arsip->file_arsip);
            if(file_exists($pathToYourFile))
            {
                unlink($pathToYourFile);
            }
        }

        $arsip->fill($request->all());
       
        if($request->file('file_arsip')){
            $filename = time().'.'.$request->file_arsip->getClientOriginalExtension();
            $request->file_arsip->move(public_path('upload/file_arsip'), $filename);
            $arsip->file_arsip = $filename;
        }
        
        $arsip->user_id = Auth::user()->id;
        $arsip->save();
    
		return redirect('/arsip')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(Arsip $arsip)
    {
        $pathToYourFile = public_path('upload/file_arsip/'.$arsip->file_arsip);
        if(file_exists($pathToYourFile))
        {
            unlink($pathToYourFile);
        }

		$arsip->delete();
		
		return redirect('/arsip')->with('status', 'Data Berhasil Dihapus');
    }
}
