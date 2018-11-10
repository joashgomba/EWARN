<?php
class Zone{
 
    // database connection and table name
    private $conn;
    private $table_name = "zones";
 
    // object properties
    public $id;
	public $zone;
	public $zonal_code;
	public $country_id;	
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	
	function read(){
 
    // select all query
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
                
            ORDER BY
                p.id DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
	}
	
	function readOne(){
 
    // query to read single record
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
            WHERE
                p.id = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
	$this->zone = $row['zone'];
	$this->zonal_code = $row['zonal_code'];
	$this->country_id = $row['country_id'];
  }
  
  
  function getByCountry(){
 
    // query to read single record
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
            WHERE
                p.country_id = ?
            ORDER BY
                p.id ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->country_id);
 
    // execute query
    $stmt->execute();
	
	return $stmt;
 
    
	
  }
  
  
}