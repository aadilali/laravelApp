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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-user', 'UserController@admin_function');
    Route::delete('/events/{id}', 'EventsPostController@destroy');

    Route::delete('/bookings/{id}', 'EventsBookingController@destroy');
});

Route::middleware(['auth', 'role:admin|vendor'])->group(function () {
    Route::get('/staff-user', 'UserController@staff_function');
    
    Route::post('/events', 'EventsPostController@store');
    Route::put('/events/{id}', 'EventsPostController@update');

    Route::get('/booking', 'EventBookingController@index');
    Route::get('/events/list', 'EventsPostController@getAll');

});

Route::middleware(['auth', 'role:admin|customer'])->group(function () {
    Route::get('/customer-user', 'UserController@customer_function');

    Route::get('/booking', 'EventBookingController@index');
    Route::post('/booking', 'EventBookingController@store');
    
    Route::get('/order', 'OrdersController@index');
    Route::post('/order', 'OrdersController@store');
});

Route::get('/get-user', 'UserController@index');

Route::post('/login','Auth\LoginController@authenticate');

Route::post('/register','Auth\RegisterController@create');
Route::post('/register-vendor','Auth\RegisterController@createVendor');

Route::get('/events/featured-list', 'EventsPostController@featuredList');
Route::get('/events/{category}', 'EventsPostController@index');
Route::get('/events/{category}/{subcategory}', 'EventsPostController@subcatEvents');
Route::get('/events/{id}', 'EventsPostController@show');
Route::get('/events-search/{searchText}', 'EventsPostController@searchEvents');

