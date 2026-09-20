<?php

require_once('vendor/autoload.php');

// ===============================
// RECEIVE DATA FROM RESULT PAGE
// ===============================

$name          = $_POST['farmer_name'] ?? '';
$soil          = $_POST['soil'] ?? '';
$temp          = $_POST['temperature'] ?? '';
$humidity      = $_POST['humidity'] ?? '';
$rainfall      = $_POST['rainfall'] ?? '';
$water         = $_POST['water'] ?? '';
$area          = $_POST['area'] ?? '';

$crop          = $_POST['crop'] ?? '';
$advice        = $_POST['advice'] ?? '';
$fertilizer    = $_POST['fertilizer'] ?? '';
$weatherAlert  = $_POST['weatherAlert'] ?? '';
$diseaseRisk   = $_POST['diseaseRisk'] ?? '';
$soilScore     = $_POST['soilScore'] ?? '';
$profit        = $_POST['profit'] ?? '';

// =======================================
// PDF ENGLISH TRANSLATION
// =======================================

$soilEnglish = [

"रेतीली मिट्टी (Sandy)" => "Sandy Soil",

"दोमट मिट्टी (Loamy)" => "Loamy Soil",

"चिकनी मिट्टी (Clay)" => "Clay Soil",

"काली मिट्टी (Black)" => "Black Soil",

"लाल मिट्टी (Red)" => "Red Soil",

"जलोढ़ मिट्टी (Alluvial)" => "Alluvial Soil"

];


$cropEnglish = [

"धान (Rice)" => "Rice",

"गेहूं (Wheat)" => "Wheat",

"मक्का (Maize)" => "Maize",

"चना (Gram)" => "Gram",

"सरसों (Mustard)" => "Mustard",

"बाजरा (Bajra)" => "Pearl Millet",

"ज्वार (Jowar)" => "Sorghum",

"कपास (Cotton)" => "Cotton",

"सोयाबीन (Soybean)" => "Soybean",

"अरहर (Pigeon Pea)" => "Pigeon Pea",

"मूंग (Green Gram)" => "Green Gram",

"उड़द (Black Gram)" => "Black Gram",

"मूंगफली (Groundnut)" => "Groundnut",

"गन्ना (Sugarcane)" => "Sugarcane",

"जौ (Barley)" => "Barley"

];


$waterEnglish = [

"कम" => "Low",

"ठीक-ठाक" => "Medium",

"अच्छी" => "Good"

];

$humidityEnglish = [

    "कम" => "Low",

    "मध्यम" => "Medium",

    "अधिक" => "High",

    "ज्यादा" => "High",

    "High" => "High",

    "Medium" => "Medium",

    "Low" => "Low"

];

$rainfallEnglish = [
    trim("कम वर्षा") => "Low Rainfall",
    trim("सामान्य वर्षा") => "Normal Rainfall",
    trim("अधिक वर्षा") => "Heavy Rainfall"
];

$diseaseEnglish = [

"LOW" => "LOW",

"MEDIUM" => "MEDIUM",

"HIGH" => "HIGH",

"कम" => "LOW",

"मध्यम" => "MEDIUM",

"अधिक" => "HIGH"

];


$soil = $soilEnglish[$soil] ?? $soil;

$crop = $cropEnglish[$crop] ?? $crop;

$water = $waterEnglish[$water] ?? $water;

$humidity = $humidityEnglish[$humidity] ?? $humidity;

$rainfall = trim($rainfall);
$rainfall = $rainfallEnglish[$rainfall] ?? "Normal Rainfall";

$diseaseRisk = $diseaseEnglish[$diseaseRisk] ?? $diseaseRisk;

// ===============================
// CREATE PDF
// ===============================

$pdf = new TCPDF();

$pdf->SetCreator('Smart Crop Advisory System');
$pdf->SetAuthor('Shivam Chaudhary');
$pdf->SetTitle('Smart Crop Advisory Report');
$pdf->SetSubject('Crop Recommendation');

$pdf->SetMargins(10,15,10);
$pdf->SetAutoPageBreak(TRUE,15);

$pdf->AddPage();


// ===============================
// FONT
// ===============================

// DejaVu Font supports Unicode
$pdf->SetFont('dejavusans','',11);


// ===============================
// HEADER
// ===============================

$pdf->SetFillColor(25,135,84);
$pdf->SetTextColor(255,255,255);

$pdf->SetFont('dejavusans','B',18);

$pdf->Cell(
    0,
    14,
    'SMART CROP ADVISORY SYSTEM',
    0,
    1,
    'C',
    true
);

$pdf->Ln(4);

$pdf->SetTextColor(0,0,0);

$pdf->SetFont('dejavusans','B',15);

$pdf->Cell(
    0,
    10,
    'Farmer Report',
    0,
    1,
    'C'
);

$pdf->Ln(3);


// ===============================
// FARMER DETAILS
// ===============================

$pdf->SetFillColor(230,240,255);

$pdf->SetFont('dejavusans','B',12);

$pdf->Cell(
    0,
    10,
    'Farmer Details',
    1,
    1,
    'L',
    true
);

$pdf->SetFont('dejavusans','',11);


$pdf->Cell(50,9,'Farmer Name',1,0);
$pdf->Cell(140,9,$name,1,1);

$pdf->Cell(50,9,'Soil Type',1,0);
$pdf->Cell(140,9,$soil,1,1);

$pdf->Cell(50,9,'Temperature',1,0);
$pdf->Cell(140,9,$temp.' °C',1,1);

$pdf->Cell(50,9,'Humidity',1,0);
$pdf->Cell(140,9,$humidity,1,1);

$pdf->Cell(50,9,'Rainfall',1,0);
$pdf->Cell(140,9,$rainfall,1,1);

$pdf->Cell(50,9,'Water Availability',1,0);
$pdf->Cell(140,9,$water,1,1);

$pdf->Cell(50,9,'Land Area',1,0);
$pdf->Cell(140,9,$area.' Bigha',1,1);

$pdf->Ln(8);

// ===============================
// RECOMMENDED CROP
// ===============================

$pdf->SetFillColor(198,239,206);

$pdf->SetFont('dejavusans','B',12);

$pdf->Cell(
    0,
    10,
    'Recommended Crop',
    1,
    1,
    'L',
    true
);

$pdf->SetFont('dejavusans','B',14);

$pdf->SetTextColor(0,128,0);

$pdf->Cell(
    0,
    12,
    $crop,
    1,
    1,
    'C'
);

$pdf->SetTextColor(0,0,0);

$pdf->Ln(5);


// ===============================
// AI ADVICE
// ===============================

$pdf->SetFillColor(255,242,204);

$pdf->SetFont('dejavusans','B',12);

$pdf->Cell(
    0,
    10,
    'AI Recommendation',
    1,
    1,
    'L',
    true
);

$pdf->SetFont('dejavusans','',11);

// ===============================
// AI ADVICE (English)
// ===============================

$advice = "The selected soil and weather conditions are suitable for this crop. Maintain proper irrigation, apply balanced fertilizers, and regularly monitor the crop for better yield.";

$pdf->MultiCell(
    0,
    8,
    $advice,
    1
);

$pdf->Ln(5);


// ===============================
// RECOMMENDED FERTILIZER
// ===============================

// Heading
$pdf->SetFillColor(226,239,218);
$pdf->SetFont('dejavusans','B',12);

$pdf->Cell(
    0,
    10,
    'Recommended Fertilizer',
    1,
    1,
    'L',
    true
);

// Table Font
$pdf->SetFont('dejavusans','',11);

// Fertilizer List
$fertilizers = [
    "DAP (Di-Ammonium Phosphate)",
    "Urea",
    "NPK Balanced Fertilizer",
    "Zinc Sulphate",
    "Organic Compost / Vermicompost"
];

// Draw Table
foreach($fertilizers as $item){

   $pdf->Cell(10,8,"•",1,0,'C');
   $pdf->Cell(180,8,$item,1,1);

}
$pdf->Ln(5);

// ===============================
// WEATHER ALERT
// ===============================

$pdf->SetFillColor(221,235,247);

$pdf->SetFont('dejavusans','B',12);

$pdf->SetX(10);

$pdf->Cell(
    190,
    10,
    'Weather Alert',
    1,
    1,
    'L',
    true
);
$pdf->SetFont('dejavusans','',11);

$weatherAlert =
"Maintain proper irrigation according to weather conditions. Regularly monitor rainfall and avoid waterlogging.";

$pdf->SetX(10);

$pdf->MultiCell(
    190,
    8,
    $weatherAlert,
    1,
    'L'
);

$pdf->Ln(5);

// ===============================
// DISEASE RISK
// ===============================

$pdf->SetX(10);
$pdf->SetFillColor(248,215,218);
$pdf->SetFont('dejavusans','B',12);

$pdf->Cell(190,10,'Disease Risk Analysis',1,1,'L',true);

$pdf->SetFont('dejavusans','',11);

$pdf->SetX(10);

$pdf->Cell(150,10,'Current Disease Risk',1,0,'L');
$pdf->Cell(40,10,$diseaseRisk,1,1,'C');

$pdf->Ln(5);
$pdf->Ln(5);

// ===============================
// SOIL HEALTH
// ===============================

$pdf->SetFillColor(212,237,218);

$pdf->SetFont('dejavusans','B',12);

$pdf->SetX(10);

$pdf->Cell(
    190,
    10,
    'Soil Health Score',
    1,
    1,
    'L',
    true
);
$pdf->SetFont('dejavusans','',11);

$pdf->SetX(10);

$pdf->MultiCell(
    190,
    8,
    "Current Soil Health Score : ".$soilScore."/100",
    1,
    'L'
);

$pdf->Ln(5);


// ===============================
// ESTIMATED PROFIT
// ===============================

$pdf->SetFillColor(255,243,205);

$pdf->SetFont('dejavusans','B',12);

$pdf->Cell(
    0,
    10,
    'Estimated Profit',
    1,
    1,
    'L',
    true
);

$pdf->SetFont('dejavusans','B',13);

$pdf->SetTextColor(0,120,0);

$pdf->Cell(
    0,
    12,
    "Rs. ".number_format($profit),
    1,
    1,
    'C'
);

$pdf->SetTextColor(0,0,0);

$pdf->Ln(6);


// ===============================
// SUMMARY
// ===============================

$pdf->SetFillColor(230,230,250);

$pdf->SetFont('dejavusans','B',12);

$pdf->Cell(
    0,
    10,
    'Smart Summary',
    1,
    1,
    'L',
    true
);

$pdf->SetFont('dejavusans','',11);

$summary =
"Recommended Crop : ".$crop."\n\n".
"Soil Type : ".$soil."\n\n".
"Land Area : ".$area." Bigha\n\n".
"Soil Health : ".$soilScore."/100\n\n".
"Disease Risk : ".$diseaseRisk."\n\n".
"Expected Profit : Rs. ".number_format($profit);

$pdf->MultiCell(
    0,
    8,
    $summary,
    1
);

$pdf->Ln(6);

// ===============================
// REPORT DATE
// ===============================

$pdf->SetFillColor(240,240,240);

$pdf->SetFont('dejavusans','B',11);

$pdf->Cell(
    60,
    10,
    'Report Generated On',
    1,
    0,
    'L',
    true
);

$pdf->SetFont('dejavusans','',11);

$pdf->Cell(
    120,
    10,
    date("d-m-Y H:i:s"),
    1,
    1
);

$pdf->Ln(8);


// ===============================
// THANK YOU MESSAGE
// ===============================

$pdf->SetFont('dejavusans','B',14);

$pdf->SetTextColor(25,135,84);

$pdf->Cell(
    0,
    10,
    'Thank You!',
    0,
    1,
    'C'
);

$pdf->SetTextColor(0,0,0);

$pdf->SetFont('dejavusans','',11);

$pdf->MultiCell(
    0,
    8,
    "This report has been generated by the Smart Crop Advisory System.\n\nThe recommendations are based on the information provided by the farmer. Please consult your local agriculture expert before taking any final farming decisions.",
    0,
    'C'
);

$pdf->Ln(5);


// ===============================
// FOOTER
// ===============================

$pdf->SetY(-25);

$pdf->SetDrawColor(180,180,180);

$pdf->Line(
    15,
    $pdf->GetY(),
    195,
    $pdf->GetY()
);

$pdf->Ln(4);

$pdf->SetFont('dejavusans','I',10);

$pdf->Cell(
    0,
    10,
    'Developed by Shivam Chaudhary | Smart Crop Advisory System',
    0,
    1,
    'C'
);


// ===============================
// DOWNLOAD PDF
// ===============================

$pdf->Output('Smart_Crop_Report.pdf','I');

exit;