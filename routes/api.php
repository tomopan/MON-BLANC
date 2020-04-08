<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

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

//最初から記述があったルーティング
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




//ここから追記//
//　API定義
//　認証後であれば下記ルート定義が有効になる
Route::group(['middleware' => 'auth'], function () {


    // -----------Heroesテーブル----------- //
    Route::get('get/hero', 'Api\HeroesController@show');
    Route::get('get/hero/{id}', 'Api\HeroesController@fetch');


    // -----------Episodeテーブル----------- //

    //小説のエピソードを投稿
    Route::post('post/episode', 'Api\EpisodesController@save');

    //エピソードを取得
    Route::get('get/papers/{user_paper_order}', 'Api\EpisodesController@showPapers');


    // -----------Novelsテーブル----------- //

    //プロフィールで公開中の小説を取得
    Route::get('get/novel/writed', 'Api\NovelsController@showWrited');

    //プロフィールで非公開の小説を取得
    Route::get('get/novel/writing', 'Api\NovelsController@showWriting');

    //hero_idにマッチした小説のデータを取得
    Route::get('get/novels/{id}', 'Api\NovelsController@show');

    //novel_idにマッチしたデータをひとつだけ取得
    Route::get('get/novel/{novel_id}', 'Api\NovelsController@fetch');

    //小説の一行目を保存
    Route::post('post/firstsentence/{id}', 'Api\NovelsController@saveFirst');

    //小説のステータスを変更(公開→非公開)
    Route::post('update/novel/close/{novel_id}', 'Api\NovelsController@closeNovelStatus');

    //小説のステータスを変更(公開→非公開)
    Route::post('update/novel/open/{novel_id}', 'Api\NovelsController@openNovelStatus');

    //小説のタイトルを変更
    Route::post('update/novel/title/{novel_id}', 'Api\NovelsController@postTitle');





    // -----------Usersテーブル----------- //
    Route::get('get/user', 'Api\UsersController@show');




});