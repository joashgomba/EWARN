<?php

class Healthfacilitiesmodel extends CI_Model {

   private $tbl_roles= 'healthfacilities';
   function __construct()
   {
       parent::__construct();
   }
   
   //get all the roles

	 function get_list() {

		$data = array();

		$Q = $this->db->get('healthfacilities');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}

	function get_active_list()
    {
        $one=false;
        $array='array';

        $this->db->select('t1.*')
            ->from('healthfacilities AS t1')
            ->where('t1.activated = 1')
            ->order_by('t1.health_facility ASC');


        $query = $this->db->get();

        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
    }
	function get_list_by_country($country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS healthfacility_id,t2.*,t3.*,t4.*, t5.*')
          ->from('healthfacilities AS t1, districts AS t2, regions AS t3, zones AS t4, countries AS t5')
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
	
	function get_paged_list($perpage=0,$start=0)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS healthfacility_id,t2.*,t3.*,t4.*, t5.*')
          ->from('healthfacilities AS t1, districts AS t2, regions AS t3, zones AS t4, countries AS t5')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')
		  ->where('t3.zone_id = t4.id')
		  ->where('t4.country_id = t5.id')
		  ->order_by('t5.country_name ASC, t4.zone ASC, t3.region ASC, t2.district ASC, t1.health_facility ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_country_paged_list($perpage=0,$start=0,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS healthfacility_id,t2.*,t3.*,t4.*, t5.*')
          ->from('healthfacilities AS t1, districts AS t2, regions AS t3, zones AS t4, countries AS t5')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')
		  ->where('t3.zone_id = t4.id')
		  ->where('t4.country_id = t5.id')
		  ->where('t5.id',$country_id)
		  ->order_by('t5.country_name ASC, t4.zone ASC, t3.region ASC, t2.district ASC, t1.health_facility ASC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function search_list($health_facility)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS healthfacility_id,t2.*,t3.*,t4.*, t5.*')
          ->from('healthfacilities AS t1, districts AS t2, regions AS t3, zones AS t4, countries AS t5')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')
		  ->where('t3.zone_id = t4.id')
		  ->where('t4.country_id = t5.id')
		  ->like('t1.health_facility', $health_facility, 'both')
		  ->order_by('t5.country_name ASC, t4.zone ASC, t3.region ASC, t2.district ASC, t1.health_facility ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function search_country_list($health_facility,$country_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS healthfacility_id,t2.*,t3.*,t4.*, t5.*')
          ->from('healthfacilities AS t1, districts AS t2, regions AS t3, zones AS t4, countries AS t5')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')
		  ->where('t3.zone_id = t4.id')
		  ->where('t4.country_id = t5.id')
		  ->where('t5.id',$country_id)
		  ->like('t1.health_facility', $health_facility, 'both')
		  ->order_by('t5.country_name ASC, t4.zone ASC, t3.region ASC, t2.district ASC, t1.health_facility ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}

    function get_list_by_admin_regions($country_id,$zone_id,$region_id,$district_id)
    {
        $one=false;
        $array='array';
        $data = array();
        $activated = 1;
        $this->db->select('t1.*, t1.id AS healthfacility_id,t2.*,t3.*,t4.*,t5.*');
        $this->db->from('healthfacilities AS t1,districts AS t2, regions AS t3, zones AS t4, countries AS t5');
        $this->db->where('t1.activated',$activated);
        $this->db->where('t1.district_id = t2.id');
        $this->db->where('t2.region_id = t3.id');
        $this->db->where('t3.zone_id = t4.id');
        $this->db->where('t4.country_id = t5.id');
        if($district_id !=0)
        {
            $this->db->where('t2.id',$district_id);
        }
        if($region_id !=0)
        {
            $this->db->where('t3.id',$region_id);
        }
        if($zone_id !=0)
        {
            $this->db->where('t4.id',$zone_id);
        }

        $this->db->where('t5.id',$country_id);
        $this->db->order_by('zone ASC, health_facility ASC');

        $query = $this->db->get();

        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
    }
	
	function get_list_by_parameters($country_id,$zone_id,$region_id,$district_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS healthfacility_id,t2.*,t3.*,t4.*,t5.*');
          $this->db->from('healthfacilities AS t1,districts AS t2, regions AS t3, zones AS t4, countries AS t5');
		  $this->db->where('t1.district_id = t2.id');
		  $this->db->where('t2.region_id = t3.id');
		  $this->db->where('t3.zone_id = t4.id');
		  $this->db->where('t4.country_id = t5.id');
		  if($district_id !=0)
		  {
		  	$this->db->where('t2.id',$district_id);
		  }
		  if($region_id !=0)
		  {
		  	$this->db->where('t3.id',$region_id);
		  }
		  if($zone_id !=0)
		  {
		  	$this->db->where('t4.id',$zone_id);
		  }
		  
		  $this->db->where('t5.id',$country_id);
		  $this->db->order_by('t5.country_name ASC, zone ASC, region ASC, district ASC');
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_list_by_parameters($perpage=0,$start=0,$country_id,$zone_id,$region_id,$district_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*, t1.id AS healthfacility_id,t2.*,t3.*,t4.*,t5.*');
          $this->db->from('healthfacilities AS t1,districts AS t2, regions AS t3, zones AS t4, countries AS t5');
		  $this->db->where('t1.district_id = t2.id');
		  $this->db->where('t2.region_id = t3.id');
		  $this->db->where('t3.zone_id = t4.id');
		  $this->db->where('t4.country_id = t5.id');
		  if($district_id !=0)
		  {
		  	$this->db->where('t2.id',$district_id);
		  }
		  if($region_id !=0)
		  {
		  	$this->db->where('t3.id',$region_id);
		  }
		  if($zone_id !=0)
		  {
		  	$this->db->where('t4.id',$zone_id);
		  }
		  
		  $this->db->where('t5.id',$country_id);
		  $this->db->order_by('t5.country_name ASC, t4.zone ASC, t3.region ASC, t2.district ASC, t1.health_facility ASC');
		  $this->db->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_approved_hfs()
	{
		$sql = 'SELECT * FROM healthfacilities WHERE activated=1';
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function get_approved_zone_hfs($zone_id)
	{
		$sql = 'SELECT zones.*,regions.*,districts.*,healthfacilities.* 
		FROM zones,regions,districts,healthfacilities 
		WHERE zones.id = regions.zone_id
		AND regions.id = districts.region_id
		AND districts.id = healthfacilities.district_id
		AND healthfacilities.activated=1
		AND zones.id='.$zone_id;
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function get_approved_region_hfs($region_id)
	{
		$sql = 'SELECT zones.*,regions.*,districts.*,healthfacilities.* 
		FROM zones,regions,districts,healthfacilities 
		WHERE zones.id = regions.zone_id
		AND regions.id = districts.region_id
		AND districts.id = healthfacilities.district_id
		AND healthfacilities.activated=1
		AND regions.id='.$region_id;
		$query = $this->db->query($sql);
		
		return $query->result();
	}
	
	function get_by_all_locations($zone_id, $region_id, $district_id)
	{
		$sql ='SELECT t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*
		FROM healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4
		WHERE t1.district_id = t2.id
		AND t2.region_id = t3.id
		AND t3.zone_id = t4.id';
		
		if ($zone_id != 0) {
            $sql .= ' AND t4.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t2.id='.$district_id;
        }
        		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_by_all_locations_approved_hf($zone_id, $region_id, $district_id,$healthfacility_id)
	{
		$sql ='SELECT t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*
		FROM healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4
		WHERE t1.district_id = t2.id
		AND t1.activated=1
		AND t2.region_id = t3.id
		AND t3.zone_id = t4.id';
		
		if ($healthfacility_id != 0) {
            $sql .= ' AND t1.id='.$healthfacility_id;
        }
		
		if ($zone_id != 0) {
            $sql .= ' AND t4.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t2.id='.$district_id;
        }
		
		$sql .= ' ORDER BY t1.health_facility ASC';
        		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_by_all_locations_approved($zone_id, $region_id, $district_id)
	{
		$sql ='SELECT t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*
		FROM healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4
		WHERE t1.district_id = t2.id
		AND t1.activated=1
		AND t2.region_id = t3.id
		AND t3.zone_id = t4.id';
		
		if ($zone_id != 0) {
            $sql .= ' AND t4.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t2.id='.$district_id;
        }
		
		$sql .= ' ORDER BY t1.health_facility ASC';
        		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_combined_list()
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*,t5.*')
          ->from('healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4, countries AS t5')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')
		  ->where('t3.zone_id = t4.id')
		  ->where('t4.country_id = t5.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 function get_by_zone($zone_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*')
          ->from('healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')		  
		  ->where('t3.zone_id = t4.id')
		  ->where('t4.id',$zone_id)
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 function get_by_report_region($region_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*')
          ->from('healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4')
		  ->where('t1.district_id = t2.id')
		  ->where('t1.activated = 1')
		  ->where('t2.region_id = t3.id')
		  ->where('t3.id',$region_id)
		  ->where('t3.zone_id = t4.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	  function get_by_report_district($district_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*')
          ->from('healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4')
		  ->where('t1.district_id = t2.id')
		  ->where('t1.activated = 1')
		  ->where('t2.region_id = t3.id')
		  ->where('t2.id',$district_id)
		  ->where('t3.zone_id = t4.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 function get_by_region($region_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*')
          ->from('healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')
		  ->where('t3.id',$region_id)
		  ->where('t3.zone_id = t4.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }
	 
	 
	 function get_by_district_list($district_id)
	 {
	 	$array='array';
		$data = array();
		$this->db->select('t1.*,t1.id AS healthfacility_id, t2.*,t3.*,t4.*')
          ->from('healthfacilities AS t1, districts AS t2,regions AS t3,zones AS t4')
		  ->where('t1.district_id = t2.id')
		  ->where('t2.region_id = t3.id')
		  ->where('t2.id',$district_id)
		  ->where('t3.zone_id = t4.id')
		  ->order_by('t1.id DESC');
		  
		return $this->db->get();
	 }

	 function get_by_district($district_id) {

		$data = array();
		$this->db->where('district_id', $district_id);
		$Q = $this->db->get('healthfacilities');

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

	
	function get_by_hfcode($hf_code){

		$this->db->where('hf_code', $hf_code);

		return $this->db->get($this->tbl_roles);

	}
	
	function get_by_name($health_facility){

		$this->db->where('health_facility', $health_facility);

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
