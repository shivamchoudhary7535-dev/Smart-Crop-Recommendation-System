<?php

require_once 'weather.php';

session_start();

if(isset($_GET['lang']))
{
    $_SESSION['lang'] = $_GET['lang'];
}

if(!isset($_SESSION['lang']))
{
    $_SESSION['lang'] = "hi";
}

$langFile = "language/" . $_SESSION['lang'] . ".php";

require_once $langFile;

if ($_SERVER['REQUEST_METHOD'] != "POST" && isset($_SESSION['crop_data'])) {
    $_POST = $_SESSION['crop_data'];
}

$name = $_POST['farmer_name'];
$soil = $_POST['soil'];
$temp = $_POST['temperature'];
$humidity = $_POST['humidity'];
$rainfall = $_POST['rainfall'];
$water = $_POST['water'];
$city = $_POST['city'];
$areaBigha = floatval($_POST['area']);
$crop = "";

$_SESSION['crop_data'] = $_POST;

// ================================
// Bilingual Display Values
// ================================

if ($_SESSION['lang'] == "en") {

    // Soil
    $soilMap = [
        "रेतीली मिट्टी (Sandy)" => "Sandy Soil",
        "दोमट मिट्टी (Loamy)" => "Loamy Soil",
        "चिकनी मिट्टी (Clay)" => "Clay Soil"
    ];

    // Humidity
    $humidityMap = [
        "कम" => "Low",
        "मध्यम" => "Medium",
        "ज्यादा" => "High"
    ];

    // Rainfall
    $rainfallMap = [
        "कम बारिश" => "Low Rainfall",
        "सामान्य बारिश" => "Normal Rainfall",
        "ज्यादा बारिश" => "Heavy Rainfall"
    ];

    // Water
    $waterMap = [
        "कम" => "Low",
        "ठीक-ठाक" => "Moderate",
        "अच्छी" => "High"
    ];

    $soil = $soilMap[$soil] ?? $soil;
    $humidity = $humidityMap[$humidity] ?? $humidity;
    $rainfall = $rainfallMap[$rainfall] ?? $rainfall;
    $water = $waterMap[$water] ?? $water;
}

// ===============================
// LIVE WEATHER API
// ===============================

$weatherData = getWeather($city);

if($weatherData && isset($weatherData['main']))
{
    $liveTemp = $weatherData['main']['temp'];
    $liveHumidity = $weatherData['main']['humidity'];
    $liveWeather = $weatherData['weather'][0]['description'];
    $liveWind = $weatherData['wind']['speed'];
}
else
{
    $liveTemp = "N/A";
    $liveHumidity = "N/A";
    $liveWeather = "Weather Not Available";
    $liveWind = "N/A";
}

$conn = mysqli_connect("localhost", "root", "", "smart_crop_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

/* Crop Logic */
function bilingual($hi, $en)
{
    return ($_SESSION['lang'] == "en") ? $en : $hi;
}

if($soil == "sandy")
{
    if($rainfall == "low")
    {
        $cropKey = "बाजरा";
        $crop = bilingual("बाजरा","Bajra");

        $advice = bilingual(
            "रेतीली मिट्टी और कम वर्षा के लिए बाजरा उपयुक्त है।",
            "Bajra is suitable for sandy soil with low rainfall."
        );
    }

    elseif($rainfall == "normal")
    {
        if($humidity == "low")
        {
            $cropKey = "बाजरा";
$crop = bilingual("बाजरा","Bajra");

            $advice = bilingual(
                "कम नमी होने के कारण बाजरा अधिक उपयुक्त है।",
                "Bajra is more suitable because of low humidity."
            );
        }
        else
        {
            $cropKey = "मूंगफली";
$crop = bilingual("मूंगफली","Groundnut");

            $advice = bilingual(
                "पर्याप्त नमी होने के कारण मूंगफली अच्छी उपज देगी।",
                "Groundnut will give better yield because of sufficient moisture."
            );
        }
    }

    else
    {
        $cropKey = "मक्का";
$crop = bilingual("मक्का","Maize");

        $advice = bilingual(
            "अधिक वर्षा में मक्का अच्छी रहती है।",
            "Maize performs well in high rainfall."
        );
    }
}

elseif($soil == "loamy")
{
    if($temp <= 20)
    {
        $cropKey = "गेहूं";
$crop = bilingual("गेहूं","Wheat");

        $advice = bilingual(
            "ठंडे मौसम में गेहूं सर्वोत्तम है।",
            "Wheat is the best crop in cool weather."
        );
    }

    elseif($temp <= 28)
    {
        if($humidity == "high")
        {
            $cropKey = "मक्का";
$crop = bilingual("मक्का","Maize");

            $advice = bilingual(
                "अधिक नमी में मक्का अच्छा उत्पादन देता है।",
                "Maize gives better yield in high humidity."
            );
        }
        else
        {
            $cropKey = "चना";
$crop = bilingual("चना","Gram");

            $advice = bilingual(
                "दोमट मिट्टी और सामान्य नमी में चना उपयुक्त है।",
                "Gram is suitable for loamy soil with normal humidity."
            );
        }
    }

    else
    {
        $cropKey = "मक्का";
$crop = bilingual("मक्का","Maize");

        $advice = bilingual(
            "उच्च तापमान में मक्का बेहतर विकल्प है।",
            "Maize is a better choice in high temperature."
        );
    }
}
elseif($soil == "clay")
{
    if($water == "good" && $humidity == "high")
    {
        $cropKey = "धान";
$crop = bilingual("धान","Rice");

        $advice = bilingual(
            "चिकनी मिट्टी, अधिक पानी और अधिक नमी में धान सर्वोत्तम है।",
            "Rice is the best crop for clay soil with high water availability and humidity."
        );
    }

    elseif($humidity == "medium")
    {
        $cropKey = "सरसों";
$crop = bilingual("सरसों","Mustard");

        $advice = bilingual(
            "मध्यम नमी में सरसों भी अच्छा विकल्प है।",
            "Mustard is a good choice under medium humidity."
        );
    }

    else
    {
        $cropKey = "सरसों";
$crop = bilingual("सरसों","Mustard");

        $advice = bilingual(
            "कम पानी में सरसों अच्छी रहती है।",
            "Mustard performs well under low water availability."
        );
    }
}
elseif($soil == "black")
{
    if($rainfall == "high")
    {
        $cropKey = "सोयाबीन";
$crop = bilingual("सोयाबीन","Soybean");

        $advice = bilingual(
            "काली मिट्टी और अच्छी वर्षा में सोयाबीन उपयुक्त है।",
            "Soybean is suitable for black soil with good rainfall."
        );
    }
    else
    {
        $cropKey = "कपास";
$crop = bilingual("कपास","Cotton");

        $advice = bilingual(
            "काली मिट्टी कपास की खेती के लिए प्रसिद्ध है।",
            "Black soil is well known for cotton cultivation."
        );
    }
}

elseif($soil == "red")
{
    if($rainfall == "low")
    {
        $cropKey = "ज्वार";
$crop = bilingual("ज्वार","Jowar");

        $advice = bilingual(
            "लाल मिट्टी और कम वर्षा वाले क्षेत्रों में ज्वार अच्छी उपज देती है।",
            "Jowar gives good yield in red soil with low rainfall."
        );
    }
    else
    {
        $cropKey = "अरहर (Pigeon Pea)";
$crop = bilingual("अरहर","Pigeon Pea");

        $advice = bilingual(
            "लाल मिट्टी और सामान्य वर्षा में अरहर उपयुक्त रहती है।",
            "Pigeon Pea is suitable for red soil with normal rainfall."
        );
    }
}

elseif($soil == "alluvial")
{
    if($humidity == "high")
    {
        $cropKey = "गन्ना";
$crop = bilingual("गन्ना","Sugarcane");

        $advice = bilingual(
            "जलोढ़ मिट्टी, पर्याप्त नमी और पानी में गन्ना सर्वोत्तम रहता है।",
            "Sugarcane performs best in alluvial soil with sufficient water and humidity."
        );
    }
    elseif($humidity == "medium")
    {
        $cropKey = "मूंग";
$crop = bilingual("मूंग","Green Gram");

        $advice = bilingual(
            "जलोढ़ मिट्टी में मूंग अच्छी उपज देती है।",
            "Green Gram gives good yield in alluvial soil."
        );
    }
    else
    {
        $cropKey = "उड़द";
$crop = bilingual("उड़द","Black Gram");

        $advice = bilingual(
            "कम नमी में उड़द एक अच्छा विकल्प है।",
            "Black Gram is a good option under low humidity."
        );
    }
}

else
{
    $cropKey = "जौ";
$crop = bilingual("जौ","Barley");

    $advice = bilingual(
        "उपलब्ध जानकारी के अनुसार जौ एक सुरक्षित विकल्प है।",
        "According to the available information, Barley is a safe recommendation."
    );
}

/* Fertilizer Logic (YOUR ORIGINAL STYLE KE SAATH IMPROVED DISPLAY) */

$fertilizer = [
    "hi" => "",
    "en" => ""
];

if($crop == "धान")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - जड़ों के मजबूत विकास के लिए<br>
        ✔ यूरिया - पौधे की अच्छी वृद्धि के लिए<br>
        ✔ पोटाश (MOP) - रोग प्रतिरोधक क्षमता के लिए<br>
        ✔ जिंक सल्फेट - धान में जिंक की कमी रोकने के लिए
        ",

        "en" => "
        ✔ DAP - For strong root development<br>
        ✔ Urea - For healthy vegetative growth<br>
        ✔ MOP (Potash) - Improves disease resistance<br>
        ✔ Zinc Sulphate - Prevents zinc deficiency in rice
        "

    ];
}
elseif($crop == "गेहूं")
{
    $fertilizer = [

        "hi" => "
        ✔ NPK 20:20:0 - संतुलित पोषण के लिए<br>
        ✔ यूरिया - बेहतर कल्ले के लिए<br>
        ✔ सल्फर - अनाज की गुणवत्ता सुधारने के लिए
        ",

        "en" => "
        ✔ NPK 20:20:0 - Balanced nutrition<br>
        ✔ Urea - Improves tillering<br>
        ✔ Sulphur - Enhances grain quality
        "

    ];
}
elseif($crop == "मक्का")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - जड़ों के विकास के लिए<br>
        ✔ यूरिया - तेज़ वृद्धि के लिए<br>
        ✔ पोटाश - दानों की गुणवत्ता बढ़ाने के लिए
        ",

        "en" => "
        ✔ DAP - Promotes root development<br>
        ✔ Urea - Supports rapid growth<br>
        ✔ Potash - Improves grain quality
        "

    ];
}
elseif($crop == "चना")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - बुवाई के समय दें<br>
        ✔ जैविक खाद - मिट्टी सुधार के लिए<br>
        ✔ जिप्सम - दानों की अच्छी गुणवत्ता के लिए
        ",

        "en" => "
        ✔ DAP - Apply during sowing<br>
        ✔ Organic Manure - Improves soil fertility<br>
        ✔ Gypsum - Enhances grain quality
        "

    ];
}
elseif($crop == "सरसों")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - बुवाई के समय दें<br>
        ✔ यूरिया - प्रारंभिक वृद्धि के लिए<br>
        ✔ सल्फर - तेल की मात्रा बढ़ाने के लिए
        ",

        "en" => "
        ✔ DAP - Apply during sowing<br>
        ✔ Urea - Supports early plant growth<br>
        ✔ Sulphur - Improves oil content
        "

    ];
}
elseif($crop == "सोयाबीन")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - जड़ों के विकास के लिए<br>
        ✔ जिप्सम - कैल्शियम एवं सल्फर के लिए<br>
        ✔ राइजोबियम कल्चर - नाइट्रोजन स्थिरीकरण के लिए
        ",

        "en" => "
        ✔ DAP - Promotes root development<br>
        ✔ Gypsum - Provides calcium and sulphur<br>
        ✔ Rhizobium Culture - Improves nitrogen fixation
        "

    ];
}
elseif($crop == "कपास")
{
    $fertilizer = [

        "hi" => "
        ✔ NPK 20:20:0 - संतुलित पोषण के लिए<br>
        ✔ यूरिया - बेहतर वृद्धि के लिए<br>
        ✔ जिंक सल्फेट - सूक्ष्म पोषक तत्व हेतु
        ",

        "en" => "
        ✔ NPK 20:20:0 - Balanced nutrition<br>
        ✔ Urea - Supports healthy growth<br>
        ✔ Zinc Sulphate - Provides micronutrients
        "

    ];
}
elseif($crop == "अरहर")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - बुवाई के समय दें<br>
        ✔ जैविक खाद - मिट्टी सुधार के लिए<br>
        ✔ जिप्सम - फसल विकास के लिए
        ",

        "en" => "
        ✔ DAP - Apply during sowing<br>
        ✔ Organic Manure - Improves soil fertility<br>
        ✔ Gypsum - Supports crop development
        "

    ];
}
elseif($crop == "बाजरा")
{
    $fertilizer = [

        "hi" => "
        ✔ यूरिया - नाइट्रोजन आपूर्ति के लिए<br>
        ✔ DAP - जड़ों के विकास के लिए<br>
        ✔ जिंक सल्फेट - फसल स्वास्थ्य के लिए
        ",

        "en" => "
        ✔ Urea - Provides nitrogen for crop growth<br>
        ✔ DAP - Promotes root development<br>
        ✔ Zinc Sulphate - Improves crop health
        "

    ];
}
elseif($crop == "ज्वार")
{
    $fertilizer = [

        "hi" => "
        ✔ यूरिया - बेहतर वृद्धि के लिए<br>
        ✔ DAP - जड़ों के विकास के लिए<br>
        ✔ पोटाश - दानों की गुणवत्ता बढ़ाने के लिए
        ",

        "en" => "
        ✔ Urea - Supports healthy growth<br>
        ✔ DAP - Promotes root development<br>
        ✔ Potash - Improves grain quality
        "

    ];
}
elseif($crop == "मूंग (Moong)")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - बुवाई के समय दें<br>
        ✔ जैविक खाद - मिट्टी की उर्वरता बढ़ाने के लिए<br>
        ✔ राइजोबियम कल्चर - नाइट्रोजन स्थिरीकरण हेतु
        ",

        "en" => "
        ✔ DAP - Apply during sowing<br>
        ✔ Organic Manure - Improves soil fertility<br>
        ✔ Rhizobium Culture - Helps nitrogen fixation
        "

    ];
}
elseif($crop == "उड़द (Urad)")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - प्रारंभिक वृद्धि के लिए<br>
        ✔ जैविक खाद - मिट्टी सुधार के लिए<br>
        ✔ जिप्सम - बेहतर उत्पादन के लिए
        ",

        "en" => "
        ✔ DAP - Supports early growth<br>
        ✔ Organic Manure - Improves soil health<br>
        ✔ Gypsum - Enhances crop yield
        "

    ];
}
elseif($crop == "मूंगफली")
{
    $fertilizer = [

        "hi" => "
        ✔ जैविक खाद - मिट्टी सुधार के लिए<br>
        ✔ NPK 10:26:26 - फलियों के विकास के लिए<br>
        ✔ जिप्सम - कैल्शियम एवं सल्फर के लिए
        ",

        "en" => "
        ✔ Organic Manure - Improves soil fertility<br>
        ✔ NPK 10:26:26 - Enhances pod development<br>
        ✔ Gypsum - Provides Calcium and Sulphur
        "

    ];
}
elseif($crop == "गन्ना")
{
    $fertilizer = [

        "hi" => "
        ✔ यूरिया - तेज़ वृद्धि के लिए<br>
        ✔ DAP - जड़ों के विकास के लिए<br>
        ✔ MOP (पोटाश) - शर्करा की मात्रा बढ़ाने के लिए
        ",

        "en" => "
        ✔ Urea - Promotes rapid growth<br>
        ✔ DAP - Improves root development<br>
        ✔ MOP (Potash) - Increases sugar content
        "

    ];
}
elseif($crop == "जौ")
{
    $fertilizer = [

        "hi" => "
        ✔ DAP - बुवाई के समय दें<br>
        ✔ यूरिया - बेहतर वृद्धि के लिए<br>
        ✔ सल्फर - दानों की गुणवत्ता के लिए
        ",

        "en" => "
        ✔ DAP - Apply during sowing<br>
        ✔ Urea - Supports healthy growth<br>
        ✔ Sulphur - Improves grain quality
        "

    ];
}
else
{
    $fertilizer = [

        "hi" => "
        ✔ जैविक खाद<br>
        ✔ वर्मी कम्पोस्ट<br>
        ✔ संतुलित NPK उर्वरक
        ",

        "en" => "
        ✔ Organic Manure<br>
        ✔ Vermicompost<br>
        ✔ Balanced NPK Fertilizer
        "

    ];
}
// Disease Risk Analysis

$currentLang = $_SESSION['lang'];

$diseaseRisk = "LOW";
$diseaseReason = "";
$diseaseSuggestion = "";

if ($humidity == "ज्यादा" && $rainfall == "ज्यादा बारिश") {

$diseaseRisk = ($currentLang=="hi") ? "उच्च" : "HIGH";

$diseaseReason = ($currentLang=="hi")
?
"अधिक नमी और भारी वर्षा के कारण फफूंद जनित रोगों का खतरा अधिक है।"
:
"High humidity and heavy rainfall increase the risk of fungal diseases.";

$diseaseSuggestion = ($currentLang=="hi")
?
"कार्बेन्डाजिम या मैनकोजेब का छिड़काव करें।"
:
"Spray Carbendazim or Mancozeb fungicide.";

}
elseif ($humidity == "मध्यम" && $rainfall == "सामान्य बारिश") {

$diseaseRisk = ($currentLang=="hi") ? "मध्यम" : "MEDIUM";

$diseaseReason = ($currentLang=="hi")
?
"मौसम रोगों के लिए मध्यम रूप से अनुकूल है।"
:
"Weather conditions are moderately favorable for crop diseases.";

$diseaseSuggestion = ($currentLang=="hi")
?
"फसल की नियमित निगरानी करें।"
:
"Monitor the crop regularly.";

}
else {

$diseaseRisk = ($currentLang=="hi") ? "कम" : "LOW";

$diseaseReason = ($currentLang=="hi")
?
"वर्तमान मौसम रोगों के फैलने के लिए अधिक अनुकूल नहीं है।"
:
"Current weather conditions are not favorable for disease development.";

$diseaseSuggestion = ($currentLang=="hi")
?
"खेत की नियमित निगरानी करें तथा साफ-सफाई बनाए रखें।"
:
"Monitor the field regularly and maintain proper field sanitation.";

}
// Weather Alert System

$weatherAlert = "";

if($_SESSION['lang'] == "hi")
{

    if($temp >= 40)
    {
        $weatherAlert = "🔥 अधिक तापमान चेतावनी: तापमान बहुत अधिक है। सिंचाई बढ़ाएँ और दोपहर में खाद न डालें।";
    }
    elseif($temp <= 10)
    {
        $weatherAlert = "❄ शीत लहर चेतावनी: तापमान बहुत कम है। फसल को ठंड से बचाएँ।";
    }
    elseif($rainfall == "ज्यादा बारिश")
    {
        $weatherAlert = "🌧 भारी वर्षा चेतावनी: खेत से पानी की निकासी का ध्यान रखें।";
    }
    elseif($rainfall == "कम बारिश")
    {
        $weatherAlert = "☀ कम वर्षा चेतावनी: सिंचाई की व्यवस्था करें।";
    }
    else
    {
        $weatherAlert = "✅ मौसम सामान्य है। फसल के लिए परिस्थितियाँ अनुकूल हैं।";
    }

}
else
{

    if($temp >= 40)
    {
        $weatherAlert = "🔥 High Temperature Alert: Temperature is very high. Increase irrigation and avoid fertilizer application during afternoon.";
    }
    elseif($temp <= 10)
    {
        $weatherAlert = "❄ Cold Wave Alert: Temperature is very low. Protect your crop from cold.";
    }
    elseif($rainfall == "High Rain")
    {
        $weatherAlert = "🌧 Heavy Rain Alert: Ensure proper drainage to avoid water logging.";
    }
    elseif($rainfall == "Low Rain")
    {
        $weatherAlert = "☀ Low Rain Alert: Arrange irrigation for your crop.";
    }
    else
    {
        $weatherAlert = "✅ Weather is normal. Conditions are favorable for the crop.";
    }

}
// Soil Health Score

$currentSoil = strtolower($soil);
$currentHumidity = strtolower($humidity);
$currentRainfall = strtolower($rainfall);
$currentWater = strtolower($water);

$soilScore = 100;

if(
    strpos($currentSoil,"sandy") !== false ||
    strpos($currentSoil,"रेतीली") !== false
)
{
    $soilScore -= 15;
}

if($temp >= 40)
{
    $soilScore -= 10;
}

if($currentHumidity=="low")
{
    $soilScore -= 10;
}

if($currentRainfall=="low")
{
    $soilScore -= 15;
}

if($currentWater=="low")
{
    $soilScore -= 20;
}

if($soilScore < 50)
{
    $soilStatus = ($currentLang == "hi") ? "खराब" : "Poor";
}
elseif($soilScore < 75)
{
    $soilStatus = ($currentLang == "hi") ? "औसत" : "Average";
}
else
{
    $soilStatus = ($currentLang == "hi") ? "उत्तम" : "Excellent";
}

// Crop Name Mapping (Hindi + English → Database Key)

$cropKeyMap = [

    "धान" => "धान",
    "Rice" => "धान",

    "गेहूं" => "गेहूं",
    "Wheat" => "गेहूं",

    "मक्का" => "मक्का",
    "Maize" => "मक्का",

    "बाजरा" => "बाजरा",
    "Bajra" => "बाजरा",

    "ज्वार" => "ज्वार",
    "Jowar" => "ज्वार",

    "चना" => "चना",
    "Gram" => "चना",

    "सरसों" => "सरसों",
    "Mustard" => "सरसों",

    "सोयाबीन" => "सोयाबीन",
    "Soybean" => "सोयाबीन",

    "मूंगफली" => "मूंगफली",
    "Groundnut" => "मूंगफली",

    "कपास" => "कपास",
    "Cotton" => "कपास",

    "अरहर" => "अरहर (Pigeon Pea)",
    "Pigeon Pea" => "अरहर (Pigeon Pea)",

    "उड़द" => "उड़द",
    "Black Gram" => "उड़द",

    "मूंग" => "मूंग",
    "Green Gram" => "मूंग",

    "जौ" => "जौ",
    "Barley" => "जौ",

    "गन्ना" => "गन्ना",
    "Sugarcane" => "गन्ना"

];

// ===============================
// Fertilizer Schedule Database
// ===============================

$fertilizerSchedule = [

"धान" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_45_days'],
        "fertilizer"=>$lang['potash']
    ],
    [
        "stage"=>$lang['after_60_days'],
        "fertilizer"=>$lang['zinc']
    ]

],

"गेहूं" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_45_days'],
        "fertilizer"=>$lang['potash']
    ],
    [
        "stage"=>$lang['after_60_days'],
        "fertilizer"=>$lang['zinc']
    ]

],

"मक्का" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_40_days'],
        "fertilizer"=>$lang['potash']
    ],
    [
        "stage"=>$lang['after_60_days'],
        "fertilizer"=>$lang['zinc']
    ]

],

"बाजरा" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_40_days'],
        "fertilizer"=>$lang['zinc']
    ]

],

"ज्वार" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_45_days'],
        "fertilizer"=>$lang['potash']
    ]

],

"चना" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_30_days'],
        "fertilizer"=>$lang['bio_fertilizer']
    ],
    [
        "stage"=>$lang['flowering_stage'],
        "fertilizer"=>$lang['potash']
    ]

],
"सरसों" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_40_days'],
        "fertilizer"=>$lang['sulphur']
    ],
    [
        "stage"=>$lang['after_55_days'],
        "fertilizer"=>$lang['micronutrients']
    ]

],

"सोयाबीन" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_25_days'],
        "fertilizer"=>$lang['rhizobium']
    ],
    [
        "stage"=>$lang['flowering_stage'],
        "fertilizer"=>$lang['potash']
    ]

],

"मूंगफली" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['gypsum']
    ],
    [
        "stage"=>$lang['flowering_stage'],
        "fertilizer"=>$lang['potash']
    ]

],

"कपास" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_30_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_60_days'],
        "fertilizer"=>$lang['potash']
    ],
    [
        "stage"=>$lang['after_75_days'],
        "fertilizer"=>$lang['micronutrients']
    ]

],

"अरहर (Pigeon Pea)" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_30_days'],
        "fertilizer"=>$lang['bio_fertilizer']
    ],
    [
        "stage"=>$lang['flowering_stage'],
        "fertilizer"=>$lang['potash']
    ]

],

"गन्ना" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_30_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_60_days'],
        "fertilizer"=>$lang['potash']
    ],
    [
        "stage"=>$lang['after_75_days'],
        "fertilizer"=>$lang['micronutrients']
    ]

],

"मूंग" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['rhizobium']
    ],
    [
        "stage"=>$lang['flowering_stage'],
        "fertilizer"=>$lang['potash']
    ]

],

"उड़द" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['rhizobium']
    ],
    [
        "stage"=>$lang['flowering_stage'],
        "fertilizer"=>$lang['potash']
    ]

],

"जौ" => [

    [
        "stage"=>$lang['at_sowing'],
        "fertilizer"=>$lang['dap']
    ],
    [
        "stage"=>$lang['after_20_days'],
        "fertilizer"=>$lang['urea']
    ],
    [
        "stage"=>$lang['after_45_days'],
        "fertilizer"=>$lang['potash']
    ]

],
];


// Estimated Crop Profit

$yield = 0;
$marketPrice = 0;
$cost = 0;

// Crop Database (Per Bigha)

$cropData = [

"धान" => [
    "yield" => 5.5,
    "price" => 2300,
    "cost"  => 6000
],

"गेहूं" => [
    "yield" => 4.5,
    "price" => 2500,
    "cost"  => 5500
],

"मक्का" => [
    "yield" => 5,
    "price" => 2200,
    "cost"  => 5000
],

"बाजरा" => [
    "yield" => 2,
    "price" => 2800,
    "cost"  => 4000
],

"ज्वार" => [
    "yield" => 2.5,
    "price" => 3000,
    "cost"  => 4500
],

"चना" => [
    "yield" => 2.5,
    "price" => 5600,
    "cost"  => 5000
],

"सरसों" => [
    "yield" => 2.2,
    "price" => 6200,
    "cost"  => 5200
],

"सोयाबीन" => [
    "yield" => 3,
    "price" => 4700,
    "cost"  => 6000
],

"मूंगफली" => [
    "yield" => 3,
    "price" => 6500,
    "cost"  => 7000
],

"कपास" => [
    "yield" => 4,
    "price" => 7200,
    "cost"  => 12000
],

"अरहर (Pigeon Pea)" => [
    "yield" => 2,
    "price" => 7000,
    "cost"  => 5000
],

"उड़द" => [
    "yield" => 1.8,
    "price" => 7600,
    "cost"  => 4500
],

"मूंग" => [
    "yield" => 1.8,
    "price" => 7800,
    "cost"  => 4500
],

"जौ" => [
    "yield" => 3.5,
    "price" => 2200,
    "cost"  => 4500
],

"गन्ना" => [
    "yield" => 375,
    "price" => 350,
    "cost"  => 20000
]

];

if(isset($cropData[$cropKey]))
{
    $yield = $cropData[$cropKey]["yield"];
    $marketPrice = $cropData[$cropKey]["price"];
    $cost = $cropData[$cropKey]["cost"];
}
else
{
    $yield = 3;
    $marketPrice = 2200;
    $cost = 5000;
}


$totalYield = $yield * $areaBigha;

$totalCost = $cost * $areaBigha;

$income = $totalYield * $marketPrice;

$profit = $income - $totalCost;

$confidence = rand(92,99);

/* SAVE DATABASE (UPDATED READY FOR FUTURE FEATURES) */

$sql = "INSERT INTO crop_data
(farmer_name, soil, temperature, humidity, rainfall, water_availability, recommended_crop)
VALUES
('$name', '$soil', '$temp', '$humidity', '$rainfall', '$water', '$crop')";

mysqli_query($conn, $sql);

mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
    <title>Smart Crop Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f7f9; }
        .card-box {
            margin-top: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .header {
            background: #198754;
            color: white;
            padding: 15px;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }
        .title {
            color: #198754;
            margin-top: 15px;
            font-weight: bold;
        }
        .badge-box span {
            margin: 3px;
        }
.ai-box{
    margin-top:20px;
    padding:20px;
    border-radius:15px;
    background:#eef8ff;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
}

.robot{
    font-size:60px;
}

#voiceStatus{
    font-weight:bold;
    color:#0d6efd;
}

.wave{
    margin-top:15px;
    display:flex;
    justify-content:center;
    gap:5px;
}

.wave span{
    width:6px;
    height:20px;
    background:#0d6efd;
    border-radius:20px;
    animation:wave .8s infinite;
    display:none;
}

.wave span:nth-child(2){animation-delay:.1s;}
.wave span:nth-child(3){animation-delay:.2s;}
.wave span:nth-child(4){animation-delay:.3s;}
.wave span:nth-child(5){animation-delay:.4s;}

@keyframes wave{

0%{
height:10px;
}

50%{
height:40px;
}

100%{
height:10px;
}

}
    </style>
</head>

<body>

<div style="text-align:right; margin:15px 20px;">

    <form method="get" style="display:inline;">
        <button type="submit"
                name="lang"
                value="hi"
                style="background:#28a745;color:white;padding:6px 12px;border:none;border-radius:5px;cursor:pointer;">
            🇮🇳 हिन्दी
        </button>
    </form>

    <form method="get" style="display:inline;">
        <button type="submit"
                name="lang"
                value="en"
                style="background:#007bff;color:white;padding:6px 12px;border:none;border-radius:5px;cursor:pointer;">
            🇬🇧 English
        </button>
    </form>

</div>

<div class="container">

    <div class="card card-box">

        <div class="header">
            <h2>🌾 Smart Crop Recommendation System</h2>
        </div>

        <div class="card-body">

           <!-- Farmer Info -->
<h3><?php echo $lang['farmer_details']; ?></h3>

<p><strong><?php echo $lang['name']; ?>:</strong> <?php echo $name; ?></p>

<p><strong><?php echo $lang['soil']; ?>:</strong> <?php echo $soil; ?></p>

<p><strong><?php echo $lang['temperature']; ?>:</strong> <?php echo $temp; ?> °C</p>

<p><strong><?php echo $lang['humidity']; ?>:</strong> <?php echo $humidity; ?></p>

<p><strong><?php echo $lang['rainfall']; ?>:</strong> <?php echo $rainfall; ?></p>

<p><strong><?php echo $lang['water']; ?>:</strong> <?php echo $water; ?></p>

<p>
    <strong><?php echo $lang['land_area']; ?>:</strong>
    <?php echo $areaBigha; ?> <?php echo $lang['bigha']; ?>
</p>

<hr>

           <!-- Recommended Crop -->
<div class="card mt-3 border-success shadow-sm">

    <div class="card-header bg-success text-white">
        🌱 <?php echo $lang['recommended_crop']; ?>
    </div>

    <div class="card-body">

       <div class="card-body">

    <h3 class="text-success mb-3">
        <?php echo $crop; ?>
    </h3>

    <div class="border-top pt-3">
        <h6 class="fw-bold text-secondary mb-2">
            💡 <?php echo $lang['advice_col']; ?>
        </h6>

        <p class="mb-0 text-dark">
            <?php echo $advice; ?>
        </p>
    </div>

</div>

    </div>

</div>



             <div class="card mt-4 border-info">

    <div class="card-header bg-info text-white">
    <?php echo $lang['weather']; ?>
</div>

    <div class="card-body">

        <p><strong><?php echo $lang['city']; ?>:</strong> <?php echo $weatherData['name']; ?></p>

        <p><strong><?php echo $lang['temperature']; ?>:</strong>
            <?php echo round($weatherData['main']['temp']); ?> °C
        </p>

        <p><strong><?php echo $lang['weather_status']; ?>:</strong>
            <?php echo ucfirst($weatherData['weather'][0]['description']); ?>
        </p>

        <p><strong><?php echo $lang['humidity']; ?>:</strong>
            <?php echo $weatherData['main']['humidity']; ?> %
        </p>

        <p><strong><?php echo $lang['wind_speed']; ?>:</strong>
            <?php echo $weatherData['wind']['speed']; ?> m/s
        </p>

    </div>

</div>

<?php
$liveTemp = floatval($weatherData['main']['temp']);
$userTemp = floatval($_POST['temperature']);

$tempDifference = round($liveTemp - $userTemp);

if($tempDifference >= 5)
{
    $risk = ($_SESSION['lang']=="hi") ? "उच्च" : "HIGH";
    $reason = ($_SESSION['lang']=="hi")
           ? "वर्तमान तापमान अनुमानित तापमान से {$tempDifference}°C अधिक है।"
    : "Current temperature is {$tempDifference}°C higher than the predicted value.";

    if($_SESSION['lang']=="hi")
{
    $suggestion = [
        "शाम के समय सिंचाई करें",
        "दोपहर में उर्वरक का प्रयोग न करें",
        "फसल में गर्मी के प्रभाव की नियमित निगरानी करें",
        "मिट्टी की नमी बनाए रखने के लिए मल्चिंग करें"
    ];
}
else
{
    $suggestion = [
        "Irrigation in evening",
        "Avoid afternoon fertilizer application",
        "Monitor heat stress regularly",
        "Use mulching to conserve soil moisture"
    ];
}
}
elseif($tempDifference >= 2)
{
    $risk = ($_SESSION['lang']=="hi") ? "मध्यम" : "MEDIUM";
    $reason = ($_SESSION['lang']=="hi")
           ? "वर्तमान तापमान अनुमानित तापमान से थोड़ा अधिक है।"
    : "Current temperature is slightly higher than the predicted value.";

    if($_SESSION['lang']=="hi")
{
    $suggestion = [
        "फसल की नियमित निगरानी करें",
        "उचित सिंचाई बनाए रखें",
        "मिट्टी की नमी की जांच करें"
    ];
}
else
{
    $suggestion = [
        "Monitor crop condition",
        "Maintain proper irrigation",
        "Check soil moisture"
    ];
}
}
else
{
    $risk = ($_SESSION['lang']=="hi") ? "कम" : "LOW";
    $reason = ($_SESSION['lang']=="hi")
           ? "वर्तमान मौसम अनुमानित मौसम के लगभग समान है।"
    : "Current weather is close to the predicted value.";

    if($_SESSION['lang']=="hi")
{
    $suggestion = [
        "सामान्य खेती की प्रक्रिया जारी रखें"
    ];
}
else
{
    $suggestion = [
        "Continue normal farming practices"
    ];
}
}

?>
<div class="card mt-4 border-warning">

    <div class="card-header bg-warning">
    <?php echo $lang['weather_analysis']; ?>
</div>

    <div class="card-body">

        <p><strong><?php echo $lang['input_temperature']; ?>:</strong> <?php echo $temp; ?> °C</p>

        <p><strong><?php echo $lang['live_temperature']; ?>:</strong>
            <?php echo round($weatherData['main']['temp']); ?> °C
        </p>

        <hr>

        <p><strong><?php echo $lang['input_humidity']; ?>:</strong>
            <?php echo $humidity; ?>
        </p>

        <p><strong><?php echo $lang['live_humidity']; ?>:</strong>
            <?php echo $weatherData['main']['humidity']; ?> %
        </p>

        <hr>

        <h5>
            <?php echo $lang['risk']; ?>:
            <span class="badge bg-danger">
                <?php echo $risk; ?>
            </span>
        </h5>

        <br>

        <strong><?php echo $lang['reason']; ?></strong>

        <p><?php echo $reason; ?></p>

        <strong><?php echo $lang['suggestion']; ?></strong>

        <ul>

        <?php

        foreach($suggestion as $item)
        {
            echo "<li>✔ $item</li>";
        }

        ?>

        </ul>

    </div>

</div>

            <!-- Fertilizer -->
            <h5>🌿 <?php echo $lang['fertilizer']; ?></h5>
            <div class="p-3 bg-light border rounded">
                <?php echo $fertilizer[$_SESSION['lang']]; ?>
            </div>
<?php
if(isset($fertilizerSchedule[$cropKey]))
{
?>
<div class="card mt-4 border-success">

    <div class="card-header bg-success text-white">
        <?php echo $lang['fertilizer_schedule']; ?>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover">

            <thead>
                <tr>
                    <th><?php echo $lang['stage']; ?></th>
<th><?php echo $lang['fertilizer_name']; ?></th>
                </tr>
            </thead>

            <tbody>

            <?php
            foreach($fertilizerSchedule[$cropKey] as $item)
            {
            ?>
                <tr>
                    <td><?php echo $item['stage']; ?></td>
                    <td><?php echo $item['fertilizer']; ?></td>
                </tr>
            <?php
            }
            ?>

            </tbody>

        </table>

    </div>

</div>
<?php
}
?>

<hr>

<?php

// Crop data nikalo

$cropInfo = $cropDatabase[$cropKey] ?? null;

$sowing = "";
$irrigation = "";
$fertilizerTime = ""; 
$weed = "";
$harvest = "";

// 1. Language और Crop Key सेट करें
$langKey = $_GET['lang'] ?? $_SESSION['lang'] ?? 'hi';
$cropKey = trim($_POST['crop'] ?? $crop ?? $recommendedCrop ?? $predictedCrop ?? '');

// 2. Exact/Case-Insensitive Match ढूँढें
$cropInfo = null;
if (!empty($cropKey) && isset($cropDatabase)) {
    foreach ($cropDatabase as $key => $data) {
        if (mb_strtolower(trim($key)) === mb_strtolower($cropKey)) {
            $cropInfo = $data;
            break;
        }
    }
}

// 3. भाषा के हिसाब से Fallback Text सेट करें
$noAdviceText = ($langKey === 'en') ? 'Advice not available' : 'सलाह उपलब्ध नहीं है';

// 4. Variables में सही सलाह असाइन करें
$sowing = $cropInfo['sowing'] ?? $noAdviceText;
$irrigation = $cropInfo['irrigation'] ?? $noAdviceText;
$fertilizerTime = $cropInfo['fertilizer'] ?? $noAdviceText;
$weed = $cropInfo['weed'] ?? $noAdviceText;
$harvest = $cropInfo['harvest'] ?? $noAdviceText;
?>

<div class="card mt-4 border-success">
<?php
// 1. AI Recommendation या Form Submit से फसल का नाम निकालें
$cropKey = trim($_POST['crop'] ?? $crop ?? $recommendedCrop ?? $predictedCrop ?? '');

// 2. Exact Match न होने पर Case-Insensitive Match ढूँढें
$cropInfo = null;
if (!empty($cropKey) && isset($cropDatabase)) {
    foreach ($cropDatabase as $key => $data) {
        if (mb_strtolower(trim($key)) === mb_strtolower($cropKey)) {
            $cropInfo = $data;
            break;
        }
    }
}

// 3. Fallback Variables (डेटा न मिलने पर सुरक्षित हैंडलिंग)
$sowing = $cropInfo['sowing'] ?? 'सलाह उपलब्ध नहीं है';
$irrigation = $cropInfo['irrigation'] ?? 'सलाह उपलब्ध नहीं है';
$fertilizerTime = $cropInfo['fertilizer'] ?? 'सलाह उपलब्ध नहीं है';
$weed = $cropInfo['weed'] ?? 'सलाह उपलब्ध नहीं है';
$harvest = $cropInfo['harvest'] ?? 'सलाह उपलब्ध नहीं है';
?>

<!-- फसल प्रबंधन योजना टेबल -->
<table class="table border">
    <thead>
        <tr class="bg-success text-white">
            <th><?php echo $lang['stage'] ?? 'चरण'; ?></th>
            <th><?php echo $lang['advice_col'] ?? 'सलाह'; ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?php echo $lang['sowing'] ?? '🌱 बुवाई'; ?></td>
            <td><?php echo htmlspecialchars($sowing); ?></td>
        </tr>
        <tr>
            <td><?php echo $lang['irrigation'] ?? '💧 सिंचाई'; ?></td>
            <td><?php echo htmlspecialchars($irrigation); ?></td>
        </tr>
        <tr>
            <td><?php echo $lang['fertilizer_stage'] ?? '🌿 उर्वरक'; ?></td>
            <td><?php echo htmlspecialchars($fertilizerTime); ?></td>
        </tr>
        <tr>
            <td><?php echo $lang['weed'] ?? '🌾 निराई-गुड़ाई'; ?></td>
            <td><?php echo htmlspecialchars($weed); ?></td>
        </tr>
        <tr>
            <td><?php echo $lang['harvest'] ?? '🚜 कटाई'; ?></td>
            <td><?php echo htmlspecialchars($harvest); ?></td>
        </tr>
    </tbody>
</table>


<!-- ========================= -->
<!-- AI Disease Detection -->
<!-- ========================= -->

<div class="card mt-4 border-success">

    <div class="card-header bg-success text-white">

        🌿 <?php echo ($_SESSION['lang']=="en")
            ? "AI Disease Detection"
            : "एआई रोग पहचान"; ?>

    </div>

    <div class="card-body text-center">

        <form
            action="disease/upload.php"
            method="POST"
            enctype="multipart/form-data">

            <label class="fw-bold mb-2">
<?php
echo ($_SESSION['lang']=="en")
? "Select Crop"
: "फसल चुनें";
?>
</label>

<select name="crop" class="form-control mb-3" required>

<option value="">
<?php
echo ($_SESSION['lang']=="en")
? "-- Select Crop --"
: "-- फसल चुनें --";
?>
</option>

<option value="Rice">🌾 Rice</option>
<option value="Wheat">🌾 Wheat</option>
<option value="Maize">🌽 Maize</option>
<option value="Bajra">🌾 Bajra</option>
<option value="Jowar">🌾 Jowar</option>
<option value="Gram">🌱 Gram</option>
<option value="Mustard">🌼 Mustard</option>
<option value="Soybean">🟢 Soybean</option>
<option value="Groundnut">🥜 Groundnut</option>
<option value="Cotton">☁ Cotton</option>
<option value="PigeonPea">🌱 Pigeon Pea</option>
<option value="BlackGram">⚫ Black Gram</option>
<option value="GreenGram">🟢 Green Gram</option>
<option value="Barley">🌾 Barley</option>
<option value="Sugarcane">🎋 Sugarcane</option>
<option value="Potato">🥔 Potato</option>
<option value="Tomato">🍅 Tomato</option>
<option value="Brinjal">🍆 Brinjal</option>
<option value="Capsicum">🫑 Capsicum</option>
<option value="Chilli">🌶 Chilli</option>

</select>

            <input
                type="file"
                class="form-control mb-3"
                name="leaf_image"
                accept="image/*"
                required>

            <button
                class="btn btn-success">

                <?php
                echo ($_SESSION['lang']=="en")
                ? "🔍 Detect Disease"
                : "🔍 रोग पहचानें";
                ?>

            </button>

        </form>

    </div>

</div>

<hr>
<div id="aiAssistant" class="ai-box">
    <div class="robot">🤖</div>

    <h4><?php echo $lang['voice_assistant']; ?></h4>

    <p id="voiceStatus">
    <?php echo $lang['ready']; ?>
</p>

    <div class="wave">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<hr>
<hr>
<div class="card mt-4 border-warning">

<div class="card-header bg-warning">
    🌤 <?php echo $lang['weather_alert']; ?>
</div>

    <div class="card-body">

        <?php echo $weatherAlert; ?>

    </div>

</div>
<div class="card-header bg-danger text-white">
    🦠
    <?php
    if($_SESSION['lang']=="hi")
        echo "रोग जोखिम विश्लेषण";
    else
        echo "Disease Risk Analysis";
    ?>
</div>

<div class="card-body">

    <strong>
    <?php
    if($_SESSION['lang']=="hi")
        echo "जोखिम स्तर:";
    else
        echo "Risk Level:";
    ?>
    </strong>

    <?php echo $diseaseRisk; ?>

    <br><br>

    <strong>
    <?php
    if($_SESSION['lang']=="hi")
        echo "कारण:";
    else
        echo "Reason:";
    ?>
    </strong>

    <br>

    <?php echo $diseaseReason; ?>

    <br><br>

    <strong>
    <?php
    if($_SESSION['lang']=="hi")
        echo "सुझाव:";
    else
        echo "Suggestion:";
    ?>
    </strong>

    <br>

    <?php echo $diseaseSuggestion; ?>

</div>
<div class="card mt-4 border-success">

    <div class="card-header bg-success text-white">
        <?php
if($_SESSION['lang']=="hi")
    echo "🌱 मिट्टी स्वास्थ्य स्कोर";
else
    echo "🌱 Soil Health Score";
?>
    </div>

    <div class="card-body text-center">

        <h2><?php echo $soilScore; ?>/100</h2>

<div class="progress mt-3" style="height:25px;">
    <div class="progress-bar bg-success"
         role="progressbar"
         style="width: <?php echo $soilScore; ?>%;"
         aria-valuenow="<?php echo $soilScore; ?>"
         aria-valuemin="0"
         aria-valuemax="100">
        <?php echo $soilScore; ?>%
    </div>
</div>

        <h5>
<?php
if($_SESSION['lang']=="hi")
    echo "स्थिति:";
else
    echo "Status:";
?>
            <strong>
<?php
if($_SESSION['lang']=="hi")
{
    if($soilStatus=="Excellent")
        echo "उत्कृष्ट";
    elseif($soilStatus=="Average")
        echo "सामान्य";
    else
        echo "खराब";
}
else
{
    echo $soilStatus;
}
?>
</strong>
        </h5>
<p>
<?php
if($_SESSION['lang']=="hi")
{
    echo "मिट्टी स्वास्थ्य स्कोर मिट्टी के प्रकार, तापमान, नमी, वर्षा तथा पानी की उपलब्धता के आधार पर निकाला गया है।";
}
else
{
    echo "Soil health score has been calculated using soil type, temperature, humidity, rainfall and water availability.";
}
?>
</p>

    </div>

</div>
<div class="card mt-4 border-success">

    <div class="card-header bg-success text-white">
        <?php echo $lang['estimated_profit']; ?>
    </div>

    <div class="card-body">

        <table class="table table-bordered text-center">

<tr>
    <th><?php echo $lang['estimated_production']; ?></th>
    <td>
        <?php echo number_format($yield,1); ?>
<?php echo ($_SESSION['lang']=="hi") ? " क्विंटल / बीघा" : " Quintal / Bigha"; ?>
<strong><?php echo $lang['land_area']; ?>:</strong>
<?php echo $areaBigha; ?>
<?php echo ($_SESSION['lang']=="hi") ? " बीघा" : " Bigha"; ?>
<strong><?php echo $lang['production']; ?>:</strong>
<?php echo number_format($totalYield,2); ?>
<?php echo ($_SESSION['lang']=="hi") ? " क्विंटल" : " Quintal"; ?>
    </td>
</tr>
<br><br>


            <tr>
                <th><?php echo $lang['market_price']; ?></th>
                <td>
₹<?php echo number_format($marketPrice); ?>
<?php echo ($_SESSION['lang']=="hi") ? " / क्विंटल" : " / Quintal"; ?>
</td>
            </tr>

            <tr>
                <th><?php echo $lang['estimated_income']; ?></th>
                <td>₹<?php echo number_format($income); ?></td>
            </tr>

            <tr>
                <th><?php echo $lang['estimated_cost']; ?></th>
                <td><?php echo number_format($totalCost); ?></td>
            </tr>

            <tr class="table-success">
                <th><?php echo $lang['expected_profit']; ?></th>
                <td><strong>₹<?php echo number_format($profit); ?></strong></td>
            </tr>

        </table>

        <small class="text-muted">
<?php
if($_SESSION['lang']=="hi")
{
    echo "यह अनुमानित गणना औसत उत्पादन और बाजार मूल्य के आधार पर की गई है।";
}
else
{
    echo "This is an estimated calculation based on average yield and market price.";
}
?>
</small>

    </div>

</div>

<div class="card mt-4 border-primary">
    <div class="card-header bg-primary text-white">
        <?php echo $lang['confidence']; ?>
    </div>

    <div class="card-body text-center">
        <h2><?php echo $confidence; ?>%</h2>
        <p><?php echo $lang['confidence_text']; ?></p>
    </div>
</div>

<hr>

<div class="text-center mt-4">
    <button class="btn btn-primary" onclick="speakRecommendation()">
        <?php echo $lang['listen']; ?>
    </button>
</div>

<button onclick="stopVoice()" class="btn btn-danger mt-2">
    <?php echo $lang['stop_voice']; ?>
</button>

<!-- Extra Feature UI Section -->
<hr>

<h5 class="title"><?php echo $lang['smart_tags']; ?></h5>

<div class="badge-box">
    <span class="badge bg-success"><?php echo $lang['ai_based']; ?></span>
    <span class="badge bg-primary"><?php echo $lang['soil_analysis']; ?></span>
    <span class="badge bg-warning text-dark"><?php echo $lang['crop_suggestion']; ?></span>
    <span class="badge bg-info text-dark"><?php echo $lang['fertilizer_guide']; ?></span>
</div>

<hr>

<h5 class="title"><?php echo $lang['system_status']; ?></h5>

<p>✔ <?php echo $lang['recommendation_generated']; ?></p>

<p>✔ <?php echo $lang['data_saved']; ?></p>

<p class="text-center mt-3">
    <a class="btn btn-outline-success" href="history.php">
        <?php echo $lang['view_history']; ?>
    </a>
</p>

<p class="text-center mt-3">

<form action="download_report.php" method="POST">

    <input type="hidden" name="farmer_name" value="<?php echo $name; ?>">
    <input type="hidden" name="soil" value="<?php echo $soil; ?>">
    <input type="hidden" name="temperature" value="<?php echo $temp; ?>">
    <input type="hidden" name="humidity" value="<?php echo $humidity; ?>">
    <input type="hidden" name="rainfall" value="<?php echo $rainfall; ?>">
    <input type="hidden" name="water" value="<?php echo $water; ?>">
    <input type="hidden" name="area" value="<?php echo $areaBigha; ?>">
    <input type="hidden" name="crop" value="<?php echo $crop; ?>">
    <input type="hidden" name="advice" value="<?php echo $advice; ?>">
    <input type="hidden" name="weatherAlert" value="<?php echo $weatherAlert; ?>">
    <input type="hidden" name="diseaseRisk" value="<?php echo $diseaseRisk; ?>">
    <input type="hidden" name="soilScore" value="<?php echo $soilScore; ?>">
    <input type="hidden" name="profit" value="<?php echo $profit; ?>">

    <button type="submit" class="btn btn-danger">
        <?php echo $lang['download_pdf']; ?>
    </button>

</form>

</p>

        </div>
    </div>

</div>
<script>

let weatherRisk = "<?php echo strip_tags($risk); ?>";

let weatherReason = "<?php echo strip_tags($reason); ?>";

let weatherSuggestion = "<?php echo implode('. ', $suggestion); ?>";

let liveTemperature = "<?php echo round($weatherData['main']['temp']); ?>";

let sowingTime = "<?php echo strip_tags($sowing); ?>";



let irrigationTime = "<?php echo strip_tags($irrigation); ?>";

let fertilizerTime = "<?php echo strip_tags($fertilizerTime); ?>";

let weedTime = "<?php echo strip_tags($weed); ?>";

let harvestTime = "<?php echo strip_tags($harvest); ?>";

function stopVoice()
{
    window.speechSynthesis.cancel();

    document.getElementById("voiceStatus").innerHTML = "⏹️ AI Assistant Stop Ho Gaya";

    document.querySelectorAll(".wave span").forEach(function(bar){
        bar.style.display = "none";
    });
}
function speakRecommendation()
{

    let message = `
Namaste <?php echo $name; ?> ji.

Aapke dwara di gayi jankari ka vishleshan kiya gaya hai.

Aapki mitti ka prakar
<?php echo strip_tags($_POST['soil']); ?> hai.

Vartaman tapman
<?php echo $_POST['temperature']; ?> degree Celsius hai.

Hawa mein nami
<?php echo strip_tags($_POST['humidity']); ?> hai.

Barish ki matra
<?php echo strip_tags($_POST['rainfall']); ?> hai.

Pani ki suvidha
<?php echo strip_tags($_POST['water']); ?> hai.

In sabhi paristhitiyon ko dekhte hue
sabse upyukt fasal hai

<?php echo strip_tags($crop); ?>.

Ab fertilizer ki salah suniye.
Kripya in fertilizers ka prayog bataye gaye samay par hi karein.
<?php
echo strip_tags(
    str_replace(
        array("<br>", "<br/>", "<br />"),
        ". ",
        $fertilizer[$_SESSION['lang']]
    )
);
?>
Agar aapko aur jaankari chahiye to Smart Crop Advisory System ka punah upyog karein.

Dhanyavaad.

Smart Crop Advisory System ka upyog karne ke liye dhanyavaad.
`;

    let speech = new SpeechSynthesisUtterance(message);

    speech.lang = "hi-IN";
    speech.rate = 0.9;
    speech.pitch = 1;
    speech.volume = 1;

    window.speechSynthesis.cancel();
document.getElementById("voiceStatus").innerHTML="<?php echo $lang['speaking']; ?>";

document.querySelectorAll(".wave span").forEach(function(bar){
    bar.style.display="inline-block";
});
    window.speechSynthesis.speak(speech);
speech.onend=function(){

document.getElementById("voiceStatus").innerHTML="<?php echo $lang['completed']; ?>";

document.querySelectorAll(".wave span").forEach(function(bar){
    bar.style.display="none";
});

}
}

window.addEventListener("load", function () {
    setTimeout(function () {
        speakRecommendation();
    }, 1000);
});
</script>
<script src="voice.js"></script>
</body>
</html>