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
			WHERE [dbo].[tb_MenuItem].[LinkID] = '44F21079-2737-4807-8B60-C02F717141E0'
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
        }
		.cellname{
			font-family: sans-serif;
            font-size: 16pt;
            width: 500px;
            text-align: left;
            border-bottom: dotted 1px grey;
		}
        .celloutput{
			font-family: sans-serif;
            font-size: 16pt;
            width: 150px;
            text-align: center;
            border-bottom: dotted 1px grey;
		}
        .cellprice {
            font-family: sans-serif;
            font-size: 16pt;
            width: 150px;
            text-align: right;
            border-bottom: dotted 1px grey;
        }
        
        .cell_group_name {
            color: #24b535;
            font-family: sans-serif;
            font-size: 18pt;
            text-align: center;
            background-color: beige;
        }
		.cellrecipe {
			font-family: sans-serif;
            font-size: 14pt;
            width: 150px;
            text-align: center;
            border-bottom: dotted 1px grey;	
		}
        .printable {
            width: 50px;
            border-bottom: dotted 1px grey;
        }
        #main {
            position: relative;
            text-align: center;
            font-family: sans-serif;
            font-size: 20pt;
            top:70px;
        }
        table th {
            background-color: bisque;
            color: crimson;
            font-family: sans-serif;
            font-size: 14pt;   
        }
        #wrapper {
            width: 100%;
            height: 70px;
            position: fixed;
            background-color: lightgray;
            z-index: 100;
        }
		#menu {
			margin: auto;
            width: 1000px;
            height: 70px;
            background-color: lightgray;
            z-index: 100;
        }
        .menu_button {
            width: 50px;
            height: 50px;
            border-radius: 5px;
            border: solid 1px gray;
            float: left;
            margin: 10px;
            text-align: center;
            cursor: pointer;
        }
		.inputWeight{
			font-size:16pt;
			border:none;
			text-align:center;
		}
        #printA3 {
			background-image: url(Images/printerA3.png);
            background-size: cover;
        }
        #printA4 {
            background-image: url(Images/printerA4.png);
            background-size: cover;
        }
	</style>
</head>

<body>
    <div id="wrapper">
		<div id="menu"> 
			<div class="menu_button" id="printA4" onclick="printLabels('A4');"></div>
			<div class="menu_button" id="printA3" onclick="printLabels('SRA3');"></div>
			<div><img src="Images/printer.png" width="30px" height="30px"></br><input type="checkbox" onchange="setAllCheckboxes()" id="printall" value="1"></div>
		</div>    
	</div>
<div id="main">
    
    Блюда на раздачу </br>

 <table cellpadding="5px" align = "center">
     <tr>
         <th ><img src="Images/printer.png" width="30px" height="30px"></br><input type="checkbox" onchange="setAllCheckboxes()" id="printall" value="1"></th>
        <th>Наименование</th>
        <th>Выход</th>
        <th >Цена</th>
		<th >Рецептура</th>
     </tr>
<?php	
echo '<tr><td colspan="4" class="cell_group_name">Салаты и холодные закуски</td></tr>',PHP_EOL;	
 foreach ($Item as $value){
        if ($value["ParentID"]=='3D4880A2-1FA0-11E9-BBA7-00155D012807'){
            echo '<tr>',PHP_EOL;
                echo '<td class = "printable"><input type="checkbox" onchange="setCheckAll()" name="print" value="'.$value["ID"].'"></td>',PHP_EOL;
                echo '<td class ="cellname">' . $value["Name"]. '</td>',PHP_EOL;
				echo '<td class ="celloutput">' . '<input class="inputWeight" type="text" size="5" onChange="changeWeight(this.value,\''.$value["ID"].'\')" name="weight" value="'.$value["Output"].'" ></input>'. '</td>',PHP_EOL;
                echo '<td class ="cellprice">' . number_format($value["Price"],0). ' руб.</td>',PHP_EOL;
				echo '<td class ="cellrecipe"><a href=recipe_restart.php?ProdID=' . $value["ProdID"]. '>Рецептура</td>',PHP_EOL;
            echo '</tr>',PHP_EOL;
        }
}
     
     //*************************************************************************
     echo '<tr><td colspan="4" class="cell_group_name">Первые блюда</td></tr>',PHP_EOL;
		
	 foreach ($Item as $value){
            if ($value["ParentID"]=='240709B4-1FBF-11E9-BBA7-00155D012807') {
            echo '<tr>',PHP_EOL;
                echo '<td class = "printable"><input type="checkbox" onchange="setCheckAll()" name="print" value="'.$value["ID"].'"></td>',PHP_EOL;
                echo '<td class ="cellname">' . $value["Name"]. '</td>',PHP_EOL;
                echo '<td class ="celloutput">' . $value["Output"]. '</td>',PHP_EOL;
                echo '<td class ="cellprice">' . number_format($value["Price"],0). ' руб.</td>',PHP_EOL;
				echo '<td class ="cellrecipe"><a href=recipe_restart.php?ProdID=' . $value["ProdID"]. '>Рецептура</td>',PHP_EOL;
            echo '</tr>',PHP_EOL;
                //$itogo=$itogo+$value["kolvo"];
            }
        }
     //*************************************************************************
     echo '<tr><td colspan="4" class="cell_group_name">Вторые блюда</td></tr>',PHP_EOL;	
	 foreach ($Item as $value){
            if ($value["ParentID"]=='70A63B0B-1FC2-11E9-BBA7-00155D012807'      //Каши
                or $value["ParentID"]=='70A63B0C-1FC2-11E9-BBA7-00155D012807'   //Овощные
                or $value["ParentID"]=='70A63B0D-1FC2-11E9-BBA7-00155D012807'   //Рыбные
                or $value["ParentID"]=='70A63B0E-1FC2-11E9-BBA7-00155D012807'   //Птица
                or $value["ParentID"]=='70F63B0F-1FC2-11E9-BBA7-00155D012807'   //Мясные натуральные
                ) {
            echo '<tr>',PHP_EOL;
                echo '<td class = "printable"><input type="checkbox" onchange="setCheckAll()" name="print" value="'.$value["ID"].'"></td>',PHP_EOL;
                echo '<td class ="cellname">' . $value["Name"]. '</td>',PHP_EOL;
                echo '<td class ="celloutput">' . $value["Output"]. '</td>',PHP_EOL;
                echo '<td class ="cellprice">' . number_format($value["Price"],0). ' руб.</td>',PHP_EOL;
				echo '<td class ="cellrecipe"><a href=recipe_restart.php?ProdID=' . $value["ProdID"]. '>Рецептура</td>',PHP_EOL;
            echo '</tr>',PHP_EOL;
	        }
        }
     //*************************************************************************
     echo '<tr><td colspan="4" class="cell_group_name">Гарниры</td></tr>',PHP_EOL;	
     foreach ($Item as $value){
            if ($value["ParentID"]=='5DE67B58-1FCC-11E9-BBA7-00155D012807'      //Гарниры
               ) {
            echo '<tr>',PHP_EOL;
                echo '<td class = "printable"><input type="checkbox" onchange="setCheckAll()" name="print" value="'.$value["ID"].'"></td>',PHP_EOL;
                echo '<td class ="cellname">' . $value["Name"]. '</td>',PHP_EOL;
                echo '<td class ="celloutput">' . $value["Output"]. '</td>',PHP_EOL;
                echo '<td class ="cellprice">' . number_format($value["Price"],0). ' руб.</td>',PHP_EOL;
				echo '<td class ="cellrecipe"><a href=recipe_restart.php?ProdID=' . $value["ProdID"]. '>Рецептура</td>',PHP_EOL;
            echo '</tr>',PHP_EOL;
            }
        }
     //*************************************************************************
     echo '<tr><td colspan="4" class="cell_group_name">Десерты, выпечка</td></tr>',PHP_EOL;	
     foreach ($Item as $value){
            if ($value["ParentID"]=='5DE67B66-1FCC-11E9-BBA7-00155D012807'//Выпечка
               ) {
            echo '<tr>',PHP_EOL;
                echo '<td class = "printable"><input type="checkbox" onchange="setCheckAll()" name="print" value="'.$value["ID"].'"></td>',PHP_EOL;
                echo '<td class ="cellname">' . $value["Name"]. '</td>',PHP_EOL;
                echo '<td class ="celloutput">' . $value["Output"]. '</td>',PHP_EOL;
                echo '<td class ="cellprice">' . number_format($value["Price"],0). ' руб.</td>',PHP_EOL;
				echo '<td class ="cellrecipe"><a href=recipe_restart.php?ProdID=' . $value["ProdID"]. '>Рецептура</td>',PHP_EOL;
            echo '</tr>',PHP_EOL;
            }
        }
     //*************************************************************************
     echo '<tr><td colspan="4" class="cell_group_name">Напитки</td></tr>',PHP_EOL;	

     foreach ($Item as $value){
            if ($value["ParentID"]=='5DE67B83-1FCC-11E9-BBA7-00155d012807'//Напитки
               ) {
            echo '<tr>',PHP_EOL;
                echo '<td class = "printable"><input type="checkbox" onchange="setCheckAll()" name="print" value="'.$value["ID"].'"></td>',PHP_EOL;
                echo '<td class ="cellname">' . $value["Name"]. '</td>',PHP_EOL;
                echo '<td class ="celloutput">' . $value["Output"]. '</td>',PHP_EOL;
                echo '<td class ="cellprice">' . number_format($value["Price"],0). ' руб.</td>',PHP_EOL;
				echo '<td class ="cellrecipe"><a href=recipe_restart.php?ProdID=' . $value["ProdID"]. '>Рецептура</td>',PHP_EOL;
            echo '</tr>',PHP_EOL;
			    
            }
        }
    
    echo ' </table>',PHP_EOL;
?>

</body>	
</html>