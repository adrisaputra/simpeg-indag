<?php

namespace App\Http\Controllers;

use App\Models\RelasiBidang;   //nama model
use App\Models\Bidang;   //nama model
use Illuminate\Http\Request;

class BidangController extends Controller
{
    public function nama_bidang($jabatan_id)
    {
        $bidang = RelasiBidang::
                  where('jabatan_id',$jabatan_id)
                  ->orderBy('id','DESC')->get();

        echo "<option value=''> -PILIH BIDANG-</option>";
        foreach($bidang as $v ){
            echo "<option value='".$v->id."'>".$v->bidang->nama_bidang."</option>";
        }
    }
}
