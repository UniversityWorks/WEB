<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab3</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php
    $fileName = 'oblinfo.txt';
    $fileHandle = fopen($fileName, 'r');

    if ($fileHandle) {
        echo '<table border="1">'.
            '<tr>
                <td style="width: 5%">N</td>
                <td style="width: 50%">Область</td>
                <td style="width: 15%; padding-left: 80px; padding-right: 80px;">Населення тис.</td>
                <td style="width: 15%; padding-left: 80px; padding-right: 80px;">Кількість вузлів</td>
                <td style="width: 15%; padding-left: 50px; padding-right: 50px;">Кількість вузлів на 100 тис. населення</td>
            </tr>';

        $n = 0;
        while (!feof($fileHandle)) {
            $region = trim(fgets($fileHandle));
            $population = trim(fgets($fileHandle));
            $nodes = trim(fgets($fileHandle));

            if ($region !== '' && $population !== '' && $nodes !== '') {
                $nodesPer100k = round($nodes / ($population / 100), 2);
                echo '<tr>' .
                     '<td>' . $n++                  . '</td>' .
                     '<td>' . htmlspecialchars($region)     . '</td>' .
                     '<td>' . htmlspecialchars($population) . '</td>' .
                     '<td>' . htmlspecialchars($nodes)      . '</td>' .
                     '<td>' . htmlspecialchars($nodesPer100k) . '</td>' .
                 '</tr>';
            }
        }

        echo '</table>';
        fclose($fileHandle);
    } 
    ?>
</body>
</html>
