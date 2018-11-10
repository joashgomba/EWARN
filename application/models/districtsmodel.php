<?php

class Districtsmodel extends CI_Model {

   private $tbl_roles= 'districts';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('districts');

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
		$sql = "SELECT countries.country_name,zones.zone, regions.region,districts.*
		FROM countries, zones, regions, districts
		WHERE countries.id = zones.country_id
		AND zones.id = regions.zone_id
		AND regions.id = districts.region_id
		AND countries.id = ".$country_id.'
		ORDER BY districts.district ASC';
		
		$query = $this->db->query($sql);
        
       return $query->result();
	}
	
	function get_list_by_country($country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS district_id,t2.*,t3.*,t4.*')
          ->from('districts AS t1, regions AS t2, zones AS t3, countries AS t4')
		  ->where('t1.region_id = t2.id')
		  ->where('t2.zone_id = t3.id')
		  ->where('t3.country_id = t4.id')
		  ->where('t4.id',$country_id)
		  ->order_by('t4.country_name ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_list($perpage=0,$start=0)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS district_id,t2.*,t3.*,t4.*')
          ->from('districts AS t1, regions AS t2, zones AS t3, countries AS t4')
		  ->where('t1.region_id = t2.id')
		  ->where('t2.zone_id = t3.id')
		  ->where('t3.country_id = t4.id')
		  ->order_by('t4.country_name ASC, zone ASC, region ASC, district ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_country_list($perpage=0,$start=0,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS district_id,t2.*,t3.*,t4.*')
          ->from('districts AS t1, regions AS t2, zones AS t3, countries AS t4')
		  ->where('t1.region_id = t2.id')
		  ->where('t2.zone_id = t3.id')
		  ->where('t3.country_id = t4.id')
		  ->where('t4.id',$country_id)
		  ->order_by('t4.country_name ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	
	function search_list($district)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS district_id,t2.*,t3.*,t4.*')
          ->from('districts AS t1, regions AS t2, zones AS t3, countries AS t4')
		  ->where('t1.region_id = t2.id')
		  ->where('t2.zone_id = t3.id')
		  ->where('t3.country_id = t4.id')
		  ->like('t1.district', $district, 'after')
		  ->order_by('t4.country_name ASC, zone ASC, region ASC, district ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function search_country_list($district,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS district_id,t2.*,t3.*,t4.*');
          $this->db->from('districts AS t1, regions AS t2, zones AS t3, countries AS t4');
		  $this->db->where('t1.region_id = t2.id');
		  $this->db->where('t2.zone_id = t3.id');
		  $this->db->where('t3.country_id = t4.id');
		  $this->db->like('t1.district', $district, 'after');
		  $this->db->where('t4.id',$country_id);
		  $this->db->order_by('t4.country_name ASC, zone ASC, region ASC, district ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_list_by_parameters($country_id,$zone_id,$region_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS district_id,t2.*,t3.*,t4.*');
          $this->db->from('districts AS t1, regions AS t2, zones AS t3, countries AS t4');
		  $this->db->where('t1.region_id = t2.id');
		  $this->db->where('t2.zone_id = t3.id');
		  $this->db->where('t3.country_id = t4.id');
		  if($region_id !=0)
		  {
		  	$this->db->where('t2.id',$region_id);
		  }
		  if($zone_id !=0)
		  {
		  	$this->db->where('t3.id',$zone_id);
		  }
		  $this->db->where('t4.id',$country_id);
		  $this->db->order_by('t4.country_name ASC, zone ASC, region ASC, district ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_list_by_parameters($perpage=0,$start=0,$country_id,$zone_id,$region_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS district_id,t2.*,t3.*,t4.*');
          $this->db->from('districts AS t1, regions AS t2, zones AS t3, countries AS t4');
		  $this->db->where('t1.region_id = t2.id');
		  $this->db->where('t2.zone_id = t3.id');
		  $this->db->where('t3.country_id = t4.id');
		  if($region_id !=0)
		  {
		  	$this->db->where('t2.id',$region_id);
		  }
		  if($zone_id !=0)
		  {
		  	$this->db->where('t3.id',$zone_id);
		  }
		  $this->db->where('t4.id',$country_id);
		  $this->db->order_by('t4.country_name ASC, zone ASC, region ASC, district ASC');
		  $this->db->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_combined_list()
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS district_id, t2.*')
          ->from('districts AS t1, regions AS t2')
		  ->where('t1.region_id = t2.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 function get_zone_districts($zone_id)
	 {
		$sql = 'SELECT t1.district,t1.id AS district_id, t2.*,t3.*
		FROM districts AS t1,regions AS t2,zones AS t3
		WHERE t1.region_id = t2.id
		AND t2.zone_id = t3.id
		AND t3.id = '.$zone_id.'
		ORDER BY t1.id DESC';
		
		$query = $this->db->query($sql);
        
       return $query->result();
	 }
	 
	 function get_by_zone($zone_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS district_id, t2.*,t3.*')
          ->from('districts AS t1,regions AS t2,zones AS t3')
		  ->where('t1.region_id = t2.id')		  
		  ->where('t2.zone_id = t3.id')
		  ->where('t3.id',$zone_id)
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 function get_districts_by_region($region_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS district_id, t2.*,t3.*')
          ->from('districts AS t1,regions AS t2,zones AS t3')
		  ->where('t1.region_id = t2.id')		  
		  ->where('t2.zone_id = t3.id')
		  ->where('t2.id',$region_id)
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	
	 function get_by_region($region_id) {

		$data = array();
		$this->db->where('region_id', $region_id);
		$Q = $this->db->get('districts');

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

		
	function get_by_name($district){

		$this->db->where('district', $district);

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
