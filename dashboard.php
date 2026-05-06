<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }
include 'db_connect.php';
$uid = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Carbon Tracker</span>
    <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
		<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <h6>Total Trips</h6>
                <h3><?php 
                    $count = mysqli_query($conn, "SELECT COUNT(*) as total FROM transport_log WHERE user_id=$uid");
                    echo mysqli_fetch_assoc($count)['total']; 
                ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <h6>Total CO2 Saved (Estimate)</h6>
                <h3>12.5 kg</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h6>User Level</h6>
                <h3>Eco-Warrior</h3>
            </div>
        </div>
    </div>
</div>
                <h5>Log New Trip</h5>
                <form action="save_data.php" method="POST">
                    <label>Vehicle</label>
                    <select name="vehicle_type" class="form-select mb-2">
                        <option value="Car">Car (High Emission)</option>
                        <option value="Bus">Bus (Medium Emission)</option>
                        <option value="Bike">Bike (Low Emission)</option>
                        <option value="Train">Train (Very Low)</option>
                    </select>
                    <label>Distance (km)</label>
                    <input type="number" name="distance" class="form-control mb-3" required>
                    <button type="submit" class="btn btn-success w-100">Add Entry</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <h5>Emissions Summary</h5>
                <canvas id="myChart" style="max-height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <div class="card mt-4 p-3 shadow-sm">
        <h5>Recent Logs</h5>
        <table class="table table-bordered">
    <thead>
        <tr>
            <th>Vehicle</th>
            <th>Distance</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
$uid = $_SESSION['user_id'];
$res = mysqli_query($conn, "SELECT * FROM transport_log WHERE user_id=$uid");

while($row = mysqli_fetch_assoc($res)) {
    $id = $row['id'];
    $vehicle = $row['vehicle_type'];
    $km = $row['distance_km'];
    $co2 = $row['carbon_emissions'];

    echo "<tr>";
    echo "<td>" . $vehicle . "</td>";
    echo "<td>" . $km . "</td>";
    echo "<td>" . $co2 . "kg</td>";
    echo "<td>
            <a href='edit.php?id=$id' class='btn btn-warning btn-sm'>Edit</a>
            <a href='delete.php?id=$id' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
          </td>";
    echo "</tr>";
}
?>    </tbody>
</table>    </div>
</div>

<script>
    fetch('chart_data.php').then(res => res.json()).then(data => {
        new Chart(document.getElementById('myChart'), {
            type: 'bar', // Changed to Bar for a professional look
            data: {
                labels: data.map(i => i.vehicle_type),
                datasets: [{ label: 'CO2 Emissions', data: data.map(i => i.total_emissions), backgroundColor: '#0d6efd' }]
            }
        });
    });
</script>
</body>
</html>