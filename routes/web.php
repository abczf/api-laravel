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
//    return view('welcome');
    phpinfo();
});
////
Route::get('/wx/token','TestController@getWxToken');
Route::get('/wx/token2','TestController@getWxToken2');
Route::get('/wx/token3','TestController@getWxToken3');
///
Route::any('/api/token','TestController@getAccessToken');


/////
Route::get('/user/info','TestController@userInfo');
Route::get('/test2','TestController@test2');

//接口
//Route::post('/user/login','TestController@login');//登录
Route::post('/user/reg','User\IndexController@reg');//注册
Route::post('/user/login','User\IndexController@login');//登录
Route::get('/user/center','User\IndexController@center')->middleware("verifyaccesstoken","count");//个人中心

Route::get('/goods','TestController@goods');//商品

Route::get('/test1','TestController@test1')->middleware("count");

Route::get('/test3','TestController@test3');

/////对称加密
//加密
Route::get('/enc1','TestController@enc1');
/////非对称加密
//加密
Route::get('/rsa1','TestController@rsa1');
//解密
Route::get('/rsa21','TestController@rsa21');
//签名测试
Route::get('/sign1','TestController@sign1');
