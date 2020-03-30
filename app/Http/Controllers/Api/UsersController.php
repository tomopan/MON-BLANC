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
    //プロフィールを表示
    public function show()
    {
        $userData = Auth::user();              

        // $userData = User::where('id', '=', $user_id)
        //             ->get();

        return response()->json($userData);
    }

}
