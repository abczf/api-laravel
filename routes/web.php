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
////
Route::get('/test1','TestController@test1');
Route::get('/test2','TestController@test2');

////对称加密
//解密
Route::get('/dec2','TestController@dec2');
////非对称加密
//解密
Route::get('/rsa2','TestController@rsa2');
//加密
Route::get('/rsa11','TestController@rsa11');
//签名测试
Route::get('/sign2','TestController@sign2');
