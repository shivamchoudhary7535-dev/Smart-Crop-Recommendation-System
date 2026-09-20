<?php

session_start();

if(isset($_GET['lang']))
{
    $_SESSION['lang'] = $_GET['lang'];
}

if(!isset($_SESSION['lang']))
{
    $_SESSION['lang'] = "hi";
}

require_once "language/" . $_SESSION['lang'] . ".php";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Smart Crop Advisory System</title>
    <link rel="stylesheet" href="farmer.css">

    <style>
        .voice-btn {
            background: orange;
            color: white;
            border: none;
            padding: 6px 10px;
            margin-left: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <h1><?php echo $lang['title']; ?></h1>

    <div style="text-align:right; margin-bottom:15px;">

    <a href="?lang=hi"
       style="padding:8px 15px;background:#28a745;color:white;text-decoration:none;border-radius:5px;">
       🇮🇳 हिन्दी
    </a>

    <a href="?lang=en"
       style="padding:8px 15px;background:#007bff;color:white;text-decoration:none;border-radius:5px;margin-left:8px;">
       🇬🇧 English
    </a>

</div>
    <h2><?php echo $lang['subtitle']; ?></h2>

    <form action="result.php" method="post">

        <!-- Farmer Name -->
        <label><?php echo $lang['farmer_name']; ?></label>

        <input type="text" name="farmer_name" placeholder="अपना नाम लिखें">

        <br><br>

        <!-- Soil Type -->
<label><?php echo $lang['soil_type']; ?></label>

<select name="soil">

<option value="sandy">
<?php echo ($_SESSION['lang']=="hi") ? "रेतीली मिट्टी" : "Sandy Soil"; ?>
</option>

<option value="loamy">
<?php echo ($_SESSION['lang']=="hi") ? "दोमट मिट्टी" : "Loamy Soil"; ?>
</option>

<option value="clay">
<?php echo ($_SESSION['lang']=="hi") ? "चिकनी मिट्टी" : "Clay Soil"; ?>
</option>

<option value="black">
<?php echo ($_SESSION['lang']=="hi") ? "काली मिट्टी" : "Black Soil"; ?>
</option>

<option value="red">
<?php echo ($_SESSION['lang']=="hi") ? "लाल मिट्टी" : "Red Soil"; ?>
</option>

<option value="alluvial">
<?php echo ($_SESSION['lang']=="hi") ? "जलोढ़ मिट्टी" : "Alluvial Soil"; ?>
</option>

</select>

<br><br>

        <!-- Temperature -->
        <label><?php echo $lang['temperature']; ?></label>

<input
    type="number"
    name="temperature"
    class="form-control"
    value="25"
    required
    placeholder="e.g. 25">

<br><br>

        <!-- Humidity -->
        <label><?php echo $lang['humidity']; ?></label>

<select name="humidity">

<option value="low">
<?php echo ($_SESSION['lang']=="hi") ? "कम" : "Low"; ?>
</option>

<option value="medium">
<?php echo ($_SESSION['lang']=="hi") ? "मध्यम" : "Medium"; ?>
</option>

<option value="high">
<?php echo ($_SESSION['lang']=="hi") ? "ज्यादा" : "High"; ?>
</option>

</select>

<br><br>

        <!-- Rainfall -->
        <label><?php echo $lang['rainfall']; ?></label>

<select name="rainfall">

<option value="low">
<?php echo ($_SESSION['lang']=="hi") ? "कम बारिश" : "Low Rainfall"; ?>
</option>

<option value="normal">
<?php echo ($_SESSION['lang']=="hi") ? "सामान्य बारिश" : "Normal Rainfall"; ?>
</option>

<option value="high">
<?php echo ($_SESSION['lang']=="hi") ? "अधिक बारिश" : "High Rainfall"; ?>
</option>

</select>

<br><br>

<!-- Water Availability -->
<label><?php echo $lang['water']; ?></label>

<select name="water">

<option value="low">
<?php echo ($_SESSION['lang']=="hi") ? "कम" : "Low"; ?>
</option>

<option value="moderate">
<?php echo ($_SESSION['lang']=="hi") ? "ठीक-ठाक" : "Moderate"; ?>
</option>

<option value="good">
<?php echo ($_SESSION['lang']=="hi") ? "अच्छी" : "Good"; ?>
</option>

</select>

<br><br>

<!-- Cultivation Area -->
<label><?php echo $lang['area']; ?></label>

<input
    type="number"
    name="area"
    step="0.1"
    min="0.1"
    placeholder="जैसे 2.5">

<br><br>

<div class="mb-3">
    <label class="form-label">🏙️ City</label>
    <input
        type="text"
        name="city"
        class="form-control"
        placeholder="Enter your city (e.g. Muzaffarnagar)"
        required>
</div>



        <!-- Submit Button -->
        <button type="submit">
    <?php echo $lang['predict']; ?>
</button>
<div style="text-align:center; margin-top:15px;">
    <button
        type="button"
        id="voiceStartBtn"
        class="voice-btn">
        <?php echo $lang['voice']; ?>
    </button>
</div>

    </form>

<script src="voice.js"></script>
<script src="voice_assistant.js"></script>
</body>
</html>
