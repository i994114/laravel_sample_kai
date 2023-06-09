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
/*
Route::group(['middleware' => 'auth'], function() {
    Route::get('/drills/new', 'DrillsController@new')->name(('drills.new'));
    Route::post('/drills/new', 'DrillsController@create');
    Route::get('/drills', 'DrillsController@index')->name('drills');
    Route::get('/drills/{id}/edit', 'DrillsController@edit')->name('drills.edit');
    Route::post('/drills/{id}', 'DrillsController@update')->name('drills.update');
    Route::post('/drills/{id}/delete', 'DrillsController@destroy')->name('drills.delete');
    Route::get('/drills/{id}', 'DrillsController@show')->name('drills.show');
    Route::get('/mypage', 'DrillsController@mypage')->name('drills.mypage');
});
*/

//コンポーネント練習用
Route::get('/test', function () {
    return view('test');
});



//Route::group(['middleware' => 'auth'], function() {
Route::middleware(['auth', 'verified'])->group(function() {
    Route::resource('drills', 'DrillsController');
    Route::get('/mypage', 'DrillsController@mypage')->name('drills.mypage');
});