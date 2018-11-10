<?php

class Diseaseofinterestmodel extends CI_Model {

	private $tbl_roles= 'diseaseofinterest';
   function __construct()
   {
       parent::__construct();
   }

   public function get_list()
   {
       $data = array();
       $Q = $this->db->get('diseaseofinterest');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
    public function get_country_list($country_id)
   {
       $data = array();
	   $this->db->where('country_id', $country_id);
       $Q = $this->db->get('diseaseofinterest');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   
    public function get_country_disease($country_id,$disease_id)
   {
       $data = array();
	   $this->db->where('country_id', $country_id)
	            ->where('disease_id', $disease_id);
       $Q = $this->db->get('diseaseofinterest');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   public function get_combined_list($country_id)
   {
	   $sql = "SELECT diseaseofinterest.*,diseases.*
	   FROM diseaseofinterest,diseases
	   WHERE diseases.id = diseaseofinterest.disease_id
	   AND diseaseofinterest.country_id=".$country_id;
	   
	   $query = $this->db->query($sql);
        
        return $query->result();
   }
   
   public function get_cases_by_region_disease($region_id, $disease_id, $epicalendar_id)
   {
	   $sql = 'SELECT SUM(formsdata.total_disease) AS disease_total, SUM(formsdata.total_under_five) AS under_five, SUM(formsdata.total_over_five) AS over_five, formsdata.disease_name
	   FROM formsdata
	   WHERE formsdata.region_id = '.$region_id.'
	   AND formsdata.disease_id = '.$disease_id.'
	   AND formsdata.epicalendar_id='.$epicalendar_id.'';
	   
	   $query = $this->db->query($sql);
	   
	   $row = $query->row();
		return $row;
   }
   
   public function get_cases_by_region($from,$to,$disease_id,$regionarray=array())
   {
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,';     
	  	foreach($regionarray as $key=>$region_id):
			
			$sql .= "sum(case when formsdata.disease_id = '".$disease_id."' and formsdata.region_id = ".$region_id." then formsdata.total_disease end) Region_".$region_id.",
  sum(case when formsdata.disease_id = '".$disease_id."' and formsdata.region_id = ".$region_id." then formsdata.total_under_five end) Region_".$region_id."_T_U_F,
  sum(case when formsdata.disease_id = '".$disease_id."' and formsdata.region_id = ".$region_id." then formsdata.total_over_five end) Region_".$region_id."_T_O_F,";
  
  $sql .= "(SELECT region FROM regions
    				  WHERE regions.id = '".$region_id."' AND regions.id = formsdata.region_id) AS the_region, ";
  
		endforeach;
		
						
		$sql .= ' forms.zone_id,forms.region_id
		
		FROM forms, formsdata
		WHERE forms.id = formsdata.form_id
		AND formsdata.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"		
		AND forms.draft !=1
		AND forms.country_id = '.$country_id;
		
		$sql .= ' 
		 GROUP BY formsdata.epicalendar_id 
		ORDER BY formsdata.epicalendar_id ASC';
		
        
     $query = $this->db->query($sql);
        
      return $query->result();
	   
	 
	   
   }
   
   public function delete_by_country($country_id)
   {
       $this->db->where('country_id', $country_id);
       $this->db->delete($this->tbl_roles);
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
