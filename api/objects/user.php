<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
	public $fname;
	public $lname;
	public $healthfacility_id;
	public $organization;
	public $email;
	public $contact_number;
	public $username;
	public $password;
	public $role_id;
	public $active;
	public $level;
	public $zone_id;
	public $region_id;
	public $district_id;
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
	$this->fname = $row['fname'];
	$this->lname = $row['lname'];
	$this->healthfacility_id = $row['healthfacility_id'];
	$this->organization = $row['organization'];
	$this->email = $row['email'];
	$this->contact_number = $row['contact_number'];
	$this->username = $row['username'];
	$this->password = $row['password'];
	$this->role_id = $row['role_id'];
	$this->active = $row['active'];
	$this->level = $row['level'];
	$this->zone_id = $row['zone_id'];
	$this->region_id = $row['region_id'];
	$this->district_id = $row['district_id'];
	$this->country_id = $row['country_id'];
  }
  
  
  function loginUser(){
 
    // query to read single record
    $query = "SELECT *
            FROM
                " . $this->table_name . " p
            WHERE
                p.password = ?
			AND p.username = ?
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
	$password = md5($this->password);
    $stmt->bindParam(1, $password);
	$stmt->bindParam(2, $this->username, PDO::PARAM_STR, 12);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
	$this->id = $row['id'];
	$this->fname = $row['fname'];
	$this->lname = $row['lname'];
	$this->healthfacility_id = $row['healthfacility_id'];
	$this->organization = $row['organization'];
	$this->email = $row['email'];
	$this->contact_number = $row['contact_number'];
	$this->username = $row['username'];
	$this->password = $row['password'];
	$this->role_id = $row['role_id'];
	$this->active = $row['active'];
	$this->level = $row['level'];
	$this->zone_id = $row['zone_id'];
	$this->region_id = $row['region_id'];
	$this->district_id = $row['district_id'];
	$this->country_id = $row['country_id'];
  }
  
  
}