<!DOCTYPE html>

<html>
    <head>
        <meta charset='utf-8'>
        <title>Работники</title>

        <link rel='stylesheet' href='css/style.css'>
    </head>
    <body>
        <table class='workers-table'>
            <tr>
                <th>ПІБ</th>
                <th>Вік</th>
                <th>Освіта</th>
                <th>Стаж роботи</th>
            </tr>
            
            <?php 
                /*
                    формуємо таблицю з данних массиву
                */

                foreach($arr as $worker)
                {
                    //рядки таблиці
                    $rowStr = '';

                    // css класси для рядка
                    $rowClass = '';
                    // css класси для комірки "Вік"
                    $ageClass = '';

                    // формування атрибутів class для елементів таблиці
                    if($worker['education'][0] === 3)
                    {
                        $rowClass .= 'higher-education ';
                    }

                    if($worker['work_experience'] < 3)
                    {
                        $rowClass .= 'beginner ';
                    }
                
                    if(($worker['age'] >= 15) && ($worker['age'] <= 24))
                    {
                        $ageClass .= 'early-working-age ';
                    }

                    if(($worker['age'] >= 25) && ($worker['age'] <= 54))
                    {
                        $ageClass .= 'average-working-age ';
                    }

                    if(($worker['age'] >= 55) && ($worker['age'] <= 64))
                    {
                        $ageClass .= 'mature-working-age ';
                    }

                    // формування рядків таблиці
                    $rowStr .= "<tr class='{$rowClass}'>";
                    $rowStr .= "<td>{$worker['fullname']}</td>";
                    $rowStr .= "<td class='{$ageClass}'>{$worker['age']}</td>";
                    $rowStr .= "<td>{$worker['education'][1]}</td>";
                    $rowStr .= "<td>{$worker['work_experience']}</td>";
                    $rowStr .= "</tr>";

                    // показ таблиці
                    echo $rowStr;
               }


            ?>
        </table>
    </body>
</html>
