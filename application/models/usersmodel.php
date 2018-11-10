<?php

class Usersmodel extends CI_Model {

    private $tbl_roles= 'users';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles
   
    function login($username, $password)
    {

	   $this -> db -> select('id, username, password, isadmin, active');
	   $this -> db -> from('users');
	   $this -> db -> where('username = ' . "'" . $username . "'");
	   $this -> db -> where('password = ' . "'" . MD5($password) . "'");
	   $this -> db -> where('active = 1');
	   $this -> db -> limit(1);

	   $query = $this -> db -> get();

	   if($query -> num_rows() == 1)
	   {
		 return $query->result();
	   }
	   else
	   {
		 return false;
	   }
	 }

	 function get_list() {

		$data = array();

		$Q = $this->db->get('users');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}

    public function get_by_hf($healthfacility_id)
    {
        $data = array();
        $this->db->where('healthfacility_id',$healthfacility_id);
        $Q = $this->db->get('users');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
	
	function get_list_by_country($country_id) {

		$data = array();
		$this->db->where('country_id',$country_id);
		$Q = $this->db->get('users');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}

    public function get_by_region($region_id)
    {
        $data = array();
        $this->db->where('region_id',$region_id);
        $Q = $this->db->get('users');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    public function get_by_district($district_id)
    {
        $data = array();
        $this->db->where('district_id',$district_id);
        $Q = $this->db->get('users');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
	
	
	function get_paged_list($perpage=0,$start=0)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('users AS t1')
		  ->order_by('t1.id DESC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_country_list($perpage=0,$start=0,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('users AS t1')
		  ->where('t1.country_id',$country_id)
		  ->order_by('t1.id DESC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	
	function get_paged_filter_list($perpage=0,$start=0,$country_id=0,$zone_id=0,$region_id=0,$district_id=0,$level=0)
   {
	 	$one=false;
		$array='array';
		$data = array();
		
		if($country_id!=0)
		 {
			 $this->db->where('country_id',$country_id);
		 }
		 if($zone_id!=0)
		 {
			 $this->db->where('zone_id',$zone_id);
		 }
		 
		  if($region_id!=0)
		 {
			 $this->db->where('region_id',$region_id);
		 }
		 
		  if($district_id!=0)
		 {
			$this->db->where('district_id',$district_id);
		 }
		 
		  if($level!=0)
		 {
			 $this->db->where('level',$level);
		 }
		 
		 $this->db->order_by('id DESC');
		 $this->db->limit($perpage,$start);
		
		$query = $this->db->get('users');
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	 public function get_filter_list($country_id=0,$zone_id=0,$region_id=0,$district_id=0,$level=0)
   {
       $data = array();
	   if($country_id!=0)
		 {
			 $this->db->where('country_id',$country_id);
		 }
		 if($zone_id!=0)
		 {
			 $this->db->where('zone_id',$zone_id);
		 }
		 
		  if($region_id!=0)
		 {
			 $this->db->where('region_id',$region_id);
		 }
		 
		  if($district_id!=0)
		 {
			$this->db->where('district_id',$district_id);
		 }
		 
		  if($level!=0)
		 {
			 $this->db->where('level',$level);
		 }
		 
       $Q = $this->db->get('users');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
    public function get_letter_filter_list($letter)
   {
       $data = array();
	   $this->db->like('fname', $letter, 'after'); 
		 
       $Q = $this->db->get('users');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   public function get_letter_country_filter_list($letter,$country_id)
   {
       $data = array();
	   $this->db->where('country_id',$country_id);
	   $this->db->like('fname', $letter, 'after'); 
		 
       $Q = $this->db->get('users');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   function get_paged_letter_filter_list($perpage=0,$start=0,$letter)
   {
	 	$one=false;
		$array='array';
		$data = array();
		
		 $this->db->like('fname', $letter, 'after'); 
		 
		 $this->db->order_by('fname ASC');
		 $this->db->limit($perpage,$start);
		
		$query = $this->db->get('users');
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	
	function get_paged_letter_country_filter_list($perpage=0,$start=0,$letter,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		
		 $this->db->where('country_id',$country_id);
		 $this->db->like('fname', $letter, 'after'); 
		 
		 $this->db->order_by('fname ASC');
		 $this->db->limit($perpage,$start);
		
		$query = $this->db->get('users');
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	function get_combined_list()
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('users AS t1')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	
	 
	 function get_filter($zone_id,$region_id,$district_id,$level)
	 {
		 $thequery = "SELECT t1.*
	 	FROM users AS t1
	 	WHERE t1.id !=0";
		 
		 if($zone_id!=0)
		 {
			 $thequery .=" AND t1.zone_id=".$zone_id;
		 }
		 
		  if($region_id!=0)
		 {
			 $thequery .=" AND t1.region_id=".$region_id;
		 }
		 
		  if($district_id!=0)
		 {
			 $thequery .=" AND t1.district_id=".$district_id;
		 }
		 
		  if($level!=0)
		 {
			 $thequery .=" AND t1.level=".$level;
		 }
		 
		 $thequery .= " ORDER BY t1.id DESC";
		 
		 $query = $this->db->query($thequery);
		 
		 return $query->result();
	 }
	 
	 function get_by_hf_id($healthfacility_id){

		$this->db->where('healthfacility_id', $healthfacility_id);

		return $this->db->get($this->tbl_roles);

	}


    function get_list_by_regions($region_id)
    {
        $one=false;
        $array='array';
        $data = array();
        $this->db->select('t1.*');
        $this->db->from('users AS t1');
        $this->db->where('t1.region_id',$region_id);

        $this->db->order_by('fname ASC');

        $query = $this->db->get();

        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
    }

	// get number of roles in database

	function count_all(){

		return $this->db->count_all($this->tbl_roles);

	}

	// get roles with paging

	function get_paged_list_old($limit = 10, $offset = 0){

		$this->db->order_by('id','asc');

		return $this->db->get($this->tbl_roles, $limit, $offset);

	}
	
	function get_by_username($username){

		$this->db->where('username', $username);

		return $this->db->get($this->tbl_roles);

	}

	// get role by id

	function get_by_id($id){

		$this->db->where('id', $id);

		return $this->db->get($this->tbl_roles);

	}

	// add new role

	function save($role){

		$this->db->insert($this->tbl_roles, $role);

		return $this->db->insert_id();

	}

	// update role by id

	function update($id, $role){

		$this->db->where('id', $id);

		$this->db->update($this->tbl_roles, $role);

	}

	// delete role by id

	function delete($id){

		$this->db->where('id', $id);

		$this->db->delete($this->tbl_roles);

	}

}
