<?php

include("../API/config.php");

$data = json_decode(file_get_contents("php://input"), true);

$result = '';


if (!isset($data[0]['updateId'])) {

    for ($i = 0; $i < count($data); $i++) {
        $taskId = $data[$i]['id'];
        $date = $data[$i]['date'];
        $date = date('Y-m-d H:i:s', strtotime($date));
        $status = $data[$i]['checked'];

        $que = $con->query("select * from taskdetail where taskid = $taskId and date = '$date'");
        if ($que->num_rows > 0) {
            continue;
        } else {
            $que  = $con->query("insert into taskdetail (taskid,status, date) values ('$taskId','$status', '$date')");
            $result = $que;
        }
    }
    if ($result == '1') {
        echo json_encode(["Success" => true, "status" => 200, "Message" => "Data inserted Successfully"]);
    } else {
        echo json_encode(["Success" => false, "status" => 500, "Message" => "Data inserted Failed"]);
    }
} else {

    for ($i = 0; $i < count($data); $i++) {

        $taskName = $data[$i]['task'];
        $id = $data[$i]['id'];
        $que = $con->query("update taskname set task = '$taskName' where id = $id");
        $result = $que;
    }

    if ($result) {
        echo json_encode(["Success" => true, "status" => 200, "Message" => "Data updated Successfully"]);
    } else {
        echo json_encode(["Success" => false, "status" => 500, "Message" => "Data updated Failed"]);
    }
}
