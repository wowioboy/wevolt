<?php

//------------------------------------------------------------------------------
require_once("config.inc.php");

// Setup connection
$database_connection = @mysql_connect(_DATABASE_HOST, _DATABASE_USER_NAME, _DATABASE_PASSWORD) or die("DB connection error! Please configure your settings.");
@mysql_select_db(_DATABASE_NAME, $database_connection) or die("db connection error!");

// RETURN TYPES FOR DATABASE_QUERY FUNCTION
define("_ALL_ROWS", 0);
define("_FIRST_ROW_ONLY", 1);
define("_DATA_ONLY", 0);
define("_ROWS_ONLY", 1);
define("_DATA_AND_ROWS", 2);
define("_FIELDS_ONLY", 3);
define("_FETCH_ASSOC", "mysql_fetch_assoc");
define("_FETCH_ARRAY", "mysql_fetch_array");


function database_query($sql, $return_type = _DATA_ONLY, $first_row_only = _ALL_ROWS, $fetch_func = _FETCH_ASSOC, $debug=false) {
	$data_array = array();
	$num_rows = 0;
	$fields_len = 0;
	
	$result = mysql_query($sql, $GLOBALS["database_connection"]) or die($sql . "|" . mysql_error());
	if ($return_type == 0 || $return_type == 2) {
		while ($row_array = $fetch_func($result)) {
			if (!$first_row_only) {
				array_push($data_array, $row_array);
			} else {
				$data_array = $row_array;
				break;
			}
		}
	}
	$num_rows = mysql_num_rows($result);
	$fields_len = mysql_num_fields($result);
	mysql_free_result($result);
	if($debug == true) echo $sql . "-" . mysql_error();
	
	switch ($return_type) {
		case _DATA_ONLY:
			return $data_array;
		case _ROWS_ONLY:
			return $num_rows;
		case _DATA_AND_ROWS:
			return array($data_array, $num_rows);
		case _FIELDS_ONLY:
			return $fields_len;
	}	
}


function database_void_query($sql, $debug=false) {
	$result = mysql_query($sql, $GLOBALS["database_connection"]);	
	if($debug == true) echo $sql . " - " . mysql_error();
	$affected_rows = mysql_affected_rows($GLOBALS["database_connection"]);
	if(preg_match("/\bupdate\b/i", $sql)){
		 if($affected_rows >= 0) return true;
	}else if(preg_match("/\binsert\b/i", $sql)){
		 if($affected_rows >= 0) return mysql_insert_id();
	}else if($affected_rows > 0){ 
		return true;
	}
	return false;
}

function set_collation(){
	$encoding = "utf8";
	$collation = "utf8_unicode_ci";
	
	$sql_variables = array(
		'character_set_client'  =>$encoding,
		'character_set_server'  =>$encoding,
		'character_set_results' =>$encoding,
		'character_set_database'=>$encoding,
		'character_set_connection'=>$encoding,
		'collation_server'      =>$collation,
		'collation_database'    =>$collation,
		'collation_connection'  =>$collation
	);

	foreach($sql_variables as $var => $value){
		$sql = "SET $var=$value;";
		database_void_query($sql);
	}        
}


?>