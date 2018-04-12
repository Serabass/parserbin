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

Route::get('/', 'ParserController@create');
Route::get('/p/{hash}', function (string $hash) {
    return redirect(route('parser', ['hash' => $hash]));
})->name('parser.redirect');
Route::get('/~{hash}', 'ParserController@show')->name('parser');
Route::post('/p/save', 'ParserController@update')->name('update-parser');

Route::get('/me', 'UserController@me')
    ->name('me')
    ->middleware(['auth']);

Route::group(['prefix' => 'login', 'namespace' => 'Auth'], function () {
    Route::get('github', 'LoginController@redirectToProvider')->name('login-social.github');
    Route::get('github/callback', 'LoginController@handleProviderCallback');
});
