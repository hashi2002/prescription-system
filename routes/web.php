<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PharmacyDashboardController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\QuotationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Dashboard routes
Route::get('/dashboard', function () {
    if (auth()->user()->isPharmacy()) {
        return redirect()->route('pharmacy.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware('auth');

// User routes
// routes/web.php
Route::middleware(['auth', 'user.type:user'])->group(function () {
    Route::get('/user-dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/prescriptions/create', [PrescriptionController::class, 'create'])->name('prescriptions.create');
    Route::post('/prescriptions', [PrescriptionController::class, 'store'])->name('prescriptions.store');
    Route::post('/quotations/{quotation}/respond', [QuotationController::class, 'respond'])->name('quotations.respond');
});

// Pharmacy routes
Route::middleware(['auth', 'pharmacy'])->group(function () {
    Route::get('/pharmacy-dashboard', [PharmacyDashboardController::class, 'index'])->name('pharmacy.dashboard');
    Route::get('/quotations/{prescription}/create', [QuotationController::class, 'create'])->name('quotations.create');
    Route::post('/quotations/{prescription}', [QuotationController::class, 'store'])->name('quotations.store');
});

// Shared routes (both user types)
Route::middleware('auth')->group(function () {
    Route::get('/prescriptions/{prescription}', [PrescriptionController::class, 'show'])->name('prescriptions.show');
    Route::get('/quotations/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
