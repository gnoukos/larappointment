<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\DailyAppointment;
use Illuminate\Http\Request;
use App\Option;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

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
        $dailyAppointments = DailyAppointment::whereHas('appointment.option', function ($q) use($optionId) {
            $q->where('id', $optionId);
        })->where('free_slots', '>', 0)->orderBy('date', 'asc')->get();

        Log::info($dailyAppointments);

        $current = date("Y-m-d");
        $disabledDates = [$current];

        while($current <= $dailyAppointments[0]->date){
            $current = date('Y-m-d', strtotime($current .' +1 day'));
            array_push($disabledDates, $current);
        }

        foreach ($dailyAppointments as $dailyAppointment){
            if (($key = array_search($dailyAppointment->date, $disabledDates)) !== false) {
                unset($disabledDates[$key]);
            }
        }

        $maxAvailDate = $dailyAppointments[0]->date;

        Log::info($disabledDates);
        Log::info($maxAvailDate);

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

    public function manageAppointments(){
        $appointments = Appointment::all();
        return view('pages.admin.manageAppointments')->with('appointments', $appointments);
    }
}
