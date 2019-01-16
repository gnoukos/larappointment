@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg mt-5">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="user-cp-tab" data-toggle="tab" href="#appointments" role="tab" aria-controls="appointments" aria-selected="true">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="user-cp-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">User Settings</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="appointments" role="tabpanel" aria-labelledby="appointments-tab">
                            <div class="inner-tab-content mt-5">
                                <table class="table table-hover">
                                    <!-- appointments table -->
                                    <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Cancel</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($timeslots as $timeslot)
                                        <tr>
                                            <th scope="row">{{$timeslot->daily_appointment->date}}</th>
                                            <td>{{$timeslot->daily_appointment->appointment->option->title}}</td>
                                            <td>{{$timeslot->slot}}</td>
                                            <td><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#confirmationModal">&times;</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- appointments table ENDS-->
                                <!-- confirmation Modal -->
                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ConfirmationModalLabel">Do you want to cancel the appointment ?</h5>
                                            </div>
                                            <div class="modal-body text-center">
                                                <form>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col">
                                                                <button type="button" class="btn btn-dark" data-dismiss="modal" aria-label="Close">No</button>
                                                            </div>
                                                            <div class="col">
                                                                <button type="submit" class="btn btn-danger">Yes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of confirmation Modal -->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="inner-tab-content">
                                <script>
                                    $(document).ready(function(){
                                        if(window.location.hash != "") {
                                            $('a[href="' + window.location.hash + '"]').click()
                                        }
                                    });
                                </script>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                {!! Form::open(['action' => ['UpdateUserController@update'], 'method' => 'POST']) !!}
                                    {{Form::label('name', 'Name')}}
                                    {{Form::text('name', $user->name, ['class' => 'form-control', 'readonly'])}}
                                    {{Form::label('email', 'Email-Address')}}
                                    {{Form::text('email', $user->email, ['class' => 'form-control'])}}
                                    {{Form::label('mobile', 'Phone')}}
                                    {{Form::text('mobile', $user->mobile_num, ['class' => 'form-control'])}}
                                    {{Form::label('password', 'Password')}}
                                    {{Form::password('password', ['class' => 'form-control'])}}
                                    {{Form::label('password', 'Password Repeat')}}
                                    {{Form::password('password_confirmation', ['class' => 'form-control'])}}
                                {{Form::hidden('_method', 'PATCH')}}
                                {{Form::submit('Submit', ['class' => 'btn btn-primary mt-2'])}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
