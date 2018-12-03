@extends('layouts.admin')
@section('include')
    <link href="nestable/dist/jquery.nestable.min.css" rel="stylesheet" type="text/css">
@endsection
@section('footer_include')
    <script src="{{ asset('nestable/jquery.nestable.js') }}"></script>
    <script>
        //$('.dd').nestable({ scroll: true });
        /*

                $('#saveHierarchy').click(function () {
                    var serializedData = JSON.stringify($('.dd').nestable('toArray'));
                    console.log(serializedData);
                });
        */

        function deleteItem(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            jQuery.ajax({
                url: "{{ url('/options') }}/"+id,
                method: 'DELETE',
                success: function(result){
                    $('.dd').nestable('remove', id);
                }
            });
        }

        $(document).ready(function () {

            $.getJSON("{{ url('/options') }}", function (result) {
                //result = "[{\"id\":1,\"title\":\"er\",\"parent\":null,\"children\":[{\"id\":3,\"title\":\"test sara item\",\"parent\":1100,\"children\":[{\"id\":7,\"title\":\"test\",\"parent\":3,\"children\":[]}]},{\"id\":6,\"title\":\"asas\",\"parent\":1,\"children\":[]}]},{\"id\":2,\"title\":\"hfe\",\"parent\":null,\"children\":[]},{\"id\":4,\"title\":\"ert\",\"parent\":null,\"children\":[]},{\"id\":5,\"title\":\"wer\",\"parent\":null,\"children\":[{\"id\":8,\"title\":\"yu\",\"parent\":5,\"children\":[]}]},{\"id\":9,\"title\":\"hjk\",\"parent\":null,\"children\":[]},{\"id\":10,\"title\":\"df\",\"parent\":null,\"children\":[]},{\"id\":11,\"title\":\"ams\",\"parent\":null,\"children\":[]},{\"id\":12,\"title\":\"mana\",\"parent\":null,\"children\":[]},{\"id\":13,\"title\":\"manitsa\",\"parent\":null,\"children\":[]},{\"id\":14,\"title\":\"manoylitsa\",\"parent\":null,\"children\":[]},{\"id\":15,\"title\":\"mana\",\"parent\":null,\"children\":[]},{\"id\":16,\"title\":\"fg\",\"parent\":null,\"children\":[]},{\"id\":17,\"title\":\"vb\",\"parent\":null,\"children\":[]},{\"id\":18,\"title\":\"dfg\",\"parent\":null,\"children\":[]},{\"id\":19,\"title\":\"mansas\",\"parent\":null,\"children\":[]}]";
                //result = JSON.parse(result);
                var output = '';

                $.each(result, function (index, item) {
                    output += buildItem(item);
                });

                $('#dd-outer-list').append(output);
                $('.dd').nestable({scroll: true, maxDepth: 30,
                    beforeDragStop: function(l,e, p){
                        console.log($( "li.dd-item" ).parent());
                        $( "li.dd-item" ).parent().css( "background-color", "red" );
                    }
                });
            });

            function buildItem(item) {
                var html = "<li class='dd-item' data-id='" + item.id + "'>";
                html += "<div class='dd-handle'>" + item.title;
                if(item.children.length == 0){
                    html+= "<button class='float-right' onmousedown='deleteItem("+item.id+")'>X</button>";
                }
                html+="</div>";
                if (item.children.length > 0) {
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
        });

        jQuery(document).ready(function () {
            jQuery('#addItemButton').click(function (e) {
                if ($('#optionTitle').val() != '' && $('#optionTitle').val() != null) {
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

        $("#saveHierarchy").click(function () {
            var output = JSON.stringify($('.dd').nestable('asNestedSet'));
            console.log(output);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
            jQuery.ajax({
                url: "{{ url('/options/update') }}",
                method: 'post',
                data: {
                    output: output
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
            <button onclick="deleteItem(20)">mana</button>
        </div>
        <div class="ml-5 mt-5 mr-5 col-lg-3">
            <div class="alert alert-danger" role="alert" id="invalidInput" style="display: none;"></div>
            <input type="text" class="form-control" id="optionTitle" placeholder="Item Name">
            <button id="addItemButton" class="btn btn-primary mt-2">Add Item</button>
        </div>
    </div>

@endsection