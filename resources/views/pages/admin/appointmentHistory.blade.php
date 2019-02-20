@extends('layouts.admin')

@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Appointent History</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                History
            </div>
            <div class="card-body">

                <div id="history-datatable-button-wrapper"></div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="historyDataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
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
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->


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




        var table = $('#historyDataTable').DataTable( {
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<div class="mt-4"></div>')
                        .appendTo( $(column.header()).empty() )
                        .on( 'change', function () {
                            var val = $(this).val();

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
                } );
            },
            lengthChange: false,
            buttons: [ { extend: 'pdf', header: false}, { extend: 'copy', header: false}, { extend: 'print', header: false}, { extend: 'excel', header: false}, ],
        } );

        table.buttons().container()
            .appendTo( '#history-datatable-button-wrapper' );

    </script>

@endsection