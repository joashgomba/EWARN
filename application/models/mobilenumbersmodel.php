<?php

class Mobilenumbersmodel extends CI_Model {

  private $tbl_roles= 'mobilenumbers';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('mobilenumbers');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_list_by_country($country_id)
	{
		$sql = "SELECT * FROM mobilenumbers WHERE country_id=".$country_id." ORDER BY id DESC";
		$query = $this->db->query($sql);
		
		return $query->result();	
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
	
	function get_by_all_sector($zone_id,$region_id,$district_id,$sector) {

		$data = array();
		$this->db->where('zone_id', $zone_id)
				 ->where('region_id', $region_id)
				 ->where('district_id', $district_id)
				 ->where('sector', $sector);
		$Q = $this->db->get('mobilenumbers');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_zone_sector($zone_id,$sector) {

		$data = array();
		$this->db->where('zone_id', $zone_id)
				 ->where('sector', $sector);
		$Q = $this->db->get('mobilenumbers');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_region_sector($region_id,$sector) {

		$data = array();
		$this->db->where('region_id', $region_id)
				 ->where('sector', $sector);
		$Q = $this->db->get('mobilenumbers');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_region_id($region_id) {

		$data = array();
		$this->db->where('region_id', $region_id);
		$Q = $this->db->get('mobilenumbers');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
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
