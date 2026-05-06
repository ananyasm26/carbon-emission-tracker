<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    $row = mysqli_fetch_assoc($result);

    if ($row && $pass == $row['password']) { // In a real app, use password_verify
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid Login! <a href='index.php'>Try again</a>";
    }
}
?>