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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('change-password', '\App\Http\Controllers\Auth\ChangePasswordController@index')->name('password.changeform');
// Should this route be in the API
Route::post('change-password', '\App\Http\Controllers\Auth\ChangePasswordController@store')->name('password.change');

Route::get('/home', 'HomeController@index')->name('home');

// Route::resource('booking', 'BookingController');

Route::resource('booking', 'BookingController')->only('show');
