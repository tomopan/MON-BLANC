<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\Bookshelve;
    
    //=======================================================================
    class BookshelvesController extends Controller
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
                $bookshelve = Bookshelve::where("id","LIKE","%$keyword%")->orWhere("user_id", "LIKE", "%$keyword%")->orWhere("novel_id", "LIKE", "%$keyword%")->paginate($perPage);
            } else {
                    $bookshelve = Bookshelve::paginate($perPage);              
            }          
            return view("bookshelve.index", compact("bookshelve"));
        }
    
        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\View\View
         */
        public function create()
        {
            return view("bookshelve.create");
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
				"user_id" => "nullable|integer", //integer('user_id')->nullable()
				"novel_id" => "nullable|integer", //integer('novel_id')->nullable()

            ]);
            $requestData = $request->all();
            
            Bookshelve::create($requestData);
    
            return redirect("bookshelve")->with("flash_message", "bookshelve added!");
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
            $bookshelve = Bookshelve::findOrFail($id);
            return view("bookshelve.show", compact("bookshelve"));
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
            $bookshelve = Bookshelve::findOrFail($id);
    
            return view("bookshelve.edit", compact("bookshelve"));
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
				"user_id" => "nullable|integer", //integer('user_id')->nullable()
				"novel_id" => "nullable|integer", //integer('novel_id')->nullable()

            ]);
            $requestData = $request->all();
            
            $bookshelve = Bookshelve::findOrFail($id);
            $bookshelve->update($requestData);
    
            return redirect("bookshelve")->with("flash_message", "bookshelve updated!");
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
            Bookshelve::destroy($id);
    
            return redirect("bookshelve")->with("flash_message", "bookshelve deleted!");
        }
    }
    //=======================================================================
    
    