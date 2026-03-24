<?php

use Illuminate\Support\Facades\Route;

// LOGIN
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\auth\ResetPasswordController;

// BACKEND
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\VideoController;

use App\Http\Controllers\CkanController;

Route::get('/', function () {
    return view('welcome');
});

// ==================== LOGIN ====================
Route::middleware('guest')->group(function () {
    //Login
    Route::get('/saritalogin', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/saritalogin', [AuthController::class, 'login'])->name('login.submit');

    // Forgot password
    Route::get('/password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    // Reset password
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== BACKEND ====================
 Route::get('/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');

 Route::resource('/user', UserController::class);

 Route::resource('/video', VideoController::class);


  // Hanya superadmin yang boleh kelola
    // Route::middleware(['role:superadmin'])->group(function () {

    //     Route::resource('/user', UserController::class);
        
    // });



Route::prefix('ckan')->controller(CkanController::class)->group(function () {
    // Main pages
    Route::get('/', 'index')->name('ckan.index');
    Route::get('/search', 'search')->name('ckan.search');

    // Datasets CRUD
    Route::get('/create', 'create')->name('ckan.create');
    Route::post('/store', 'store')->name('ckan.store');
    Route::get('/dataset/{id}', 'show')->name('ckan.show');
    Route::get('/dataset/{id}/edit', 'edit')->name('ckan.edit');
    Route::put('/dataset/{id}', 'update')->name('ckan.update');
    Route::delete('/dataset/{id}', 'destroy')->name('ckan.destroy');

    // Resources
    Route::post('/resource/upload', 'uploadResource')->name('ckan.resource.upload');
    Route::post('/datastore/{resourceId}', 'queryDataStore')->name('ckan.datastore');

    // Organizations
    Route::get('/organizations', 'organizations')->name('ckan.organizations');
    Route::get('/organization/{id}', 'showOrganization')->name('ckan.organization');

    // API
    Route::get('/health', 'health')->name('ckan.health');

    Route::get('/datasets', 'datasets')->name('ckan.datasets');

    Route::post('/dataset/{id}/track-view', 'trackView')->name('ckan.track-view');

    Route::get('/dataset/{datasetId}/resource/{resourceId}/preview', 'previewData')
        ->name('ckan.resource.preview');

    // ✅ API endpoint untuk AJAX load data
    Route::get('/api/dataset/{datasetId}/resource/{resourceId}/data', 'apiGetData')
        ->name('ckan.resource.api');
});

/*
|--------------------------------------------------------------------------
| API Routes (for external access)
|--------------------------------------------------------------------------
*/
Route::prefix('api/ckan')->group(function () {
    Route::get('/health', [CkanController::class, 'health']);
    Route::get('/datasets', [CkanController::class, 'search']);
    Route::get('/datasets/{id}', [CkanController::class, 'show']);
    Route::get('/organizations', [CkanController::class, 'organizations']);
    Route::get('/organizations/{id}', [CkanController::class, 'showOrganization']);
});