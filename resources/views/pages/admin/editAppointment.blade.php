@extends('layouts.admin')
@section('footer_include')
    <script>
        $('#extraHourSet').click( function(){
            var numOfChildren = $('#hoursBoxes').find(".row").length;
            $('#hoursBoxes').append('<div class="row mt-2">\n' +
                '                <div class="col-md-2" id="hourBoxesContainer">\n' +
                '                    <label class="mr-1" for="from"><h6>From: </h6></label><input class="form-control mr-3" name="hourBoxFrom'+(numOfChildren+1)+'" type="time">\n' +
                '                </div>\n' +
                '                <div class="col-md-2" id="hourBoxesContainer">\n' +
                '                    <label class="mr-1" for="to"><h6>To: </h6></label><input class="form-control mr-3" name="hourBoxTo'+(numOfChildren+1)+'" type="time">\n' +
                '                </div>\n' +
                '                <span class="align-middle"><i class="fas fa-times" id="deleteHourBox'+(numOfChildren+1)+'"></i></span>\n' +
                '            </div>');
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
        {{ Form::open(['action' => ['AppointmentController@update',$appointment->id], 'method' => 'PUT']) }}
        <div id="appointmentOption"><h4>Appointment refers to: </h4>
            <select class="custom-select" name="belongToOption">
                <option>Choose an option</option>
                @foreach($options as $option)
                    <option value="{{$option->id}}" @if($option->id==$appointment->belong_to_option) selected @endif>{{$option->title}}</option>
                @endforeach
            </select></div>
        <hr>
        <h4>Days of Appointment</h4>
        <hr>
        <div class="row">
            <?php $availDays = json_decode($appointment->repeat,true) ?>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="monday" value="Monday" @if(in_array("monday", $availDays)) checked @endif> Monday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="tuesday" value="Tuesday" @if(in_array("tuesday", $availDays)) checked @endif> Tuesday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="wednesday" value="Wednesday" @if(in_array("wednesday", $availDays)) checked @endif> Wednesday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="thursday" value="Thursday" @if(in_array("thursday", $availDays)) checked @endif> Thursday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="friday" value="Friday" @if(in_array("friday", $availDays)) checked @endif> Friday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="saturday" value="Saturday" @if(in_array("saturday", $availDays)) checked @endif> Saturday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="sunday" value="Sunday" @if(in_array("sunday", $availDays)) checked @endif> Sunday</h6></div>
        </div>
        <hr>
        <h4>Hours of Appointment</h4>
        <hr>
        <div id="hoursBoxes">
            @foreach($appointment->appointment_hours as $appointment_hour)
                <div class="row">
                    <div class="col-md-2" id="hourBoxesContainer">
                        <label class="mr-1" for="from"><h6>From: </h6></label><input class="form-control mr-3" name="hourBoxFrom1" type="time" value="{{ $appointment_hour->start }}">
                    </div>
                    <div class="col-md-2" id="hourBoxesContainer">
                        <label class="mr-1" for="to"><h6>To: </h6></label><input class="form-control mr-3" name="hourBoxTo1" type="time" value="{{ $appointment_hour->end }}">
                    </div>
                    <span class="align-middle"><i class="fas fa-times" id="deleteHourBox1"></i></span>
                </div>
            @endforeach

        </div><div id="extraHourSet" style="cursor: pointer;"><i class="far fa-plus-square fa-2x"></i></div>
        <hr>
        <h4>Settings</h4>
        <hr>
        <div class="form-inline"><p class="h6">Available Appointments for: <input class="form-control mr-3" type="number" name="weeks" value="{{ $appointment->weeks }}">weeks</p></div>
        <div class="form-inline"><p class="h6">Average Duration of Appointment: <input class="form-control mr-3" type="number" name="duration" value="{{ $appointment->duration }}">minutes</p></div>
        <div class="form-inline"><p class="h6">Type: <select class="custom-select" name="typeOfAppointment"><option value="regular" @if($appointment->type=='regular') selected @endif>Regular</option><option value="ticket" @if($appointment->type=='ticket') selected @endif>Timeslots</option></select></p></div>
        {{ Form::submit('Update', ['class' => 'btn btn-large btn-primary mt-5 mb-5']) }}
        {{ Form::close() }}
        @if(session('success'))

            <div class="alert alert-success">
                {{session('success')}}
            </div>

        @endif
    </div>

@endsection