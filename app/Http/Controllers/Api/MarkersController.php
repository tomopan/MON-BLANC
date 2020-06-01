<?php

//変更
namespace App\Http\Controllers\Api;

//追記
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validate;
use DB;

use App\Marker;
use App\User;
use App\Hero;
use App\PaperNovel;
use App\StoryPaper;



    
    //=======================================================================
    class MarkersController extends Controller
    {

        //選択した文章を保存:post/mark_text
        public function save(Request $request)
        {
            //ユーザー情報取得
            $userId = Auth::id();

            //登録する情報を格納
            $mark_text = new Marker;
            //ユーザー情報を登録
            $mark_text->user_id = $userId;
            //小説idを登録
            $mark_text->paper_novel_id = $request->paper_novel_id;
            //ストーリーidを登録
            $mark_text->story_paper_id = $request->story_paper_id;
            //テキストを登録
            $mark_text->text = $request->text;

            //保存
            $mark_text->save();

            return $mark_text;
        }

        //マークしたテキストデータを取得:get/mark_texts
        public function show()
        {
            $mark_texts = DB::table('paper_novels as p')
                        ->join('markers as m','p.id','=','m.paper_novel_id')
                        ->where('m.user_id','=',Auth::id())
                        ->select('m.paper_novel_id','m.story_paper_id','m.text','p.hero_id')
                        ->get();
            return response()->json($mark_texts);
        }

        //マークされている数を取得:get/mark_count
        public function showCount($paper_novel_id)
        {
            $mark_count = Marker::where('paper_novel_id','=',$paper_novel_id)
                        ->count();
            return response()->json($mark_count);
        }
    }
    //=======================================================================
    
    