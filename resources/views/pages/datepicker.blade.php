@extends('layouts.app')

@section('include')

    <link rel="stylesheet" href="{{ asset('bower_components/pg-calendar/dist/css/pignose.calendar.css') }}" />
    <script src="{{ asset('bower_components/pg-calendar/dist/js/pignose.calendar.full.js') }}"></script>



@endsection



@section('content')
    <div class="row">
        <div class="col-lg mt-5 text-center">
            <div class="calendar" id="pignoseCalendar" style="display: none;"></div>
            <button class="btn btn-dark mt-3" id="nextAvailableDateButton">Next available date</button>
        </div>
        <div class="col-lg mt-5">
            <form method="post" action="{{action('AppointmentController@makeAppointment')}}">
                <div class="card" id="hoursCard" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">Choose Hour</h5>
                        <p class="card-text" id="chooseDatePrompt">First choose date to see available hours.</p>
                        <div class="wrapper text-center">
                            <div id ="optionLoader" class="spinner-border mb-3" role="status" style="display:none">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <div class="btn-group-md btn-group-toggle text-center" data-toggle="buttons" id="hourButtonContainer">
                                {{--<label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                       <input type="radio" name="13:30" id="hourRadio" autocomplete="off" value="13:30"> 13:30
                                   </label>--}}
                            </div>
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            @auth

                            <div class="col-12 text-center mt-4">
                                <textarea name="comment" class="form-control mb-4" id="userComment" rows="3" placeholder="Type your comments (optional)"></textarea>
                                <button type="submit" value="Submit" class="btn btn-primary" id="makeAppointmentButton">Make the Appointment</button>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
                @guest
                <div class="card mt-4" id="userDetailsCard">
                    <div class="card-body">
                        <h5 class="card-title">Fill with your details</h5>
                        <div class="wrapper text-center">
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tmpUserEmail" name="guest_email" value="{{ old('guest_email') }}" placeholder="Email" >
                                    @if ($errors->has('guest_email'))
                                        <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('guest_email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tmpUserName" name="guest_name" value="{{ old('guest_name') }}" placeholder="Your Name" >
                                    @if ($errors->has('guest_name'))
                                        <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('guest_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="tmpUserPhone" name="guest_phone" value="{{ old('guest_phone') }}" placeholder="Your Phone" >
                                    @if ($errors->has('guest_phone'))
                                        <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('guest_phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <textarea name="comment" class="form-control " id="userComment" rows="3" placeholder="Type your comments (optional)"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" value="Submit" class="btn btn-primary" id="makeAppointmentButton">Make the Appointment</button>
                        </div>
                    </div>

                </div>

                @endguest
            </form>
        </div>
    </div>
    <script>
        var disabledDatesArray = [@foreach ($disabledDates as $disabledDate)
           '{{ $disabledDate }}',
        @endforeach];

        var maxAvailDate = '{{$maxAvailDate}}';

        $("#hoursCard").fadeIn(1000); // fade in the hour selection box

        $("#pignoseCalendar").fadeIn(1000); // fade in the calendar

        function showMakeAppointmentButton(){
            $("#makeAppointmentButton").show();
            @auth$("#userComment").show();@endauth
        }

        $("#makeAppointmentButton").hide(); //hide button until hour selected

        @auth
        $("#userComment").hide();
        @endauth

        @if(!session('timeslotObj')) ///BLADE
        /////SET FIRST AVAILABLE DATE//////
        var maxDateObj = new Date(maxAvailDate); //creates max available date object to use in for loop
        var availDate = new Date(moment().format("YYYY-MM-DD"));
        var d = availDate;
        while (true){

            var isAvail = true;

            $.each( disabledDatesArray, function( key, value ) { //foreach loop in disabled dates array
                //console.log( key + ": " + value );
                var tmpDate = new Date(value); // creates temporary date object for disabled date
                if(d.getTime() == tmpDate.getTime()){ // checks if current date object equals disabled date object
                    isAvail = false; // if true sets isAvail to false, because date seems to be unavailable and the loop breaks
                    return false;
                }
                availDate = d; //just gets the last date of for loop
            });

            if(isAvail===true){ //if the last date was found to be available the loop stops
                $('.calendar').pignoseCalendar({ //initialize pignose calendar
                    initialize: true,
                    date: moment(availDate.getTime()),
                    disabledDates: disabledDatesArray,
                    minDate: moment().format("YYYY-MM-DD"), //disable dates before today
                    maxDate: maxAvailDate, //disable dates after a certain date
                    select: function(date, context) { //callback function to get selected date
                        try {
                            $("#hourButtonContainer").empty();
                            //console.log(date[0]._i); //selected date
                            var option = getUrlParameter('option');
                            getFreeTimeslots(option, date[0]._i);
                            $("#makeAppointmentButton").hide();
                            $("#chooseDatePrompt").hide();
                            @auth$("#userComment").hide();@endauth
                        }catch (e) {
                            $("#makeAppointmentButton").hide();
                            $("#chooseDatePrompt").show();
                            @auth $("#userComment").hide();@endauth
                        }
                    }
                });
                $('[data-date='+moment(availDate.getTime()).format("YYYY-MM-DD")+']').click();
                $('[data-date='+moment(availDate.getTime()).format("YYYY-MM-DD")+']').click();
                $('[data-date='+moment(availDate.getTime()).format("YYYY-MM-DD")+']').click();
                break;
            }

            d.setDate(d.getDate() + 1);//next possible available date

            if(d.getTime() > maxDateObj.getTime()){
                console.log("Something went really wrong!");
                break;
            }
        }
        /////SET FIRST AVAILABLE DATE END//////
        @else
        $('.calendar').pignoseCalendar({ //initialize pignose calendar
            initialize: true,
            disabledDates: disabledDatesArray,
            minDate: moment().format("YYYY-MM-DD"), //disable dates before today
            maxDate: maxAvailDate, //disable dates after a certain date
            select: function(date, context) { //callback function to get selected date
                try {
                    $("#hourButtonContainer").empty();
                    //console.log(date[0]._i); //selected date
                    var option = getUrlParameter('option');
                    getFreeTimeslots(option, date[0]._i);
                    $("#makeAppointmentButton").hide();
                    $("#chooseDatePrompt").hide();
                    @auth$("#userComment").hide();@endauth
                }catch (e) {
                    $("#makeAppointmentButton").hide();
                    $("#chooseDatePrompt").show();
                    @auth $("#userComment").hide();@endauth
                }
            }
        });
        ///SET OLD INPUT DATE AND TIME///////
        $('[data-date={{ \Carbon\Carbon::parse(session('timeslotObj')->slot)->format("Y-m-d") }}]').click();
        $( document ).ajaxComplete(function() {
            $('[value={{ old('timeslot') }}]').click();
        });
        ///SET OLD INPUT DATE AND TIME END////
        @endif
        /////////SHOW NEXT AVAILABLE DATE//////////
        $("#nextAvailableDateButton").click(function(){	//function to find first available date

            var maxDateObj = new Date(maxAvailDate); //creates max available date object to use in for loop

            var preMonth = availDate.getMonth();

            availDate.setDate(availDate.getDate() + 1);

            var nextMonth = availDate.getMonth();

            if(preMonth !== nextMonth){
                $('.pignose-calendar-top-next').click();
            }

            for (var d = availDate; d.getTime() <= maxDateObj.getTime(); d.setDate(d.getDate() + 1)) { // for loop from today until max available date

                var isAvail = true;

                $.each( disabledDatesArray, function( key, value ) { //foreach loop in disabled dates array
                    //console.log( key + ": " + value );
                    var tmpDate = new Date(value); // creates temporary date object for disabled date
                    if(d.getTime() == tmpDate.getTime()){ // checks if current date object equals disabled date object
                        isAvail = false; // if true sets isAvail to false, because date seems to be unavailable and the loop breaks
                        return false;
                    }
                    availDate = d; //just gets the last date of for loop
                });

                if(isAvail==true){ //if the last date was found to be available the loop stops
                    break;
                }
            }
            $('[data-date='+moment(availDate.getTime()).format("YYYY-MM-DD")+']').click();
            //console.log( $('[data-date='+moment(availDate.getTime()).format("YYYY-MM-DD")+']'));
        });
        /////////SHOW NEXT AVAILABLE DATE END //////////


        function getFreeTimeslots(option, date){
            console.log(option+ "   " + date);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            jQuery.ajax({
                url: "{{ url('/getFreeTimeslots') }}",
                data: {
                    "option": option,
                    "date": date
                },
                method: 'GET',
                success: function(result){
                    showAvailableHours(result);
                }
            });
        }

        function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };

        function showAvailableHours(result) {
            $.each(result, function(i, item) {
                console.log(item.slot);
                $("#hourButtonContainer").append('<label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1" onclick="showMakeAppointmentButton();"><input type="radio" name="timeslot" id="hourRadio" autocomplete="off" value="'+item.id+'">'+item.slot.split(" ")[1].slice(0, -3)+'</label>');
            });
        }

        $(document).ajaxStart(function () {
            $("#optionLoader").show();
        }).ajaxStop(function () {
            $("#optionLoader").hide();
        });


    </script>


@endsection