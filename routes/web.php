<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CkanController;

Route::get('/', function () {
    return view('welcome');
});




Route::prefix('ckan')->controller(CkanController::class)->group(function () {
    // Main pages
    Route::get('/', 'index')->name('frontend.index');
    Route::get('/search', 'search')->name('frontend.search');

    // Datasets CRUD
    Route::get('/create', 'create')->name('frontend.create');
    Route::post('/store', 'store')->name('frontend.store');
    Route::get('/dataset/{id}', 'show')->name('frontend.show');
    Route::get('/dataset/{id}/edit', 'edit')->name('frontend.edit');
    Route::put('/dataset/{id}', 'update')->name('frontend.update');
    Route::delete('/dataset/{id}', 'destroy')->name('frontend.destroy');

    // Resources
    Route::post('/resource/upload', 'uploadResource')->name('frontend.resource.upload');
    Route::post('/datastore/{resourceId}', 'queryDataStore')->name('frontend.datastore');

    // Organizations
    Route::get('/organizations', 'organizations')->name('frontend.organizations');
    Route::get('/organization/{id}', 'showOrganization')->name('frontend.organization');

    // API
    Route::get('/health', 'health')->name('frontend.health');

    Route::get('/datasets', 'datasets')->name('frontend.datasets');

    Route::post('/dataset/{id}/track-view', 'trackView')->name('frontend.track-view');

    Route::get('/dataset/{datasetId}/resource/{resourceId}/preview', 'previewData')
        ->name('frontend.resource.preview');

    // ✅ API endpoint untuk AJAX load data
    Route::get('/api/dataset/{datasetId}/resource/{resourceId}/data', 'apiGetData')
        ->name('frontend.resource.api');
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