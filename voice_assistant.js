const startBtn = document.getElementById("voiceStartBtn");
const SpeechRecognition =
window.SpeechRecognition || window.webkitSpeechRecognition;

const recognition = new SpeechRecognition();

recognition.lang = "hi-IN";
recognition.continuous = false;
recognition.interimResults = false;
let currentStep = "name";

function speak(message)
{
    const msg = new SpeechSynthesisUtterance();

    msg.lang = "hi-IN";
    msg.rate = 1;
    msg.pitch = 1;

    msg.text = message;

    msg.onend = function ()
    {
        recognition.start();
    };

    speechSynthesis.speak(msg);
}

startBtn.addEventListener("click", function () {

    const msg = new SpeechSynthesisUtterance();

    msg.lang = "hi-IN";
    msg.rate = 1;
    msg.pitch = 1;

    msg.text =
    "नमस्ते किसान भाई। मैं आपका स्मार्ट कृषि सहायक हूँ। सबसे पहले अपना नाम बताइए।";

    msg.onend = function ()
    {
        recognition.start();
    };

    speechSynthesis.speak(msg);

});

recognition.onresult = function(event)
{
    let text = event.results[0][0].transcript.toLowerCase();

    console.log(text);

    // ==========================
    // STEP 1 : NAME
    // ==========================
    if(currentStep === "name")
    {
        document.querySelector('input[name="farmer_name"]').value = text;

        currentStep = "soil";

        const msg = new SpeechSynthesisUtterance();

        msg.lang = "hi-IN";
        msg.text = "अब मिट्टी का प्रकार बताइए।";

        msg.onend = function()
        {
            recognition.start();
        };

        speechSynthesis.speak(msg);

        return;
    }

    // ==========================
    // STEP 2 : SOIL
    // ==========================

    let soil = document.querySelector('select[name="soil"]');

    if(currentStep === "soil")
    {

        if(text.includes("रेती"))
            soil.value = "sandy";

        else if(text.includes("दोमट"))
            soil.value = "loamy";

        else if(text.includes("चिकनी"))
            soil.value = "clay";

        else if(text.includes("काली"))
            soil.value = "black";

        else if(text.includes("लाल"))
            soil.value = "red";

        else if(text.includes("जलोढ़"))
            soil.value = "alluvial";

        currentStep = "temperature";

        const msg = new SpeechSynthesisUtterance();

        msg.lang = "hi-IN";
        msg.text = "अब तापमान बताइए।";

        msg.onend = function()
        {
            recognition.start();
        };

        speechSynthesis.speak(msg);

        return;
    }

// ==========================
// STEP 3 : TEMPERATURE
// ==========================

if(currentStep === "temperature")
{

    let number = text.match(/\d+/);

    if(number)
    {
        document.querySelector('input[name="temperature"]').value = number[0];
    }

    currentStep = "humidity";

    const msg = new SpeechSynthesisUtterance();

    msg.lang = "hi-IN";
    msg.text =
    "अब नमी बताइए। कम, मध्यम या ज्यादा।";

    msg.onend = function()
    {
        recognition.start();
    };

    speechSynthesis.speak(msg);

    return;

}
// ==========================
// STEP 4 : HUMIDITY
// ==========================

if(currentStep === "humidity")
{

    let humidity = document.querySelector('select[name="humidity"]');

    if(text.includes("कम"))
    {
        humidity.value = "low";
    }
    else if(text.includes("मध्यम"))
    {
        humidity.value = "medium";
    }
    else if(text.includes("ज्यादा"))
    {
        humidity.value = "high";
    }

    currentStep = "rainfall";

    const msg = new SpeechSynthesisUtterance();

    msg.lang = "hi-IN";
    msg.text =
    "अब वर्षा बताइए। कम, सामान्य या ज्यादा।";

    msg.onend = function()
    {
        recognition.start();
    };

    speechSynthesis.speak(msg);

    return;

}
// ==========================
// STEP 5 : RAINFALL
// ==========================

if(currentStep === "rainfall")
{
    let rainfall = document.querySelector('select[name="rainfall"]');

    if(text.includes("कम"))
    {
        rainfall.selectedIndex = 0;
    }
    else if(text.includes("सामान्य"))
    {
        rainfall.selectedIndex = 1;
    }
    else if(text.includes("अधिक") || text.includes("ज्यादा"))
    {
        rainfall.selectedIndex = 2;
    }

    currentStep = "water";

    const msg = new SpeechSynthesisUtterance();

    msg.lang = "hi-IN";
    msg.text = "अब पानी की उपलब्धता बताइए। कम, मध्यम या पर्याप्त।";

    msg.onend = function()
    {
        recognition.start();
    };

    speechSynthesis.speak(msg);

    return;
}
else if (currentStep === "water") {

    let water = document.querySelector('select[name="water"]');

    if (
        text.includes("कम") ||
        text.includes("कम पानी")
    ) {
        water.value = "low";
    }
    else if (
        text.includes("ठीक") ||
        text.includes("ठीक ठाक") ||
        text.includes("ठीक-ठाक") ||
        text.includes("मध्यम")
    ) {
        water.value = "moderate";
    }
    else if (
        text.includes("अच्छी") ||
        text.includes("अधिक") ||
        text.includes("पूरा") ||
        text.includes("पर्याप्त") ||
        text.includes("हाँ") ||
        text.includes("हां")
    ) {
        water.value = "good";
    }

    currentStep = "area";

const msg = new SpeechSynthesisUtterance();

msg.lang = "hi-IN";
msg.text = "अपनी खेती का क्षेत्रफल बताइए। उदाहरण के लिए दो दशमलव पाँच बीघा।";

msg.onend = function () {
    recognition.start();   // AI ke bolne ke baad hi mic start hoga
};

speechSynthesis.speak(msg);

return;
}
// ==========================
// STEP 7 : AREA
// ==========================

if (currentStep === "area") {

    let area = document.querySelector('input[name="area"]');

    text = text
.replace("बीघा","")
.replace("बीगा","")
.replace("बिघा","")
.replace("एकड़","")
.trim();

    let areaValue = "";

    // Direct number
    let number = text.match(/\d+(\.\d+)?/);

    if (number) {
        areaValue = number[0];
    }
    else {

        if (text.includes("एक")) areaValue = "1";
        else if (text.includes("दो")) areaValue = "2";
        else if (text.includes("तीन")) areaValue = "3";
        else if (text.includes("चार")) areaValue = "4";
        else if (text.includes("पाँच")) areaValue = "5";
        else if (text.includes("छह")) areaValue = "6";
        else if (text.includes("सात")) areaValue = "7";
        else if (text.includes("आठ")) areaValue = "8";
        else if (text.includes("नौ")) areaValue = "9";
        else if (text.includes("दस")) areaValue = "10";

        // Common decimal
        if (text.includes("ढाई")) areaValue = "2.5";
    }

    area.value = areaValue;

    currentStep = "city";

    speak("अब अपना शहर बताइए।");
    return;
}
// =========================
// STEP 8 : CITY
// =========================

if (currentStep == "city") {

    let city = document.querySelector('input[name="city"]');

    city.value = text;

    speak("धन्यवाद। आपकी फसल सलाह तैयार की जा रही है।");

    setTimeout(function () {

        document.querySelector("form").submit();

    },2500);

    return;
}
};