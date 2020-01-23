<?php
include ("functions.php");



		$tsql= "SELECT 
			  [dbo].[tb_Order].[NameRsrv],
              [dbo].[tb_Order].[AvansSum],
			  [dbo].[tb_Order].[InfoRsrv],
			  [dbo].[tb_Order].[Seats],
			  [dbo].[tb_Order].[DateRsrv],
			  [dbo].[tb_Order].[DateAdd],
			  [dbo].[tb_Order].[Num],
			  [dbo].[tb_User].[Name]
			FROM [dbo].[tb_Order], [dbo].[tb_User]
			WHERE [dbo].[tb_Order].[Num]= ".$_GET["order"]."
			AND [dbo].[tb_Order].[UserAddID]=[dbo].[tb_User].[ObjID]";
			

$Order=queryRestArt($tsql);
$tsql= "SELECT 
              item.[Count],
              item.[Price],
              item.[TotalDiscSum],
              item.[TotalSum],
              item.[Status],
			  prod.[Name],
			  prod.[Output],
              prod.[Type],
			  prod.[Unit],
              prnt.[PrnGrpID]
			FROM  [dbo].[tb_Order], [dbo].[tb_OrdItem] item
            LEFT OUTER JOIN [dbo].[tb_Product] prod ON prod.[ObjID]=item.[ProdID]
            LEFT OUTER JOIN [dbo].[tb_Print] prnt ON prnt.[ProdID]=item.[ProdID]
            LEFT OUTER JOIN [dbo].[tb_MenuItem] menu 
            ON (prod.[ObjID]=menu.[ProdID] AND menu.[LinkID]=item.[MenuID])
			WHERE item.[LinkID]=[dbo].[tb_Order].[ObjID]
			AND [dbo].[tb_Order].[Num]=".$_GET["order"]."
            ORDER BY  prnt.[PrnGrpID]";
			
$Order_item=queryRestArt($tsql);
$allparent=allParentID();
$router=prnrouter();

?>







<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>Заказ №<?=$_GET[order]?></title>
    <style>
            .tab1 {
                border-right: solid 1px;
                font-size: 12pt;
                padding-left: 10px;
            }
            .tab2 {
                font-size: 16pt;
                height: 25px;
                border-right: solid 1px;
                border-bottom: dashed grey 1px;
                padding: 10px;
            }

        @media print {
            body {
                padding: 0;
                font-family: serif;
                font-size: 11pt;
            }
            div#order{
                width: 700px;
            }
            .navi{
                display: none;
            }
            #contract{
                width: 800px;
            }
            #tabcontract{
                vertical-align: top;

            }
            td {
                vertical-align: middle;
            }
            .td1 {
                border-right: solid 1px;
                border-top: solid 1px;
                border-bottom: solid 1px;
                background-color: #d6d6d8;
                font-style: bold;
                height: 25px;
            }

            .money {
                border-right: solid 1px;
                font-size: 12pt;
                padding-left: 10px;
            }

        }
        @page  {
            margin-left: 1.5cm;
            margin-right: 1cm;
            margin-top: 1cm;
            margin-bottom: 1cm;
        }
        
        @media screen {

            body {
                padding: 0;
                font-family: sans-serif;
                font-size: 11pt;
            }

            .navi {
                width: 100px;
                height: 100px;
                border: solid grey 1px;
                position: fixed;
                border-radius: 10px;
                right: 100px;
                cursor: pointer;
            }

            

            td {
                vertical-align: middle;
            }

            .td1 {
                border-right: solid 1px;
                border-top: solid 1px;
                border-bottom: solid 1px;
                background-color: #d6d6d8;
                font-style: bold;
                height: 25px;
            }

            .tab1 {
                border-right: solid 1px;
                font-size: 12pt;
                padding-left: 10px;
            }

            .money {
                border-right: solid 1px;
                font-size: 12pt;
                padding-left: 10px;
            }
        }

    </style>
</head>

<body>
<div class="navi" onClick="history.back()"
     style="
                background-image: url('Images/x.png');
                top: 0px;">

</div>
<div class="navi" onclick="window.print();"

         style="background-image: url('Images/printer.png');
                top: 150px;">
</div>


<div class="navi" onclick="window.scrollBy(0,-100)"
         style="background-image: url('Images/row_up.png');
                top: 450px;
         ">
</div>

<div class="navi" onclick="window.scrollBy(0,100)"
        style=" background-image: url('Images/row_down.png');
                top: 600px;
        ">
</div>


<div style="position:absolute; top: 0;left:0; text-align: center;" id="kitchen">
    <?php
// Вывод таблицы заказа на кухню
?>

    <span style="text-align: center;line-height: 50px; font-size: 20pt;">Заказ для кухни на <?=$Order[1]["DateRsrv"]->format("d.m.Y H-i")?></span> </br>
    

    <table cellspacing="0" width="800px" style="padding: 5px;">
        <tr>
            <td class="td1" style="border-left: solid 1px;">№</td>
            <td class="td1">Наименование</td>
            <td class="td1">Выход,г</td>
            <td class="td1">Кол-во</td>
            <td class="td1">Ед</td>
            <td class="td1">Итого вес</td>
            

        </tr>
       <?php
    //var_dump($Order_item);
        
       for ($i=0;$i<count($Order_item);$i++){
           $Order_item[$i]["prnName"]=get_prnGrpID($item[$i]["prodID"], $router, $allparent);
       }
    customMultiSort($Order_item,'prnName');
        
        for ($i=1;$i<=count($Order_item);$i++) {

           
            if ($Order_item[$i]["Status"]<>3 and $Order_item[$i]["Type"]==3) {
                echo '  <tr>
                        <td class="tab2" style="border-left: solid 1px">' . $i . '</td>
                        <td class="tab2" style="text-align:left;">' . $Order_item[$i]["Name"] . '</td>
                        <td class="tab2">' . $Order_item[$i]["Output"] . '</td>
                        <td class="tab2" style="text-align: right; padding-left: 15px;">' . number_format($Order_item[$i]["Count"],1,"."," ") . '</td>
                        <td class="tab2">' . $Order_item[$i]["Unit"] . '</td>

                        <td class="tab2"  style="text-align: right;">' . number_format((float)$Order_item[$i]["Count"] * (float)$Order_item[$i]["Output"], 0, ".", " ") . ' </td>
                        

                    </tr>';
                
            }
        }
        ?>
    </table>
    
</div>


</body>

</html>