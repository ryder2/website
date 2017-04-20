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
Route::get('register/verify/{token}', 'Auth\RegisterController@verify');

Route::get('/termsandconditions', 'TermsAndConditionsController@index'); 

Route::get('/myoffers', 'MyoffersController@index');
Route::get('/deleteoffer', 'MyoffersController@delete');
Route::get('/deleteofferapplication', 'MyoffersController@deleteofferapplication');
Route::get('/addoffer', 'MyoffersController@add');
Route::post('/addofferrecord', 'MyoffersController@create');
Route::post('/applyoffer', 'MyoffersController@apply');
Route::post('/applyonoffer', 'MyoffersController@applyonoffer');

Route::post('/viewofferapplication', 'MyoffersController@viewofferapplication');
Route::post('/acceptofferapplication', 'MyoffersController@acceptofferapplication');
Route::post('/completedofferapplication', 'MyoffersController@completedofferapplication');

Route::get('/calendar', 'CalenderController@index');

Route::get('/adminpanel', 'AdminpanelController@index');
Route::post('/executeSearch', 'AdminpanelController@search');
Route::get('/executeSearch', 'AdminpanelController@search');
Route::post('/adminpanel', 'AdminpanelController@save');

Route::get('/myprofile', 'Profile\MyprofileController@index');
Route::get('/editprofile', 'Profile\MyprofileController@edit');
Route::post('/saveprofile', 'Profile\MyprofileController@save');
Route::post('/ratemecano', 'Profile\MyprofileController@ratemecano');

Route::get('/seemecanoprofile/{mecanoname}',[
    'uses' => 'SeemecanoprofileController@switchInfo',
    'as'   => 'seemecanoprofil'
]);


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::post('/pay/{product}', [
    'uses' => 'MyoffersController@postPayWithStripe',
    'as' => 'pay',
    'middleware' => 'auth'
]);