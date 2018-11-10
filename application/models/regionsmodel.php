<?php

class Regionsmodel extends CI_Model {

   private $tbl_roles= 'regions';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('regions');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_country($country_id)
	{
		$sql = "SELECT countries.country_name,zones.zone, regions.*
		FROM countries, zones, regions
		WHERE countries.id = zones.country_id
		AND zones.id = regions.zone_id
		AND countries.id = ".$country_id;
		
		$query = $this->db->query($sql);
        
       return $query->result();
	}
	
	function get_combined_list()
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS region_id, t2.*')
          ->from('regions AS t1, zones AS t2')
		  ->where('t1.zone_id = t2.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 
	 function get_list_by_country($country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS region_id,t2.*,t3.*')
          ->from('regions AS t1, zones AS t2, countries AS t3')
		  ->where('t1.zone_id = t2.id')
		  ->where('t2.country_id = t3.id')
		  ->where('t3.id',$country_id)
		  ->order_by('t1.region ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	 function get_list_by_country_zone($country_id,$zone_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS region_id,t2.*,t3.*')
          ->from('regions AS t1, zones AS t2, countries AS t3')
		  ->where('t1.zone_id = t2.id')
		  ->where('t2.country_id = t3.id')
		  ->where('t2.id',$zone_id)
		  ->where('t3.id',$country_id)
		  ->order_by('t1.region ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_filter_list($perpage=0,$start=0,$country_id,$zone_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS region_id,t2.*,t3.*')
          ->from('regions AS t1, zones AS t2, countries AS t3')
		  ->where('t1.zone_id = t2.id')
		  ->where('t2.country_id = t3.id')
		  ->where('t2.id',$zone_id)
		  ->where('t3.id',$country_id)
		  ->order_by('t1.region ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_list($perpage=0,$start=0)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS region_id')
          ->from('regions AS t1')
		  ->order_by('t1.region ASC')
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
		$this->db->select('t1.*, t1.id AS region_id,t2.*,t3.*')
          ->from('regions AS t1, zones AS t2, countries AS t3')
		  ->where('t1.zone_id = t2.id')
		  ->where('t2.country_id = t3.id')
		  ->where('t3.id',$country_id)
		  ->order_by('t1.region ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	
	function search_list($region)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS region_id')
          ->from('regions AS t1')
		  ->like('t1.region',$region,'after');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function search_country_list($region,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS region_id,t2.country_id')
          ->from('regions AS t1, zones AS t2')
		  ->where('t1.zone_id = t2.id')
		  ->where('t2.country_id',$country_id)
		  ->like('t1.region',$region,'after');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	 
	
	function get_by_zone($zone_id) {

		$data = array();
		$this->db->where('zone_id', $zone_id);
		$Q = $this->db->get('regions');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}

	// get number of roles in database

	function count_all(){

		return $this->db->count_all($this->tbl_roles);

	}

	
	
	function get_by_name($region){

		$this->db->where('region', $region);

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
