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

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/myoffers', 'MyoffersController@index');
Route::get('/deleteoffer', 'MyoffersController@delete');
Route::get('/addoffer', 'MyoffersController@add');
Route::post('/addofferrecord', 'MyoffersController@create');
Route::post('/applyoffer', 'MyoffersController@apply');
Route::post('/applyonoffer', 'MyoffersController@applyonoffer');
Route::get('/calendar', 'CalenderController@index');

Route::get('/myprofile', 'Profile\MyprofileController@index');
Route::get('/editprofile', 'Profile\MyprofileController@edit');
Route::post('/saveprofile', 'Profile\MyprofileController@save');
