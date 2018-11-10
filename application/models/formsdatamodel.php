<?php

class Formsdatamodel extends CI_Model {

	private $tbl_roles= 'formsdata';
   function __construct()
   {
       parent::__construct();
   }
   

   public function get_list()
   {
       $data = array();
       $Q = $this->db->get('formsdata');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }

    public function get_by_hf($healthfacility_id)
    {
        $data = array();
        $this->db->where('healthfacility_id',$healthfacility_id);
        $Q = $this->db->get('formsdata');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    public function get_by_region($region_id)
    {
        $data = array();
        $this->db->where('region_id',$region_id);
        $Q = $this->db->get('formsdata');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    public function get_by_district($district_id)
    {
        $data = array();
        $this->db->where('district_id',$district_id);
        $Q = $this->db->get('formsdata');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

   public function get_by_form_id($form_id)
   {
       $data = array();
	   $this->db->where('form_id',$form_id);
       $Q = $this->db->get('formsdata');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   function get_zone_consultations($epicalendar_id,$zonesarray=array())
   {
	   if(empty($zonesarray))
		{
			$inarray = 0;
		}
		else
		{
			$inarray = 0;
			foreach($zonesarray as $key=>$zone_id):
			
				$inarray .= ','.$zone_id;
			
			endforeach;
		}
	   
	   $sql = "SELECT SUM( total_consultations ) AS Zone_Consultations, zone_id
		FROM forms
		WHERE epicalendar_id =".$epicalendar_id."
		AND zone_id
		IN ( ".$inarray.")";
		
		$query = $this->db->query($sql);
        
        return $query->result();
		
   }
   
   
   function get_cases_week_zones($epicalendar_id,$zonesarray=array(),$diseasearray=array())
   {
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   $sql = "SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,";
	   
	   foreach($diseasearray as $key=>$diseasecode):
	   
	   $sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",";
	   
	   endforeach;
	   
	   $sql .= "forms.zone_id,forms.region_id,forms.district_id
		FROM forms, formsdata
		WHERE forms.id = formsdata.form_id
		AND formsdata.epicalendar_id =".$epicalendar_id."
		AND forms.draft !=1";
		
		if(empty($zonesarray))
		{
			$inarray = 0;
		}
		else
		{
			$inarray = 0;
			foreach($zonesarray as $key=>$zone_id):
			
				$inarray .= ','.$zone_id;
			
			endforeach;
		}
		
		$sql .= " AND forms.zone_id IN (".$inarray.") 
		GROUP BY formsdata.epicalendar_id, forms.zone_id
		ORDER BY formsdata.epicalendar_id ASC";
		
		$query = $this->db->query($sql);
        
        return $query->result();
   }
   
   
   
   function malaria_week_report_zones($epicalendar_id,$zonesarray=array())
	{
		
		$sql = "SELECT SUM(formsdata.total_disease) AS diease_total, forms.epicalendar_id,forms.zone_id
		FROM forms,formsdata
		WHERE forms.epicalendar_id=".$epicalendar_id."
		AND forms.id = formsdata.form_id
		AND formsdata.disease_name = 'Mal'
		AND forms.draft !=1";
		
		if(empty($zonesarray))
		{
			$inarray = 0;
		}
		else
		{
			$inarray = 0;
			foreach($zonesarray as $key=>$zone_id):
			
				$inarray .= ','.$zone_id;
			
			endforeach;
		}
		
		$sql .= " AND forms.zone_id
		IN (".$inarray.") 
		GROUP BY forms.epicalendar_id, forms.zone_id";
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}

    function disease_interest_epi_numbers($epicalendaridArray = array(),$country_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {

        $sql = 'SELECT forms.week_no,';


        foreach($diseasearray as $key=>$diseasecode):

            $sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",";
        endforeach;

        $sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id';

        if(empty($epicalendaridArray))
        {
            $inarray = 0;
        }
        else
        {
            $inarray = 0;
            foreach($epicalendaridArray as $key=>$epi_id):

                $inarray .= ','.$epi_id;

            endforeach;
        }


        $sql .= " FROM epdcalendar, forms, formsdata";
        $sql .= ' WHERE formsdata.form_id = forms.id
				AND forms.epicalendar_id = epdcalendar.id
				AND forms.draft !=1
				AND epdcalendar.id
		        IN ( '.$inarray.')
				AND forms.country_id = '.$country_id;

        if ($zone_id != 0) {
            $sql .= ' AND forms.zone_id='.$zone_id;
        }

        if ($region_id != 0) {
            $sql .= ' AND forms.region_id='.$region_id;
        }

        if ($district_id != 0) {
            $sql .= ' AND forms.district_id='.$district_id;
        }

        if ($healthfacility_id != 0) {
            $sql .= ' AND forms.healthfacility_id='.$healthfacility_id;
        }

        $sql .= " GROUP BY epdcalendar.id
ORDER BY epdcalendar.from ASC ";

        $query = $this->db->query($sql);

        return $query->result();


    }

   function disease_interest_numbers($epi_id_one,$epi_id_two,$country_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
   {
	  	   
	   $sql = 'SELECT forms.week_no,';
	   
	   
	   foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",";
		endforeach;
		
		$sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id';
		
		$sql .= " FROM epdcalendar, forms, formsdata";
		$sql .= ' WHERE formsdata.form_id = forms.id
				AND forms.epicalendar_id = epdcalendar.id
				AND forms.draft !=1
				AND epdcalendar.id BETWEEN '.$epi_id_one.' AND '.$epi_id_two.'
				AND forms.country_id = '.$country_id;
				
		if ($zone_id != 0) {
            $sql .= ' AND forms.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND forms.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND forms.district_id='.$district_id;
        }
		
		if ($healthfacility_id != 0) {
            $sql .= ' AND forms.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= " GROUP BY epdcalendar.id
ORDER BY epdcalendar.from ASC ";

	  $query = $this->db->query($sql);
        
      return $query->result();
	
	   
   }
   
   
   function disease_interest_epi($epi_id,$country_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasecode)
   {
	   
	   $sql = 'SELECT forms.week_no,';
	   			
		$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) diseaseCode,";
				
		$sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id';
		
		$sql .= " FROM epdcalendar, forms, formsdata";
		$sql .= ' WHERE formsdata.form_id = forms.id
				AND forms.epicalendar_id = epdcalendar.id
				AND forms.draft !=1
				AND epdcalendar.id = '.$epi_id.'
				AND forms.country_id = '.$country_id;
				
		if ($zone_id != 0) {
            $sql .= ' AND forms.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND forms.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND forms.district_id='.$district_id;
        }
		
		if ($healthfacility_id != 0) {
            $sql .= ' AND forms.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= " GROUP BY epdcalendar.id
ORDER BY epdcalendar.from ASC ";

	  $query = $this->db->query($sql);
        
      
	   $row = $query->row();
	   $zero = 0;
	   
	   if(empty($row))
	   {
		   return $zero;
	   }
	   else
	   {
		
	     return $row->diseaseCode;
	   }
	   
	
	   
   }
   
   function age_gender_totals($epicalendar_id,$district_id,$region_id,$zone_id,$healthfacility_id)
   {
	   $sql = "SELECT forms.week_no, (sum(formsdata.male_under_five) + sum(formsdata.male_over_five)) AS total_male,(sum(formsdata.female_under_five) + sum(formsdata.female_over_five)) AS total_female,
sum(formsdata.total_under_five) AS under_five_total,sum(formsdata.total_over_five) AS over_five_total
FROM formsdata, forms
WHERE forms.id = formsdata.form_id
AND forms.draft !=1
AND formsdata.epicalendar_id = ".$epicalendar_id;
	   
	   if ($zone_id != 0) {
            $sql .= ' AND formsdata.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formsdata.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formsdata.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formsdata.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= ' GROUP BY formsdata.epicalendar_id';
		
		$query = $this->db->query($sql);
        
        return $query->result();
   }
   
   function health_facility_average($disease_id,$healthfacility_id,$weeks)
   {
		 $sql = ' SELECT AVG( a.total_disease ) AS the_average
				FROM (
				
				SELECT total_disease
				FROM formsdata
				WHERE disease_id = '.$disease_id.'
				AND healthfacility_id = '.$healthfacility_id.'
				ORDER BY id DESC 
				LIMIT '.$weeks.'
				)a';

		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		return $row->the_average;
	 }
	 
	 
	function get_by_disease_period_locations($epicalendar_id,$disease_name,$district_id, $region_id, $zone_id)
	 {
		 $sql = 'SELECT SUM(total_disease) AS disease_total
		FROM formsdata
		WHERE disease_name = "'.$disease_name.'"
		AND epicalendar_id = '.$epicalendar_id.' ';
		
		if ($zone_id != 0) {
            $sql .= 'AND zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND district_id='.$district_id;
        }
		
		$sql .= ' GROUP BY epicalendar_id';

		$query = $this->db->query($sql);
		$row = $query->row();
		
		if(empty($row->disease_total))
		{
			$zero = 0;
			return $zero;
		}
		else
		{
			return $row->disease_total;
		}
	 }
	
    function sum_by_under_five($epicalendar_id,$disease_name,$district_id, $region_id, $zone_id)
    {
        
        $sql = 'SELECT (SUM( male_under_five ) + SUM(female_under_five)) AS disease_total
		FROM formsdata
		WHERE disease_name = "'.$disease_name.'"
		AND epicalendar_id = '.$epicalendar_id.' ';
		
		if ($zone_id != 0) {
            $sql .= 'AND zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND district_id='.$district_id;
        }
		
		$sql .= ' GROUP BY epicalendar_id';

		$query = $this->db->query($sql);
		$row = $query->row();
		
		if(empty($row->disease_total))
		{
			$zero = 0;
			return $zero;
		}
		else
		{
			return $row->disease_total;
		}
        
    } 
	
	function sum_by_over_five($epicalendar_id,$disease_name,$district_id, $region_id, $zone_id)
    {
        
        $sql = 'SELECT (SUM( male_over_five ) + SUM(female_over_five)) AS disease_total
		FROM formsdata
		WHERE disease_name = "'.$disease_name.'"
		AND epicalendar_id = '.$epicalendar_id.' ';
		
		if ($zone_id != 0) {
            $sql .= 'AND zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND district_id='.$district_id;
        }
		
		$sql .= ' GROUP BY epicalendar_id';

		$query = $this->db->query($sql);
		$row = $query->row();
		
		if(empty($row->disease_total))
		{
			$zero = 0;
			return $zero;
		}
		else
		{
			return $row->disease_total;
		}
        
    } 
	
	function cummulative_interest_figures($from,$to,$country_id,$diseasecode)
	{
		
		$sql = "SELECT SUM( total_disease ) AS cummulative_total
		FROM formsdata
		WHERE epicalendar_id
		BETWEEN ".$from." 
		AND ".$to."  
		AND disease_name = '".$diseasecode."'
		AND country_id =".$country_id;
		
		$query = $this->db->query($sql);
		$row = $query->row();
		
		if(empty($row->cummulative_total))
		{
			$zero = 0;
			return $zero;
		}
		else
		{
			return $row->cummulative_total;
		}
	}
	
	function cummulative_figures($from,$to,$country_id)
	{
		$sql = "SELECT SUM( total_disease ) AS cummulative_total
		FROM formsdata
		WHERE epicalendar_id
		BETWEEN ".$from." 
		AND ".$to."  
		AND country_id =".$country_id;
		
		$query = $this->db->query($sql);
		$row = $query->row();
		
		if(empty($row->cummulative_total))
		{
			$zero = 0;
			return $zero;
		}
		else
		{
			return $row->cummulative_total;
		}
	}
	function get_full_list($form_id,$limit)
	{
		$sql = 'SELECT * 
		FROM formsdata
		JOIN forms ON formsdata.form_id = forms.id
		WHERE form_id ='.$form_id.'
		LIMIT '.$limit;
		
		$query = $this->db->query($sql);
        
       return $query->result();
	}
	
	 function get_by_form_healthfacility_disease_limit($form_id, $healthfacility_id,$disease_id,$limit)
    {
        
        $this->db->where('form_id', $form_id)->where('healthfacility_id', $healthfacility_id)->where('disease_id', $disease_id)->limit($limit);
        
        return $this->db->get($this->tbl_roles);
		/**
		$sql = 'SELECT id, form_id, healthfacility_id, disease_id, male_under_five, female_under_five, male_over_five, female_over_five, total_under_five, total_over_five,total_disease
		FROM formsdata
		WHERE form_id='.$form_id.' AND healthfacility_id = '.$healthfacility_id.' AND disease_id='.$disease_id.'
		LIMIT 1';
		
		$query = $this->db->query($sql);
		
		return $query;
		
		**/
        
    }
   	 
   function get_by_form_healthfacility_disease($form_id, $healthfacility_id,$disease_id)
    {
        
        $this->db->where('form_id', $form_id)->where('healthfacility_id', $healthfacility_id)->where('disease_id', $disease_id)->limit(1);
        
        return $this->db->get($this->tbl_roles);
        
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
