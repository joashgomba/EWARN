<?php

class Documentsmodel extends CI_Model {

  	private $tbl_roles= 'documents';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('documents');
		
		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_list_country($country_id) {

		$this->db->select('t1.*')
		     ->from('documents AS t1')
			 ->where('t1.country_id', $country_id)
			 ->order_by('t1.id DESC');
        
        return $this->db->get();
	
	}
	
	function get_list_zone($zone_id,$country_id) {

		$this->db->select('t1.*')
		     ->from('documents AS t1')
			 ->where('t1.zone_id', $zone_id)
			 ->where('t1.country_id', $country_id)
			 ->order_by('t1.id DESC');
        
        return $this->db->get();
	
	}
	
	function get_list_region($region_id,$country_id) {

		$this->db->select('t1.*')
		     ->from('documents AS t1')
			 ->where('t1.region_id', $region_id)
			 ->where('t1.country_id', $country_id)
			 ->order_by('t1.id DESC');
        
        return $this->db->get();
	
	}
	
	function get_list_district($district_id,$country_id) {

		$this->db->select('t1.*')
		     ->from('documents AS t1')
			 ->where('t1.district_id', $district_id)
			 ->where('t1.country_id', $country_id)
			 ->order_by('t1.id DESC');
        
        return $this->db->get();
	
	}

	
	function get_list_level($level,$country_id) {

		$this->db->select('t1.*')->from('documents AS t1')->where('t1.level', $level)->where('t1.country_id', $country_id)->order_by('t1.id DESC');
        
        return $this->db->get();
	
	}

	// get number of roles in database

	function count_all(){

		return $this->db->count_all($this->tbl_roles);

	}

	// get roles with paging

	function get_paged_list($limit = 10, $offset = 0){

		$this->db->order_by('id','asc');

		return $this->db->get($this->tbl_roles, $limit, $offset);

	}

	// get role by id

	function get_by_id($id){

		$this->db->where('id', $id);

		return $this->db->get($this->tbl_roles);

	}
	
	function get_by_zonal_limit($zone_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('documents AS t1')
		  ->where('t1.zone_id',$zone_id)
		  ->order_by('t1.id DESC')
		  ->limit(5);
		  
		return $this->db->get();
	 }
	 
	 function get_by_region_limit($region_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('documents AS t1')
		  ->where('t1.region_id',$region_id)
		  ->order_by('t1.id DESC')
		  ->limit(5);
		  
		return $this->db->get();
	 }
	 
	  function get_by_district_limit($district_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('documents AS t1')
		  ->where('t1.district_id',$district_id)
		  ->order_by('t1.id DESC')
		  ->limit(5);
		  
		return $this->db->get();
	 }
	
		
	function get_by_level_limit($level)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('documents AS t1')
		  ->where('t1.level',$level)
		  ->order_by('t1.id DESC')
		  ->limit(5);
		  
		return $this->db->get();
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
