<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
     // use HasFactory;
	protected $table = 'arsip_tbl';
	protected $fillable =[
        'no_surat',
        'perihal',
        'tanggal',
        'file_arsip',
        'user_id'
    ];
}
