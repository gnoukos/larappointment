@extends('layouts.admin')
@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Tickets Id</li>
        </ol>

    </div>
    <!-- /.container-fluid -->
    <div class="container ml-2">
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">API url</th>
                    <th scope="col">Remaining</th>
                    <th scope="col">Id</th>
                </tr>
                </thead>
                <tbody>
                @foreach($dailyAppoinments as $dailyAppoinment)
                    <tr>
                        <th scope="row">{{ $dailyAppoinment->appointment->option->title }}</th>
                        <td>{{ \Carbon\Carbon::parse($dailyAppoinment->date)->format("d/m/Y")}}</td>
                        <td><input type="text" value="{{url('/')}}api/getTicket?da_id={{ $dailyAppoinment->id }}"></td>
                        <td>{{ $dailyAppoinment->free_slots }}</td>
                        <td>{{ $dailyAppoinment->id }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            @if($dailyAppoinments->isEmpty())
                <p>No tickets to show.</p>
            @endif

        </div>

    </div>

@endsection