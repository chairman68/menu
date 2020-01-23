<?php
require_once ("lib/db_Restart.php");

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
<div id="choice_prod" aria-hidden="true">
    
    <div class="header-choice">
      Блюда на раздачу </br>  
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
        

        <div class="cell_group_name">Сейчас в продаже</div>
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

    	
        <div class="cell_group_name">Салаты и холодные закуски</div>
    	<div class="group" id="salad">
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


    	<div class="cell_group_name">Первые блюда</div>
    	<div class="group" id="soup">
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
    	<div class="group" id="vtor">
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
    	<div class="group" id="garnir">
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
    	<div class="group" id="cake">
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
    	<div class="group" id="napitki">
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