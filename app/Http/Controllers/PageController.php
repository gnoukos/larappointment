<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;

class PageController extends Controller
{
    public function index(){

        $options = Option::setEagerLoads([])->where('parent',null)->get();
        //$options = Option::setEagerLoads(array('children'))->where('parent', 1)->get();
//       $options = Option::where('id', 1)->with(array('children:id,title' =>function($query){
//          $query->setEagerLoads([]);
//       }))->get();
       // return response()->json($options);
        return view('pages.index')->with('options',$options);
    }

    public function datePicker(){
        return view('pages.datepicker');
    }

    public function adminDashboard(){
        return view('pages.admin.adminDashboard');
    }

    public function hierarchy(){
        return view('pages.admin.hierarchy');
    }

    public function createAppointment(){
        $options = Option::doesntHave('children')->get();
        return view('pages.admin.createAppointment')->with('options', $options);
    }
}
