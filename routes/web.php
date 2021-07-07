<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\Video\CategoryController;
use App\Http\Controllers\AuthorizeController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Vendor\Auth\ForgotPasswordController as VendorForgotPasswordController;
use App\Http\Controllers\Vendor\Auth\LoginController as VendorLoginController;
use App\Http\Controllers\Vendor\Auth\ResetPasswordController as VendorResetPasswordController;
use App\Http\Controllers\Vendor\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;




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

Auth::routes(['verify' => true]);


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AdminLoginController::class, 'login'])->name('login');
    Route::get('logout', [AdminLoginController::class, 'logout'])->name('logout');

    // Admin Password Reset
    Route::get('password/request', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/sendEmail', [AdminForgotPasswordController::class, 'sendResetCodeEmail'])->name('password.send.code');
    Route::post('password/verify-code', [AdminForgotPasswordController::class, 'verifyCode'])->name('password.verify.code');
    Route::get('password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('password/reset/change', [AdminResetPasswordController::class, 'reset'])->name('password.change');


    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('profile', [AdminController::class, 'profileUpdate'])->name('profile.update');
        Route::get('password', [AdminController::class, 'password'])->name('password');
        Route::post('password', [AdminController::class, 'passwordUpdate'])->name('password.update');

        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/list', [AdminUserController::class, 'userList'])->name('list');
            Route::get('/show/{id}', [AdminUserController::class, 'show'])->name('show');
            Route::post('/update/{id}', [AdminUserController::class, 'update'])->name('update');
            Route::get('/active/list', [AdminUserController::class, 'activeList'])->name('active.list');
            Route::get('/banned/list', [AdminUserController::class, 'bannedList'])->name('banned.list');
            Route::get('/email-unverified/list', [AdminUserController::class, 'emailUnverifiedList'])->name('email.unverified.list');
            Route::get('/send/email/all', [AdminUserController::class, 'sendEmailAll'])->name('email.send.all');
            Route::post('email/send', [AdminUserController::class, 'sendEmail'])->name('email.send');
        });

        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('update', [SettingController::class, 'update'])->name('update');
            Route::get('email', [SettingController::class, 'email'])->name('email');
            Route::post('email-configure', [SettingController::class, 'emailConfigure'])->name('email.configure');
            Route::post('email-template', [SettingController::class, 'emailTemplate'])->name('email.template');
        });

        Route::get('/payment-list', [TransactionController::class, 'payment_list'])->name('payment.list');
        Route::get('/transaction-list', [TransactionController::class, 'transaction_list'])->name('transaction.list');

        // Email Log
        Route::get('/email-log', [SettingController::class, 'emailLog'])->name('email.log');
        Route::get('/email-show/{id}', [SettingController::class, 'emailShow'])->name('email.show');

        //Payment Gateways
        Route::prefix('payment/gateways')->name("payment.gateway.")->group(function () {
            Route::get('/list', [PaymentGatewayController::class, 'list'])->name('list');
            Route::get('/edit/{id}', [PaymentGatewayController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [PaymentGatewayController::class, 'update'])->name('update');
            Route::get('/active/{id}', [PaymentGatewayController::class, 'active'])->name('active');
            Route::get('/deactive/{id}', [PaymentGatewayController::class, 'deactive'])->name('deactive');
        });
        //Language Manger
        Route::prefix('language')->name('language.')->group(function () {

            Route::get('list', [LanguageController::class, 'list'])->name('list');
            Route::post('store', [LanguageController::class, 'store'])->name('store');
            Route::post('update', [LanguageController::class, 'update'])->name('update');
            Route::post('destroy', [LanguageController::class, 'destroy'])->name('destroy');

            Route::get('default/{id}', [LanguageController::class, 'default'])->name('default');

            Route::prefix('translate')->name('translate.')->group(function () {
                Route::get('create/{id}', [LanguageController::class, 'translateCreate'])->name('create');
                Route::post('update/{id}', [LanguageController::class, 'translateUpdate'])->name('update');

                Route::prefix('key')->name('key.')->group(function () {
                    Route::post('update/{id}', [LanguageController::class, 'translateUpdateByKey'])->name('update');
                    Route::post('destroy/{id}', [LanguageController::class, 'translateDestroyByKey'])->name('destroy');
                });
            });
        });

        // Plan Manager
        Route::prefix('plans')->name('plan.')->group(function () {
            Route::get('list', [PlanController::class, 'list'])->name('list');
            Route::get('create', [PlanController::class, 'create'])->name('create');
            Route::post('store', [PlanController::class, 'store'])->name('store');
            Route::get('edit/{plan}', [PlanController::class, 'edit'])->name('edit');
            Route::post('update/{plan}', [PlanController::class, 'update'])->name('update');

            Route::get('active/{plan}', [PlanController::class, 'active'])->name('active');
            Route::get('deactive/{plan}', [PlanController::class, 'deactive'])->name('deactive');
        });

        // Video Manager
        Route::prefix('video')->name('video.')->group(function () {

            Route::prefix('category')->name('category.')->group(function () {
                Route::get('list', [CategoryController::class, 'list'])->name('list');
                Route::post('store', [CategoryController::class, 'store'])->name('store');
                Route::post('update', [CategoryController::class, 'update'])->name('update');
            });
        });
    });
});


/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
*/

Route::prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/', [VendorLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [VendorLoginController::class, 'login'])->name('login');
    Route::get('logout', [VendorLoginController::class, 'logout'])->name('logout');

    // Vendor Password Reset
    Route::get('password/reset', [VendorForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
    Route::post('password/reset', [VendorForgotPasswordController::class, 'sendResetCodeEmail']);
    Route::post('password/verify-code', [VendorForgotPasswordController::class, 'verifyCode'])->name('password.verify.code');
    Route::get('password/reset/{token}', [VendorResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('password/reset/change', [VendorResetPasswordController::class, 'reset'])->name('password.change');


    Route::middleware('vendor')->group(function () {
        Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [VendorController::class, 'profile'])->name('profile');
        Route::post('profile', [VendorController::class, 'profileUpdate'])->name('profile.update');
        Route::get('password', [VendorController::class, 'password'])->name('password');
        Route::post('password', [VendorController::class, 'passwordUpdate'])->name('password.update');
    });
});

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::prefix('user')->name('user.')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('email-verify-form', [AuthorizeController::class, 'authorizForm'])->name('authorize.form');
        Route::get('resend-code', [AuthorizeController::class, 'resendCode'])->name('authorize.resend');

        Route::middleware('verified')->group(function () {
            Route::get('dashboard', [HomeController::class, 'index'])->name('index');
            Route::get('profile', [HomeController::class, 'profile'])->name('profile');
            Route::post('profile', [HomeController::class, 'profileUpdate'])->name('profile.update');
            Route::get('password', [HomeController::class, 'password'])->name('password');
            Route::post('password', [HomeController::class, 'passwordUpdate'])->name('password.update');

            // Deposit Methods
            Route::prefix('deposit')->name('deposit.')->group(function () {
                Route::get('/gateway', [HomeController::class, 'selector'])->name('selector');
                Route::post('/gateway/save-payment-info', [HomeController::class, 'savePaymentInfo'])->name('save.payment.info');

                Route::get('set', [HomeController::class, 'setDepositAmount'])->name('set.amount');
                Route::get('history', [HomeController::class, 'history'])->name('history');
                Route::post('money', [HomeController::class, 'depositMoney'])->name('money');
            });

            Route::get('billing-portal', function (Request $request) {
                return $request->user()->redirectToBillingPortal();
            });

            //Plan Routes
            Route::get('/plans', [PurchaseController::class, 'plan'])->name('plan');
            Route::get('/plan-purchase/{plan}', [PurchaseController::class, 'purchase'])->name('purchase.plan');

            // Upload Routes
            Route::middleware('isUserSubscribed')->group(function () {
                Route::get('/upload', [UploadController::class, 'upload'])->name('upload');
                Route::get('/videos', [UploadController::class, 'videos'])->name('videos');
                Route::post('check-ext-size', [UploadController::class, 'checkExtSize'])->name('check.ext.size');
                Route::post('/store-upload', [UploadController::class, 'store'])->name('upload.store');
                Route::get('/video-details-edit', [UploadController::class, 'videoDetailsEdit'])->name('video.details.edit');
                Route::post('/video-details-update', [UploadController::class, 'videoDetailsUpdate'])->name('video.details.update');

                Route::post('/convert-upload', [UploadController::class, 'convertToObject'])->name('upload.convert');
            });
        });
    });
});


/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [FrontendController::class,'main'])->name('main');
Route::get('/watch', [FrontendController::class,'main'])->name('main');

Route::get('/change/language', [FrontendController::class, 'changeLanguage'])->name('change.language');
