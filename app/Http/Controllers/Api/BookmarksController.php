<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Validate;
use DB;
use App\Bookmark;
use App\Hero;
use App\PaperNovel;
use App\StoryPaper;
    
    //=======================================================================
    class BookmarksController extends Controller
    {
        public function save($paper_novel_id)
        { 
            //ユーザー情報取得
            $userId = Auth::id();

            //登録する情報を格納
            $bookmark_novel = new Bookmark;
            $bookmark_novel->user_id=$userId;
            $bookmark_novel->paper_novel_id=$paper_novel_id;
            $bookmark_novel->save();

        }

        public function check($paper_novel_id)
        { 
            //ユーザー情報取得
            $userId = Auth::id();
            //登録する情報を格納
            $bookmark = Bookmark::where('user_id','=',$userId)
                                ->where('paper_novel_id','=',$paper_novel_id)
                                ->exists();
            if($bookmark) {
                $bookmark  = Bookmark::where('user_id','=',$userId)
                        ->where('paper_novel_id','=',$paper_novel_id)
                        ->select('id')
                        ->get();
            }
            return response()->json($bookmark);
        }

        public function show()
        { 
            //ユーザー情報取得
            $userId = Auth::id();
            //登録する情報を格納
            $bookmark_novels = DB::table('bookmarks as b')
                                ->join('paper_novels as p','p.id','=','b.paper_novel_id')
                                ->join('story_papers as s','s.paper_novel_id','=','p.id')
                                ->join('heroes as h','h.id','=','p.hero_id')
                                ->where('b.user_id','=',$userId)
                                ->where('s.story_number','=',1)
                                ->select('b.id','p.title','b.paper_novel_id','h.img_url','p.hero_id','s.text')
                                ->get();
            return response()->json($bookmark_novels);
        }

        public function destroy($bookmark_id){
            //bookmarksテーブルから削除
            $bookmark_novel = Bookmark::where('user_id','=',Auth::id())
                            ->where('id','=',$bookmark_id)
                            ->delete();
        }
    }

    //=======================================================================
    
    