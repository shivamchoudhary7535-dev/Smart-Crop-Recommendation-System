<?php

$diseaseData = include("disease_data.php");
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "smart_crop_db"
);

if(!$conn)
{
    die("Database Connection Failed");
}

/*
    Abhi AI Model nahi laga hai.
    Isliye testing ke liye dummy prediction use kar rahe hain.

    Baad me AI model isi variable ko replace karega.
*/

$crop = $_GET['crop'] ?? "tomato";
$image = $_GET['image'] ?? "";

// Crop ki sari available diseases nikalo
$availableDiseases = array_keys($diseaseData[$crop]);

// Random disease select karo (Testing purpose)
$predictedDisease = $availableDiseases[array_rand($availableDiseases)];

/*
Examples:

healthy
early_blight
late_blight
rust
blast
brown_spot

*/

if(isset($diseaseData[$crop][$predictedDisease]))
{
    $result = $diseaseData[$crop][$predictedDisease];
    // Dummy AI Confidence (Testing)
$confidence = rand(85,99);
}
else
{
    die("Disease not found.");
}

/* ===============================
   Save Prediction History
================================ */

$conn = mysqli_connect("localhost", "root", "", "smart_crop_db");

if($conn)
{

    $crop_name = mysqli_real_escape_string($conn, ucfirst($crop));

    $disease_en = mysqli_real_escape_string($conn, $result['en']);

    $disease_hi = mysqli_real_escape_string($conn, $result['hi']);

    $confidence = "89%";

    $image = $_GET['image'] ?? "";

    mysqli_query($conn, "
    INSERT INTO disease_history
    (crop, disease_en, disease_hi, confidence, image)
    VALUES
    ('$crop_name','$disease_en','$disease_hi','$confidence','$image')
    ");

}
$image = $_GET['image'] ?? "";

$disease_en = $result['en'];
$disease_hi = $result['hi'];

$confidence = rand(85,99) . "%";

$sql = "INSERT INTO disease_history
(
    crop,
    disease_en,
    disease_hi,
    confidence,
    image
)
VALUES
(
    '$crop',
    '$disease_en',
    '$disease_hi',
    '$confidence',
    '$image'
)";

mysqli_query($conn, $sql);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>AI Disease Detection</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>🌿 AI Disease Detection Result</h3>

</div>

<div class="card-body">
<?php
if($image!="")
{
?>
<div class="text-center mb-4">

<h5>Uploaded Leaf Image</h5>

<img
src="uploads/<?php echo $image; ?>"
class="img-fluid rounded shadow"
style="max-width:350px;">

</div>

<hr>

<?php
}
?>

<h4>

<?php if($image!=""){ ?>

<div class="text-center mb-3">

<img
src="uploads/<?= $image; ?>"
class="img-fluid rounded border"
style="max-height:250px;">

</div>

<?php } ?>

Disease :

<?= $result['en']; ?>
<br><br>

<strong>AI Confidence :</strong>

<?= $confidence; ?>%

<br>

<?= $result['hi']; ?>

</h4>
<hr>

<h5>🌾 Crop / फसल</h5>

<p>

<?php echo ucfirst($crop); ?>

</p>

<hr>

<p>

<strong>Cause</strong>

<br>

<?= $result['cause_en'] ?? ""; ?>

<br>

<?= $result['cause_hi'] ?? ""; ?>

</p>
<hr>

<h5>⚠ Symptoms / लक्षण</h5>

<ul>

<?php

if(isset($result['symptoms_en']))
{
    foreach($result['symptoms_en'] as $item)
    {
        echo "<li>$item</li>";
    }
}

?>

</ul>

<ul>

<?php

if(isset($result['symptoms_hi']))
{
    foreach($result['symptoms_hi'] as $item)
    {
        echo "<li>$item</li>";
    }
}

?>

</ul>

<hr>

<h5>💊 Medicine / दवा</h5>

<ul>

<?php

if(isset($result['medicine_en']))
{

    foreach($result['medicine_en'] as $item)
    {

        echo "<li>$item</li>";

    }

}

?>

</ul>

<ul>

<?php

if(isset($result['medicine_hi']))
{

    foreach($result['medicine_hi'] as $item)
    {

        echo "<li>$item</li>";

    }

}

?>

</ul>

<hr>

<h5>Treatment</h5>

<ul>

<?php

if(isset($result['treatment_en']))
{

foreach($result['treatment_en'] as $item)
{

echo "<li>$item</li>";

}

}

?>

</ul>

<ul>

<?php

if(isset($result['treatment_hi']))
{

foreach($result['treatment_hi'] as $item)
{

echo "<li>$item</li>";

}

}

?>

</ul>

</div>

</div>

</div>

</body>

</html>