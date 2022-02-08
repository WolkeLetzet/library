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
Route::get('register', function () {
    return redirect(route('article.index'));
});

Route::view('a', 'article.create');

Route::namespace('App\Http\Controllers')->middleware('auth')->group(function () {

    Route::get('index', 'ArticleController@index')->name('article.index');
    Route::get('article/show/{id}', 'ArticleController@show')->name('article.show');
    Route::get('user/profile','UserController@show')->name('user.profile');

    Route::post('user/profile','HomeController@guardarNombre')->name('cambiar-nombre');
    Route::get('user/setting/password/','HomeController@showChangePassword')->name('password.reset');
    Route::post('user/setting/password/','HomeController@verificarContraseña')->name('password.verify');

    Route::group(['middleware' => ['role:admin']], function () {
        //

        Route::get('user/admin/crate','UserController@create')->name('user.create');
        Route::post('user/admin/crate','UserController@store')->name('user.store');

        Route::post('article/delete/{id}','ArticleController@destroy')->name('article.delete');

        Route::get('article/create', 'ArticleController@create')->name('article.create');
        Route::post('article/create', 'ArticleController@store')->name('article.create');
        

    });
});
