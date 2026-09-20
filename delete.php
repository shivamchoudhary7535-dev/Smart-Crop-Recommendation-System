<?php

$conn = mysqli_connect("localhost", "root", "", "smart_crop_db");

if(!$conn)
{
    die("Connection Failed");
}

$id = $_GET['id'];

$sql = "DELETE FROM crop_data WHERE id=$id";

if(mysqli_query($conn, $sql))
{
    header("Location: view_data.php");
}
else
{
    echo "Delete Failed";
}

?>