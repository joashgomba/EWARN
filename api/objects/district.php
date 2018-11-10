<?php
class District{
 
    // database connection and table name
    private $conn;
    private $table_name = "districts";
 
    // object properties
    public $id;
	public $district;
	public $region_id;	
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
	$this->district = $row['district'];
	$this->region_id = $row['region_id'];
  }
  
  
  function getByRegion(){
 
    // query to read single record
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
            WHERE
                p.region_id = ?
            ORDER BY
                p.id ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->region_id);
 
    // execute query
    $stmt->execute();
	
	return $stmt;
 
    
	
  }
  
  
  function getByCountry(){
 
    // query to read single record
    $query = "SELECT p.*, r.id AS regionID, z.id AS zoneID
            FROM
                " . $this->table_name . " p, regions r, zones z
            WHERE
				p.region_id = r.id
				AND r.zone_id = z.id
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