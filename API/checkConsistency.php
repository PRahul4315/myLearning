<?php

include("../API/config.php");

// Step 1: Fetch all tasks
$taskQuery = "SELECT id, task, createdon FROM taskname WHERE status = 1";
$taskResult = $con->query($taskQuery);

$consistencyData = [];

while ($task = $taskResult->fetch_assoc()) {
    $taskId = $task['id'];
    $taskName = $task['task'];
    $createdOn = date('Y-m-d', strtotime($task['createdon']));

    // Step 2: Get all dates this task was completed (checked)
    $detailQuery = "
        SELECT DATE(date) as done_date
        FROM taskdetail
        WHERE taskid = '$taskId' AND status = 1
        ORDER BY date ASC
    ";
    $detailResult = $con->query($detailQuery);

    $doneDates = [];
    while ($row = $detailResult->fetch_assoc()) {
        $doneDates[] = $row['done_date'];
    }

    // Step 3: Calculate total possible days (from created date → today)
    $startDate = new DateTime($createdOn);
    $endDate = new DateTime(date('Y-m-d')); // today
    $interval = $startDate->diff($endDate)->days + 1; // inclusive

    // Step 4: Calculate consistency
    $completedDays = count($doneDates);
    $consistency = ($completedDays / $interval) * 100;

    $consistencyData[] = [
        "task" => $taskName,
        "created_on" => $createdOn,
        "completed_days" => $completedDays,
        "total_days" => $interval,
        "consistency" => round($consistency, 2)
    ];
}

// Step 5: Output JSON
echo json_encode($consistencyData, JSON_PRETTY_PRINT);

?>
