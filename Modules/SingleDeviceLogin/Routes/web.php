<?php

use Illuminate\Support\Facades\Route;
use Modules\SingleDeviceLogin\Http\Controllers\SingleDeviceLoginController;

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
    Route::group(['middleware' => ['xss', 'admin', 'TimeZone'], 'prefix' => 'users-device'], function () {
        Route::get('/', [SingleDeviceLoginController::class, 'index'])->name('users_device.index')->middleware('PermissionCheck:user_device_list');
        Route::get('/reset-device/{user_id}/{device_type}', [SingleDeviceLoginController::class, 'resetDevice'])->name('user.resetDevice')->middleware('PermissionCheck:reset_device');
    });
});
