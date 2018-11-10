<?php
class mysqldb {
 	
	/*
	FILL IN YOUR DATABASE DETAILS BEFORE RUNNING THE EXAMPLE
	*/
	
	var $hostname = "YOUR_DATABASE_HOSTNAME";
	var $username = "YOUR_DATABASE_USERNAME";
	var $password = "YOUR_DATABASE_PASSWORD";
	var $database = "YOUR_DATABASE_NAME";
   
  
   	function db_connect() {
		$result = mysql_connect($this->hostname,$this->username,$this->password); 
		if (!$result) {
			echo 'Connection to database server at: '.$this->hostname.' failed.';
			return false;
		}
		return $result;
	}

	
	function select_db() {
		$this->db_connect();
		if (!mysql_select_db($this->database)) {
			echo 'Selection of database: '.$this->database.' failed.';
			return false;
		}
	}
	
	function query($query) {
		$result = mysql_query($query) or die("Query failed: $query<br><br>" . mysql_error());
		return $result;
		mysql_free_result($result);
	}
	
	function fetch_array($result) {
		return mysql_fetch_array($result);
	}
	
	function num_rows($result) {
		return mysql_num_rows($result);
	}
	
	function last_insert_id() {
		return mysql_insert_id();
	}
	
	function kill() {
		mysql_close();
	}
   
} 
?>