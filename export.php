<?php

$conn = mysqli_connect("localhost", "root", "", "smart_crop_db");

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Farmer_Records.xls");

echo "ID\tFarmer Name\tSoil\tTemperature\tHumidity\tRainfall\tWater\tCrop\n";

$sql = "SELECT * FROM crop_data";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result))
{
    echo $row['id']."\t";
    echo $row['farmer_name']."\t";
    echo $row['soil']."\t";
    echo $row['temperature']."\t";
    echo $row['humidity']."\t";
    echo $row['rainfall']."\t";
    echo $row['water']."\t";
    echo $row['crop']."\n";
}

?>