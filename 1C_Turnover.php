<?php
// Получение оборотов по счету

include('lib/lib_1c_odata.php');

$sum=turnoversByAccount('2018-01-01','2018-02-01','90012');
echo 'Январь </br>';
echo '90.01.2  Выручка '.$sum[All][Cr].'</br>';
$sum=turnoversByAccount('2018-01-01','2018-02-01','2003');

echo '20.03 Себестоимость  '.$sum[All][Cr].'</br>';
	
?>