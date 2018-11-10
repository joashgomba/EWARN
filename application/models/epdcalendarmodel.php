<?php

class Epdcalendarmodel extends CI_Model {

     private $tbl_roles= 'epdcalendar';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('epdcalendar');

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
		$this->db->where('country_id', $country_id);
		$Q = $this->db->get('epdcalendar');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_list_by_year($epdyear) {

		$data = array();
		$this->db->where('epdyear', $epdyear);
		$Q = $this->db->get('epdcalendar');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_list_by_asc_date($start_date,$end_date,$country_id)
	{
		$sql = 'SELECT * 
		FROM  epdcalendar 
		WHERE  epdcalendar.from >=  "'.$start_date.'"
		AND  epdcalendar.to <=  "'.$end_date.'"
		AND epdcalendar.country_id='.$country_id.'
		ORDER BY epdcalendar.from ASC';
		
		$query = $this->db->query($sql);
        
       return $query->result();
	}
	
	function get_list_by_date($start_date,$end_date,$country_id)
	{
		$sql = 'SELECT * 
		FROM  epdcalendar 
		WHERE  epdcalendar.from >=  "'.$start_date.'"
		AND  epdcalendar.to <=  "'.$end_date.'"
		AND epdcalendar.country_id='.$country_id.'
		ORDER BY epdcalendar.from ASC';
		
		$query = $this->db->query($sql);
        
       return $query->result();
	}
	
	function get_list_by_year_country($epdyear,$country_id) {

		$data = array();
		$this->db->where('epdyear', $epdyear)
				 ->where('country_id', $country_id);
		$Q = $this->db->get('epdcalendar');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_country_date($country_id,$date)
	{
		$sql = 'SELECT * 
			FROM epdcalendar
			WHERE country_id ='.$country_id.'
			AND  "'.$date.'" >= epdcalendar.from
			AND  "'.$date.'" <= epdcalendar.to';
			
			$query = $this->db->query($sql);
			
			$row = $query->row();
		
		    return $row->id;
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
	
	function get_by_reporting_year_country($reporting_year,$country_id){

		$this->db->where('epdyear', $reporting_year)
		 		 ->where('country_id', $country_id);
				
		return $this->db->get($this->tbl_roles);

	}
	
	function get_by_reporting_year($reporting_year){

		$this->db->where('epdyear', $reporting_year);
				
		return $this->db->get($this->tbl_roles);

	}
	
	function get_by_year_week_country($reporting_year,$week_no,$country_id){

		$this->db->where('epdyear', $reporting_year)
				 ->where('week_no', $week_no)
				 ->where('country_id', $country_id);
				
		return $this->db->get($this->tbl_roles);

	}


	function get_by_year_week($reporting_year,$week_no){

		$this->db->where('epdyear', $reporting_year)
				 ->where('week_no', $week_no);
				
		return $this->db->get($this->tbl_roles);

	}
	
	function get_by_country_id($country_id){

		$this->db->where('country_id', $country_id);

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
