```php
<?php

// ==============================
// Smart AI Disease Detection
// ==============================

$image = $_GET['image'] ?? "";
$crop  = $_GET['crop'] ?? "";

// Disease Database
$diseaseData = include("disease_data.php");

// Default Values
$predictedClass = "";
$confidence = 0;
$disease = null;
$errorMessage = "";

// ==============================
// Run AI Model
// ==============================

if ($image != "")
{
    $imagePath = __DIR__ . "/uploads/" . basename($image);

    if (file_exists($imagePath))
    {
        $python = "C:\\xampp\\htdocs\\SmartCropProject\\ai_env\\Scripts\\python.exe";
        $model  = __DIR__ . "\\model.py";

        $imageReal = realpath($imagePath);

        if ($imageReal === false)
        {
            $errorMessage = "Image path could not be resolved.";
        }
        else
        {
            $command =
                "\"" . $python . "\" "
                . escapeshellarg($model)
                . " "
                . escapeshellarg($crop)
                . " "
                . escapeshellarg($imageReal);

            $output = shell_exec($command . " 2>&1");

            // ==========================================
            // Extract JSON returned by Python
            // ==========================================

            preg_match('/\{.*\}/s', $output, $matches);

            if (empty($matches))
            {
                echo "<pre>";
                echo "JSON Not Found\n\n";
                echo htmlspecialchars($output);
                echo "</pre>";
                exit;
            }

            $jsonLine = $matches[0];

            $result = json_decode($jsonLine, true);

            if (json_last_error() !== JSON_ERROR_NONE)
            {
                echo "<pre>";
                echo "JSON Decode Failed\n";
                echo json_last_error_msg() . "\n\n";
                echo htmlspecialchars($jsonLine);
                echo "</pre>";
                exit;
            }

            // ==========================================
            // Python Prediction Successful
            // ==========================================

            if (
                isset($result["status"]) &&
                $result["status"] === "success"
            )
            {
                $predictedClass = trim($result["class"] ?? "");
                $confidence = floatval($result["confidence"] ?? 0);

                // ==========================================
                // CROP NAME NORMALIZATION
                // ==========================================

                $crop = trim($crop);

                // ==========================================
                // RICE - EXACT MODEL LABEL MAPPING
                // ==========================================

                if (strcasecmp($crop, "Rice") === 0)
                {
                    $riceMapping = [

                        "bacterial_leaf_blight"
                            => "Rice_Bacterial_Leaf_Blight",

                        "brown_spot"
                            => "Rice_Brown_Spot",

                        "healthy"
                            => "Rice_Healthy",

                        "leaf_blast"
                            => "Rice_Leaf_Blast",

                        "leaf_scald"
                            => "Rice_Leaf_Scald",

                        "narrow_brown_spot"
                            => "Rice_Narrow_Brown_Spot"
                    ];

                    $modelLabel = strtolower(trim($predictedClass));

                    if (isset($riceMapping[$modelLabel]))
                    {
                        $predictedClass = $riceMapping[$modelLabel];
                    }
                }

                // ==========================================
                // WHEAT MAPPING
                // ==========================================

                elseif (strcasecmp($crop, "Wheat") === 0)
                {
                    $wheatMapping = [

                        "healthy"
                            => "Wheat_Healthy",

                        "loose_smut"
                            => "Wheat_Loose_Smut",

                        "powdery_mildew"
                            => "Wheat_Powdery_Mildew",

                        "rust"
                            => "Wheat_Rust"
                    ];

                    $modelLabel = strtolower(trim($predictedClass));

                    if (isset($wheatMapping[$modelLabel]))
                    {
                        $predictedClass = $wheatMapping[$modelLabel];
                    }
                }

                // ==========================================
                // MAIZE MAPPING
                // ==========================================

                elseif (strcasecmp($crop, "Maize") === 0)
                {
                    $maizeMapping = [

                        "healthy"
                            => "Maize_Healthy",

                        "gray_leaf_spot"
                            => "Maize_Gray_Leaf_Spot",

                        "leaf_blight"
                            => "Maize_Leaf_Blight",

                        "rust"
                            => "Maize_Rust"
                    ];

                    $modelLabel = strtolower(trim($predictedClass));

                    if (isset($maizeMapping[$modelLabel]))
                    {
                        $predictedClass = $maizeMapping[$modelLabel];
                    }
                }

                // ==========================================
                // FIND DISEASE DETAILS
                // ==========================================

                if (isset($diseaseData[$predictedClass]))
                {
                    $disease = $diseaseData[$predictedClass];
                }
                else
                {
                    $errorMessage =
                        "Disease details are not available for this prediction.";
                }
            }
            else
            {
                $errorMessage =
                    $result["message"] ?? "AI prediction failed.";
            }
        }
    }
    else
    {
        $errorMessage = "Uploaded image not found.";
    }
}
else
{
    $errorMessage = "No image was provided.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>Smart AI Disease Detection</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3 class="mb-0">
🌿 Smart AI Disease Detection
</h3>

</div>

<div class="card-body">

<?php if ($image != "") { ?>

<!-- ==============================
     Uploaded Image
============================== -->

<div class="text-center">

<h5 class="mb-3">
Uploaded Leaf Image
</h5>

<img
src="uploads/<?php echo htmlspecialchars($image); ?>"
class="img-fluid rounded shadow"
style="max-height:300px;">

</div>

<hr>

<?php } ?>


<?php if ($disease) { ?>

<!-- ==============================
     AI ANALYSIS REPORT
============================== -->

<div class="card border-success shadow mt-4">

<div class="card-header bg-success text-white">

<h3>
🤖 AI Analysis Report
</h3>

</div>

<div class="card-body">

<h4 class="text-success">

🌱 Crop :

<?php echo htmlspecialchars($disease["crop_en"] ?? $crop); ?>

(<?php echo htmlspecialchars($disease["crop_hi"] ?? ""); ?>)

</h4>

<hr>

<h4 class="text-danger">

🦠 Disease :

<?php echo htmlspecialchars($disease["disease_en"] ?? "Unknown"); ?>

(<?php echo htmlspecialchars($disease["disease_hi"] ?? ""); ?>)

</h4>

<hr>

<h5>

📊 Confidence :

<span class="badge bg-primary">

<?php echo htmlspecialchars($confidence); ?> %

</span>

</h5>

</div>

</div>


<!-- ==============================
     DISEASE INFORMATION
============================== -->

<hr>

<div class="card mt-4 shadow">

<div class="card-header bg-primary text-white">

📋 Disease Information

</div>

<div class="card-body">


<h5>
🦠 Cause (कारण)
</h5>

<p>

<?php

echo htmlspecialchars(
    $disease["cause_en"] ?? "Not Available"
);

?>

<br>

<strong>

<?php

echo htmlspecialchars(
    $disease["cause_hi"] ?? ""
);

?>

</strong>

</p>


<hr>


<h5>
🔍 Symptoms (लक्षण)
</h5>

<ul>

<?php

if (isset($disease["symptoms_en"]))
{
    foreach (
        $disease["symptoms_en"]
        as $i => $symptom
    )
    {
        echo "<li>";

        echo htmlspecialchars($symptom);

        if (
            isset($disease["symptoms_hi"][$i])
        )
        {
            echo " (";

            echo htmlspecialchars(
                $disease["symptoms_hi"][$i]
            );

            echo ")";
        }

        echo "</li>";
    }
}

?>

</ul>


<hr>


<h5>
💊 Recommended Medicines
</h5>

<ul>

<?php

if (isset($disease["medicine_en"]))
{
    foreach (
        $disease["medicine_en"]
        as $i => $medicine
    )
    {
        echo "<li>";

        echo htmlspecialchars($medicine);

        if (
            isset($disease["medicine_hi"][$i])
        )
        {
            echo " (";

            echo htmlspecialchars(
                $disease["medicine_hi"][$i]
            );

            echo ")";
        }

        echo "</li>";
    }
}

?>

</ul>


<hr>


<h5>
🌱 Treatment
</h5>

<ul>

<?php

if (isset($disease["treatment_en"]))
{
    foreach (
        $disease["treatment_en"]
        as $i => $step
    )
    {
        echo "<li>";

        echo htmlspecialchars($step);

        if (
            isset($disease["treatment_hi"][$i])
        )
        {
            echo " (";

            echo htmlspecialchars(
                $disease["treatment_hi"][$i]
            );

            echo ")";
        }

        echo "</li>";
    }
}

?>

</ul>

</div>

</div>


<!-- ==============================
     FARMER ADVICE
============================== -->

<div class="card mt-4 shadow border-success">

<div class="card-header bg-success text-white">

👨‍🌾 Farmer Advice (किसान सलाह)

</div>

<div class="card-body">

<?php

if (isset($disease['farmer_advice_hi']))
{

    echo '<div class="alert alert-success mb-0">';

    echo "🌱 " .
         htmlspecialchars(
             $disease['farmer_advice_hi']
         );

    echo '</div>';

}
else
{

?>

<div class="alert alert-success mb-0">

🌱 किसान नियमित सिंचाई, संतुलित उर्वरक
तथा समय-समय पर फसल का निरीक्षण करते रहें।

</div>

<?php

}

?>

</div>

</div>


<?php } else { ?>


<!-- ==============================
     PREDICTION / DISEASE ERROR
============================== -->

<div class="alert alert-warning">

<h5>
⚠️ AI Prediction Information
</h5>

<?php

echo htmlspecialchars(
    $errorMessage
);

?>

<br><br>

<?php if ($predictedClass != "") { ?>

Predicted Class :

<strong>

<?php

echo htmlspecialchars(
    $predictedClass
);

?>

</strong>

<br>

Confidence :

<strong>

<?php

echo htmlspecialchars(
    $confidence
);

?> %

</strong>

<?php } ?>

</div>


<?php } ?>

</div>

</div>

</div>

</body>

</html>
```
