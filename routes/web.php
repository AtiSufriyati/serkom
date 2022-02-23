<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/customer', 'CustomerController@index')->name('customer');
Route::post('/logout', 'AuthController@logout')->name('auth.logout');
Route::group(['prefix' => 'login'], function () {
    Route::get('/', 'AuthController@login')->name('auth.login');
    Route::post('/dologin', 'AuthController@dologin')->name('auth.dologin');
});


Route::group(['prefix' => 'customer'], function () {
    Route::get('/', 'CustomerController@index')->name('customer');
    Route::post('/submit', 'CustomerController@submit')->name('submit.customer');
    Route::get('/get_customer', 'CustomerController@get_customer')->name('get.customer');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserController@index')->name('user');
    Route::post('/submit', 'UserController@submit')->name('submit.user');
    Route::get('/get_user', 'UserController@get_user')->name('get.user');
});

Route::group(['prefix' => 'price'], function () {
    Route::get('/', 'PriceController@index')->name('price');
    Route::post('/submit', 'PriceController@submit')->name('submit.price');
    Route::get('/get_price', 'PriceController@get_price')->name('get.price');
});
Route::group(['prefix' => 'level'], function () {
    Route::get('/', 'LevelController@index')->name('level');
    Route::post('/submit', 'LevelController@submit')->name('submit.level');
    Route::get('/get_level', 'LevelController@get_level')->name('get.level');
});
Route::group(['prefix' => 'payment'], function () {
    Route::get('/', 'PaymentController@index')->name('payment');
    Route::post('/submit', 'PaymentController@submit')->name('submit.payment');
    Route::get('/get_payment', 'PaymentController@get_payment')->name('get.payment');
    Route::get('/get_usage', 'PaymentController@get_usage')->name('get.usage');

});
Route::group(['prefix' => 'usage'], function () {
    Route::get('/', 'UsageController@index')->name('usage');
    Route::post('/submit', 'UsageController@submit')->name('submit.usage');
    Route::get('/get_usage', 'UsageController@get_usage')->name('get.usage');
});



