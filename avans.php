<?php 
  /***************************************************/
 /*Отчет по внесенным авансам по заказам брони*/
/***************************************************/

include ("lib/db_Restart.php");
$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы
$db= new orange\db_Restart ($config,1);

		$tsql= "SELECT 
			 ord.[DateRsrv],
             ord.[NameRsrv],
             ord.[AvansCard],
             ord.[AvansSum]
            FROM [dbo].[tb_Order] as ord
            WHERE ord.[AvansSum] <> 0
            ORDER BY ord.[DateRsrv]";
 

$order= $db->query($tsql);


//var_dump($order);
?>

<!Doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Авансы по заказам</title>
    <style>
        .cellmoney {
            text-align: right;
        }
        table {
            margin: auto;
        }
        td {
            text-align: left;
        }
        #main {
            text-align: center;
            font-family: sans-serif;
            font-size: 14pt;
            margin: auto;
        }
    </style>
</head>
	<body>
        <div id="main">
            <table>
                <tr>
                    <th>Дата банкета</th>  <th>Заказчик</th> <th>Карта</th> <th>Сумма аванса </th>
                </tr>
    <?php
                foreach ($order as $value) {
                   echo '<tr><td>'. $value["DateRsrv"]->format("d.m.Y").'</td><td>'.$value["NameRsrv"].'</td><td>'.$value["AvansCard"].'</td><td class="cellmoney">'.number_format($value["AvansSum"],0).' руб.</td></tr>';
                }
    ?>
            </table>
        </div>
	</body>
</html>
