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

Auth::routes();

Route::get('/sandbox', 'SandboxController@index')->name('sandbox');
Route::get('/', 'ParserController@create')->name('home');
Route::get('/fork/~{hash}', 'ParserController@fork')->name('forkParser');

Route::get('/p/{hash}', function (string $hash) {
    return redirect(route('parser', ['hash' => $hash]));
})->name('parser.redirect');

Route::group(['prefix' => '/~{hash}', 'as' => 'parser'], function () {
    Route::get('/', 'ParserController@show')->name('.index');
    Route::get('/embed', 'ParserController@embed')->name('.embed');
});

Route::group(['prefix' => '/@{username}', 'as' => 'user'], function () {
    Route::get('/', 'UserController@show')->name('.show');
    Route::get('/~{hash}', 'ParserController@showByUser')->name('.parser');
    Route::get('/~{hash}/embed', 'ParserController@embed')->name('.parser.embed');
});

Route::post('/p/save', 'ParserController@update')->name('update-parser');

Route::group(['prefix' => '/me', 'as' => 'me', 'middleware' => 'auth'], function () {
    Route::get('/', 'UserController@me')->name('.index');
    Route::get('/parsers', 'UserController@parsers')->name('.parsers');
});

Route::group(['prefix' => 'login', 'namespace' => 'Auth'], function () {
    Route::get('github', 'LoginController@redirectToProvider')->name('login-social.github');
    Route::get('github/callback', 'LoginController@handleProviderCallback');
});
