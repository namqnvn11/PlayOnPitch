<?php
require base_path('routes/auth.php');

use App\Http\Controllers\Boss\PriceTimeSettingController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\District;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RegisterBossController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\BossController;

use App\Http\Controllers\Boss\YardController;

use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\YardListController;
use App\Http\Controllers\User\YardDetailController;
use App\Http\Controllers\User\ChoiceYardController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\PolicyController;
use App\Http\Controllers\User\ClauseController;
use App\Http\Controllers\User\PrivacyPolicyController;
use App\Http\Controllers\User\CancellationPolicyController;
use App\Http\Controllers\User\CommodityPolicyController;
use App\Http\Controllers\User\PaymentPolicyController;
use App\Http\Controllers\User\VoucherController as UserVoucherController;
use App\Http\Controllers\User\MyVoucherController;


//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('admin-boss/login', [LoginController::class, 'showLoginForm'])
    ->middleware(RedirectIfAuthenticated::class)
    ->name('admin.boss/login');
Route::post('admin-boss/login', [LoginController::class, 'login'])->name('admin-boss.login');


Route::get('login', [LoginController::class, 'showLoginUser'])
    ->middleware(RedirectIfAuthenticated::class)
    ->name('login');

Route::middleware(['auth:admin'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/index', [UserController::class, 'index'])->name('index');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [UserController::class, 'detail'])->name('detail');
            Route::post('/block/{id}', [UserController::class, 'block'])->name('block');
            Route::post('/unblock/{id}', [UserController::class, 'unblock'])->name('unblock');
            Route::get('/get-districts', [UserController::class, 'getDistricts'])->name('getDistricts');
            Route::get('/search', [UserController::class, 'search'])->name('search');
            Route::post('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('reset-password');

        });

        Route::prefix('voucher')->name('voucher.')->group(function () {
            Route::get('/index', [VoucherController::class, 'index'])->name('index');
            Route::post('/store', [VoucherController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [VoucherController::class, 'detail'])->name('detail');
            Route::post('/block/{id}', [VoucherController::class, 'block'])->name('block');
            Route::post('/unblock/{id}', [VoucherController::class, 'unblock'])->name('unblock');
            Route::get('/search', [VoucherController::class, 'search'])->name('search');
        });

        Route::prefix('boss')->name('boss.')->group(function () {
            Route::get('/index', [BossController::class, 'index'])->name('index');
            Route::post('/store', [BossController::class, 'store'])->name('store');
            Route::get('/detail/{id}', [BossController::class, 'detail'])->name('detail');
            Route::post('/block/{id}', [BossController::class, 'block'])->name('block');
            Route::post('/unblock/{id}', [BossController::class, 'unblock'])->name('unblock');
            Route::get('/get-districts', [BossController::class, 'getDistricts'])->name('getDistricts');
            Route::get('/search', [BossController::class, 'search'])->name('search');
            Route::post('/reset-password/{id}', [BossController::class, 'resetPassword'])->name('reset-password');

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
            Route::get('/search', [YardController::class, 'search'])->name('search');
            Route::post('/pricing/{id}', [PriceTimeSettingController::class, 'pricing'])->name('pricing');
            Route::get('/getPricing/{id}',[PriceTimeSettingController::class, 'getPricing'])->name('getPricing');
            Route::post('/setOpenTime/{id}',[PriceTimeSettingController::class, 'setOpenTime'])->name('setOpenTime');
            Route::get('/testing/create',[PriceTimeSettingController::class, 'test'])->name('test');
            Route::get('/testing/delete',[PriceTimeSettingController::class, 'delete'])->name('delete');
            Route::get('test',function (){
                return view('boss.yard.test');
        });
    });
});

Route::middleware(['auth:web'])->group(function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');
        Route::post('/store', [RegisterBossController::class, 'store'])->name('storeRegister');
        Route::prefix('home')->name('home.')->group(function () {
            Route::get('/index', [HomeController::class, 'index'])->name('index');
            Route::get('/get-districts', [HomeController::class, 'getDistricts'])->name('getDistricts');
        });

        Route::prefix('yardlist')->name('yardlist.')->group(function () {
            Route::get('/index', [YardListController::class, 'index'])->name('index');
            Route::get('/get-districts', [YardListController::class, 'getDistricts'])->name('getDistricts');
        });

        Route::prefix('yarddetail')->name('yarddetail.')->group(function () {
            Route::get('/index', [YardDetailController::class, 'index'])->name('index');
        });

        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/index', [ProfileController::class, 'index'])->name('index');
            Route::post('/update', [ProfileController::class, 'updateProfile'])->name('update');
            Route::post('/password_update', [ProfileController::class, 'updatePassword'])->name('updatePassword');
            Route::get('/detail/{id}', [ProfileController::class, 'detail'])->name('detail');
            Route::get('/get-provinces', [ProfileController::class, 'getProvinces'])->name('getProvinces');
            Route::get('/get-districts', [ProfileController::class, 'getDistricts'])->name('getDistricts');
        });

        Route::prefix('choice_yard')->name('choice_yard.')->group(function () {
            Route::get('/index', [ChoiceYardController::class, 'index'])->name('index');
        });

        Route::prefix('invoice')->name('invoice.')->group(function () {
            Route::get('/index', [InvoiceController::class, 'index'])->name('index');
        });

        Route::prefix('policy')->name('policy.')->group(function () {
            Route::get('/index', [PolicyController::class, 'index'])->name('index');
        });

        Route::prefix('clause')->name('clause.')->group(function () {
            Route::get('/index', [ClauseController::class, 'index'])->name('index');
        });

        Route::prefix('privacy_policy')->name('privacy_policy.')->group(function () {
            Route::get('/index', [PrivacyPolicyController::class, 'index'])->name('index');
        });

        Route::prefix('cancellation_policy')->name('cancellation_policy.')->group(function () {
            Route::get('/index', [CancellationPolicyController::class, 'index'])->name('index');
        });

        Route::prefix('commodity_policy')->name('commodity_policy.')->group(function () {
            Route::get('/index', [CommodityPolicyController::class, 'index'])->name('index');
        });

        Route::prefix('payment_policy')->name('payment_policy.')->group(function () {
            Route::get('/index', [PaymentPolicyController::class, 'index'])->name('index');
        });

        Route::prefix('voucher')->name('voucher.')->group(function () {
            Route::get('/index', [UserVoucherController::class, 'index'])->name('index');
            Route::post('/exchange-voucher', [UserVoucherController::class, 'exchangeVoucher'])->name('exchangeVoucher');
        });

        Route::prefix('my_voucher')->name('my_voucher.')->group(function () {
            Route::get('/index', [MyVoucherController::class, 'index'])->name('index');
        });
    });
});
