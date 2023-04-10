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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('verified')->group(function() {
    //本登録ユーザだけ表示できるページ
    Route::get('verified', function() {
        return '本登録が完了しています！';
    });
});

//メール送信用
Route::get('contact', 'ContactController@index');
Route::post('contact', 'ContactController@send');

//drill
Route::get('/drills/new', 'DrillsController@new')->name(('drills.new'));
Route::post('/drills/new', 'DrillsController@create');
Route::get('/drills', 'DrillsController@index')->name('drills');
Route::get('/drills/{id}/edit', 'DrillsController@edit')->name('drills.edit');
Route::post('/drills/{id}', 'DrillsController@update')->name('drills.update');