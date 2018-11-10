<?php

class Reportsmodel extends CI_Model
{
    function index()
    {
        //return $query = $this->db->get('reportingforms');
        //Here you should note i am returning 
        //the query object instead of 
        //$query->result() or $query->result_array()
        
        $array = 'array';
        $data  = array();
        $this->db->select('t1.reporting_year AS week_year,t1.week_no,t2.zone AS Zon_name,t3.region AS reg_name,t4.district AS d_name,t5.organization AS org_name,t5.health_facility AS hf_name,t5.health_facility_type AS hft,t5.hf_code AS hfc,(sum(t1.iliufivemale) + sum( 	t1.iliufivefemale)) AS ili_lt_5,(sum(t1.iliofivemale) + sum(t1.iliofivefemale)) AS ili_gt_5,(sum(t1.sariufivemale) + sum(t1.sariufivefemale)) AS sari_lt_5,(sum(t1.sariofivemale) + sum(t1.sariofivefemale)) AS sari_gt_5,(sum(t1.awdufivemale) + sum(t1.awdufivefemale)) AS awd_lt_5,(sum(t1.awdofivemale) + sum(t1.awdofivefemale)) AS awd_gt_5,(sum(t1.bdufivemale) + sum(t1.bdufivefemale)) AS bd_lt_5,(sum(t1.bdofivemale) + sum(t1.bdofivefemale)) AS bd_gt_5,(sum(t1.oadufivemale) + sum(t1.oadufivefemale)) AS oad_lt_5,(sum(t1.oadofivemale) + sum(t1.oadofivefemale)) AS oad_gt_5,(sum(t1.diphmale) + sum(t1.diphfemale)) AS diph,(sum(t1.wcmale) + sum(t1.wcfemale)) AS wc,(sum(t1.measmale) + sum(t1.measfemale)) AS meas,(sum(t1.nntmale) + sum(t1.nntfemale)) AS nnt,(sum(t1.afpmale) + sum(t1.afpfemale)) AS afp,(sum(t1.ajsmale) + sum(t1.ajsfemale)) AS ajs,(sum(t1.vhfmale) + sum(t1.vhffemale)) AS vhf,(sum(t1.malufivemale) + sum(t1.malufivefemale)) AS mal_lt_5,(sum(t1.malofivemale) + sum(t1.malofivefemale)) AS mal_gt_5,(sum(t1.suspectedmenegitismale) + sum(t1.suspectedmenegitisfemale)) AS men, t1.undisonedesc AS unDis_name,(sum(t1.undismale) + sum(t1.undisfemale)) AS unDis_num, t1.undissecdesc AS unDis_name,(sum(t1.undismaletwo) + sum(t1.undisfemaletwo)) AS unDis_num,(sum(t1.ocmale) + sum(t1.ocfemale)) AS oc,t1.total_consultations AS total_cons_disease,t1.sre AS sre, t1.pf AS pf, t1.pv AS pv,t1.pmix AS pmix,t2.zonal_code AS zon_code,t3.regional_code AS reg_code, t4.district_code AS dis_code, t1.entry_date AS Entry_Date, t1.entry_time AS Entry_Time, t6.username AS User_ID, t6.contact_number AS con_number, t1.edit_date AS Edit_Date,t1.edit_time AS Edit_Time')->from('reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6')->where('t1.healthfacility_id = t5.id')->where('t1.region_id = t3.id')->where('t4.region_id = t3.id')->where('t3.zone_id = t2.id')->where('t5.district_id = t4.id')->where('t1.user_id = t6.id')->order_by('t1.id DESC');
        
        return $query = $this->db->get();
        
    }
	
	
	function testmalaria_report($zone_id, $region_id, $district_id, $healthfacility_id, $from, $to, $reporting_year, $reporting_year2)
    {
        $sql = 'SELECT t1.*,t2.*,t3.*,t4.*,t5.*,t6.contact_number AS User_Contact,t6.*,(sum(t1.iliufivemale) + sum(t1.iliufivefemale)) AS ili_lt_5,(sum(t1.iliofivemale) + sum(t1.iliofivefemale)) AS ili_gt_5,(sum(t1.sariufivemale) + sum(t1.sariufivefemale)) AS sari_lt_5,(sum(t1.sariofivemale) + sum(t1.sariofivefemale)) AS sari_gt_5,(sum(t1.awdufivemale) + sum(t1.awdufivefemale)) AS awd_lt_5,(sum(t1.awdofivemale) + sum(t1.awdofivefemale)) AS awd_gt_5,(sum(t1.bdufivemale) + sum(t1.bdufivefemale)) AS bd_lt_5,(sum(t1.bdofivemale) + sum(t1.bdofivefemale)) AS bd_gt_5,(sum(t1.oadufivemale) + sum(t1.oadufivefemale)) AS oad_lt_5,(sum(t1.oadofivemale) + sum(t1.oadofivefemale)) AS oad_gt_5,(sum(t1.diphmale) + sum(t1.diphfemale)) AS diph,(sum(t1.wcmale) + sum(t1.wcfemale)) AS wc,(sum(t1.measmale) + sum(t1.measfemale)) AS meas,(sum(t1.nntmale) + sum(t1.nntfemale)) AS nnt,(sum(t1.afpmale) + sum(t1.afpfemale)) AS afp,(sum(t1.ajsmale) + sum(t1.ajsfemale)) AS ajs,(sum(t1.vhfmale) + sum(t1.vhffemale)) AS vhf,(sum(t1.malufivemale) + sum(t1.malufivefemale)) AS mal_lt_5,(sum(t1.malofivemale) + sum(t1.malofivefemale)) AS mal_gt_5,(sum(t1.suspectedmenegitismale) + sum(t1.suspectedmenegitisfemale)) AS men, t1.undisonedesc AS unDis_name,(sum(t1.undismale) + sum(t1.undisfemale)) AS unDis_num, t1.undissecdesc AS unDis_name,(sum(t1.undismaletwo) + sum(t1.undisfemaletwo)) AS unDis_num,(sum(t1.ocmale) + sum(t1.ocfemale)) AS oc, sum(t1.pv) AS totpv, sum(t1.sre) as totsre, sum(t1.pf) as totpf, sum(t1.pmix) as totpmix
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'" ';
		
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.week_no BETWEEN "'.$from.'" AND "'.$to.'"
			AND t1.healthfacility_id = t5.id	
			AND t1.region_id = t3.id	
			AND t4.region_id = t3.id
			AND t3.zone_id = t2.id
			AND t5.district_id = t4.id
			AND t1.user_id = t6.id
			AND t1.draft !=1 ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND t1.week_no BETWEEN "'.$from.'" AND "'.$to.'"
					AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                } else {
                    $sql .= 'AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                }
            }
            
        }
        
        if ($zone_id != 0) {
            $sql .= 'AND t2.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t4.id='.$district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND t5.id='.$healthfacility_id;
        }
        
        $sql .= ' GROUP BY t1.epdcalendar_id ORDER BY t1.id DESC ';
     
        
        return $sql;
        
    }
    
    function malaria_report($zone_id, $region_id, $district_id, $healthfacility_id, $from, $to, $reporting_year, $reporting_year2)
    {
        $sql = 'SELECT t1.*,t2.*,t3.*,t4.*,t5.*,t6.contact_number AS User_Contact,t6.*,(sum(t1.iliufivemale) + sum(t1.iliufivefemale)) AS ili_lt_5,(sum(t1.iliofivemale) + sum(t1.iliofivefemale)) AS ili_gt_5,(sum(t1.sariufivemale) + sum(t1.sariufivefemale)) AS sari_lt_5,(sum(t1.sariofivemale) + sum(t1.sariofivefemale)) AS sari_gt_5,(sum(t1.awdufivemale) + sum(t1.awdufivefemale)) AS awd_lt_5,(sum(t1.awdofivemale) + sum(t1.awdofivefemale)) AS awd_gt_5,(sum(t1.bdufivemale) + sum(t1.bdufivefemale)) AS bd_lt_5,(sum(t1.bdofivemale) + sum(t1.bdofivefemale)) AS bd_gt_5,(sum(t1.oadufivemale) + sum(t1.oadufivefemale)) AS oad_lt_5,(sum(t1.oadofivemale) + sum(t1.oadofivefemale)) AS oad_gt_5,(sum(t1.diphmale) + sum(t1.diphfemale)) AS diph,(sum(t1.wcmale) + sum(t1.wcfemale)) AS wc,(sum(t1.measmale) + sum(t1.measfemale)) AS meas,(sum(t1.nntmale) + sum(t1.nntfemale)) AS nnt,(sum(t1.afpmale) + sum(t1.afpfemale)) AS afp,(sum(t1.ajsmale) + sum(t1.ajsfemale)) AS ajs,(sum(t1.vhfmale) + sum(t1.vhffemale)) AS vhf,(sum(t1.malufivemale) + sum(t1.malufivefemale)) AS mal_lt_5,(sum(t1.malofivemale) + sum(t1.malofivefemale)) AS mal_gt_5,(sum(t1.suspectedmenegitismale) + sum(t1.suspectedmenegitisfemale)) AS men, t1.undisonedesc AS unDis_name,(sum(t1.undismale) + sum(t1.undisfemale)) AS unDis_num, t1.undissecdesc AS unDis_name,(sum(t1.undismaletwo) + sum(t1.undisfemaletwo)) AS unDis_num,(sum(t1.ocmale) + sum(t1.ocfemale)) AS oc, sum(t1.pv) AS totpv, sum(t1.sre) as totsre, sum(t1.pf) as totpf, sum(t1.pmix) as totpmix
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'" ';
		
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.epdcalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
			AND t1.healthfacility_id = t5.id	
			AND t1.region_id = t3.id	
			AND t4.region_id = t3.id
			AND t3.zone_id = t2.id
			AND t5.district_id = t4.id
			AND t1.user_id = t6.id
			AND t1.draft !=1 ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND t1.epdcalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
					AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                } else {
                    $sql .= 'AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                }
            }
            
        }
        
        if ($zone_id != 0) {
            $sql .= 'AND t2.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t4.id='.$district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND t5.id='.$healthfacility_id;
        }
        
        $sql .= ' GROUP BY t1.epdcalendar_id ORDER BY t1.epdcalendar_id ASC ';
        
        $query = $this->db->query($sql);
        
        return $query->result();
        
    }
	
	//reporting health facilities by type
	function get_reporting_hf_by_type($zone_id, $region_id, $district_id, $from, $to, $reporting_year, $reporting_year2)
	{
		$sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.healthfacility_id, healthfacilities.health_facility, healthfacilities.health_facility_type, COUNT( reportingforms.id ) AS no_of_healthfacilities,zones.*,regions.*,districts.*
FROM reportingforms, healthfacilities,zones,regions,districts
WHERE healthfacilities.id = reportingforms.healthfacility_id';

if ($reporting_year == $reporting_year2) {
            $sql .= 'AND reportingforms.epdcalendar_id >="'.$from.'" AND reportingforms.epdcalendar_id <="'.$to.'" ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND reportingforms.epdcalendar_id >="'.$from.'" AND reportingforms.epdcalendar_id <="'.$to.'" ';
                } 
            }
            
        }
		
		$sql .= 'AND healthfacilities.district_id = districts.id
		AND districts.region_id = regions.id
		AND regions.zone_id = zones.id ';
		
		 if ($zone_id != 0) {
            $sql .= 'AND zones.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND regions.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND districts.id='.$district_id;
        }
        
       		
		$sql .= ' GROUP BY healthfacilities.health_facility_type';
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	//get reporting health facilities
	
	function get_reporting_hf($zone_id, $region_id, $district_id, $from, $to, $reporting_year, $reporting_year2)
	{
		$sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.healthfacility_id, healthfacilities.health_facility, healthfacilities.health_facility_type,healthfacilities.hf_code, zones . * , regions . * , districts . *
FROM reportingforms, healthfacilities, zones, regions, districts
WHERE healthfacilities.id = reportingforms.healthfacility_id';
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND reportingforms.epdcalendar_id >="'.$from.'" AND reportingforms.epdcalendar_id <="'.$to.'" ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND reportingforms.epdcalendar_id >="'.$from.'" AND reportingforms.epdcalendar_id <="'.$to.'" ';
                } 
            }
            
        }
		
		$sql .= 'AND healthfacilities.district_id = districts.id
		AND districts.region_id = regions.id
		AND regions.zone_id = zones.id ';
		
		 if ($zone_id != 0) {
            $sql .= 'AND zones.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND regions.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND districts.id='.$district_id;
        }
        
       		
		$sql .= ' ORDER BY healthfacilities.health_facility ASC';
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	//get non-reporting - code will loop through this
	
	function get_non_reporting_hf($zone_id, $region_id, $district_id, $from, $to, $reporting_year, $reporting_year2, $healthfacility_id)
	{
		$sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.healthfacility_id, healthfacilities.health_facility,healthfacilities.hf_code,zones.*,regions.*,districts.*
FROM reportingforms, healthfacilities,zones,regions,districts
WHERE healthfacilities.id = reportingforms.healthfacility_id';
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND reportingforms.epdcalendar_id >="'.$from.'" AND reportingforms.epdcalendar_id <="'.$to.'" ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND reportingforms.epdcalendar_id >="'.$from.'" AND reportingforms.epdcalendar_id <="'.$to.'" ';
                } 
            }
            
        }
		$sql .='AND healthfacilities.id ='.$healthfacility_id.'
		AND healthfacilities.district_id = districts.id
		AND districts.region_id = regions.id
		AND regions.zone_id = zones.id ';
		
		if ($zone_id != 0) {
            $sql .= 'AND zones.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND regions.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND districts.id='.$district_id;
        }
        		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	function get_sum_by_period_locations($zon_id, $reg_id, $dist_id, $hf_id, $reportingperiod_id,$status)
	{
		$sql = 'SELECT SUM( cases ) AS reported_cases, disease_name
		FROM alerts
		WHERE reportingperiod_id ='.$reportingperiod_id.'
		AND verification_status ='.$status.' ';
		
		if ($zon_id != 0) {
            $sql .= 'AND zone_id='.$zon_id;
        }
        
        if ($reg_id != 0) {
            $sql .= ' AND region_id='.$reg_id;
        }
        
        if ($dist_id != 0) {
            $sql .= ' AND district_id='.$dist_id;
        }
        
        if ($hf_id != 0) {
            $sql .= ' AND healthfacility_id='.$hf_id;
        }
		
		$sql .= ' GROUP BY disease_name';
		
		$query = $this->db->query($sql);
        
        return $query->result();
		
	}
	
	function sum_alerts_disease($zone_id, $region_id, $district_id, $healthfacility_id, $from, $to, $reporting_year, $reporting_year2,$status,$disease_name)
    {
		
		$data = array();
		$sql = 'SELECT SUM( cases ) AS reported_cases, disease_name,reportingperiod_id
				FROM alerts
				WHERE verification_status='.$status.' ';
		
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND reportingperiod_id >="'.$from.'" AND reportingperiod_id <="'.$to.'" ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND reportingperiod_id >="'.$from.'" AND reportingperiod_id <="'.$to.'" ';
                } 
            }
            
        }
		        
        if ($zone_id != 0) {
            $sql .= 'AND zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND district_id='.$district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= ' AND disease_name="'.$disease_name.'"';
        
        $sql .= ' ORDER BY reportingperiod_id DESC';
        
		$query = $this->db->query($sql);
		
		foreach ($query->result_array() as $row){

		       $data['reported_cases'] = $row['reported_cases'];
			   

		 }
		 
		 if(!empty($data))
		 {
			 $alert_cases = $data['reported_cases'];
		 }
		 else
		 {
			 $alert_cases = 0;
		 }
        
      
	 	return $alert_cases;
		
	}
	
	
	
	
	function sum_alerts($zone_id, $region_id, $district_id, $healthfacility_id, $from, $to, $reporting_year, $reporting_year2,$status)
    {
		$sql = 'SELECT SUM( cases ) AS reported_cases, disease_name,reportingperiod_id
				FROM alerts
				WHERE verification_status='.$status.' ';
		
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND reportingperiod_id >="'.$from.'" AND reportingperiod_id <="'.$to.'" ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND reportingperiod_id >="'.$from.'" AND reportingperiod_id <="'.$to.'" ';
                } 
            }
            
        }
		        
        if ($zone_id != 0) {
            $sql .= 'AND zone_id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND region_id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND district_id='.$district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND healthfacility_id='.$healthfacility_id;
        }
		
		$sql .= ' GROUP BY disease_name';
        
        $sql .= ' ORDER BY reportingperiod_id DESC';
        
    $query = $this->db->query($sql);
        
       return $query->result();
	 
		
	}
	
	
	    
    function weekly_diseases($zone_id, $region_id, $district_id, $healthfacility_id, $from, $to, $reporting_year, $reporting_year2)
    {
        $sql = 'SELECT t1.*,t2.*,t3.*,t4.*,t5.*,t6.contact_number AS User_Contact,t6.*,(sum(t1.iliufivemale) + sum(t1.iliufivefemale)) AS ili_lt_5,(sum(t1.iliofivemale) + sum(t1.iliofivefemale)) AS ili_gt_5,(sum(t1.sariufivemale) + sum(t1.sariufivefemale)) AS sari_lt_5,(sum(t1.sariofivemale) + sum(t1.sariofivefemale)) AS sari_gt_5,(sum(t1.awdufivemale) + sum(t1.awdufivefemale)) AS awd_lt_5,(sum(t1.awdofivemale) + sum(t1.awdofivefemale)) AS awd_gt_5,(sum(t1.bdufivemale) + sum(t1.bdufivefemale)) AS bd_lt_5,(sum(t1.bdofivemale) + sum(t1.bdofivefemale)) AS bd_gt_5,(sum(t1.oadufivemale) + sum(t1.oadufivefemale)) AS oad_lt_5,(sum(t1.oadofivemale) + sum(t1.oadofivefemale)) AS oad_gt_5,(sum(t1.diphmale) + sum(t1.diphfemale)) AS diph,(sum(t1.diphofivemale) + sum(t1.diphofivefemale)) AS diph_gt_5,(sum(t1.wcmale) + sum(t1.wcfemale)) AS wc, (sum(t1.wcofivemale) + sum(t1.wcofivefemale)) AS wc_gt_5,(sum(t1.measmale) + sum(t1.measfemale)) AS meas,(sum(t1.measofivemale) + sum(t1.measofivefemale)) AS meas_gt_5,(sum(t1.nntmale) + sum(t1.nntfemale)) AS nnt,(sum(t1.afpmale) + sum(t1.afpfemale)) AS afp,(sum(t1.afpofivemale) + sum(t1.afpofivefemale)) AS afp_gt_5,(sum(t1.ajsmale) + sum(t1.ajsfemale)) AS ajs,(sum(t1.vhfmale) + sum(t1.vhffemale)) AS vhf,(sum(t1.malufivemale) + sum(t1.malufivefemale)) AS mal_lt_5,(sum(t1.malofivemale) + sum(t1.malofivefemale)) AS mal_gt_5,(sum(t1.suspectedmenegitismale) + sum(t1.suspectedmenegitisfemale)) AS men, (sum(t1.suspectedmenegitisofivemale) + sum(t1.suspectedmenegitisofivefemale)) AS men_gt_5, t1.undisonedesc AS unDis_name,(sum(t1.undismale) + sum(t1.undisfemale)) AS unDis_num, t1.undissecdesc AS unDis_name,(sum(t1.undismaletwo) + sum(t1.undisfemaletwo)) AS unDis_num,(sum(t1.ocmale) + sum(t1.ocfemale)) AS oc
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'" ';
		
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.epdcalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
			AND t1.healthfacility_id = t5.id	
			AND t1.region_id = t3.id	
			AND t4.region_id = t3.id
			AND t3.zone_id = t2.id
			AND t5.district_id = t4.id
			AND t1.user_id = t6.id
			AND t1.draft !=1 ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND t1.epdcalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
					AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                } else {
                    $sql .= 'AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                }
            }
            
        }		
		
        
        if ($zone_id != 0) {
            $sql .= 'AND t2.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t4.id='.$district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND t5.id='.$healthfacility_id;
        }
        
        $sql .= ' GROUP BY t1.epdcalendar_id ORDER BY t1.id DESC ';
        
        $query = $this->db->query($sql);
        
        return $query->result();
        
    }
	
	function get_alerts_by_hf($zone_id, $region_id, $district_id, $healthfacility_id, $from, $to, $reporting_year, $reporting_year2,$status)
	{
		$sql = 'SELECT DISTINCT healthfacilities.id, healthfacilities.*, reportingforms.*, SUM( alerts.cases ) AS reported_cases, alerts.disease_name, alerts.reportingperiod_id,zones.*,regions.*,districts.*
FROM healthfacilities, alerts, reportingforms,zones,regions,districts
WHERE alerts.verification_status ='.$status.' ';
		
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND alerts.reportingperiod_id >="'.$from.'" AND alerts.reportingperiod_id <="'.$to.'"
					AND reportingforms.healthfacility_id = healthfacilities.id	
					AND reportingforms.region_id = regions.id	
					AND districts.region_id = regions.id
					AND regions.zone_id = zones.id
					AND healthfacilities.district_id = districts.id
					AND reportingforms.draft !=1
					AND healthfacilities.id = reportingforms.healthfacility_id
					AND reportingforms.id = alerts.reportingform_id ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND alerts.reportingperiod_id >="'.$from.'" AND alerts.reportingperiod_id <="'.$to.'"
							AND reportingforms.healthfacility_id = healthfacilities.id	
							AND reportingforms.region_id = regions.id	
							AND districts.region_id = regions.id
							AND regions.zone_id = zones.id
							AND healthfacilities.district_id = districts.id
							AND reportingforms.draft !=1
							AND healthfacilities.id = reportingforms.healthfacility_id
							AND reportingforms.id = alerts.reportingform_id ';
                } else {
                    $sql .= 'AND reportingforms.healthfacility_id = healthfacilities.id	
					AND reportingforms.region_id = regions.id	
					AND districts.region_id = regions.id
					AND regions.zone_id = zones.id
					AND healthfacilities.district_id = districts.id
					AND reportingforms.draft !=1
					AND healthfacilities.id = reportingforms.healthfacility_id
					AND reportingforms.id = alerts.reportingform_id ';
                }
            }
            
        }
		
		if ($zone_id != 0) {
            $sql .= ' AND zones.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND regions.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND districts.id='.$district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND healthfacilities.id='.$healthfacility_id;
        }
		
		$sql .= ' GROUP BY alerts.disease_name ORDER BY alerts.reportingperiod_id DESC';
		
		$query = $this->db->query($sql);
        
        return $query->result();
	}
	
	 function get_case_records($zone_id, $region_id, $district_id, $healthfacility_id, $from, $to, $reporting_year, $reporting_year2)
    {
        $sql = 'SELECT t1.*,t2.*,t3.*,t4.*,t5.*,t6.contact_number AS User_Contact,t6.*,(sum(t1.iliufivemale) + sum(t1.iliufivefemale)) AS ili_lt_5,(sum(t1.iliofivemale) + sum(t1.iliofivefemale)) AS ili_gt_5,(sum(t1.sariufivemale) + sum(t1.sariufivefemale)) AS sari_lt_5,(sum(t1.sariofivemale) + sum(t1.sariofivefemale)) AS sari_gt_5,(sum(t1.awdufivemale) + sum(t1.awdufivefemale)) AS awd_lt_5,(sum(t1.awdofivemale) + sum(t1.awdofivefemale)) AS awd_gt_5,(sum(t1.bdufivemale) + sum(t1.bdufivefemale)) AS bd_lt_5,(sum(t1.bdofivemale) + sum(t1.bdofivefemale)) AS bd_gt_5,(sum(t1.oadufivemale) + sum(t1.oadufivefemale)) AS oad_lt_5,(sum(t1.oadofivemale) + sum(t1.oadofivefemale)) AS oad_gt_5,(sum(t1.diphmale) + sum(t1.diphfemale)) AS diph,(sum(t1.diphofivemale) + sum(t1.diphofivefemale)) AS diph_gt_5,(sum(t1.wcmale) + sum(t1.wcfemale)) AS wc, (sum(t1.wcofivemale) + sum(t1.wcofivefemale)) AS wc_gt_5,(sum(t1.measmale) + sum(t1.measfemale)) AS meas,(sum(t1.measofivemale) + sum(t1.measofivefemale)) AS meas_gt_5,(sum(t1.nntmale) + sum(t1.nntfemale)) AS nnt,(sum(t1.afpmale) + sum(t1.afpfemale)) AS afp,(sum(t1.afpofivemale) + sum(t1.afpofivefemale)) AS afp_gt_5,(sum(t1.ajsmale) + sum(t1.ajsfemale)) AS ajs,(sum(t1.vhfmale) + sum(t1.vhffemale)) AS vhf,(sum(t1.malufivemale) + sum(t1.malufivefemale)) AS mal_lt_5,(sum(t1.malofivemale) + sum(t1.malofivefemale)) AS mal_gt_5,(sum(t1.suspectedmenegitismale) + sum(t1.suspectedmenegitisfemale)) AS men, (sum(t1.suspectedmenegitisofivemale) + sum(t1.suspectedmenegitisofivefemale)) AS men_gt_5, t1.undisonedesc AS unDis_name,(sum(t1.undismale) + sum(t1.undisfemale)) AS unDis_num, t1.undissecdesc AS unDis_name,(sum(t1.undismaletwo) + sum(t1.undisfemaletwo)) AS unDis_num,(sum(t1.ocmale) + sum(t1.ocfemale)) AS oc 
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'" ';
		
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.epdcalendar_id>="'.$from.'" AND t1.epdcalendar_id <="'.$to.'"
			AND t1.healthfacility_id = t5.id	
			AND t1.region_id = t3.id	
			AND t4.region_id = t3.id
			AND t3.zone_id = t2.id
			AND t5.district_id = t4.id
			AND t1.user_id = t6.id
			AND t1.draft !=1 ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND t1.epdcalendar_id>="'.$from.'" AND t1.epdcalendar_id <="'.$to.'"
					AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                } else {
                    $sql .= 'AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                }
            }
            
        }
		        
        if ($zone_id != 0) {
            $sql .= 'AND t2.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t4.id='.$district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND t5.id='.$healthfacility_id;
        }
        
        $sql .= ' GROUP BY t5.id ORDER BY t5.health_facility ASC';
        
        $query = $this->db->query($sql);
        
        return $query->result();
        
    }
	
	
    
    function get_export_records($zone_id, $region_id, $district_id, $healthfacility_id, $from, $to, $reporting_year, $reporting_year2)
    {
        $sql = 'SELECT t1.*,t2.*,t3.*,t4.*,t5.*,t6.contact_number AS User_Contact,t6.*
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'" ';
		
		if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.epdcalendar_id>="'.$from.'" AND t1.epdcalendar_id <="'.$to.'"
			AND t1.healthfacility_id = t5.id	
			AND t1.region_id = t3.id	
			AND t4.region_id = t3.id
			AND t3.zone_id = t2.id
			AND t5.district_id = t4.id
			AND t1.user_id = t6.id
			AND t1.draft !=1 ';
        } else {
            if ($reporting_year2 > $reporting_year) {
                if ($to > $from) {
                    $sql .= 'AND t1.epdcalendar_id>="'.$from.'" AND t1.epdcalendar_id <="'.$to.'"
					AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                } else {
                    $sql .= 'AND t1.healthfacility_id = t5.id	
					AND t1.region_id = t3.id	
					AND t4.region_id = t3.id
					AND t3.zone_id = t2.id
					AND t5.district_id = t4.id
					AND t1.user_id = t6.id
					AND t1.draft !=1 ';
                }
            }
            
        }
		        
        if ($zone_id != 0) {
            $sql .= 'AND t2.id='.$zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id='.$region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t4.id='.$district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND t5.id='.$healthfacility_id;
        }
        
        $sql .= ' ORDER BY t1.week_no DESC';
        
        $query = $this->db->query($sql);
        
        return $query->result();
        
    }

    function get_full_list_week_array($reporting_year, $reporting_year2,$epicalendaridArray=array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {

        $country_id = $this->erkanaauth->getField('country_id');

        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year, forms.epicalendar_id, forms.zone_id, forms.region_id, forms.district_id, forms.user_id, forms.sre, forms.pf, forms.pv, forms.pmix, forms.total_consultations,forms.undismale,forms.undisfemale,forms.undismaletwo,forms.undisfemaletwo,forms.ocmale,forms.ocfemale, forms.approved_dist,forms.approved_region,forms.approved_zone,forms.approved_national,forms.draft,formsdata.form_id, users.username, users.contact_number, healthfacilities.health_facility,';
        foreach($diseasearray as $key=>$diseasecode):

            $sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";
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

        foreach($diseasearray as $key=>$diseasecode):

            $sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE disease_name = '".$diseasecode."' AND forms.healthfacility_id = formalerts.healthfacility_id
					  AND reportingperiod_id IN ( '.$inarray.')) AS ".$diseasecode."_total_alerts, ";
        endforeach;




        $sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms,formsdata,users,healthfacilities
		WHERE forms.epicalendar_id IN ( '.$inarray.')
		AND forms.id = formsdata.form_id
		AND users.id = forms.user_id
		AND forms.healthfacility_id = healthfacilities.id
		AND forms.draft !=1
		AND forms.country_id = '.$country_id.'
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
		GROUP BY forms.healthfacility_id 
		ORDER BY healthfacilities.health_facility ASC';


        $query = $this->db->query($sql);

        return $query->result();


    }
	
	
	function get_full_list($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
		
		$country_id = $this->erkanaauth->getField('country_id');
		
		$sql = 'SELECT forms.id, forms.week_no, forms.reporting_year, forms.epicalendar_id, forms.user_id, forms.sre, forms.pf, forms.pv, forms.pmix, forms.total_consultations,forms.undismale,forms.undisfemale,forms.undismaletwo,forms.undisfemaletwo,forms.ocmale,forms.ocfemale, forms.approved_dist,forms.approved_region,forms.approved_zone,forms.approved_national,forms.draft,formsdata.form_id, users.username, users.contact_number, healthfacilities.health_facility,';     
	  	foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";
		endforeach;
		
		foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE disease_name = '".$diseasecode."' AND forms.healthfacility_id = formalerts.healthfacility_id
					  AND reportingperiod_id BETWEEN '".$from."' AND '".$to."') AS ".$diseasecode."_total_alerts, ";
		endforeach;
				
		$sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms,formsdata,users,healthfacilities
		WHERE forms.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
		AND forms.id = formsdata.form_id
		AND users.id = forms.user_id
		AND forms.healthfacility_id = healthfacilities.id
		AND forms.draft !=1
		AND forms.country_id = '.$country_id.'
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
		GROUP BY forms.healthfacility_id 
		ORDER BY healthfacilities.health_facility ASC';
		
        
       $query = $this->db->query($sql);
        
       return $query->result();
	   
	      
    }
	
	function get_full_list_gender_age($epicalendar_id,$district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
	{
		$sql = "SELECT forms.week_no,forms.reporting_year,formsdata.epicalendar_id,";
		foreach($diseasearray as $key=>$diseasecode):
		
		$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_under_five end) AS ".$diseasecode."_under_five,
		sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_over_five end) AS ".$diseasecode."_over_five,
		(sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_over_five end)+sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_under_five end)) AS ".$diseasecode."_total_male,
		(sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_over_five end)+sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_under_five end)) AS ".$diseasecode."_total_female,
		";
				
		endforeach;
		$sql .= "forms.zone_id,forms.region_id,forms.district_id 
		FROM forms,formsdata
		WHERE forms.epicalendar_id = ".$epicalendar_id."
		AND forms.id = formsdata.form_id
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
		
		
		$query = $this->db->query($sql);
        
       return $query->result();
		
	}
	
	function get_full_list_week($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
		
		$sql = 'SELECT forms.id, forms.week_no, forms.reporting_year, forms.epicalendar_id,forms.draft,formsdata.form_id, epdcalendar.epdyear,';     
	  	foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_disease end) ".$diseasecode.",
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_under_five end) ".$diseasecode."_M_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_under_five end) ".$diseasecode."_F_U_F,
   sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.male_over_five end) ".$diseasecode."_M_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.female_over_five end) ".$diseasecode."_F_O_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_under_five end) ".$diseasecode."_T_U_F,
  sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_over_five end) ".$diseasecode."_T_O_F,";
		endforeach;
		
		foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "(SELECT COUNT(*)FROM formalerts
    				  WHERE formalerts.disease_name = '".$diseasecode."' AND epdcalendar.id = formalerts.reportingperiod_id
					  AND formalerts.reportingperiod_id BETWEEN '".$from."' AND '".$to."' AND zone_id =". $zone_id." ) AS ".$diseasecode."_total_alerts, ";
		endforeach;
				
		$sql .= 'forms.healthfacility_id,forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms,formsdata,epdcalendar
		WHERE forms.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
		AND forms.id = formsdata.form_id
		AND epdcalendar.id = forms.epicalendar_id
		AND forms.draft !=1
		';
		
		if ($zone_id != 0) {
            $sql .= 'AND forms.zone_id='.$zone_id;
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
		GROUP BY epdcalendar.id 
		ORDER BY epdcalendar.id ASC';
		
        
       $query = $this->db->query($sql);
        
       return $query->result();
	   
	      
    }
	
	function get_full_list_case_single_week($epicalendar_id, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
		
		$sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,';     
	  	foreach($diseasearray as $key=>$diseasecode):
			
			$sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' then formsdata.total_disease end) ".$diseasecode.",";
		endforeach;
		
						
		$sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formsdata
		WHERE forms.id = formsdata.form_id
		AND formsdata.epicalendar_id = '.$epicalendar_id.'		
		AND forms.draft !=1';
		
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
		GROUP BY formsdata.epicalendar_id 
		ORDER BY formsdata.epicalendar_id ASC';
		
        
       $query = $this->db->query($sql);
        
       return $query->result();
	   
	 
	   
	      
    }

    public function get_list_disease_sum($epicalendaridArray = array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasecode)
    {
        $country_id = $this->erkanaauth->getField('country_id');
        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,SUM(formsdata.total_disease) AS Disease_Total,forms.zone_id,forms.region_id,forms.district_id
                FROM forms, formsdata
                WHERE forms.id = formsdata.form_id';

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

        $sql .= ' AND formsdata.epicalendar_id
		IN ( '.$inarray.') ';

        $sql .= 'AND forms.draft !=1
                AND forms.country_id = '.$country_id.'
                AND formsdata.disease_name="'.$diseasecode.'"';
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

        $sql .= ' GROUP BY formsdata.epicalendar_id
                ORDER BY formsdata.epicalendar_id ASC';

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function get_list_category_sum($epicalendaridArray = array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasecategory_id)
    {
        $country_id = $this->erkanaauth->getField('country_id');
        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,SUM(formsdata.total_disease) AS Category_Total,forms.zone_id,forms.region_id,forms.district_id,diseasecategories.id,diseases.*
                FROM forms, formsdata, diseasecategories, diseases
                WHERE forms.id = formsdata.form_id';

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

        $sql .= ' AND formsdata.epicalendar_id
		IN ( '.$inarray.') ';

        $sql .= 'AND forms.draft !=1
                AND forms.country_id = '.$country_id.'
                AND diseasecategories.id = '.$diseasecategory_id.'
                AND formsdata.disease_id = diseases.id
                AND diseasecategories.id = diseases.diseasecategory_id';
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

        $sql .= ' GROUP BY formsdata.epicalendar_id, diseasecategories.id
                ORDER BY formsdata.epicalendar_id ASC';

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function get_list_sum($epicalendar_id, $district_id, $region_id, $zone_id, $healthfacility_id)
    {
        $country_id = $this->erkanaauth->getField('country_id');
        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,SUM(formsdata.total_disease) AS Disease_Total,forms.zone_id,forms.region_id,forms.district_id
                FROM forms, formsdata
                WHERE forms.id = formsdata.form_id';


        $sql .= ' AND formsdata.epicalendar_id = '.$epicalendar_id;

        $sql .= ' AND forms.draft !=1
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

        $sql .= ' GROUP BY formsdata.epicalendar_id
                ORDER BY formsdata.epicalendar_id ASC';

        $query = $this->db->query($sql);

        //return $query->result();
        $ret = $query->row();
        return $ret->Disease_Total;
    }


    function get_full_list_case_epi_week($reporting_year, $reporting_year2, $epicalendaridArray = array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
        $country_id = $this->erkanaauth->getField('country_id');

        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,';
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

        $limit = count($epicalendaridArray);


        $sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formsdata
		WHERE forms.id = formsdata.form_id		
		AND formsdata.epicalendar_id
		IN ( '.$inarray.')
		AND forms.draft !=1
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

        $sql .= ' 
		GROUP BY formsdata.epicalendar_id 
		ORDER BY formsdata.epicalendar_id ASC
		LIMIT '.$limit;


        $query = $this->db->query($sql);

        return $query->result();


    }

    function get_full_list_case_week_array($reporting_year, $reporting_year2,$epicalendaridArray=array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
        $country_id = $this->erkanaauth->getField('country_id');

        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,';
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


        $sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formsdata
		WHERE forms.id = formsdata.form_id
		AND formsdata.epicalendar_id
		IN ( '.$inarray.')		
		AND forms.draft !=1
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

        $sql .= ' 
		GROUP BY formsdata.epicalendar_id 
		ORDER BY formsdata.epicalendar_id ASC';


        $query = $this->db->query($sql);

        return $query->result();


    }


    function get_full_list_case_week($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
		$country_id = $this->erkanaauth->getField('country_id');
		
		$sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,';     
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
		
		FROM forms, formsdata
		WHERE forms.id = formsdata.form_id
		AND formsdata.epicalendar_id BETWEEN "'.$from.'" AND "'.$to.'"		
		AND forms.draft !=1
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
		
		$sql .= ' 
		GROUP BY formsdata.epicalendar_id 
		ORDER BY formsdata.epicalendar_id ASC';
		
        
       $query = $this->db->query($sql);
        
       return $query->result();
	   
	      
    }


    function get_full_list_alert_week_array($reporting_year, $reporting_year2, $epicalendaridArray=array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
        $country_id = $this->erkanaauth->getField('country_id');

        $sql = 'SELECT forms.id, forms.week_no, formalerts.reportingperiod_id,';
        foreach($diseasearray as $key=>$diseasecode):
            $sql .=" COUNT(CASE WHEN formalerts.disease_name =  '".$diseasecode."' THEN formalerts.id END) ".$diseasecode.", ";
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


        $sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formalerts
		WHERE forms.id = formalerts.reportingform_id
		AND formalerts.reportingperiod_id
		IN ( '.$inarray.')	
		AND forms.draft !=1
		AND forms.country_id = '.$country_id.'
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
		GROUP BY formalerts.reportingperiod_id 
		ORDER BY formalerts.reportingperiod_id ASC';


        $query = $this->db->query($sql);

        return $query->result();


    }
	
	function get_full_list_alert_week($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasearray=array())
    {
		$country_id = $this->erkanaauth->getField('country_id');
		
		$sql = 'SELECT forms.id, forms.week_no, formalerts.reportingperiod_id,';     
	  	foreach($diseasearray as $key=>$diseasecode):
			$sql .=" COUNT(CASE WHEN formalerts.disease_name =  '".$diseasecode."' THEN formalerts.id END) ".$diseasecode.", ";
		endforeach;
								
		$sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formalerts
		WHERE forms.id = formalerts.reportingform_id
		AND formalerts.reportingperiod_id BETWEEN "'.$from.'" AND "'.$to.'"		
		AND forms.draft !=1
		AND forms.country_id = '.$country_id.'
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
		GROUP BY formalerts.reportingperiod_id 
		ORDER BY formalerts.reportingperiod_id ASC';
		
        
       $query = $this->db->query($sql);
        
       return $query->result();
	   
	      
    }


    function get_full_zone_week($epicalendar_id, $district_id, $region_id, $zone_id, $healthfacility_id,$diseasecode)
    {
        $country_id = $this->erkanaauth->getField('country_id');

        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,';

        $sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",";

        $sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formsdata
		WHERE forms.id = formsdata.form_id
		AND formsdata.epicalendar_id = '.$epicalendar_id.'		
		AND forms.draft !=1
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

        $sql .= ' 
		GROUP BY formsdata.epicalendar_id 
		ORDER BY formsdata.epicalendar_id ASC';


        $query = $this->db->query($sql);

        //return $query->result();

        $row = $query->row();
        return $row;



    }


    function get_full_list_zone_week($epicalendaridArray=array(), $district_id, $region_id, $zone_id, $healthfacility_id,$diseasecode)
    {
        $country_id = $this->erkanaauth->getField('country_id');

        $sql = 'SELECT forms.id, forms.week_no, forms.reporting_year,formsdata.epicalendar_id,';

        $sql .= "sum(case when formsdata.disease_name = '".$diseasecode."' and formsdata.country_id = ".$country_id." then formsdata.total_disease end) ".$diseasecode.",";

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


        $sql .= ' forms.zone_id,forms.region_id,forms.district_id
		
		FROM forms, formsdata
		WHERE forms.id = formsdata.form_id	
		AND formsdata.epicalendar_id
		IN ( '.$inarray.')	
		AND forms.draft !=1
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

        $sql .= ' 
		GROUP BY formsdata.epicalendar_id 
		ORDER BY formsdata.epicalendar_id ASC';


        $query = $this->db->query($sql);

        return $query->result();

    }


	
    function get_report_records()
    {
        $array = 'array';
        $data  = array();
        $query = $this->db->query('SELECT t1.*,t2.*,t3.*,t4.*,t5.*,t6.contact_number AS User_Contact,t6.*
FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
WHERE t1.healthfacility_id = t5.id	
AND t1.region_id = t3.id	
AND t4.region_id = t3.id
AND t3.zone_id = t2.id
AND t5.district_id = t4.id
AND t1.user_id = t6.id
AND t1.draft !=1
ORDER BY t1.id DESC
');
        
        return $query->result();
    }
}
