<?php
class Disease{
 
    // database connection and table name
    private $conn;
    private $table_name = "diseases";
 
    // object properties
    public $id;
	public $country_id;
	public $diseasecategory_id;
	public $disease_code;
	public $disease_name;
	public $case_definition;
	public $alert_type;
	public $alert_threshold;
	public $no_of_times;
	public $weeks;
	
 
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
	$this->country_id = $row['country_id'];
	$this->diseasecategory_id = $row['diseasecategory_id'];
	$this->disease_code = $row['disease_code'];
	$this->disease_name = $row['disease_name'];
	$this->case_definition = $row['case_definition'];
	$this->alert_type = $row['alert_type'];
	$this->alert_threshold = $row['alert_threshold'];
	$this->no_of_times = $row['no_of_times'];
	$this->weeks = $row['weeks'];
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