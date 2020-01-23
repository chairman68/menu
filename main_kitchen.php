<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Три Апельсина</title>
<style>
	body {
		width: 100%;
		height: 100%;
		font-family: Gotham, "Helvetica Neue", Helvetica, Arial, "sans-serif";
		font-size: 14pt;
		
	}
	.button {
		width: 25%;
		height: 70px;
		border: solid 1px grey;
		border-radius: 10px;
		margin: 10px;
		display: flex;
		align-items: center;
		text-align: center;
		justify-content:center;
		padding: 10px;
		text-decoration: none;
		color: orangered;
		font-size: 150%;
	}
	#label_1 {
		width: 70%;
		margin: auto;
		height: 100px;
		padding: 10px;
		text-align: center;
		color: orangered;
	}
	#wrapper {
		width: 100%;
		height: 100%;
		display: flex;
		justify-content:space-between;
		flex-wrap:wrap; 
	}
</style>
</head>

<body>
	<div id="wrapper">
		
		<div id="label_1"><h1>Кухня "Три Апельсина"</h1></div>
		<a class= "button" href="calendar.php">Календарь банкетов</a>
		<a class= "button" href="daily_menu.php">Текущее меню</a>
		<a class= "button" href="kitchen_razdacha.php">Рецептуры на раздачу</a>
		<a class= "button" href="kitchen_banket.php">Рецептуры на банкет</a>
		<a class= "button" href="current_sales.php">Продано сегодня</a>
		
			
		
	</div>
</body>
</html>