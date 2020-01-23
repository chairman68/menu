<?php
if (isset($_GET['date_begin']) and isset($_GET['date_end'])) {
    $date_begin = new DateTime($_GET['date_begin']);
    $date_begin->setTime(8,00,00);
    $date_end = new DateTime($_GET['date_end']);
    $date_end->setTime(23,59,59);
} else {
    $date_begin = new DateTime();
    $date_begin->setTime(8,00,00);
    $date_end = new DateTime();
    $date_end->setTime(23,59,59);
}

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
			 SUM(item.[TotalSum]) as ordersum,
			 ord.[Num] as ordnum,
             ord.[Seats] as seats,
			 ord.[DateRsrv] as datersrv
			 FROM [dbo].[tb_Order] ord,  [dbo].[tb_OrdItem] item
            LEFT OUTER JOIN [dbo].[tb_Product] prod ON prod.[ObjID]=item.[ProdId]
            LEFT OUTER JOIN [dbo].[tb_MenuItem] menuitem ON menuitem.[ProdID]=item.[ProdId]
			LEFT OUTER JOIN [dbo].[tb_Menu] menu ON menu.[ObjID]=menuitem.[LinkID]
			WHERE item.[LinkID] = ord.[ObjID]
			AND menu.[Name]='Банкетное меню 2016'
			AND prod.[Type]=3
			AND ord.[Seats]>=40
			GROUP BY ord.[Seats], ord.[Num],ord.[DateRsrv]
            Order by ord.[DateRsrv]";
 
//print ($tsql);

 

    
$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $Item[$i]=$row;
    $i++;
}
sqlsrv_free_stmt($getResults);


//var_dump($Item);
?>


<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <title>Продажи блюд за период</title>
    <style>
	
		.cellname{
			font-family: sans-serif;
            font-weight: bold;
            font-size: 12pt;
            width: 100%;
            text-align: left;
            border-bottom: dotted 1px grey;
		}
        .cellkolvo {
            font-family: sans-serif;
            font-size: 12pt;
            width: 20%;
            text-align: right;
            border-bottom: dotted 1px grey;
        }
        .cellitogo {
            background-color: bisque;    
            color: crimson;
            font-family: sans-serif;
            font-size: 14pt;
            width: 20%;
            text-align: right;   
        }
        .cellitogoname {
            background-color: bisque; 
            color: crimson;
            font-family: sans-serif;
            font-size: 14pt;
            width: 80%;
            text-align: right;   
        }
        .cell_group_name {
            color: crimson;
            font-family: sans-serif;
            font-size: 14pt;
            text-align: center;   
        }
	</style>
</head>

<body>
<div id="main">
	

 <table cellpadding="5px" align = "center"><tr>
    <th style=" background-color: bisque;
                color: crimson;
                font-family: sans-serif;
                font-size: 14pt;">Дата банкета</th>
	<th style=" background-color: bisque;
                color: crimson;
                font-family: sans-serif;
                font-size: 14pt;">Номер заказа</th>   
   <th style=" background-color: bisque;
                color: crimson;
                font-family: sans-serif;
                font-size: 14pt;">Стоимость блюд</th>
	<th style=" background-color: bisque;
                color: crimson;
                font-family: sans-serif;
                font-size: 14pt;">Количество гостей</th>
    <th style=" background-color: bisque;
                color: crimson;
                font-family: sans-serif;
                font-size: 14pt;">Расчет на гостя</th>
    
 </tr>
<?php	
		
	  $itogo=0;
	 $itogosum=0;
     foreach ($Item as $value){
  //          var_dump($value);
            echo '<tr>';
                        echo '<td class ="cellname">' . date_format($value["datersrv"], 'd-m-Y'). '</td>';
		 				echo '<td class ="cellkolvo">' . number_format($value["ordnum"],0). '</td>';
                        echo '<td class ="cellkolvo">' . number_format($value["ordersum"],0). '</td>';
		 				echo '<td class ="cellkolvo">' . number_format($value["seats"],0). '</td>';
		 				echo '<td class ="cellkolvo">' . number_format(($value["ordersum"] / $value["seats"]),0). '</td>';
			 echo '</tr>';
		$itogo++;
		$itogosum = $itogosum+($value["ordersum"] / $value["seats"]);
        }
     echo '<tr>
            <td class ="cellitogoname" >Итого</td>
            <td class="cellitogo">'.$itogosum/$itogo.'</td>
            </tr>';
   
?>
	</table>
</html>