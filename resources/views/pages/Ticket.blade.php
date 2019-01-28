@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center mt-5">
            <div class="card mt-4" id="userDetailsCard">
                <div class="card-body">
                    <h1 class="card-title mt-5 mb-5"><i class="fas fa-receipt fa-5x"></i></h1>
                    <div class="wrapper text-center mt-5 mb-5">
                        <h3>Your Ticket number for <span class="text-success">{{ $timeslot->daily_appointment->appointment->option->title }}</span>, at: <span class="text-success">{{ \Carbon\Carbon::parse($timeslot->slot)->format('l d/m/Y') }} </span> is</h3>
                        <br><button type="button" class="btn btn-dark btn-lg">{{ $timeslot->ticket_num }}</button><br>
                        <button id="downloadTicket" class="btn btn-primary mt-5">Download Ticket</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("#downloadTicket").click(function () {
            var doc = new jsPDF();
            doc.setFontSize(30);
            var text = "Your Ticket number is: {{ $timeslot->ticket_num }}";
            doc.text(text, 10, 10);
            doc.save('ticket.pdf');
        });

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
@endsection