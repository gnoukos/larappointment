@extends('layouts.admin')
@section('include')
    <link href="nestable/dist/jquery.nestable.min.css" rel="stylesheet" type="text/css">
@endsection
@section('footer_include')
    <script src="{{ asset('nestable/jquery.nestable.js') }}"></script>
    <script>
        //$('.dd').nestable({ scroll: true });

        $('#saveHierarchy').click(function() {
            var serializedData = $('.dd').nestable('serialize');
            console.log(serializedData);
        });

        $(document).ready(function(){
            //var obj = '[{"id":1},{"id":2},{"id":3,"children":[{"id":4,"children":[{"id":6},{"id":7}]},{"id":5}]}]';
            $.getJSON("{{ url('/options') }}", function(result){
                console.log(result);
            });
            var obj = '[]';
            var output = '';
            function buildItem(item) {
                //console.log("in buildItem");
                var html = "<li class='dd-item' data-id='" + item.id + "'>";
                html += "<div class='dd-handle'>" + item.id + "</div>";

                if (item.children) {
                    //console.log("in children parser");
                    html += "<ol class='dd-list'>";
                    $.each(item.children, function (index, sub) {
                        html += buildItem(sub);
                    });
                    html += "</ol>";

                }

                html += "</li>";

                return html;
            }

            $.each(JSON.parse(obj), function (index, item) {
                //console.log("in obj parser");
                output += buildItem(item);

            });
            console.log("mana");
            $('#dd-outer-list').append(output);
            $('.dd').nestable({ scroll: true , maxDepth: 30 });
        });

        jQuery(document).ready(function(){
            jQuery('#addItemButton').click(function(e){
                if($('#optionTitle').val()!='' && $('#optionTitle').val()!=null) {
                    e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }

                    });
                    jQuery.ajax({
                        url: "{{ url('/options') }}",
                        method: 'post',
                        data: {
                            title: jQuery('#optionTitle').val()
                        },
                        success: function (result) {
                            console.log(result.success);
                            console.log(result.optionId);
                            console.log(result.optionTitle);

                            $('#invalidInput').hide();

                            //console.log(item);
                            if (result.hasOwnProperty('errors')) {
                                $('#invalidInput').show();
                                $('#invalidInput').html(result.errors.title[0]);
                            } else {
                                //$('.dd').nestable('add', {"id":item});
                                var newItem = '<li class="dd-item" data-id="' + result.optionId + '"><div class="dd-handle">' + result.optionTitle + '</div></li>';
                                $('#dd-outer-list').append(newItem);
                                $('.dd-empty').remove();
                                $('#optionTitle').val('');
                            }

                        }
                    });
                }
            });
        });

    </script>
@endsection
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
            <ol class="dd-list" id="dd-outer-list">

            </ol>
        </div>
        <button id="saveHierarchy" class="btn btn-primary mb-2 mt-5">Save Hierarchy</button>
    </div>
    <div class="ml-5 mt-5 mr-5 col-lg-3">
        <div class="alert alert-danger" role="alert" id="invalidInput" style="display: none;"></div>
        <input type="text" class="form-control" id="optionTitle" placeholder="Item Name">
        <button id="addItemButton" class="btn btn-primary mt-2">Add Item</button>
    </div>
</div>

@endsection