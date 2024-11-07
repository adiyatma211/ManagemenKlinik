<?php

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
    });
});


// Managemen Pasien Level Dokter

Route::get('/riwayatPasien',[PagesController::class,'riwayatPasien'])->name('view.riwayat');




require __DIR__.'/auth.php';
