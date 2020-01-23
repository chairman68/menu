<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/template.css" type="text/css" />
    <title>Меню Три Апельсина</title>
</head>

<body>

<?php
$date=new DateTime();
// Создание SOAP-клиента по WSDL-документу
$client = new SoapClient("http://192.168.1.55:29121/wsdl/IRestWebServ");


$request_1=<<<XML1
<?xml version="1.0" encoding="UTF-8"?>
<Request work="1" name="Food" DeviceID="server" >
	<Unloads>
XML1;
?>
<?
$request_2=<<<XML2
	
  </Unloads>
</Request>

XML2;


	
function count_orders_period($date1,$date2) {	
global $request_1;
global $request_2;
global $client;

$query= '<Query name="Количество заказов" text="SELECT COUNT(*) FROM tb_order where (DateDel between \''. $date1->format("Y.m.d 10:00:00.000").'\' and \''.$date1->format("Y.m.d H:i:s.000").'\') and Status=2 " />';
	
$request= $request_1.$query.$request_2;
//echo $request;
//var_dump($request);	
$resultSOAP = $client->ExecRequest($request);
$resultSOAP = str_replace ("UTF-16","UTF-8",$resultSOAP);
$Response = simplexml_load_string($resultSOAP);
// В $Response лежит ответ кассового сервера в виде объекта simplexml
//var_dump($Response);
return $Response->Unloads->Query->Item["COLUMN1"];
}

echo 'количество заказов - '.count_orders_period($date,$date);

/*for ($i=0;$Response->Unloads->Object["name"]="Order";$i++) {
    $Object=$Response->Unloads->Object[$i];
   echo $i;
	echo $Object[$i]->Properties["DateDel"];
	echo '</br>';
*/    

?>
</body>
</html>