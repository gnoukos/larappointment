<?php

namespace App\Http\Controllers;

use App\Jobs\appointmentCanceledJob;
use App\Mail\appointmentCanceled;
use Illuminate\Support\Facades\Mail;
use App\Option;
use App\Timeslot;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
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

///// find existing levels
        $levels = array();
        $level = Option::setEagerLoads([])->where('parent', -1)->first();
        if($level){
            array_push($levels, $level->title);
            while($level){
                $id = $level->id;
                $level = Option::where('parent', $id)->first();
                if($level){
                    array_push($levels, $level->title);
                }
            }
        }
        //////find existing levels end
//////////////////find max depth
        $options = Option::setEagerLoads([])->where('parent', NULL)->get();
        $depth = array();
        $ctr=0;
        foreach ($options as $option){
            $depth[$ctr]=0;
            if($option){
                while($option){
                    $id = $option->id;
                    $option = Option::where('parent', $id)->first();
                    if($option){
                        $depth[$ctr]++;
                    }
                }
            }
            $ctr++;
        }
        $maxDepth=0;
        foreach ($depth as $d){
            if($d>$maxDepth){
                $maxDepth=$d;
            }
        }
        $maxDepth++; /// find max depth end
 /////////////////
        //////give names to no named levels

        $loops = $maxDepth - sizeof($levels);

        for($i=0; $i<$loops; $i++){
            array_push($levels, "No Title");
        }

        $oldLevel = Option::setEagerLoads([])->where('parent', -1)->first();
        while ($oldLevel) {
            $id = $oldLevel->id;
            $oldLevel->delete();
            $oldLevel = Option::where('parent', $id)->first();
        }

        $parent = null;
        foreach ($levels as $key => $level) {
            if ($key == 0) {
                $option = new Option();
                $option->title = $level;
                $option->parent = -1;
                $option->save();
                $parent = $option->id;
            } else {
                $option = new Option();
                $option->title = $level;
                $option->parent = $parent;
                $option->save();
                $parent = $option->id;
            }
        }

/////give names to no named levels end
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
        $option = Option::where('id', $id)->with('appointments', 'appointments.appointment_hours', 'appointments.daily_appointments', 'appointments.daily_appointments.timeslots')->first();
        foreach ($option->appointments as $appointment) {
            foreach ($appointment->daily_appointments as $daily) {
                foreach ($daily->timeslots as $slot){
                    if($slot->user){
                        $parents = getTimeSlotOptionParentsArray($slot);
                        //Mail::to($slot->user)->send(new appointmentCanceled($slot, $parents));
                        $details['user'] = $slot->user;
                        $details['timeslot'] = $slot;
                        $details['parents'] = $parents;
                        $mailJob = (new appointmentCanceledJob($details))->delay(Carbon::now()->addSeconds(3));
                        dispatch($mailJob);
                    }
                }
                $daily->timeslots()->delete();
            }
            $appointment->appointment_hours()->delete();
            $appointment->daily_appointments()->delete();
        }
        $option->appointments()->delete();
        $option->delete();


    }

    public function children($id,Request $request)
    {
        $options = Option::setEagerLoads([])->where('parent', $id)->with('appointments')->get();

        foreach ($options as $key=>$option){ //remove disabled or empty(NO APPOINTMENTS) options
            $option->hasAppointment = 0;
            if($request->isOption=='true' && !$option->children->count() && !$option->appointments->count()){
                $options->forget($key);
            }else{
                foreach ($option->appointments as $appointment){
                    if(!$appointment->enabled){
                        $options->forget($key);
                        break;
                    }else{
                        $option->hasAppointment = 1;
                    }
                }
            }
            $sumOfFreeSlots = 0;
            foreach ($option->appointments as $app){
                foreach ($app->daily_appointments as $d_appointment){
                    $sumOfFreeSlots = $sumOfFreeSlots + $d_appointment->free_slots;
                }
            }
            if($sumOfFreeSlots<=0 && $request->isOption=='true' && !$option->children->count()){
               $options->forget($key);
            }

        }
        return response()->json($options);
    }

    public function storeLevels(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'levels.*' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/levels')->withErrors($validator);
        }

        $levels = Option::setEagerLoads([])->where('parent', -1)->first();


        while ($levels) {
            $id = $levels->id;
            $levels->delete();
            $levels = Option::where('parent', $id)->first();
        }


        $levels = $request->levels;

        $parent = null;
        foreach ($levels as $key => $level) {
            if ($key == 0) {
                $option = new Option();
                $option->title = $level;
                $option->parent = -1;
                $option->save();
                $parent = $option->id;
            } else {
                $option = new Option();
                $option->title = $level;
                $option->parent = $parent;
                $option->save();
                $parent = $option->id;
            }
        }

        return redirect('/levels')->with('success', 'Level names saved!');
    }


}
