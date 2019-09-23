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
})->name("start");

Route::get("/login","LoginController@loginPhone");
Route::post("/getCode","LoginController@getCode")->name("phone");
Route::get("/loginCode","LoginController@loginCode")->name("code");
// Auth::routes();

Route::get('home', 'HomeController@index');
Route::group(['middleware' => 'checkToken'], function () {
	
});
