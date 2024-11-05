<?php
require base_path('routes/auth.php');
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\BossController;

use App\Http\Controllers\Boss\YardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin-boss/login', [LoginController::class, 'showLoginForm'])
    ->middleware(RedirectIfAuthenticated::class)
    ->name('admin.boss/login');
Route::post('admin-boss/login', [LoginController::class, 'login'])->name('admin-boss.login');


Route::get('/dashboard', function () {
    return view('user.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth:admin'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/index', [UserController::class, 'index'])->name('index');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::post('/block/{id}', [UserController::class, 'block'])->name('block');
            Route::post('/unblock/{id}', [UserController::class, 'unblock'])->name('unblock');
            Route::get('/get-districts', [UserController::class, 'getDistricts'])->name('getDistricts');
            Route::get('/search', [UserController::class, 'search'])->name('search');

        });

        Route::prefix('voucher')->name('voucher.')->group(function () {
            Route::get('/index', [VoucherController::class, 'index'])->name('index');
            Route::post('/store', [VoucherController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [VoucherController::class, 'detail'])->name('detail');
            Route::post('/block/{id}', [VoucherController::class, 'block'])->name('block');
            Route::post('/unblock/{id}', [VoucherController::class, 'unblock'])->name('unblock');
        });

        Route::prefix('boss')->name('boss.')->group(function () {
            Route::get('/index', [BossController::class, 'index'])->name('index');
            Route::post('/store', [BossController::class, 'store'])->name('store');
            Route::post('/block/{id}', [BossController::class, 'block'])->name('block');
            Route::post('/unblock/{id}', [BossController::class, 'unblock'])->name('unblock');
            Route::get('/get-districts', [BossController::class, 'getDistricts'])->name('getDistricts');
            Route::get('/search', [BossController::class, 'search'])->name('search');
        });
    });
});
Route::middleware(['auth:boss'])->group(function () {
    Route::prefix('boss')->name('boss.')->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::prefix('yard')->name('yard.')->group(function () {
            Route::get('/index', [YardController::class, 'index'])->name('index');
            Route::post('/store', [YardController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [YardController::class, 'detail'])->name('detail');
            Route::post('/block/{id}', [YardController::class, 'block'])->name('block');
            Route::post('/unblock/{id}', [YardController::class, 'unblock'])->name('unblock');
            Route::get('/get-districts', [YardController::class, 'getDistricts'])->name('getDistricts');
        });
    });
});
