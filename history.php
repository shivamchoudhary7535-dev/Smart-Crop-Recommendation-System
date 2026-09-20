<?php
$conn = mysqli_connect("localhost", "root", "", "smart_crop_db");

if (!$conn) {
    die("Connection failed");
}

$sql = "SELECT * FROM crop_data ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmers History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<div class="container mt-4">

    <h2 class="text-center text-success">📊 Farmers Crop History</h2>

    <table class="table table-bordered table-striped mt-4">
        <thead class="table-success">
            <tr>
                <th>ID</th>
                <th>Farmer Name</th>
                <th>Soil</th>
                <th>Temperature</th>
                <th>Humidity</th>
                <th>Rainfall</th>
                <th>Water Availability</th>
                <th>Crop</th>
            </tr>
        </thead>

        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['farmer_name']; ?></td>
                <td><?php echo $row['soil']; ?></td>
                <td><?php echo $row['temperature']; ?></td>
                <td><?php echo $row['humidity']; ?></td>
                <td><?php echo $row['rainfall']; ?></td>
                <td><?php echo $row['water_availability']; ?></td>
                <td><?php echo $row['recommended_crop']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>

<?php mysqli_close($conn); ?>