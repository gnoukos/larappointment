@extends('layouts.admin')
@section('footer_include')

@endsection
@section('content')

    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Levels</li>
        </ol>
        <div id="saveSuccess" class="alert alert-success alert-dismissible fade show" role="alert"
             style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h6 class="alert-heading">Hierarchy Saved!</h6>
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
        <form>
            <div class="form-group">
                <div class="row">
                    @foreach($levels as $depth => $options)
                        @if(count($options) > 0)
                        <div class="col-md-4 mb-5 mt-5">
                            <input type="text" class="form-control" id="level{{$depth}}" placeholder="Level {{$depth}}">
                            <ul>
                                @foreach($options as $option)
                                    <li>{{$option->title}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-5 col-lg-3">
                    <div class="alert alert-danger" role="alert" id="invalidInput" style="display: none;"></div>
                    <button type="submit" class="btn btn-primary mt-2">Save Level Names</button>
                </div>
            </div>
        </form>
    </div>
@endsection