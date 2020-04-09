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
// API定義
// 認証後であれば下記ルート定義が有効になる
Route::group(['middleware' => 'auth'], function () {

    // -----------Usersテーブル----------- //
    Route::get('get/user', 'Api\UsersController@show');


    // -----------Heroesテーブル----------- //
    Route::get('get/hero', 'Api\HeroesController@show');
    Route::get('get/hero_fetch/{hero_id}', 'Api\HeroesController@fetch');


    // -----------PaperNovelsテーブル----------- //
    //user_paper_orderにマッチしたデータをひとつだけ取得
    Route::get('fetch/paper_novel/{user_paper_order}', 'Api\PaperNovelsController@fetch');

    //paper_novel_idにマッチしたデータのタイトルをひとつだけ取得
    Route::get('fetch/paper_novel_titile/{paper_novel_id}', 'Api\PaperNovelsController@fetchTitle');

    //プロフィールで公開中の小説を取得
    Route::get('get/open_paper_novels', 'Api\PaperNovelsController@showOpenPaperNovels');

    //プロフィールで非公開の小説を取得
    Route::get('get/close_paper_novels', 'Api\PaperNovelsController@showClosePaperNovels');

    //hero_idにマッチしたペーパーノベルのデータを全て取得
    Route::get('get/paper_novels/{hero_id}', 'Api\PaperNovelsController@show');

    //小説の一行目を保存
    Route::post('post/firstsentence/{id}', 'Api\PaperNovelsController@saveFirst');

    //小説のステータスを変更(公開→非公開)
    Route::post('update/paper_novel_close/{user_paper_order}', 'Api\PaperNovelsController@closePaperNovelStatus');

    //小説のステータスを変更(公開→非公開)
    Route::post('update/paper_novel_open/{user_paper_order}', 'Api\PaperNovelsController@openPaperNovelStatus');

    //小説のタイトルを変更
    Route::post('update/paper_title/{user_paper_order}', 'Api\PaperNovelsController@postTitle');

    // -----------StoryPapersテーブル----------- //

    //ストーリーペーパーのデータを取得
    Route::get('get/story_papers/{paper_novel_id}', 'Api\StoryPapersController@showPapers');

    //ストーリーペーパーを投稿
    Route::post('post/story_paper', 'Api\StoryPapersController@save');






});