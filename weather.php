<?php

function getWeather($city)
{

    $apiKey = "8202ce4a58d3a746be2af8eae9aef3bf";

    $url = "https://api.openweathermap.org/data/2.5/weather?q="
            . urlencode($city)
            . "&appid=".$apiKey
            . "&units=metric";

    $response = file_get_contents($url);

    if($response === FALSE)
    {
        return false;
    }

    $data = json_decode($response, true);

    return $data;

}

?>