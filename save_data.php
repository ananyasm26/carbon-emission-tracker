<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle = $_POST['vehicle_type'];
    $dist = $_POST['distance'];
    $uid = $_SESSION['user_id']; // Get the logged-in user's ID
    
    // Set different rates for different vehicles
    $rates = ["Car" => 0.2, "Bus" => 0.08, "Bike" => 0.02, "Train" => 0.01];
    $emissions = $dist * ($rates[$vehicle] ?? 0.1);

    $sql = "INSERT INTO transport_log (vehicle_type, distance_km, carbon_emissions, user_id) 
            VALUES ('$vehicle', '$dist', '$emissions', '$uid')";

    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>