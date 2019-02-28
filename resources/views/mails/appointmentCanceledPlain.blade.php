Your Appointment for:
@for ($i=0; $i<count($parents); $i++ )
        @if ($i!=count($parents)-1)
            {{$parents[$i]["title"]}} ->
        @else
            {{$parents[$i]["title"]}}
        @endif
@endfor, in: {{ \Carbon\Carbon::parse($timeslot->slot)->format('l d/m/Y') }} at {{ \Carbon\Carbon::parse($timeslot->slot)->format('H:i') }} has been canceled!