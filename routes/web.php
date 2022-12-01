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

Route::get('/', function () {
    return view('welcome');
});

Route::get('add', 'TaskController@add');
Route::post('add', 'TaskController@postAdd')->name('post.add.task');

Route::get('list', 'TaskController@list')->name('list.task');
Route::get('/delete/{id}', 'TaskController@delete')->name('task.delete');

Route::get('list', 'TaskController@list')->name('list.task');
Route::get('test', 'TaskController@test');

Route::get('detail/{id}', 'TaskController@detail')->name('task.detail');

Route::post('update/{id}', 'TaskController@update')->name('task.update');