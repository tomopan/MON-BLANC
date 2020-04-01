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
// Route::group(['middleware' => 'auth'], function () {


    // -----------Heroesテーブル----------- //
    Route::get('get/hero', 'Api\HeroesController@show');
    Route::get('get/hero/{id}', 'Api\HeroesController@fetch');


    // -----------Episodeテーブル----------- //

    //小説のエピソードを投稿
    Route::post('post/episode', 'Api\EpisodesController@save');
    
    //エピソードを取得
    Route::get('get/episode/{novel_id}', 'Api\EpisodesController@show');

    //エピソードを取得
    Route::get('get/papers/{novel_id}', 'Api\EpisodesController@showPapers');


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





    // -----------Usersテーブル----------- //
    Route::get('get/user', 'Api\UsersController@show');


    //---------------未実装----------------//

    // 読書ページのフォロー(コントローラーを書く時にidを変数にいれる記載をしようと思います)
    // Route::post('post/follow/{id}', 'Api\FollowsController@uid');
    // トップページの主人公選択(@の後ろがわからない。。。。)
    // Route::get('post/hero/{id}', 'Api\HerosController@save');
// 
    // 主人公ページの「書かれた小説閲覧」
    // Route::get('get/novel/', 'Api\NovelsController@show');
    // プロフィールの小説データ取得
        //執筆中の小説
        // Route::get('get/episode/writing', 'Api\EpisodesController@showWriting');
        //執筆中の小説
        // Route::get('get/episode/writed', 'Api\EpisodesController@showWrited');

    // 主人公ページの「キャラクター概要」
    // 読書ページの「目次」から取るエピソード
    // Route::get('post/episode/{id}', 'Api\NovelsController@show');
    // 新規登録ユーザー
    // Route::get('post/user/{id}', 'Api\UsersController@store');
    //


// });