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
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UserController@index')->name('dashboard_all_users');
        Route::get('/{id}', 'UserController@show')->name('dashboard_show_user');
        Route::post('/{id}', 'UserController@update')->name('dashboard_update_user');
        Route::delete('/{id}', 'UserController@destroy')->name('dashboard_remove_user');
    });

    // Location Resource
    Route::group(['prefix' => 'locations'], function() {
        Route::get('/', 'LocationController@index')->name('dashboard_all_locations');
        Route::get('/add', 'LocationController@create')->name('dashboard_add_location');
        Route::get('/{name}', 'LocationController@show')->name('dashboard_location_details');
    });

    // Settings/Account Resource
    Route::group(['prefix' => 'settings'], function() {
        Route::get('/', 'AccountController@settings')->name('dashboard_settings');
        Route::get('/profile-image', 'AccountController@profile_picture')->name('dashboard_change_profile');
        Route::post('/update-image', 'AccountController@change_picture')->name('dashboard_update_profile_image');
        Route::post('/update-location', 'AccountController@change_location')->name('dashboard_update_profile_location');
        Route::post('/update-user', 'AccountController@update_user')->name('dashboard_update_user');
        Route::delete('/delete-user', 'AccountController@delete_user')->name('dashboard_delete_user');
    });

    Route::group(['prefix' => 'reports'], function() {
        Route::get('/', 'ReportsController@index')->name('dashboard_all_reports');
    });

    Route::get('/chart/data', 'DashboardController@update_chart');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/ajax/get/streets', 'HomeController@get_streets_where')->name('ajax_get_streets');
Route::post('/ajax/get/all_streets', 'HomeController@get_streets')->name('ajax_get_all_streets');
