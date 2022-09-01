<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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

Route::middleware(['role:Editor|Super-Admin'])
    ->namespace('Admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resources([
            'signs' => 'SignController',
            'users' => 'UserController',
            'roles' => 'RoleController'
        ]);

        Route::get('/changePassword', [UserController::class, 'changePasswordForm'])->name('changePasswordForm');
        Route::post('/changePassword', [UserController::class, 'changePassword'])->name('changePassword');

        Route::name('users.')->prefix('users')->group(function () {
            Route::put('/{id}/toggleStatus', [UserController::class, 'toggleStatus'])->name('toggleStatus');
        });
    });

Route::get('/{page}', 'PageController')
    ->name('page')
    ->where('page', 'about|services|contact');
