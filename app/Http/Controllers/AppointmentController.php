<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Option;
use App\AppointmentHours;
use Illuminate\Http\Request;
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
            'monday' => 'required_without_all: tuesday, wednesday, thursday, friday, saturday, sunday',
            'tuesday' => 'required_without_all: monday, wednesday, thursday, friday, saturday, sunday',
            'wednesday' => 'required_without_all: tuesday, monday, thursday, friday, saturday, sunday',
            'thursday' => 'required_without_all: tuesday, wednesday, monday, friday, saturday, sunday',
            'friday' => 'required_without_all: tuesday, wednesday, thursday, monday, saturday, sunday',
            'saturday' => 'required_without_all: tuesday, wednesday, thursday, friday, monday, sunday',
            'sunday' => 'required_without_all: tuesday, wednesday, thursday, friday, saturday, monday',
            'hourBoxFrom1' => 'required',
            'hourBoxTo1' => 'required',
            'weeks' => 'required',
            'duration' => 'required',
            'typeOfAppointment' => 'required|in:regular,ticket'
        ]);

        $appointment = new Appointment();
        $appointment->type = $request->typeOfAppointment;
        $appointment->weeks = $request->weeks;
        $appointment->duration = $request->duration;
        $appointment->belong_to_option = $request->belongToOption;

        $daysArray = array();
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
        }

        $appointment->repeat = json_encode($daysArray);

        $appointment->save();

        $appointment_hours = new AppointmentHours();

        $appointment_hours->appointment_id = $appointment->id;
        $appointment_hours->start = $request->hourBoxFrom1;
        $appointment_hours->end = $request->hourBoxTo1;

        $appointment_hours->save();

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
            'monday' => 'required_without_all: tuesday, wednesday, thursday, friday, saturday, sunday',
            'tuesday' => 'required_without_all: monday, wednesday, thursday, friday, saturday, sunday',
            'wednesday' => 'required_without_all: tuesday, monday, thursday, friday, saturday, sunday',
            'thursday' => 'required_without_all: tuesday, wednesday, monday, friday, saturday, sunday',
            'friday' => 'required_without_all: tuesday, wednesday, thursday, monday, saturday, sunday',
            'saturday' => 'required_without_all: tuesday, wednesday, thursday, friday, monday, sunday',
            'sunday' => 'required_without_all: tuesday, wednesday, thursday, friday, saturday, monday',
            'hourBoxFrom1' => 'required',
            'hourBoxTo1' => 'required',
            'weeks' => 'required',
            'duration' => 'required',
            'typeOfAppointment' => 'required|in:regular,ticket'
        ]);

        $appointment->type = $request->typeOfAppointment;
        $appointment->weeks = $request->weeks;
        $appointment->duration = $request->duration;
        $appointment->belong_to_option = $request->belongToOption;

        $daysArray = array();
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
        }

        $appointment->repeat = json_encode($daysArray);

        $appointment->save();

        $appointment_hours = new AppointmentHours();

        $appointment_hours->appointment_id = $appointment->id;
        $appointment_hours->start = $request->hourBoxFrom1;
        $appointment_hours->end = $request->hourBoxTo1;

        $appointment_hours->save();

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
