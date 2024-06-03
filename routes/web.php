<?php

use App\Http\Controllers\TempImagesController;
use App\Http\Controllers\AksiController;
use App\Http\Controllers\AplikasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\CripsController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\AlgoritmaController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FrontendController::class, 'index']);
Route::get('/cek-nilai-siswa', [FrontendController::class, 'cekNilaiSiswa'])->name('cek-nilai-siswa');

Route::get('login', [LoginController::class, 'showLoginForm']);
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home.index');

    // Aplikasi
    Route::get('/pengaturan-aplikasi', [AplikasiController::class, 'index'])->name('pengaturan-apikasi.index');
    Route::post('/pengaturan-apllikasi/update', [AplikasiController::class, 'update'])->name('pengaturan-aplikasi.update');

    // Temp Images
    Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.delete');
    Route::get('/change-status/{id}', [UserController::class, 'changeStatus'])->name('change-status');


    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('users/update-password/{id}', [ProfileController::class, 'updatePassword'])->name('users.update-password');

    // Group
    Route::get('/group', [GroupController::class, 'index'])->name('group.index');
    Route::post('/group', [GroupController::class, 'store'])->name('group.store');
    Route::delete('/group/{id}', [GroupController::class, 'destroy'])->name('group.delete');

    // Section
    Route::get('/aksi', [AksiController::class, 'index'])->name('aksi.index');

    // Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu/create-section', [MenuController::class, 'create_section'])->name('menu.create-section');
    Route::post('/menu', [MenuController::class, 'create_menu'])->name('menu.store');
    Route::get('/menu/detail-section/{id}', [MenuController::class, 'detail_section']);
    Route::get('/menu/detail-menu/{id}', [MenuController::class, 'detail_menu']);
    Route::put('/menu/update-section/{id}', [MenuController::class, 'update_section'])->name('menu.update-section');
    Route::put('/menu/update-menu/{id}', [MenuController::class, 'update_menu'])->name('menu.update-menu');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy_menu'])->name('menu.delete');
    Route::delete('/menu/delete-section/{id}', [MenuController::class, 'destroy_section'])->name('menu.delete-section');

    // Permission
    Route::get('permission/data-akses/{id}', [PermissionController::class, 'data_akses'])->name('permission.data-akses');
    Route::post('permission/data-akses/edit_akses', [PermissionController::class, 'edit_akses'])->name('permission.edit-akses');
    Route::post('permission/data-akses/all_access', [PermissionController::class, 'all_access'])->name('permission.all-akses');

    // Periode
    Route::get('/periode', [PeriodeController::class, 'index'])->name('periode.index');
    Route::post('/periode', [PeriodeController::class, 'store'])->name('periode.store');
    Route::get('/periode/{id}', [PeriodeController::class, 'show']);
    Route::put('/periode/{id}', [PeriodeController::class, 'update'])->name('periode.update');
    Route::delete('/periode/{id}', [PeriodeController::class, 'destroy'])->name('periode.delete');

    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/list/{id}', [SiswaController::class, 'list'])->name('siswa.list');
    Route::get('/detail/{id}', [SiswaController::class, 'show'])->name('siswa.detail');
    Route::post('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('siswa.delete');
    Route::get('/siwa/download-template', [SiswaController::class, 'downloadTemplate'])->name('siswa.download-template');

    // Kriteria
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::post('/kriteria', [KriteriaController::class, 'store'])->name('kriteria.store');
    Route::get('/kriteria/{id}', [KriteriaController::class, 'show']);
    Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/kriteria/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.delete');

    // Kriteria
    Route::get('/crips', [CripsController::class, 'index'])->name('crips.index');
    Route::post('/crips', [CripsController::class, 'store'])->name('crips.store');
    Route::get('/crips/{id}', [CripsController::class, 'show']);
    Route::put('/crips/{id}', [CripsController::class, 'update'])->name('crips.update');
    Route::delete('/crips/{id}', [CripsController::class, 'destroy'])->name('crips.delete');

    // Penilaian
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{id}', [PenilaianController::class, 'detail'])->name('penilaian.detail');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');

    // Algortima
    Route::get('/penilaian/kalkulasi/{id}', [AlgoritmaController::class, 'index'])->name('kalkulasi.index');

    // Import Excel
    Route::post('/import-siswa', [ImportController::class, 'importSiswa'])->name('import-siswa');

    // Export Excel
    Route::get('/siswa/export/{periode_id}', [ExportController::class, 'exportSiswa'])->name('siswa.export');
    Route::get('/nilai/export/{periode_id}', [ExportController::class, 'exportNilai'])->name('nilai.export');
});
