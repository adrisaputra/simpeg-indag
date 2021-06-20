<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;   //nama model
use App\Models\Honorer;   //nama model
use App\Models\Absen;   //nama model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
        if(Auth::user()->group==1){
            $pegawai = Pegawai::where('status_hapus', 0)->count();
            $honorer = Honorer::count();
            return view('admin.beranda', compact('pegawai','honorer'));
        } else if(Auth::user()->group==3){
            $count = Absen::where('nip', Auth::user()->name)->where('tanggal', date('Y-m-d'))->count();
            $status_kehadiran = Absen::where('nip', Auth::user()->name)->where('tanggal', date('Y-m-d'))->get();
            return view('admin.beranda', compact('count','status_kehadiran'));
        }
        
    }
}
