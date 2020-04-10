<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\StoryPaper;
//追記
use App\PaperNovel;
use App\User;

    
    //=======================================================================
    class StoryPapersController extends Controller
    {
        //ストーリーペーパーを保存:api/post/story_paper
        public function save(Request $request)
        {
            // Postするデータを格納
            $story_paper = new StoryPaper;

            //ペーパーノベルidを取得
            $paper_novel_id = PaperNovel::where('user_id','=',Auth::id())
                        ->where('user_paper_order','=',$request->user_paper_order)
                        ->select('id')
                        ->first();

            //エピソード番号を取得
            $writed_story_number = StoryPaper::where('paper_novel_id','=',$paper_novel_id->id)
                                ->max('story_number');
                //既に書かれていたら、numberに+1
                if($writed_story_number) $story_number = $writed_story_number + 1;
                //はじめの1ページなら、1を代入
                else $story_number = 1;


            //小説情報を登録
            $story_paper->paper_novel_id = $paper_novel_id->id;
            $story_paper->text = $request->text;
            $story_paper->story_number = $story_number;
            $story_paper->status = $request->status;
            $story_paper->save();

            //PaperNovelsテーブルを更新
            $novel =  PaperNovel::where('id','=',$request->paper_novel_id) 
                        ->update(['title' => $request->title]);
        }



        // 編集ページに表示するペーパーを取得:api/get/story_papers_edit/
        public function showEditPapers($user_paper_order)
        {
            //ペーパーノベルidを取得
            $paper_novel_id = PaperNovel::where('user_id','=',Auth::id())
                        ->where('user_paper_order','=',$user_paper_order)
                        ->select('id')
                        ->first();
            //ペーパーを取得
            $story_papers =  StoryPaper::where('paper_novel_id','=',$paper_novel_id->id)
                                ->orderBy('story_number')
                                ->get();

            return response()->json($story_papers);
        }

        // ペーパーノベルidにマッチしたペーパーを取得:api/get/story_papers/
        public function showPapers($paper_novel_id)
        {
            //ペーパーを取得
            $story_papers =  StoryPaper::where('paper_novel_id','=',$paper_novel_id)
                                ->orderBy('story_number')
                                ->get();

            return response()->json($story_papers);
        }

    }
    //=======================================================================
    
    