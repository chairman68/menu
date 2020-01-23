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

$request1 = <<<XML1
<?xml version="1.0" encoding="UTF-8"?>
<Request work="1" name="Food" DeviceID="server">
	<Unloads>
		<Object name="Order" cond="Num='
XML1;
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



$Response = simplexml_load_string($resultSOAP);
// В $Response лежит ответ кассового сервера в виде объекта simplexml
//print_r($Response);

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
        body {
            padding: 0;
            font-family: sans-serif;
            font-size: 11pt;
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
        }


    </style>
</head>

<body>

<div style="width:800px;
            position: absolute;
            text-align: center;
            margin: auto;">

    <div onClick="history.back()"
         style="width: 100px;
                height: 100px;
                border: solid grey 1px;
                background-image: url('Images/x.png');
                position: fixed;
                top: 0px;
                right: 100px;
                border-radius: 10px;">
    </div>
    <div style="width: 100px;
                height: 100px;
                border: solid grey 1px;
                background-image: url('Images/printer.png');
                position: fixed;
                top: 150px;
                right: 100px;
                border-radius: 10px;">
    </div>
    <div style="width: 100px;
                height: 100px;
                border: solid grey 1px;
                background-image: url('Images/contract.png');
                position: fixed;
                top: 300px;
                right: 100px;
                border-radius: 10px;">
    </div>

    <div onclick="window.scrollBy(0,-100)" style="width: 100px;
                height: 100px;
                border: solid grey 1px;
                background-image: url('Images/row_up.png');
                position: fixed;
                top: 450px;
                right: 100px;
                border-radius: 10px;">
    </div>

    <div onclick="window.scrollBy(0,100)" style="width: 100px;
                height: 100px;
                border: solid grey 1px;
                background-image: url('Images/row_down.png');
                position: fixed;
                top: 600px;
                right: 100px;
                border-radius: 10px;">
    </div>




    <table cellspacing="0" style="border-bottom: solid grey 2px; border-top: solid grey 2px; border-collapse:collapse; " width="800px">
        <tr>
            <td colspan="2" style="text-align: left; padding: 20px; border-bottom: solid grey 2px; font-size: 14pt;">
                ИП Степановский Владимир Александрович ОГРНИП 312352806100032 ИНН 352813849901 </br>
                кафе "Три Апельсина" г.Череповец ул. Комарова д.5</br>
                телефон 50-77-00
                e-mail cafe@triapelsina.ru</br>
                Интернет сайт triapelsina.ru</br>
                Группа ВКонтакте vk.com/3apelsina
            </td>
            <td>
                <img src="Images/logo.png">
            </td>

        </tr>
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
        $begin_time=explodeTimeStamp($Response->Unloads->Object[0]->Properties['DateRsrv']);
        $year=strtok($begin_time["date"],".");
        $month_int=(int)strtok(".");
        $day=strtok(".");
        $time=strtok($begin_time["time"],":").'-'.strtok(":");
        ?>
        <tr>
            <td colspan="3" style="padding:10px; font-size: 20pt; font-style: bold;">
                Начало банкета <span style="font-size: 24pt;"><?=$day?> <?=$mounth[$month_int]?> <?=$year?> г. </span><?=$time?>
            </td>
        </tr>
        <tr >
            <td colspan="2"  style="text-align: left; padding-left: 20px;">
                Заказчик:        <span style="font-size: 18pt;"><?=$Response->Unloads->Object[0]->Properties['NameRsrv'];?></span>
            </td>
            <td rowspan="2" style="border: solid grey 1px; border-radius: 10px;">
                Количество гостей </br> <span style="font-size: 32pt;"><?=$Response->Unloads->Object[0]->Properties['Seats'];?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; padding-left: 20px;">
                Информация: <span style="font-size: 16pt;"><?=$Response->Unloads->Object[0]->Properties['InfoRsrv'];?></span>
            </td>

        </tr>
        <tr>
            <td height="40px" style="text-align: left;padding-left: 20px;" ">
            Бронирование зала №<?=$_GET["order"]?> от <?=$Response->Unloads->Object[0]->Properties['DateAdd'];?>
            </td>
            <td style="text-align: right;">
                Администратор:
            </td>
            <td >
                <?=$Response->Unloads->Object[1]->Properties['Name'];?>
            </td>
        </tr>


    </table>

    <span style="text-align: center;line-height: 50px; font-size: 20pt;">Состав заказа</span>

    <table cellspacing="0" width="800px" style="padding: 5px;">
        <tr>
            <td class="td1" style="border-left: solid 1px;">№</td> <td class="td1">Наименование</td> <td class="td1">Выход</td> <td class="td1">Кол-во</td> <td class="td1">Ед</td> <td class="td1">Цена</td> <td class="td1">Скидка</td><td class="td1">Стоимость</td>

        </tr>
       <?

        for ($i=0;$Response->Unloads->Object[0]->Link->Item[$i]<>null;$i++) {

        $ProdID=$Response->Unloads->Object[0]->Link->Item[$i]["ProdID"];
        $numstr=$i+1;

            foreach ($Response->Unloads->Object as $object){

                if ($object["name"]=="Product"){

                    foreach ( $object->Properties as $Properties){

                        if ((string)$Properties[ID]==(string)$ProdID) $prodname = $Properties[Name];
                    }
                }
            }




            if ($Response->Unloads->Object[0]->Link->Item[$i]["Status"]=="1") {
                echo '  <tr>
                        <td class="tab1" style="border-left: solid 1px">' . $numstr . '</td>
                        <td class="tab1" style="text-align:left;">' . $prodname . '</td>
                        <td class="tab1"></td>
                        <td class="tab1" style="text-align: right; padding-left: 15px;">'.$Response->Unloads->Object[0]->Link->Item[$i]["Count"].'</td>
                        <td class="tab1"></td>
                        <td class="tab1" style="text-align: right;">'.$Response->Unloads->Object[0]->Link->Item[$i]["Price"].' руб.</td>
                        <td class="tab1" style="text-align: right;">'.$Response->Unloads->Object[0]->Link->Item[$i]["TotalDiscSum"].' руб.</td>
                        <td class="tab1"  style="text-align: right;">'.$Response->Unloads->Object[0]->Link->Item[$i]["TotalSum"].' руб.</td>
                    </tr>';
            }
            $order_total=$order_total+$Response->Unloads->Object[0]->Link->Item[$i]["TotalSum"];
            $discount_total=$discount_total+$Response->Unloads->Object[0]->Link->Item[$i]["TotalDiscSum"];

        }
        ?>
        <tr>
            <td colspan="6" style="border-top: solid 1px; text-align: right;">ИТОГ:</td> <td style="border-top: solid 1px;text-align: right;"><?=$discount_total?> руб.</td> <td style="border-top: solid 1px;text-align: right;"><?=$order_total?> руб.</td>

        </tr>

        <tr>
            <td colspan="6" style="text-align: right;">Сумма аванса:</td>
            <td></td>
            <td style="text-align: right;"><?=$Response->Unloads->Object[0]->Properties['AvansSum']?> руб.</td>

        </tr>
        <tr>
            <td colspan="6" style="text-align: right;">Сумма к доплате:</td>
            <td></td>
            <td style="text-align: right;"><?=$order_total-$Response->Unloads->Object[0]->Properties['AvansSum']?> руб.</td>

        </tr>

        <tr>
            <td colspan="7" style="border-top: solid grey 2px;">

            </td>

        </tr>
        <tr>
            <td  colspan="2" rowspan="2" style="font-size: 16px;">Справочная информация:</td>
            <td colspan="5" style="text-align: right;">Стоимость блюд в расчете на одного гостя:</td>
            <td style="text-align: right;"><?=round($order_total/$Response->Unloads->Object[0]->Properties['Seats'])?> руб.</td>

        </tr>
        <tr>
            <td colspan="5" style="text-align: right;">Вес блюд в расчете на одного гостя:</td>
            <td style="text-align: right;">0 г.</td>

        </tr>
    </table>

</div>
</body>

</html>