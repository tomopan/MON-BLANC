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

        //小説のタイトルを保存
        public function save(Request $request,$hero_id)
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
            $novel->title = $request->title;
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
                    ->select('u.name','u.id','n.id','n.title','n.user_id','n.status')
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
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\View\View
         */
        public function edit($id)
        {
            $novel = Novel::findOrFail($id);
    
            return view("novel.edit", compact("novel"));
        }
    
        /**
         * Update the specified resource in storage.
         *
         * @param  int  $id
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function update(Request $request, $id)
        {
            $this->validate($request, [
				"hero_id" => "nullable|integer", //integer('hero_id')->nullable()
				"user_id" => "nullable|integer", //integer('user_id')->nullable()
				"title" => "nullable", //text('title')->nullable()
				"viewer_count" => "nullable|integer", //integer('viewer_count')->nullable()
				"status" => "nullable|integer", //integer('status')->nullable()

            ]);
            $requestData = $request->all();
            
            $novel = Novel::findOrFail($id);
            $novel->update($requestData);
    
            return redirect("novel")->with("flash_message", "novel updated!");
        }
    
        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function destroy($id)
        {
            Novel::destroy($id);
    
            return redirect("novel")->with("flash_message", "novel deleted!");
        }
    }

    
