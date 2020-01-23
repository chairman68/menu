<?php
// Форматирование вывода ошибок SQL сервера
function FormatErrors( $errors )
{
    /* Display errors. */
    echo "Error information: ";

    foreach ( $errors as $error )
    {
        echo "SQLSTATE: ".$error['SQLSTATE']."<br/>";
        echo "Code: ".$error['code']."<br/>";
        echo "Message: ".$error['message']."<br/>";
    }
}
//------------------------------------


// Функция исполнения запроса в базе РестАрт. Возвращает массив строк результата.
function queryRestArt ($tsql){
    $out=array();
    $config=json_decode(file_get_contents("json/config.json")); //Получить параметры системы
    $conn = sqlsrv_connect($config->db_connect->server_name, (array) $config->db_connect->connection_options_razdacha); 
    
    if(!$conn){
        echo "Нет подключения к серверу БД!";
    }
    
    $getResults= sqlsrv_query($conn, $tsql);

    if ($getResults == FALSE)
    die(FormatErrors(sqlsrv_errors()));
    $i=1;
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        $out[$i]=$row;
        $i++;
    }

    sqlsrv_free_stmt($getResults);

    return $out;
}
//------------------------------------
// Функция возвращает массив с родительскими ID
 function allParentID(){   
    $tsql=" SELECT
            prod.[ObjID] ProdID,
            prod.[ParentID]
            FROM [dbo].[tb_Product] prod";
        $out= queryRestArt ($tsql);
    return $out;

 }

// Функция возвращает массив с маршрутизацией печати
function prnrouter(){
    $tsql=" SELECT
            prn.[ProdID],
            prn.[PrnGrpID],
            prngrp.[Name]
            FROM [dbo].[tb_Print] prn, [dbo].[tb_PrnGrp] prngrp
            WHERE prngrp.[ObjID] = prn.[PrnGrpID]";
        $out= queryRestArt ($tsql);
    return $out;
}
// Функция возвращает ID группы принтеров для данной номенклатуры
// $prnrouter  массив с маршрутизацией печати
function get_prnGrpID($prodID, $prnrouter, $allparent){
    $out=null;
    while ($out==null){
        foreach ($prnrouter as $value){
            if ($value["ProdId"]=$prodID) {
                if ($value["PrnGrpID"]==null){
                    foreach ($allparent as $parent){
                        if ($parent["ProdID"]=$prodID){
                            $prodID=$parent["ParentID"];
                            break 2;
                        } else {
                        $out=$value["Name"];
                        }
                    }
                }
            }
        }
    }
    return $out;
    
}
/* Сортируем многомерный массив по значению вложенного массива
 * @param $array array многомерный массив который сортируем
 * @param $field string название поля вложенного массива по которому необходимо отсортировать
 * @return array отсортированный многомерный массив
 */
function customMultiSort($array,$field) {
    $sortArr = array();
    foreach($array as $key=>$val){
        $sortArr[$key] = $val[$field];
    }

    array_multisort($sortArr,$array);

    return $array;
}
