<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'IndexController@index');
Route::get('tags/add', 'IndexController@showAddNewTagPage');
Route::post('tags/add', 'IndexController@addTagDetails');
Route::get('tags/graph/stats', "IndexController@showTagGraphStats");
Route::get('tags/stats', "IndexController@showTagStats");
Route::post("create-database-tables", 'DatabaseController@createDBTables');