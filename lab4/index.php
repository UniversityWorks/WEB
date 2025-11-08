<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Lab4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <h2>Виберіть напрямок навчання:</h2>

        <form action="data.php" method="GET">
            <?php
                $directions = file('napr.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                
                sort($directions, SORT_STRING);
                
                foreach ($directions as $direction) {
                    echo "<label>";
                    echo "<input type='radio' name='specialization' value='$direction' required>";
                    echo htmlspecialchars($direction); 
                    echo "</label><br>";
                }
            ?>
            
            <br>
            <input type="submit" value="Отправить запрос">
        </form>
    </div>

</body>
</html>
