@extends('layouts.app')

@section('content')
    <div class="row">
    <div class="col-md-6 offset-md-3 text-center mt-5">
        <h1 class="display-4">Make an Appointment</h1>
        <div class="info-form mt-5 mb-5">
            <form action="/datepicker" method="get" id="optionsMenuForm" class="justify-content-center">
                <div id="optionsMenu" class="form-group">
                    <label for="level1" class="h5 mt-2">Level 1</label>
                    <select class="form-control" id="level_1_selection" onchange="getNextLevel(value,1)">
                        <option value="-1">Select Option</option>
                        @foreach($options as $option)
                        <option value="{{$option->id}}">{{$option->title}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="option" id="selectedOption" value="">
                </div>

                <button type="submit" class="btn btn-dark">Choose Date</button>
                <div id="invalidInput" class="alert alert-danger alert-dismissible fade show mt-5" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h6 class="alert-heading">Please select an option for every field!</h6>
                </div>
            </form>
        </div>
    </div>
    </div>

    <script>

        $("#optionsMenuForm").submit(function(e){
            var selectChildren = $("#optionsMenu > select").length+1;
            var ok = true;
            for(var i=1; i<selectChildren; i++){
                if($("#level_"+i+"_selection").val()==-1){
                    ok = false;
                    break;
                }
            }
            if(ok==false) {
                e.preventDefault();
                $("#invalidInput").show();
            }
        });

        function getNextLevel(id,level) {
            $("#invalidInput").hide();
            var selectChildren = $("#optionsMenu > select").length+1;

            for(var i=level+1; i<selectChildren; i++){
                //console.log("level "+i);
                $("#level"+i).remove();
                $("#level_"+i+"_selection").remove();
            }

            if(id!=-1){
                $.getJSON("{{ url('/options') }}/"+id+"/children", function (result) {
                    if (!(result == undefined || result == null || result.length == 0)){
                        $("#optionsMenu").append('<label id="level'+(level+1)+'" for="level'+(level+1)+'" class="h5 mt-2">Level'+(level+1)+'</label>');
                        $("#optionsMenu").append('<select class="form-control" id="level_'+(level+1)+'_selection" onchange="getNextLevel(value,'+(level+1)+')"> </select>');
                        var $dropdown = $("#level_"+(level+1)+"_selection");
                        $dropdown.append($("<option />").val(-1).text("Select Option"));
                        $.each(result, function () {
                            $dropdown.append($("<option />").val(this.id).text(this.title));
                        });
                    }
                });
            }
            $('#selectedOption').val(id);
        }


    </script>
@endsection