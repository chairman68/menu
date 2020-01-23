<?php 
/*Вывод текущего меню на раздаче*/
/* 25.02.2019 */
session_start();
include ("lib/db_Restart.php");

$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

$db = new orange\db_Restart ($config,0);

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
			WHERE [dbo].[tb_MenuItem].[LinkID] = '".$config->ID_MENU_BUFET."'
			AND [dbo].[tb_MenuItem].[Stopped]=0
			AND [dbo].[tb_MenuItem].[ProdID]=[dbo].[tb_Product].[ObjID]
			ORDER BY [dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";

$Item = $db->query($tsql);
$db->close_connection();
?>

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="css/common.css" rel="stylesheet">
    <title>Меню на раздаче</title>
    <style>
        th {
                background-color: bisque;
                color: crimson;
                font-family: sans-serif;
                font-size: 14pt;
        }
		.navi {
                width: 100px;
                height: 100px;
                border: solid grey 1px;
                position: fixed;
                border-radius: 10px;
                right: 10px;
                cursor: pointer;
				z-index: 100;
				background-color: white;
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
            text-align: left;
            background-color: beige;
        }
        #main {
            text-align: center;
            font-family: sans-serif;
            font-size: 20pt;
        }
	</style>
</head>

<body>
	<a class="navi" href="main_kitchen.php"
     style="
                background-image: url('Images/x.png');
                top: 5px;">

</a>


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
<?php require 'status_bar.php';?>
<div id="main">
    Меню на сегодня </br>

 <table cellpadding="5px" align = "center"><tr>
    <th>Наименование</th>
    <th>Выход</th>
	<th>Цена</th>
    
 </tr>
<?php	
	
    foreach ($config->prod_group as $prod_group) {
        
		echo '<tr><td colspan="3" class="cell_group_name">'.$prod_group->name.'</td></tr>';	

             foreach ($Item as $value){
                foreach ($prod_group->group_ID as $group_ID) {
                    if ($value["ParentID"]==$group_ID) {
                    echo '<tr>';
                                echo '<td class ="cellname">' . $value["Name"]. '</td>';
                                echo '<td class ="celloutput">' . $value["Output"]. '</td>';
                                echo '<td class ="cellprice">' . number_format($value["Price"],0). ' руб.</td>';
        			 		echo '</tr>';
        	        }
                }
             }
            
     }
    
   
    echo ' </table>';
?>
	
</html>
