<?php

if(isset($_FILES['leaf_image']))
{
$crop = $_POST['crop'] ?? "";

    // Crop receive karo

    $folder = "uploads/";

    if(!is_dir($folder))
    {
        mkdir($folder, 0777, true);
    }

    $filename = time() . "_" . basename($_FILES["leaf_image"]["name"]);

    $target = $folder . $filename;
if(move_uploaded_file($_FILES["leaf_image"]["tmp_name"], $target))
{
    header("Location: predict_ai.php?image=" . urlencode($filename) . "&crop=" . urlencode($crop));
    exit;
}
else
{
    echo "<h2 style='color:red;'>UPLOAD FAILED</h2>";
    exit;
}
}
else
{
    echo "No image selected.";
}

?>