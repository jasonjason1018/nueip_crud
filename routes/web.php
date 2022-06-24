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

Route::get('/', 'CrudController@account_manage');
Route::post('/insert_data', 'CrudController@insert_data');
Route::post('/update_data', 'CrudController@update_data');
Route::get('/delete_data/{sno}', 'CrudController@delete_data');
