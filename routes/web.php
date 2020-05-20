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

//ログイン後に表示されるホーム画面のルート
// Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/lp', function () {
        return view('lp');
    });
    Route::get('/lpScroll', function () {
        return view('lpScroll');
    });

// });
// Route::get('/', function () {
//     return view('lp');
// });
// Route::get('/', function() {
//   return view('index');
// })->middleware('auth');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
