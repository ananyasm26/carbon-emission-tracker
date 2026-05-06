<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
include 'db_connect.php';

$id = $_GET['id'];
$uid = $_SESSION['user_id'];

// Fetch the specific record to edit
$res = mysqli_query($conn, "SELECT * FROM transport_log WHERE id=$id AND user_id=$uid");
$row = mysqli_fetch_assoc($res);

if (!$row) { die("Record not found or access denied."); }

// Process the update when the user clicks 'Update'
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle = $_POST['vehicle_type'];
    $dist = $_POST['distance'];
    
    // Recalculate emissions based on vehicle type
    $rates = ["Car" => 0.2, "Bus" => 0.08, "Bike" => 0.02, "Train" => 0.01];
    $emissions = $dist * ($rates[$vehicle] ?? 0.1);

    $update_sql = "UPDATE transport_log SET vehicle_type='$vehicle', distance_km='$dist', carbon_emissions='$emissions' WHERE id=$id AND user_id=$uid";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Log Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow p-4" style="width: 400px;">
        <h4 class="mb-4">Edit Transport Log</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Vehicle Type</label>
                <select name="vehicle_type" class="form-select">
                    <option value="Car" <?php if($row['vehicle_type'] == 'Car') echo 'selected'; ?>>Car</option>
                    <option value="Bus" <?php if($row['vehicle_type'] == 'Bus') echo 'selected'; ?>>Bus</option>
                    <option value="Bike" <?php if($row['vehicle_type'] == 'Bike') echo 'selected'; ?>>Bike</option>
                    <option value="Train" <?php if($row['vehicle_type'] == 'Train') echo 'selected'; ?>>Train</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Distance (km)</label>
                <input type="number" name="distance" class="form-control" value="<?php echo $row['distance_km']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Entry</button>
            <a href="dashboard.php" class="btn btn-link w-100 mt-2 text-decoration-none">Cancel</a>
        </form>
    </div>
</body>
</html>