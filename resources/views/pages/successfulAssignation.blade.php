@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <div class="card mt-4" id="userDetailsCard">
                <div class="card-body">
                    <h1 class="card-title mt-5 mb-5"><i class="fas fa-calendar-check fa-5x"></i></h1>
                    <div class="wrapper text-center mt-5 mb-5">
                        <h3>Your appointment in <span class="text-success">{{ $timeslot->daily_appointment->appointment->option->title }}</span>, was set for: <span class="text-success">{{ \Carbon\Carbon::parse($timeslot->slot)->format('l d/m/Y') }}</span> at <span class="text-success">{{ \Carbon\Carbon::parse($timeslot->slot)->format('H:i') }}</span></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection