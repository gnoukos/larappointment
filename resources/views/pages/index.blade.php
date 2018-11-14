@extends('layouts.app')

@section('content')
    <div class="row">
    <div class="col-md-6 offset-md-3 text-center mt-5">
        <h1 class="display-4">Make an Appointment</h1>
        <div class="info-form mt-5 mb-5">
            <form action="date.html" class="justify-content-center">
                <div class="form-group">
                    <label for="level1" class="h5">Level 1</label>
                    <select class="form-control" id="level_1_selection">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark ">Choose Date</button>
            </form>
        </div>
    </div>
    </div>
@endsection