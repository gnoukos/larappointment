<?php

namespace App\Http\Controllers;

use App\Timeslot;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();

        $timeslots = Timeslot::with('daily_appointment.appointment.option')->where('user_id', $user->id)->orderBy('slot', 'desc')->get();

        foreach ($timeslots as $timeslot){
            $timeslot->daily_appointment->date = substr($timeslot->daily_appointment->date,0,10);
            $timeslot->slot=substr($timeslot->slot,11,5);

            $parent = Option::setEagerLoads([])->whereHas('children',function($q) use($timeslot) {
                $q->where('id',$timeslot->daily_appointment->appointment->option->id);
            })->first();

            $parents=[$timeslot->daily_appointment->appointment->option->title];
            if($parent){
                array_push($parents, $parent->title);
                while($parent){
                    $id = $parent->id;
                    $parent = Option::setEagerLoads([])->whereHas('children',function($q) use($id) {
                        $q->where('id',$id);
                    })->first();
                    if($parent){
                        array_push($parents, $parent->title);
                    }
                }
            }

            $timeslot->parents=array_reverse($parents);

        }

        return view('userDashboard')->with(['user'=>$user,'timeslots'=>$timeslots]);
    }

}
