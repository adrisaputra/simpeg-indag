<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPendidikan extends Model
{
    // use HasFactory;
	protected $table = 'riwayat_pendidikan_tbl';
	protected $fillable =[
        'pegawai_id',
        'jenis_pendidikan',
        'pendidikan',
        'nama_sekolah',
        'jurusan',
        'no_ijazah',
        'tahun_ijazah',
        'user_id'
    ];

    public function pegawai()
    {
        return $this->belongsTo('App\Models\Pegawai');
    }
}
