<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\Dashboard\AdminsController;
use Modules\Users\Http\Controllers\Dashboard\RoleController;

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::prefix('roles')->group(function() {
        Route::get('/list', [RoleController::class, 'datatableList'])->name('roles.datatableList');
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->middleware('permission:roles.create')->name('roles.create');
        Route::post('/', [RoleController::class, 'store'])->middleware('permission:roles.create')->name('roles.store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:roles.edit')->name('roles.edit');
        Route::put('/{role}/update', [RoleController::class, 'update'])->middleware('permission:roles.edit')->name('roles.update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware('permission:roles.delete')->name('roles.destroy');
    });

    Route::prefix('admins')->group(function() {
        Route::get('/list', [AdminsController::class, 'datatableList'])->name('admins.datatableList');
        Route::get('/', [AdminsController::class, 'index'])->middleware('permission:admins.show')->name('admins.index');
        Route::get('/create', [AdminsController::class, 'create'])->middleware('permission:admins.create')->name('admins.create');
        Route::post('/', [AdminsController::class, 'store'])->middleware('permission:admins.create')->name('admins.store');
        Route::get('/{admin}/edit', [AdminsController::class, 'edit'])->middleware('permission:admins.edit')->name('admins.edit');
        Route::put('/{admin}/update', [AdminsController::class, 'update'])->middleware('permission:admins.edit')->name('admins.update');
        Route::delete('/{admin}', [AdminsController::class, 'destroy'])->middleware('permission:admins.delete')->name('admins.destroy');
    });

    Route::prefix('profile')->group(function() {
        Route::get('/edit', [AdminsController::class, 'editProfile'])->name('admins.profile.edit');
        Route::put('/update', [AdminsController::class, 'updateProfile'])->name('admins.profile.update');
    });
});

