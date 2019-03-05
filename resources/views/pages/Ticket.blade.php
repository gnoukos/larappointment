@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <div class="card mt-4" id="userDetailsCard">
                <div class="card-body" id="ticketContent">
                    <h1 class="card-title mt-5 mb-5"><i class="fas fa-receipt fa-5x"></i></h1>
                    <div class="wrapper text-center mt-5 mb-5">
                        <h3>Your Ticket number for <span class="text-success">
                                @for ($i=0; $i<count($parents); $i++ )
                                    @if ($i!=count($parents)-1)
                                        {{$parents[$i]}} ->
                                    @else
                                        {{$parents[$i]}}
                                    @endif
                                @endfor</span>, at: <span class="text-success">{{ \Carbon\Carbon::parse($timeslot->slot)->format('l d/m/Y') }}</span> and time: <span class="text-success"> {{\Carbon\Carbon::parse($startingHour)->format('H:i')}}</span> is</h3>
                        <br><button type="button" class="btn btn-dark btn-lg">{{ $timeslot->ticket_num }}</button><br>

                        @if(session('MailSuccess'))

                             <div class="alert alert-success text-center mt-3 col-md-6 offset-md-3">
                                 {{session('MailSuccess')}}
                             </div>
                        @endif

                        @if(session('smsSuccess'))

                            <div class="alert alert-success text-center mt-3 col-md-6 offset-md-3">
                                {{session('smsSuccess')}}
                            </div>
                        @endif

                        <a id="downloadTicket" download="ticket.jpeg" href="" class="btn btn-primary mt-5"><i class="fas fa-download"></i> Download Ticket</a>
                        <button type="button" class="btn btn-secondary mt-5" id="mailPopOverButton" data-placement="top" data-toggle="popover" title="Type your Mail" data-html='true' data-content='
                        <form method="post" action="{{action('AppointmentController@mailTheTicket')}}">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                           <div class="input-group mb-3">
  <input type="text" name="emailAddress" class="form-control" placeholder="Email Address" aria-label="Email Address" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="preventResubmit()" type="submit">Send</button>
                        </div>
                    </div>
                        </form>'><i class="fas fa-envelope"></i> Send Email</button>


                        <button type="button" class="btn btn-secondary mt-5" id="smsPopOverButton" data-placement="top" data-toggle="popover" title="Type your mobile number" data-html='true' data-content='
                        <form id="smsSubmitForm" method="post" action="{{action('AppointmentController@smsTheTicket')}}">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            <div class="input-group mb-3">
  <input type="text" name="mobileNumber" class="form-control" placeholder="Mobile Num" aria-label="Mobile Num" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="smsSubmit" onclick="preventResubmit()" class="btn btn-outline-secondary" type="submit">Send</button>
                        </div>
                    </div>
                        </form>' ><i class="fas fa-mobile"></i> Send SMS</button>

                        @if ($errors->has('emailAddress'))
                            <div class="alert alert-danger text-center mt-3 col-md-6 offset-md-3">
                        <strong>{{ $errors->first('emailAddress') }}</strong>
                        </div>
                        @endif

                        @if ($errors->has('mobileNumber'))
                            <div class="alert alert-danger text-center mt-3 col-md-6 offset-md-3">
                        <strong>{{ $errors->first('mobileNumber') }}</strong>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        const {body} = document;

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = canvas.height = 400;

        const tempImg = document.createElement('img');
        tempImg.addEventListener('load', onTempImageLoad);
        tempImg.src = 'data:image/svg+xml,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="400" height="300"><foreignObject width="100%" height="100%"><div xmlns="http://www.w3.org/1999/xhtml"><style>span {color: #52DEE5;} h1{background-color: #383D3B; color: #EEE5E9;}</style><h1>Ticket: <span>{{ $timeslot->ticket_num }}</span><br />@for ($i=0; $i<count($parents); $i++) @if($i!=count($parents)-1) {{$parents[$i]}}=> @else {{$parents[$i]}} @endif @endfor <br /><span>{{ \Carbon\Carbon::parse($timeslot->slot)->format('l d/m/Y') }}</span> <br /><span> {{\Carbon\Carbon::parse($startingHour)->format('H:i')}}</span></h1></div></foreignObject></svg>');
        const targetImg = document.createElement('img');
        body.appendChild(targetImg);

        function onTempImageLoad(e){
            ctx.drawImage(e.target, 0, 0);
            targetImg.src = canvas.toDataURL('image/jpg');
        }


        $( document ).ready(function() {
            var src = $('img').attr('src');
            $('img').hide();
            $('#downloadTicket').attr("href", src);

            $('.popover-dismiss').popover({
                trigger: 'focus'
            })

            $("[data-toggle=popover]").popover();

        });


        function preventResubmit() {
            $('#smsPopOverButton').popover('hide');
            $('#mailPopOverButton').popover('hide');
        }


    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
@endsection