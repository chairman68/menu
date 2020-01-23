<?php
//  Скрипт возвращает список аудитов в формате JSON
include("../functions.php");
if (isset($_GET['page'])) { // Проверяем наличие идентификатора страницы
$page=$_GET['page'];
}else{
$page=1;    
}


		$tsql= "SELECT audit.*
                        ,count(auditItem.[ID]) as item
                FROM [CAFE2019].[dbo].[tb_My_Audit] audit
                JOIN [CAFE2019].[dbo].[tb_My_Audit_User] audit_user ON audut_user.AuditID=audit.ObjID 
                JOIN [CAFE2019].[dbo].[tb_User] user ON user.ObjID=audut_user.UserID
                where [dbo].[tb_My_Audit]=".$_GET['AuditID'];
                
$data=queryRestArt($tsql);

 // Выдаем JSON ответ 
$json_data= json_encode($data);
header("Content-type: application/json; charset=utf-8");
echo $_GET['callback'] . ' (' . $json_data . ');';