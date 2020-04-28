<?php

//変更
namespace App\Http\Controllers\Api;

//追記
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validate;
use DB;

use App\User;
use App\Hero;

use App\PaperNovel;
use App\StoryPaper;
    
    //=======================================================================
    class PaperNovelsController extends Controller
    {

        //小説の一文目を保存
        public function saveFirst(Request $request,$hero_id)
        {
            //ユーザー情報取得
            $userId = Auth::id();

            //登録する情報を格納
            $paper_novel = new PaperNovel;
            //ユーザー情報を登録
            $paper_novel->user_id = $userId;
            //ペーパー情報を登録
            $paper_novel->hero_id = $hero_id;//主人公id
            $paper_novel->first_sentence = $request->first_sentence;//ファーストセンテンス

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

            //story_papersにも保存
                $paper_novel_id = PaperNovel::where('user_id','=',$userId)
                                            ->where('user_paper_order','=',$user_paper_order)
                                            ->select('id')
                                            ->first();

                $story_paper = new StoryPaper;
                $story_paper->paper_novel_id = $paper_novel_id->id;
                $story_paper->story_number = 1;
                $story_paper->status = 0;
                $story_paper->text = $request->first_sentence;
                $story_paper->save();

            return $paper_novel;
        }

        //最初の一文を更新
        public function updateFirst(Request $request)
        {
            //ペーパーノベルidを取得
            $paper_novel = PaperNovel::where('user_id','=',Auth::id())
                            ->where('user_paper_order','=',$request->user_paper_order)
                            ->update(['first_sentence' => $request->first_sentence]);
        }


        //hero_idにマッチした、公開されている小説のデータを取得
        public function show($hero_id)
        {
            $novels = DB::table('paper_novels as n')
                    ->join('users as u','u.id','=','n.user_id')
                    ->where('n.hero_id', '=', $hero_id)
                    ->where('n.status', '=', 1)
                    ->select('u.name','n.id','n.hero_id','n.title','n.user_id','n.status','n.first_sentence')
                    ->get();

            return response()->json($novels);
        }

        //$user_paper_orderにマッチした小説のデータをひとつだけ取得:api/fetch/paper_novel/
        public function fetch($user_paper_order)
        {
            $paper_novel = PaperNovel::where('user_id','=',Auth::id())
                                        ->where('user_paper_order','=',$user_paper_order)
                                        ->first();

            //ストーリーペーパーが何枚目か取得
            $story_number = StoryPaper::where('paper_novel_id','=',$paper_novel->id)
                                ->max('story_number');
            
            

            $paper_novel->story_number = $story_number;

            return response()->json($paper_novel);
        }

        //$user_paper_orderにマッチした小説のデータをひとつだけ取得:api/fetch/paper_novel_title/
        public function fetchTitle($paper_novel_id)
        {
            // 非公開だったらtopへリダイレクト
            // $status = PaperNovel::where('id','=',$paper_novel_id)
            //         ->select('status')
            //         ->first();

            // if($status->status == 0)  return;

            //公開だったらタイトルを取得
            // else if($status->status == 1){
                $paper_novel_title = DB::table('paper_novels as p')
                ->join('users as u','u.id','=','p.user_id')
                ->where('p.id','=',$paper_novel_id)
                ->select('p.title','u.user_name','u.name','p.status')
                ->first();
            // }

            return response()->json($paper_novel_title);
        }

        //プロフィールページで公開中の小説のデータ取得
        public function showOpenPaperNovels($user_name)
        {
            //ユーザーidを取得
            $user_id = User::where('user_name','=',$user_name)
                        ->select('id')
                        ->first();

            $paper_novels =DB::table('paper_novels as n')
                        ->join('heroes as h','h.id','=','n.hero_id')
                        ->where('n.user_id','=', $user_id->id)
                        ->where('n.status',1)
                        ->select('n.id','n.title','n.user_id','n.status','n.hero_id','h.img_url','n.user_paper_order')
                        ->orderBy('n.user_paper_order')
                        ->get();

            return response()->json($paper_novels);
        }
    
        //プロフィールページで非公開の小説のデータ取得
        public function showClosePaperNovels()
        {
            $novels =DB::table('paper_novels as n')
                        ->join('heroes as h','h.id','=','n.hero_id')
                        ->where('n.user_id','=', Auth::id())
                        ->where('n.status',0)
                        ->select('n.id','n.title','n.user_id','n.status','n.hero_id','h.img_url','n.user_paper_order')
                        ->orderBy('n.created_at')
                        ->get();
            return response()->json($novels);
        }

        //小説のステータスを変更（公開→非公開）
        public function closePaperNovelStatus($user_paper_order)
        {
            $paper_novel =  PaperNovel::where('user_id','=',Auth::id()) 
                        ->where('user_paper_order','=',$user_paper_order)
                        ->update(['status' => 0]);
            return $paper_novel;
        }

        //小説のステータスを変更（非公開→公開）
        public function openPaperNovelStatus($user_paper_order)
        {
            $paper_novel =  PaperNovel::where('user_id','=',Auth::id()) 
                        ->where('user_paper_order','=',$user_paper_order)
                        ->update(['status' => 1]);
            return $paper_novel;
        }

        //小説のタイトルを変更
        public function postTitle(Request $request,$user_paper_order)
        {
            $title = PaperNovel::where('user_id','=',Auth::id()) 
                                ->where('user_paper_order','=',$user_paper_order)
                                ->update(['title' => $request->title]);
            return $title;
            // return response()->json($novels);
        }

        //小説の削除
        public function destroy($paper_novel_id){
            //paper_novelsテーブルから削除
            $paper_novel = PaperNovel::where('id','=',$paper_novel_id)
                            ->delete();

            //story_papersテーブルから削除
            $story_papers = StoryPaper::where('paper_novel_id','=',$paper_novel_id)
                            ->delete();
        }

        //小説タイトルで検索
        public function find($paper_novel_title){
            if (!empty($paper_novel_title)) {
                return PaperNovel::select('id', 'title','hero_id')
                        ->where('title', 'LIKE', "%$paper_novel_title%")
                        ->limit(20)->get();
            }
            return [];
        }

        //ランダムで4つ取得
        public function random(){
            $novels = PaperNovel::inRandomOrder()
                    ->take(4)
                    ->select('id','first_sentence')
                    ->get();
            return response()->json($novels);
        }
    }
    //=======================================================================
    
    