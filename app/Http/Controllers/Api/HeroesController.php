<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Heroe;
    
    //=======================================================================
    class HeroesController extends Controller
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
                $heroe = Heroe::where("id","LIKE","%$keyword%")->orWhere("img_url", "LIKE", "%$keyword%")->orWhere("hero_hescription", "LIKE", "%$keyword%")->orWhere("novel_count", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $heroe = Heroe::paginate($perPage);              
            }          
            return view("heroe.index", compact("heroe"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("heroe.create");
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
				"img_url" => "nullable|integer", //integer('img_url')->nullable()
				"hero_hescription" => "nullable|integer", //integer('hero_hescription')->nullable()
				"novel_count" => "nullable|integer", //integer('novel_count')->nullable()

            ]);
            $requestData = $request->all();
            
            Heroe::create($requestData);
    
            return redirect("heroe")->with("flash_message", "heroe added!");
        }
    
        /**
         * Display the specified resource.
         *
         * @param  int  $id
         *
         * @return \Illuminate\View\View
         */
        public function show($id)
        {
            $heroe = Heroe::findOrFail($id);
            return view("heroe.show", compact("heroe"));
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
            $heroe = Heroe::findOrFail($id);
    
            return view("heroe.edit", compact("heroe"));
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
				"img_url" => "nullable|integer", //integer('img_url')->nullable()
				"hero_hescription" => "nullable|integer", //integer('hero_hescription')->nullable()
				"novel_count" => "nullable|integer", //integer('novel_count')->nullable()

            ]);
            $requestData = $request->all();
            
            $heroe = Heroe::findOrFail($id);
            $heroe->update($requestData);
    
            return redirect("heroe")->with("flash_message", "heroe updated!");
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
            Heroe::destroy($id);
    
            return redirect("heroe")->with("flash_message", "heroe deleted!");
        }
    }
    //=======================================================================
    
    