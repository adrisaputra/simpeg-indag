<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAnak extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_anak_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_anak',
        'tempat_lahir',
        'tanggal_lahir',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
