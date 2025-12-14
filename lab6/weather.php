<?php
header('Content-Type: text/html; charset=utf-8');

function getPageContent($link) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

$html = getPageContent('http://www.gismeteo.ua/city/hourly/5053/'); 


function getCityName($html) {
    if (preg_match('~<h1>(.*?)</h1>~u', $html, $matches)) {
        return strip_tags($matches[1]);
    }
    return "Не знайдено";
}


function getCurrentDate($html) {
    if (preg_match('~<div class="current-time"[^>]*>(.*?)</div>~u', $html, $matches)) {
        return trim($matches[1]);
    }
    return date("d.m.Y");
}

function getSunriseAndSunset($html) {
    $sunrise = "--:--";
    $sunset = "--:--";
    
    if (preg_match('~Восход\s*—\s*(\d{1,2}:\d{2})~u', $html, $m)) {
        $sunrise = $m[1];
    }
    if (preg_match('~Заход\s*—\s*(\d{1,2}:\d{2})~u', $html, $m)) {
        $sunset = $m[1];
    }
    
    return [$sunrise, $sunset];
}


function getDayLength($html) {
    if (preg_match('~Долгота дня:\s*(\d+)\s*ч\s*(\d+)\s*мин~u', $html, $matches)) {
        $h = $matches[1];
        $m = $matches[2];
        return "{$h} год {$m} хв"; 
    }
    return "Не знайдено";
}


function getTemperatureInfo($html) {
    $temps = [];
    
    if (preg_match('~data-row="temperature-air"(.*?)</div>\s*</div>~s', $html, $block_match)) {
        $block_html = $block_match[1];
        

        if (preg_match_all('~<temperature-value value="([^"]+)"~u', $block_html, $matches)) {
            $temps = $matches[1]; 
        }
    }
    
    return $temps; 
}


$cityName = getCityName($html);
$dateInfo = getCurrentDate($html);
list($sunrise, $sunset) = getSunriseAndSunset($html);
$dayLen = getDayLength($html);
$temperatures = getTemperatureInfo($html);


?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Погода <?php echo $cityName; ?></title>
    <link rel="stylesheet" href="../css/style6.css">
</head>
<body>

    <div class="main-wrapper">
        
        <div class="weather-card">
            <h1 class="city-name">Погода у місті <?php echo $cityName; ?></h1>
            <div class="date-info"><?php echo $dateInfo; ?></div>

            <div class="astro-info">
                <div class="astro-item">
                    <span class="astro-label">Схід сонця</span>
                    <span class="astro-value">☀ <?php echo $sunrise; ?></span>
                </div>
                <div class="astro-item">
                    <span class="astro-label">Захід сонця</span>
                    <span class="astro-value">🌙 <?php echo $sunset; ?></span>
                </div>
            </div>

            <div class="day-length">
                Тривалість світлого часу: <span><?php echo $dayLen; ?></span>
            </div>

            <div class="temp-section-title">Прогноз температури</div>
            <table class="temp-table">
                <thead>
                    <tr>
                        <th>00:00</th>
                        <th>03:00</th>
                        <th>06:00</th>
                        <th>09:00</th>
                        <th>12:00</th>
                        <th>15:00</th>
                        <th>18:00</th>
                        <th>21:00</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php 
                        foreach ($temperatures as $t) {
                            $val = intval($t);
                            $colorStyle = ($val > 0) ? 'color: #e74c3c;' : 'color: #3498db;';
                            echo "<td style='{$colorStyle}'>{$t}&deg;</td>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="../header.php" class="button">Головна</a>
    
    </div>

</body>
</html>