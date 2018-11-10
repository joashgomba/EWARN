<?php
class Healthfacility{
 
    // database connection and table name
    private $conn;
    private $table_name = "healthfacilities";
 
    // object properties
    public $id;
	public $health_facility;
	public $country_id;	
	public $district_id;
 
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
	$this->health_facility = $row['health_facility'];
	$this->district_id = $row['district_id'];
  }
  
  
  function getByDistrict(){
 
    // query to read single record
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
            WHERE
                p.district_id = ?
            ORDER BY
                p.id ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->district_id);
 
    // execute query
    $stmt->execute();
	
	return $stmt;
 
    
	
  }
  
  function getByCountry(){
 
    // query to read single record
    $query = "SELECT h.*,d.id AS districtID, r.id AS region_id, z.id AS zone_id
            FROM
                " . $this->table_name . " h, districts d, regions r, zones z
            WHERE
                h.district_id = d.id
				AND d.region_id = r.id
				AND r.zone_id = z.id
				AND z.country_id = ?
            ORDER BY
                h.id ASC";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->country_id);
 
    // execute query
    $stmt->execute();
	
	return $stmt;
 
    
	
  }
  
  
}