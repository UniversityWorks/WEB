<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Прогноз погоди</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
require 'get_weather.php';
$city_id = isset($_GET['city']) ? $_GET['city'] : '4944';
$weather_data = get_weather_data($city_id);
?>

<div class="weather-panel">
    <h1>Прогноз для міста: <?php echo $weather_data['city']; ?></h1>
    <div class="weather-info">
        <p><strong>Дата:</strong> <?php echo date('d.m.Y'); ?></p>
        <p><strong>Схід сонця:</strong> <?php echo $weather_data['sunrise']; ?></p>
        <p><strong>Захід сонця:</strong> <?php echo $weather_data['sunset']; ?></p>
        <p><strong>Тривалість дня:</strong> <?php echo $weather_data['duration']; ?></p>
    </div>

    <h2>Температура протягом дня:</h2>
    <div class="temperature-details">
        <?php foreach ($weather_data['temperatures'] as $hour => $temperature): ?>
            <div class="temperature-item">
                <span><?php echo $hour; ?>:00</span> 
                <span><?php echo $temperature; ?> °C</span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
