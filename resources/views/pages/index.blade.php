@extends('layouts.app')

@section('content')
    <div class="row">
    <div class="col-md-6 offset-md-3 text-center mt-5">
        <h1 class="display-4">Make an Appointment</h1>
        <div class="info-form mt-5 mb-5">
            <form action="date.html" class="justify-content-center">
                <div id="optionsMenu" class="form-group">
                    <label for="level1" class="h5 mt-2">Level 1</label>
                    <select class="form-control" id="level_1_selection" onchange="getNextLevel(value,1)">
                        <option value="-1">Select Option</option>
                        @foreach($options as $option)
                        <option value="{{$option->id}}">{{$option->title}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-dark ">Choose Date</button>
            </form>
        </div>
    </div>
    </div>

    <script>

        function getNextLevel(id,level) {
            var labelChildren = $("#optionsMenu > label").length+1;
            var selectChildren = $("#optionsMenu > select").length+1;
            //console.log(labelChildren+" "+selectChildren);

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
        }


    </script>
@endsection