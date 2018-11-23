@extends('layouts.admin')
@section('include')
    <link href="nestable/dist/jquery.nestable.min.css" rel="stylesheet" type="text/css">
@endsection
@section('footer_include')
    <script src="{{ asset('nestable/jquery.nestable.js') }}"></script>
    <script>
        $('.dd').nestable({ /* config options */ });

        $('#addItemButton').click(function(){
            var item = $('#addItem').val();
            console.log(item);
            if(item == '' || item == null){
                return false;
            }else{
                $('.dd').nestable('add', {"id":item});
            }
        });

    </script>
@section
@section('content')

<div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Hierarchy</li>
    </ol>
</div>
<!-- /.container-fluid -->
<div class="row">
    <div class="tree-container ml-5 mt-5 mr-5 col-lg-7">
        <div class="dd">
            <ol class="dd-list">
                <li class="dd-item" data-id="1">
                    <div class="dd-handle">Item 1</div>
                </li>
                <li class="dd-item" data-id="2">
                    <div class="dd-handle">Item 2</div>
                </li>
                <li class="dd-item" data-id="3">
                    <div class="dd-handle">Item 3</div>
                    <ol class="dd-list">
                        <li class="dd-item" data-id="4">
                            <div class="dd-handle">Item 4</div>
                        </li>
                        <li class="dd-item" data-id="5">
                            <div class="dd-handle">Item 5</div>
                        </li>
                    </ol>
                </li>
            </ol>
        </div>
        <button id="addItemButton" class="btn btn-primary mb-2 mt-5">Save Form</button>
    </div>
    <div class="ml-5 mt-5 mr-5 col-lg-3">
        <input type="text" class="form-control" id="addItem" placeholder="Item Name">
        <button id="addItemButton" class="btn btn-primary mt-2">Add Item</button>
    </div>
</div>

@endsection