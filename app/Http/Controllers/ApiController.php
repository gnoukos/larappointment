<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\DailyAppointment;
use App\Mail\appointmentCanceled;
use App\Mail\successfullAssignation;
use App\Jobs\appointmentCanceledJob;
use App\Jobs\appointmentAssignationJob;
use App\Option;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use App\AppointmentHours;
use App\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ApiController extends Controller
{
    public function getTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dailyAppointmentId' => 'required|numeric'
        ]);

        $optionId = $request->session()->get('optionId');

        if ($validator->fails()) {
            return response()->json('Invalid Input Given');
        }

        $dailyAppointmentId = $request->dailyAppointmentId;
        $dailyAppointment = DailyAppointment::find($dailyAppointmentId);
        if($dailyAppointment && $dailyAppointment->free_slots > 0){
            $dailyAppointment->free_slots = $dailyAppointment->free_slots - 1;
            $dailyAppointment->save();
        }else{
            return response()->json("No available tickets");
        }

        $startingHour = Timeslot::where('daily_appointments_id', $dailyAppointmentId)->orderBy('slot', 'asc')->first();
        $startingHour = $startingHour->slot;

        $timeslot = Timeslot::where('daily_appointments_id', $dailyAppointmentId)->where('user_id', null)->where('ticket_num', null)->orderBy('slot', 'asc')->first();

        $totalTimeslots = Timeslot::where('daily_appointments_id', $dailyAppointmentId)->count();

        $freeTimeslots = Timeslot::where('daily_appointments_id', $dailyAppointmentId)->where('ticket_num', null)->count();

        $timeslot->ticket_num = ($totalTimeslots - $freeTimeslots)+1;

        if(Auth::check()){
            $timeslot->user_id=Auth::user()->id;
        }
        else{
            $timeslot->user_id=null;
        }



        $timeslot->save();

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

        $parents=array_reverse($parents);


        session(['Stimeslot' => $timeslot]);
        session(['Sparents' => $parents]);
        session(['SstartingHour' => $startingHour]);

        return response()->json(['ticket_info'=>$timeslot,'parents'=>$parents,'startingHour'=>$startingHour]);
        return Redirect::Route('getTicketView')->with('timeslot' , $timeslot)->with('parents',$parents)->with('startingHour',$startingHour);
    }
}
