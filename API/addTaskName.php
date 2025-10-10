<?php

include("../API/config.php");

$data = json_decode(file_get_contents("php://input"), true);

$result = '';

if (!isset($data[0]['id'])) {

    for ($i = 0; $i < count($data); $i++) {

        $taskName = $data[$i]['task'];
        $createdOn = date('Y-m-d');

        $que  = $con->query("insert into taskname (task,status, createdon) values ('$taskName', 1 ,'$createdOn')");
        $result = $que;
    }
    if ($result) {
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


