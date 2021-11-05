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

Route::get('/', 'App\Http\Controllers\DashboardController@index')->name('index');
Route::get('/logout', '\App\Http\Controllers\Auth\AuthenticatedSessionController@destroy');
Route::get('/login', '\App\Http\Controllers\Auth\AuthenticatedSessionController@create')->name('login');

Route::post('/register', '\App\Http\Controllers\Auth\RegisteredUserController@store')->name('register');

Route::group(['middleware' => ['auth', 'role:admin'], ] ,function () {
    Route::prefix('admin')->name('admin.')->group(function() {

        Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');

        Route::prefix('levis')->name('levis.')->group(function() {
            Route::get('', 'App\Http\Controllers\LevisController@index')->name('index');
            Route::get('apiData', 'App\Http\Controllers\LevisController@apiData')->name('apiData');
            Route::post('update', 'App\Http\Controllers\LevisController@update')->name('update');
            Route::post('save', 'App\Http\Controllers\LevisController@save')->name('save');
            Route::get('edit', 'App\Http\Controllers\LevisController@edit')->name('edit');
            Route::post('delete', 'App\Http\Controllers\LevisController@delete')->name('delete');

            // SELETC2
            Route::get('/getType','App\Http\Controllers\LevisController@getType')->name('getType');
            Route::get('/getBrand','App\Http\Controllers\LevisController@getBrand')->name('getBrand');
        });

        Route::prefix('brand')->name('brand.')->group(function() {
            Route::get('', 'App\Http\Controllers\BrandController@index')->name('index');
            Route::get('apiData', 'App\Http\Controllers\BrandController@apiData')->name('apiData');
            Route::post('update', 'App\Http\Controllers\BrandController@update')->name('update');
            Route::post('save', 'App\Http\Controllers\BrandController@save')->name('save');
            Route::get('edit', 'App\Http\Controllers\BrandController@edit')->name('edit');
            Route::post('delete', 'App\Http\Controllers\BrandController@delete')->name('delete');
        });

        Route::prefix('type')->name('type.')->group(function() {
            Route::get('', 'App\Http\Controllers\TypeController@index')->name('index');
            Route::get('apiData', 'App\Http\Controllers\TypeController@apiData')->name('apiData');
            Route::post('update', 'App\Http\Controllers\TypeController@update')->name('update');
            Route::post('save', 'App\Http\Controllers\TypeController@save')->name('save');
            Route::get('edit', 'App\Http\Controllers\TypeController@edit')->name('edit');
            Route::post('delete', 'App\Http\Controllers\TypeController@delete')->name('delete');
        });
    });
});

require __DIR__.'/auth.php';
