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
                        <button id="downloadTicket" class="btn btn-primary mt-5">Download Ticket</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $('#downloadTicket').click(function () {

            var doc = new jsPDF();
            var specialElementHandlers = {
                '#editor': function (element, renderer) {
                    return true;
                }
            };

            doc.fromHTML($('#ticketContent').html(), 15, 15, {
                'width': 170,
                'elementHandlers': specialElementHandlers
            });
            doc.save('ticket.pdf');
        });

        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
@endsection