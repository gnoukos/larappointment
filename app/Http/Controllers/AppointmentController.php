<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\DailyAppointment;
use App\Option;
use App\AppointmentHours;
use App\Timeslot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Validator;

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

        /*$daysArray = array();
        if($request->has('monday')){
            array_push($daysArray, 'monday');
        }
        if($request->has('tuesday')){
            array_push($daysArray, 'tuesday');
        }
        if($request->has('wednesday')){
            array_push($daysArray, 'wednesday');
        }
        if($request->has('thursday')){
            array_push($daysArray, 'thursday');
        }
        if($request->has('friday')){
            array_push($daysArray, 'friday');
        }
        if($request->has('saturday')){
            array_push($daysArray, 'saturday');
        }
        if($request->has('sunday')){
            array_push($daysArray, 'sunday');
        }*/

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

                $daily_appointment->date = gmdate("Y-m-d H:i:s", $current);
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

        /*$daysArray = array();
        if($request->has('monday')){
            array_push($daysArray, 'monday');
        }
        if($request->has('tuesday')){
            array_push($daysArray, 'tuesday');
        }
        if($request->has('wednesday')){
            array_push($daysArray, 'wednesday');
        }
        if($request->has('thursday')){
            array_push($daysArray, 'thursday');
        }
        if($request->has('friday')){
            array_push($daysArray, 'friday');
        }
        if($request->has('saturday')){
            array_push($daysArray, 'saturday');
        }
        if($request->has('sunday')){
            array_push($daysArray, 'sunday');
        }*/

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
}
