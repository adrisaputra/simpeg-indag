<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;   //nama model
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
            $pns = Pegawai::where('status', 'PNS')->where('status_hapus', 0)->count();
            $cpns = Pegawai::where('status', 'CPNS')->where('status_hapus', 0)->count();
            return view('admin.beranda', compact('pegawai','pns','cpns'));
        } else if(Auth::user()->group==3){
            $status_kehadiran = Absen::where('nip', Auth::user()->name)->where('tanggal', date('Y-m-d'))->get();
            $status_kehadiran->toArray();
            return view('admin.beranda', compact('status_kehadiran'));
        }
        
    }
}
