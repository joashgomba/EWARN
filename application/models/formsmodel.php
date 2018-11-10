<?php

class Formsmodel extends CI_Model {

	private $tbl_roles= 'forms';
   function __construct()
   {
       parent::__construct();
   }

   public function get_list()
   {
       $data = array();
       $Q = $this->db->get('forms');
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
        $Q = $this->db->get('forms');
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
        $Q = $this->db->get('forms');
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
        $Q = $this->db->get('forms');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }


   
   function get_cases_week_zones($epicalendar_id,$zonesarray=array())
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
		
	   $sql = "SELECT forms.week_no, SUM(formsdata.total_disease) AS sum_cases,
		formsdata.zone_id FROM formsdata,forms
		WHERE forms.draft !=1 
		AND forms.id = formsdata.form_id
		AND forms.epicalendar_id = ".$epicalendar_id." 
		AND forms.zone_id IN (".$inarray.") 
		GROUP BY forms.epicalendar_id, forms.zone_id 
		ORDER BY forms.epicalendar_id ASC";
		
		$query = $this->db->query($sql);
        
        return $query->result();
   }
   
   
   function get_consultations_week_zone($epicalendar_id,$zonesarray=array())
   {
	  $sql = 'SELECT forms.week_no, SUM(forms.total_consultations) AS sum_consultations,forms.zone_id
FROM forms
WHERE forms.draft !=1
AND forms.epicalendar_id = '.$epicalendar_id;

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
		GROUP BY forms.epicalendar_id, forms.zone_id
		ORDER BY forms.epicalendar_id ASC"; 
		
		$query = $this->db->query($sql);
        
        return $query->result();
   }
   
   
   function getconsultations($epicalendar_id, $district_id, $region_id, $zone_id, $healthfacility_id)
   {
	   $sql = 'SELECT forms.week_no, SUM(forms.total_consultations) AS sum_consultations
FROM forms
WHERE forms.draft !=1
AND forms.epicalendar_id = '.$epicalendar_id;

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
		
		$sql .= ' 
		GROUP BY forms.epicalendar_id ';
		
		$query = $this->db->query($sql);
        
       		
		$row = $query->row();
		
		if(empty($row))
		{
			$empty_row = 0;
			
			return $empty_row;
		}
		else
		{
			return $row->sum_consultations;
		}
	
	
		
   }
   
   function getreportingsites($epicalendar_id, $district_id, $region_id, $zone_id, $healthfacility_id)
   {
	   $sql = 'SELECT COUNT( * ) AS reporting_sites
FROM forms
WHERE forms.draft !=1
AND forms.epicalendar_id = '.$epicalendar_id;

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
		
		$sql .= ' 
		GROUP BY forms.epicalendar_id ';
		
		$query = $this->db->query($sql);
        
       		
		$row = $query->row();
		
		if(empty($row))
		{
			$empty_row = 0;
			
			return $empty_row;
		}
		else
		{
			return $row->reporting_sites;
		}
	
	
		
   }

    function gettimelyreportingsites($epicalendar_id, $district_id, $region_id, $zone_id, $healthfacility_id)
    {
        $sql = 'SELECT COUNT( * ) AS reporting_sites
FROM forms
WHERE forms.draft !=1
AND forms.timely = 1
AND forms.epicalendar_id = '.$epicalendar_id;

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

        $sql .= ' 
		GROUP BY forms.epicalendar_id ';

        $query = $this->db->query($sql);


        $row = $query->row();

        if(empty($row))
        {
            $empty_row = 0;

            return $empty_row;
        }
        else
        {
            return $row->reporting_sites;
        }



    }
   
   function getforms()
   {
	    $sql = 'SELECT * FROM forms WHERE id > 25657';
	   
	   $query = $this->db->query($sql);
        
       return $query->result();
   }
   
   function getalerts($reportingform_id)
   {
	   $sql = 'SELECT * 
		FROM  `formalerts` 
		WHERE disease_id =0
		AND reportingform_id = '.$reportingform_id;
		
		$CI = &get_instance();
	   $this->db2 = $CI->load->database('db2', TRUE);


	   $query = $this->db2->query($sql);
        
       return $query->result();
   }
   
   function get_cases_period($epicalendar_id)
   {
	  $sql = "SELECT forms.reporting_year, forms.week_no,diseases.disease_code,zones.zone,regions.region,districts.district,healthfacilities.health_facility,formsdata.form_id,
	SUM(formsdata.total_disease) AS disease_sum
	FROM forms,zones,regions,districts,healthfacilities,formsdata,diseases
	WHERE forms.zone_id = zones.id
	AND forms.region_id = regions.id
	AND forms.district_id = districts.id
	AND forms.healthfacility_id = healthfacilities.id
	AND formsdata.form_id = forms.id
	AND diseases.id = formsdata.disease_id
	AND formsdata.total_disease
	AND forms.epicalendar_id = ".$epicalendar_id."
	GROUP BY diseases.id,forms.id,forms.epicalendar_id";  
	
	$query = $this->db->query($sql);
        
     return $query->result(); 
   }
   
   
   function get_case_list_by_period($epicalendar_id,$diseasearray=array())
   {
	   $country_id = $this->erkanaauth->getField('country_id');
	   $sql = "SELECT forms.week_no,forms.reporting_year,";
	   foreach($diseasearray as $key=>$diseasecode):
	   
	   $sql .= "SUM(CASE WHEN formsdata.disease_name = '".$diseasecode."' AND formsdata.country_id = ".$country_id." THEN formsdata.total_disease end) ".$diseasecode.",";
	   
	   endforeach;
	   
	   $sql .= "zones.zone,regions.region,districts.district,healthfacilities.health_facility,formsdata.form_id
		FROM forms,zones,regions,districts,healthfacilities,formsdata
		WHERE forms.zone_id = zones.id
		AND forms.country_id = ".$country_id."
		AND forms.region_id = regions.id
		AND forms.district_id = districts.id
		AND forms.healthfacility_id = healthfacilities.id
		AND formsdata.form_id = forms.id
		AND forms.epicalendar_id = ".$epicalendar_id."
		GROUP BY forms.epicalendar_id";
		
		$query = $this->db->query($sql);
        
        return $query->result();
		
	   
   }
   
   
   function generatealerts()
   {
	   $sql = 'SELECT * FROM formsdata WHERE id > 358780';
	   
	   $query = $this->db->query($sql);
        
       return $query->result();
   }
   
   
   function export_merge()
   {
	   $sql = "SELECT forms.*,formsdata.id AS formdata_id, users.username, healthfacilities.health_facility,sum(case when formsdata.disease_name = 'SARI' then formsdata.total_disease end) SARI, sum(case when formsdata.disease_name = 'SARI' then formsdata.total_disease end) SARI, sum(case when formsdata.disease_name = 'SARI' then formsdata.male_under_five end) SARI_M_U_F, sum(case when formsdata.disease_name = 'SARI' then formsdata.female_under_five end) SARI_F_U_F, sum(case when formsdata.disease_name = 'SARI' then formsdata.male_over_five end) SARI_M_O_F, sum(case when formsdata.disease_name = 'SARI' then formsdata.female_over_five end) SARI_F_O_F, sum(case when formsdata.disease_name = 'SARI' then formsdata.total_under_five end) SARI_T_U_F, sum(case when formsdata.disease_name = 'SARI' then formsdata.total_over_five end) SARI_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'SARI' ) AS SARI_ID, sum(case when formsdata.disease_name = 'ILI' then formsdata.total_disease end) ILI, sum(case when formsdata.disease_name = 'ILI' then formsdata.male_under_five end) ILI_M_U_F, sum(case when formsdata.disease_name = 'ILI' then formsdata.female_under_five end) ILI_F_U_F, sum(case when formsdata.disease_name = 'ILI' then formsdata.male_over_five end) ILI_M_O_F, sum(case when formsdata.disease_name = 'ILI' then formsdata.female_over_five end) ILI_F_O_F, sum(case when formsdata.disease_name = 'ILI' then formsdata.total_under_five end) ILI_T_U_F, sum(case when formsdata.disease_name = 'ILI' then formsdata.total_over_five end) ILI_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'ILI' ) AS ILI_ID, sum(case when formsdata.disease_name = 'AWD' then formsdata.total_disease end) AWD, sum(case when formsdata.disease_name = 'AWD' then formsdata.male_under_five end) AWD_M_U_F, sum(case when formsdata.disease_name = 'AWD' then formsdata.female_under_five end) AWD_F_U_F, sum(case when formsdata.disease_name = 'AWD' then formsdata.male_over_five end) AWD_M_O_F, sum(case when formsdata.disease_name = 'AWD' then formsdata.female_over_five end) AWD_F_O_F, sum(case when formsdata.disease_name = 'AWD' then formsdata.total_under_five end) AWD_T_U_F, sum(case when formsdata.disease_name = 'AWD' then formsdata.total_over_five end) AWD_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'AWD' ) AS AWD_ID, sum(case when formsdata.disease_name = 'BD' then formsdata.total_disease end) BD, sum(case when formsdata.disease_name = 'BD' then formsdata.male_under_five end) BD_M_U_F, sum(case when formsdata.disease_name = 'BD' then formsdata.female_under_five end) BD_F_U_F, sum(case when formsdata.disease_name = 'BD' then formsdata.male_over_five end) BD_M_O_F, sum(case when formsdata.disease_name = 'BD' then formsdata.female_over_five end) BD_F_O_F, sum(case when formsdata.disease_name = 'BD' then formsdata.total_under_five end) BD_T_U_F, sum(case when formsdata.disease_name = 'BD' then formsdata.total_over_five end) BD_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'BD' ) AS BD_ID, sum(case when formsdata.disease_name = 'OAD' then formsdata.total_disease end) OAD, sum(case when formsdata.disease_name = 'OAD' then formsdata.male_under_five end) OAD_M_U_F, sum(case when formsdata.disease_name = 'OAD' then formsdata.female_under_five end) OAD_F_U_F, sum(case when formsdata.disease_name = 'OAD' then formsdata.male_over_five end) OAD_M_O_F, sum(case when formsdata.disease_name = 'OAD' then formsdata.female_over_five end) OAD_F_O_F, sum(case when formsdata.disease_name = 'OAD' then formsdata.total_under_five end) OAD_T_U_F, sum(case when formsdata.disease_name = 'OAD' then formsdata.total_over_five end) OAD_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'OAD' ) AS OAD_ID, sum(case when formsdata.disease_name = 'Diph' then formsdata.total_disease end) Diph, sum(case when formsdata.disease_name = 'Diph' then formsdata.male_under_five end) Diph_M_U_F, sum(case when formsdata.disease_name = 'Diph' then formsdata.female_under_five end) Diph_F_U_F, sum(case when formsdata.disease_name = 'Diph' then formsdata.male_over_five end) Diph_M_O_F, sum(case when formsdata.disease_name = 'Diph' then formsdata.female_over_five end) Diph_F_O_F, sum(case when formsdata.disease_name = 'Diph' then formsdata.total_under_five end) Diph_T_U_F, sum(case when formsdata.disease_name = 'Diph' then formsdata.total_over_five end) Diph_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'Diph' ) AS Diph_ID, sum(case when formsdata.disease_name = 'WC' then formsdata.total_disease end) WC, sum(case when formsdata.disease_name = 'WC' then formsdata.male_under_five end) WC_M_U_F, sum(case when formsdata.disease_name = 'WC' then formsdata.female_under_five end) WC_F_U_F, sum(case when formsdata.disease_name = 'WC' then formsdata.male_over_five end) WC_M_O_F, sum(case when formsdata.disease_name = 'WC' then formsdata.female_over_five end) WC_F_O_F, sum(case when formsdata.disease_name = 'WC' then formsdata.total_under_five end) WC_T_U_F, sum(case when formsdata.disease_name = 'WC' then formsdata.total_over_five end) WC_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'WC' ) AS WC_ID, sum(case when formsdata.disease_name = 'Meas' then formsdata.total_disease end) Meas, sum(case when formsdata.disease_name = 'Meas' then formsdata.male_under_five end) Meas_M_U_F, sum(case when formsdata.disease_name = 'Meas' then formsdata.female_under_five end) Meas_F_U_F, sum(case when formsdata.disease_name = 'Meas' then formsdata.male_over_five end) Meas_M_O_F, sum(case when formsdata.disease_name = 'Meas' then formsdata.female_over_five end) Meas_F_O_F, sum(case when formsdata.disease_name = 'Meas' then formsdata.total_under_five end) Meas_T_U_F, sum(case when formsdata.disease_name = 'Meas' then formsdata.total_over_five end) Meas_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'Meas' ) AS Meas_ID, sum(case when formsdata.disease_name = 'NNT' then formsdata.total_disease end) NNT, sum(case when formsdata.disease_name = 'NNT' then formsdata.male_under_five end) NNT_M_U_F, sum(case when formsdata.disease_name = 'NNT' then formsdata.female_under_five end) NNT_F_U_F, sum(case when formsdata.disease_name = 'NNT' then formsdata.male_over_five end) NNT_M_O_F, sum(case when formsdata.disease_name = 'NNT' then formsdata.female_over_five end) NNT_F_O_F, sum(case when formsdata.disease_name = 'NNT' then formsdata.total_under_five end) NNT_T_U_F, sum(case when formsdata.disease_name = 'NNT' then formsdata.total_over_five end) NNT_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'NNT' ) AS NNT_ID, sum(case when formsdata.disease_name = 'AFP' then formsdata.total_disease end) AFP, sum(case when formsdata.disease_name = 'AFP' then formsdata.male_under_five end) AFP_M_U_F, sum(case when formsdata.disease_name = 'AFP' then formsdata.female_under_five end) AFP_F_U_F, sum(case when formsdata.disease_name = 'AFP' then formsdata.male_over_five end) AFP_M_O_F, sum(case when formsdata.disease_name = 'AFP' then formsdata.female_over_five end) AFP_F_O_F, sum(case when formsdata.disease_name = 'AFP' then formsdata.total_under_five end) AFP_T_U_F, sum(case when formsdata.disease_name = 'AFP' then formsdata.total_over_five end) AFP_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'AFP' ) AS AFP_ID, sum(case when formsdata.disease_name = 'AJS' then formsdata.total_disease end) AJS, sum(case when formsdata.disease_name = 'AJS' then formsdata.male_under_five end) AJS_M_U_F, sum(case when formsdata.disease_name = 'AJS' then formsdata.female_under_five end) AJS_F_U_F, sum(case when formsdata.disease_name = 'AJS' then formsdata.male_over_five end) AJS_M_O_F, sum(case when formsdata.disease_name = 'AJS' then formsdata.female_over_five end) AJS_F_O_F, sum(case when formsdata.disease_name = 'AJS' then formsdata.total_under_five end) AJS_T_U_F, sum(case when formsdata.disease_name = 'AJS' then formsdata.total_over_five end) AJS_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'AJS' ) AS AJS_ID, sum(case when formsdata.disease_name = 'VHF' then formsdata.total_disease end) VHF, sum(case when formsdata.disease_name = 'VHF' then formsdata.male_under_five end) VHF_M_U_F, sum(case when formsdata.disease_name = 'VHF' then formsdata.female_under_five end) VHF_F_U_F, sum(case when formsdata.disease_name = 'VHF' then formsdata.male_over_five end) VHF_M_O_F, sum(case when formsdata.disease_name = 'VHF' then formsdata.female_over_five end) VHF_F_O_F, sum(case when formsdata.disease_name = 'VHF' then formsdata.total_under_five end) VHF_T_U_F, sum(case when formsdata.disease_name = 'VHF' then formsdata.total_over_five end) VHF_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'VHF' ) AS VHF_ID, sum(case when formsdata.disease_name = 'Mal' then formsdata.total_disease end) Mal, sum(case when formsdata.disease_name = 'Mal' then formsdata.male_under_five end) Mal_M_U_F, sum(case when formsdata.disease_name = 'Mal' then formsdata.female_under_five end) Mal_F_U_F, sum(case when formsdata.disease_name = 'Mal' then formsdata.male_over_five end) Mal_M_O_F, sum(case when formsdata.disease_name = 'Mal' then formsdata.female_over_five end) Mal_F_O_F, sum(case when formsdata.disease_name = 'Mal' then formsdata.total_under_five end) Mal_T_U_F, sum(case when formsdata.disease_name = 'Mal' then formsdata.total_over_five end) Mal_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'Mal' ) AS Mal_ID, sum(case when formsdata.disease_name = 'Men' then formsdata.total_disease end) Men, sum(case when formsdata.disease_name = 'Men' then formsdata.male_under_five end) Men_M_U_F, sum(case when formsdata.disease_name = 'Men' then formsdata.female_under_five end) Men_F_U_F, sum(case when formsdata.disease_name = 'Men' then formsdata.male_over_five end) Men_M_O_F, sum(case when formsdata.disease_name = 'Men' then formsdata.female_over_five end) Men_F_O_F, sum(case when formsdata.disease_name = 'Men' then formsdata.total_under_five end) Men_T_U_F, sum(case when formsdata.disease_name = 'Men' then formsdata.total_over_five end) Men_T_O_F,(SELECT id FROM diseases WHERE disease_code = 'Men' ) AS Men_ID
FROM forms,formsdata,users,healthfacilities 
WHERE forms.id = formsdata.form_id AND users.id = forms.user_id 
AND forms.healthfacility_id = healthfacilities.id
GROUP BY forms.id ORDER BY forms.epicalendar_id ASC";

 	   $CI = &get_instance();
	   $this->db2 = $CI->load->database('db2', TRUE);


	   $query = $this->db2->query($sql);
        
       return $query->result();
	   
   }
   
   function get_by_facility_category_data($form_id,$diseasecategory_id,$limit)
   {
	   $sql = 'SELECT diseases.id, diseases.country_id, diseases.diseasecategory_id,diseases.disease_code,diseases.disease_name,diseases.case_definition,forms.id,forms.healthfacility_id,formsdata.id,formsdata.form_id,formsdata.healthfacility_id,formsdata.disease_id, formsdata.male_under_five, formsdata.female_under_five, formsdata.male_over_five, formsdata.female_over_five
FROM diseases, forms,formsdata
WHERE formsdata.form_id = forms.id
AND forms.healthfacility_id = formsdata.healthfacility_id
AND diseases.id = formsdata.disease_id
AND forms.id = '.$form_id.'
AND diseases.diseasecategory_id = '.$diseasecategory_id.'
LIMIT '.$limit.'';

	   $query = $this->db->query($sql);
        
       return $query->result();
   }
   
   function get_by_facility_data($form_id,$limit)
   {
	   $sql = 'SELECT diseases.id, diseases.country_id, diseases.disease_code,diseases.disease_name,diseases.case_definition,forms.id,forms.healthfacility_id,formsdata.id,formsdata.form_id,formsdata.healthfacility_id,formsdata.disease_id, formsdata.male_under_five, formsdata.female_under_five, formsdata.male_over_five, formsdata.female_over_five
FROM diseases, forms,formsdata
WHERE formsdata.form_id = forms.id
AND forms.healthfacility_id = formsdata.healthfacility_id
AND diseases.id = formsdata.disease_id
AND forms.id = '.$form_id.'
LIMIT '.$limit.'';

	   $query = $this->db->query($sql);
        
       return $query->result();
   }
   
   
   function get_full_list_level($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$level)
    {
        $sql = 'SELECT t1.*
		FROM forms AS t1
		WHERE t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'" ';
        
        if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.week_no>="'.$from.'" AND t1.week_no <="'.$to.'"
			AND t1.draft !=1 ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND t1.week_no>="'.$from.'" AND t1.week_no <="'.$to.'"
					AND t1.draft !=1 ';
                } else {
                    $sql .= ' AND t1.draft !=1 ';
                }
            }
            
        }
		/**
		if($level==4)//national
		{
			$sql .= ' AND approved_zone=1';
		}
		
		if($level==1)//zonal
		{
			$sql .= ' AND approved_region=1';
		}
		
		if($level==2)//Regional
		{
			$sql .= ' AND approved_dist=1';
		}
		
		if($level==6)//District
		{
			$sql .= ' AND approved_dist=0';
		}
		
		**/
               
        $sql .= ' ORDER BY t1.id DESC';
		
        
        $query = $this->db->query($sql);
        
       return $query->result();
	   
        
    }
	
	function malaria_week_report_zones($epicalendar_id,$zonesarray=array())
	{
		
		$sql = "SELECT SUM( t1.pv ) AS totpv, SUM( t1.sre ) AS totsre, SUM( t1.pf ) AS totpf, SUM( t1.pmix ) AS totpmix, (
		SUM( t1.pv ) + SUM( t1.pf ) + SUM( t1.pmix )
		) AS slides_tested, SUM( t1.total_positive ) AS positive_slides, t1.zone_id
		FROM forms AS t1
		WHERE t1.epicalendar_id =".$epicalendar_id."
		AND t1.draft !=1";
		
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
		
		$sql .= " AND t1.zone_id
		IN (".$inarray.") 
		GROUP BY t1.epicalendar_id, t1.zone_id";
		
		$query = $this->db->query($sql);
        
        return $query->result();
		
	}
	
	function malaria_week_report($epicalendar_id, $district_id, $region_id, $zone_id)
	{
		$sql = 'SELECT SUM( t1.pv ) AS totpv, SUM( t1.sre ) AS totsre, SUM( t1.pf ) AS totpf, SUM( t1.pmix ) AS totpmix, (SUM( t1.pv )+SUM( t1.pf ) + SUM( t1.pmix )) AS slides_tested, SUM(t1.total_positive) AS positive_slides
		FROM forms AS t1
		WHERE t1.epicalendar_id = '.$epicalendar_id.'
		AND t1.draft !=1';
		
		if ($zone_id != 0) {
            $sql .= ' AND t1.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t1.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t1.district_id='.$district_id;
        }
        
        	
		$sql .= ' GROUP BY t1.epicalendar_id';
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function malariadata($from, $to, $district_id, $region_id, $zone_id)
	{
		
		$sql = "SELECT forms.week_no,forms.reporting_year,SUM(total_under_five) AS disease_under_five, SUM(total_over_five) AS disease_over_five,SUM(total_disease) AS disease_total
		FROM formsdata,forms
		WHERE forms.epicalendar_id BETWEEN ".$from." AND ".$to."
		AND forms.draft !=1
		AND formsdata.disease_name = 'Mal'
		AND forms.id = formsdata.form_id";
		
		if ($zone_id != 0) {
            $sql .= 'AND forms.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND forms.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND forms.district_id='.$district_id;
        }
		
		$sql .= " GROUP BY forms.epicalendar_id
		ORDER BY forms.epicalendar_id ASC";
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}

    function malaria_report($epicalendaridArray=array(), $district_id, $region_id, $zone_id)
    {
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

        $sql = 'SELECT SUM( t1.pv ) AS totpv, SUM( t1.sre ) AS totsre, SUM( t1.pf ) AS totpf, SUM( t1.pmix ) AS totpmix, t2.id, t2.epdyear, t2.week_no
		FROM forms AS t1, epdcalendar AS t2
		WHERE t1.epicalendar_id IN ( '.$inarray.')
		AND t1.epicalendar_id = t2.id
		AND t1.draft !=1 ';

        if ($zone_id != 0) {
            $sql .= 'AND t1.zone_id='.$zone_id;
        }

        if ($region_id != 0) {
            $sql .= ' AND t1.region_id='.$region_id;
        }

        if ($district_id != 0) {
            $sql .= ' AND t1.district_id='.$district_id;
        }


        $sql .= ' GROUP BY t1.epicalendar_id
		ORDER BY t2.id ASC ';

        $query = $this->db->query($sql);

        return $query->result();
    }
	
	function malariareport($from, $to, $district_id, $region_id, $zone_id)
	{
		$sql = 'SELECT SUM( t1.pv ) AS totpv, SUM( t1.sre ) AS totsre, SUM( t1.pf ) AS totpf, SUM( t1.pmix ) AS totpmix, t2.id, t2.epdyear, t2.week_no
		FROM forms AS t1, epdcalendar AS t2
		WHERE t1.epicalendar_id
		BETWEEN "'.$from.'" AND "'.$to.'"
		AND t1.epicalendar_id = t2.id
		AND t1.draft !=1 ';
		
		if ($zone_id != 0) {
            $sql .= 'AND t1.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t1.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t1.district_id='.$district_id;
        }
        
        	
		$sql .= ' GROUP BY t1.epicalendar_id
		ORDER BY t2.id ASC ';
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_diseases_average($start_date,$end_date,$country_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
	{
				
		$sql = "SELECT forms.week_no, ";
		
		foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "SUM(CASE WHEN formsdata.disease_name =  '".$diseasecode."' AND formsdata.country_id = ".$country_id."
THEN formsdata.total_disease
END ) / SUM( formsdata.total_disease )*100 AS ".$diseasecode."_average,sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",(SELECT disease_code
FROM diseases
WHERE disease_code =  '".$diseasecode."'
AND diseases.country_id = ".$country_id."
) AS ".$diseasecode."_ID,";
  
 	endforeach;
	
		$sql .= " forms.reporting_year ";
		
		$sql .= 'FROM epdcalendar, forms, formsdata
		WHERE formsdata.form_id = forms.id
		AND forms.epicalendar_id = epdcalendar.id
		AND forms.draft !=1
		AND epdcalendar.from >=  "'.$start_date.'"
		AND  epdcalendar.to <=  "'.$end_date.'"
		AND forms.country_id = '.$country_id.'
		AND epdcalendar.country_id='.$country_id;
		
		 if ($zone_id != 0) {
            $sql .= ' AND forms.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND forms.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND forms.district_id='.$district_id;
        }
		
		$sql .= " GROUP BY epdcalendar.id
ORDER BY epdcalendar.from ASC ";

	  $query = $this->db->query($sql);
        
      return $query->result();
	}
	
	function get_diseases_average_week($epicalendar_id,$country_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
	{
		$sql = "SELECT forms.week_no, ";
		
		foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "SUM(CASE WHEN formsdata.disease_name =  '".$diseasecode."' AND formsdata.country_id = ".$country_id."
THEN formsdata.total_disease
END ) / SUM( formsdata.total_disease )*100 AS ".$diseasecode."_average,sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",(SELECT disease_code
FROM diseases
WHERE disease_code =  '".$diseasecode."'
AND diseases.country_id = ".$country_id."
) AS ".$diseasecode."_ID,";
  
 	endforeach;
	
		$sql .= " forms.reporting_year ";
		
		$sql .= 'FROM epdcalendar, forms, formsdata
		WHERE formsdata.form_id = forms.id
		AND forms.epicalendar_id = epdcalendar.id
		AND forms.draft !=1
		AND epdcalendar.id =  '.$epicalendar_id.'
		AND forms.country_id = '.$country_id.'
		AND epdcalendar.country_id='.$country_id;
		
		 if ($zone_id != 0) {
            $sql .= ' AND forms.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND forms.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND forms.district_id='.$district_id;
        }
		
		$sql .= " GROUP BY epdcalendar.id
ORDER BY epdcalendar.from ASC ";

	  $query = $this->db->query($sql);
        
      return $query->result();
	}
	
	function getdiseasesum($epicalendar_id, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasecode)
	{
		$country_id = $this->erkanaauth->getField('country_id');
		$sql = "SELECT  forms.week_no,sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end)/SUM(formsdata.total_disease)*100 AS average
FROM forms, formsdata
WHERE formsdata.form_id = forms.id
AND forms.country_id = ".$country_id."
AND forms.draft !=1
AND forms.epicalendar_id = ".$epicalendar_id;

       if ($zone_id != 0) {
            $sql .= ' AND forms.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND forms.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND forms.district_id='.$district_id;
        }

	$sql .=" GROUP BY forms.epicalendar_id";
	
	$query = $this->db->query($sql);
        
       		
		$row = $query->row();
		return $row;




    }


    function get_full_list_array($reporting_year, $reporting_year2, $epicalendaridArray=array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
        $country_id = $this->erkanaauth->getField('country_id');
        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year, forms.epicalendar_id, forms.user_id, forms.sre, forms.pf, forms.pv, forms.pmix, forms.total_consultations,forms.undismale,forms.undisfemale,forms.undismaletwo,forms.undisfemaletwo,forms.ocmale,forms.ocfemale, forms.approved_dist,forms.approved_region,forms.approved_zone,forms.approved_national,forms.draft,formsdata.form_id, users.username, users.contact_number, healthfacilities.health_facility,';
        foreach($diseasearray as $key=>$diseasecode):

            $sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";

        endforeach;

        foreach($diseasearray as $key=>$diseasecode):

            $sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE formalerts.disease_name = '".$diseasecode."' AND formalerts.country_id = ".$country_id." AND forms.id = formalerts.reportingform_id) AS ".$diseasecode."_total_alerts, ";
        endforeach;

        $sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE disease_name = 'UnDis' AND forms.id = formalerts.reportingform_id) AS UnDis_total_alerts, ";

        $sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE disease_name = 'Pf' AND forms.id = formalerts.reportingform_id) AS Pf_total_alerts, ";

        $sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE disease_name = 'SRE' AND forms.id = formalerts.reportingform_id) AS SRE_total_alerts, ";

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

        $sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms,formsdata,users,healthfacilities
		WHERE forms.epicalendar_id IN ( '.$inarray.')
		AND forms.country_id = '.$country_id.'
		AND forms.id = formsdata.form_id
		AND users.id = forms.user_id
		AND forms.healthfacility_id = healthfacilities.id
		AND forms.draft !=1
		';

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

        $sql .= ' 
		GROUP BY forms.id 
		ORDER BY forms.epicalendar_id DESC';


        $query = $this->db->query($sql);

        return $query->result();



    }
	
	function get_full_list($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
		$country_id = $this->erkanaauth->getField('country_id');
		$sql = 'SELECT forms.id, forms.week_no, forms.reporting_year, forms.epicalendar_id, forms.user_id, forms.sre, forms.pf, forms.pv, forms.pmix, forms.total_consultations,forms.undismale,forms.undisfemale,forms.undismaletwo,forms.undisfemaletwo,forms.ocmale,forms.ocfemale, forms.approved_dist,forms.approved_region,forms.approved_zone,forms.approved_national,forms.draft,formsdata.form_id, users.username, users.contact_number, healthfacilities.health_facility,';     
	  	foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";
  
 	endforeach;
		
		foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE formalerts.disease_name = '".$diseasecode."' AND formalerts.country_id = ".$country_id." AND forms.id = formalerts.reportingform_id) AS ".$diseasecode."_total_alerts, ";
		endforeach;
		
		$sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE disease_name = 'UnDis' AND forms.id = formalerts.reportingform_id) AS UnDis_total_alerts, ";
					  
		$sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE disease_name = 'Pf' AND forms.id = formalerts.reportingform_id) AS Pf_total_alerts, ";
		
		$sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE disease_name = 'SRE' AND forms.id = formalerts.reportingform_id) AS SRE_total_alerts, ";
		
		$sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms,formsdata,users,healthfacilities
		WHERE forms.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
		AND forms.country_id = '.$country_id.'
		AND forms.id = formsdata.form_id
		AND users.id = forms.user_id
		AND forms.healthfacility_id = healthfacilities.id
		AND forms.draft !=1
		';
		
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
		
		$sql .= ' 
		GROUP BY forms.id 
		ORDER BY forms.epicalendar_id DESC';
		
        
       $query = $this->db->query($sql);
        
      return $query->result();
	  
	   
	      
    }

    function get_full_export_epi_list($reporting_year, $reporting_year2, $epicalendaridArray=array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
        $country_id = $this->erkanaauth->getField('country_id');
        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year, forms.epicalendar_id, forms.user_id, forms.sre, forms.pf, forms.pv, forms.pmix, forms.total_consultations,forms.undismale,forms.undisfemale,forms.undismaletwo,forms.undisfemaletwo,forms.ocmale,forms.ocfemale, forms.approved_dist,forms.approved_region,forms.approved_zone,forms.approved_national,forms.draft,forms.undisonedesc,forms.undissecdesc,forms.entry_date,forms.entry_time,forms.edit_date,forms.edit_time,formsdata.form_id, users.username, users.contact_number, healthfacilities.health_facility,healthfacilities.health_facility_type,healthfacilities.hf_code,';
        foreach($diseasearray as $key=>$diseasecode):

            $sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";
        endforeach;

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


        $sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms,formsdata,users,healthfacilities
		WHERE forms.epicalendar_id IN ( '.$inarray.')
		AND forms.id = formsdata.form_id
		AND forms.country_id = '.$country_id.'
		AND users.id = forms.user_id
		AND forms.healthfacility_id = healthfacilities.id
		AND forms.draft !=1
		';

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

        $sql .= ' 
		GROUP BY forms.id 
		ORDER BY forms.epicalendar_id DESC';


        $query = $this->db->query($sql);

        return $query->result();


    }
	
	
	function get_full_export_list($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
		$country_id = $this->erkanaauth->getField('country_id');
		$sql = 'SELECT forms.id, forms.week_no, forms.reporting_year, forms.epicalendar_id, forms.user_id, forms.sre, forms.pf, forms.pv, forms.pmix, forms.total_consultations,forms.undismale,forms.undisfemale,forms.undismaletwo,forms.undisfemaletwo,forms.ocmale,forms.ocfemale, forms.approved_dist,forms.approved_region,forms.approved_zone,forms.approved_national,forms.draft,forms.undisonedesc,forms.undissecdesc,forms.entry_date,forms.entry_time,forms.edit_date,forms.edit_time,formsdata.form_id, users.username, users.contact_number, healthfacilities.health_facility,healthfacilities.health_facility_type,healthfacilities.hf_code,';     
	  	foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";
		endforeach;
		
			
		$sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms,formsdata,users,healthfacilities
		WHERE forms.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
		AND forms.id = formsdata.form_id
		AND forms.country_id = '.$country_id.'
		AND users.id = forms.user_id
		AND forms.healthfacility_id = healthfacilities.id
		AND forms.draft !=1
		';
		
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
		
		$sql .= ' 
		GROUP BY forms.id 
		ORDER BY forms.epicalendar_id DESC';
		
        
       $query = $this->db->query($sql);
        
       return $query->result();
	   
	   
	   
        
    }
	
	
	function get_full_list_old($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
		
		$sql = 'SELECT forms.id, forms.week_no, forms.reporting_year, forms.epicalendar_id, forms.user_id, forms.sre, forms.pf, forms.pv, forms.pmix, forms.total_consultations,forms.undismale,forms.undisfemale,forms.undismaletwo,forms.undisfemaletwo,forms.ocmale,forms.ocfemale, forms.approved_dist,forms.approved_region,forms.approved_zone,forms.approved_national,forms.draft,formsdata.form_id, users.username, users.contact_number, healthfacilities.health_facility,';     
	  	foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";
		endforeach;
		
		$sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms,formsdata,users,healthfacilities
		WHERE forms.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
		AND forms.id = formsdata.form_id
		AND users.id = forms.user_id
		AND forms.healthfacility_id = healthfacilities.id
		AND forms.draft !=1
		';
		
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
		
		$sql .= ' 
		GROUP BY forms.id 
		ORDER BY forms.epicalendar_id DESC';
		
        
        $query = $this->db->query($sql);
        
       return $query->result();
	   
        
    }
	
	
	function get_full_list_export_test($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id)
    {
        $sql = 'SELECT t1.*
		FROM forms AS t1
		WHERE t1.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
		AND t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'"
		AND t1.draft !=1
		';
		
		if ($zone_id != 0) {
            $sql .= 'AND t1.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t1.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t1.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND t1.healthfacility_id='.$healthfacility_id;
        }
        
        		               
        $sql .= ' ORDER BY t1.epicalendar_id DESC';
		
        
        //$query = $this->db->query($sql);
        
       return $sql;
	   
        
    }

    function get_full_list_epi_export($reporting_year, $reporting_year2, $epicalendaridArray=array(), $district_id, $region_id, $zone_id, $healthfacility_id)
    {

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

        $sql = 'SELECT t1.*
		FROM forms AS t1
		WHERE t1.epicalendar_id IN ( '.$inarray.')
		AND t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'"
		AND t1.draft !=1
		';

        if ($zone_id != 0) {
            $sql .= 'AND t1.zone_id='.$zone_id;
        }

        if ($region_id != 0) {
            $sql .= ' AND t1.region_id='.$region_id;
        }

        if ($district_id != 0) {
            $sql .= ' AND t1.district_id='.$district_id;
        }

        if ($healthfacility_id != 0) {
            $sql .= ' AND t1.healthfacility_id='.$healthfacility_id;
        }


        $sql .= ' ORDER BY t1.epicalendar_id DESC';


        $query = $this->db->query($sql);

        return $query->result();


    }
	
	function get_full_list_export($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id)
    {
        $sql = 'SELECT t1.*
		FROM forms AS t1
		WHERE t1.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
		AND t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'"
		AND t1.draft !=1
		';
		
		if ($zone_id != 0) {
            $sql .= 'AND t1.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t1.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t1.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND t1.healthfacility_id='.$healthfacility_id;
        }
        
        		               
        $sql .= ' ORDER BY t1.epicalendar_id DESC';
		
        
        $query = $this->db->query($sql);
        
       return $query->result();
	   
        
    }


    public function zone_disease_week($epicalendar_id,$zonearray=array(),$diseasearray=array())
    {
        $country_id = $this->erkanaauth->getField('country_id');

        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,zones.zone, ';
        foreach($diseasearray as $key=>$diseasecode):

            $sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";

        endforeach;


        $sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formsdata, zones
		WHERE forms.id = formsdata.form_id
		AND formsdata.epicalendar_id = '.$epicalendar_id.'
		AND zones.id = forms.zone_id		
		AND forms.draft !=1
		AND forms.country_id = '.$country_id;

        if(empty($zonearray))
        {
            $inarray = 0;
        }
        else
        {
            $inarray = 0;
            foreach($zonearray as $key=>$zone_id):

                $inarray .= ','.$zone_id;

            endforeach;
        }

        $sql .= " AND forms.zone_id
		IN ( ".$inarray.")";

        $sql .= ' 
		GROUP BY forms.zone_id';


        $query = $this->db->query($sql);

        return $query->result();

    }
	
	
   public function location_disease_week($epicalendar_id,$districtsarray=array(),$diseasearray=array())
   {
	  $country_id = $this->erkanaauth->getField('country_id');
		
		$sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,districts.district, ';     
	  	foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";
  
		endforeach;
		
						
		$sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formsdata, districts
		WHERE forms.id = formsdata.form_id
		AND formsdata.epicalendar_id = '.$epicalendar_id.'
		AND districts.id = forms.district_id		
		AND forms.draft !=1
		AND forms.country_id = '.$country_id;
		
		if(empty($districtsarray))
		{
			$inarray = 0;
		}
		else
		{
			$inarray = 0;
			foreach($districtsarray as $key=>$district_id):
			
				$inarray .= ','.$district_id;
			
			endforeach;
		}
		
		$sql .= " AND forms.district_id
		IN ( ".$inarray.")";
		
		$sql .= ' 
		GROUP BY forms.district_id';
		
        
       $query = $this->db->query($sql);
        
       return $query->result(); 
	 
   }

   public function reportingsites($epicalendaridArray,$district_id,$region_id,$zone_id)
   {
       $sql = 'SELECT forms.*, zones.*, regions.*, districts.*, healthfacilities.* ';
       $sql .= 'FROM forms, zones, regions, districts, healthfacilities ';

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

       $sql .= 'WHERE formsdata.epicalendar_id IN ( '.$inarray.') AND forms.draft !=1';

       $sql .= ' AND forms.region_id = regions.id ';
       $sql .= 'AND forms.zone_id = zones.id ';
       $sql .= 'AND forms.district_id = districts.id ';
       $sql .= 'AND forms.healthfacility_id = healthfacilities.id';

       if ($zone_id != 0) {
           $sql .= ' AND forms.zone_id='.$zone_id;
       }

       if ($region_id != 0) {
           $sql .= ' AND forms.region_id='.$region_id;
       }

       if ($district_id != 0) {
           $sql .= ' AND forms.district_id='.$district_id;
       }

   }
   
   public function get_list_by_hf($healthfacility_id)
   {
       $data = array();
	   $this->db->where('healthfacility_id',$healthfacility_id);
       $Q = $this->db->get('forms');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   public function get_list_by_dist($district_id)
   {
       $data = array();
	   $this->db->where('district_id',$district_id);
       $Q = $this->db->get('forms');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   public function get_list_by_country($country_id)
   {
       $data = array();
	   $this->db->where('country_id',$country_id);
       $Q = $this->db->get('forms');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   public function get_list_by_region($region_id)
   {
       $data = array();
	   $this->db->where('region_id',$region_id);
       $Q = $this->db->get('forms');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   public function get_search_list($healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no)
   {
       $data = array();
	   $country_id = $this->erkanaauth->getField('country_id');
	   if($healthfacility_id !=0)
		{
			$this->db->where('healthfacility_id',$healthfacility_id);
		}
		if($district_id !=0)
		{
			$this->db->where('district_id',$district_id);
		}
		if($region_id !=0)
		{
			$this->db->where('region_id',$region_id);
		}
		if($zone_id !=0)
		{
			$this->db->where('zone_id',$zone_id);
		}
		if($reporting_year !=0)
		{
			$this->db->where('reporting_year',$reporting_year);
		}
		if($week_no !=0)
		{
			$this->db->where('week_no',$week_no);
		}
		
	   $this->db->where('country_id',$country_id);
	   
       $Q = $this->db->get('forms');
       if ($Q->num_rows() > 0) {
       	foreach ($Q->result_array() as $row){
       		$data[] = $row;
       	}
       }
       $Q->free_result();
       return $data;
   }
   
   function get_paged_search_list($perpage=0,$start=0,$healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no)
   {
	   
	 	$one=false;
		$array='array';
		$data = array();
		
		$country_id = $this->erkanaauth->getField('country_id');
		
		if($healthfacility_id !=0)
		{
			$this->db->where('healthfacility_id',$healthfacility_id);
		}
		if($district_id !=0)
		{
			$this->db->where('district_id',$district_id);
		}
		if($region_id !=0)
		{
			$this->db->where('region_id',$region_id);
		}
		if($zone_id !=0)
		{
			$this->db->where('zone_id',$zone_id);
		}
		if($reporting_year !=0)
		{
			$this->db->where('reporting_year',$reporting_year);
		}
		if($week_no !=0)
		{
			$this->db->where('week_no',$week_no);
		}
		
		$this->db->where('country_id',$country_id);
		
		$this->db->order_by("id", "DESC"); 
		$this->db->limit($perpage,$start);
		  
		$query = $this->db->get('forms');
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
   
   function get_paged_hf_list($perpage=0,$start=0,$healthfacility_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('forms AS t1')
		  ->where('t1.healthfacility_id',$healthfacility_id)
		  ->order_by('t1.id DESC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_dict_list($perpage=0,$start=0,$district_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('forms AS t1')
		  ->where('t1.district_id',$district_id)
		  ->order_by('t1.id DESC')
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
          ->from('forms AS t1')
		  ->where('t1.country_id',$country_id)
		  ->order_by('t1.id DESC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_reg_list($perpage=0,$start=0,$region_id)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('forms AS t1')
		  ->where('t1.region_id',$region_id)
		  ->order_by('t1.id DESC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
	
	function get_paged_list($perpage=0,$start=0)
   {
	 	$one=false;
		$array='array';
		$data = array();
		$this->db->select('t1.*')
          ->from('forms AS t1')
		  ->order_by('t1.id DESC')
		  ->limit($perpage,$start);
		  
		$query = $this->db->get();
        
        $result =  !$one  ? $query->result($array) : $query->row() ;
        return $result;
	}
   
   
   function get_by_period_hf($epdcalendar_id, $healthfacility_id)
    {
        
        $data = array();
        $this->db->where('epicalendar_id', $epdcalendar_id)
		         ->where('healthfacility_id', $healthfacility_id);
        $Q = $this->db->get('forms');
        
        if ($Q->num_rows() > 0) {
            
            foreach ($Q->result_array() as $row) {
                
                $data[] = $row;
                
            }
            
        }
        
        $Q->free_result();
        
        return $data;
        
    }
	
	 function get_by_reporting_period_hf($epdcalendar_id, $healthfacility_id)
    {
        
        $this->db->where('epicalendar_id', $epdcalendar_id)->where('healthfacility_id', $healthfacility_id);
        
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
