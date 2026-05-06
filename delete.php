<?php
session_start();
include 'db_connect.php';
$id = $_GET['id'];
$uid = $_SESSION['user_id'];

// Securely delete only if the record belongs to the logged-in user
mysqli_query($conn, "DELETE FROM transport_log WHERE id=$id AND user_id=$uid");
header("Location: dashboard.php");
?>