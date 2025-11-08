<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Lab4</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <?php
        if (isset($_GET['specialization'])) {
            $spec = $_GET['specialization'];
            
            echo "<h2>Статистика по напрямку: " . htmlspecialchars($spec) . "</h2>";

            $handle = fopen("data.txt", "r");

            if ($handle) {
                $found = false;
                $line_counter = 0;
                $univ_count = 0;

                echo "<table>";
                echo "<thead>
                        <tr>
                            <th>N</th>
                            <th>Середня сума балів</th>
                            <th>Число поступивших на бюджет</th>
                            <th>Недобір</th>
                            <th>Число контрактників</th>
                            <th>ВНЗ</th>
                        </tr>
                      </thead>";
                echo "<tbody>";

                while (($line = fgets($handle)) !== false) {
                    $trimmed_line = trim($line);

                    if (!$found) {
                        if ($trimmed_line == $spec) {
                            $found = true;
                            $count_line = fgets($handle);
                            $univ_count = (int)trim($count_line);
                            break; 
                        }
                    }
                }

                if ($found && $univ_count > 0) {
                    
                    for ($i = 1; $i <= $univ_count; $i++) {
                        
                        $avg_score = trim(fgets($handle));
                        $budget_count = trim(fgets($handle));
                        $contract_line = trim(fgets($handle));
                        $univ_name = trim(fgets($handle));
                        
                        $contract_val = "-";
                        $shortfall_val = "-";
                        $contract_num = (int)$contract_line;
                        
                        if ($contract_num > 0) {
                            $contract_val = $contract_num;
                        } elseif ($contract_num < 0) {
                            $shortfall_val = abs($contract_num);
                        }
                        
                        echo "<tr>";
                        echo "<td>$i</td>";
                        echo "<td>$avg_score</td>";
                        echo "<td>$budget_count</td>";
                        echo "<td>$shortfall_val</td>";
                        echo "<td>$contract_val</td>";
                        echo "<td>" . htmlspecialchars($univ_name) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Напрямок не знайдено або дані відсутні.</td></tr>";
                }
                
                echo "</tbody></table>";
                fclose($handle); 
                
            } else {
                echo "<p>Помилка: не вдалося відкрити файл data.txt.</p>";
            }

        } else {
            echo "<h2>Будь ласка, оберіть напрямок на <a href='index.php'>головній сторінці</a>.</h2>";
        }
    ?>
    <br>
    <a href="index.php">Повернутися до вибору</a>
</div>

</body>
</html>
