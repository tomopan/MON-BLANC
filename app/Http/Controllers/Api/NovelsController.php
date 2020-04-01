<?php

//変更
namespace App\Http\Controllers\Api;

//追記
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Auth;
use Validate;
use DB;

use App\User;
use App\Novel;



    //=======================================================================
    class NovelsController extends Controller
    {

        //小説の一文目を保存
        public function saveFirst(Request $request,$hero_id)
        {
            //ユーザー情報取得
            $userId = Auth::id();
            // $userId = 100;

            //登録する情報を格納
            $novel = new Novel;
            //ユーザー情報を登録
            $novel->user_id = $userId;
            //小説情報を登録
            $novel->hero_id = $hero_id;
            $novel->first_sentence = $request->first_sentence;
            $novel->status = 1;
            $novel->save();
            return $novel;
        }
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\View\View
         */

        //hero_idにマッチした、公開されている小説のデータを取得
        public function show($hero_id)
        {
            $novels = DB::table('novels as n')
                    ->join('users as u','u.id','=','n.user_id')
                    ->where('n.hero_id', '=', $hero_id)
                    ->where('n.status', '=', 1)
                    ->select('u.name','n.id','n.hero_id','n.title','n.user_id','n.status')
                    ->get();
            // $novels =  Novel::where('hero_id','=',$hero_id)
            //                 ->get();

            return response()->json($novels);
        }

        //novel_idにマッチした小説のデータをひとつだけ取得
        public function fetch($novel_id)
        {
            $novel = DB::table('novels as n')
                    ->join('users as u','u.id','=','n.user_id')
                    ->where('n.id', '=', $novel_id)
                    ->select('u.name','u.id','n.id','n.title','n.user_id','n.status','n.first_sentence')
                    ->first();
            // $novel =  Novel::where('id','=',$novel_id)
            //                 ->get();
            
            // $novel->user_id = 1;
            return response()->json($novel);
        }

        //プロフィールページで公開中の小説のデータ取得
        public function showWrited()
        {
            $novels =  Novel::where('user_id','=', Auth::id())
                        ->where('status',1)
                        ->orderBy('created_at')
                        ->get();
            return response()->json($novels);
        }
    
        //プロフィールページで非公開の小説のデータ取得
        public function showWriting()
        {
            $novels =  Novel::where('user_id','=', Auth::id())
                        ->where('status',0)
                        ->orderBy('created_at')
                        ->get();
            return response()->json($novels);
        }

        //小説のステータスを変更（公開→非公開）
        public function closeNovelStatus($novel_id)
        {
            $novel =  Novel::where('id','=',$novel_id) 
                        ->update(['status' => 0]);
            return $novel;
            // return response()->json($novels);
        }

        //小説のステータスを変更（非公開→公開）
        public function openNovelStatus($novel_id)
        {
            $novel =  Novel::where('id','=',$novel_id) 
                        ->update(['status' => 1]);
            return $novel_id;
            // return response()->json($novels);
        }
    }
    
