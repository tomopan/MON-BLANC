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
use App\Hint;

class HintsController extends Controller
{
    //ヒントを保存
    public function save(Request $request)
    {
        // ユーザーid取得
        $userId = Auth::id();

        if(!$request->user_paper_order){
            //第一文ページで保存した場合は、user_paper_orderを次の数値にする
            $user_paper_order = PaperNovel::where('user_id','=',$userId)
                                ->max('user_paper_order');
            
            $request->user_paper_order = $user_paper_order +1;
        }


        //既に登録してるか確認
        $answersToggle = Hint::where('user_id','=',$userId)
        ->where('user_paper_order','=',$request->user_paper_order)
        ->exists();
        
        if($answersToggle){
            //Postするデータを格納
            $answers = Hint::where('user_id','=',$userId)
                            ->where('user_paper_order','=',$request->user_paper_order)
                            ->update([
                                'q_1' => $request->q_1,
                                'q_2' => $request->q_2,
                                'q_3' => $request->q_3,
                                'q_4' => $request->q_4,
                                'q_5' => $request->q_5,
                            ]);
        }else{
            //Postするデータを格納
            $answers = new Hint;
            $answers->user_id = $userId;
            $answers->user_paper_order = $request->user_paper_order;
            $answers->q_1 = $request->q_1;
            $answers->q_2 = $request->q_2;
            $answers->q_3 = $request->q_3;
            $answers->q_4 = $request->q_4;
            $answers->q_5 = $request->q_5;
            $answers->save();
        }

    }
    //ヒントを保存
    public function edit(Request $request)
    {
        // ユーザーid取得
        $userId = Auth::id();
        
        //Postするデータを格納
        $answers = Hint::where('user_id','=',$userId)
                        ->where('user_paper_order','=',$request->user_paper_order)
                        ->update([
                            'q_1' => $request->q_1,
                            'q_2' => $request->q_2,
                            'q_3' => $request->q_3,
                            'q_4' => $request->q_4,
                            'q_5' => $request->q_5,
                        ]);
    }

    //ヒントを保存
    public function show($user_paper_order)
    {
        // ユーザーid取得
        $userId = Auth::id();
        // 回答を取得
        $answers = Hint::where('user_id','=',$userId)
                        ->where('user_paper_order','=',$user_paper_order)
                        ->first();
        return response()->json($answers);

    }
}
