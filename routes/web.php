<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk menampilkan daftar program
Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');

// Route untuk menyimpan program baru
Route::post('/programs', [ProgramController::class, 'storeOrUpdate'])->name('programs.store');

// Route untuk memperbarui program
Route::put('/programs/{id}', [ProgramController::class, 'storeOrUpdate'])->name('programs.update');

// Route untuk menghapus program
Route::delete('/programs/{id}', [ProgramController::class, 'destroy'])->name('programs.destroy');






require __DIR__.'/auth.php';
