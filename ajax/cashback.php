
<?php
	
/* Скрипт cashback.php выполняет следующие функции:
1.	Определяет возможность начисления бонусов по акции CASHBACK на момент вызова скрипта;
2.	Начисляет бонусы;
3.	Информирует покупателя о начислении бонусов по акции посредством SMS.
4.	Возвращает discount=процент от суммы чека возвращенный в виде бонусов; card=Данные карты покупателя;
	TransactionDateTime=время проведения транзакции начисления бонусов; 
*/
	

include $_SERVER['DOCUMENT_ROOT']."/dds/T_DDS.php"; // Описание типов данных для обменов с DDS

// Создание SOAP-клиента по WSDL-документу
$clientDDS = new SoapClient("http://192.168.1.55:10750/wsdl/IDepServerSOAP");

$currentDate =new DateTime(); // Текущее время
$duration = new DateInterval("PT10H30M30S");// Временной интервал запроса 30 сек
$subDate =new DateTime();
$subDate->sub($duration);// Время начала периода запроса


$Auth = new TAuth (); 
$Auth->Pass=""; // Пароль для доступа к базе ДДС

//************** Задание параметров фильтра транзакций *********************************
$TransactionsFilter = new TTransactionsFilter();
	$TransactionsFilter->CardID = "";
	$TransactionsFilter->BeginDateTime = $subDate->format('Y.m.d H-i-s.000');
	$TransactionsFilter->EndDateTime = $currentDate->format('Y.m.d H-i-s.000');
	$TransactionsFilter->DocId = "";
	$TransactionsFilter->KKMID = "";
	$TransactionsFilter->TransactionType = 6;
	$TransactionsFilter->Sum = (float)-1;
	$TransactionsFilter->Status = 0;
	$TransactionsFilter->SalePlace = "";
	$TransactionsFilter->Author = "";
	$TransactionsFilter->SystemID = "";
	$TransactionsFilter->KKMName = "";

//var_dump($TransactionsFilter);
$resultDDS = $clientDDS->GetTransactions($Auth,$TransactionsFilter);

$TransactionInfo = $resultDDS["TransactionParamsFullArray"];

$lastTransaction=end($TransactionInfo); // Последняя транзакция за период

//var_dump($resultDDS);
//var_dump($lastTransaction);
if ($lastTransaction){

	$card=$clientDDS->GetCard($Auth,$lastTransaction->CardID);// Данные карты
	$masterCard=$clientDDS->GetCard($Auth,$lastTransaction->MasterID); // Данные мастер карты
	
	$transDateTime=DateTime::createFromFormat('Y.m.d H:i:s????', $lastTransaction->TransactionDateTime);
	

	$diff= date_diff($currentDate,$transDateTime);
	//if ($diff->h==0 and $diff->i==0 and $diff->s<30) {
	if (true) {
		// ЗАДАЕМ ПАРАМЕТРЫ ТРАНЗАКЦИИ
		$bonusSum=0; // СУММА БОНУСА
		$TransactionParamsIn = new TTransactionParamsIn();

		$TransactionParamsIn->CardID 			= $lastTransaction->CardID;		//String		Идентификатор карты
		$TransactionParamsIn->Code 				= $card['Card']->Code;			//String		Код карты
		$TransactionParamsIn->TransactionType 	= 7;							//Int			Тип операции
		$TransactionParamsIn->Sum 				= $bonusSum;					//Float			Сумма операции
		$TransactionParamsIn->SalePlace			="Три Апельсина";				//String		Наименование места продажи
		$TransactionParamsIn->Author			="Система лояльности";			//String		Автор
		$TransactionParamsIn->Description		="Начисление бонусов по акции возврата денег";			//String		Краткое описание операции
		$TransactionParamsIn->SystemID 			= "Web Service";				//String		Наименование системы операции
		$TransactionParamsIn->DocId				="";							//String		Идентификатор документа
		$TransactionParamsIn->KKMID				="";							//String		Идентификатор кассы ККМ
		$TransactionParamsIn->KKMName			="";							//String		Наименование кассы ККМ
		$TransactionParamsIn->CheckStructure	="";							//String		Произвольное описание структуры услуги
		$TransactionParamsIn->umBonusPays		= (float)0;						//Float			Сумма бонусных типов оплат
		$TransactionParamsIn->Password 			= $card['Card']->Password;		//String		Пароль карты
		
		echo '{"TransactionDateTime":"'.$transDateTime->format(DATE_W3C).'","card":"'.$card['Card']->Name.'","discount":"50" }';

	} else {/****************** вывод таблицы с данными транзакции************************
			echo " Последняя транзакция произведена ".$diff->h." hours ".$diff->i." min ".$diff->s." sec назад </br> Начисления бонусов не произведено";
			
			echo "<table>
						<tr>";	
			echo "<td>Идентификатор транзакции: </td><td>".$lastTransaction->TransactionID." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Идентификатор карты: </td><td>".$card['Card']->Name." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Владелец карты: </td><td>".$card['Card']->ContractorID." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Идентификатор мастер-карты: </td><td>".$masterCard['Card']->Name." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Время транзакции: </td><td>".$lastTransaction->TransactionDateTime." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Тип транзакции: </td><td>".$lastTransaction->TransactionType." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Сумма: </td><td>".$lastTransaction->Sum." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Статус транзакции: </td><td>".$lastTransaction->Status." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Место : </td><td>".$lastTransaction->SalePlace." </td>";
			echo "		</tr>
						<tr>";	
			echo "<td>Автор:</td><td>".$lastTransaction->Author." </td>";
			echo "		</tr>
						<tr>";	
			echo "<td>Описание транзакции:</td><td>".$lastTransaction->Description." </td>";
			echo "		</tr>
						<tr>";	
			echo "<td>Идентификатор системы:</td><td>".$lastTransaction->SystemID." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Идентификатор документа: </td><td>".$lastTransaction->DocId." </td>";
			echo "		</tr>
						<tr>";	
			echo "<td>Идентификатор  ККМ: </td><td>".$lastTransaction->KKMID." </td>";
			echo "		</tr>
						<tr>";	
			echo "<td>Название ККМ: </td><td>".$lastTransaction->KKMName." </td>";
			echo "		</tr>
						<tr>";
			echo "<td>Содержание чека: </td><td>".nl2br($lastTransaction->CheckStructure)." </td>";
				
	echo "</tr>
	</table>";
	/********************************************************/
		//echo '{"TransactionDateTime":"2017-01-13T14:20:49+04:00","card":"00200 Анощенко Анна Павловна","discount":"50" }';
	}
				
				
				
	} else {
			echo 'Нет покупок для возврата бонусов';
			//echo '{"TransactionDateTime":"'.$transDateTime->format(DATE_W3C).'","card":"'.$card['Card']->Name.'","discount":"50" }';
	}
	
		
	?>
