<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Viewer;
    
    //=======================================================================
    class ViewersController extends Controller
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
                $viewer = Viewer::where("id","LIKE","%$keyword%")->orWhere("novel_id", "LIKE", "%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $viewer = Viewer::paginate($perPage);              
            }          
            return view("viewer.index", compact("viewer"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("viewer.create");
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
				"user_id" => "nullable|integer", //integer('user_id')->nullable()

            ]);
            $requestData = $request->all();
            
            Viewer::create($requestData);
    
            return redirect("viewer")->with("flash_message", "viewer added!");
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
            $viewer = Viewer::findOrFail($id);
            return view("viewer.show", compact("viewer"));
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
            $viewer = Viewer::findOrFail($id);
    
            return view("viewer.edit", compact("viewer"));
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
				"user_id" => "nullable|integer", //integer('user_id')->nullable()

            ]);
            $requestData = $request->all();
            
            $viewer = Viewer::findOrFail($id);
            $viewer->update($requestData);
    
            return redirect("viewer")->with("flash_message", "viewer updated!");
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
            Viewer::destroy($id);
    
            return redirect("viewer")->with("flash_message", "viewer deleted!");
        }
    }
    //=======================================================================
    
    