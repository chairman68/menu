<?php
/*
 
 * Список забронированных заказов
 */

?>
<?php
// Функция вытаскивания даты и времени из строковой Time Stamp

function explodeTimeStamp ($str){
    list ($datetime["date"],$datetime["time"] ) = sscanf($str,"%s %s");
    return $datetime;
}
function explodeDateTime ($DT){
    $datetime["date"]= $DT->format("Y.m.d");
	$datetime["time"]= $DT->format("H:i:s.000");
    return $datetime;
}



/***********************************************************************/



include ("lib/db_Restart.php");

$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

$db = new orange\db_Restart ($config,1);

		$tsql= "SELECT 
			  [dbo].[tb_Order].[NameRsrv],
			  [dbo].[tb_Order].[InfoRsrv],
			  [dbo].[tb_Order].[Seats],
			  [dbo].[tb_Order].[DateRsrv],
			  [dbo].[tb_Order].[Num]
			FROM [dbo].[tb_Order]
			WHERE [dbo].[tb_Order].[Status] = 4
			ORDER BY [dbo].[tb_Order].[Num]";
        

	$Order = $db->query($tsql);
	$db->close_connection();

        if (!$Order[2]){ 
		header('HTTP/1.1 200 OK');
		header('Location: /order.php?order='.$Order[1]["Num"]);
		exit();
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
    <title>Предварительные заказы</title>
    <style>
	.navi {
                width: 100px;
                height: 100px;
                border: solid grey 1px;
                position: fixed;
                border-radius: 10px;
                right: 100px;
                cursor: pointer;
            }
	</style>
</head>

<body>
<div id="main">
	<h1>На эту дату есть несколько заказов</h1> </br> </br>

 <table align = "center"><tr>
    <th style="border:solid 1px;">Клиент</th>
	<th style="border:solid 1px;">Телефон</th>
	<th style="border:solid 1px;">Гостей</th>
    <th style="border:solid 1px;">Дата Резерва</th>
	<th style="border:solid 1px;">Номер заказа</th>
	<th style="border:solid 1px;"></th>
 </tr>
	
	<?php	
		$i=1;
			
		while ($Order[$i]){
			
					echo '<tr>';
			  
			  				echo '<td class ="cell" style = "width:200px; text-align:left;">' . $Order[$i]["NameRsrv"]. '</td>';
			  				echo '<td class ="cell" style = "width:100px; text-align:center;">' . $Order[$i]["InfoRsrv"]. '</td>';
			  				echo '<td class ="cell" style = "width:50px; text-align:center;">' . $Order[$i]["Seats"]. '</td>';
			  				echo '<td class ="cell" style = "width:100px; text-align:center;">' . $Order[$i]["DateRsrv"]->format("d-m-Y H:i"). '</td>';
			  				echo '<td class ="cell" style = "width:100px; text-align:center;">' . $Order[$i]["Num"]. '</td>';
							echo '<td class ="cell" style= "border-right: solid 1px; width:200px;text-align:center;"><a href=\'http://192.168.1.56/order.php?order='.$Order[$i]["Num"].'\'> Состав заказа</a></td>';
			
			  			echo '</tr>';
			$i++;
			
         }
    
    echo ' </table>';
    
	?>
	<div class="navi" onClick="history.back()"
     style="
                background-image: url('Images/x.png');
                top: 0px;">

</div>
</body>
</html>