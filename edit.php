<?php

$conn = mysqli_connect("localhost", "root", "", "smart_crop_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];

$sql = "SELECT * FROM crop_data WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $name = $_POST['farmer_name'];
    $soil = $_POST['soil'];
    $temperature = $_POST['temperature'];
    $humidity = $_POST['humidity'];
    $rainfall = $_POST['rainfall'];
    $water = $_POST['water'];

    $update = "UPDATE crop_data SET
                farmer_name='$name',
                soil='$soil',
                temperature='$temperature',
                humidity='$humidity',
                rainfall='$rainfall',
                water='$water'
                WHERE id=$id";

    mysqli_query($conn, $update);

    header("Location: view_data.php");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Record</title>

    <style>
        body{
            font-family:Arial;
            padding:20px;
        }

        form{
            width:400px;
            margin:auto;
        }

        input{
            width:100%;
            padding:10px;
            margin:5px 0;
        }

        button{
            padding:10px 20px;
            background:green;
            color:white;
            border:none;
        }

        h2{
            text-align:center;
            color:green;
        }
    </style>
</head>

<body>

<h2>Edit Farmer Record</h2>

<form method="POST">

    <label>Farmer Name</label>
    <input type="text" name="farmer_name" value="<?php echo $row['farmer_name']; ?>">

    <label>Soil</label>
    <input type="text" name="soil" value="<?php echo $row['soil']; ?>">

    <label>Temperature</label>
    <input type="text" name="temperature" value="<?php echo $row['temperature']; ?>">

    <label>Humidity</label>
    <input type="text" name="humidity" value="<?php echo $row['humidity']; ?>">

    <label>Rainfall</label>
    <input type="text" name="rainfall" value="<?php echo $row['rainfall']; ?>">

    <label>Water</label>
    <input type="text" name="water" value="<?php echo $row['water']; ?>">

    <br><br>

    <button type="submit" name="update">Update Record</button>

</form>

</body>
</html>