<?php


function getTimeSlotOptionParentsArray($slot){
    $parents = array();
    $options = \App\Option::setEagerLoads([])->get();
    $options = collect($options)->toArray();
    array_unshift($parents,$slot->daily_appointment->appointment->option);
    while($parents[0]["parent"]) {
        $parent = array_filter($options, function ($item) use ($parents) {
            return $item["id"] == $parents[0]["parent"];
        });
        array_unshift($parents, array_values($parent)[0]);
    }
    return $parents;
}
