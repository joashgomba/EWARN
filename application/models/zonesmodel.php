<?php

class Zonesmodel extends CI_Model {

 	private $tbl_roles= 'zones';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles
   
   function get_country_list($country_id) {

		$data = array();
		
		$this->db->where('country_id',$country_id);
		$Q = $this->db->get('zones');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}

	 function get_list() {

		$data = array();

		$Q = $this->db->get('zones');

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

	// get roles with paging

	function get_paged_list($perpage=0,$start=0)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('zones AS t1')
		  ->order_by('t1.zone ASC')
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
          ->from('zones AS t1')
		  ->where('t1.country_id',$country_id)
		  ->order_by('t1.zone ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function search_list($zone)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('zones AS t1')
		  ->like('t1.zone',$zone,'after');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function search_country_list($zone,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('zones AS t1')
		  ->where('t1.country_id',$country_id)
		  ->like('t1.zone',$zone,'after');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
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
