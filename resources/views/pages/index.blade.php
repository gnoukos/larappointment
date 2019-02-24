@extends('layouts.app')

@section('content')
    <div class="row">
    <div class="col-md-6 offset-md-3 text-center mt-5">
        <h1 class="display-4">Make an Appointment</h1>
        <div class="info-form mt-5 mb-5">
            <form action="{{ url('/datepicker') }}" method="get" id="optionsMenuForm" class="justify-content-center">
                <div id="optionsMenu" class="form-group">
                    <label for="level1" class="h5 mt-2">{{ $level1->title }}</label>
                    <select class="form-control" id="level_1_selection" onchange="getNextLevel(value,1,{{ $level1->id }})">
                        <option value="-1,-1">Select Option</option>
                        @foreach($options as $option)
                        <option value="{{$option->id}},{{$option->hasAppointment}}">{{$option->title}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="option" id="selectedOption" value="">
                </div>
                <div id ="optionLoader" class="spinner-border mb-3" role="status" style="display:none">
                    <span class="sr-only">Loading...</span>
                </div>
                <div><button type="submit" class="btn btn-dark" id="chooseDateButton" disabled>Choose Date</button></div>
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


        function getNextLevel(value,level,levelId) {
            var res = value.split(",");
            var id = res[0];
            var hasAppointment = res[1];
            console.log(id);
            console.log(hasAppointment);

            $("#invalidInput").hide();
            var selectChildren = $("#optionsMenu > select").length+1;

            for(var i=level+1; i<selectChildren; i++){
                $("#level"+i).remove();
                $("#level_"+i+"_selection").remove();
            }

            if(id!=-1){
                $.getJSON("{{ url('/options') }}/"+id+"/children", { isOption: true } ,function (result) {
                    $.getJSON("{{ url('/options') }}/"+levelId+"/children",{ isOption: false } ,function(json){
                        //console.log(result.length);
                        if(hasAppointment == 1){
                            $('#chooseDateButton').prop("disabled", false);
                        }else{
                            if (!(result == undefined || result == null || result.length === 0)){
                                $("#optionsMenu").append('<label id="level'+(level+1)+'" for="level'+(level+1)+'" class="h5 mt-2">'+json[0].title+'</label>');
                                $("#optionsMenu").append('<select class="form-control" id="level_'+(level+1)+'_selection" onchange="getNextLevel(value,'+(level+1)+','+ json[0].id +')"> </select>');
                                var $dropdown = $("#level_"+(level+1)+"_selection");
                                $dropdown.append($("<option />").val(-1).text("Select Option"));
                                $.each(result, function () {
                                    $dropdown.append($("<option />").val(this.id).text(this.title));
                                });
                                $('#chooseDateButton').prop("disabled", true);
                            }else{
                                $('#chooseDateButton').prop("disabled", false);
                            }
                            if(json.length !== 0 && result.length === 0){
                                $('#chooseDateButton').prop("disabled", true);
                                $("#optionsMenu").append('<label id="level'+(level+1)+'" for="level'+(level+1)+'" class="h5 mt-2">'+json[0].title+'</label>');
                                $("#optionsMenu").append('<select class="form-control" id="level_'+(level+1)+'_selection" onchange="getNextLevel(value,'+(level+1)+','+ json[0].id +')"><option>There are no appointments!</option></select>');
                            }
                        }

                    });
                });
            }else{
                $('#chooseDateButton').prop("disabled", true);
            }
            $('#selectedOption').val(id);
        }

        function resetSelected(){ // re-initialize options selection
            $('.form-control').prop('selectedIndex',0);
        }



            $(document).ajaxStart(function () {
                $("#optionLoader").show();
            }).ajaxStop(function () {
                $("#optionLoader").hide();
            });



    </script>
@endsection