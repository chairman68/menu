<?php
include ("lib/db_Restart.php");

$kassa = (integer) $_GET["kassa"];
$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы
$db= new orange\db_Restart ($config,$kassa);



	$tsql= "SELECT [dbo].[tb_Recipe].[ObjID]
				  ,[dbo].[tb_Recipe].[ObjActive]
				  ,[dbo].[tb_Recipe].[ExtrnCode]
				  ,[dbo].[tb_Recipe].[ObjTS]
				  ,[dbo].[tb_Recipe].[ObjCrtnTS]
				  ,[dbo].[tb_Recipe].[Posted]
				  ,[dbo].[tb_Recipe].[OrgID]
				  ,[dbo].[tb_Recipe].[SubunitID]
				  ,[dbo].[tb_Recipe].[BegDate]
				  ,[dbo].[tb_Recipe].[EndDate]
				  ,[dbo].[tb_Recipe].[Number]
				  ,[dbo].[tb_Recipe].[ProdID]
				  ,[dbo].[tb_Recipe].[Quantity]
				  ,[dbo].[tb_Recipe].[UnitName]
				  ,[dbo].[tb_Recipe].[UnitID]
				  ,[dbo].[tb_Recipe].[Image]
				  ,[dbo].[tb_Recipe].[OutPut]
				  ,[dbo].[tb_Recipe].[Main]
				  ,[dbo].[tb_Recipe].[CookingTime]
				  ,[dbo].[tb_Recipe].[PrepTechnology]
				  ,[dbo].[tb_Recipe].[ExteriorReqs]
				  ,[dbo].[tb_Recipe].[Comment]
				  ,[dbo].[tb_Product].[Name] as Prodname
				  
				FROM [dbo].[tb_Recipe],[dbo].[tb_Product]
				WHERE [dbo].[tb_Recipe].[ProdID]= '".$_GET["ProdID"]."'
				AND [dbo].[tb_Recipe].[ProdID]=[dbo].[tb_Product].[ObjID]
				ORDER BY [dbo].[tb_Recipe].[BegDate] DESC";
	$recipe = $db->query($tsql);

	
	if (count($recipe)>0){
	
	
		if ($recipe[1]["ObjID"]<>'00000000-0000-0000-0000-000000000000') {
			$tsql= "SELECT [dbo].[tb_RecItem].[LinkID]
						  ,[dbo].[tb_RecItem].[Pos]
						  ,[dbo].[tb_RecItem].[ProdName]
						  ,[dbo].[tb_RecItem].[ProdID]
						  ,[dbo].[tb_RecItem].[QntAll]
						  ,[dbo].[tb_RecItem].[QntNet]
						  ,[dbo].[tb_RecItem].[QntOut]
						  ,[dbo].[tb_RecItem].[UnitName]
						  ,[dbo].[tb_RecItem].[UnitID]
						  ,[dbo].[tb_RecItem].[RecipeID]
						  ,[dbo].[tb_RecItem].[Spice]
						  ,[dbo].[tb_Product].[Name] as Prodname
						  ,[dbo].[tb_Product].[Type] as Prodtype

						FROM [dbo].[tb_RecItem],[dbo].[tb_Product]
						WHERE [dbo].[tb_RecItem].[LinkID]= '".$recipe[1]["ObjID"]."'
						AND [dbo].[tb_RecItem].[ProdID]=[dbo].[tb_Product].[ObjID]";

				$goods = $db->query($tsql);
		}
	} else {
			
			$recipe[1]=array("ObjID"=>'00000000-0000-0000-0000-000000000000'
					 ,"ObjActive"=>''
					 ,"ExtrnCode"=>''
					 ,"ObjTS"=>new DateTime()
					 ,"ObjCrtnTS"=> new DateTime()
					 ,"Posted"=>''
					 ,"OrgID"=>''
					 ,"SubunitID"=>''
					 ,"BegDate"=>new DateTime()
					 ,"EndDate"=>new DateTime()
					 ,"Number"=>''
					 ,"ProdID"=>''
					 ,"Quantity"=>''
					 ,"UnitName"=>''
					 ,"UnitID"=>''
					 ,"Image"=>''
					 ,"OutPut"=>''
					 ,"Main"=>''
					 ,"CookingTime"=>''
					 ,"PrepTechnology"=>''
					 ,"ExteriorReqs"=>''
					 ,"Comment"=>''
					 ,"Prodname"=>'Нет рецептуры'
					);
		}

		$db->close_connection();
?>
	
	<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Рецептура</title>
<style>
	html, body {
		width: 100%;
		height: 100%;		
		margin: 0;
		padding:0;
		font-size:16pt;
		font-family: Geneva, Arial, Helvetica, sans-serif;
	}
	.navi {
		width: 68px;
		height: 68px;
		min-height: 68px;
		border: solid grey 1px;
		margin:10px;
		border-radius: 10px;
		display: flex;
		justify-content: center;
		align-items: center;
		cursor: pointer;
		z-index: 100;
		background-color: white;
		background-size: contain;
		font-size:20pt;
	}
	#name_panel {
		width: 1190px;
		height:180px;
		display: flex;
		text-align: center;
		background-color: grey;
	}
	#name {
		width: 400px;
		height:160px;
		margin:10px;
		padding 10px;
		background-color: white;
		display: flex;
		justify-content: center;
		align-items: center;
		font-size: 20pt;
		text-align: center;
	}
	#recipe_num {
		width: 380px;
		height:70px;
		margin:10px;
		background-color: white;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	#output {
		width: 380px;
		height:70px;
		margin:10px;
		background-color: white;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	.b10 {
		width: 68px;
		height:90px;
		background-color: white;
		display: flex;
		justify-content: center;
		align-items: center;
	}
	#quantity {
		width: 180px;
		height:70px;
		margin:10px;
		background-color: white;
		display: flex;
		justify-content: center;
		align-items: center;
		color: red;
		font-size: 24pt;
	}
	.col {
		display: flex;
		flex-direction: column;
		justify-content: space-around;
	}
	#menu_panel {
	width: 1190px;
		height:90px;
		display: flex;
		justify-content: space-around;
		align-items: center;
		background-color: lightgrey;	
	}
	#item_panel {
		
	}
	#recipe {
		position: absolute;
		top: 270px;
		width: 1190px;
	
	}
	#technology {
		position: absolute;
		top: 270px;
		width: 1190px;
		display: none;
	}
	#picture {
		position: absolute;
		top: 270px;
		width: 1190px;
		display: none;
		justify-content: center;
		align-items: center;
	}
	.ingr_name, .ing_name {
		width: 570px;
		height: 40px;
		background-color: white;
		padding: 5px;
		font-size: 120%;
		
	}
	.ingr_brutto, .ing_brutto {
		width: 200px;
		height: 50px;
		background-color: white;
		padding: 5px;
		text-align: center;
	}
	.ingr_netto, .ing_netto{
		width: 200px;
		height: 50px;
		background-color: white;
		padding: 5px;
		text-align: center;
	}
	.ingr_out, .ing_out{
		width: 200px;
		height: 50px;
		background-color: white;
		padding: 5px;
		text-align: center;
	}
	#colname_panel {
		width: 1190px;
		height: 50px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		background-color: grey;
	}
	.tab_head {
		height: 40px;
		font-weight: bold;
		display: flex;
		text-align: center;
		align-items:center;
		justify-content:center;
	}
	.menu_button {
		background-color: white;
		border-radius: 10px;
		width: 300px;
		height: 70px;
		display: flex;
		justify-content: center;
		align-items: center;
	}
</style>

</head>

<body>
	
<?php // ***************** Кнопки навигации ****************************?>
	
<div id="name_panel">
	<div id="name"><?=$recipe[1]["Prodname"]?></div>
	<div class="col">
		<div id="recipe_num">Рецептура № <?=$recipe[1]["Number"]?> <br/> от <?=$recipe[1]["BegDate"]->format("d-m-Y")?></div>
		<div id="output">Выход блюда - <?=$recipe[1]["OutPut"]?> грамм.</div>
	</div>
	<div class="col">
		<div class="navi" onClick="plus10()">+10</div>
		<div class="navi" onClick="minus10()">-10</div>
	</div>
	<div class="col">
		<div style="color:white;">Рассчитано на</div>
		<div id="quantity"><?=$recipe[1]["Quantity"]?></div>
		<div style="color:white;">порций</div>
	</div>
	<div class="col">
		<div class="navi" onClick="plus1()">+1</div>
		<div class="navi" onClick="minus1()">-1</div>
	</div>
	<div class="col">
	<div class="navi" onClick="history.back()"
     style="background-image: url('Images/x.png');">

</div>	
	</div>
</div>
<div id="menu_panel">
<div class="menu_button" id="btn_recipe" contextmenu=""style="background-color:lightgreen;" onClick="sostav()">Состав</div>
<div class="menu_button" id="btn_technology" onClick="technology()">Технология</div>
<div class="menu_button"  id="btn_picture" onClick="photo()">Фото</div>
</div>
<div id="item_panel"></div>
<div id="recipe">
	<div id="colname_panel">
		<div class="ing_name tab_head">Наименование</div>
		<div class="ing_brutto tab_head">Брутто</div>
		<div class="ing_netto tab_head">Нетто</div>
		<div class="ing_out tab_head">Выход</div>
	</div>
<?php	
if ($recipe[1]["ObjID"]<>'00000000-0000-0000-0000-000000000000') {		
	foreach ($goods as $good){
		
		echo "<div id='colname_panel'>";
			if($good["Prodtype"]==3) {
				echo "<div class='ingr_name'><a href='kitchen_recipe.php?ProdID=".$good["ProdID"]."&kassa=".$_GET["kassa"]."'>".$good["Prodname"]."</a></div>";
				} else {
				echo "<div class='ingr_name'>".$good["Prodname"]."</div>";
				}
			echo "<div class='ingr_brutto'>".number_format($good["QntAll"],3)."</div>";
			echo "<div class='ingr_netto'>".number_format($good["QntNet"],3)."</div>";
			echo "<div class='ingr_out'>".number_format($good["QntOut"],3)."</div>";
			if ($good["RecipeID"]<>'00000000-0000-0000-0000-000000000000'){
				$returnID["included"][]=$good["RecipeID"];
				//echo "<td id='tb_recipe'>Есть</td>";
			} else {
				//echo "<td id='tb_recipe'></td>";
			}
		echo "</div>";
		
	}
} 	
?>
</div>
<div id="technology">
	<div style="margin-bottom: 100px; padding: 30px;">Время приготовления:<br/> <?=$recipe[1]["CookingTime"]?></div>
	<div style="margin-bottom: 100px; padding: 30px;">Технология приготовления: <br/> <?=$recipe[1]["PrepTechnology"]?></div>
	<div style="margin-bottom: 100px; padding: 30px;">Внешний вид:<br/><?=$recipe[1]["ExteriorReqs"]?></div>
	<div style="margin-bottom: 100px; padding: 30px;">Комментарии:<br/><?=$recipe[1]["Comment"]?></div>
</div>
<div id="picture">
<?php	if  ($recipe[1]["Image"]<>'') {
			echo '<img src="'.$recipe[1]["Image"].'"';
		} else {
			echo '<img src="Images/noimage.jpg"';
		}		
?>	
</div>
</body>
<script>
var quantity_base=document.getElementById("quantity");
var brutto_base=document.getElementsByClassName("ingr_brutto");
var netto_base=document.getElementsByClassName("ingr_netto");
var out_base=document.getElementsByClassName("ingr_out");


	</script>
	<script>
	function sostav() {
		document.getElementById("recipe").style.display='block';
		document.getElementById("btn_recipe").style.backgroundColor='lightgreen';
		document.getElementById("technology").style.display='none';
		document.getElementById("btn_technology").style.backgroundColor='white';
		document.getElementById("picture").style.display='none';
		document.getElementById("btn_picture").style.backgroundColor='white';
		
	}
	function technology() {
		document.getElementById("technology").style.display='block';
		document.getElementById("btn_technology").style.backgroundColor='lightgreen';
		document.getElementById("recipe").style.display='none';
		document.getElementById("btn_recipe").style.backgroundColor='white';
		document.getElementById("picture").style.display='none';
		document.getElementById("btn_picture").style.backgroundColor='white';
	}
	function photo(){
		document.getElementById("picture").style.display='flex';
		document.getElementById("btn_picture").style.backgroundColor='lightgreen';
		document.getElementById("recipe").style.display='none';
		document.getElementById("btn_recipe").style.backgroundColor='white';
		document.getElementById("technology").style.display='none';
		document.getElementById("btn_technology").style.backgroundColor='white';
	}
	
	function plus1 () {
		var koef=(+document.getElementById("quantity").innerHTML+1)/+quantity_base.innerHTML;
		recount(koef);
		document.getElementById("quantity").innerHTML=+document.getElementById("quantity").innerHTML+1;
	}
	function plus10 () {
		var koef=(+document.getElementById("quantity").innerHTML+10)/+quantity_base.innerHTML;
		recount(koef);
		document.getElementById("quantity").innerHTML=+document.getElementById("quantity").innerHTML+10;
	}
	function minus1 () {
		if (+document.getElementById("quantity").innerHTML>1){
			var koef=(+document.getElementById("quantity").innerHTML-1)/+quantity_base.innerHTML;
			recount(koef);
			document.getElementById("quantity").innerHTML=+document.getElementById("quantity").innerHTML-1;
					
		}
	}
	function minus10 () {
		var koef;
		if (+document.getElementById("quantity").innerHTML>10){
		koef=(+document.getElementById("quantity").innerHTML-10)/+quantity_base.innerHTML;
		recount(koef);
			document.getElementById("quantity").innerHTML=+document.getElementById("quantity").innerHTML-10;
		} else {
			
			koef=1/+quantity_base.innerHTML;
			
		recount(koef);
			document.getElementById("quantity").innerHTML=1;
			
		}
	}
	
	function recount (k){
	
		
		for (var i = 0; i < brutto_base.length; i++){
			var brutto = +brutto_base[i].innerHTML*k;
			var netto = +netto_base[i].innerHTML*k;
			var out = +out_base[i].innerHTML*k;
    		document.getElementsByClassName("ingr_brutto")[i].innerHTML = brutto.toFixed(3);
			document.getElementsByClassName("ingr_netto")[i].innerHTML = netto.toFixed(3);
			document.getElementsByClassName("ingr_out")[i].innerHTML = out.toFixed(3);
		}
		
	}
	</script>
</html>
