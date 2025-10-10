<?php

include("../API/config.php");

$data = json_decode(file_get_contents("php://input"), true);

$result = '';

$que = $con->query("delete from taskname where id = ".$data['id']);

if($que){
    echo json_encode(["Success" => true, "status" => 200, "Message" => "Data Deleted Successfully"]);
}else{
    echo json_encode(["Success" => false, "status" => 500, "Message" => "Data Deleted Failed"]);
}


?>