<?php
function get_weather_data() {
    $url = 'https://meteofor.com.ua/ru/weather-wardenburg-2885/';
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $out = curl_exec($curl);
    curl_close($curl);
    $out = mb_convert_encoding($out, 'UTF-8');
    
    if (!$out) {
        die("Не вдалося отримати дані з сайту.");
    }
    preg_match("/<div class=\"page-title\">(.*?)<\/div>/s", $out, $matches);
    $city = isset($matches[1]) ? $matches[1] : 'Невідоме місто';
    preg_match("/<div class=\"astro-sun\">.*?<div.*?>(Схід|Восход)\s*—\s*(\d{1,2}:\d{2}).*?<\/div>/su", $out, $sunrise_matches);
    $sunrise = isset($sunrise_matches[2]) ? $sunrise_matches[2] : 'Невідомий час сходу';
    preg_match("/<div class=\"astro-sun\">.*?(Захід|Заход)\s*—\s*(\d{2}:\d{2}).*?<\/div>/su", $out, $sunset_matches);
    $sunset = isset($sunset_matches[2]) ? $sunset_matches[2] : 'Невідомий час заходу';
    if ($sunrise !== 'Невідомий час сходу' && $sunset !== 'Невідомий час заходу') {
        $sunrise_time = strtotime($sunrise);
        $sunset_time = strtotime($sunset);
        $day_duration_seconds = $sunset_time - $sunrise_time;
        $hours = floor($day_duration_seconds / 3600);
        $minutes = floor(($day_duration_seconds % 3600) / 60);
        $duration = "{$hours} год {$minutes} хв";
    } else {
        $duration = 'Невідома тривалість дня';
    }
    preg_match_all("/<div class=\"value\".*?>\s*<temperature-value value=\"(.*?)\" from-unit=\"c\"/su", $out, $temperature_matches);
    $temperatures = isset($temperature_matches[1]) ? $temperature_matches[1] : [];
    $temperatures = array_slice($temperatures, 6);
    $hours = [1, 4, 7, 10, 13, 16, 19, 22];
    $temperature_data = [];
    foreach ($hours as $index => $hour) {
        $temperature_data[$hour] = isset($temperatures[$index]) ? $temperatures[$index] : 'Невідомо';
    }
    return [
        'city' => $city,
        'sunrise' => $sunrise,
        'sunset' => $sunset,
        'duration' => $duration,
        'temperatures' => $temperature_data
    ];
}
?>
