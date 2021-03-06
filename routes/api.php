<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('booking', 'BookingController')->except(['create', 'edit', 'show'])->middleware('auth:api');
Route::resource('client', 'ClientController')->except(['create', 'edit', 'show'])->middleware('auth:api');
Route::resource('pet', 'PetController')->except(['create', 'edit', 'show'])->middleware('auth:api');
Route::resource('pet-type', 'PetTypeController')->except(['create', 'edit', 'show'])->middleware('auth:api');
Route::resource('service', 'ServiceController')->except(['create', 'edit', 'show'])->middleware('auth:api');
