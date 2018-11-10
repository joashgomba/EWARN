<?php

class Bulletinsmodel extends CI_Model {

   private $tbl_roles= 'bulletins';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('bulletins');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_level_limit($level)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('bulletins AS t1')
		  ->where('t1.level',$level)
		  ->order_by('t1.id DESC')
		  ->limit(5);
		  
		return $this->db->get();
	 }
	
	function get_by_level($level)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('bulletins AS t1')
		  ->where('t1.level',$level)
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 function get_zonal_list_by_level($level)
	 {
		 $array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS bulletin_id, t2.*')
          ->from('bulletins AS t1,zones AS t2')
		  ->where('t1.level',$level)
		  ->where('t1.zone_id = t2.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 function get_zonal_list_by_level_zone($level,$zone_id)
	 {
		$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS bulletin_id, t2.*')
          ->from('bulletins AS t1,zones AS t2')
		  ->where('t1.level',$level)
		  ->where('t2.id',$zone_id)
		  ->where('t1.zone_id = t2.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 function get_combined_list_region($level)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS bulletin_id, t2.*')
          ->from('bulletins AS t1, regions AS t2')
		  ->where('t1.level',$level)
		  ->where('t1.region_id = t2.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	
	function get_combined_list($level,$region_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS bulletin_id, t2.*')
          ->from('bulletins AS t1, regions AS t2')
		  ->where('t1.level',$level)
		  ->where('t1.region_id',$region_id)
		  ->where('t1.region_id = t2.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	
	function get_by_period($reportingperiod_id) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id);
		$Q = $this->db->get('bulletins');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_year_week($week_year,$week_no,$level){

		$this->db->where('week_year', $week_year)
				 ->where('week_no', $week_no)
				 ->where('level', $level);
				
		return $this->db->get($this->tbl_roles);

	}
	
	function get_by_year_week_zone($week_year,$week_no,$zone_id){

		$this->db->where('week_year', $week_year)
				 ->where('week_no', $week_no)
				 ->where('zone_id', $zone_id);
				
		return $this->db->get($this->tbl_roles);

	}
	
	function get_by_year_week_region($week_year,$week_no,$region_id){

		$this->db->where('week_year', $week_year)
				 ->where('week_no', $week_no)
				 ->where('region_id', $region_id);
				
		return $this->db->get($this->tbl_roles);

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
	
	function reporting_period_id($reportingperiod_id){

		$this->db->where('reportingperiod_id', $reportingperiod_id);

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
