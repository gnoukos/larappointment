@extends('layouts.admin')

@section('content')

        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Overview</li>
            </ol>
            <!-- Icon Cards-->
            <div class="row">
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-primary o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="mr-5">{{ $timeslotsToday }} Appointments Today!</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-warning o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="far fa-calendar-check"></i>
                            </div>
                            <div class="mr-5">{{ $timeslotsMonth }} Appointments remaining This Month!</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="mr-5">{{ $usersNum }} Registered Users</div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-table"></i>
                    All the Appointments
                </div>
                <div class="card-body">
                    @if(session('success'))

                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>

                    @endif
                    <div id="datatable-button-wrapper"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th class="unsortable"></th>
                                <th class="unsortable"></th>
                            </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Phone</th>
                                    <th>Time</th>
                                    <th class="unsortable">Remaining</th>
                                    <th class="unsortable">Cancel</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($timeslots as $timeslot)
                                <tr>
                                    <td>{{ $timeslot->user->name }}</td>
                                    <td>
                                        @for ($i=0; $i<count($timeslot->parents); $i++ )
                                            @if ($i!=count($timeslot->parents)-1)
                                                {{$timeslot->parents[$i]}} ->
                                            @else
                                                {{$timeslot->parents[$i]}}
                                            @endif
                                        @endfor
                                    </td>
                                    <td>{{ $timeslot->daily_appointment->appointment->type }}</td>
                                    <td>{{ substr($timeslot->daily_appointment->date,0,10) }}</td>
                                    <td>{{ $timeslot->user->mobile_num }}</td>
                                    <td>{{ $timeslot->slot }}</td>
                                    <td>{{ $timeslot->daily_appointment->free_slots }}</td>
                                    <td class="unsortable">
                                        {!! Form::open(['url' => ['flushSlot',$timeslot->id], 'method' => 'POST']) !!}
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Do you want to cancel the appointment of {{$timeslot->user->name}}? ')">&times;</button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Phone</th>
                                    <th>Time</th>
                                    <th class="unsortable">Remaining</th>
                                    <th class="unsortable">Cancel</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- confirmation Modal -->
        <!--<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="ConfirmationModalLabel" aria-hidden="true">
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
        </div>-->
        <!-- end of confirmation Modal -->

        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
        <script>




                var table = $('#dataTable').DataTable( {
                    initComplete: function () {
                        this.api().columns(':not(.unsortable)').every( function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    // var val = $.fn.dataTable.util.escapeRegex(
                                    //     $(this).val()
                                    // );
                                    var val = $(this).val();

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        } );
                    },
                    lengthChange: false,
                    buttons: [ { extend: 'pdf', header: false}, { extend: 'copy', header: false}, { extend: 'print', header: false}, { extend: 'excel', header: false}, ],
                } );

                table.buttons().container()
                    .appendTo( '#datatable-button-wrapper' );

        </script>
@endsection