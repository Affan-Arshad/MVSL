<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SignController;
use App\Http\Controllers\Admin\UserController;

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

Route::get('/', function () {
    Session()->reflash();
    return redirect('/search');
});
Route::get('/home', function () {
    Session()->reflash();
    return redirect('/search');
});

Auth::routes(['register' => false]);

Route::resource('signs', 'SignController');

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::namespace('Admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // admin sign routes
        Route::get('/signs', [SignController::class, 'index'])->middleware('permission:create_signs|edit_signs|delete_signs')->name('signs.index');
        Route::get('/signs/create', [SignController::class, 'create'])->middleware('permission:create_signs')->name('signs.create');
        Route::post('/signs', [SignController::class, 'store'])->middleware('permission:create_signs')->name('signs.store');
        Route::get('/signs/{sign}/edit', [SignController::class, 'edit'])->middleware('permission:edit_signs')->name('signs.edit');
        Route::put('/signs/{sign}', [SignController::class, 'update'])->middleware('permission:edit_signs')->name('signs.update');
        Route::delete('/signs/{sign}', [SignController::class, 'destroy'])->middleware('permission:delete_signs')->name('signs.destroy');

        // admin user routes
        Route::get('/users', [UserController::class, 'index'])->middleware('permission:create_users|edit_users|delete_users')->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->middleware('permission:create_users')->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->middleware('permission:create_users')->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->middleware('permission:edit_users')->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->middleware('permission:edit_users')->name('users.update');
        Route::delete('/users/{id}/toggleStatus', [UserController::class, 'toggleStatus'])->middleware('permission:delete_users')->name('users.toggleStatus');

        // admin role routes
        Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:create_roles|edit_roles|delete_roles')->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->middleware('permission:create_roles')->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:create_roles')->name('roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:edit_roles')->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:edit_roles')->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:delete_roles')->name('roles.destroy');
    });

Route::get('/changePassword', [UserController::class, 'changePasswordForm'])->name('changePasswordForm');
Route::post('/changePassword', [UserController::class, 'changePassword'])->name('changePassword');

Route::get('/{page}', 'PageController')
    ->name('page')
    ->where('page', 'about|services|contact');
