<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect('/search');
});
Route::get('/home', function () {
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
    });

Route::get('/{page}', 'PageController')
    ->name('page')
    ->where('page', 'about|services|contact');
