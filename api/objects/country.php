<?php
class Country{
 
    // database connection and table name
    private $conn;
    private $table_name = "countries";
 
    // object properties
    public $id;
	public $country_name;
	public $first_admin_level_label;
	public $second_admin_level_label;
	public $third_admin_level_label;	
 
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
	$this->country_name = $row['country_name'];
	$this->first_admin_level_label = $row['first_admin_level_label'];
	$this->second_admin_level_label = $row['second_admin_level_label'];
	$this->third_admin_level_label = $row['third_admin_level_label'];
  }
  
  
   
}