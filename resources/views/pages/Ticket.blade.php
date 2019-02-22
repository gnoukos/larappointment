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
                        <a id="downloadTicket" download="ticket.jpeg" href="" class="btn btn-primary mt-5">Download Ticket</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        const {body} = document;

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = canvas.height = 1000;

        const tempImg = document.createElement('img');
        tempImg.addEventListener('load', onTempImageLoad);
        tempImg.src = 'data:image/svg+xml,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" width="1000" height="300"><foreignObject width="100%" height="100%"><div xmlns="http://www.w3.org/1999/xhtml"><style>span {color: #52DEE5;} h1{background-color: #383D3B; color: #EEE5E9;}</style><h1>Ticket: <span>{{ $timeslot->ticket_num }}</span><br />@for ($i=0; $i<count($parents); $i++) @if($i!=count($parents)-1) {{$parents[$i]}}=> @else {{$parents[$i]}} @endif @endfor <br /><span>{{ \Carbon\Carbon::parse($timeslot->slot)->format('l d/m/Y') }}</span> <br /><span> {{\Carbon\Carbon::parse($startingHour)->format('H:i')}}</span></h1></div></foreignObject></svg>');
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
        });

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
@endsection