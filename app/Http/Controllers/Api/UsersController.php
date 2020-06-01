<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

use App\User;

class UsersController extends Controller
{
    //ログイン中のユーザー情報を取得
    public function show()
    {
        if(Auth::user()){
            $userData = Auth::user();              
            return response()->json($userData);
        }
    }

    //ログイン中のユーザー情報を取得
    public function showProfile($user_name)
    { 
        $userData = User::where('user_name','=',$user_name)
                    ->first();
        return response()->json($userData);
    }

    //プロフィールを編集して更新
    public function edit(Request $request)
    {           
        $user = User::find(Auth::id());
        $user->name     = $request->name;
        $user->user_name     = $request->user_name;
        $user->bio     = $request->bio;

        $user->save();
        return $user;
    }

}
