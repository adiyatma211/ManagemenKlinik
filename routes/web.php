<?php

use App\Http\Controllers\InventarisModelController;
use App\Http\Controllers\ManagemenBooking\ReservasiController;
use App\Http\Controllers\ManagemenDokter\DepartemenModelController;
use App\Http\Controllers\ManagemenDokter\DokterModelController;
use App\Http\Controllers\ManagemenDokter\PasienModelController;
use App\Http\Controllers\ManagemenDokter\RekamPasienController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PresensiModelController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//Dashborad
Route::middleware(['auth', CheckRole::class . ':admin,dokter'])->group(function () {
    Route::get('/dashboard', [PagesController::class,'base'])->name('dashboard');
});

// ManagemenDokter Level Admin

Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::prefix('managePasien')->group(function () {
        Route::get('/', [PagesController::class, 'pasien']);
        Route::get('/view/{no_rm}', [PasienModelController::class, 'edit'])->name('view.pasien');
        Route::post('/tambah', [PasienModelController::class, 'store'])->name('save.pasien');
        Route::get('/edit/{no_rm}', [PasienModelController::class, 'edit'])->name('edit.pasien');
        Route::post('/update/{no_rm}', [PasienModelController::class, 'update'])->name('update.pasien');
        Route::delete('/delete/{no_rm}', [PasienModelController::class, 'destroy'])->name('destroy.pasien');
        Route::get('/{departemenId}', [PasienModelController::class, 'getDoctorsByDepartment']);
    });
});

// Parameter Dokter -Departemen dan Admin

Route::middleware(['auth', CheckRole::class . ':dokter,admin'])->group(function () {
    Route::get('/departemen', [PagesController::class, 'departemen'])->name('view.departemen');
    Route::post('/departemen/tambah', [DepartemenModelController::class, 'store'])->name('store.departemen');
    Route::get('/departemen/edit/{id}', [DepartemenModelController::class, 'edit'])->name('edit.departemen');
    Route::post('/departemen/update/{id}', [DepartemenModelController::class, 'update'])->name('update.departemen');
    Route::delete('/departemen/delete/{id}', [DepartemenModelController::class, 'destroy'])->name('destroy.departemen');
});

// Managemen Pasien  -Dokter
Route::middleware(['auth', CheckRole::class . ':dokter,admin'])->group(function () {
    Route::get('/dokter',[PagesController::class,'dokter'])->name('view.dokter');
    Route::post('/dokter/tambah',[DokterModelController::class,'store'])->name('store.dokter');
    Route::get('/dokter/edit/{id}',[DokterModelController::class,'edit'])->name('edit.dokter');
    Route::post('/dokter/update/{id}',[DokterModelController::class,'update'])->name('update.dokter');
    Route::delete('/dokter/delete/{id}',[DokterModelController::class,'destroy'])->name('destroy.dokter');
});


// Riwayat Pasien -Dokter
Route::middleware(['auth', CheckRole::class . ':dokter,admin'])->group(function () {
    Route::get('/riwayatPasien',[PagesController::class,'riwayatPasien'])->name('view.riwayat');
    Route::get('/riwayatPasien/tindakan',[PagesController::class,'updateRiwayat'])->name('view.tindakan');
    Route::post('/riwayatPasien/selesai/{id}',[RekamPasienController::class,'selesaiPasien'])->name('selesai.tindakan');
    Route::post('/riwayatPasien/store', [RekamPasienController::class, 'store'])->name('patients.store');
    Route::get('/riwayatPasien/{id}/edit', [RekamPasienController::class, 'edit'])->name('patients.edit');
    Route::post('/riwayatPasien/{id}', [RekamPasienController::class, 'update'])->name('patients.update');
    Route::delete('/riwayatPasien/{id}', [RekamPasienController::class, 'destroy'])->name('patients.destroy');
});


// Managemen Booking
Route::middleware(['auth', CheckRole::class . ':dokter,admin'])->group(function () {
    Route::get('/jadwalDokter',[PagesController::class,'jadwalDokter'])->name('view.jadwal');
    Route::get('/reservasiPasien',[PagesController::class,'reservasiPasien'])->name('view.reservasi');
    Route::get('/reservasiPasien/tambah/{no_rm}',[ReservasiController::class,'getPatientByNoRm'])->name('get.reservasi');
    Route::post('/reservasi/save-or-update', [ReservasiController::class, 'saveOrUpdatePatient'])->name('reservasi.saveOrUpdate');
    Route::get('/reservasi/{no_rm}/edit', [ReservasiController::class, 'getPatientByNoRm'])->name('reservasi.edit');
    Route::delete('/reservasi/{no_rm}', [ReservasiController::class, 'destroy'])->name('reservasi.delete');
});
// Konfirmasi Kehadiran
Route::middleware(['auth', CheckRole::class . ':dokter,admin'])->group(function () {
    Route::get('/konfirm', [PagesController::class, 'konfirmKehadiran'])->name('konfirmasi.kehadiran');
    Route::post('/konfirm/kehadiran/{no_rm}', [ReservasiController::class, 'konfirmasi'])->name('konfirmasi.kehadiran');
});

// In your web.php file
Route::middleware(['auth', CheckRole::class . ':dokter,admin'])->group(function () {
Route::post('/presensi/masuk', [PresensiModelController::class, 'masuk'])->name('presensi.masuk');
Route::post('/presensi/keluar', [PresensiModelController::class, 'keluar'])->name('presensi.keluar');
Route::get('/presensi', [PresensiModelController::class, 'index'])->name('presensi.index');
});
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::get('/reportInventaris', [InventarisModelController::class, 'menu'])->name('inventaris.index');
    Route::get('/getInventoryItems', [InventarisModelController::class, 'getInventoryItems'])->name('inventaris.getItems');
    Route::get('/getInventoryItem/{id}', [InventarisModelController::class, 'getInventoryItem'])->name('inventaris.getItem');
    Route::post('/saveInventoryItem', [InventarisModelController::class, 'save'])->name('inventaris.store');
    Route::post('/updateInventoryItem/{id}', [InventarisModelController::class, 'updateInventoryItem'])->name('inventaris.update');
    Route::delete('/deleteInventoryItem/{id}', [InventarisModelController::class, 'destroy'])->name('inventaris.delete');
});

Route::get('/rekam', [PagesController::class, 'pasienNota'])->name('pasien.nota');
    

require __DIR__.'/auth.php';
