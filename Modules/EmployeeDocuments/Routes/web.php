<?php
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

Route::middleware(['demo.mode'])->group(function () {
    Route::middleware(['xss', 'TimeZone', 'MaintenanceMode', 'admin'])->group(function () {
        Route::prefix('documents')->group(function () {
            Route::get('/list', 'UserDocumentController@index')->name('documents.index');
            Route::get('/document-tbody', 'UserDocumentController@documentTbody')->name('documents.tbody');
            Route::post('/user-documents', 'UserDocumentController@store')->name('documents.store');

            Route::get('/types', 'UserDocumentController@types')->name('documents.types.index');
            Route::get('types/edit/{id}', 'UserDocumentController@typeEdit')->name('documents.types.edit');
            Route::get('types/delete/{id}', 'UserDocumentController@typeDelete')->name('documents.types.delete');
            Route::get('types/create', 'UserDocumentController@typeCreate')->name('documents.types.create');
            Route::post('types/store', 'UserDocumentController@typeStore')->name('documents.types.store');
            Route::any('types/update', 'UserDocumentController@typeUpdate')->name('documents.types.update');
            Route::get('type-tbody', 'UserDocumentController@typeTbody')->name('documents.types.tbody');

            // routes/web.php or routes/api.php

            Route::get('/user-documents/create', 'UserDocumentController@create')->name('user-documents.create');
            Route::get('/user-documents/{id}', 'UserDocumentController@show')->name('user-documents.show');
            Route::get('/user-documents/{id}/edit', 'UserDocumentController@edit')->name('user-documents.edit');
            Route::put('/user-documents/{id}', 'UserDocumentController@update')->name('user-documents.update');
            Route::delete('/user-documents/{id}', 'UserDocumentController@destroy')->name('user-documents.destroy');

        });
    });
});
