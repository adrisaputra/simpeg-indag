<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTugasLuarNegeri extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_tugas_luar_negeri_tbl';
	protected $fillable =[
        'pegawai_id',
        'tujuan',
        'tanggal_mulai',
        'tanggal_selesai',
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
