<?php

namespace App\Http\Controllers;

use App\Timeslot;
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

        $timeslots = Timeslot::where('user_id', $user->id)->orderBy('slot', 'desc')->get();

        foreach ($timeslots as $timeslot){
            $timeslot->daily_appointment->date = substr($timeslot->daily_appointment->date,0,10);
            $timeslot->slot=substr($timeslot->slot,11,5);
        }

        return view('userDashboard')->with(['user'=>$user,'timeslots'=>$timeslots]);
    }
}
