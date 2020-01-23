<?php 
  /***************************************************/
 /*Отчет по внесенным авансам по заказам брони*/
/***************************************************/

/******* Обработчик ошибок SQL Server*/
function FormatErrors( $errors )
{
    /* Display errors. */
    echo "Error information: ";

    foreach ( $errors as $error )
    {
        echo "SQLSTATE: ".$error['SQLSTATE']."";
        echo "Code: ".$error['code']."";
        echo "Message: ".$error['message']."";
    }
}
/******* Обработчик ошибок SQL Server*/

$serverName = "CASH\RESTART";
$connectionOptions = array(
    "Database" => "CAFE",
    "Uid" => "sa",
    "PWD" => "rarus12",
	"CharacterSet" => "UTF-8"
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if(!$conn){
    echo "Нет подключения к серверу БД!";
} 

		$tsql= "SELECT 
			 ord.[DateRsrv],
             ord.[NameRsrv],
             ord.[AvansCard],
             ord.[AvansSum]
            FROM [dbo].[tb_Order] as ord
            WHERE ord.[AvansSum] <> 0
            ORDER BY ord.[DateRsrv]";
 

$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $order[$i]=$row;
    $i++;
}
sqlsrv_free_stmt($getResults);


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
