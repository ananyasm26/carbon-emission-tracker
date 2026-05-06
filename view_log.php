<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Carbon Log</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Your Transport History</h2>
    <table border="1">
        <tr>
            <th>Vehicle</th>
            <th>Distance (km)</th>
            <th>CO2 (kg)</th>
            <th>Date</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM transport_log ORDER BY log_date DESC");
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['vehicle_type']}</td>
                    <td>{$row['distance_km']}</td>
                    <td>{$row['carbon_emissions']}</td>
                    <td>{$row['log_date']}</td>
                  </tr>";
        }
        ?>
    </table>

    <h2>Emissions Overview</h2>
    <div style="width: 400px; height: 400px;">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        fetch('chart_data.php')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.vehicle_type);
                const emissions = data.map(item => item.total_emissions);

                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: emissions,
                            backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56']
                        }]
                    }
                });
            });
    </script>
    <br>
    <a href="index.php">Add New Entry</a>
</body>
</html>