<?php

namespace App\Http\Controllers\Api;
//追記
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Novel;
use App\Episode;
use App\User;
    
    //=======================================================================
    class EpisodesController extends Controller
    {

        public function save(Request $request)
        {
            
            //エピソードを保存
            $episodes = new Episode;
            
            //ペーパーidを取得
            $novel_id = Novel::where('user_id','=',Auth::id())
                        ->where('user_paper_order','=',$request->user_paper_order)
                        ->select('id')
                        ->first();
            
                        //エピソード番号を取得
            $writed_episode_number = Episode::where('novel_id','=',$novel_id->id)
                                ->max('episode_number');
                //既に書かれていたら、numberに+1
                if($writed_episode_number) $episode_number = $writed_episode_number + 1;
                //はじめの1ページなら、1を代入
                else $episode_number = 1;



            //小説情報を登録
            $episodes->novel_id = $novel_id->id;
            $episodes->text = $request->text;
            $episodes->episode_number = $episode_number;
            $episodes->status = $request->status;
            $episodes->save();

            //Novelsテーブルを更新
            $novel =  Novel::where('id','=',$request->novel_id) 
                        ->update(['title' => $request->title]);

        }

        // 小説idにマッチしたペーパーを取得
        public function showPapers($user_paper_order)
        {
            //ペーパーidを取得
            $novel_id = Novel::where('user_id','=',Auth::id())
                            ->where('user_paper_order','=',$user_paper_order)
                            ->select('id')
                            ->first();

            //ペーパーを取得
            $papers =  Episode::where('novel_id','=',$novel_id->id)
                                ->orderBy('episode_number')
                                ->get();

            return response()->json($papers);
        }

        // 執筆中ページを取得
        public function showWriting()
        {
            $episode =  Episode::where('status',0)
                                ->orderBy('created_at')
                                ->get();
            return response()->json($episode);
        }

        // 執筆済ページを取得
        public function showWrited()
        {
            $episode =  Episode::where('status',1)
                                ->orderBy('created_at')
                                ->get();
            return response()->json($episode);
        }
    
    }
    //=======================================================================
    
    