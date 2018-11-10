<?php

class Formalertsmodel extends CI_Model {

	private $tbl_roles= 'formalerts';
   function __construct()
   {
       parent::__construct();
   }

   public function get_list()
   {
       $data = array();
       $Q = $this->db->get('formalerts');
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
        $Q = $this->db->get('formalerts');
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
        $Q = $this->db->get('formalerts');
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
        $Q = $this->db->get('formalerts');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row){
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }
   
   
   function get_by_zone_period($epicalendar_id,$zone_id)
   {
	   $sql = "SELECT zones.zone, COUNT( districts.id ) AS total_districts,
		(
		SELECT COUNT(healthfacilities.id)
		FROM zones,healthfacilities,forms
		WHERE zones.id = forms.zone_id
		AND healthfacilities.id = forms.healthfacility_id
		AND forms.epicalendar_id=".$epicalendar_id."
		AND forms.draft !=1
		AND zones.id = ".$zone_id."
		GROUP BY forms.zone_id
		) AS reporting_facilities,
		(
		SELECT SUM(total_consultations)
		FROM zones,forms
		WHERE zones.id = forms.zone_id
		AND forms.epicalendar_id=".$epicalendar_id."
		AND forms.draft !=1
		AND zones.id = ".$zone_id."
		GROUP BY forms.zone_id
		) AS total_consultations,
		(
		SELECT COUNT(formalerts.id)
		FROM zones,forms,formalerts
		WHERE zones.id = forms.zone_id
		AND forms.id = formalerts.reportingform_id
		AND formalerts.reportingperiod_id=".$epicalendar_id."
		AND forms.draft !=1
		AND zones.id = ".$zone_id."
		GROUP BY forms.zone_id
		) AS total_alerts
		FROM zones, districts, regions
		WHERE zones.id = regions.zone_id
		AND regions.id = districts.region_id
		AND zones.id = ".$zone_id."
		GROUP BY zone_id";
		
		$query = $this->db->query($sql);
		
		return $query;
   }
   
   
   function get_by_period_year_alert_outbreak($epicalendar_id,$from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
   {
	   $country_id = $this->erkanaauth->getField('country_id');
	   $sql = "SELECT forms.id, forms.week_no, formalerts.reportingperiod_id,";
	   foreach($diseasearray as $key=>$diseasecode):
		   $sql .= "COUNT(CASE WHEN formalerts.disease_name =  '".$diseasecode."' AND formalerts.country_id=".$country_id." THEN formalerts.id END) ".$diseasecode."_alerts,
			COUNT(CASE WHEN formalerts.disease_name =  '".$diseasecode."' AND formalerts.country_id=".$country_id." AND formalerts.outcome=2 THEN formalerts.id END) ".$diseasecode."_outbreaks,
			COUNT(CASE WHEN formalerts.disease_name =  '".$diseasecode."' AND formalerts.country_id=".$country_id." AND formalerts.verification_status=1 THEN formalerts.id END) ".$diseasecode."_true_alerts,
			COUNT(CASE WHEN formalerts.disease_name =  '".$diseasecode."' AND formalerts.country_id=".$country_id." AND formalerts.verification_status=0 THEN formalerts.id END) ".$diseasecode."_false_alerts,
			(SELECT COUNT( formalerts.id )
			FROM formalerts, forms
			WHERE forms.id = formalerts.reportingform_id
			AND formalerts.disease_name='".$diseasecode."'
			AND formalerts.country_id=".$country_id."
			AND formalerts.reportingperiod_id
			BETWEEN ".$from." 
			AND ".$to.") AS ".$diseasecode."_year_alert,
			(SELECT COUNT( formalerts.id )
			FROM formalerts, forms
			WHERE forms.id = formalerts.reportingform_id
			AND formalerts.disease_name='".$diseasecode."'
			AND formalerts.country_id=".$country_id."
			AND formalerts.outcome=2 
			AND formalerts.reportingperiod_id
			BETWEEN ".$from." 
			AND ".$to.") AS ".$diseasecode."_year_outbreaks,";
		
		endforeach;
		
		$sql .= "forms.zone_id,forms.region_id,forms.district_id,forms.healthfacility_id
		FROM forms, formalerts
		WHERE forms.id = formalerts.reportingform_id
		AND forms.country_id=".$country_id."
		AND formalerts.reportingperiod_id =".$epicalendar_id."		
		AND forms.draft !=1";
		
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
		
		$sql .= " GROUP BY formalerts.reportingperiod_id 
		ORDER BY formalerts.reportingperiod_id ASC";
		
		$query = $this->db->query($sql);
		
		return $query->result();
		
   }
   
   
   function get_active_hf_period($epicalendar_id,$zone_id,$region_id)
   {
		$sql = "SELECT healthfacilities.id AS healthfacility_id,healthfacilities.health_facility, healthfacilities.district_id, healthfacilities.focal_person_name,healthfacilities.contact_number,forms.week_no,forms.reporting_year, formalerts.id,districts.district,districts.lat, districts.long,regions.region,zones.zone,
		(
		SELECT COUNT(*)
		FROM forms
		WHERE healthfacilities.id=  forms.healthfacility_id
		AND forms.epicalendar_id=".$epicalendar_id."
		) AS No_Reported,
		(
		SELECT COUNT(*) 
		FROM formalerts
		WHERE healthfacilities.id=  formalerts.healthfacility_id
		AND formalerts.reportingperiod_id=".$epicalendar_id."
		) AS No_Alerts,
		(
		SELECT COUNT(*) 
		FROM formalerts
		WHERE formalerts.outcome !=1
		AND healthfacilities.id=  formalerts.healthfacility_id
		AND formalerts.reportingperiod_id=".$epicalendar_id."
		) AS No_Action
		FROM healthfacilities,forms,formalerts,districts,regions,zones
		WHERE healthfacilities.id = forms.healthfacility_id
		AND formalerts.healthfacility_id = healthfacilities.id
		AND healthfacilities.district_id = districts.id
		AND districts.region_id = regions.id
		AND regions.zone_id = zones.id";
		
		if ($zone_id != 0) {
            $sql .= ' AND zones.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND regions.id='.$region_id;
        }
		
		$sql .= " AND forms.epicalendar_id=".$epicalendar_id."
		GROUP BY healthfacilities.id,forms.epicalendar_id";
		
		
		$query = $this->db->query($sql);
		
		return $query->result();
		
   }
   
   function get_inactive_hf_period($epicalendar_id,$zone_id,$region_id,$country_id,$idarrays=array())
   {
	   
	   $sql = "SELECT healthfacilities.id AS healthfacility_id,healthfacilities.health_facility, healthfacilities.district_id, healthfacilities.focal_person_name,healthfacilities.contact_number,districts.district,districts.lat, districts.long,regions.region,zones.zone
	   FROM healthfacilities,districts,regions,zones
		WHERE healthfacilities.district_id = districts.id
		AND districts.region_id = regions.id
		AND regions.zone_id = zones.id";
		
		if ($zone_id != 0) {
            $sql .= ' AND zones.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND regions.id='.$region_id;
        }
		
	   if(empty($idarrays))
	   {
		   $in_varriables = '0,';
	   }
	   else
	   {
		   $in_varriables = '';
		   foreach($idarrays as $key=>$idarray):		   
		   		$in_varriables .= $idarray.',';
		   endforeach;
	   }
	   
	   $sql .= ' AND healthfacilities.id NOT IN ( '.$in_varriables.' 0 )
	   AND zones.country_id = '.$country_id.'
	   ORDER BY healthfacilities.id DESC';
	   
	   $query = $this->db->query($sql);
		
	   return $query->result();
   }
   
   function get_total_true_alerts($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id)
   {
	   $sql = 'SELECT SUM( formalerts.cases ) AS total_cases
FROM formalerts,forms
WHERE formalerts.reportingperiod_id ='.$reportingperiod_id;
	   
	   $sql .= ' AND forms.id = formalerts.reportingform_id';
	   
	   if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= "
		AND verification_status = 1
		AND forms.draft !=1
		GROUP BY formalerts.reportingperiod_id";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		if(empty($row))
		{
			$empty_row = 0;
			
			return $empty_row;
		}
		else
		{
			return $row->total_cases;
		}
   }
   
   function get_total_alerts($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id)
   {
	   $sql = 'SELECT SUM( formalerts.cases ) AS total_cases
FROM formalerts,forms
WHERE formalerts.reportingperiod_id ='.$reportingperiod_id;
	   
	   $sql .= ' AND forms.id = formalerts.reportingform_id';
	   
	   if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= "
		AND forms.draft !=1
		GROUP BY formalerts.reportingperiod_id";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		if(empty($row))
		{
			$empty_row = 0;
			
			return $empty_row;
		}
		else
		{
			return $row->total_cases;
		}
   }
   
   function get_sum_by_disease_period($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id,$disease_code)
   {
	   $country_id = $this->erkanaauth->getField('country_id');
	   $sql = "SELECT forms.week_no, forms.reporting_year, SUM( 
CASE WHEN formalerts.disease_name =  '".$disease_code."' AND formalerts.country_id = ".$country_id."
THEN formalerts.cases
END ) disease_total,";

		$sql .= " formalerts.id 
		FROM forms, formalerts";
		$sql .= " 
		WHERE forms.id = formalerts.reportingform_id";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		$sql .= "
		AND forms.draft !=1
		AND forms.country_id = ".$country_id."
		AND formalerts.reportingperiod_id =".$reportingperiod_id."
		GROUP BY formalerts.reportingperiod_id";
		
		$query = $this->db->query($sql);
		
		$row = $query->row();
		
		if(empty($row))
		{
			$empty_row = 0;
			
			return $empty_row;
		}
		else
		{
			return $row->disease_total;
		}
   }
   
   function get_list_by_epi_periods($reportingperiodone_id,$reportingperiodtwo_id,$district_id, $region_id, $zone_id, $healthfacility_id)
   {
		$sql = "SELECT forms.epicalendar_id, forms.week_no,forms.entry_date,forms.entry_time,formalerts.disease_name,formalerts.cases,districts.district,districts.lat,districts.long,regions.region,zones.zone, healthfacilities.health_facility, users.username,users.contact_number
		FROM forms, formalerts, districts, regions, zones, healthfacilities,users
		WHERE forms.id = formalerts.reportingform_id
		AND districts.id = formalerts.district_id
		AND regions.id = formalerts.region_id
		AND zones.id = formalerts.zone_id
		AND healthfacilities.id = formalerts.healthfacility_id
		AND users.id = forms.user_id
		AND forms.draft !=1";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= " AND formalerts.reportingperiod_id BETWEEN  ".$reportingperiodone_id." AND ".$reportingperiodtwo_id;
		
		$query = $this->db->query($sql);
		
		return $query->result();
		
		
   }


    function get_list_by_epi_array_disease_status($epicalendaridArray=array(),$district_id, $region_id, $zone_id, $healthfacility_id,$disease_id,$verification_status)
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

        $sql = "SELECT forms.epicalendar_id, forms.week_no,forms.entry_date,forms.entry_time,formalerts.disease_name,formalerts.cases,districts.district,districts.lat,districts.long,regions.region,zones.zone, healthfacilities.health_facility, users.username,users.contact_number
		FROM forms, formalerts, districts, regions, zones, healthfacilities,users
		WHERE forms.id = formalerts.reportingform_id
		AND districts.id = formalerts.district_id
		AND regions.id = formalerts.region_id
		AND zones.id = formalerts.zone_id
		AND healthfacilities.id = formalerts.healthfacility_id
		AND users.id = forms.user_id
		AND forms.draft !=1";

        if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }

        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }

        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }

        if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }

        $sql .= " AND formalerts.reportingperiod_id IN ( ".$inarray.") ";

        if ($disease_id != 0) {
            $sql .= ' AND formalerts.disease_id='.$disease_id;
        }

        if ($verification_status != 2) {
            $sql .= ' AND formalerts.verification_status='.$verification_status;
        }

        $query = $this->db->query($sql);

        return $query->result();



    }
   
   function get_list_by_epi_periods_disease_status($reportingperiodone_id,$reportingperiodtwo_id,$district_id, $region_id, $zone_id, $healthfacility_id,$disease_id,$verification_status)
   {
	   
		$sql = "SELECT forms.epicalendar_id, forms.week_no,forms.entry_date,forms.entry_time,formalerts.disease_name,formalerts.cases,districts.district,districts.lat,districts.long,regions.region,zones.zone, healthfacilities.health_facility, users.username,users.contact_number
		FROM forms, formalerts, districts, regions, zones, healthfacilities,users
		WHERE forms.id = formalerts.reportingform_id
		AND districts.id = formalerts.district_id
		AND regions.id = formalerts.region_id
		AND zones.id = formalerts.zone_id
		AND healthfacilities.id = formalerts.healthfacility_id
		AND users.id = forms.user_id
		AND forms.draft !=1";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= " AND formalerts.reportingperiod_id BETWEEN  ".$reportingperiodone_id." AND ".$reportingperiodtwo_id;
		
		if ($disease_id != 0) {
            $sql .= ' AND formalerts.disease_id='.$disease_id;
        }
		
		if ($verification_status != 2) {
            $sql .= ' AND formalerts.verification_status='.$verification_status;
        }
		
		$query = $this->db->query($sql);
		
		return $query->result();
		
		
   }
   
   function get_list_by_period($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id)
   {
		$sql = "SELECT forms.epicalendar_id, forms.week_no,forms.entry_date,forms.entry_time,formalerts.disease_name,formalerts.cases,districts.district,districts.lat,districts.long,regions.region,zones.zone, healthfacilities.health_facility, users.username,users.contact_number
		FROM forms, formalerts, districts, regions, zones, healthfacilities,users
		WHERE forms.id = formalerts.reportingform_id
		AND districts.id = formalerts.district_id
		AND regions.id = formalerts.region_id
		AND zones.id = formalerts.zone_id
		AND healthfacilities.id = formalerts.healthfacility_id
		AND users.id = forms.user_id
		AND forms.draft !=1";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= " AND formalerts.reportingperiod_id = ".$reportingperiod_id;
		
		$query = $this->db->query($sql);
		
		return $query->result();
   }
   
    function get_list_by_period_limit($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id)
   {
		$sql = "SELECT forms.epicalendar_id, forms.week_no,forms.entry_date,forms.entry_time,formalerts.disease_name,formalerts.cases,districts.district,districts.lat,districts.long,regions.region,zones.zone, healthfacilities.health_facility, users.username,users.contact_number
		FROM forms, formalerts, districts, regions, zones, healthfacilities,users
		WHERE forms.id = formalerts.reportingform_id
		AND districts.id = formalerts.district_id
		AND regions.id = formalerts.region_id
		AND zones.id = formalerts.zone_id
		AND healthfacilities.id = formalerts.healthfacility_id
		AND users.id = forms.user_id
		AND forms.draft !=1";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= " AND formalerts.reportingperiod_id = ".$reportingperiod_id;
		
		$sql .= " LIMIT 100";
		
		$query = $this->db->query($sql);
		
		return $query->result();
   }
   
   
   function get_list_by_period_disease($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id,$disease_id)
   {
		$sql = "SELECT forms.epicalendar_id, forms.week_no,forms.entry_date,forms.entry_time,formalerts.disease_name,formalerts.cases,districts.district,districts.lat,districts.long,regions.region,zones.zone, healthfacilities.health_facility, users.username,users.contact_number
		FROM forms, formalerts, districts, regions, zones, healthfacilities,users
		WHERE forms.id = formalerts.reportingform_id
		AND districts.id = formalerts.district_id
		AND regions.id = formalerts.region_id
		AND zones.id = formalerts.zone_id
		AND healthfacilities.id = formalerts.healthfacility_id
		AND users.id = forms.user_id
		AND forms.draft !=1";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= " AND formalerts.disease_id = ".$disease_id;
		
		$sql .= " AND formalerts.reportingperiod_id = ".$reportingperiod_id;
		
		$query = $this->db->query($sql);
		
		return $query->result();
   }

    public function district_disease_alerts($epicalendar_id,$districtarray=array(),$diseasearray=array())
    {
        $country_id = $this->erkanaauth->getField('country_id');

        $sql = "SELECT forms.week_no, forms.reporting_year, formalerts.reportingperiod_id,districts.district,regions.region,zones.zone, ";

        foreach($diseasearray as $key=>$diseasecode):

            $sql .= "
			SUM( 
		CASE WHEN formalerts.disease_name =  '".$diseasecode."'
		AND formalerts.country_id = ".$country_id."
		THEN formalerts.cases
		END ) ".$diseasecode.",";
        endforeach;

        $sql .= " formalerts.id 
		FROM forms, formalerts, districts, regions, zones ";
        $sql .= "WHERE forms.id = formalerts.reportingform_id
		AND districts.id = formalerts.district_id
		AND regions.id = formalerts.region_id
		AND zones.id = formalerts.zone_id";

        if(empty($districtarray))
        {
            $inarray = 0;
        }
        else
        {
            $inarray = 0;
            foreach($districtarray as $key=>$district_id):

                $inarray .= ','.$district_id;

            endforeach;
        }

        $sql .= " AND formalerts.district_id
		IN ( ".$inarray.")";

        $sql .= " AND forms.draft !=1
        AND formalerts.verification_status = 1
		AND formalerts.reportingperiod_id =".$epicalendar_id."
		GROUP BY formalerts.district_id";

        $query = $this->db->query($sql);

        return $query->result();

    }
   
   function get_sum_by_period_map($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
   {
	   $country_id = $this->erkanaauth->getField('country_id');
	   $sql = "SELECT forms.week_no, forms.reporting_year, forms.entry_date,forms.entry_time,districts.district,districts.lat,districts.long, regions.region,zones.zone, users.username,users.contact_number, healthfacilities.health_facility,";
		
		foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "
			SUM( 
		CASE WHEN formalerts.disease_name =  '".$diseasecode."'
		AND formalerts.country_id = ".$country_id."
		THEN formalerts.cases
		END ) ".$diseasecode.",";
		endforeach;
		
		$sql .= " formalerts.id 
		FROM forms, formalerts, districts, regions, zones, users, healthfacilities";
		$sql .= " 
		WHERE forms.id = formalerts.reportingform_id
		AND districts.id = formalerts.district_id
		AND users.id = forms.user_id
		AND regions.id = formalerts.region_id
		AND zones.id = formalerts.zone_id
		AND healthfacilities.id = formalerts.healthfacility_id";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		$sql .= "
		AND forms.draft !=1
		AND formalerts.reportingperiod_id =".$reportingperiod_id."
		GROUP BY formalerts.reportingperiod_id,forms.id";
		
		$query = $this->db->query($sql);
		
		return $query->result();
   }
   
   function get_sum_by_period($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
   {
	   $country_id = $this->erkanaauth->getField('country_id');
	   $sql = "SELECT forms.week_no, forms.reporting_year, ";
		
		foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "
			SUM( 
		CASE WHEN formalerts.disease_name =  '".$diseasecode."'
		THEN formalerts.cases
		END ) ".$diseasecode.",(
		SELECT disease_name
		FROM diseases
		WHERE disease_code=  '".$diseasecode."'
		AND diseases.country_id = ".$country_id."
		) AS ".$diseasecode."_Name,";
		endforeach;
		
		$sql .= " formalerts.id 
		FROM forms, formalerts, diseases";
		$sql .= " 
		WHERE forms.id = formalerts.reportingform_id";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= " AND diseases.id = formalerts.disease_id
		AND forms.draft !=1
		AND forms.country_id = ".$country_id."
		AND diseases.country_id = ".$country_id."
		AND formalerts.reportingperiod_id =".$reportingperiod_id."
		GROUP BY formalerts.reportingperiod_id";
		
		$query = $this->db->query($sql);
		
		return $query->result();
   }
   
   
   function get_sum_by_period_true($reportingperiod_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
   {
	   
	   $country_id = $this->erkanaauth->getField('country_id');

	   $sql = "SELECT forms.week_no, forms.reporting_year, ";
		
		foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "
			SUM( 
		CASE WHEN formalerts.disease_name =  '".$diseasecode."'
		THEN formalerts.cases
		END ) ".$diseasecode.",(
		SELECT disease_name
		FROM diseases
		WHERE disease_code=  '".$diseasecode."'
		AND diseases.country_id = ".$country_id."
		) AS ".$diseasecode."_Name,";
		endforeach;
		
		$sql .= " formalerts.id 
		FROM forms, formalerts, diseases";
		$sql .= " 
		WHERE forms.id = formalerts.reportingform_id";
		
		if ($zone_id != 0) {
            $sql .= ' AND formalerts.zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND formalerts.region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND formalerts.district_id='.$district_id;
        }
		
		 if ($healthfacility_id != 0) {
            $sql .= ' AND formalerts.healthfacility_id='.$healthfacility_id;
        }
		$sql .= " AND diseases.id = formalerts.disease_id
		AND forms.draft !=1
		AND formalerts.verification_status = 1
		AND formalerts.reportingperiod_id =".$reportingperiod_id."
		AND forms.country_id = ".$country_id."
		AND diseases.country_id = ".$country_id."
		GROUP BY formalerts.reportingperiod_id";
		
		$query = $this->db->query($sql);
		
		return $query->result();
   }


    function get_all_hfs($zone_id,$region_id,$country_id)
    {

        $sql = "SELECT healthfacilities.id AS healthfacility_id,healthfacilities.health_facility, healthfacilities.district_id, healthfacilities.focal_person_name,healthfacilities.contact_number,districts.district,districts.lat, districts.long,regions.region,zones.zone
	   FROM healthfacilities,districts,regions,zones
		WHERE healthfacilities.district_id = districts.id
		AND districts.region_id = regions.id
		AND regions.zone_id = zones.id";

        if ($zone_id != 0) {
            $sql .= ' AND zones.id='.$zone_id;
        }

        if ($region_id != 0) {
            $sql .= ' AND regions.id='.$region_id;
        }



        $sql .= ' AND zones.country_id = '.$country_id.'
	   ORDER BY healthfacilities.id DESC';

        $query = $this->db->query($sql);

        return $query->result();
    }
   
   function get_by_period($reportingperiod_id) {

		$data = array();
		$this->db->where('reportingperiod_id', $reportingperiod_id);
		$Q = $this->db->get('formalerts');

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
		$this->db->where('reportingperiod_id', $reportingperiod_id)
		         ->where('district_id', $district_id);
		$Q = $this->db->get('formalerts');

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
		$this->db->where('reportingperiod_id', $reportingperiod_id)
		         ->where('region_id', $region_id);
		$Q = $this->db->get('formalerts');

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
		$this->db->where('reportingperiod_id', $reportingperiod_id)
		         ->where('zone_id', $zone_id);
		$Q = $this->db->get('formalerts');

		if ($Q->num_rows() > 0) {

			foreach ($Q->result_array() as $row){

		         	$data[] = $row;

		        }

		}	

		$Q->free_result();

		return $data;	

	}
   
   function get_by_form_period_disease_name($form_id, $healthfacility_id,$disease_name,$reportingperiod_id)
    {
        
        $this->db->where('reportingform_id', $form_id)->where('healthfacility_id', $healthfacility_id)->where('disease_name', $disease_name)->where('reportingperiod_id', $reportingperiod_id)->limit(1);
        
        return $this->db->get($this->tbl_roles);
        
    }
   
   function get_by_form_period_disease($form_id, $healthfacility_id,$disease_id,$reportingperiod_id)
    {
        
        $this->db->where('reportingform_id', $form_id)->where('healthfacility_id', $healthfacility_id)->where('disease_id', $disease_id)->where('reportingperiod_id', $reportingperiod_id)->limit(1);
        
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
