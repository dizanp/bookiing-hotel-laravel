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

//Frontend Controller
Route::get('/', 'FrontController@index');
Route::get('/item/{slug}', 'FrontController@item');
Route::get('/data', 'FrontController@data');
Route::get('/login', 'FrontController@login');
Route::get('/register', 'FrontController@register');
Route::get('reload-captcha', 'FrontController@reloadCaptcha');
Route::post('/item/order/{id}', 'FrontController@order');
Route::get('/order', 'FrontController@list_order');
Route::post('/order/upload/{id}', 'FrontController@upload_bukti');
Route::post('/order/checkout/{id}', 'FrontController@checkout');

//User Controller
Route::post('/register', 'UserController@registerPost');
Route::post('/login', 'UserController@loginPost');
Route::get('/logout', 'UserController@logout');

//Backend Controller
Route::get('/admin', 'AdminController@index');
Route::resource('/admin/hotels', 'HotelController');
Route::get('/admin/order', 'AdminController@order');
Route::get('/admin/detail/{id}', 'AdminController@detail');
Route::post('/admin/detail/{id}', 'AdminController@detail_change');


// Route::get('/', function () {
//     return view('welcome');
// });
