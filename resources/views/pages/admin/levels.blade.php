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
        <div id="saveSuccess" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
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
                    <div class="col-md-4 mb-5 mt-5">
                        <input type="text" class="form-control" id="level1" placeholder="Level 1">
                        <ul>
                            <li>Item 1</li>
                            <li>Item 6</li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-5 mt-5">
                        <input type="text" class="form-control" id="level1" placeholder="Level 1">
                        <ul>
                            <li>Item 1</li>
                            <li>Item 6</li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-5 mt-5">
                        <input type="text" class="form-control" id="level1" placeholder="Level 1">
                        <ul>
                            <li>Item 1</li>
                            <li>Item 6</li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-5 mt-5">
                        <input type="text" class="form-control" id="level1" placeholder="Level 1">
                        <ul>
                            <li>Item 1</li>
                            <li>Item 6</li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-5 mt-5">
                        <input type="text" class="form-control" id="level1" placeholder="Level 1">
                        <ul>
                            <li>Item 1</li>
                            <li>Item 6</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-5 col-lg-3">
                    <div class="alert alert-danger" role="alert" id="invalidInput" style="display: none;"></div>
                    <button type="submit" class="btn btn-primary mt-2">Save Level Names</button>
                </div>
            </div>
        </form>
    </div>
@endsection