<?php

$lang = [

    "title" => "🌾 Smart Crop Recommendation System",

    "farmer_details" => "👨‍🌾 Farmer Details",

    "recommended_crop" => "🌿 Recommended Crop",

    "advice" => "ℹ Advice",

    "weather" => "🌦 Live Weather",

    "weather_analysis" => "🌤 Weather Impact Analysis",

    "fertilizer" => "🌿 Fertilizer Recommendation",

    "crop_plan" => "🧑‍🌾 Crop Management Plan",

    "soil_score" => "🌱 Soil Health Score",

    "profit" => "💰 Estimated Profit",

    "confidence" => "🤖 AI Recommendation Confidence",

    "disease" => "🦠 Disease Risk Analysis",

    "city" => "City",

    "temperature" => "Temperature",

    "humidity" => "Humidity",

    "weather_status" => "Weather",

    "wind_speed" => "Wind Speed",

    "risk" => "Risk Level",

    "reason" => "Reason",

    "suggestion" => "Suggestion",

         "subtitle" => "Smart Crop Advisory System",

    "farmer_name" => "Farmer Name",

    "soil_type" => "Soil Type",

    "area" => "Land Area (Bigha)",

    "rainfall" => "Rainfall",

    "water" => "Water Availability",

    "predict" => "🌾 Predict Crop",

    "voice" => "🎤 Voice Assistant Start",

    "city_placeholder" => "Enter your city (e.g. Pilkhuwa)",

    "name_placeholder" => "Enter your name",

    "area_placeholder" => "e.g. 2.5",
    "input_temperature" => "Input Temperature",
   "live_temperature" => "Live Temperature",
"input_humidity" => "Input Humidity",
"live_humidity" => "Live Humidity",

"stage" => "Stage",
"advice_col" => "Advice",

"sowing" => "🌱 Sowing",
"irrigation" => "💧 Irrigation",
"fertilizer_stage" => "🌿 Fertilizer",
"weed" => "🌾 Weed Control",
"harvest" => "🚜 Harvest",

"voice_assistant" => "AI Voice Assistant",
"ready" => "Ready...",
"speaking" => "🤖 AI Assistant is Speaking...",
"completed" => "☑ Recommendation Complete",
"name" => "Name",
"soil" => "Soil",
"land_area" => "Land Area",
"bigha" => "Bigha",
"weather_alert" => "Weather Alert System",
"low_rain_alert" => "Low Rain Alert",
"high_temp_alert" => "High Temperature Alert",
"heavy_rain_alert" => "Heavy Rain Alert",
"estimated_profit" => "💰 Estimated Crop Profit",
"estimated_production" => "Estimated Production",
"market_price" => "Market Price",
"estimated_income" => "Estimated Income",
"estimated_cost" => "Estimated Cost",
"expected_profit" => "Expected Profit",
"land_area" => "Land Area",
"production" => "Total Production",
"quintal" => "Quintal",
"per_bigha" => "Per Bigha",
"confidence_text" => "This recommendation is highly reliable based on the provided inputs.",

"listen" => "🔊 Listen Recommendation",

"stop_voice" => "⏹ Stop Voice",

"smart_tags" => "📊 Smart Tags",

"ai_based" => "AI Based",

"soil_analysis" => "Soil Analysis",

"crop_suggestion" => "Crop Suggestion",

"fertilizer_guide" => "Fertilizer Guide",

"system_status" => "🖥 System Status",

"recommendation_generated" => "Recommendation Generated Successfully",

"data_saved" => "Data Saved in Database",

"view_history" => "📊 View Previous Records",

"download_pdf" => "📄 Download PDF Report",
"fertilizer_schedule" => "🌿 Fertilizer Schedule",
"stage" => "Stage",
"fertilizer_name" => "Fertilizer",

"at_sowing" => "🌱 At Sowing",
"after_20_days" => "⏳ After 20 Days",
"after_25_days" => "⏳ After 25 Days",
"after_30_days" => "⏳ After 30 Days",
"after_40_days" => "⏳ After 40 Days",
"after_45_days" => "⏳ After 45 Days",
"after_55_days" => "⏳ After 55 Days",
"after_60_days" => "⏳ After 60 Days",
"after_75_days" => "⏳ After 75 Days",
"flowering_stage" => "🌼 Flowering Stage",
"dap" => "DAP",
"urea" => "Urea",
"potash" => "Potash (MOP)",
"zinc" => "Zinc Sulphate",
"sulphur" => "Sulphur",
"gypsum" => "Gypsum",
"bio_fertilizer" => "Bio Fertilizer",
"rhizobium" => "Rhizobium Culture",
"micronutrients" => "Micronutrients"
];

$cropDatabase = [
    // 1. Rice
    "rice" => [
        "sowing" => "Transplant 20-25 days old seedlings with proper spacing.",
        "irrigation" => "Maintain 2-5 cm water level during transplanting and tillering stages.",
        "fertilizer" => "Apply Nitrogen in 3 split doses along with Zinc Sulphate.",
        "weed" => "Apply recommended herbicides within 3-5 days of transplanting.",
        "harvest" => "Stop irrigation when grains turn 80% golden and harvest."
    ],
    "धान" => [
        "sowing" => "Transplant 20-25 days old seedlings with proper spacing.",
        "irrigation" => "Maintain 2-5 cm water level during transplanting and tillering stages.",
        "fertilizer" => "Apply Nitrogen in 3 split doses along with Zinc Sulphate.",
        "weed" => "Apply recommended herbicides within 3-5 days of transplanting.",
        "harvest" => "Stop irrigation when grains turn 80% golden and harvest."
    ],

    // 2. Wheat
    "wheat" => [
        "sowing" => "Sow at 20-22 cm row distance at a depth of 4-5 cm.",
        "irrigation" => "Provide first irrigation at Crown Root Initiation stage (21 days after sowing).",
        "fertilizer" => "Apply balanced dose of Nitrogen, Phosphorus, and Potash.",
        "weed" => "Control broad and narrow leaf weeds at 30-35 days stage.",
        "harvest" => "Harvest when grains become hard and golden brown."
    ],
    "गेहूं" => [
        "sowing" => "Sow at 20-22 cm row distance at a depth of 4-5 cm.",
        "irrigation" => "Provide first irrigation at Crown Root Initiation stage (21 days after sowing).",
        "fertilizer" => "Apply balanced dose of Nitrogen, Phosphorus, and Potash.",
        "weed" => "Control broad and narrow leaf weeds at 30-35 days stage.",
        "harvest" => "Harvest when grains become hard and golden brown."
    ],

    // 3. Maize
    "maize" => [
        "sowing" => "Sow with 60 cm row-to-row and 20 cm plant-to-plant spacing.",
        "irrigation" => "Irrigate critical stages: knee-high stage and silking stage.",
        "fertilizer" => "Apply half Nitrogen at sowing and remaining as top dressing.",
        "weed" => "Perform earthing up and weeding at 20-25 days after sowing.",
        "harvest" => "Harvest when cob husk turns dry and brown."
    ],
    "मक्का" => [
        "sowing" => "Sow with 60 cm row-to-row and 20 cm plant-to-plant spacing.",
        "irrigation" => "Irrigate critical stages: knee-high stage and silking stage.",
        "fertilizer" => "Apply half Nitrogen at sowing and remaining as top dressing.",
        "weed" => "Perform earthing up and weeding at 20-25 days after sowing.",
        "harvest" => "Harvest when cob husk turns dry and brown."
    ],

    // 4. Bajra
    "bajra" => [
        "sowing" => "Maintain 45 cm row spacing and sow at a depth of 2-3 cm.",
        "irrigation" => "Irrigate 30-35 days after sowing (just before flowering stage).",
        "fertilizer" => "Apply DAP during sowing and Urea after 20-25 days.",
        "weed" => "Complete the first weeding at 15-20 days stage.",
        "harvest" => "Harvest earheads when grains become hard and dry."
    ],
    "बाजरा" => [
        "sowing" => "Maintain 45 cm row spacing and sow at a depth of 2-3 cm.",
        "irrigation" => "Irrigate 30-35 days after sowing (just before flowering stage).",
        "fertilizer" => "Apply DAP during sowing and Urea after 20-25 days.",
        "weed" => "Complete the first weeding at 15-20 days stage.",
        "harvest" => "Harvest earheads when grains become hard and dry."
    ],

    // 5. Jowar
    "jowar" => [
        "sowing" => "Sow at 45 cm row spacing and 3-4 cm depth.",
        "irrigation" => "Avoid moisture stress during flowering and grain formation.",
        "fertilizer" => "Use balanced doses of Urea and DAP.",
        "weed" => "Perform one weeding 20 days after sowing.",
        "harvest" => "Harvest when leaves turn yellow and grains harden."
    ],
    "ज्वार" => [
        "sowing" => "Sow at 45 cm row spacing and 3-4 cm depth.",
        "irrigation" => "Avoid moisture stress during flowering and grain formation.",
        "fertilizer" => "Use balanced doses of Urea and DAP.",
        "weed" => "Perform one weeding 20 days after sowing.",
        "harvest" => "Harvest when leaves turn yellow and grains harden."
    ],

    // 6. Gram
    "gram" => [
        "sowing" => "Sow in rows 30 cm apart at a depth of 7-8 cm.",
        "irrigation" => "Give light irrigation before flowering (30-35 days); avoid during flowering.",
        "fertilizer" => "Apply Phosphorus and Rhizobium culture treatment at sowing.",
        "weed" => "Remove weeds 25-30 days after sowing.",
        "harvest" => "Harvest when plants turn yellowish-brown and pods dry up."
    ],
    "चना" => [
        "sowing" => "Sow in rows 30 cm apart at a depth of 7-8 cm.",
        "irrigation" => "Give light irrigation before flowering (30-35 days); avoid during flowering.",
        "fertilizer" => "Apply Phosphorus and Rhizobium culture treatment at sowing.",
        "weed" => "Remove weeds 25-30 days after sowing.",
        "harvest" => "Harvest when plants turn yellowish-brown and pods dry up."
    ],

    // 7. Mustard
    "mustard" => [
        "sowing" => "Sow lightly maintaining 30 cm row spacing.",
        "irrigation" => "Irrigate at flowering stage (30 days) and pod filling stage.",
        "fertilizer" => "Apply Sulphur to increase oil content in seeds.",
        "weed" => "Thin out dense plants at 20-25 days to maintain proper distance.",
        "harvest" => "Harvest when 75% of pods turn golden yellow."
    ],
    "सरसों" => [
        "sowing" => "Sow lightly maintaining 30 cm row spacing.",
        "irrigation" => "Irrigate at flowering stage (30 days) and pod filling stage.",
        "fertilizer" => "Apply Sulphur to increase oil content in seeds.",
        "weed" => "Thin out dense plants at 20-25 days to maintain proper distance.",
        "harvest" => "Harvest when 75% of pods turn golden yellow."
    ],

    // 8. Soybean
    "soybean" => [
        "sowing" => "Sow treated seeds at 45 cm row spacing.",
        "irrigation" => "Ensure no waterlogging; provide light irrigation during pod formation.",
        "fertilizer" => "Apply DAP and Sulphur at the time of sowing.",
        "weed" => "Complete weeding within 20-25 days.",
        "harvest" => "Harvest when leaves shed and pods become dry."
    ],

    // 9. Groundnut
    "groundnut" => [
        "sowing" => "Sow in friable soil with 30 cm row spacing.",
        "irrigation" => "Maintain adequate moisture during pegging stage.",
        "fertilizer" => "Apply Gypsum for better pod development.",
        "weed" => "Do not weed during pegging stage; clear weeds prior to it.",
        "harvest" => "Harvest when leaves yellow by uprooting and drying."
    ],

    // 10. Cotton
    "cotton" => [
        "sowing" => "Sow seeds at 60-90 cm spacing in pits or rows.",
        "irrigation" => "Provide regular irrigation during flowering and boll formation.",
        "fertilizer" => "Apply Nitrogen and Potash in split doses.",
        "weed" => "Keep the field weed-free for the first 60 days.",
        "harvest" => "Pick cotton when bolls fully open and dry."
    ],

    // 11. Pigeon Pea
    "pigeon pea" => [
        "sowing" => "Sow on ridges with 60-75 cm row spacing.",
        "irrigation" => "Irrigate during flowering and pod development stages.",
        "fertilizer" => "Apply recommended doses of Phosphorus and Sulphur.",
        "weed" => "Perform two weedings during the first 45 days.",
        "harvest" => "Harvest when 80% of pods turn brown."
    ],

    // 12. Black Gram
    "black gram" => [
        "sowing" => "Sow at shallow depth maintaining 30 cm row distance.",
        "irrigation" => "Provide 1-2 light irrigations as needed.",
        "fertilizer" => "Apply Phosphorus at sowing time.",
        "weed" => "Perform first weeding at 20 days.",
        "harvest" => "Harvest when pods turn black."
    ],

    // 13. Green Gram
    "green gram" => [
        "sowing" => "Sow in moist soil at 30 cm row distance.",
        "irrigation" => "Maintain moisture during flowering and pod filling.",
        "fertilizer" => "Treat seed with Rhizobium culture and apply DAP.",
        "weed" => "Keep field weed-free during 15-20 days stage.",
        "harvest" => "Harvest when 80% of pods turn dark brown or black."
    ],

    // 14. Barley
    "barley" => [
        "sowing" => "Sow at 22 cm row distance and 4-5 cm depth.",
        "irrigation" => "First irrigation after 30 days and second at grain formation.",
        "fertilizer" => "Use balanced amounts of Urea and DAP.",
        "weed" => "Spray herbicides at 30 days stage.",
        "harvest" => "Harvest when crop becomes completely golden and dry."
    ],

    // 15. Sugarcane
    "sugarcane" => [
        "sowing" => "Plant 2 or 3-eyed setts in furrows spaced 75-90 cm apart.",
        "irrigation" => "Irrigate at 10-15 day intervals during hot summer.",
        "fertilizer" => "Apply adequate Nitrogen, DAP, and Potash in split doses.",
        "weed" => "Regular weeding and earthing up during early growth stage.",
        "harvest" => "Harvest close to ground level when mature."
    ],

    // 16. Potato
    "potato" => [
        "sowing" => "Plant tubers on ridges spaced 50-60 cm apart.",
        "irrigation" => "Light but regular irrigation during tuber initiation.",
        "fertilizer" => "Apply good amount of Potash to increase tuber size.",
        "weed" => "Earth up soil and remove weeds at 25-30 days stage.",
        "harvest" => "Dig out tubers 10 days after foliage dries."
    ],

    // 17. Tomato
    "tomato" => [
        "sowing" => "Transplant healthy seedlings with 60x45 cm spacing.",
        "irrigation" => "Provide drip or light regular irrigation.",
        "fertilizer" => "Spray Calcium and Potash to prevent blossom end rot.",
        "weed" => "Weed regularly and provide staking to plants.",
        "harvest" => "Harvest when fruits turn orange-red."
    ],

    // 18. Brinjal
    "brinjal" => [
        "sowing" => "Transplant at 60x60 cm spacing in well-prepared soil.",
        "irrigation" => "Irrigate every 4-5 days depending on weather.",
        "fertilizer" => "Apply organic manure and balanced Nitrogen.",
        "weed" => "Perform weeding and hoeing at 20-25 days.",
        "harvest" => "Harvest glossy and tender fruits."
    ],

    // 19. Capsicum
    "capsicum" => [
        "sowing" => "Transplant on ridges with 60x45 cm spacing.",
        "irrigation" => "Maintain uniform moisture; avoid waterlogging.",
        "fertilizer" => "Foliar spray of micronutrients for higher yield.",
        "weed" => "Use plastic mulching or manual hand weeding.",
        "harvest" => "Harvest firm and deep green fruits."
    ]
];
?>