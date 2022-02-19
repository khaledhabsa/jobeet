<?php

use Modules\Users\Http\Controllers\Api\DriverController;
use Modules\Users\Http\Controllers\Api\ModeratorController;
use Modules\Users\Http\Controllers\Api\PermissionController;
use Modules\Users\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;
use Modules\Users\Http\Controllers\Api\UsersController;
use Modules\Users\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(['localization'])->group(function() {
    Route::group(['middleware' => 'auth:api'], function () {
            Route::group(['prefix' => 'employee-signup'], function () {
                Route::post('/', [ModeratorController::class, 'store']);
            });

            Route::get('logout', [AuthController::class, 'logout']);
            Route::get('get-profile', [UsersController::class, 'getProfile']);
            Route::post('set-profile', [UsersController::class, 'updateProfile']);

            Route::group(['prefix' => 'profile'], function () {
                Route::post('update-image', [UsersController::class, 'updateProfileImage']);
                Route::post('update-email', [UsersController::class, 'updateProfileEmail']);
                Route::post('update-name', [UsersController::class, 'updateProfileName']);
            });

            Route::prefix('roles')->group(function() {
                Route::get('/', [RoleController::class, 'index'])->middleware(['permission:roles.show'])->name('roles.api.index');
                Route::post('/', [RoleController::class, 'store'])->middleware('permission:roles.create')->name('roles.api.store');
                Route::get('/{role}/show', [RoleController::class, 'show'])->middleware('permission:roles.show')->name('roles.api.show');
                Route::put('/{role}/update', [RoleController::class, 'update'])->middleware('permission:roles.edit')->name('roles.api.update');
                Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware('permission:roles.delete')->name('roles.api.destroy');
            });

            Route::prefix('permissions')->group(function() {
                Route::get('/', [PermissionController::class, 'index'])->name('permissions.api.index')->middleware('permission:roles.create|role.edit');
            });
        });

    Route::post('company-register', [AuthController::class, 'companyRegister']);
    Route::post('login', [AuthController::class, 'login']);

    Route::post('preferences-localization', [UsersController::class, 'setPreferencesLocalization']);
});
