@extends('layouts.admin')
@section('footer_include')
    <script>
        $('#extraHourSet').click( function(){
            var numOfChildren = $('#hoursBoxes').find(".row").length;
            $('#hoursBoxes').append('<div class="row mt-2" id="row'+(numOfChildren+1)+'">\n' +
                '                <div class="col-md-2" id="hourBoxesContainer">\n' +
                '                    <label class="mr-1" for="from"><h6>From: </h6></label><input class="form-control mr-3" name="hourBoxFrom'+(numOfChildren+1)+'" type="time">\n' +
                '                </div>\n' +
                '                <div class="col-md-2" id="hourBoxesContainer">\n' +
                '                    <label class="mr-1" for="to"><h6>To: </h6></label><input class="form-control mr-3" name="hourBoxTo'+(numOfChildren+1)+'" type="time">\n' +
                '                </div>\n' +
                '                <span class="align-middle"><i class="fas fa-times" id="deleteHourBox'+(numOfChildren+1)+'" onclick="deleteHourBox('+(numOfChildren+1)+')"></i></span>\n' +
                '            </div>');
        });

        function deleteHourBox(id){
            $('#row'+id).fadeOut(300,function(){$(this).remove();});;
        }
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
        @if(count($errors) >0)
            @foreach($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif
        {{ Form::open(array('action' => 'AppointmentController@store')) }}
        <div id="appointmentOption"><h4>Category refers to: </h4>
            <select class="custom-select" name="belongToOption">
                <option>Choose an option</option>
                @foreach($options as $option)
                    <option value="{{$option->id}}" @if(old('belongToOption') && old('belongToOption')==$option->id) selected="selected" @endif>{{$option->title}}</option>
                @endforeach
            </select></div>
        <hr>
        <h4>Days of Appointment</h4>
        <hr>
        <div class="row">
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="days[]" value="monday" > Monday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="days[]" value="tuesday" > Tuesday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="days[]" value="wednesday" > Wednesday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="days[]" value="thursday" > Thursday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="days[]" value="friday" > Friday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="days[]" value="saturday" > Saturday</h6></div>
            <div class="col-md-3 mt-2"><h6><input type="checkbox" name="days[]" value="sunday" > Sunday</h6></div>
        </div>
        <hr>
        <h4>Hours of Appointment</h4>
        <hr>
        <div id="hoursBoxes">
            <div class="row">
                <div class="col-md-2" id="hourBoxesContainer">
                    <label class="mr-1" for="from"><h6>From: </h6></label><input class="form-control mr-3" name="hourBoxFrom1" type="time" value="{{ old('hourBoxFrom1') }}">
                </div>
                <div class="col-md-2" id="hourBoxesContainer">
                    <label class="mr-1" for="to"><h6>To: </h6></label><input class="form-control mr-3" name="hourBoxTo1" type="time" value="{{ old('hourBoxTo1') }}">
                </div>
            </div>

        </div><div class="mt-2" id="extraHourSet" style="cursor: pointer;"><i class="far fa-plus-square fa-2x"></i></div>
        <hr>
        <h4>Settings</h4>
        <hr>
        <div class="form-inline"><p class="h6">Appointment Available Until: <input class="form-control mr-3" type="date" name="endDate" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ old('endDate') }}"> or <input class="form-control mr-3 ml-3" type="number" name="weeks" value="{{ old('weeks') }}"> weeks</p></div>
        <div class="form-inline"><p class="h6">Average Duration of Appointment: <input class="form-control mr-3" type="number" name="duration" value="{{ old('duration') }}">minutes</p></div>
        <div class="form-inline"><p class="h6">Type: <select class="custom-select" name="typeOfAppointment"><option value="regular" @if(old('typeOfAppointment') && old('typeOfAppointment')=='regular') selected="selected" @endif>Regular</option><option value="ticket" @if(old('typeOfAppointment') && old('typeOfAppointment')=='ticket') selected="selected" @endif>Ticket</option></select></p></div>
        {{ Form::submit('Save', ['class' => 'btn btn-large btn-primary mt-5 mb-5']) }}
        {{ Form::close() }}
        @if(session('success'))

            <div class="alert alert-success">
                {{session('success')}}
            </div>

        @endif
    </div>

@endsection