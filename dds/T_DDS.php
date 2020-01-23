<?php
//********************** Описание классов *********************************
class TTransactionsFilter {
	var $CardID;
	var $BeginDateTime;
	var $EndDateTime;
	var $DocId;
	var $KKMID;
	var $TransactionType;
	var $Sum;
	var $Status;
	var $SalePlace;
	var $Author;
	var $SystemID;
	var $KKMName;
}
class TAuth {
	var $Pass;
}

class TCard {
	var $CardID; 				//String		Уникальный идентификатор карты.
	var $MasterID;				//String		Код мастер карты родителя.
	var $ParentID;				//String		Код карты родителя в иерархии.
	var $IsGroup;				//Int			Признак группы.
	var $Code;					//String		Данные карты.
	var $ContractorID;			//String		Идентификатор контрагента.
	var $BalanceFlag;			//Int			Признак балансной карты
	var $Description;			//String		Описание карты
	var $Balance;				//Float			Величина баланса карты
	var $CreditMax;				//Float			Глубина кредита
	var $Active;				//Int			Признак активации карты
	var $ActDateTime;			//String		Дата и время активации карты
	var $EndDateTime;			//String		Дата и время деактивации карты
	var $Turnover;				//Float			Полный оборот по карте
	var $LastDateTime;			//String		Дата и время последней транзакции
	var $LastID;				//String		Код последней транзакции
	var $CreditInfinite;		//Int			Признак неограниченности кредита
	var $Restrictions;			//TRestrictions	Ограничения
	var $Name;					//String		Представление карты
	var $Blocked;				//Int			Признак заблокированности карты
	var $BlockedDescription;	//String		Причина блокировки/разблокировки
	var $DiscountFlag;			//Int			Признак дисконтной карты
	var $RptPeriodType;			//Int			Тип отчётного периода
	var $RptPeriodNum;			//Int			Параметр отчётного периода
	var $Password;				//String		Пароль
	var $Coupon;				//Int			Признак карты-купона
	var $PhoneNumber;			//String		Номер телефона для SMS
	var $ImagePresent;			//Int			Признак существования картинки для карты
}

class TRestrictions{
	var $ModeRestrictions;		//Int			Режим наложения ограничений:
   								// 				0 - не меняются
   								//				1 - удалить
   								//				2 - перезаписать
	var $DayCount;				//Int			Допустимое количество продаж в сутки
	var $WeekCount;				//Int			Допустимое количество продаж в неделю
	var $MonthCount;			//Int			Допустимое количество продаж в месяц
	var $YearCount;				//Int			Допустимое количество продаж в год
	var $DaySum;				//Float			Допустимая сумма продаж в сутки
	var $WeekSum;				//Float			Допустимая сумма продаж в неделю
	var $MonthSum;				//Float			Допустимая сумма продаж в месяц
	var $YearSum;				//Float			Допустимая сумма продаж в год
	var $StartDaySec;			//Int			Смещение начала суток относительно полуночи (в секундах)

}

class TActivateCardParams { 
	var $CardID;				//String		Идентификатор карты
	var $MasterID;				//String		Код мастер карты родителя.
	var $Code;					//String		Данные карты.
	var $ContractorID;			//String		Идентификатор контрагента.
	var $Description;			//String		Описание карты
	var $CreditMax;				//Float			Глубина кредита
	var $CreditInfinite;		//Int			Признак неограниченности кредита

}

class TTransactionParamsIn {
	var $CardID;				//String		Идентификатор карты
	var $Code;					//String		Код карты
	var $TransactionType;		//Int			Тип операции
	var $Sum;					//Float			Сумма операции
	var $SalePlace;				//String		Наименование места продажи
	var $Author;				//String		Автор
	var $Description;			//String		Краткое описание операции
	var $SystemID;				//String		Наименование системы операции
	var $DocId;					//String		Идентификатор документа
	var $KKMID;					//String		Идентификатор кассы ККМ
	var $KKMName;				//String		Наименование кассы ККМ
	var $CheckStructure;		//String		Произвольное описание структуры услуги
	var $SumBonusPays;			//Float			Сумма бонусных типов оплат
	var $Password;				//String		Пароль карты
}

?>