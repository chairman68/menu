<?php

// lib/db_RestArt.php

namespace orange;

class db_RestArt {

	private $config;
	private $kassa;
	private $conn;

	public function __construct ($config,$kassa){
		$this->config=$config;
		$this->kassa=$kassa;
		$this->conn = sqlsrv_connect($config->db_connect->server_name, (array) $config->db_connect->kassa[$kassa]); 
		 if(!$this->conn){
		        echo "Нет подключения к серверу БД!";
		 }   

	}

	public function query ($tsql){
		// Выполнение запроса    
	    $out=array();
	    $getResults= sqlsrv_query($this->conn, $tsql);

	    //if ($getResults == FALSE) die(FormatErrors(sqlsrv_errors()));
	    if ($getResults == FALSE) die();
	    
	    $i=1;
	    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
	        $out[$i]=$row;
	        $i++;
	    }

	    sqlsrv_free_stmt($getResults);

	    return $out;
	}
	public function addRecord ($tablename,$column_data){

		$query_insert="INSERT INTO ".$tablename." (";
		$query_insert2=") VALUES (";
		foreach ($column_data as $key => $value) {
			$query_insert.=$key.",";
			$query_insert2.=$value.",";
		}
		$query_insert=	str_replace(",)", ")", $query_insert.$query_insert2.")");
		echo $query_insert;

	}
	public function close_connection () {

		sqlsrv_close($this->conn);
	}

	function FormatErrors( $errors )	{
	    /* Display errors. */
	    echo "Error information: ";

	    foreach ( $errors as $error )
	    {
	        echo "SQLSTATE: ".$error['SQLSTATE']."";
	        echo "Code: ".$error['code']."";
	        echo "Message: ".$error['message']."";
    	}
	}
}
?>