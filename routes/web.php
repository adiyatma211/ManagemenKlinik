<?php

use App\Http\Controllers\ManagemenDokter\DepartemenModelController;
use App\Http\Controllers\ManagemenDokter\DokterModelController;
use App\Http\Controllers\ManagemenDokter\PasienModelController;
use App\Http\Controllers\PagesController;
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
Route::get('/dashboard', [PagesController::class,'base'])->name('dashboard');

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


// Managemen Pasien Level Dokter
Route::get('/dokter',[PagesController::class,'dokter'])->name('view.dokter');
Route::post('/dokter/tambah',[DokterModelController::class,'store'])->name('store.dokter');
Route::get('/dokter/edit/{id}',[DokterModelController::class,'edit'])->name('edit.dokter');
Route::post('/dokter/update/{id}',[DokterModelController::class,'update'])->name('update.dokter');
Route::delete('/dokter/delete/{id}',[DokterModelController::class,'destroy'])->name('destroy.dokter');




Route::get('/riwayatPasien',[PagesController::class,'riwayatPasien'])->name('view.riwayat');
Route::get('/departemen',[PagesController::class,'departemen'])->name('view.departemen');
// Parameter Dokter -Departemen
Route::post('/departemen/tambah',[DepartemenModelController::class,'store'])->name('store.departemen');
Route::get('/departemen/edit/{id}',[DepartemenModelController::class,'edit'])->name('edit.departemen');
Route::post('/departemen/update/{id}',[DepartemenModelController::class,'update'])->name('update.departemen');
Route::delete('/departemen/delete/{id}',[DepartemenModelController::class,'destroy'])->name('destroy.departemen');





require __DIR__.'/auth.php';
