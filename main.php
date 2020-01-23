<?php 
session_start();
//include ("security.php");
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link href="css/common.css" rel="stylesheet">
<title>ИС Три Апельсина</title>
<style>
	
	.button {
		width: 25%;
		height: 70px;
		border: solid 1px grey;
		border-radius: 10px;
		margin: 10px;
		display: flex;
		align-items:  center;
		justify-content: center;
		padding: 10px;
		text-decoration: none;
		text-align: center;
		color: orangered;
		font-size: 14pt;
	}
	#label_1 {
		width: 100%;
		height: 100px;
		text-align: center;
		color: orangered;
	}
	#wrapper {
		width: 100%;
		display: flex;
		justify-content:  center;
		flex-wrap: wrap; 
	}
	
	
	
</style>
</head>

<body>
	<?php //require 'status_bar.php';?>
	<div id="label_1"><h1>Информационная система кафе "Три Апельсина"</h1></div>
	<div id="wrapper">
		<a class= "button" href="calendar.php">Календарь банкетов</a>
		<a class= "button" href="daily_menu.php">Текущее меню</a>
		<a class= "button" href="print_menu_razdacha.php">Полное меню на раздаче</a>
		<a class= "button" href="print_menu_banquet.php">Банкетное меню</a>
		<a class= "button" href="calendar_orders.php">Продажи до 18.02.2019</a>
        <a class= "button" href="calendar_orders2019.php">Продажи с 18.02.2019</a>
		<a class= "button" href="list_of_preorders.php">Бронь</a>
		<a class= "button" href="rpt-avans.php">Авансы по банкетам</a>
		<a class= "button" href="main_kitchen.php">Монитор повара</a>
        <a class= "button" href="load_recipes_from_xml.php">Выгрузка рецептур в Рестарт</a>
		<a class= "button" href="start.php?screen=1">Монитор №1 на раздаче</a>
		<a class= "button" href="start.php?screen=2">Монитор №2 на раздаче</a>
		<a class= "button" href="start.php?screen=3">Монитор №3 на раздаче</a>
		<a class= "button" href="start.php?screen=4">Монитор №4 на раздаче</a>
		<a class= "button" href="start.php?screen=5">Монитор №5 на раздаче</a>
		<a class= "button" href="start.php?screen=6">Монитор №6 на раздаче</a>
	</div>
</body>
</html>
