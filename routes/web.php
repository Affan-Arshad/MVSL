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

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', 'PageController@home')->name('home');
Route::get('/about', 'PageController@about')->name('about');
Route::get('/services', 'PageController@services')->name('services');
Route::get('/contact', 'PageController@contact')->name('contact');

Route::resource('signs', 'SignController');
