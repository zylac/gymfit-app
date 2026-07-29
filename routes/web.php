<?php

use App\Http\Controllers\Member\BookingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking Routes for Members
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/payment', [BookingController::class, 'payment'])->name('bookings.payment');
    Route::post('/bookings/{booking}/payment', [BookingController::class, 'uploadPayment'])->name('bookings.payment.upload');
    Route::delete('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// =============================================
// 🚀 Wasmer Deployment Helpers (HAPUS setelah deploy stabil!)
// =============================================

use Illuminate\Support\Facades\Artisan;

$wasmerToken = fn ($token) => $token === 'gymfit-secret-' . md5(config('app.key'));

// Route untuk menjalankan scheduler (dipanggil oleh cron-job.org atau EasyCron)
Route::get('/wasmer/scheduler/{token}', function ($token) use ($wasmerToken) {
    abort_unless($wasmerToken($token), 403);
    Artisan::call('schedule:run');
    return response()->json(['status' => 'ok', 'message' => 'Scheduler executed']);
});

// Route untuk menjalankan optimize (cache config, route, view)
Route::get('/wasmer/optimize/{token}', function ($token) use ($wasmerToken) {
    abort_unless($wasmerToken($token), 403);
    Artisan::call('optimize', ['--force' => true]);
    return response()->json(['status' => 'ok', 'message' => 'Optimization completed']);
});

// Route untuk menjalankan migration (panggil sekali setelah deploy!)
Route::get('/wasmer/migrate/{token}', function ($token) use ($wasmerToken) {
    abort_unless($wasmerToken($token), 403);
    Artisan::call('migrate', ['--force' => true]);
    return response()->json(['status' => 'ok', 'message' => 'Migration completed']);
});

// Route untuk serve storage files (workaround karena Wasmer gak support symlink)
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    return file_exists($fullPath) ? response()->file($fullPath) : abort(404);
})->where('path', '.*');

require __DIR__.'/auth.php';

