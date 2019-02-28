<?php

use Illuminate\Support\Facades\Log;


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

function send_sms($mobile,$message)
{
    $fir=substr($mobile,0,2);
    $len=strlen($mobile);
    if($fir==69 && $len==10){
        $url = 'http://vlsi.gr/sms/webservice/process.php';
        $data = array(
            'authcode' => '67788',
            'mobilenr' => $mobile,
            'message' => $message
        );
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        //Log::info($result);
        if ($result === FALSE) { /* Handle error */
            echo'unexpected error!!!';
        }
        //var_dump($result);
    }
    else {
        echo('This number is not a mobile!');
    }

}

