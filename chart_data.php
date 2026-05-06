<?php
header('Content-Type: application/json');
include 'db_connect.php';

$sql = "SELECT vehicle_type, SUM(carbon_emissions) as total_emissions 
        FROM transport_log 
        GROUP BY vehicle_type";
$result = mysqli_query($conn, $sql);

$data = array();
while($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>