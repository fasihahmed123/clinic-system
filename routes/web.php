<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function () {
    return redirect()->route('login');
});

// Login ke baad redirect directly patients index
Route::get('/dashboard', function () {
    return redirect()->route('patients.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Profile routes (Laravel Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patient CRUD routes
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');

// ✅ Put all specific routes before {patient} parameter route
Route::get('/patients/export', [PatientController::class, 'export'])->name('patients.export');
Route::post('/patients/import', [PatientController::class, 'import'])->name('patients.import');



// Parameter route should be last
Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
});

require __DIR__.'/auth.php';