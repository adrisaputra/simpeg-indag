<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\RiwayatOrangTuaController;
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
use App\Http\Controllers\RiwayatTugasController;
use App\Http\Controllers\RiwayatKaryaIlmiahController;
use App\Http\Controllers\RiwayatPenghargaanController;
use App\Http\Controllers\RiwayatCutiController;
use App\Http\Controllers\RiwayatKursusController;
use App\Http\Controllers\RiwayatHukumanController;
use App\Http\Controllers\RiwayatGajiController;
use App\Http\Controllers\RiwayatTugasLuarNegeriController;
use App\Http\Controllers\RiwayatPajakController;
use App\Http\Controllers\RekapitulasiController;

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

Route::get('/clear-cache-all', function() {
    Artisan::call('cache:clear');
    dd("Cache Clear All");
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
Route::post('/pegawai/import_excel', [PegawaiController::class, 'import_excel']);

## Riwayat Orang Tua
Route::get('/riwayat_orang_tua/{id}', [RiwayatOrangTuaController::class, 'index']);
Route::get('/riwayat_orang_tua/search/{id}', [RiwayatOrangTuaController::class, 'search']);
Route::get('/riwayat_orang_tua/create/{id}', [RiwayatOrangTuaController::class, 'create']);
Route::post('/riwayat_orang_tua/{id}', [RiwayatOrangTuaController::class, 'store']);
Route::get('/riwayat_orang_tua/edit/{id}/{riwayat_orang_tua}', [RiwayatOrangTuaController::class, 'edit']);
Route::put('/riwayat_orang_tua/edit/{id}/{riwayat_orang_tua}', [RiwayatOrangTuaController::class, 'update']);
Route::get('/riwayat_orang_tua/hapus/{id}/{riwayat_orang_tua}',[RiwayatOrangTuaController::class, 'delete']);

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

## Riwayat Tugas
Route::get('/riwayat_tugas/{id}', [RiwayatTugasController::class, 'index']);
Route::get('/riwayat_tugas/search/{id}', [RiwayatTugasController::class, 'search']);
Route::get('/riwayat_tugas/create/{id}', [RiwayatTugasController::class, 'create']);
Route::post('/riwayat_tugas/{id}', [RiwayatTugasController::class, 'store']);
Route::get('/riwayat_tugas/edit/{id}/{riwayat_tugas}', [RiwayatTugasController::class, 'edit']);
Route::put('/riwayat_tugas/edit/{id}/{riwayat_tugas}', [RiwayatTugasController::class, 'update']);
Route::get('/riwayat_tugas/hapus/{id}/{riwayat_tugas}',[RiwayatTugasController::class, 'delete']);

## Riwayat Karya Ilmiah
Route::get('/riwayat_karya_ilmiah/{id}', [RiwayatKaryaIlmiahController::class, 'index']);
Route::get('/riwayat_karya_ilmiah/search/{id}', [RiwayatKaryaIlmiahController::class, 'search']);
Route::get('/riwayat_karya_ilmiah/create/{id}', [RiwayatKaryaIlmiahController::class, 'create']);
Route::post('/riwayat_karya_ilmiah/{id}', [RiwayatKaryaIlmiahController::class, 'store']);
Route::get('/riwayat_karya_ilmiah/edit/{id}/{riwayat_karya_ilmiah}', [RiwayatKaryaIlmiahController::class, 'edit']);
Route::put('/riwayat_karya_ilmiah/edit/{id}/{riwayat_karya_ilmiah}', [RiwayatKaryaIlmiahController::class, 'update']);
Route::get('/riwayat_karya_ilmiah/hapus/{id}/{riwayat_karya_ilmiah}',[RiwayatKaryaIlmiahController::class, 'delete']);

## Riwayat Penghargaan
Route::get('/riwayat_penghargaan/{id}', [RiwayatPenghargaanController::class, 'index']);
Route::get('/riwayat_penghargaan/search/{id}', [RiwayatPenghargaanController::class, 'search']);
Route::get('/riwayat_penghargaan/create/{id}', [RiwayatPenghargaanController::class, 'create']);
Route::post('/riwayat_penghargaan/{id}', [RiwayatPenghargaanController::class, 'store']);
Route::get('/riwayat_penghargaan/edit/{id}/{riwayat_penghargaan}', [RiwayatPenghargaanController::class, 'edit']);
Route::put('/riwayat_penghargaan/edit/{id}/{riwayat_penghargaan}', [RiwayatPenghargaanController::class, 'update']);
Route::get('/riwayat_penghargaan/hapus/{id}/{riwayat_penghargaan}',[RiwayatPenghargaanController::class, 'delete']);

## Riwayat Cuti
Route::get('/riwayat_cuti/{id}', [RiwayatCutiController::class, 'index']);
Route::get('/riwayat_cuti/search/{id}', [RiwayatCutiController::class, 'search']);
Route::get('/riwayat_cuti/create/{id}', [RiwayatCutiController::class, 'create']);
Route::post('/riwayat_cuti/{id}', [RiwayatCutiController::class, 'store']);
Route::get('/riwayat_cuti/edit/{id}/{riwayat_cuti}', [RiwayatCutiController::class, 'edit']);
Route::put('/riwayat_cuti/edit/{id}/{riwayat_cuti}', [RiwayatCutiController::class, 'update']);
Route::get('/riwayat_cuti/hapus/{id}/{riwayat_cuti}',[RiwayatCutiController::class, 'delete']);

## Riwayat Kursus
Route::get('/riwayat_kursus/{id}', [RiwayatKursusController::class, 'index']);
Route::get('/riwayat_kursus/search/{id}', [RiwayatKursusController::class, 'search']);
Route::get('/riwayat_kursus/create/{id}', [RiwayatKursusController::class, 'create']);
Route::post('/riwayat_kursus/{id}', [RiwayatKursusController::class, 'store']);
Route::get('/riwayat_kursus/edit/{id}/{riwayat_kursus}', [RiwayatKursusController::class, 'edit']);
Route::put('/riwayat_kursus/edit/{id}/{riwayat_kursus}', [RiwayatKursusController::class, 'update']);
Route::get('/riwayat_kursus/hapus/{id}/{riwayat_kursus}',[RiwayatKursusController::class, 'delete']);

## Riwayat Hukuman
Route::get('/riwayat_hukuman/{id}', [RiwayatHukumanController::class, 'index']);
Route::get('/riwayat_hukuman/search/{id}', [RiwayatHukumanController::class, 'search']);
Route::get('/riwayat_hukuman/create/{id}', [RiwayatHukumanController::class, 'create']);
Route::post('/riwayat_hukuman/{id}', [RiwayatHukumanController::class, 'store']);
Route::get('/riwayat_hukuman/edit/{id}/{riwayat_hukuman}', [RiwayatHukumanController::class, 'edit']);
Route::put('/riwayat_hukuman/edit/{id}/{riwayat_hukuman}', [RiwayatHukumanController::class, 'update']);
Route::get('/riwayat_hukuman/hapus/{id}/{riwayat_hukuman}',[RiwayatHukumanController::class, 'delete']);

## Riwayat Gaji
Route::get('/riwayat_gaji/{id}', [RiwayatGajiController::class, 'index']);
Route::get('/riwayat_gaji/search/{id}', [RiwayatGajiController::class, 'search']);
Route::get('/riwayat_gaji/create/{id}', [RiwayatGajiController::class, 'create']);
Route::post('/riwayat_gaji/{id}', [RiwayatGajiController::class, 'store']);
Route::get('/riwayat_gaji/edit/{id}/{riwayat_gaji}', [RiwayatGajiController::class, 'edit']);
Route::put('/riwayat_gaji/edit/{id}/{riwayat_gaji}', [RiwayatGajiController::class, 'update']);
Route::get('/riwayat_gaji/hapus/{id}/{riwayat_gaji}',[RiwayatGajiController::class, 'delete']);

## Riwayat Tugas Luar Negeri
Route::get('/riwayat_tugas_luar_negeri/{id}', [RiwayatTugasLuarNegeriController::class, 'index']);
Route::get('/riwayat_tugas_luar_negeri/search/{id}', [RiwayatTugasLuarNegeriController::class, 'search']);
Route::get('/riwayat_tugas_luar_negeri/create/{id}', [RiwayatTugasLuarNegeriController::class, 'create']);
Route::post('/riwayat_tugas_luar_negeri/{id}', [RiwayatTugasLuarNegeriController::class, 'store']);
Route::get('/riwayat_tugas_luar_negeri/edit/{id}/{riwayat_tugas_luar_negeri}', [RiwayatTugasLuarNegeriController::class, 'edit']);
Route::put('/riwayat_tugas_luar_negeri/edit/{id}/{riwayat_tugas_luar_negeri}', [RiwayatTugasLuarNegeriController::class, 'update']);
Route::get('/riwayat_tugas_luar_negeri/hapus/{id}/{riwayat_tugas_luar_negeri}',[RiwayatTugasLuarNegeriController::class, 'delete']);

## Riwayat Pajak
Route::get('/riwayat_pajak/{id}', [RiwayatPajakController::class, 'index']);
Route::get('/riwayat_pajak/search/{id}', [RiwayatPajakController::class, 'search']);
Route::get('/riwayat_pajak/create/{id}', [RiwayatPajakController::class, 'create']);
Route::post('/riwayat_pajak/{id}', [RiwayatPajakController::class, 'store']);
Route::get('/riwayat_pajak/edit/{id}/{riwayat_pajak}', [RiwayatPajakController::class, 'edit']);
Route::put('/riwayat_pajak/edit/{id}/{riwayat_pajak}', [RiwayatPajakController::class, 'update']);
Route::get('/riwayat_pajak/hapus/{id}/{riwayat_pajak}',[RiwayatPajakController::class, 'delete']);

## Rekapitulasi
Route::get('/rekapitulasi_jumlah_pegawai', [RekapitulasiController::class, 'rekapitulasi_jumlah_pegawai']);
Route::get('/rekapitulasi_jumlah_pegawai_bidang', [RekapitulasiController::class, 'rekapitulasi_jumlah_pegawai_bidang']);
Route::get('/rekapitulasi_esselon', [RekapitulasiController::class, 'rekapitulasi_esselon']);
Route::get('/rekapitulasi_gender_bidang', [RekapitulasiController::class, 'rekapitulasi_gender_bidang']);
Route::get('/rekapitulasi_golongan', [RekapitulasiController::class, 'rekapitulasi_golongan']);
Route::get('/rekapitulasi_asn_aktif', [RekapitulasiController::class, 'rekapitulasi_asn_aktif']);
Route::get('/rekapitulasi_asn_non_aktif', [RekapitulasiController::class, 'rekapitulasi_asn_non_aktif']);
Route::get('/rekapitulasi_cuti', [RekapitulasiController::class, 'rekapitulasi_cuti']);
Route::get('/rekapitulasi_pensiunan', [RekapitulasiController::class, 'rekapitulasi_pensiunan']);
Route::get('/rekapitulasi_pendidikan', [RekapitulasiController::class, 'rekapitulasi_pendidikan']);