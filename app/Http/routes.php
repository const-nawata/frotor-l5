<?php

Route::get('/', [
	'as' => 'home',
	'uses' => 'IndexController@getIndex'
]);

Route::controller('index', 'IndexController');

Route::get('dashboard', 'IndexController@getDashboard');
Route::get('set/{faucetId}', 'IndexController@getDashboard');
Route::get('showdummy', 'IndexController@getDummyPage');

Route::post('faucetation', 'IndexController@postActionFaucet');
Route::post('save', 'IndexController@postSaveFaucet');
Route::post('resetall', 'IndexController@postResetAll');

// Route::get('setdomain', 'IndexController@setDomain');	//TODO: Debug route
