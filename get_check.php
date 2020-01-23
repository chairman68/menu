<?php
/*********************************** СТРУКТУРЫ ДАННЫХ *****************************************/

/*******************************
ДАННЫЕ ЗАПРОСА

echo $Response["KEY"];

KEY:

["appname"]			=>string(13) "ARMwaiter.exe"
["build"]			=>string(7) "8.3.2.0"
["work"]			=>string(1) "1"
["name"]			=>string(4) "Food"
["dbprefix"]		=>string(5) "POS02"
["version"]			=>string(6) "2.2.99"
["databaseid"]		=>string(38) "{165f4cad-8f41-11e3-93ef-00155d012805}"
["datetime"]		=>string(23) "2017.01.05 11:56:43.994"
["dbdatetime"]		=>string(23) "2017.01.05 11:56:43.992"
["compname"]		=>string(10) "SERVERCASH"
["keyNumber"]		=>string(6) "362488"
["keyPinCode"]		=>string(7) "325-726"
["keyIsSoft"]		=>string(1) "1"
["DeviceID"]		=>string(6) "server"
**********************************/

/*******************************
ДАННЫЕ ЧЕКА ПРОДАЖ

echo $Response->Unloads->Object[$i]->Properties["KEY"];

KEY

["ID"]					=>string(38) "{D010ED6E-C40C-433F-8F79-DEFC15C03454}"
["Active"]				=>string(1) "1"
["ExtrnCode"]			=>string(0) ""
["TimeStamp"]			=>string(23) "2016.12.29 16:56:50.223"
["CreationTimeStamp"]	=>string(23) "2016.12.29 10:12:30.563"
["Date"]				=>string(23) "2016.12.29 10:12:30.537"
["UserID"]				=>string(38) "{46D62FCE-90D7-11E3-93EF-00155D012805}"
["Prefix"]				=>string(5) "POS02"
["KKMID"]				=>string(38) "{5FDF7207-0C89-4F0B-BDCD-2AE4FAD84DA5}"
["OrgID"]				=>string(38) "{387EBE13-3A57-11E4-93F9-00155D012805}"
["SubunitID"]			=>string(38) "{387EBE14-3A57-11E4-93F9-00155D012805}"
["DatabaseID"]			=>string(38) "{165F4CAD-8F41-11E3-93EF-00155D012805}"
["Type"]				=>string(1) "0"
["Origin"]				=>string(1) "1"
["Suspended"]			=>string(1) "0"
["AvansDDS"]			=>string(0) ""
["AvansCard"]			=>string(0) ""
["OrdUserID"]			=>string(38) "{46D62FCE-90D7-11E3-93EF-00155D012805}"
["OrdNum"]				=>string(5) "30305"
["PreChkUserID"]		=>string(38) "{46D62FCE-90D7-11E3-93EF-00155D012805}"
["PayMeth"]				=>string(1) "1"
["IsFisc"]				=>string(1) "0"
["NoCombID"]			=>string(0) ""
["FRShift"]				=>string(2) "44"
["FRCheck"]				=>string(4) "4974"
["FRDoc"]				=>string(4) "4974"
["FRDate"]				=>string(23) "2016.12.29 10:07:56.467"
["SrcID"]				=>string(0) ""
["Posted"]				=>string(1) "1"
["DateShift"]			=>string(23) "2016.12.29 16:56:50.223"
["ShiftBegin"]			=>string(23) "2016.12.29 08:57:42.490"
["ShiftNum"]			=>string(2) "86"
["CardID"]				=>string(38) "{639EBC7B-61EE-40FB-A1CE-2853959BA635}"
["DiscID"]				=>string(0) ""
["DiscPerc"]			=>string(1) "0"
["DiscSum"]				=>string(1) "0"
["FRName"]				=>string(78) "1С-Рарус: Фискальный регистратор Штрих-М №1"
["CompName"]			=>string(6) "KASSA1"
["Comment"]				=>string(0) ""
["InkassSum"]			=>string(0) ""
["OrderID"]				=>string(38) "{39D65925-0036-4EC1-8528-59046ADC8FB4}"
["OrdDateAdd"]			=>string(23) "2016.12.29 10:10:09.347"
["OrdGuests"]			=>string(1) "1"
["ObjectID"]			=>string(0) ""
["AreaID"]				=>string(0) ""
["AuthUserID"]			=>string(0) ""
["GuestID"]				=>string(0) ""
["ErrorMsg"]			=>string(0) ""

**********************************/

/*******************************
ДАННЫЕ СТРОКИ ЧЕКА ChkBar 

echo $Response->Unloads->Object[$i]->Link[0]->Item["KEY"];


KEY:

["Pos"]				=>string(1) 	позиция строки в чеке
["IsProd"]			=>string(1) 
["RefID"]			=>string(38)	тип объекта ссылки RefID:
									1 – номенклатура (Product.ObjID)
									0 – модификатор (Mod.ObjID)
									Ссылка на объект. Зависит от IsProd

["MenuID"]			=>string(38)	Меню (Menu.ObjID). 
["Barcode"]			=>string(0) 	Штрих-код товара (EAN-8/-12/-13/-14).
									Обязателен для алкогольной продукции.

["ExciseCode"]		=>string(0) 	Штрих код с акцизной марки (PDF-417).
									Обязателен для алкогольной продукции.
["Price"]			=>string(2) 	Цена товара.
["Count"]			=>string(1) 	Количество.
["Sum"]				=>string(2) 	Сумма (без учёта скидки).
["UnitName"]		=>string(4) 	Наименование единицы измерения
["UnitID"]			=>string(38)	ID единицы измерения. 
["DiscID"]			=>string(0) 	Скидка на строку (Discount.ObjID).
["DiscPerc"]		=>string(1) 	Процент скидки на строку
["DiscSum"]			=>string(1) 	Сумма скидки на строку
["TotalDiscPerc"]	=>string(1) 	Полный процент скидки на строку.С учётом распределённой скидки на документ.
["TotalDiscSum"]	=>string(1) 	Полная сумма скидки на строку.С учётом распределённой скидки на документ.
["TotalSum"]		=>string(2) 	Полная сумма строки. TotalSum = Sum - TotalDiscSum.
["TaxID"]			=>string(0) 	Ставка налога (Tax.ObjID)
["TaxSum"]			=>string(1)		рассчитанная сумма налога
["OrderID"]			=>string(38)	Исходный заказ (Order.ObjID)
["PrnGrpID"]		=>string(0) 	Группа принтеров (PrnGrp.ObjID)
["ProdID"]			=>string(0) 	Товар-сырьё для RefID, если RefID – модификатор (Product.ObjID). 
["ProdCnt"]			=>string(1) 	Количество номенклатуры ProdID. ProdCnt = Count * OrdItem.RawProdCnt
["SrcPos"]			=>string(1) 	Для чека продажи – 0.Для чека возврата – номер данной строки в соответствующем чеке продажи (LinkID.SrcID)
["DateCancel"]		=>string(0) 	Дата/Время удаления позиции заказа.Используется только при Check.Type=2
["UserCancelID"]	=>string(0) 	Инициатор удаления позиции заказа. (User.ObjID) Используется только при Check.Type=2
["CancelID"]		=>string(0) 	Причина отмены строки заказа (Cancel.ObjID). Используется только при Is Check.Type=2
["IsPrepared"]		=>string(1) 	Блюдо приготовлено (из строки исходного заказа). Попадает в закрытие смены типа «списание».



**********************************/

/*******************************
ДАННЫЕ МОДИФИКАТОРОВ ChkMod 

echo $Response->Unloads->Object[1]->Link[1]->Item["KEY"];

KEY: ????
**********************************/

/*******************************
АЛКООЛЬНЫЕ ДАННЫЕ ChkAlco 

echo $Response->Unloads->Object[$i]->Link[2]->Item["KEY"];

KEY:

["ProdID"]			=>GUID			Вскрытый товар (Product.ObjID). 
["Quantity"]		=>Real			Количество
["Barcode"]			=>wString(20)	Штрих-код товара (EAN-8/-12/-13/-14)
["ExciseCode"]		=>wString(80)	Штрих код с акцизной марки (PDF-417)
["UnitName"]		=>wString(25)	Наименование единицы измерения
["UnitID"]			=>GUID			ID единицы измерения


**********************************/
/*******************************
ДАННЫЕ О ВИДЕ ПЛАТЕЖА ChkPay 

echo $Response->Unloads->Object[$i]->Link[3]->Item["KEY"];

KEY:

["PayTypeID"]		=>string(38)
["IsFisc"]			=>string(1) 
["CardID"]			=>string(38)
["RefNum"]			=>string(36)
["Sum"]				=>string(2) 
["BackSum"]			=>string(1) 

**********************************/
/*******************************
ДАННЫЕ О ЛОГАХ ЗАКАЗА ChkLog 

echo $Response->Unloads->Object[$i]->Link[4]->Item["KEY"];

KEY:

["Event"]			=>Integer		Тип события:
									1 – отмена пречека
["Date"]			=>DateTime		Дата/Время события
["UserID"]			=>GUID			Инициатор события (User.ObjID)
["Sum"]				=>Real			Сумма заказа на момент события



**********************************/



/*********************************************************************************************************************

						СТРУКТУРА ТАБЛИЦЫ CHECK

Date				DateTime		Время создания.
UserID				GUID			Кассир (User.ObjID). 
Prefix				wString(40)		Префикс кассового узла (как в файлах обмена)
KKMID				GUID			Касса ККМ (KKM.ObjID). 
OrgID				GUID			Организация (Organization.ObjID). 
Type				Integer			Тип чека.
									0 – продажа
									1 – возврат
									2 – отмена (чек с отменёнными позициями заказа)
									3 – внесение аванса в заказ брони (в АРМ Метрдотель)
									4 – возврат аванса
									5 – вскрытие
Origin				Integer			Происхождение чека.
									0 – не известно (после миграции)
									1, 2, 3, 5 – из исходного заказа (OrderID.Origin)
									2 (Официант) – для чеков внесения/возврата авансов.
									4 – чек из АРМ’а «Депозитные карты»
Suspended			Bit				= 0
									Признак незавершённости операции по чеку.
									Может быть = 1 в чеках продажи АРМа Самообслуживания.
AvansDDS			wString(50)		Адрес:порт депозитного сервера, на котором был проведён авансовый платёж данным чеком.
									Заполняется только для авансового чека.
OrdUserID			GUID			Пользователь (User.ObjID), исполнитель заказа чека:
									•	«доставка» – курьер (OrderID.DelivUserID)
									•	иначе – владелец заказа (OrderID.UserAddID)
OrdNum				Integer			номер заказа чека (OrderID.Num)
PreChkUserID		GUID			Пользователь (User.ObjID), инициатор пробития пречека заказа (OrderID.PreChkUserID)
PayMeth				Integer			Способ оплаты. Как в PayType.Method, и ещё:
									-1 – смешанный
IsFisc				Bit				Признак фискальности чека. Имеет фискальные платежи
NoCombID			GUID			Некомбинированный тип платежа для данного чека (PayType.ObjID).
									NULL – если чек имеет комбинированные платежи.
FRShift				Integer			Номер смены ФР-чека
FRCheck				Integer			Номер чека ФР
FRDoc				Integer			Номер документа ФР
FRDate				DateTime		Дата/время пробития чека на ФР
SrcID				GUID			Исходный чек (продажи) с данного чека возврата (Check.ObjID)
Posted				Bit				=0
									Признак проведения документа.
									Чек проводится при закрытии смены.
DateShift			DateTime		Признак выгрузки чека в итоги закрытия смены.
									В данное поле записывается поле DateAdd объекта Shift, в котором учитывается данный чек.
ShiftBegin			DateTime		Дата/время открытия рабочей смены чека
ShiftNum			Integer			Номер рабочей смены, когда чек был напечатан
CardID				GUID			Дисконтная карта (Card.ObjID). 
									Для авансовых чеков (Type=3/4) — платёжная карта, на которую зачисляется (снимается) аванс.
DiscID				GUID			Скидка на документ (Discount.ObjID)
DiscPerc			Real			Процент скидки на документ
DiscSum				Real			Сумма скидки на документ
FRName				wString(50)		Имя ФР, на котором отпечатали чек
CompName			wString(50)		Имя компьютера, с которого напечатали чек
OrderID				GUID			Заказ для чека (Order.ObjID) 
OrdDateAdd			DateTime		Время создания заказа (OrderID.DateAdd)
OrdGuests			Integer			Количество клиентов заказа (OrderID.Seats)
ObjectID			GUID			Стол (Object.ObjID) заказа (OrderID.ObjectID)
AreaID				GUID			Зал (Area.ObjID) заказа (ObjectID.AreaID)
AuthUserID			GUID			Пользователь (User.ObjID), чью карточку прокатывали последний раз при операциях эскалации или подтверждении права
GuestID				GUID			Гость (Guest.ObjID) из заказа (OrderID.GuestID).
ErrorMsg			wString(200)	Проигнорированная ошибка при пробитии чека

*******************************************************************************************************************************/

include $_SERVER['DOCUMENT_ROOT']."/dds/T_DDS.php"; // Описание типов данных для обменов с DDS

// Создание SOAP-клиента по WSDL-документу
$client = new SoapClient("http://192.168.1.55:29121/wsdl/IRestWebServ");
$clientDDS = new SoapClient("http://192.168.1.55:10750/wsdl/IDepServerSOAP");
// Поcылка SOAP-запроса и получение результата

$requestDate2 =new DateTime();
$duration = new DateInterval("P17DT30S");
$requestDate1 =new DateTime();
$requestDate1->sub($duration);

/*echo $requestDate1->format('Y.m.d H:i:s.000');
echo $requestDate2->format('Y.m.d H:i:s.000');
*/
$request1 = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Request work="1" name="Food" DeviceID="server">
	<Unloads>
		<Object name="Check" cond="(Type='0') and (Date between'
XML;
?>
<?
$request2 = <<<XML1
') and (CardId is not NULL)" />
	</Unloads>
</Request>
XML1;

?>
<?



$req= $request1.$requestDate1->format('Y-m-d H:i:s')."' and '".$requestDate2->format('Y-m-d H:i:s').$request2;


$resultSOAP = $client->ExecRequest($request1.$requestDate2->format('Y.m.d 10:00:00.000')."' and '".$requestDate2->format('Y.m.d H:i:s.000').$request2);
$resultSOAP = str_replace ("UTF-16","UTF-8",$resultSOAP);



$Response = simplexml_load_string($resultSOAP);
// В $Response лежит ответ кассового сервера в виде объекта simplexml



var_dump($Response);








?>