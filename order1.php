<?php
function FormatErrors( $errors )
{
    /* Display errors. */
    echo "Error information: ";

    foreach ( $errors as $error )
    {
        echo "SQLSTATE: ".$error['SQLSTATE']."";
        echo "Code: ".$error['code']."";
        echo "Message: ".$error['message']."";
    }
}

$serverName = "CASH\RESTART";
$connectionOptions = array(
    "Database" => "CAFE",
    "Uid" => "sa",
    "PWD" => "rarus12",
	"CharacterSet" => "UTF-8"
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
if(!$conn){
    echo "Нет подключения к серверу БД!";
} 

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
			

//print($tsql);
$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $Order[$i]=$row;
    $i++;
}

sqlsrv_free_stmt($getResults);

$tsql= "SELECT 
              item.[Count],
              item.[Price],
              item.[TotalDiscSum],
              item.[TotalSum],
              item.[Status],
			  prod.[Name],
			  prod.[Output],
              prod.[Type],
			  prod.[Unit]
			FROM  [dbo].[tb_Order], [dbo].[tb_OrdItem] item
            LEFT OUTER JOIN [dbo].[tb_Product] prod ON prod.[ObjID]=item.[ProdID]
            LEFT OUTER JOIN [dbo].[tb_MenuItem] menu 
            ON (prod.[ObjID]=menu.[ProdID] AND menu.[LinkID]=item.[MenuID])
			WHERE item.[LinkID]=[dbo].[tb_Order].[ObjID]
			AND [dbo].[tb_Order].[Num]=".$_GET["order"]."
            ORDER BY item.[MenuID], menu.[Pos]";
			

//print($tsql);
$getResults= sqlsrv_query($conn, $tsql);

if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
$i=1;
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $Order_item[$i]=$row;
    $i++;
}
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

            #contract {
                width: 800px;
            }

            #tabcontract {
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
<script type="text/javascript">
    var keyswitch=1;
    document.getElementById('order').style.visibility='visible';
    document.getElementById('kitchen').style.visibility='hidden';
    document.getElementById('contract').style.visibility='hidden';
</script>
<div class="navi" onclick="
                    keyswitch=keyswitch+1;
                    if (keyswitch>3) keyswitch=1;
                    switch (keyswitch){
                        case 1:
                            document.getElementById('order').style.visibility='visible';
                            document.getElementById('kitchen').style.visibility='hidden';
                            document.getElementById('contract').style.visibility='hidden';
                        break;

                        case 2:
                            document.getElementById('order').style.visibility='hidden';
                            document.getElementById('kitchen').style.visibility='visible';
                            document.getElementById('contract').style.visibility='hidden';
                        break;

                        case 3:
                            document.getElementById('order').style.visibility='hidden';
                            document.getElementById('kitchen').style.visibility='hidden';
                            document.getElementById('contract').style.visibility='visible';
                        break;
                        default :
                            document.getElementById('order').style.visibility='visible';
                            document.getElementById('kitchen').style.visibility='hidden';
                            document.getElementById('contract').style.visibility='hidden';
                            $switch=1;
                        break;

                    }"

         style="background-image: url('Images/contract.png');
                top: 300px;

         ">
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

<div id="order"
     style="width:800px;
            position: absolute;
            text-align: center;
            margin: auto;
     ">




    <table cellspacing="0" style="border-bottom: solid grey 2px; border-top: solid grey 2px; border-collapse:collapse; " width="790px">
        <tr>
            <td colspan="2" style="text-align: left; padding: 20px; border-bottom: solid grey 2px; font-size: 14pt;">
                ИП Степановский Владимир Александрович </br>
                ОГРНИП 312352806100032 ИНН 352813849901 </br>
                кафе "Три Апельсина" г.Череповец ул. Комарова д.5</br>
                телефон 50-77-00</br>
                e-mail cafe@triapelsina.ru</br>
                Интернет сайт: 	http://triapelsina.ru</br>
                Группа ВКонтакте: 	https://vk.com/3apelsina
            </td>
            <td>
                <img src="Images/logo.png">
            </td>

        </tr>
        <?php
        $mounth=array(
            1=>"января",
            2=>"февраля",
            3=>"марта",
            4=>"апреля",
            5=>"мая",
            6=>"июня",
            7=>"июля",
            8=>"августа",
            9=>"сентября",
            10=>"октября",
            11=>"ноября",
            12=>"декабря");
        
		$min_sum = 45000; // минимальная сумма на низкий сезон
		$condition = ' ЗАКАЗЧИК обязуется в срок, указанный в п. 2.2., сделать заказ по блюдам кухни  на сумму не менее чем 45 000 руб. и из расчета не менее 1250 рублей на одного гостя.  '; //Условия на низкий сезон
		if ($month_int>5 and $month_int<10) {
			$min_sum = 50000; // минимальная сумма на высокий сезон
			$condition = ' ЗАКАЗЧИК обязуется в срок, указанный в п. 2.2., сделать заказ по блюдам кухни  на сумму не менее чем 50 000 руб. и из расчета не менее 1250 рублей на одного гостя.  '; //Условия на высокий сезон
		}
		
        ?>
        <tr>
            <td colspan="3" style="padding:10px; font-size: 20pt; font-style: bold;">
                Начало банкета <span style="font-size: 24pt;"><?=$Order[1]["DateRsrv"]->format("d.m.Y в H-i")?> </span>
            </td>
        </tr>
        <tr >
            <td colspan="2"  style="text-align: left; padding-left: 20px;">
                Заказчик:        <span style="font-size: 18pt;"><?=$Order[1]["NameRsrv"];?></span>
            </td>
            <td rowspan="2" style="border: solid grey 1px; border-radius: 10px;">
                Количество гостей </br> <span style="font-size: 32pt;"><?=$Order[1]["Seats"];?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; padding-left: 20px;">
                Информация: <span style="font-size: 16pt;"><?=$Order[1]["InfoRsrv"];?></span>
            </td>

        </tr>
        <tr>
            <td height="40px" style="text-align: left;padding-left: 20px;" >
            Бронирование зала №<?=$_GET["order"]?> от <?=$Order[1]["DateAdd"]->format("d.m.Y");
			?>
            </td>
            <td style="text-align: right;">
                Администратор:
            </td>
            <td >
                <?=$Order[1]["Name"];?>
            </td>
        </tr>


    </table>
<?php //   --------------  Вывод таблицы с составом заказа --------------------?>
    <span style="text-align: center;line-height: 50px; font-size: 20pt;">Состав заказа</span>

    <table cellspacing="0" width="800px" style="padding: 5px;">
        <tr>
            <td class="td1" style="border-left: solid 1px;">№</td>
            <td class="td1">Наименование</td>
            <td class="td1">Выход,г</td>
            <td class="td1">Кол-во</td>
            <td class="td1">Ед</td>
            <td class="td1">Цена</td>
            <td class="td1">Скидка</td>
            <td class="td1">Стоимость</td>

        </tr>
       <?php // ------------- Цикл построчного вывода позиций -------------------
    
        for ($i=1;$Order_item[$i];$i++) {

        
        

            // --------- вывод строки заказа -------------------
            if ($Order_item[$i]["Status"]=="1") {
                echo '  <tr>
                        <td class="tab1" style="border-left: solid 1px">' . $i . '</td>
                        <td class="tab1" style="text-align:left;">' . $Order_item[$i]["Name"] . '</td>
                        <td class="tab1">'.$Order_item[$i]["Output"].'</td>
                        <td class="tab1" style="text-align: right; padding-left: 15px;">'.number_format($Order_item[$i]["Count"],1,"."," ").'</td>
                        <td class="tab1">'.$Order_item[$i]["Unit"].'</td>
                        <td class="money" style="text-align: right;">'.number_format((float)$Order_item[$i]["Price"],2,"."," ").' </td>
                        <td class="tab1" style="text-align: right;">'.number_format((float)$Order_item[$i]["TotalDiscSum"],2,"."," ").' </td>
                        <td class="tab1"  style="text-align: right;">'.number_format((float)$Order_item[$i]["TotalSum"],2,"."," ").' </td>

                    </tr>';
                $order_total=$order_total+(float)$Order_item[$i]["TotalSum"];
                $discount_total=$discount_total+(float)$Order_item[$i]["TotalDiscSum"];
                $weight_total=$weight_total+($Order_item[$i]["Output"]*$Order_item[$i]["Count"]);
                if ($Order_item[$i]["Type"]==3){
                    $dishes_total=$dishes_total+$Order_item[$i]["TotalSum"];
                }
            }
        }
        ?>
        <?php // ------------  Вывод строк таблицы с итоговыми суммами ------------------?>
        <tr>
            <td colspan="6" style="border-top: solid 1px; text-align: right;">ИТОГ:</td>
            <td style="border-top: solid 1px;text-align: right;"><?=number_format($discount_total,2,"."," ")?></td>
            <td style="border-top: solid 1px;text-align: right;"><?=number_format($order_total,2,"."," ")?></td>

        </tr>

        <tr>
            <td colspan="6" style="text-align: right;">Сумма аванса:</td>
            <td></td>
            <td style="text-align: right;"><?=number_format((float)$Order[1]["AvansSum"],2,"."," ")?></td>

        </tr>
        <tr>
            <td colspan="6" style="text-align: right;">Сумма к доплате:</td>
            <td></td>
            <td style="text-align: right;"><?=number_format($order_total-$Order[1]["AvansSum"],2,"."," ")?></td>

        </tr>

        <tr>
            <td colspan="8" style="border-top: solid grey 2px;">

            </td>

        </tr>
        <tr>
            <td  colspan="2" rowspan="2" style="font-size: 16px;">Справочная информация:</td>
            <td colspan="5" style="text-align: right;">Стоимость блюд в расчете на одного гостя:</td>
            <td style="text-align: right;"><?=round($dishes_total/$Order[1]["Seats"])?> руб.</td>

        </tr>
        <tr>
            <td colspan="5" style="text-align: right;">Вес блюд в расчете на одного гостя:</td>
            <td style="text-align: right;"><?=round($weight_total/$Order[1]["Seats"])?> г.</td>

        </tr>
    </table>

</div>
<div style="position:absolute; top: 0;left:0;visibility: hidden; text-align: center;" id="kitchen">
    <?php include("kitchen.php"); // Вставка формы заказа для кухни?>
</div>

<div style="visibility: hidden; text-align: justify;" id="contract">
    <?php include("contract.php"); // Вставка формы для печати договора?>
</div>

</body>

</html>