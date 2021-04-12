<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RiwayatAyahController;
use App\Http\Controllers\RiwayatIbuController;
use App\Http\Controllers\RiwayatPasanganController;
use App\Http\Controllers\RiwayatAnakController;
use App\Http\Controllers\RiwayatAngkaKreditController;
use App\Http\Controllers\RiwayatJabatanController;
use App\Http\Controllers\RiwayatKepangkatanController;
use App\Http\Controllers\RiwayatLhkpnController;
use App\Http\Controllers\RiwayatKompetensiController;
use App\Http\Controllers\RiwayatPendidikanController;
use App\Http\Controllers\RiwayatSeminarController;
use App\Http\Controllers\RiwayatDiklatController;
use App\Http\Controllers\RiwayatPenghargaanController;
use App\Http\Controllers\RiwayatKursusController;
use App\Http\Controllers\RiwayatHukumanController;
use App\Http\Controllers\RiwayatTugasLuarNegeriController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/buat_storage', function () {
    Artisan::call('storage:link');
    dd("Storage Berhasil Di Buat");
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [HomeController::class, 'index']);

## Pegawai
Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::get('/pegawai/search', [PegawaiController::class, 'search']);
Route::get('/pegawai/create', [PegawaiController::class, 'create']);
Route::post('/pegawai', [PegawaiController::class, 'store']);
Route::get('/pegawai/edit/{pegawai}', [PegawaiController::class, 'edit']);
Route::put('/pegawai/edit/{pegawai}', [PegawaiController::class, 'update']);
Route::get('/pegawai/hapus/{pegawai}',[PegawaiController::class, 'delete']);

## Riwayat Ayah
Route::get('/riwayat_ayah/{id}', [RiwayatAyahController::class, 'index']);
Route::get('/riwayat_ayah/search/{id}', [RiwayatAyahController::class, 'search']);
Route::get('/riwayat_ayah/create/{id}', [RiwayatAyahController::class, 'create']);
Route::post('/riwayat_ayah/{id}', [RiwayatAyahController::class, 'store']);
Route::get('/riwayat_ayah/edit/{id}/{riwayat_ayah}', [RiwayatAyahController::class, 'edit']);
Route::put('/riwayat_ayah/edit/{id}/{riwayat_ayah}', [RiwayatAyahController::class, 'update']);
Route::get('/riwayat_ayah/hapus/{id}/{riwayat_ayah}',[RiwayatAyahController::class, 'delete']);

## Riwayat Ibu
Route::get('/riwayat_ibu/{id}', [RiwayatIbuController::class, 'index']);
Route::get('/riwayat_ibu/search/{id}', [RiwayatIbuController::class, 'search']);
Route::get('/riwayat_ibu/create/{id}', [RiwayatIbuController::class, 'create']);
Route::post('/riwayat_ibu/{id}', [RiwayatIbuController::class, 'store']);
Route::get('/riwayat_ibu/edit/{id}/{riwayat_ibu}', [RiwayatIbuController::class, 'edit']);
Route::put('/riwayat_ibu/edit/{id}/{riwayat_ibu}', [RiwayatIbuController::class, 'update']);
Route::get('/riwayat_ibu/hapus/{id}/{riwayat_ibu}',[RiwayatIbuController::class, 'delete']);

## Riwayat Pasangan
Route::get('/riwayat_pasangan/{id}', [RiwayatPasanganController::class, 'index']);
Route::get('/riwayat_pasangan/search/{id}', [RiwayatPasanganController::class, 'search']);
Route::get('/riwayat_pasangan/create/{id}', [RiwayatPasanganController::class, 'create']);
Route::post('/riwayat_pasangan/{id}', [RiwayatPasanganController::class, 'store']);
Route::get('/riwayat_pasangan/edit/{id}/{riwayat_pasangan}', [RiwayatPasanganController::class, 'edit']);
Route::put('/riwayat_pasangan/edit/{id}/{riwayat_pasangan}', [RiwayatPasanganController::class, 'update']);
Route::get('/riwayat_pasangan/hapus/{id}/{riwayat_pasangan}',[RiwayatPasanganController::class, 'delete']);

## Riwayat Anak
Route::get('/riwayat_anak/{id}', [RiwayatAnakController::class, 'index']);
Route::get('/riwayat_anak/search/{id}', [RiwayatAnakController::class, 'search']);
Route::get('/riwayat_anak/create/{id}', [RiwayatAnakController::class, 'create']);
Route::post('/riwayat_anak/{id}', [RiwayatAnakController::class, 'store']);
Route::get('/riwayat_anak/edit/{id}/{riwayat_anak}', [RiwayatAnakController::class, 'edit']);
Route::put('/riwayat_anak/edit/{id}/{riwayat_anak}', [RiwayatAnakController::class, 'update']);
Route::get('/riwayat_anak/hapus/{id}/{riwayat_anak}',[RiwayatAnakController::class, 'delete']);

## Riwayat Jabatan
Route::get('/riwayat_jabatan/{id}', [RiwayatJabatanController::class, 'index']);
Route::get('/riwayat_jabatan/search/{id}', [RiwayatJabatanController::class, 'search']);
Route::get('/riwayat_jabatan/create/{id}', [RiwayatJabatanController::class, 'create']);
Route::post('/riwayat_jabatan/{id}', [RiwayatJabatanController::class, 'store']);
Route::get('/riwayat_jabatan/edit/{id}/{riwayat_jabatan}', [RiwayatJabatanController::class, 'edit']);
Route::put('/riwayat_jabatan/edit/{id}/{riwayat_jabatan}', [RiwayatJabatanController::class, 'update']);
Route::get('/riwayat_jabatan/hapus/{id}/{riwayat_jabatan}',[RiwayatJabatanController::class, 'delete']);

## Riwayat Angka Kredit
Route::get('/riwayat_angka_kredit/{id}', [RiwayatAngkaKreditController::class, 'index']);
Route::get('/riwayat_angka_kredit/search/{id}', [RiwayatAngkaKreditController::class, 'search']);
Route::get('/riwayat_angka_kredit/create/{id}', [RiwayatAngkaKreditController::class, 'create']);
Route::post('/riwayat_angka_kredit/{id}', [RiwayatAngkaKreditController::class, 'store']);
Route::get('/riwayat_angka_kredit/edit/{id}/{riwayat_angka_kredit}', [RiwayatAngkaKreditController::class, 'edit']);
Route::put('/riwayat_angka_kredit/edit/{id}/{riwayat_angka_kredit}', [RiwayatAngkaKreditController::class, 'update']);
Route::get('/riwayat_angka_kredit/hapus/{id}/{riwayat_angka_kredit}',[RiwayatAngkaKreditController::class, 'delete']);

## Riwayat Kepangkatan
Route::get('/riwayat_kepangkatan/{id}', [RiwayatKepangkatanController::class, 'index']);
Route::get('/riwayat_kepangkatan/search/{id}', [RiwayatKepangkatanController::class, 'search']);
Route::get('/riwayat_kepangkatan/create/{id}', [RiwayatKepangkatanController::class, 'create']);
Route::post('/riwayat_kepangkatan/{id}', [RiwayatKepangkatanController::class, 'store']);
Route::get('/riwayat_kepangkatan/edit/{id}/{riwayat_kepangkatan}', [RiwayatKepangkatanController::class, 'edit']);
Route::put('/riwayat_kepangkatan/edit/{id}/{riwayat_kepangkatan}', [RiwayatKepangkatanController::class, 'update']);
Route::get('/riwayat_kepangkatan/hapus/{id}/{riwayat_kepangkatan}',[RiwayatKepangkatanController::class, 'delete']);

## Riwayat LHKPN
Route::get('/riwayat_lhkpn/{id}', [RiwayatLhkpnController::class, 'index']);
Route::get('/riwayat_lhkpn/search/{id}', [RiwayatLhkpnController::class, 'search']);
Route::get('/riwayat_lhkpn/create/{id}', [RiwayatLhkpnController::class, 'create']);
Route::post('/riwayat_lhkpn/{id}', [RiwayatLhkpnController::class, 'store']);
Route::get('/riwayat_lhkpn/edit/{id}/{riwayat_lhkpn}', [RiwayatLhkpnController::class, 'edit']);
Route::put('/riwayat_lhkpn/edit/{id}/{riwayat_lhkpn}', [RiwayatLhkpnController::class, 'update']);
Route::get('/riwayat_lhkpn/hapus/{id}/{riwayat_lhkpn}',[RiwayatLhkpnController::class, 'delete']);

## Riwayat Kompetensi
Route::get('/riwayat_kompetensi/{id}', [RiwayatKompetensiController::class, 'index']);
Route::get('/riwayat_kompetensi/search/{id}', [RiwayatKompetensiController::class, 'search']);
Route::get('/riwayat_kompetensi/create/{id}', [RiwayatKompetensiController::class, 'create']);
Route::post('/riwayat_kompetensi/{id}', [RiwayatKompetensiController::class, 'store']);
Route::get('/riwayat_kompetensi/edit/{id}/{riwayat_kompetensi}', [RiwayatKompetensiController::class, 'edit']);
Route::put('/riwayat_kompetensi/edit/{id}/{riwayat_kompetensi}', [RiwayatKompetensiController::class, 'update']);
Route::get('/riwayat_kompetensi/hapus/{id}/{riwayat_kompetensi}',[RiwayatKompetensiController::class, 'delete']);

## Riwayat Pendidikan
Route::get('/riwayat_pendidikan/{id}', [RiwayatPendidikanController::class, 'index']);
Route::get('/riwayat_pendidikan/search/{id}', [RiwayatPendidikanController::class, 'search']);
Route::get('/riwayat_pendidikan/create/{id}', [RiwayatPendidikanController::class, 'create']);
Route::post('/riwayat_pendidikan/{id}', [RiwayatPendidikanController::class, 'store']);
Route::get('/riwayat_pendidikan/edit/{id}/{riwayat_pendidikan}', [RiwayatPendidikanController::class, 'edit']);
Route::put('/riwayat_pendidikan/edit/{id}/{riwayat_pendidikan}', [RiwayatPendidikanController::class, 'update']);
Route::get('/riwayat_pendidikan/hapus/{id}/{riwayat_pendidikan}',[RiwayatPendidikanController::class, 'delete']);

## Riwayat Seminar
Route::get('/riwayat_seminar/{id}', [RiwayatSeminarController::class, 'index']);
Route::get('/riwayat_seminar/search/{id}', [RiwayatSeminarController::class, 'search']);
Route::get('/riwayat_seminar/create/{id}', [RiwayatSeminarController::class, 'create']);
Route::post('/riwayat_seminar/{id}', [RiwayatSeminarController::class, 'store']);
Route::get('/riwayat_seminar/edit/{id}/{riwayat_seminar}', [RiwayatSeminarController::class, 'edit']);
Route::put('/riwayat_seminar/edit/{id}/{riwayat_seminar}', [RiwayatSeminarController::class, 'update']);
Route::get('/riwayat_seminar/hapus/{id}/{riwayat_seminar}',[RiwayatSeminarController::class, 'delete']);

## Riwayat Diklat
Route::get('/riwayat_diklat/{id}', [RiwayatDiklatController::class, 'index']);
Route::get('/riwayat_diklat/search/{id}', [RiwayatDiklatController::class, 'search']);
Route::get('/riwayat_diklat/create/{id}', [RiwayatDiklatController::class, 'create']);
Route::post('/riwayat_diklat/{id}', [RiwayatDiklatController::class, 'store']);
Route::get('/riwayat_diklat/edit/{id}/{riwayat_diklat}', [RiwayatDiklatController::class, 'edit']);
Route::put('/riwayat_diklat/edit/{id}/{riwayat_diklat}', [RiwayatDiklatController::class, 'update']);
Route::get('/riwayat_diklat/hapus/{id}/{riwayat_diklat}',[RiwayatDiklatController::class, 'delete']);

## Riwayat Penghargaan
Route::get('/riwayat_penghargaan/{id}', [RiwayatPenghargaanController::class, 'index']);
Route::get('/riwayat_penghargaan/search/{id}', [RiwayatPenghargaanController::class, 'search']);
Route::get('/riwayat_penghargaan/create/{id}', [RiwayatPenghargaanController::class, 'create']);
Route::post('/riwayat_penghargaan/{id}', [RiwayatPenghargaanController::class, 'store']);
Route::get('/riwayat_penghargaan/edit/{id}/{riwayat_penghargaan}', [RiwayatPenghargaanController::class, 'edit']);
Route::put('/riwayat_penghargaan/edit/{id}/{riwayat_penghargaan}', [RiwayatPenghargaanController::class, 'update']);
Route::get('/riwayat_penghargaan/hapus/{id}/{riwayat_penghargaan}',[RiwayatPenghargaanController::class, 'delete']);

## Riwayat Kursus
Route::get('/riwayat_kursus/{id}', [RiwayatKursusController::class, 'index']);
Route::get('/riwayat_kursus/search/{id}', [RiwayatKursusController::class, 'search']);
Route::get('/riwayat_kursus/create/{id}', [RiwayatKursusController::class, 'create']);
Route::post('/riwayat_kursus/{id}', [RiwayatKursusController::class, 'store']);
Route::get('/riwayat_kursus/edit/{id}/{riwayat_kursus}', [RiwayatKursusController::class, 'edit']);
Route::put('/riwayat_kursus/edit/{id}/{riwayat_kursus}', [RiwayatKursusController::class, 'update']);
Route::get('/riwayat_kursus/hapus/{id}/{riwayat_kursus}',[RiwayatKursusController::class, 'delete']);

## Riwayat Kursus
Route::get('/riwayat_hukuman/{id}', [RiwayatHukumanController::class, 'index']);
Route::get('/riwayat_hukuman/search/{id}', [RiwayatHukumanController::class, 'search']);
Route::get('/riwayat_hukuman/create/{id}', [RiwayatHukumanController::class, 'create']);
Route::post('/riwayat_hukuman/{id}', [RiwayatHukumanController::class, 'store']);
Route::get('/riwayat_hukuman/edit/{id}/{riwayat_hukuman}', [RiwayatHukumanController::class, 'edit']);
Route::put('/riwayat_hukuman/edit/{id}/{riwayat_hukuman}', [RiwayatHukumanController::class, 'update']);
Route::get('/riwayat_hukuman/hapus/{id}/{riwayat_hukuman}',[RiwayatHukumanController::class, 'delete']);

## Riwayat Tugas Luar Negeri
Route::get('/riwayat_tugas_luar_negeri/{id}', [RiwayatTugasLuarNegeriController::class, 'index']);
Route::get('/riwayat_tugas_luar_negeri/search/{id}', [RiwayatTugasLuarNegeriController::class, 'search']);
Route::get('/riwayat_tugas_luar_negeri/create/{id}', [RiwayatTugasLuarNegeriController::class, 'create']);
Route::post('/riwayat_tugas_luar_negeri/{id}', [RiwayatTugasLuarNegeriController::class, 'store']);
Route::get('/riwayat_tugas_luar_negeri/edit/{id}/{riwayat_tugas_luar_negeri}', [RiwayatTugasLuarNegeriController::class, 'edit']);
Route::put('/riwayat_tugas_luar_negeri/edit/{id}/{riwayat_tugas_luar_negeri}', [RiwayatTugasLuarNegeriController::class, 'update']);
Route::get('/riwayat_tugas_luar_negeri/hapus/{id}/{riwayat_tugas_luar_negeri}',[RiwayatTugasLuarNegeriController::class, 'delete']);
