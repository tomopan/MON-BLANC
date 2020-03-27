<?php

//変更
namespace App\Http\Controllers\api;

//追記
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Novel;
    
    //=======================================================================
    class NovelsController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\View\View
         */


        public function index(Request $request)
        {
            $keyword = $request->get("search");
            $perPage = 25;
    
            if (!empty($keyword)) {
                $novel = Novel::where("id","LIKE","%$keyword%")->orWhere("hero_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->orWhere("title", "LIKE", "%$keyword%")->orWhere("viewer_count", "LIKE", "%$keyword%")->orWhere("status", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $novel = Novel::paginate($perPage);              
            }          
            return view("novel.index", compact("novel"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("novel.create");
        }
    
        /**
         * Store a newly created resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         *
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function store(Request $request)
        {
            $this->validate($request, [
				"hero_id" => "nullable|integer", //integer('hero_id')->nullable()
				"user_id" => "nullable|integer", //integer('user_id')->nullable()
				"title" => "nullable", //text('title')->nullable()
				"viewer_count" => "nullable|integer", //integer('viewer_count')->nullable()
				"status" => "nullable|integer", //integer('status')->nullable()

            ]);
            $requestData = $request->all();
            
            Novel::create($requestData);
    
            return redirect("novel")->with("flash_message", "novel added!");
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\View\View
         */
        public function show()
        {
            //例外処理らしい
            // $novel = Novel::findOrFail();
            $novel =  Novel::all();

            return response()->json($novel);
            // json(['profile'=>$array,'tastes'=>$taste,'notEntered'=>$genderNotEntered,'selectedTastes'=>$selectedTastes], 200);
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

    
