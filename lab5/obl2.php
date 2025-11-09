<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab5</title>
</head>
<body>
<?php
    echo '<style>
        html, body{
            padding: 0;
            margin: 0;
            width: 100%;
        }
        table{
            width: 100%;
            text-align: center;
        }
    </style>';
    $filePath = 'oblinfo.txt';
    $fileContents = file($filePath);
    $selectedOption = '';

    if(isset($_POST['selectedOption'])){
        $selectedOption = trim($_POST['selectedOption']);
    }
    echo '<table border="1"><tr><td>Область</td><td>Кількість населення, тис.</td><td>Кількість вузів</td><td>Кількість вузів на 100 тис.</td></tr>';
    for($i = 0; $i < count($fileContents); $i += 3){
        if(trim($fileContents[$i]) == $selectedOption){
            echo '<tr>
                <td style="width: 55%">'. $fileContents[$i] .'</td>
                <td style="width: 15%">'. $fileContents[$i + 1] .'</td>
                <td style="width: 15%">'. $fileContents[$i + 2] .'</td>
                <td style="width: 15%">'. round($fileContents[$i+2] / ($fileContents[$i + 1] / 100),2) .'</td>
            </tr>';
            break;
        }
    }
    echo '</table>'
?>
</body>
</html>
