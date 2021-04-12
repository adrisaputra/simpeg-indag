<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatDiklat extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_diklat_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_diklat',
        'diklat',
        'nama_diklat',
        'tempat',
        'penyelenggara',
        'no_sertifikat',
        'tanggal_sertifikat',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam',
        'angkatan',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
