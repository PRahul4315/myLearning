<?php

include("../API/config.php");

$que = $con ->query("select * from taskname");

$result = $que->fetch_all(MYSQLI_ASSOC);

if ($que->num_rows > 0) {
    echo json_encode($result);
} else {
    echo json_encode([]);
}

// print_r($que);

?>