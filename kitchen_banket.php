<?php 
include ("lib/db_Restart.php");

$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

$db= new orange\db_Restart ($config,1);


		$tsql= "SELECT 
			  [dbo].[tb_MenuItem].[ParentID],
			  [dbo].[tb_MenuItem].[ID],
			  [dbo].[tb_MenuItem].[IsGroup],
			  [dbo].[tb_MenuItem].[Name],
			  [dbo].[tb_MenuItem].[Pos],
			  [dbo].[tb_MenuItem].[ProdID],
			  [dbo].[tb_MenuItem].[Price],
			  [dbo].[tb_Product].[Comment],
			  [dbo].[tb_Product].[Output]
			FROM [dbo].[tb_MenuItem], [dbo].[tb_Product]
			WHERE [dbo].[tb_MenuItem].[LinkID] = '3d48809f-1fa0-11e9-bba7-00155d012807'
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY [dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";

$Item = $db->query($tsql);

$db->close_connection();
?>

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript">

function printLabels(format) {
    var id=[];
    var boxes = document.getElementsByName('print');
    for (n=0; n<boxes.length; n++){
        if (boxes[n].checked) id.push(boxes[n].value);
    }
    var str = JSON.stringify(id);
	if (format=='A4') window.open("print_labels.php?json="+str);
	if (format=='SRA3') window.open("print_labels_SRA3.php?json="+str);
 }
function setAllCheckboxes(){
    var boxes = document.getElementsByName('print');
       if (document.getElementById('printall').checked) {
            for (n=0; n<boxes.length; n++){
            boxes[n].checked=true;   
            }    
       
       } else {
            for (n=0; n<boxes.length; n++){
            boxes[n].checked=false;   
            }       
       } 
}
function setCheckAll() {
    var n=0;
    var boxes = document.getElementsByName('print');
    for (n=0; n<boxes.length; n++){
       if (boxes[n].checked) {
            document.getElementById('printall').checked=true;
           return;
       } else {
           document.getElementById('printall').checked=false; 
       }
    }
}
function changeWeight(value,ID){
	// 1. Создаём новый объект XMLHttpRequest
	var xhr = new XMLHttpRequest();
	var str='{ weight: "'+value+'",id: "'+ID+'"}';
	var json = JSON.stringify(str);

xhr.open("POST", 'ajax/changeweight.php', true);
xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');

//xhr.onreadystatechange = ...;

// Отсылаем объект в формате JSON и с Content-Type application/json
// Сервер должен уметь такой Content-Type принимать и раскодировать
xhr.send(json);
alert( xhr.responseText );
}
</script>
    <title>Банкетные блюда</title>
    <style>
        body {
            margin: 0;
            padding: 0;
			font-family: sans-serif;
            font-size: 14pt;
			cursor: none;
        }
		.navi {
                width: 7%;
                height: 90%;
                border: solid grey 1px;
                border-radius: 10px;
				margin: 0;
				background-color: white;
            }
		.group {
			display: flex;
			flex-wrap: wrap;
			background-color: gray;
			justify-content:center;
		}
		.item_link {
			width: 30%;
			height: 100px;
			text-decoration: none;
			border: solid 1px;
			margin: 5px;
			padding: 5px;
			display: flex;
			align-items: center;
			justify-content: center;
			background-color: white;
			color: black;
			border-radius: 10px;
			font-size: 100%;
		}
		
        
        .cell_group_name {
            color: #24b535;
            font-family: sans-serif;
            font-size: 130%;
            display: flex;
            justify-content:center;
            align-items:center;
            text-align: center;
            background-color: white;
			height: 70px;
        }
		
        #main {
            
			position: relative;
            text-align: center;
            font-family: sans-serif;
            font-size: 20pt;
            top:70px;
			
        }
        
		#menu {
			margin: auto;
            width: 100%;
            height: 10%;
            background-color: gray;
            z-index: 99;
			display: flex;
			align-items:center;
			justify-content:space-around;
			position: fixed;
        }
        .menu_button {
            height: 90%;
			width: 15%;
            border-radius: 10px;
            border: solid 1px gray;
            margin: 0;
			padding: 0;
            text-align: center;
			text-decoration: none;
			font-size: 20pt;
			background-color: white;
			display: flex;
			justify-content: center;
			align-items: center;
			color: red;
        }
		.inputWeight{
			font-size:16pt;
			border:none;
			text-align:center;
		}
        
	</style>
</head>

<body>
  

<div id="menu">
	<a class="menu_button" href="#salad">Салаты</a>
	<a class="menu_button" href="#holzak">Холодные закуски</a>
	<a class="menu_button" href="#gorzak">Горячие закуски</a>
	<a class="menu_button" href="#garnir">Горячие блюда</a>
	<a class="menu_button" href="#cake">Десерты и напитки</a>
	<a class="menu_button" href="#children">Детские</a>
	<a class="navi" href="main_kitchen.php" style="background: url('Images/x.png') no-repeat; background-position: center,center; background-color:white;"></a>
</div>	

<div id="main">
    
	
<div class="cell_group_name" id="holzak">Холодные закуски</div>
	<div class="group">
<?php
foreach ($Item as $value){
        if ($value["ParentID"]==mb_strtoupper('EB10030b-1FD4-11E9-BBA7-00155D012807', 'UTF8')) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=1>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
        }
}
?>
     </div>
	<div class="cell_group_name" id="salad">Салаты</div>
	<div class="group">
<?php		 
     //*************************************************************************
     	
	 foreach ($Item as $value){
            if ($value["ParentID"]==mb_strtoupper('eb100322-1fd4-11e9-bba7-00155d012807', 'UTF8')) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=1>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
                
            }
        }
?>
     </div>
	<div class="cell_group_name" id="gorzak">Горячие закуски</div>
	<div class="group">
<?php	
     //*************************************************************************
  	 foreach ($Item as $value){
            if ($value["ParentID"]==mb_strtoupper('eb100330-1fd4-11e9-bba7-00155d012807', 'UTF8')  
                ) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=1>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
	        }
        }
?>
     </div>
	<div class="cell_group_name" id="garnir">Горячие блюда и гарниры</div>
	<div class="group">
<?php
     //*************************************************************************
     
     foreach ($Item as $value){
            if ($value["ParentID"]==mb_strtoupper('eb10033b-1fd4-11e9-bba7-00155d012807', 'UTF8')      //Гарниры
               ) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=1>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
            }
        }
?>
     </div>
	<div class="cell_group_name" id="cake">Десерты и напитки</div>
	<div class="group">
<?php
     //*************************************************************************
     
     foreach ($Item as $value){
            if ($value["ParentID"]==mb_strtoupper('a63d822a-1fda-11e9-bba7-00155d012807', 'UTF8') 
               ) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=1>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
            }
        }
?>
     </div>
	<div class="cell_group_name" id="children">Детские блюда</div>
	<div class="group">
<?php
     //*************************************************************************
     
     foreach ($Item as $value){
            if ($value["ParentID"]==mb_strtoupper('72a2ff39-4243-11e9-bba7-00155d012807', 'UTF8')
               ) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=1>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
			    
            }
        }
    
?>
     </div>

</body>	
</html>