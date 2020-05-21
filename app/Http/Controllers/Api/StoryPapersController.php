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
            
        }

        //ストーリーペーパーを更新:api/edit/story_paper
        public function edit(Request $request)
        {
            //ユーザー情報取得
            $userId = Auth::id();
            //ペーパーノベルidを取得
            $paper_novel_id = PaperNovel::where('user_id','=',$userId)
                        ->where('user_paper_order','=',$request->user_paper_order)
                        ->select('id')
                        ->first();
            if($paper_novel_id){
                // ストーリーがあるか確認
                $paper_novel_toggle = StoryPaper::where('paper_novel_id','=',$paper_novel_id->id)
                                                ->where('story_number','=',$request->story_number)
                                                ->exists();
            }

            //更新の場合
            if($paper_novel_id && $paper_novel_toggle){
                // Postするデータを格納
                $story_paper = StoryPaper::where('paper_novel_id','=',$paper_novel_id->id)
                                ->where('story_number','=',$request->story_number)
                                ->update(['text' => $request->text]);
            }
            // 2話目以降のエピソードだったら、ストーリーペーパーを保存
            else if($paper_novel_id && !$paper_novel_toggle){
                //StoryPpaersテーブルに保存
                $story_paper = new StoryPaper;
                $story_paper->paper_novel_id = $paper_novel_id->id;
                $story_paper->text = $request->text;
                $story_paper->story_number = $request->story_number;
                $story_paper->status = 0;
                $story_paper->save();
            }
            //新しいページだったら、新規で保存
            else{
            //PaperNovelsテーブルに保存
                //登録する情報を格納
                $paper_novel = new PaperNovel;
                //ユーザー情報を登録
                $paper_novel->user_id = $userId;
                //ペーパー情報を登録
                $paper_novel->hero_id = $request->hero_id;//主人公id

                //ペーパーの順序を登録
                    //ペーパーの順序を取得
                    $user_paper_order = PaperNovel::where('user_id','=',$userId)
                                        ->max('user_paper_order');
                        //既に書かれていたら、numberに+1
                        if($user_paper_order) $user_paper_order += 1;
                        //はじめてのペーパーなら、1を代入
                        else $user_paper_order = 1;

                $paper_novel->user_paper_order = $user_paper_order;//ペーパーオーダー
                $paper_novel->status = 0;//ステータスを0(非公開)
                $paper_novel->save();

                //StoryPpaersテーブルに保存
                $paper_novel_id = PaperNovel::where('user_id','=',$userId)
                                ->where('user_paper_order','=',$user_paper_order)
                                ->select('id')
                                ->first();

                $story_paper = new StoryPaper;
                $story_paper->paper_novel_id = $paper_novel_id->id;
                $story_paper->text = $request->text;
                $story_paper->story_number = 1;
                $story_paper->status = 0;
                $story_paper->save();
            }

            return $story_paper;
        }

        // 編集ページに表示するペーパーを取得:api/get/story_papers_edit/
        public function showEditPapers($user_paper_order)
        {
            $novel_toggle =  PaperNovel::where('user_id','=',Auth::id())
                        ->where('user_paper_order','=',$user_paper_order)
                        ->exists();
            if($novel_toggle){
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
            }else{
                return response()->json($novel_toggle);
            }
        }

        // 編集ページに表示するペーパーを取得:api/get/story_papers_edit/
        public function fetchEditPaper($user_paper_order,$story_number)
        {
            //ペーパーノベルidを取得
            $paper_novel_id = PaperNovel::where('user_id','=',Auth::id())
                        ->where('user_paper_order','=',$user_paper_order)
                        ->select('id')
                        ->first();
            //ペーパーを取得
            if($paper_novel_id){
                $story_paper =  StoryPaper::where('paper_novel_id','=',$paper_novel_id->id)
                ->where('story_number','=',$story_number)
                ->first();
                return response()->json($story_paper);
            }


        }

        // ペーパーノベルidにマッチしたペーパーを取得:api/get/story_papers/
        public function showPapers($paper_novel_id)
        {
            //ペーパーを取得
            $story_papers =  DB::table('story_papers as s')
                                ->where('s.paper_novel_id','=',$paper_novel_id)
                                ->orderBy('s.story_number')
                                ->select('s.text','s.story_number')
                                ->get();

            return response()->json($story_papers);
        }

        //エピソードの削除
        public function destroy($paper_novel_id,$story_number){
            //story_papersテーブルから削除
            $story_papers = StoryPaper::where('paper_novel_id','=',$paper_novel_id)
                            ->where('story_number','=',$story_number)
                            ->delete();
        }


    }
    //=======================================================================
    
    