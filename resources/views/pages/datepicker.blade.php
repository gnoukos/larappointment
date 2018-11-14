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
            <div class="card" id="hoursCard" style="display: none;">
                <div class="card-body">
                    <h5 class="card-title">Choose Hour</h5>
                    <p class="card-text">First choose date to see available hours.</p>
                    <div class="wrapper text-center">
                        <div class="btn-group-md btn-group-toggle text-center" data-toggle="buttons">
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:30" id="hourRadio" autocomplete="off" value="13:30"> 13:30
                            </label>
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:40" id="hourRadio" autocomplete="off" value="13:40"> 13:40
                            </label>
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:50" id="hourRadio" autocomplete="off" value="13:50"> 13:50
                            </label>
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:30" id="hourRadio" autocomplete="off" value="13:31"> 13:30
                            </label>
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:40" id="hourRadio" autocomplete="off" value="13:41"> 13:40
                            </label>
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:50" id="hourRadio" autocomplete="off" value="13:51"> 13:50
                            </label>
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:30" id="hourRadio" autocomplete="off" value="13:32"> 13:30
                            </label>
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:40" id="hourRadio" autocomplete="off" value="13:42"> 13:40
                            </label>
                            <label class="btn btn-secondary ml-1 mt-1 mb-1 mr-1">
                                <input type="radio" name="13:50" id="hourRadio" autocomplete="off" value="13:52"> 13:50
                            </label>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <a href="#" class="btn btn-primary" id="makeAppointmentButton">Make the Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var disabledDatesArray = [
            '2018-11-15',
            '2018-10-29',
            '2018-10-14',
            '2018-10-30',
            '2018-11-03',
            '2018-11-01',
            '2018-10-31'
        ];

        var maxAvailDate = '2018-11-22';

        $("#hoursCard").fadeIn(1000); // fade in the hour selection box

        $("#pignoseCalendar").fadeIn(1000); // fade in the calendar

        $('input:radio[id=hourRadio]').change(function(){ //check when radio clicked and get value
            var val = $(this).val(); // retrieve the value
            console.log(val);
            $("#makeAppointmentButton").show();
        });

        $("#makeAppointmentButton").hide(); //hide button until hour selected

        $('.calendar').pignoseCalendar({ //initialize pignose calendar
            initialize: false,
            disabledDates: disabledDatesArray,
            minDate: moment().format("YYYY-MM-DD"), //disable dates before today
            maxDate: maxAvailDate, //disable dates after a certain date
            select: function(date, context) { //callback function to get selected date
                console.log(date[0]._i); //selected date
            }
        });


        var availDate = new Date(moment().format("YYYY-MM-DD"));//just a temporary object that will store the first available date found

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
        });


    </script>


@endsection