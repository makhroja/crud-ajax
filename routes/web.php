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

Route::get('/students', 'StudentController@index');

Route::get('/json-students', 'StudentController@dataTable')->name('jsonStudents');
Route::post('/get-student', 'StudentController@edit')->name('getStudent');
Route::post('/delete-student', 'StudentController@delete')->name('deleteStudent');

Route::post('/store-student', 'StudentController@store')->name('storeStudent');
Route::post('/update-student', 'StudentController@update')->name('updateStudent');
