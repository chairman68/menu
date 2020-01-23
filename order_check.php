<?php
/**
 * Created by PhpStorm.
 * User: vova
 * Date: 21.10.14
 * Time: 0:24
 */
// Создание SOAP-клиента по WSDL-документу
$client = new SoapClient("http://192.168.1.55:29121/wsdl/IRestWebServ");

// Поcылка SOAP-запроса и получение результата
?>
<?
$request1 = <<<XML1
<?xml version="1.0" encoding="UTF-8"?>
<Request work="1" name="Food" DeviceID="server">
	<Unloads>
		<Object name="Order" cond="Num='
XML1;


$request3 = <<<XML3
<?xml version="1.0" encoding="UTF-8"?>
<Request work="1" name="Food">
	<Unloads>
		<Object name="Check" cond="OrdNum='
XML3;

$request2 = <<<XML2
'" />
	</Unloads>
</Request>
XML2;
?>
<?
$request=$request1.$_GET["order"].$request2;
$resultSOAP = $client->ExecRequest($request);
$resultSOAP = str_replace ("UTF-16","UTF-8",$resultSOAP);
$ResponseOrder = simplexml_load_string($resultSOAP);
// В $Response лежит ответ кассового сервера в виде объекта simplexml
//print_r($ResponseOrder);

//$request=$request3.$_GET["order"].$request2;
//$resultSOAP = $client->ExecRequest($request);
//$resultSOAP = str_replace ("UTF-16","UTF-8",$resultSOAP);
//$ResponseCheck = simplexml_load_string($resultSOAP);
// В $Response лежит ответ кассового сервера в виде объекта simplexml

//print_r($ResponseCheck);




// Функция вытаскивания даты и времени из строковой Time Stamp
function explodeTimeStamp ($str){
    list ($datetime["date"],$datetime["time"] ) = sscanf($str,"%s %s");
    return $datetime;
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
        
        <?
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
        $begin_time=explodeTimeStamp($ResponseOrder->Unloads->Object[0]->Properties['DateRsrv']);
        $year=strtok($begin_time["date"],".");
        $month_int=(int)strtok(".");
        $day=strtok(".");
        $time=strtok($begin_time["time"],":").'-'.strtok(":");
		$min_sum = 38500; // минимальная сумма на низкий сезон
		if ($month_int>5 and $month_int<10) {
			$min_sum = 49500; // минимальная сумма на высокий сезон
		}
		
        ?>
        <tr>
            <td colspan="3" style="padding:10px; font-size: 20pt; font-style: bold;">
                Дата банкета <span style="font-size: 24pt;"><?=$day?> <?=$mounth[$month_int]?> <?=$year?> г. </span><?=$time?>
            </td>
        </tr>
        <tr >
            <td colspan="2"  style="text-align: left; padding-left: 20px;">
                Заказчик:        <span style="font-size: 18pt;"><?=$ResponseOrder->Unloads->Object[0]->Properties['NameRsrv'];?></span>
            </td>
            <td rowspan="2" style="border: solid grey 1px; border-radius: 10px;">
                Количество гостей </br> <span style="font-size: 32pt;"><?=$ResponseOrder->Unloads->Object[0]->Properties['Seats'];?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; padding-left: 20px;">
                Информация: <span style="font-size: 16pt;"><?=$ResponseOrder->Unloads->Object[0]->Properties['InfoRsrv'];?></span>
            </td>

        </tr>
        <tr>
            <td height="40px" style="text-align: left;padding-left: 20px;" ">
            Бронирование зала №<?=$_GET["order"]?> от <?=$ResponseOrder->Unloads->Object[0]->Properties['DateAdd'];?>
            </td>
            <td style="text-align: right;">
                Администратор:
            </td>
            <td >
                <?=$ResponseOrder->Unloads->Object[1]->Properties['Name'];?>
            </td>
        </tr>
		<tr>
            <td height="40px" style="text-align: left;padding-left: 20px;" ">
            Время закрытия смены <?=$ResponseOrder->Unloads->Object[0]->Properties['DateShift'];?>
            </td>
            <td style="text-align: right;">
               
            </td>
            <td >
               
            </td>
        </tr>

    </table>
<? //   --------------  Вывод таблицы с составом заказа --------------------?>
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
       <? // ------------- Цикл построчного вывода позиций -------------------

        for ($i=0;$ResponseOrder->Unloads->Object[0]->Link->Item[$i]<>null;$i++) {

        $ProdID=$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["ProdID"];
        $numstr=$i+1;
            // ------------- Получение данных о продукте из связанной таблицы Product -------
            foreach ($ResponseOrder->Unloads->Object as $object){

                if ($object["name"]=="Product"){

                    foreach ( $object->Properties as $Properties){

                        if ((string)$Properties[ID]==(string)$ProdID) {
                            $prodname = $Properties[Name];
                            $prodweight=$Properties[Output];
                            $unit=$Properties[Unit];
                            $product_type=$Properties["Type"];
                        }
                    }
                }
            }



            // --------- вывод строки заказа -------------------
            if ($ResponseOrder->Unloads->Object[0]->Link->Item[$i]["Status"]<>"3") {
                echo '  <tr>
                        <td class="tab1" style="border-left: solid 1px">' . $numstr . '</td>
                        <td class="tab1" style="text-align:left;">' . $prodname . '</td>
                        <td class="tab1">'.$prodweight.'</td>
                        <td class="tab1" style="text-align: right; padding-left: 15px;">'.$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["Count"].'</td>
                        <td class="tab1">'.$unit.'</td>
                        <td class="money" style="text-align: right;">'.number_format((float)$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["Price"],2,"."," ").' </td>
                        <td class="tab1" style="text-align: right;">'.number_format((float)$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["TotalDiscSum"],2,"."," ").' </td>
                        <td class="tab1"  style="text-align: right;">'.number_format((float)$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["TotalSum"],2,"."," ").' </td>

                    </tr>';
                $order_total=$order_total+$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["TotalSum"];
                $discount_total=$discount_total+$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["TotalDiscSum"];
                $weight_total=$weight_total+($prodweight*$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["Count"]);
                if ($product_type=="3"){
                    $dishes_total=$dishes_total+$ResponseOrder->Unloads->Object[0]->Link->Item[$i]["TotalSum"];
                }

            }
        }
        ?>
        <?// ------------  Вывод строк таблицы с итоговыми суммами ------------------?>
        <tr>
            <td colspan="6" style="border-top: solid 1px; text-align: right;">ИТОГ:</td>
            <td style="border-top: solid 1px;text-align: right;"><?=number_format($discount_total,2,"."," ")?></td>
            <td style="border-top: solid 1px;text-align: right;"><?=number_format($order_total,2,"."," ")?></td>

        </tr>

       

        <tr>
            <td colspan="8" style="border-top: solid grey 2px;">

            </td>

        </tr>
        <tr>
            <td  colspan="2" rowspan="2" style="font-size: 16px;">Справочная информация:</td>
            <td colspan="5" style="text-align: right;">Стоимость блюд в расчете на одного гостя:</td>
            <td style="text-align: right;"><?=round($dishes_total/$ResponseOrder->Unloads->Object[0]->Properties['Seats'])?> руб.</td>

        </tr>
        <tr>
            <td colspan="5" style="text-align: right;">Вес блюд в расчете на одного гостя:</td>
            <td style="text-align: right;"><?=round($weight_total/$ResponseOrder->Unloads->Object[0]->Properties['Seats'])?> г.</td>

        </tr>
    </table>

</div>
<div style="position:absolute; top: 0;left:0;visibility: hidden; text-align: center;" id="kitchen">
    <? include("kitchen.php");?>
</div>

<div style="visibility: hidden; text-align: justify;" id="contract">
    <? include("contract.php");?>
</div>

</body>

</html>