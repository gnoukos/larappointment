@extends('layouts.app')

@section('content')
    <div class="row">
    <div class="col-md-6 offset-md-3 text-center mt-5">
        <h1 class="display-4">Make an Appointment</h1>
        <div class="info-form mt-5 mb-5">
            <form action="date.html" class="justify-content-center">
                <div id="mana" class="form-group">
                    <label for="level1" class="h5">Level 1</label>
                    <select class="form-control" id="level_1_selection" onchange="getNextLevel(value)">
                        @foreach($options as $option)
                        <option value="{{$option->id}}">{{$option->title}}</option>
                        @endforeach
                    </select>

                </div>
                <button type="submit" class="btn btn-dark ">Choose Date</button>
            </form>
        </div>
    </div>
    </div>

    <script>

        function getNextLevel(id) {
            $( "#mana" ).append( '<label for="leve22" class="h5">Level 2</label>' );
        }


    </script>
@endsection