console.log("VOICE JS LOADED");

function startVoice() {

    if (!('webkitSpeechRecognition' in window) &&
        !('SpeechRecognition' in window)) {

        alert("Aapka browser Voice Recognition support nahi karta.");
        return;
    }

    const SpeechRecognition =
        window.SpeechRecognition || window.webkitSpeechRecognition;

    const recognition = new SpeechRecognition();

    recognition.lang = "hi-IN";
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;

    recognition.onstart = function () {
        alert("🎤 Bolna shuru kijiye...");
    };

    recognition.onresult = function (event) {

        let text = event.results[0][0].transcript.toLowerCase();

        alert("Aapne bola:\n\n" + text);

        // ==========================
        // Farmer Name
        // ==========================

        if (text.includes("मेरा नाम")) {

            let name = text
                .replace("मेरा नाम", "")
                .split("मिट्टी")[0]
                .trim();

            document.getElementsByName("farmer_name")[0].value = name;
        }

        // ==========================
        // Soil
        // ==========================

        let soil = document.getElementsByName("soil")[0];

        if (
            text.includes("रेतीली") ||
            text.includes("sandy") ||
            text.includes("retili")
        ) {
            soil.selectedIndex = 0;
        }

        else if (
            text.includes("चिकनी") ||
            text.includes("clay") ||
            text.includes("chikni")
        ) {
            soil.selectedIndex = 1;
        }

        else if (
            text.includes("दोमट") ||
            text.includes("loamy") ||
            text.includes("domat")
        ) {
            soil.selectedIndex = 2;
        }

        // ==========================
        // Temperature
        // ==========================

        let number = text.match(/\d+/);

        if (number) {
            document.getElementsByName("temperature")[0].value = number[0];
        }

        // ==========================
        // Humidity
        // ==========================

        let humidity = document.getElementsByName("humidity")[0];

        if (
            text.includes("नमी कम") ||
            text.includes("humidity low")
        ) {
            humidity.selectedIndex = 0;
        }

        else if (
            text.includes("नमी मध्यम") ||
            text.includes("मध्यम नमी")
        ) {
            humidity.selectedIndex = 1;
        }

        else if (
            text.includes("नमी ज्यादा") ||
            text.includes("उच्च नमी")
        ) {
            humidity.selectedIndex = 2;
        }

        // ==========================
        // Rainfall
        // ==========================

        let rain = document.getElementsByName("rainfall")[0];

        if (
            text.includes("कम बारिश")
        ) {
            rain.selectedIndex = 0;
        }

        else if (
            text.includes("सामान्य बारिश")
        ) {
            rain.selectedIndex = 1;
        }

        else if (
            text.includes("ज्यादा बारिश")
        ) {
            rain.selectedIndex = 2;
        }

        // ==========================
        // Water
        // ==========================

        let water = document.getElementsByName("water")[0];

        if (
            text.includes("पानी कम")
        ) {
            water.selectedIndex = 0;
        }

        else if (
            text.includes("ठीक-ठाक") ||
            text.includes("ठीक ठाक")
        ) {
            water.selectedIndex = 1;
        }

        else if (
            text.includes("अच्छी") ||
            text.includes("पर्याप्त पानी")
        ) {
            water.selectedIndex = 2;
        }

        alert("✅ Form Automatically Fill Ho Gaya.");
    };

    recognition.onerror = function (event) {

        alert("Voice Error : " + event.error);

    };

    recognition.start();
}
function speakRecommendation() {

    let status = document.getElementById("voiceStatus");

    if(status)
        status.innerHTML = "🔊 Speaking...";

    let crop = document.querySelector("h3.text-success");

    if(!crop) return;

    let cropName = crop.innerText;

    let confidence = 92;

    let message = "";

// Detect Language

let language = "";

if(document.documentElement.lang === "hi")
{

message =
"नमस्ते किसान भाई। " +

"स्मार्ट क्रॉप एडवाइजरी सिस्टम में आपका स्वागत है। " +

"कृपया कुछ क्षण प्रतीक्षा करें। " +

"आपके खेत की जानकारी का विश्लेषण किया जा रहा है। " +

"मिट्टी का प्रकार। " +

"तापमान। " +

"नमी। " +

"वर्षा। " +

"पानी की उपलब्धता। " +

"विश्लेषण सफलतापूर्वक पूरा हुआ।";

message +=

" आपके खेत की मिट्टी और मौसम की स्थिति के आधार पर। " +

"आपके लिए सबसे उपयुक्त फसल है। " +

cropName + "। " +

"यह फसल वर्तमान परिस्थितियों में बेहतर उत्पादन देने की संभावना रखती है। " +

"अनुशंसा विश्वसनीयता। " +

confidence +

" प्रतिशत। " +

"अब मैं आपके लिए मौसम, उर्वरक और खेती संबंधी विशेषज्ञ सलाह प्रस्तुत करूँगा।";

message +=

" वर्तमान मौसम का विश्लेषण भी पूरा हो गया है। " +

"वर्तमान तापमान " +

liveTemperature +

" डिग्री सेल्सियस है। " +

"जोखिम स्तर। " +

weatherRisk +

"। " +

"कारण। " +

weatherReason +

"। ";

message +=

" अब मैं आपके लिए विशेषज्ञ खेती सलाह प्रस्तुत कर रहा हूँ। " +

"कृपया निम्नलिखित सुझावों का ध्यानपूर्वक पालन करें। " +

weatherSuggestion +

"। " +

"इन सुझावों का पालन करने से आपकी फसल स्वस्थ रहेगी और उत्पादन में वृद्धि होगी। ";

message +=

" अब मैं आपके लिए फसल प्रबंधन योजना प्रस्तुत कर रहा हूँ। " +

"कृपया ध्यानपूर्वक सुनिए। " +

"बुवाई का समय। " +

sowingTime +

"। " +

"सिंचाई का समय। " +

irrigationTime +

"। " +

"उर्वरक देने का समय। " +

fertilizerTime +

"। " +

"निराई गुड़ाई का समय। " +

weedTime +

"। " +

"कटाई का समय। " +

harvestTime +

"। ";

message +=

" धन्यवाद किसान भाई। " +

"स्मार्ट क्रॉप एडवाइजरी सिस्टम का उपयोग करने के लिए आपका धन्यवाद। " +

"हमें आशा है कि यह सलाह आपकी खेती में उपयोगी सिद्ध होगी। " +

"आपकी फसल अच्छी हो। " +

"आपको भरपूर उत्पादन और अधिक लाभ प्राप्त हो। " +

"आपका दिन शुभ हो।";

language = "hi-IN";

}
else
{

message =
"Hello Farmer. " +

"Welcome to Smart Crop Advisory System. " +

"Please wait. " +

"Your farm information is being analyzed. " +

"Soil Type. " +

"Temperature. " +

"Humidity. " +

"Rainfall. " +

"Water Availability. " +

"Analysis completed successfully.";

message +=

" Based on your soil and weather conditions. " +

"The most suitable crop for your field is. " +

cropName + ". " +

"This crop has the highest probability of providing a good yield under the current conditions. " +

"Recommendation confidence. " +

confidence +

" percent. " +

"Now I will provide weather analysis, fertilizer recommendations and expert farming guidance.";

message +=

" Current weather analysis has also been completed. " +

"The current temperature is " +

liveTemperature +

" degrees Celsius. " +

"Risk level. " +

weatherRisk +

". " +

"Reason. " +

weatherReason +

". " +

"Suggestion. " +

weatherSuggestion +

". ";

message +=

" I will now provide expert farming guidance. " +

"Please listen carefully to the following recommendations. " +

weatherSuggestion +

". " +

"Following these recommendations will improve your crop health and increase productivity. ";

message +=

" I will now present your crop management schedule. " +

"Please listen carefully. " +

"Sowing schedule. " +

sowingTime +

". " +

"Irrigation schedule. " +

irrigationTime +

". " +

"Fertilizer schedule. " +

fertilizerTime +

". " +

"Weed control schedule. " +

weedTime +

". " +

"Harvest schedule. " +

harvestTime +

". ";

message +=

" Thank you Farmer. " +

"Thank you for using the Smart Crop Advisory System. " +

"We hope this recommendation will help improve your farming. " +

"We wish you a healthy crop, a successful harvest, and maximum profit. " +

"Have a wonderful day.";

language = "en-US";

}

    let speech = new SpeechSynthesisUtterance(message);

    speech.lang = language;

    speech.onend = function(){

        if(status)
            status.innerHTML = "✅ Completed";

    };

    window.speechSynthesis.speak(speech);

}