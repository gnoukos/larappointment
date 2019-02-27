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
            <form method="post" action="{{action('AppointmentController@getTicket')}}">
                <div class="card" id="hoursCard" style="display: none;">
                    <div class="card-body">
                        <h5 class="card-title">Get your Ticket</h5>
                        <p class="card-text" id="chooseDatePrompt">First choose date to get Ticket.</p>
                        <div id="selectedDate">
                            <div class="alert alert-info text-center" role="alert">
                                You Selected: <strong id="date"></strong>
                            </div>
                        </div>
                        <div id="noAvailableTicket">
                            <div class="alert alert-danger text-center" role="alert">
                                <strong>There is not available ticket.</strong>
                            </div>
                        </div>
                        <input type="hidden" name="dailyAppointmentId" id="dailyAppointmentId" value="">
                        <div class="wrapper text-center">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" value="Submit" class="btn btn-primary" id="makeAppointmentButton">Get Ticket</button>
                            </div>
                        </div>
                    </div>
                </div>
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

        $("#makeAppointmentButton").hide(); //hide button until hour selected

        $("#noAvailableTicket").hide();

        $("#selectedDate").hide();

        /*$('.calendar').pignoseCalendar({ //initialize pignose calendar
            initialize: false,
            disabledDates: disabledDatesArray,
            minDate: moment().format("YYYY-MM-DD"), //disable dates before today
            maxDate: maxAvailDate, //disable dates after a certain date
            select: function(date, context) { //callback function to get selected date
                try {
                    $('#selectedDate #date').empty();
                    console.log(date[0]._i); //selected date
                    $("#makeAppointmentButton").show();
                    $("#chooseDatePrompt").hide();
                    var option = getUrlParameter('option');
                    getDailyAppointment(option, date[0]._i);
                }catch (e) {
                    $("#makeAppointmentButton").hide();
                    $("#chooseDatePrompt").show();
                    $('#selectedDate #date').empty();
                    $("#selectedDate").hide();
                }
            }
        });*/


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
                            $('#selectedDate #date').empty();
                            console.log(date[0]._i); //selected date
                            $("#makeAppointmentButton").show();
                            $("#chooseDatePrompt").hide();
                            var option = getUrlParameter('option');
                            getDailyAppointment(option, date[0]._i);
                        }catch (e) {
                            $("#makeAppointmentButton").hide();
                            $("#chooseDatePrompt").show();
                            $('#selectedDate #date').empty();
                            $("#selectedDate").hide();
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
        /////////SHOW NEXT AVAILABLE DATE END //////////!!!


        function getDailyAppointment(option, date){
            console.log(option+ "   " + date);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            jQuery.ajax({
                url: "{{ url('/getDailyAppointment') }}",
                data: {
                    "option": option,
                    "date": date
                },
                method: 'GET',
                success: function(result){
                    if(result){
                        var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
                        var monthNames = [
                            "January", "February", "March",
                            "April", "May", "June", "July",
                            "August", "September", "October",
                            "November", "December"
                        ];
                        $("#noAvailableTicket").hide();
                        var d = new Date(date);
                        $("#selectedDate").show();
                        var dateMsg = weekday[d.getDay()] + ' ' + d.getDate() + ' ' + monthNames[d.getMonth()] + ' ' + d.getFullYear();
                        $('#selectedDate #date').append(dateMsg);
                        $('#dailyAppointmentId').val(result.id);
                        console.log(result);
                    }else{
                        $("#noAvailableTicket").show();
                    }
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

        /*var availDate = new Date(moment().format("YYYY-MM-DD"));//just a temporary object that will store the first available date found

        var nextAvailableDateButtonClicks = 0; //counter to check how many times the next available date button is clicked

        $("#nextAvailableDateButton").click(function(){	//function to find first available date

            nextAvailableDateButtonClicks++;

            if(nextAvailableDateButtonClicks>1){ //if its not the first time it means that the loop should continue from the exact next date of last available
                availDate.setDate(availDate.getDate() + 1);
            }

            var maxDateObj = new Date(maxAvailDate); //creates max available date object to use in for loop
            var d = new Date();

            for (d = availDate; d.getTime() <= maxDateObj.getTime(); d.setDate(d.getDate() + 1)) { // for loop from today until max available date

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
            $('.calendar').pignoseCalendar('set', moment(availDate.getTime()).format("YYYY-MM-DD")); //sets the available date to the pignose calendar
        });*/

    </script>


@endsection