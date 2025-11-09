<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab5</title>
</head>
<body>
<?php
    $filePath = 'oblinfo.txt';
    $fileContents = file($filePath);
    echo '<form  method="post" action="obl2.php">
          <select name="selectedOption">';

    for($i = 0; $i < count($fileContents); $i += 3){
        echo '<option value="'.$fileContents[$i].'">'.$fileContents[$i].'</option>';
    }

    echo '</select><br>
          <button style="margin-top: 10px;" name="submit">Відправити запит</button>
          </form>';
?>
</body>
</html>
