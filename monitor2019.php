<?php 
// ********************* Функции ***********************************

include ("lib/db_Restart.php");

$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

global $db;

$db= new orange\db_Restart ($config,0);

function count_orders_period($db,$date1,$date2){

	$query= "SELECT COUNT(*)
	        FROM [dbo].[tb_Order]
	        WHERE [dbo].[tb_Order].[DateDel] BETWEEN '". $date1."' and '".$date2."'
	        AND Status=2";
    $data = $db->query($query);
    
	return $data[1][""];
}	

//********************* НАЧАЛО ПРОГРАММЫ ***********************************************



if (isset($_GET['date']) ) {
    $date = new DateTime($_GET['date']);
} else {
    $date=new DateTime();
}

$orders_quantity_1=count_orders_period($db,$date->format("Ymd 08:00:00"),$date->format("Ymd 10:59:59"));
$orders_quantity_2=count_orders_period($db,$date->format("Ymd 11:00:00"),$date->format("Ymd 11:59:59"));
$orders_quantity_3=count_orders_period($db,$date->format("Ymd 12:00:00"),$date->format("Ymd 12:59:59"));
$orders_quantity_4=count_orders_period($db,$date->format("Ymd 13:00:00"),$date->format("Ymd 13:59:59"));
$orders_quantity_5=count_orders_period($db,$date->format("Ymd 14:00:00"),$date->format("Ymd 14:59:59"));
$orders_quantity_6=count_orders_period($db,$date->format("Ymd 15:00:00"),$date->format("Ymd 15:59:59"));
$orders_quantity_7=count_orders_period($db,$date->format("Ymd 16:00:00"),$date->format("Ymd 23:59:59"));
$orders_quantity_sum=$orders_quantity_1+$orders_quantity_2+$orders_quantity_3+$orders_quantity_4+$orders_quantity_5+$orders_quantity_6+$orders_quantity_7;
$db->close_connection();
?>

<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Монитор показателей</title>
	<style type="text/css">
		body {
			width: 100%;
			height: 100%;
		}
		.hour {
			width: 100px;
			height: 250px;
			float: left;
			position: relative;
			
		}
		.hours_name {
			width: 80px;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			font-size: 12pt;
			color: skyblue;
			text-align: center;
			padding: 10px;
		}
		.quantity_graf {
			margin: auto;
			width: 50px;
			background-color: red;
			position: absolute;
			bottom: 0;
			left: 25px;
		}
		.orders_quantity {
			color: red;
			font-size: 16pt;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			text-align: center;
		}
		#label {
			color: gray;
			text-align: center;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			font-size: 40px;
			height: 100px;
		}
		#orders_quantity_sum {
			color: red;
			text-align: center;
			font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
			font-size: 40px;
		}
		#graf_area {
			width: 100%;
			height: 250px;
			background-color:whitesmoke;
			position: absolute;
			bottom: 0;
			left: 0;
			right: 0;
		}
		#quantity_graf_1 {
			height: <?=$orders_quantity_1?>px;
		}
		#quantity_graf_2 {
			height: <?=$orders_quantity_2?>px;
		}
		#quantity_graf_3 {
			height: <?=$orders_quantity_3?>px;
		}
		#quantity_graf_4 {
			height: <?=$orders_quantity_4?>px;
		}
		#quantity_graf_5 {
			height: <?=$orders_quantity_5?>px;
		}
		#quantity_graf_6 {
			height: <?=$orders_quantity_6?>px;
		}
		#quantity_graf_7 {
			height: <?=$orders_quantity_7?>px;
		}
	</style>	
</head>
<body>
    <iframe src="/reports/rpt-sales2019.php?date_begin=<?=$date->format("Ymd")?>&date_end=<?=$date->format("Ymd")?>" width="39%" height="930px" frameborder="0"  style="float:right; margin-right:1%;">
        Ваш браузер не поддерживает плавающие фреймы!
    </iframe>
	<div style="width:60%;height:930px; position:relative;">
        
		<div id="label">Монитор показателей на <?=$date->format('d.m.Y')?></div>
        <div id="monitor">
		  <div id=orders_quantity_sum>Всего заказов </br> <h1><?=$orders_quantity_sum?></h1></div>
        </div>
		<div id="graf_area">
			<div style="width:100%; margin: auto; position: relative;">
				<div class="hour">
                    <div class="hours_name">10-11</div>
					<div class="orders_quantity" id="orders_quantity_1"><?=$orders_quantity_1?></div>
                    <div class="quantity_graf" id="quantity_graf_1"></div>
                    
				</div>
				<div class="hour">
					<div class="graf">
						<div class="quantity_graf" id="quantity_graf_2"></div>
					</div>
                    <div class="hours_name">11-12</div>
					<div class="orders_quantity" id="orders_quantity_2"><?=$orders_quantity_2?></div>
				</div>
				<div class="hour">
					<div class="graf">
						<div class="quantity_graf" id="quantity_graf_3"></div>
					</div>
                    <div class="hours_name">12-13</div>
					<div class="orders_quantity" id="orders_quantity_3"><?=$orders_quantity_3?></div>
				</div>
				<div class="hour">
					<div class="graf">
						<div class="quantity_graf" id="quantity_graf_4"></div>
					</div>
                    <div class="hours_name">13-14</div>
					<div class="orders_quantity" id="orders_quantity_4"><?=$orders_quantity_4?></div>
				</div>
				<div class="hour">
					<div class="graf">
						<div class="quantity_graf" id="quantity_graf_5"></div>
					</div>
                    <div class="hours_name">14-15</div>
					<div class="orders_quantity" id="orders_quantity_5"><?=$orders_quantity_5?></div>
				</div>
				<div class="hour">
					<div class="graf">
						<div class="quantity_graf" id="quantity_graf_6"></div>
					</div>
                    <div class="hours_name">15-16</div>
					<div class="orders_quantity" id="orders_quantity_6"><?=$orders_quantity_6?></div>
				</div>
				<div class="hour">
					<div class="graf">
						<div class="quantity_graf" id="quantity_graf_6"></div>
					</div>
                    <div class="hours_name">16-17</div>
					<div class="orders_quantity" id="orders_quantity_7"><?=$orders_quantity_7?></div>
				</div>

					<div style="clear:both;"></div>
				</div>
		</div>		
	</div>

</body>
</html>