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

            //小説情報を登録
            $episodes->novel_id = $request->novel_id;
            $episodes->text = $request->text;
            $episodes->status = $request->status;
            $episodes->save();

            //Novelsテーブルを更新
            $novel =  Novel::where('id','=',$request->novel_id) 
                        ->update(['title' => $request->title]);
            // return $novel;
        }


        public function show($novel_id)
        {
            $episode =  Episode::where('novel_id','=',$novel_id)
                ->get();
            return response()->json($episode);
        }

        // 小説idにマッチしたペーパーを取得
        public function showPapers($novel_id)
        {
             $papers =  Episode::where('novel_id','=',$novel_id)
                                ->orderBy('created_at')
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
    
    