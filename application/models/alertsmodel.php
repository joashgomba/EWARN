<?php

class Alertsmodel extends CI_Model {

private $tbl_roles= 'alerts';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	 function get_list_by_form($reportingform_id) {

		$data = array();
		$this->db->where('reportingform_id',$reportingform_id);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_list_limit()
	{
		$sql = 'SELECT * FROM  alerts LIMIT 90';
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_hf_alerts_locations($zone_id,$region_id,$district_id,$from, $to,$reporting_year, $reporting_year2,$status)
	{
		$sql = 'SELECT healthfacilities.*,healthfacilities.id AS hf_id,districts.*,regions.*,zones.* FROM healthfacilities,districts,regions,zones
		WHERE healthfacilities.activated=1';
		
		$sql .= ' AND zones.id = regions.zone_id AND regions.id = districts.region_id AND districts.id=healthfacilities.district_id';
		if ($zone_id != 0) {
            $sql .= ' AND zones.id=' . $zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND regions.id=' . $region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND districts.id=' . $district_id;
        }
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_by_locations_hf($zone_id,$region_id,$district_id,$from, $to,$reporting_year, $reporting_year2,$healthfacility_id)
	{
		$sql = 'SELECT * FROM alerts
		WHERE healthfacility_id = '.$healthfacility_id.' ';
		if ($reporting_year == $reporting_year2) {
			$sql .= 'AND reportingperiod_id>=' . $from . ' AND reportingperiod_id <=' . $to . ' ';
		}
		 else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
					$sql .= 'AND reportingperiod_id>=' . $from . ' AND reportingperiod_id <=' . $to . ' ';
				}
			}
		 }
		 
		 if ($zone_id != 0) {
            $sql .= ' AND zone_id=' . $zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND region_id=' . $region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND district_id=' . $district_id;
        }
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_by_locations_hf_status($zone_id,$region_id,$district_id,$from, $to,$reporting_year, $reporting_year2,$status,$healthfacility_id)
	{
		$sql = 'SELECT * FROM alerts
		WHERE verification_status='.$status.' AND healthfacility_id='.$healthfacility_id.' ';
		if ($reporting_year == $reporting_year2) {
			$sql .= 'AND reportingperiod_id>=' . $from . ' AND reportingperiod_id <=' . $to . ' ';
		}
		 else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
					$sql .= 'AND reportingperiod_id>=' . $from . ' AND reportingperiod_id <=' . $to . ' ';
				}
			}
		 }
		 
		 if ($zone_id != 0) {
            $sql .= ' AND zone_id=' . $zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND region_id=' . $region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND district_id=' . $district_id;
        }
		
		$query = $this->db->query($sql);
		
		$data = array();
		
		foreach ($query->result_array() as $row){

		        $data[] =  $row['reportingform_id'];
		 }
			 
	$value = '';
	if(empty($data))
	{
		$value = 0;
	}
	else
	{
		$value =$data[0];
	}
   
	   return $value;
	}
	
	
	function get_by_locations($zone_id,$region_id,$district_id,$from, $to,$reporting_year, $reporting_year2,$status)
	{
		$sql = 'SELECT * FROM alerts
		WHERE verification_status='.$status.' ';
		if ($reporting_year == $reporting_year2) {
			$sql .= 'AND reportingperiod_id>=' . $from . ' AND reportingperiod_id <=' . $to . ' ';
		}
		 else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
					$sql .= 'AND reportingperiod_id>=' . $from . ' AND reportingperiod_id <=' . $to . ' ';
				}
			}
		 }
		 
		 if ($zone_id != 0) {
            $sql .= ' AND zone_id=' . $zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND region_id=' . $region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND district_id=' . $district_id;
        }
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_by_period_status_zone($reportingperiod_id,$status,$zone_id) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
				 ->where('verification_status', $status)
				 ->where('zone_id', $zone_id);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_status_zone_bulletin($reportingperiod_id,$status,$include_bulletin,$zone_id) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
				 ->where('verification_status', $status)
				 ->where('include_bulletin', $include_bulletin)
				 ->where('zone_id', $zone_id);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_status_region($reportingperiod_id,$status,$region_id) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
				 ->where('verification_status', $status)
				 ->where('region_id', $region_id);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_status_region_bulletin($reportingperiod_id,$status,$include_bulletin,$region_id) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
				 ->where('verification_status', $status)
				 ->where('include_bulletin', $include_bulletin)
				 ->where('region_id', $region_id);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_status($reportingperiod_id,$status) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
				 ->where('verification_status', $status);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_status_bulletin($reportingperiod_id,$status,$include_bulletin) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
				 ->where('include_bulletin', $include_bulletin)
				 ->where('verification_status', $status);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function sum_by_disease_status_zone($periodstart,$periodend,$status,$disease_name,$zone_id)
	{
		$data = '';
		$sql = 'SELECT SUM( cases ) AS alerts_cases
		FROM alerts
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND verification_status ='.$status.'
		AND disease_name = "'.$disease_name.'"
		AND zone_id = '.$zone_id.'';
		$query = $this->db->query($sql);
        
        //return $query->result();
			foreach ($query->result() as $row){

		         	$data = $row;

		        }
		
		return $data;
		
	}
	
	function sum_by_disease_status_region($periodstart,$periodend,$status,$disease_name,$region_id)
	{
		$data = '';
		$sql = 'SELECT SUM( cases ) AS alerts_cases
		FROM alerts
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND verification_status ='.$status.'
		AND disease_name = "'.$disease_name.'"
		AND region_id = '.$region_id.'';
		$query = $this->db->query($sql);
        
        //return $query->result();
			foreach ($query->result() as $row){

		         	$data = $row;

		        }
		
		return $data;
		
	}
	
	function sum_by_disease_status($periodstart,$periodend,$status,$disease_name)
	{
		$data = '';
		$sql = 'SELECT SUM( cases ) AS alerts_cases
		FROM alerts
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND verification_status ='.$status.'
		AND disease_name = "'.$disease_name.'"';
		$query = $this->db->query($sql);
        
        //return $query->result();
			foreach ($query->result() as $row){

		         	$data = $row;

		        }
		
		return $data;
		
	}
	
	function sum_by_disease_outcome_hf($periodstart,$periodend,$outcome,$healthfacility_id,$disease_name)
	{
		$data = '';
		$sql = 'SELECT SUM( cases ) AS alerts_cases
		FROM alerts
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND healthfacility_id = '.$healthfacility_id.'
		AND disease_name = "'.$disease_name.'"';
		$query = $this->db->query($sql);
        
        //return $query->result();
			foreach ($query->result() as $row){

		         	$data = $row;

		        }
		
		return $data;
		
	}
	
	function sum_by_disease_outcome($periodstart,$periodend,$outcome,$disease_name)
	{
		$data = '';
		$sql = 'SELECT SUM( cases ) AS alerts_cases
		FROM alerts
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND verification_status = 1
		AND outcome ='.$outcome.'
		AND disease_name = "'.$disease_name.'"';
		$query = $this->db->query($sql);
        
        //return $query->result();
			foreach ($query->result() as $row){

		         	$data = $row;

		        }
		
		return $data;
		
	}
	
	function sum_by_disease_outcome_zone($periodstart,$periodend,$outcome,$disease_name,$zone_id)
	{
		$data = '';
		$sql = 'SELECT SUM( cases ) AS alerts_cases
		FROM alerts
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND verification_status = 1
		AND outcome ='.$outcome.'
		AND disease_name = "'.$disease_name.'"
		AND zone_id = '.$zone_id.' ';
		$query = $this->db->query($sql);
        
        //return $query->result();
			foreach ($query->result() as $row){

		         	$data = $row;

		        }
		
		return $data;
		
	}
	
	function sum_by_disease_outcome_region($periodstart,$periodend,$outcome,$disease_name,$region_id)
	{
		$data = '';
		$sql = 'SELECT SUM( cases ) AS alerts_cases
		FROM alerts
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND verification_status = 1
		AND outcome ='.$outcome.'
		AND disease_name = "'.$disease_name.'"
		AND region_id = '.$region_id.' ';
		$query = $this->db->query($sql);
        
        //return $query->result();
			foreach ($query->result() as $row){

		         	$data = $row;

		        }
		
		return $data;
		
	}
	
	function get_sum_by_period_range_zone($periodstart,$periodend,$zone_id)
	{
		$sql = 'SELECT * , SUM( cases ) AS reported_cases
		FROM `alerts`
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND zone_id = '.$zone_id.'
		GROUP BY disease_name';
		
		 $query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_sum_by_period_range_region($periodstart,$periodend,$region_id)
	{
		$sql = 'SELECT * , SUM( cases ) AS reported_cases
		FROM `alerts`
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND region_id = '.$region_id.'
		GROUP BY disease_name';
		
		 $query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_sum_by_period_range_district($periodstart,$periodend,$district_id)
	{
		$sql = 'SELECT * , SUM( cases ) AS reported_cases
		FROM `alerts`
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		AND district_id = '.$district_id.'
		GROUP BY disease_name';
		
		 $query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_sum_by_period_range($periodstart,$periodend)
	{
		$sql = 'SELECT * , SUM( cases ) AS reported_cases
		FROM `alerts`
		WHERE reportingperiod_id
		BETWEEN '.$periodstart.'
		AND '.$periodend.'
		GROUP BY disease_name';
		
		 $query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_sum_by_period_status($reportingperiod_id,$status) {
		 
		 $sql = 'SELECT SUM( cases ) AS reported_cases, disease_name
		FROM alerts
		WHERE reportingperiod_id ='.$reportingperiod_id.'
		AND verification_status ='.$status.'
		GROUP BY disease_name
		ORDER BY reported_cases DESC
		';
        
        $query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_sum_by_period_zone($reportingperiod_id,$zone_id,$status) {
		 
		 $sql = 'SELECT SUM( cases ) AS reported_cases, disease_name
		FROM alerts
		WHERE reportingperiod_id ='.$reportingperiod_id.'
		AND zone_id ='.$zone_id.'
		AND verification_status ='.$status.'
		GROUP BY disease_name
		ORDER BY reported_cases DESC
		';
        
        $query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_sum_by_period_region($reportingperiod_id,$region_id,$status) {
		 
		 $sql = 'SELECT SUM( cases ) AS reported_cases, disease_name
		FROM alerts
		WHERE reportingperiod_id ='.$reportingperiod_id.'
		AND region_id ='.$region_id.'
		AND verification_status ='.$status.'
		GROUP BY disease_name
		ORDER BY reported_cases DESC
		';
        
        $query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_sum_by_period_district($reportingperiod_id,$district_id,$status) {
		 
		 $sql = 'SELECT SUM( cases ) AS reported_cases, disease_name
		FROM alerts
		WHERE reportingperiod_id ='.$reportingperiod_id.'
		AND district_id ='.$district_id.'
		AND verification_status ='.$status.'
		GROUP BY disease_name
		ORDER BY reported_cases DESC
		';
        
        $query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_by_period_zone($reportingperiod_id,$zone_id,$status) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
		         ->where('zone_id', $zone_id)
				 ->where('verification_status', $status);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_region($reportingperiod_id,$region_id,$status) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
		         ->where('region_id', $region_id)
				 ->where('verification_status', $status);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_by_period_district($reportingperiod_id,$district_id,$status) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id)
		         ->where('district_id', $district_id)
				 ->where('verification_status', $status);
		$Q = $this->db->get('alerts');

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
		$this->db->where('reportingperiod_id', $reportingperiod_id);
		$Q = $this->db->get('alerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
	
	function get_list_report($reportingform_id,$healthfacility_id)
	 {
	 	$query = $this->db->query("SELECT t1.*
	 	FROM alerts
	 	WHERE t1.reportingform_id ='".$reportingform_id."' AND t1.healthfacility_id ='".$healthfacility_id."'
	 	ORDER BY t1.id DESC");
		 
		 return $query->result();
	 }
	 
	 function get_by_name_reporting_form($disease_name,$reportingform_id){

		$this->db->where('disease_name', $disease_name)
		         ->where('reportingform_id', $reportingform_id);

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

	// update role by id
	
	function update_by_disease_rept_form($reportingform_id,$disease_name, $role){

		$this->db->where('reportingform_id', $reportingform_id)
				 ->where('disease_name', $disease_name);

		$this->db->update($this->tbl_roles, $role);

	}
	
	function update($id, $role){

		$this->db->where('id', $id);

		$this->db->update($this->tbl_roles, $role);

	}
	
	function delete_by_reportingform_id_disease($reportingform_id,$disease_name){

		$this->db->where('reportingform_id', $reportingform_id)
		         ->where('disease_name', $disease_name);

		$this->db->delete($this->tbl_roles);

	}

	// delete role by id

	function delete($id){

		$this->db->where('id', $id);

		$this->db->delete($this->tbl_roles);

	}
}
