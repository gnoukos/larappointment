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
                            <div class="mr-5">7 New Appointments Today!</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-warning o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="far fa-calendar-check"></i>
                            </div>
                            <div class="mr-5">28 Appointments This Month!</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6 mb-3">
                    <div class="card text-white bg-success o-hidden h-100">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="mr-5">143 Registered Users</div>
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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Phone</th>
                                <th class="unsortable"></th>
                            </tr>
                            </thead>
                            <thead id="titles">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Phone</th>
                                <th class="unsortable">Cancel</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Phone</th>
                                <th class="unsortable">Cancel</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>2011/04/25</td>
                                <td class="unsortable"><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#confirmationModal">&times;</a></td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>2011/07/25</td>
                                <td class="unsortable"><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#confirmationModal">&times;</a></td>
                            </tr>
                            <tr>
                                <td>Ashton Cox</td>
                                <td>Junior Technical Author</td>
                                <td>San Francisco</td>
                                <td>2009/01/12</td>
                                <td class="unsortable"><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#confirmationModal">&times;</a></td>
                            </tr>
                            <tr>
                                <td>Gavin Joyce</td>
                                <td>Developer</td>
                                <td>Edinburgh</td>
                                <td>2010/12/22</td>
                                <td class="unsortable"><a class="btn btn-danger" href="#" data-toggle="modal" data-target="#confirmationModal">&times;</a></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.container-fluid -->

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

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>

            $(document).ready(function() {
                $('#dataTable').DataTable( {
                    initComplete: function () {
                        this.api().columns(':not(.unsortable)').every( function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo( $(column.header()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        } );
                    }
                } );
            } );
        </script>
@endsection