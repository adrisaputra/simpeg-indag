<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatHukuman extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_hukuman_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_hukuman',
        'uraian_hukuman',
        'no_sk',
        'tanggal_sk',
        'pejabat',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
