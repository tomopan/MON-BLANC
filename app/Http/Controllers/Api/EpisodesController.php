<?php

namespace App\Http\Controllers\Api;
//追記
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Episode;
    
    //=======================================================================
    class EpisodesController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\View\View
         */

        public function save(Request $request)
        {
            //ユーザー情報取得


            //エピソードを保存
            $episodes = new Episode;
            //ユーザー情報を登録

            
            //小説情報を登録
            $episodes->novel_id = $request->novel_id;
            $episodes->episode_title = $request->episode_title;
            $episodes->text = $request->text;
            $episodes->status = $request->status;
            $episodes->save();
        }

        public function index(Request $request)
        {
            $keyword = $request->get("search");
            $perPage = 25;
            
            if (!empty($keyword)) {
                $episode = Episode::where("id","LIKE","%$keyword%")->orWhere("novel_id", "LIKE", "%$keyword%")->orWhere("episode_number", "LIKE", "%$keyword%")->orWhere("episode_title", "LIKE", "%$keyword%")->orWhere("text", "LIKE", "%$keyword%")->orWhere("status", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $episode = Episode::paginate($perPage);              
            }          
            return view("episode.index", compact("episode"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("episode.create");
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
				"novel_id" => "nullable|integer", //integer('novel_id')->nullable()
				"episode_number" => "nullable|integer", //integer('episode_number')->nullable()
				"episode_title" => "nullable", //text('episode_title')->nullable()
				"text" => "nullable", //text('text')->nullable()
				"status" => "nullable|integer", //integer('status')->nullable()

            ]);
            $requestData = $request->all();
            
            Episode::create($requestData);
    
            return redirect("episode")->with("flash_message", "episode added!");
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
            $episode =  Episode::all();
            return response()->json($episode);
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
    
        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\View\View
         */
        public function edit($id)
        {
            $episode = Episode::findOrFail($id);
    
            return view("episode.edit", compact("episode"));
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
				"novel_id" => "nullable|integer", //integer('novel_id')->nullable()
				"episode_number" => "nullable|integer", //integer('episode_number')->nullable()
				"episode_title" => "nullable", //text('episode_title')->nullable()
				"text" => "nullable", //text('text')->nullable()
				"status" => "nullable|integer", //integer('status')->nullable()

            ]);
            $requestData = $request->all();
            
            $episode = Episode::findOrFail($id);
            $episode->update($requestData);
    
            return redirect("episode")->with("flash_message", "episode updated!");
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
            Episode::destroy($id);
    
            return redirect("episode")->with("flash_message", "episode deleted!");
        }
    }
    //=======================================================================
    
    