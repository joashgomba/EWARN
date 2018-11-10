<?php

class Emergenciesmodel extends CI_Model {

	private $tbl_roles= 'emergencies';
   function __construct()
   {
       parent::__construct();
   }

   public function get_list()
   {
       $data = array();
       $Q = $this->db->get('emergencies');
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
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS emergency_id,t2.*,t3.*,t4.*, t5.*')
          ->from('emergencies AS t1, districts AS t2, regions AS t3, zones AS t4, countries AS t5')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')
		  ->where('t3.zone_id = t4.id')
		  ->where('t4.country_id = t5.id')
		  ->where('t5.id',$country_id)
		  ->order_by('t5.country_name ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	
	function get_by_period_healthfacility($reportingperiod_id,$healthfacility_id) {

		$data = array();
		$this->db->where('epicalendar_id', $reportingperiod_id)
		         ->where('healthfacility_id', $healthfacility_id);
		$Q = $this->db->get('emergencies');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_district($reportingperiod_id,$district_id) {

		$data = array();
		$this->db->where('epicalendar_id', $reportingperiod_id)
		         ->where('district_id', $district_id);
		$Q = $this->db->get('emergencies');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_region($reportingperiod_id,$region_id) {

		$data = array();
		$this->db->where('epicalendar_id', $reportingperiod_id)
		         ->where('region_id', $region_id);
		$Q = $this->db->get('emergencies');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_zone($reportingperiod_id,$zone_id) {

		$data = array();
		$this->db->where('epicalendar_id', $reportingperiod_id)
		         ->where('zone_id', $zone_id);
		$Q = $this->db->get('emergencies');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	
	function get_by_period($reportingperiod_id) {

		$data = array();
		$this->db->where('epicalendar_id', $reportingperiod_id);
		$Q = $this->db->get('emergencies');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	

   public function count_all()
   {
       return $this->db->count_all($this->tbl_roles);
   }

   public function get_by_id($id)
   {
       $this->db->where('id', $id);
       return $this->db->get($this->tbl_roles);
   }

   public function save($role)
   {
       $this->db->insert($this->tbl_roles, $role);
       return $this->db->insert_id();
   }

   public function update($id,$role)
   {
       $this->db->where('id', $id);
       $this->db->update($this->tbl_roles, $role);
   }

   public function delete($id)
   {
       $this->db->where('id', $id);
       $this->db->delete($this->tbl_roles);
   }

}
