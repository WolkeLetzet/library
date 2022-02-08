<?php

use Illuminate\Support\Facades\Auth;
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
    return redirect(route('article.index'));
});

Auth::routes();


Route::view('a', 'article.create');

Route::namespace('App\Http\Controllers')->middleware('auth')->group(function () {

    Route::get('index', 'ArticleController@index')->name('article.index');
    Route::get('article/show/{id}', 'ArticleController@show')->name('article.show');

    Route::group(['middleware' => ['role:admin']], function () {
        //
        Route::get('article/create', 'ArticleController@create')->name('article.create');
        Route::post('article/create', 'ArticleController@store')->name('article.create');
    });
});
