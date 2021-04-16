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

Route::get('/', 'HomeController@landing')->name('landing_page');

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function() {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    // User Resource
    Route::get('/users', 'UserController@index')->name('dashboard_all_users');
    Route::get('/user/{id}', 'UserController@show')->name('dashboard_show_user');
    Route::post('/user/{id}', 'UserController@update')->name('dashboard_update_user');
    Route::delete('/user/{id}', 'UserController@destroy')->name('dashboard_remove_user');

    // Location Resource
    Route::get('/locations', 'LocationController@index')->name('dashboard_all_locations');
    Route::get('/locations/add', 'LocationController@create')->name('dashboard_add_location');
    Route::get('/locations/{name}', 'LocationController@show')->name('dashboard_location_details');

    Route::get('/settings', 'DashboardController@settings')->name('dashboard_settings');
});

Route::get('/firebase', 'FirebaseController@index');
Route::get('/home', 'HomeController@index')->name('home');
