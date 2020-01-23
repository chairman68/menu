<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 18.10.14
 * Time: 7:44
 * Список пршедших банкетов
 */
?>
<?php
// Функция вытаскивания даты и времени из строковой Time Stamp
function explodeTimeStamp ($str){
    list ($datetime["date"],$datetime["time"] ) = sscanf($str,"%s %s");
    return $datetime;
}

if (isset($_GET['month']) ) {
    $calendar_month = (int)$_GET['month'];
    $calendar_year = (int)$_GET['year'];
} else {
    $calendar_month = (int)date("m");
    $calendar_year = (int)date("Y");
}
$requestDate = mktime(0,0,0,$calendar_month,"1",$calendar_year);
// Функция вытаскивания даты и времени из строковой Time Stamp
function explodeDateTime ($DT){
    $datetime["date"]= $DT->format("Y.m.d");
	$datetime["time"]= $DT->format("H:i:s.000");
    return $datetime;
}

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
			  [dbo].[tb_Order].[ObjID],
			  [dbo].[tb_Order].[DateRsrv],
			  [dbo].[tb_Order].[Seats],
              [dbo].[tb_Order].[DateDel],
              [dbo].[tb_Order].[NameRsrv],
              [dbo].[tb_Order].[InfoRsrv],
			  [dbo].[tb_Order].[Num],
              SUM(item.[TotalSum])
			FROM [dbo].[tb_Order] ord
            LEFT OUTER JOIN [dbo].[tb_OrdItem] item ON item.[LinkID]=ord.[ObjID]
			WHERE [dbo].[tb_Order].[Seats] > 2
			ORDER BY [dbo].[tb_Order].[DateRsrv]";
        


$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $data[$i]=$row;
    $i++;
}

//var_dump($data);

sqlsrv_free_stmt($getResults);


$url="192.168.1.56";

$mounth=array(
    1=>"Январь",
    2=>"Февраль",
    3=>"Март",
    4=>"Апрель",
    5=>"Май",
    6=>"Июнь",
    7=>"Июль",
    8=>"Август",
    9=>"Сентябрь",
    10=>"Октябрь",
    11=>"Ноябрь",
    12=>"Декабрь");

// Если в строке передаются месяц и год, то устанавливаем их. Иначе используем значения текущей даты.
if (isset($_GET['month']) ) {
    $calendar_month = (int)$_GET['month'];
    $calendar_year = (int)$_GET['year'];
} else {
    $calendar_month = (int)date("m");
    $calendar_year = (int)date("Y");
}


if ($calendar_month==12) {
    $nextmonth=1;
    $nextyear=$calendar_year+1;
} else {
    $nextmonth=$calendar_month+1;
    $nextyear=$calendar_year;
}

if ($calendar_month==1) {
    $previousmonth=12;
    $previousyear=$calendar_year-1;
} else {
    $previousmonth=$calendar_month-1;
    $previousyear=$calendar_year;
}


?>
<!-- Выдаем HTML страницу -->

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/orderlist.css" type="text/css" />
    <!--
    <meta http-equiv="Refresh" content="300" />
    -->
    <title>Заказы за <?= $mounth[$calendar_month] ?></title>
</head>

<body>

<div style="width: 1000px;
   	 			margin: 0 auto;
                align:center;
                height: 100px;
                color: grey;
                text-align:center;>
                
   				<div style="width: 50%;
   	 						margin: 0 auto;
                			align:center;
                			height: 150px;
                			color: grey;
                			text-align:center;
                			font-size:200%;">
       						<?=$mounth[$calendar_month]?> </br> <?=$calendar_year?>
   				</div>

				<?php // Кнопки навигации ?>   
  
   				<div style=" position:absolute;
                            width: 50px;
                            height: 50px;
                            right: 100px;
                            top: 25px;
                            border: solid grey 1px;
                            border-radius:10px;
                            background-size:cover;
                            background-image: url('Images/row_right.png');
                            cursor: pointer;"
      						 onclick="location.href='http://<?=$url?>/old_orders.php?month=<?=$nextmonth?>&year=<?=$nextyear?>'">
   				</div>
               
               <div style=" position:absolute;
                            width: 50px;
                            height: 50px;
                            left:100px;
                            top: 25px;
                            border: solid grey 1px;
                            border-radius:10px;
                            background-size:cover;
                            background-image: url('Images/row_left.png');
                            cursor: pointer;"
         					onclick="location.href='http://<?=$url?>/old_orders.php?month=<?=$previousmonth?>&year=<?=$previousyear?>'">

   				</div>
</div>
   
   
   
<?php 
    
echo ' <table align = "center"><tr>
    <th style="border:solid 1px;">№</th>
    <th style="border:solid 1px;">Клиент</th>
	<th style="border:solid 1px;">Телефон</th>
	<th style="border:solid 1px;">Гостей</th>
    <th style="border:solid 1px;">Дата Резерва</th>
    <th style="border:solid 1px;">Время закрытия</th>
	<th style="border:solid 1px;">Номер заказа</th>
	<th style="border:solid 1px;"></th>
   </tr>';
$n=1;
	foreach ($data as $Object) {

            
        
        //var_dump($Object);         
				  
        echo '<tr>';
            echo '<td class ="cell" style = "width:50px; text-align:left;">' . $n. '</td>';
            echo '<td class ="cell" style = "width:200px; text-align:left;">' . $Object[NameRsrv]. '</td>';
            echo '<td class ="cell" style = "width:100px; text-align:center;">' . $Object[InfoRsrv]. '</td>';
            echo '<td class ="cell" style = "width:50px; text-align:center;">' . $Object[Seats]. '</td>';
            echo '<td class ="cell" style = "width:100px; text-align:center;">' . $Object[DateRsrv]->format(dmY). '</td>';
            if ($Object[DateDel]==null){
            echo '<td class ="cell" style = "width:100px; text-align:center;"></td>';
            } else {
            echo '<td class ="cell" style = "width:100px; text-align:center;">' . $Object[DateDel]->format(dmY). '</td>';
                    }
            echo '<td class ="cell" style = "width:100px; text-align:center;">' . $Object[Num]. '</td>';
            echo '<td class ="cell" style= "cursor: pointer; border-right: solid 1px; width:200px;text-align:center;" onclick="location.href='." 'http://".$url."/order.php?order=".$Object[Num]." ' ".'"s> Состав заказа</td>';

        echo '</tr>';
        $n++;
                        
    }
    echo ' </table>';
 
?>
</body>
</html>