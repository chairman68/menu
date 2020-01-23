<?php?>
<?php?>
<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="css/template.css" type="text/css" />
    <meta http-equiv="Refresh" content="300" />
    <title>Меню Три Апельсина</title>
</head>

<body>

<?php

// Создание SOAP-клиента по WSDL-документу
$client = new SoapClient("http://192.168.1.55:29121/wsdl/IRestWebServ");

// Поcылка SOAP-запроса и получение результата

$request = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request work="1" name="Food">
	<Unloads>
		<Object name="Order" cond="Status='4'" />
	</Unloads>
</Request>
XML;
$resultSOAP = $client->ExecRequest($request);
$resultSOAP = str_replace ("UTF-16","UTF-8",$resultSOAP);



$Response = simplexml_load_string($resultSOAP);
// В $Response лежит ответ кассового сервера в виде объекта simplexml

var_dump($Response);

/*
// определение параметров подключения
$db='Menu';
$user='mysql';
$password='mysql';
$host ='192.168.1.55';

// подключение к БД
$mysqli= mysqli_connect ($host ,$user,$password,$db);

if (!mysqli_connect($host ,$user, $password)) {
    echo "Ошибка подключения к серверу MySQL";
    exit;
}

// Удаление записей из БД
$query="DELETE FROM `menu`.`Order`"	;
mysqli_query($mysqli,$query); //or die ("ERROR: ".mysqli_error());
//	printf("Errormessage: %s\n", $mysqli->error);

$query="DELETE FROM `menu`.`OrdItem`"	;
mysqli_query($mysqli,$query); //or die ("ERROR: ".mysqli_error());
//	printf("Errormessage: %s\n", $mysqli->error);

// для каждого меню парсим xml в БД
/*     Num             Integer         Номер заказа. Уникальный для БД.
           DateAdd         DateTime        Дата/Время создания.
           UserAddID       GUID            Инициатор создания (User.ObjID). Оно же – владелец заказа. Может меняться.
           DateDel         DateTime        Дата/Время закрытия.
           UserDelID       GUID            Инициатор закрытия (User.ObjID).
           CancelID        GUID            Причина закрытия (Cancel.ObjID).
                                           Особые значения:NULL – при переносе в другой заказ или при пробитии чека по заказу;
                                           null_GUID – при удалении заказа через мобильный терминал
           DateAlt         DateTime        Дата/Время последнего изменения
           UserAltID       GUID            Инициатор последнего изменения (User.ObjID)
           DatePreChk      DateTime        Дата/Время пробития пречека
           PreChkUserID    GUID            Инициатор пробития пречека (User.ObjID)
           DateRsrv        DateTime        Дата/время, на которую забронирован стол.
           NameRsrv        wString(100)    ФИО бронирующего
           InfoRsrv        wString(40)     Доп. информация о бронирующем (телефон)
           PrepRsrv        Integer         Кол-во минут до времени бронирования, за которое нужно начать готовить заказ.
                                           Если 0, то готовить заранее не нужно.
           MsgUsersRsrv    wString(4000)   Список операторов, которых нужно уведомлять о необходимости готовить бронь
           AvansDDS        wString(50)     Адрес:порт депозитного сервера, на котором был проведён авансовый платёж по данному заказу
           AvansCard       wString(50)     Код карты, на которую зачислен аванс
           AvansSum        Real            Сумма аванса
           ObjectID        GUID            Стол заказа (Object.ObjID).
           Seats           Integer         Число гостей. Число гостей, обслуживаемых по текущему заказу
           Status          Integer         Статус заказа:
                                           1 – открыт
                                           2 – закрыт (отменён / перенесён / пробит)
                                           3 – пречек
                                           4 – предварительный (бронь)
                                           10 – принят заказ доставки
                                           11 – отправлен заказ доставки
           Origin          Integer         Происхождение заказа (АРМ, в котором создали):
                                           1 – продавец (ФФ)
                                           2 – официант
                                           3 – доставка
           ExtrnID         String(40)      ID заказа (для мобильного терминала).
           DateShift       DateTime        Признак выгрузки заказа в итоги закрытия смены.
                                           В данное поле записывается поле DateAdd объекта Shift, в котором учитывается данный заказ.
           CardID          GUID            Дисконтная карта (Card.ObjID).
           DiscID          GUID            Скидка на документ (Discount.ObjID)
           DiscVal         Real            Значение скидки (DocDiscItem.Value)
           DiscPerc        Real            Процент скидки на документ
           DiscSum         Real            Сумма скидки на документ
           AuthUserID      GUID            Пользователь (User.ObjID), чью карточку прокатывали последний раз при операциях эскалации или подтверждении права
           GuestID         GUID            Гость (Guest.ObjID).
                                           В «Официанте» заполняется по карточке.
                                           В «Доставке» – клиент.
           IsPaid          Bit             Оплаченность заказа доставки.
                                           0 при закрытом заказе, если реальная оплата – после чека продажи
           DelivUserID     GUID            Курьер доставки (User.ObjID).
           DelivAddress    wString(500)    Адрес доставки заказа
           DelivMetro      wString(80)     Метро из  DelivAddress
           DelivStreet     wString(80)     Улица из  DelivAddress
           DelivDistr      wString(80)     Зона из  DelivAddress
           DelivLName      wString(50)     Имя клиента доставки.
           DelivFName      wString(50)     Фамилия клиента доставки
           DelivPName      wString(50)     Отчество клиента доставки
           DelivPhone      String(20)      Основной телефон клиента (мобильный).
           DelivPhone2     String(20)      Дополнительный телефон клиента (городской).
           DateReady       DateTime        Дата/время готовности заказа доставки
           DateDeliv       DateTime        Дата/время, к которому доставить заказ клиенту
           DelivInfo       wString(1500)   Комментарий к заказу доставки
           DelivSum        Real            Ожидаемая сумма, которую даст клиент доставки
           ComplectDate    DateTime        Дата/время последней распечатки листа комплектации


$key=0; // ключ idMenuItem

for ($i=0;$Response->Unloads->Object["name"]="Order";$i++) {
    $Object=$Response->Unloads->Object[$i];

    $queryOrder=
        "INSERT INTO `Menu`.`Order`
		SET
		`Num`		    ='".$Item['Num']."' ,
		`DateAdd`       ='".$Item['DateAdd']."',
		`UserAddID`	    ='".$Item['UserAddID']."' ,
		`DateDel`	    ='".$Item['DateDel']."' ,
		`UserDelID`	    ='".$Item['UserDelID']."',
		`CancelID`		='".$Item['CancelID']."',
		`DateAlt`		='".$Item['DateAlt']."',
		`UserAltID`	    ='".$Item['UserAltID']."',
		`DatePreChk`	='".$Item['DatePreChk']."',
		`PreChkUserID`	='".$Item['PreChkUserID']."',
		`DateRsrv`		='".$Item['DateRsrv']."',
		`NameRsrv`		='".$Item['NameRsrv']."',
        `InfoRsrv`      ='".$Item['NameRsrv']."',
        `PrepRsrv`      ='".$Item['PrepRsrv']."',
        `MsgUsersRsrv`  ='".$Item['MsgUsersRsrv']."',
        `AvansDDS`      ='".$Item['AvansDDS']."',
        `AvansCard`     ='".$Item['AvansCard']."',
        `AvansSum`      ='".$Item['AvansSum']."',
        `ObjectID`      ='".$Item['ObjectID']."',
        `Seats`         ='".$Item['Seats']."',
        `Status`        ='".$Item['Status']."',
        `Origin`        ='".$Item['Origin']."',
        `ExtrnID`       ='".$Item['ExtrnID']."',
        `DateShift`     ='".$Item['DateShift']."',
        `CardID`        ='".$Item['CardID']."',
        `DiscID`        ='".$Item['DiscID']."',
        `DiscVal`       ='".$Item['DiscVal']."',
        `DiscPerc`      ='".$Item['DiscPerc']."',
        `DiscSum`       ='".$Item['DiscSum']."',
        `AuthUserID`    ='".$Item['AuthUserID']."',
        `GuestID`       ='".$Item['GuestID']."',
        `IsPaid`        ='".$Item['IsPaid']."',
        `DelivUserID`   ='".$Item['DelivUserID']."',
        `DelivAddress`  ='".$Item['DelivAddress']."',
        `DelivMetro`    ='".$Item['DelivMetro']."',
        `DelivStreet`   ='".$Item['DelivStreet']."',
        `DelivDistr`    ='".$Item['DelivDistr']."',
        `DelivLName`    ='".$Item['DelivLName']."',
        `DelivFName`    ='".$Item['DelivFName']."',
        `DelivPName`    ='".$Item['DelivPName']."',
        `DelivPhone`    ='".$Item['DelivPhone']."',
        `DelivPhone2`   ='".$Item['DelivPhone2']."',
        `DateReady`     ='".$Item['DateReady']."',
        `DateDeliv`     ='".$Item['DateDeliv']."',
        `DelivInfo`     ='".$Item['DelivInfo']."',
        `DelivSum`      ='".$Item['DelivSum']."',
        `ComplectDate`  ='".$Item['ComplectDate']."'";

    //Выполнение запроса по добавлению записей в БД
   // mysqli_query($mysqli,$queryOrder);

    foreach ($Object->Link->OrdItem as $OrdItem ) {




        //Выполнение запроса по добавлению записей в БД
      //  mysqli_query($mysqli,$query); //or die ("ERROR: ".mysqli_error());

        $key++;	//Устанавливаем номер следующей записи idMenuItem

    };
}
echo "Обновлено ".$key." записей в таблице OrdItem </br>";


mysqli_close($mysqli);
// закрываем подключение к БД
echo "ПРОЦЕДУРА ОБНОВЛЕНИЯ ЗАВЕРШЕНА!";
*/
?>
</body>
</html>