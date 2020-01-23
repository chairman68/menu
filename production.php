<?php 
session_start();

//require_once ("lib/security.php");
//$security= new security();
//$security->testUser();
?>

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Выпуск блюд</title>    
    <link href="css/production.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
    <link href="css/menu_panel.css" rel="stylesheet">
    <script src="js/production.js" defer ></script>
</head>

<body>
<?php require_once('status_bar.php')?>
<div class='main'>
	<div id='navi'>
		<div class = "button-active" id='button-top-left'>Задание</div>
		<div class="button-passive" id='button-top-center'>Рецептура</div>
		<div class="button-passive" id='button-top-right'>Выпуск партии</div>
	</div>
	<div id='panel-contaner'>
		<div class="product-header">
				
				<div id='recipe-number'>Рецептура № 1231231 от 01-01-2018 г.</div>
				
				<div class='product-header-productname'>Каша гречневая с маслом</div>
				<a href=# class = 'button-shadow ' id='button-back'>Back</a>
			</div>
		<div class='panel' id='panel-task'>

			<div class='panel-left'>
				<div class='flex-center' > <h1>Осталось</h1></div>
				<div class='flex-center' id='task-time-balance'>19:00:00</div>
				<div class='flex-center' style="background-color: aqua; color: #0602A2;"> <h2>Приготовить к</h2></div>
				<div class='flex-center' id='task-ready-time'>11-10-2019 10:00:00</div>
				<div class='flex-center' id="task-owner-contaner">
					<div class="flex-center" id='task-owner'>Задание выдал: <br\>Иванова Ирина Борисовна</div>
					<div  id='task-time'>10-10-2019 15:00:00</div>
				</div>
			</div>
			<div class='panel-right border-1' >
				<div class='' id='task-part-size'>40 <span style="font-size: 50%">пор. x </span><span style="color: #B47D07; font-size: 60%">150 </span><span style="font-size: 50%">г<span style="font-size: 50%"></div>
					
				<div class='' id='task-product-weight'>6.000 <span style="font-size: 50%">кг</span></div>
				
				<div   id='task-comment'>Не солить!!!</div>
			</div>
		</div>
		<div class='panel' id='panel-recipe'>
			<div class="product-header">
				
				<div id='recipe-number'>Рецептура № 1231231 от 01-01-2018 г.</div>
				
				<div class='product-header-productname'>Каша гречневая с маслом</div>
				<a href=# class = 'button-shadow ' id='button-back'>Back</a>
			</div>
			<div id="panel-recipe-navi"> 
				<a href="#" class="button-shadow button-shadow-active" id="button-recipe">Раскладка</a>
				<a href="#" class="button-shadow" id="button-tecnology">Технология</a>
				<a href="#" class="button-shadow" id="button-photo">Фото</a>
			</div>
			
			<div class="panel-recipe-data" id ="panel-recipe-ingridients">
				<table id ="panel-recipe-ingridients-table">
					<tr>
						<th class="recipe-table-col1">Номер</th>
						<th >Продукт</th>
						<th class="recipe-table-col3">Брутто</th>
						<th class="recipe-table-col4">Нетто</th>
						<th class="recipe-table-col5">Выход</th>
					</tr>
					<tr>
						<td class="recipe-table-col1">1</td>
						<td class="recipe-table-col2">Картофель</td>
						<td class="recipe-table-col3">1.650</td>
						<td class="recipe-table-col4">1.500</td>
						<td class="recipe-table-col5">1.300</td>
					</tr>
					<tr>
						<td class="recipe-table-col1">1</td>
						<td class="recipe-table-col2">Картофель</td>
						<td class="recipe-table-col3">1.650</td>
						<td class="recipe-table-col4">1.500</td>
						<td class="recipe-table-col5">1.300</td>
					</tr>
					<tr>
						<td class="recipe-table-col1">1</td>
						<td class="recipe-table-col2">Картофель</td>
						<td class="recipe-table-col3">1.650</td>
						<td class="recipe-table-col4">1.500</td>
						<td class="recipe-table-col5">1.300</td>
					</tr>
					<tr>
						<td class="recipe-table-col1">1</td>
						<td class="recipe-table-col2">Картофель</td>
						<td class="recipe-table-col3">1.650</td>
						<td class="recipe-table-col4">1.500</td>
						<td class="recipe-table-col5">1.300</td>
					</tr>
					<tr>
						<td class="recipe-table-col1">1</td>
						<td class="recipe-table-col2">Картофель</td>
						<td class="recipe-table-col3">1.650</td>
						<td class="recipe-table-col4">1.500</td>
						<td class="recipe-table-col5">1.300</td>
					</tr>
					
				</table>
			</div>
			<div class=" panel-recipe-data" id ="panel-recipe-tecnology">
				<div id='recipe-tecnology'>технология</div>
			</div>
			<div class=" panel-recipe-data" id ="panel-recipe-photo">
				<div id='recipe-photo'>фото</div>
			</div>
		</div>
		<div class='panel' id='panel-production'>
			<div class="product-header">
				<div id='recipe-number'>Рецептура № 1231231 от 01-01-2018 г.</div>
				<div class='product-header-productname'>Каша гречневая с маслом</div>
			</div>
			
			<div class='flex-center label2 widh-100%'>Список выпущенных партий</div>
			<table>
				<tr>
					<th>Номер партии</th>
					<th>Время выпуска</th>
					<th>Количество</th>
					<th>Вес</th>
					<th>Бракераж</th>
				</tr>
				<tr>
					<td>1231</td>
					<td>10-10-2019 10:00</td>
					<td>40</td>
					<td>10.400</td>
					<td>5</td>
				</tr>
				<tr>
					<td>1233</td>
					<td>10-10-2019 12:00</td>
					<td>20</td>
					<td>5.200</td>
					<td>нет оценки</td>
				</tr>
					
			</table>	
			<div id='production-task-time'>время задания</div>
			<div id='production-part-size'>размер произведенной партии</div>
			<div id='production-product-weight'>общий вес продукта</div>
			<div id='production-ready-time'>время готовности партии</div>
			<a href=# class="button-shadow button-shadow-active" id="production-button-produce"> Выпустить продукцию</a>

			<div class='production-form' >
				<div id='production-part-size'>размер произведенной партии</div>
				<div id='production-product-weight'>общий вес продукта</div>	
				
			</div>
			</div>

	</div>

</div>


</body>

</html>