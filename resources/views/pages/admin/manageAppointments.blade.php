@extends('layouts.admin')
@section('footer_include')
    <script>
       //toggle for bootsrap 4
        $(function() {

        })

       $(function() {
           $('.toggle-event').change(function() {
               //console.log('Toggle: ' + $(this).prop('checked') + $(this).attr('data-id'));
               var id = $(this).attr('data-id');
               $.ajaxSetup({
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }

               });
               jQuery.ajax({
                   url: "{{ url('/changeAppointmentState') }}",
                   method: 'post',
                   data: {
                       appointmentId: id
                   },
                   success: function () {
                        console.log("success");
                   },
                   fail: function (xhr, textStatus, errorThrown) {
                       $("[data-id="+id+"]").bootstrapToggle('toggle');
                   }
               });
           })
       })

    </script>
@endsection
@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Manage Appointments</li>
        </ol>
        <div id="saveSuccess" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h6 class="alert-heading">Appointment Saved!</h6>
        </div>
        <div id="saveError" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h6 class="alert-heading">An error occurred! Refresh the page and try again.</h6>
        </div>
    </div>
    <!-- /.container-fluid -->
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Type</th>
                    <th scope="col">created</th>
                    <th scope="col">State</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <th scope="row">{{ $appointment->option->title }}</th>
                        <td>{{ $appointment->type }}</td>
                        <td>{{ $appointment->created_at }}</td>
                        <td><input type="checkbox" data-toggle="toggle" id="toggle-event" class="toggle-event" data-id="{{$appointment->id}}" data-onstyle="success" data-offstyle="danger" data-on="Ενεργό" data-off="Ανενεργό" @if($appointment->enabled) checked @endif ></td>

                        <td><a class="btn btn-secondary  @if($appointment->OccupiedSlots > 0) disabled @endif" href="appointment/{{$appointment->id}}/edit">Edit</a></td>
                        <td>
                            {!! Form::open(['action' => ['AppointmentController@destroy',$appointment->id], 'method' => 'DELETE']) !!}
                            <button type="submit" class="btn btn-danger"  onclick="return confirm('Do you want to delete this appointment category ? ')">Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($appointments->isEmpty())
                <p>No appointment categories.</p>
            @endif
            @if(session('success'))

                <div class="alert alert-success">
                    {{session('success')}}
                </div>

            @endif
        </div>
        <!-- confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ConfirmationModalLabel">Do you want to delete this appointment ?</h5>
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
@endsection