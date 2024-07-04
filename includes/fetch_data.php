<?php
include_once("includes/config.php");// SQL query to fetch data
$sql = "SELECT added_on, maintenance_peyment FROM maintenance_payments";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return data as JSON
echo json_encode($data);
?>
