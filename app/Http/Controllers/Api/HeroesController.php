<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Validate;
use DB;

use App\Heroe;
use App\User;
    
    //=======================================================================
    class HeroesController extends Controller
    {
        public function show()
        {
            $heroes = Heroe::all();
            return response()->json($heroes);
        }

        public function fetch($hero_id)
        {
            $userId = Auth::id();
            $hero = Heroe::where('id','=',$hero_id)
                            ->first();

            // $hero->user_id = 1;

            return response()->json($hero);
        }
    }
    //=======================================================================
    
    