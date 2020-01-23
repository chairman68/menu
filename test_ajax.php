<?php 
include ("lib/db_Restart.php");

$config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы

$db= new orange\db_Restart ($config,0);


		$tsql= "SELECT 
              [dbo].[tb_MenuItem].[ParentID],
              [dbo].[tb_MenuItem].[ID],
              [dbo].[tb_MenuItem].[Stopped],
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
            ORDER BY [dbo].[tb_MenuItem].[Stopped],[dbo].[tb_MenuItem].[ParentID], [dbo].[tb_MenuItem].[Pos]";

$Item = $db->query($tsql);

$db->close_connection();

?>

<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


    <title>Выпуск блюд</title>
    <style>
        body {
            margin: 0;
            padding: 0;
			font-family: sans-serif;
            font-size: 20pt;
			cursor: none;
            height: 100%;
            width: 100%;
            display: flex;
            flex-direction: column;
            -webkit-overflow-scrolling:touch;
            cursor: auto;
        }
        button {
            font-size: 14pt;
        }
        table {
            font-size: 14pt;
            border-collapse: collapse;
            border: 1px solid grey;

        }
        td,th {
            padding: 5px;
            border: 1px solid grey;
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
		.group {
			display: flex;
			flex-wrap: wrap;
			background-color: gray;
            min-height: 90%;
            align-content: flex-start;
		}
		.item_link {
			width: 160px;
			height: 70px;
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
		}
		
        
        .cell_group_name {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #24b535;
            font-family: sans-serif;
            font-size: 24pt;
            text-align: center;
            background-color: beige;
			height: 10%;
        }
        #add-new-output {
            bottom: 10px;
            margin: auto;
            position: fixed;
            left:0;
            right: 0;
            font-size: 14pt;
            text-align: center;
        }
		#list_outputs {
            margin: auto;
            position: fixed;
            width: 100%;
            height: 100%;

             
        }
        #choice_prod {
            width: 100%;
            height: 60%;
            padding-right: 110px;
			position: fixed;
            text-align: center;
            font-family: sans-serif;
            font-size: 14pt;
            top:40%;
            overflow: scroll;
            visibility: hidden;
            display: flex;
			
        }
        .header-choice {
            width: 100%;
            height: 10%;
            background-color: red;
            position: fixed;
        }
		#menu {
			margin: auto;
            width: 150px;
            height: 100%;
            background-color: gray;
            z-index: 99;
			display: flex;
            flex-direction: column;
            position: fixed;
			
        }
        .menu-list {
            -webkit-overflow-scrolling:touch;
            overflow-y: scroll;
            position: relative;
            margin-left:   150px;


        }
        .menu_button {
            height: 60px;
			width: 100px;
            border-radius: 5px;
            border: solid 1px gray;
            margin: 5px;
			padding: 5px;
            text-align: center;
			text-decoration: none;
			font-size: 16pt;
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

        
        
        #contaner-form-output {
            position: fixed;
            width: 100%;
            height: 60%;
            top: 40%;
            background-color: #fff;
            visibility: hidden;
        }
        #production-form {
            margin: 20px auto;
            max-width: 95%;
            padding: 30px 30px 6px 30px;
            border: 1px solid rgba(0,0,0,.2);
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
            border-radius: 5px;
            -moz-background-clip: padding;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            background: rgba(255,255,255,.4); 
            -moz-box-shadow: 0 0 13px 3px rgba(0,0,0,.5);
            -webkit-box-shadow: 0 0 13px 3px rgba(0,0,0,.5);
            box-shadow: 0 0 13px 3px rgba(0,0,0,.5);
            overflow: hidden;
            display: flex;
            flex-direction: column; 
        }
        #production-form input {
            width: 90%;
            height: 70px;
            border: 1px solid rgba(0,0,0,.4);
            -moz-border-radius: 4px;
            -webkit-border-radius: 4px;
            border-radius: 4px;
            -moz-background-clip: padding;
            -webkit-background-clip: padding-box;
            background-clip: padding-box; 
            display:block;
            font-family: 'Open Sans', sans-serif;
            font-size:24px;
            font-weight: 300;    
            color:black;
            padding-left:20px;
            padding-right:20px;
            margin-bottom:20px;
        }
        #chk-form-output:checked + form {
            visibility: visible;
        }
        .fix-header {
            text-align: center;
        }
        .table-row {
            display: flex;
            width: 100%;
            height: 50px;
            border-bottom: 1px solid gray;
            border-top: 1px solid gray;
            font-size: 14pt;
        }
        .tb-header {
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 500;
            text-align: center;
        }
        .tb-cell {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .tb-num {
            flex: 1 1 10%;
            border-right : 1px solid gray;
        
        }
        .tb-datetime {
            flex: 1 1 20%;
            border-right : 1px solid gray;
        
        }
        .tb-prodname {
            flex: 1 1 40%;
            border-right : 1px solid gray;
        
        }
        .tb-kolvo {
           flex: 1 1 15%;
           border-right : 1px solid gray;
        }
        .tb-test {
           flex: 1 1 15%;
           border-right : 1px solid gray;
           border-left : 1px solid gray;
            
        }
	</style>

<script src="js/production-list.js" defer ></script>


</head>

<body>
<?php // Навигация ---------------------------------------?>
<!--<a class="navi" href="main_kitchen.php"
     style="
                background-image: url('Images/x.png');
                top: 5px;">

</a> -->




<div id="list_outputs">
    <div class="fix-header">Выпуски блюд за <?=date('d.m.yy')?></div>
    <div  id="output">
    </div>    

    <button class="item_link" id="add-new-output" onclick="open_choice_list()" >Добавить новый выпуск продукции</button> 
</div>


	
<?php // Окно выбора продукта для выпуска ?>


<div id="choice_prod" aria-hidden="true">
    
    <div class="header-choice">
        
    </div>

    <div id="menu">
        <a class="menu_button" href="#salad">Салаты</a>
        <a class="menu_button" href="#soup">Первые</a>
        <a class="menu_button" href="#vtor">Вторые</a>
        <a class="menu_button" href="#garnir">Гарниры</a>
        <a class="menu_button" href="#cake">Выпечка</a>
        <a class="menu_button" href="#napitki">Напитки</a>
    </div>  
    <div class="menu-list">
        Блюда на раздачу </br>

        <div class="cell_group_name" id="salad">Сейчас в продаже</div>
        <div class="group">
            <?php
            foreach ($Item as $value){
                    if ($value["Stopped"]==0 AND $value["IsGroup"]==0) {
                        echo '<button class= "item_link" data-prodid="' . $value["ProdID"]. '" data-prodname="' . $value["Name"]. '" onClick = "open_form_output(this)">',PHP_EOL;
                        echo $value["Name"],PHP_EOL;    
                        echo '</label>',PHP_EOL;
                    }
            }


            ?>
        </div>

    	
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
    </div>    
</div>



<div id="contaner-form-output">
    <form id="production-form" metod="POST">
        <input id="input-prodID" type="text" name="prodID" placeholder="Код блюда"  readonly />
        <input id="input-prodname" type="text" name="prodName" placeholder="Наименование блюда"  readonly />
        <input id="input-kolvo" type="number" name="kolvo" placeholder="Количество"   required />
        <input name="submit" class="menu_button" type="submit" value="Оформить выпуск продукции" />
        <input type="reset" name="cancel" class="menu_button" value="Отмена" onclick="close_form_output()" >   
    </form>

</div>

</body>


<script type="text/javascript">
    
</script>
</html>