@extends('layouts.admin')
@section('footer_include')
    <script>
         $('#extraHourSet').click( function(){
            var numOfChildren = $('#hourBoxesContainer').find("label").length/2;
            $('#hourBoxesContainer').append('<label class="mr-1" for="from">From: </label><input class="form-control mr-3" name="hourBoxFrom'+(numOfChildren+1)+'" type="time">' +
                                            '<label class="mr-1" for="to">To: </label><input class="form-control mr-3" name="hourBoxTo'+(numOfChildren+1)+'" type="time">');
        });
    </script>
@endsection
@section('content')

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Appointments</li>
        </ol>

    </div>
    <!-- /.container-fluid -->
    <div class="container mt-5 mb-5">
        {{ Form::open(array('action' => 'AppointmentController@store')) }}
        <div id="appointmentOption"><h4>Appointment refers to: </h4>
            <select class="custom-select" name="belongToOption">
                <option>Choose an option</option>
                @foreach($options as $option)
                    <option value="{{$option->id}}">{{$option->title}}</option>
                @endforeach
            </select></div>
        <hr>
        <h4>Days of Appointment</h4>
        <hr>
        <div class="row">
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="monday" value="Monday"> Monday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="tuesday" value="Tuesday"> Tuesday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="wednesday" value="Wednesday"> Wednesday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="thursday" value="Thursday"> Thursday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="friday" value="Friday"> Friday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="saturday" value="Saturday"> Saturday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="sunday" value="Sunday"> Sunday</h6></div>
        </div>
        <hr>
        <h4>Hours of Appointment</h4>
        <hr>
        <div class="form-inline">
            <div class="form-group" id="hourBoxesContainer">
                <label class="mr-1" for="from"><h6>From: </h6></label><input class="form-control mr-3" name="hourBoxFrom1" type="time">
                <label class="mr-1" for="to"><h6>To: </h6></label><input class="form-control mr-3" name="hourBoxTo1" type="time">
            </div>
            <div id="extraHourSet" style="cursor: pointer;"><i class="far fa-plus-square fa-2x"></i></div>
        </div>
        <hr>
        <h4>Settings</h4>
        <hr>
        <div class="form-inline"><p class="h6">Available Appointments for: <input class="form-control mr-3" type="number" name="weeks">weeks</p></div>
        <div class="form-inline"><p class="h6">Average Duration of Appointment: <input class="form-control mr-3" type="number" name="duration">minutes</p></div>
        <div class="form-inline"><p class="h6">Type: <select class="custom-select" name="typeOfAppointment"><option value="regular">Regular</option><option value="timeslots">Timeslots</option></select></p></div>
        {{ Form::submit('Save', ['class' => 'btn btn-large btn-primary mt-5 mb-5']) }}
        {{ Form::close() }}
        @if(session('success'))

            <div class="alert alert-success">
                {{session('success')}}
            </div>

        @endif
    </div>

@endsection