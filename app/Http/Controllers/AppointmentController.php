<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\DailyAppointment;
use App\Mail\successfullAssignation;
use App\Option;
use App\User;
use Illuminate\Support\Facades\App;
use Session;
use App\AppointmentHours;
use App\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'belongToOption' => 'required',
            'days' => 'required|min:1',
            'hourBoxFrom1' => 'required',
            'hourBoxTo1' => 'required',
            'weeks' => 'required',
            'duration' => 'required',
            'typeOfAppointment' => 'required|in:regular,ticket'
        ]);

        if ($validator->fails()) {
            return redirect('/createAppointment')->withErrors($validator)->withInput();
        }

        $appointment = new Appointment();
        $appointment->type = $request->typeOfAppointment;
        $appointment->weeks = $request->weeks;
        $appointment->duration = $request->duration;
        $appointment->belong_to_option = $request->belongToOption;

                $appointment->repeat = json_encode($request->days);

        $appointment->save();

        for($hid=1;$hid<=30;$hid++){


            if($request->has('hourBoxFrom'.$hid) && $request->has('hourBoxTo'.$hid)) {


                $appointment_hours = new AppointmentHours();

                $appointment_hours->appointment_id = $appointment->id;
                $appointment_hours->start = $request->{'hourBoxFrom'.$hid};
                $appointment_hours->end = $request->{'hourBoxTo'.$hid};

                $appointment_hours->save();
            }
        }
        //CREATING DAILY APPOINTMENTS
        $repeat = json_decode($appointment->repeat);
        $start = time()+86400;
        $end = $start + 604800*$appointment->weeks;
        $current = $start;
        while($current < $end){
            $weekday = strtolower(date('l', $current));
            if(in_array($weekday, $repeat)){
                $daily_appointment = new DailyAppointment();

                $daily_appointment->date = date("Y-m-d H:i:s", $current);
                $daily_appointment->appointment_id = $appointment->id;
                $daily_appointment->free_slots = 0;

                $daily_appointment->save();
            }
            $current = $current + 86400;
        }
        /////////////////////
        ///
        /// CREATING TIMESLOTS
        $appointment_hours = AppointmentHours::where('appointment_id',$appointment->id)->get();
        $daily_appointments = DailyAppointment::where('appointment_id',$appointment->id)->get();
        Log::info($appointment_hours);
        Log::info($daily_appointments);
        foreach ($daily_appointments as $daily_appointment){

            foreach ($appointment_hours as $appointment_hour){

                $tmpDate = new \Datetime($daily_appointment->date);
                $tmpDate = $tmpDate->format('Y-m-d');

                $tmp_slot = $tmpDate ;

                $start = new \DateTime($tmp_slot . " " . $appointment_hour->start);
                $end = new \DateTime($tmp_slot . " " . $appointment_hour->end);
                for($start; $start<$end; $start->modify("+{$appointment->duration} minutes")){

                    $timeslot = new Timeslot();
                    $timeslot->daily_appointments_id = $daily_appointment->id;
                    $timeslot->slot = $start;
                    $timeslot->save();
                }
            }

            $daily_appointment->free_slots= Timeslot::where('daily_appointments_id',$daily_appointment->id)->count();
            $daily_appointment->save();
        }

        ///////////////////

        return redirect('/manageAppointments')->with('success', 'Appointment saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//Appointment $appointment
    {
        $options = Option::doesntHave('children')->get();
        $appointment = Appointment::find($id);
        return view('pages.admin.editAppointment')->with(['appointment' => $appointment, 'options' => $options]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validator = Validator::make($request->all(), [
            'belongToOption' => 'required',
            'days' => 'required|min:1',
            'hourBoxFrom1' => 'required',
            'hourBoxTo1' => 'required',
            'weeks' => 'required',
            'duration' => 'required',
            'typeOfAppointment' => 'required|in:regular,ticket'
        ]);

        if ($validator->fails()) {
            return redirect('/appointment/'.$appointment->id.'/edit')->withErrors($validator)->withInput();
        }

        $appointment->type = $request->typeOfAppointment;
        $appointment->weeks = $request->weeks;
        $appointment->duration = $request->duration;
        $appointment->belong_to_option = $request->belongToOption;

        $appointment->repeat = json_encode($request->days);

        $appointment->save();

         AppointmentHours::where('appointment_id',$appointment->id)->delete();


        for($hid=1;$hid<=30;$hid++){
            if($request->has('hourBoxFrom'.$hid) && $request->has('hourBoxTo'.$hid)) {

                $appointment_hours = new AppointmentHours();

                $appointment_hours->appointment_id = $appointment->id;
                $appointment_hours->start = $request->{'hourBoxFrom'.$hid};
                $appointment_hours->end = $request->{'hourBoxTo'.$hid};

                $appointment_hours->save();
            }
        }


        return redirect('/manageAppointments')->with('success', 'Appointment saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //Appointment $appointment
    {
        Appointment::destroy($id);
        return redirect('/manageAppointments');
    }

    public function getFreeTimeslots(Request $request)
    {
        $option = $request->option;
        $date = $request->date;

        $timeslots = Timeslot::whereHas('daily_appointment.appointment.option', function ($q) use($option, $date) {
            $q->where('id', $option);
        })->where('slot', 'like', $date.'%')->where('user_id', null)->orderBy('slot', 'asc')->get();

        //Log::info($timeslots);

        return response()->json($timeslots);
    }

    public function getDailyAppointment(Request $request){
        $option = $request->option;
        $date = $request->date;

        $dailyAppointment = DailyAppointment::whereHas('appointment.option', function($q) use($option, $date) {
            $q->where('id', $option);
        })->where('date', 'like', $date.'%')->first();

        //$dailyAppointmentId = $dailyAppointment->id;

        return response()->json($dailyAppointment);

    }

    public function makeAppointment(Request $request)
    {
        $timeslot = Timeslot::findOrFail($request->timeslot);

        $optionId = $request->session()->get('optionId');

        if(!Auth::check()){
            $validator = Validator::make($request->all(), [
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|string|email|max:255|unique:users,email',
                'guest_phone' => 'required|numeric|min:8'
            ]);

            $attributeNames = array(
                'guest_name' => 'name',
                'guest_email' => 'e-mail',
                'guest_phone' => 'phone',

            );

            $validator->setAttributeNames($attributeNames);


            if ($validator->fails()) {
                return redirect(url('/datepicker?option='.$optionId))->withErrors($validator)->withInput();
            }

            $user = new User();
            $randomUserPassword = str_random(8);
            $user->name = $request->guest_name;
            $user->role = 'user';
            $user->password = Hash::make($randomUserPassword);
            $user->email = $request->guest_email;
            $user->mobile_num = $request->guest_phone;
            $user->save();

            if($timeslot->user_id == null) {
                $timeslot->user_id = $user->id;
                $timeslot->save();
            }

        }else{

            $user = Auth::user();

            if($timeslot->user_id == null) {
                $timeslot->user_id = $user->id;
                $timeslot->save();
            }
        }


        //Mail::to($request->user())->send(new successfullAssignation($timeslot));

        return view('pages.successfulAssignation')->with('timeslot', $timeslot);
    }

    public function getTicket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dailyAppointmentId' => 'required|numeric'
        ]);

        $optionId = $request->session()->get('optionId');

        if ($validator->fails()) {
            return redirect('/datepicker?option='.$optionId)->withErrors($validator);
        }

        $dailyAppointmentId = $request->dailyAppointmentId;
        $dailyAppointment = DailyAppointment::find($dailyAppointmentId);
        Log::info($dailyAppointment);
        if($dailyAppointment && $dailyAppointment->free_slots > 0){
            $dailyAppointment->free_slots = $dailyAppointment->free_slots - 1;
            $dailyAppointment->save();
        }else{
            return redirect('/datepicker?option='.$optionId)->withErrors("No available tickets");
        }

        $timeslot = Timeslot::where('daily_appointments_id', $dailyAppointmentId)->where('user_id', null)->where('ticket_num', null)->orderBy('slot', 'asc')->first();

        $totalTimeslots = Timeslot::where('daily_appointments_id', $dailyAppointmentId)->count();

        $freeTimeslots = Timeslot::where('daily_appointments_id', $dailyAppointmentId)->where('ticket_num', null)->count();

        $timeslot->ticket_num = ($totalTimeslots - $freeTimeslots)+1;

        $timeslot->save();

        return view('pages.Ticket')->with('timeslot', $timeslot);
    }

    public function flushSlot($id){

        $timeslot = Timeslot::find($id);
        if(Auth::user()->id == $timeslot->user_id || Auth::user()->role == 'admin'){
            $timeslot->user_id = null;
            $timeslot->save();
        }

        if(Auth::user()->role == 'admin'){
            return redirect('/admin');
        }
        return redirect('/dashboard');
    }
}












