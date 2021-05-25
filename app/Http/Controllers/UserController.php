<?php

namespace App\Http\Controllers;

use App\Models\User;   //nama model
use App\Models\Bidang;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; //untuk membuat query di controller
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    ## Cek Login
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    ## Tampikan Data
    public function index()
    {
		$user = DB::table('users')->orderBy('id','DESC')->paginate(10);
		return view('admin.user.index',compact('user'));
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
        $bidang = Bidang::get();
        $view=view('admin.user.create',compact('bidang'));
        $view=$view->render();
        return $view;
    }
	
	## Simpan Data
	public function store(Request $request)
    {
		$this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'group' => 'required'
		]);
		
        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->password);
        $input['group'] = $request->group;
        if($request->group==2){
            $input['bidang_id'] = $request->bidang_id;
        }
        User::create($input);
		
		return redirect('/user')->with('status','Data Tersimpan');

    }
	
	## Tampilkan Form Edit
    public function edit(User $user)
    {
        $bidang = Bidang::get();
        $view=view('admin.user.edit', compact('user','bidang'));
        $view=$view->render();
		return $view;
    }
	
	## Edit Data
    public function update(Request $request, User $user)
    {
		if($request->password){
			$this->validate($request, [
				'name' => 'required|string|max:255',
				'password' => 'required|string|min:8|confirmed'
			]);
		} else {
			$this->validate($request, [
				'name' => 'required|string|max:255'
			]);
		}
         
		if($request->password){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->group = $request->group;
            if($request->group==4){
                $input['seksi'] = $request->seksi;
            }
		} else {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->group = $request->group;
            if($request->group==4){
                $input['seksi'] = $request->seksi;
            }
        }
        $user->save();
        
		return redirect('/user')->with('status', 'Data Berhasil Diubah');
    }

    ## Hapus Data
    public function delete(User $user)
    {
        $id = $user->id;
		$user->delete();
		
		return redirect('/user')->with('status', 'Data Berhasil Dihapus');
    }
}
