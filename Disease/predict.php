<?php

$image = $_GET['image'] ?? "";
// ============================
// AI Prediction
// ============================

$diseaseData = include("disease_data.php");

$imagePath = "uploads/" . $image;

// Python AI Model Run
$command = "python model.py " . escapeshellarg($imagePath);

$output = shell_exec($command);

$result = json_decode($output, true);

$predictedClass = "";

$confidence = 0;

if(isset($result["status"]) && $result["status"]=="success")
{
    $predictedClass = $result["class"];
    $confidence = $result["confidence"];
}
else
{
    die("<h2 style='color:red;'>❌ AI Prediction Failed</h2><pre>".$output."</pre>");
}

// ============================
// Disease Details
// ============================

$disease = null;

if(isset($diseaseData[$predictedClass]))
{
    $disease = $diseaseData[$predictedClass];
}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Smart AI Disease Detection</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>🌿 Smart AI Disease Detection</h3>

</div>

<div class="card-body text-center">

<?php

if($image!="")
{

?>

<h5>Uploaded Leaf Image</h5>

<img
src="uploads/<?php echo $image; ?>"
class="img-fluid rounded shadow"
style="max-height:300px;">

<br><br>

<?php if($disease){ ?>

<div class="alert alert-success mt-4">

<h4>🤖 AI Analysis Completed</h4>

<hr>

<h5>
🌱 Crop :
<?php echo $disease["crop_en"]; ?>
(<?php echo $disease["crop_hi"]; ?>)
</h5>

<h5>
🦠 Disease :
<?php echo $disease["disease_en"]; ?>
(<?php echo $disease["disease_hi"]; ?>)
</h5>

<h5>
📊 Confidence :
<?php echo $confidence; ?> %
</h5>

</div>

<?php } ?>

<?php
}
else
{
    echo "<div class='alert alert-danger'>No Image Found.</div>";
}
?>

</div>

</div>

</div>

</body>

</html>