<?php

use App\Http\Controllers\ManagemenDokter\PasienModelController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
Route::get('/dashboard', [PagesController::class,'base']);

// ManagemenDokter

Route::get('/managePasien', [PagesController::class,'pasien']);
Route::get('/managePasien/view/{no_rm}', [PasienModelController::class,'edit'])->name('view.pasien');
Route::post('/managePasien/tambah', [PasienModelController::class,'store'])->name('save.pasien');
Route::get('/managePasien/edit/{no_rm}', [PasienModelController::class,'edit'])->name('edit.pasien');
Route::post('/managePasien/update/{no_rm}', [PasienModelController::class,'update'])->name('update.pasien');
Route::delete('/managePasien/delete/{no_rm}', [PasienModelController::class,'destroy'])->name('destroy.pasien');



require __DIR__.'/auth.php';
