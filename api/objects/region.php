<?php
class Region{
 
    // database connection and table name
    private $conn;
    private $table_name = "regions";
 
    // object properties
    public $id;
	public $region;
	public $regional_code;
	public $zone_id;
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
	$this->region = $row['region'];
	$this->regional_code = $row['regional_code'];
	$this->zone_id = $row['zone_id'];
  }
  
  
  function getByZone(){
 
    // query to read single record
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
            WHERE
                p.zone_id = ?
            ORDER BY
                p.id ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->zone_id);
 
    // execute query
    $stmt->execute();
	
	return $stmt;
 
    
	
  }
  
  function getByCountry(){
 
    // query to read single record
    $query = "SELECT p.*,z.id AS zoneID
            FROM
                " . $this->table_name . " p, zones z
            WHERE
				p.zone_id = z.id
                AND z.country_id = ?
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