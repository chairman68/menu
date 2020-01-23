<?php 
include ("lib/db_Restart.php");

$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

$db= new orange\db_Restart ($config,0);


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
			WHERE [dbo].[tb_MenuItem].[LinkID] = '44f21079-2737-4807-8b60-c02f717141e0'
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
    <title>Блюда на раздачу</title>
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
 

<!--
<div class="navi" onclick="window.scrollBy(0,-200)"
         style="background-image: url('Images/row_up.png');
                top: 450px;
         ">
</div>

<div class="navi" onclick="window.scrollBy(0,200)"
        style=" background-image: url('Images/row_down.png');
                top: 600px;
        ">
</div> 
-->
	
<div id="menu">
	<a class="menu_button" href="#salad">Салаты</a>
	<a class="menu_button" href="#soup">Первые</a>
	<a class="menu_button" href="#vtor">Вторые</a>
	<a class="menu_button" href="#garnir">Гарниры</a>
	<a class="menu_button" href="#cake">Выпечка</a>
	<a class="menu_button" href="#napitki">Напитки</a>
    <a class="navi" href="main_kitchen.php" style="background: url('Images/x.png') no-repeat; background-position: center,center; background-color:white;"></a>
</div>	
<div id="main">
<div class="cell_group_name" id="salad">Салаты и холодные закуски</div>
	<div class="group">
<?php
foreach ($Item as $value){
        if ($value["ParentID"]=='3D4880A2-1FA0-11E9-BBA7-00155D012807') {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=0>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
        }
}
?>
     </div>
	<div class="cell_group_name" id="soup">Первые блюда</div>
	<div class="group">
<?php		 
     //*************************************************************************
     	
	 foreach ($Item as $value){
            if ($value["ParentID"]=='240709B4-1FBF-11E9-BBA7-00155D012807') {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=0>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
                
            }
        }
?>
     </div>
	<div class="cell_group_name" id="vtor">Вторые блюда</div>
	<div class="group">
<?php	
     //*************************************************************************
  	 foreach ($Item as $value){
            if ($value["ParentID"]=='70A63B0B-1FC2-11E9-BBA7-00155D012807'      //Каши
                or $value["ParentID"]=='70A63B0C-1FC2-11E9-BBA7-00155D012807'   //Овощные
                or $value["ParentID"]=='70A63B0D-1FC2-11E9-BBA7-00155D012807'   //Рыбные
                or $value["ParentID"]=='70A63B0E-1FC2-11E9-BBA7-00155D012807'   //Птица
                or $value["ParentID"]=='70A63B0F-1FC2-11E9-BBA7-00155D012807'   //Мясные 
                ) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=0>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
	        }
        }
?>
     </div>
	<div class="cell_group_name" id="garnir">Гарниры</div>
	<div class="group">
<?php
     //*************************************************************************
     
     foreach ($Item as $value){
            if ($value["ParentID"]=='5DE67B58-1FCC-11E9-BBA7-00155D012807'      //Гарниры
               ) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=0>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
            }
        }
?>
     </div>
	<div class="cell_group_name" id="cake">Выпечка</div>
	<div class="group">
<?php
     //*************************************************************************
     
     foreach ($Item as $value){
            if ($value["ParentID"]=='5DE67B66-1FCC-11E9-BBA7-00155D012807'//Выпечка
               ) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=0>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
            }
        }
?>
     </div>
	<div class="cell_group_name" id="napitki">Напитки</div>
	<div class="group">
<?php
     //*************************************************************************
     
     foreach ($Item as $value){
            if ($value["ParentID"]=='5DE67B83-1FCC-11E9-BBA7-00155D012807'//Напитки
               ) {
            echo '<a class= "item_link"  href=kitchen_recipe.php?ProdID=' . $value["ProdID"]. '&kassa=0>',PHP_EOL;
                echo $value["Name"],PHP_EOL;
				
            echo '</a>',PHP_EOL;
			    
            }
        }
    
?>
     </div>

</body>	
</html>