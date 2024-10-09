<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LicenseController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/auth/login')->name('root');

Route::controller(AuthController::class)->prefix('auth')->group(function () {
	Route::get('/login', 'login')->name('login');
	Route::post('/login', 'loginAction')->name('login.action');
	Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::middleware('auth')->group(function () {
	Route::controller(AdminController::class)
		->prefix('admin')
		->group(function () {
			Route::get('/licenses', 'licenses')->name('admin.licenses');
			Route::get('/api-consume', 'api_consume')->name('admin.api-consume');
			Route::get('/profile', 'profile')->name('admin.profile');
		});

	Route::controller(LicenseController::class)
		->prefix('admin/license')
		->group(function () {
			Route::get('/create', 'create')->name('license.create');
			Route::get('/edit/{license}', 'edit')->name('license.edit');
			Route::post('/generate', 'generate')->name('license.generate');
			Route::put('/update/{license}', 'update')->name('license.update');
			Route::delete('/destroy/{license}', 'destroy')->name('license.destroy');
		});
});
