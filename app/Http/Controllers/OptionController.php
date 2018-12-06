<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;
use Validator;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::where('parent', null)->get();
        return response()->json($options);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }

        $option = new Option();
        $option->title = $request->title;
        $option->save();

        return response()->json(['success' => 'Option added successfully!', 'optionId' => $option->id, 'optionTitle' => $option->title]);
    }

    public function updateHierarchy(Request $request)
    {
        $output = json_decode($request['output']);
        foreach ($output as $item) {
            $option = Option::find($item->id);
            if ($item->parent_id != "") {
                $option->parent = $item->parent_id;
            } else {
                $option->parent = null;
            }
            $option->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        if(Auth::check() && Auth::user()->role == 'ADMIN'){
//
//        }
        Option::destroy($id);
    }

    public function children($id)
    {
        $options = Option::setEagerLoads([])->where('parent',$id)->get();
        return response()->json($options);
    }

}
