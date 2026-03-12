<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CkanController;

Route::get('/', function () {
    return view('welcome');
});




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