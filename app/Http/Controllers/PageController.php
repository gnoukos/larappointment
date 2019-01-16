<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\DailyAppointment;
use Illuminate\Http\Request;
use App\Option;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\Auth;

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
        $optionId = Input::get('option');

        session(['optionId' => $optionId]);

        $dailyAppointments = DailyAppointment::whereHas('appointment.option', function ($q) use($optionId) {
            $q->where('id', $optionId);
        })->where('free_slots', '>', 0)->orderBy('date', 'desc')->get();



        $current = date("Y-m-d");
        $disabledDates = [$current];


        while($current <= $dailyAppointments[0]->date){
            $current = date('Y-m-d', strtotime($current .' +1 day'));
            array_push($disabledDates, $current);
        }


        foreach ($dailyAppointments as $dailyAppointment){
            if (($key = array_search(substr($dailyAppointment->date, 0, -9), $disabledDates)) !== false) {
                unset($disabledDates[$key]);
            }
        }


        Log::info($dailyAppointments);
        Log::info($disabledDates);


       $maxAvailDate = $dailyAppointments[0]->date;


        return view('pages.datepicker')->with(['disabledDates'=>$disabledDates, 'maxAvailDate'=>$maxAvailDate]);
    }

    public function adminDashboard(){
        if (Auth::user()->role=='admin') {
            return view('pages.admin.adminDashboard');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function hierarchy(){

        if (Auth::user()->role=='admin') {
            return view('pages.admin.hierarchy');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function createAppointment(){

        if (Auth::user()->role=='admin') {
            $options = Option::doesntHave('children')->get();
            return view('pages.admin.createAppointment')->with('options', $options);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function manageAppointments(){

        if (Auth::user()->role=='admin') {
            $appointments = Appointment::all();
            return view('pages.admin.manageAppointments')->with('appointments', $appointments);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}
