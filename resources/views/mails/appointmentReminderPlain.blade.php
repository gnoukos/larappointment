 This is an appointment reminder for:
                                @for ($i=0; $i<count($parents); $i++ )
                                    @if ($i!=count($parents)-1)
                                        {{$parents[$i]}} ->
                                    @else
                                        {{$parents[$i]}}
                                    @endif
                                @endfor
                           , at: {{ \Carbon\Carbon::parse($timeslot->slot)->format('l d/m/Y') }} - {{ \Carbon\Carbon::parse($timeslot->slot)->format('H:i') }}
