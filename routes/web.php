<?php

use App\Http\Controllers\AdminTriageController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\auth\NewPasswordController;
use App\Http\Controllers\auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TriageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Guest Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::prefix('/triage')
    ->name('triage.')
    ->controller(TriageController::class)
    ->group(function () {
        Route::get('/step/1', 'triageStepOne')->name('step.one');
        Route::post('/step/1', 'triageStepOneProcess')->name('step.one.process');
        Route::get('/step/2', 'triageStepTwo')->name('step.two');
        Route::post('/step/2', 'triageStepTwoProcess')->name('step.two.process');
        Route::get('/result', 'triagePredictionResult')->name('prediction.result');
});
/*
|--------------------------------------------------------------------------
| Authentication Route
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginRegisterController::class, 'loginView'])->name('login');
        Route::post('login', [LoginRegisterController::class, 'login'])->name('authenticate');

        // Route::get('register', [LoginRegisterController::class, 'registerView'])->name('register');
        // Route::post('register', [LoginRegisterController::class, 'register'])->name('registering');

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('logout', [LoginRegisterController::class, 'logout'])->name('logout');
    });
});

Route::controller(VerificationController::class)->middleware('auth')->group(function () {
    Route::get('/email/verify', 'notice')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verify')
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/resend', 'resend')
        ->middleware('throttle:6,1')
        ->name('verification.resend');
});

/*
|--------------------------------------------------------------------------
| Admin Route
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::middleware(['auth'])->group(function () {
            Route::controller(ProfileController::class)->group(function () {
                Route::get('profile', 'myprofile')->name('users.profile.edit');
                Route::patch('profile', 'updateProfile')->name('users.profile.update');
                Route::patch('profile-password', 'updatePassword')->name('users.password.update');
            });

            Route::middleware(App\Http\Middleware\Permission::class)->group(function () {
                Route::get('dashboard', [AdminTriageController::class, 'index'])->name('dashboard');

                Route::resource('users', UserController::class)->except(['create', 'edit']);

                Route::controller(RolesAndPermissionsController::class)->group(function () {
                    Route::get('roles', 'index')->name('roles.index');
                    Route::get('role/{role}', 'show')->name('roles.show');
                    Route::post('role', 'store')->name('roles.store');
                    Route::put('role/{role}', 'update')->name('roles.update');
                    Route::delete('role/{role}', 'destroy')->name('roles.delete');
                });

                Route::controller(AdminTriageController::class)->group(function () {
                    Route::get('triage/step/1', 'triageStepOne')->name('triage.step.one');
                    Route::post('triage/step/1', 'triageStepOneProcess')->name('triage.step.one.process');
                    Route::get('triage/reset', 'triageStepOneProcessReset')->name('triage.step.one.process.reset');
                    Route::get('triage/step/2', 'triageStepTwo')->name('triage.step.two');
                    Route::post('triage/step/2', 'triageStepTwoProcess')->name('triage.step.two.process');
                    Route::get('triage/step/validation', 'triageValidation')->name('triage.validation');
                    Route::post('triage/step/validation', 'triageValidationProcess')->name('triage.validation.process');
                    Route::delete('triage/{triage?}', 'destroy')->name('triage.delete');
                });
            });
        });
    });
