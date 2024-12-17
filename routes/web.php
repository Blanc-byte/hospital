<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
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
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/appointments', [AdminController::class, 'index'])->name('admin.appointments');
    Route::get('/admin/history', [AdminController::class, 'history'])->name('admin.history');
    Route::get('/admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/assign-doctor', [AdminController::class, 'assignDoctor']);
    Route::post('/update-doctor', [AdminController::class, 'updateDoctor']);
    Route::post('/doctors/update', [AdminController::class, 'update']);
    Route::post('/add-doctor', [AdminController::class, 'store'])->name('doctor.add');

});

Route::middleware(['auth', 'isPatient'])->group(function () {
    Route::get('/patient/appointment', [PatientController::class, 'index'])->name('patient.appointment');
    Route::post('/appointment', [PatientController::class, 'store'])->name('appointment.store');
    Route::get('/appointment/view', [PatientController::class, 'viewAppointment'])->name('appointment.view');
    Route::get('/appointment/approved', [PatientController::class, 'viewAppointmentApproved'])->name('appointment.approved');
});

// Route::get('/patient/appointment', [PatientController::class, 'index'])
// ->middleware(['auth', 'isPatient'])
// ->name('patient.appointment');
// Route::post('/appointment', [PatientController::class, 'store'])
// ->middleware(['auth', 'isPatient'])
// ->name('appointment.store');



Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    $user = Auth::user(); // Get the authenticated user

    if ($user->role === 'Admin') {
        return redirect()->route('admin.appointments'); // Redirect to admin's appointments page
    } elseif ($user->role === 'Patient') {
        return redirect()->route('patient.appointment'); // Redirect to patient's appointment page
    }

    // Default fallback if no role matches
    abort(403, 'Unauthorized action.');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
