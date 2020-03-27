<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// エピソード（第一話など）を書いて投稿
//小説タイトルを投稿
Route::post('post/episode', 'Api\EpisodesController@save');

// 読書ページのフォロー(コントローラーを書く時にidを変数にいれる記載をしようと思います)
Route::post('post/follow/{id}', 'Api\FollowsController@uid');
// トップページの主人公選択(@の後ろがわからない。。。。)
Route::get('post/hero/{id}', 'Api\HerosController@save');

// 主人公ページの「書かれた小説閲覧」
Route::get('get/novel/', 'Api\NovelsController@show');
// プロフィールの小説データ取得
    //執筆中の小説
    Route::get('get/episode/writing', 'Api\EpisodesController@showWriting');
    //執筆中の小説
    Route::get('get/episode/writed', 'Api\EpisodesController@showWrited');

// 主人公ページの「キャラクター概要」
Route::get('post/hero/{id}', 'Api\HerosController@show');
// 読書ページの「目次」から取るエピソード
// Route::get('post/episode/{id}', 'Api\NovelsController@show');
// 新規登録ユーザー
Route::get('post/user/{id}', 'Api\UsersController@store');
//



