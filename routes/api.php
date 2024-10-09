<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiLicenseController;
use Illuminate\Support\Facades\Route;

// Routes untuk License API
Route::controller(ApiLicenseController::class)->prefix('license')->group(function () {
	Route::get('/', 'index')->name('api.license.index');
	Route::get('/show/{license}', 'show')->name('api.license.show');
	Route::get('/edit/{license}', 'edit')->name('api.license.edit');
	Route::post('/generate', 'generate')->name('api.license.generate');
	Route::put('/update/{license}', 'update')->name('api.license.update');
	Route::delete('/destroy/{license}', 'destroy')->name('api.license.destroy');
});

Route::controller(ApiAuthController::class)->prefix('auth')->group(function () {
	Route::post('/login', 'loginAction')->name('api.login.action');
	Route::post('/logout', 'logout')->name('api.logout');
});
