<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|-------------------------------------------------------------------------- index
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', 'WelcomeController@index');

// Route::get('home', 'HomeController@index');

// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);


Route::get('/', [
	'as' => 'home',
	'uses' => 'IndexController@getIndex'
]);

Route::controller('index', 'IndexController');

Route::get('dashboard', 'IndexController@getDashboard');
Route::get('set', 'IndexController@getDashboard');
// Route::get('nextfaucet', 'IndexController@getNextFaucet');
Route::post('faucetation', 'IndexController@postActionFaucet');
Route::post('save', 'IndexController@postSaveFaucet');

Route::get('showdummy', 'IndexController@getDummyPage');
