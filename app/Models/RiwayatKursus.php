<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKursus extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_kursus_tbl';
	protected $fillable =[
        'pegawai_id',
        'nama_kursus',
        'tempat',
        'penyelenggara',
        'no_sertifikat',
        'tanggal_sertifikat',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
