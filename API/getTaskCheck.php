<?php

include("../API/config.php");

$que = $con->query("select task from taskname");
if ($que->num_rows == 0) {
    $que = $con->query("truncate table taskdetail");
}

$que = $con ->query("select * from taskdetail");

$result = $que->fetch_all(MYSQLI_ASSOC);
$finalRasult = [];
$finalObj = [];

if ($que->num_rows > 0) {

    foreach($result as $res){
        $finalObj['id'] = $res['taskid'];
        $finalObj['date'] = $res['date'];
        $finalObj['checked'] = true;
        array_push($finalRasult, $finalObj);
        $finalObj = [];
    }

    echo json_encode($finalRasult);
} else {
    echo json_encode([]);
}



?>