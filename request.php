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
$request=$request1.$_GET["order"].$request2;
$resultSOAP = $client->ExecRequest($request);
$resultSOAP = str_replace ("UTF-16","UTF-8",$resultSOAP);



$Response = simplexml_load_string($resultSOAP);
// В $Response лежит ответ кассового сервера в виде объекта simplexml
print_r($Response);

?>