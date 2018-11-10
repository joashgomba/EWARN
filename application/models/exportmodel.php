<?php

class Exportmodel extends CI_Model {
	function index(){
	  //return $query = $this->db->get('reportingforms');
	   //Here you should note i am returning 
	   //the query object instead of 
	   //$query->result() or $query->result_array()
	
	   $array='array';
			$data = array();
			$this->db->select('t1.reporting_year AS week_year,t1.week_no,t2.zone AS Zon_name,t3.region AS reg_name,t4.district AS d_name,t5.organization AS org_name,t5.health_facility AS hf_name,t5.health_facility_type AS hft,t5.hf_code AS hfc,(sum(t1.iliufivemale) + sum( 	t1.iliufivefemale)) AS ili_lt_5,(sum(t1.iliofivemale) + sum(t1.iliofivefemale)) AS ili_gt_5,(sum(t1.sariufivemale) + sum(t1.sariufivefemale)) AS sari_lt_5,(sum(t1.sariofivemale) + sum(t1.sariofivefemale)) AS sari_gt_5,(sum(t1.awdufivemale) + sum(t1.awdufivefemale)) AS awd_lt_5,(sum(t1.awdofivemale) + sum(t1.awdofivefemale)) AS awd_gt_5,(sum(t1.bdufivemale) + sum(t1.bdufivefemale)) AS bd_lt_5,(sum(t1.bdofivemale) + sum(t1.bdofivefemale)) AS bd_gt_5,(sum(t1.oadufivemale) + sum(t1.oadufivefemale)) AS oad_lt_5,(sum(t1.oadofivemale) + sum(t1.oadofivefemale)) AS oad_gt_5,(sum(t1.diphmale) + sum(t1.diphfemale)) AS diph,(sum(t1.wcmale) + sum(t1.wcfemale)) AS wc,(sum(t1.measmale) + sum(t1.measfemale)) AS meas,(sum(t1.nntmale) + sum(t1.nntfemale)) AS nnt,(sum(t1.afpmale) + sum(t1.afpfemale)) AS afp,(sum(t1.ajsmale) + sum(t1.ajsfemale)) AS ajs,(sum(t1.vhfmale) + sum(t1.vhffemale)) AS vhf,(sum(t1.malufivemale) + sum(t1.malufivefemale)) AS mal_lt_5,(sum(t1.malofivemale) + sum(t1.malofivefemale)) AS mal_gt_5,(sum(t1.suspectedmenegitismale) + sum(t1.suspectedmenegitisfemale)) AS men, t1.undisonedesc AS unDis_name,(sum(t1.undismale) + sum(t1.undisfemale)) AS unDis_num, t1.undissecdesc AS unDis_name,(sum(t1.undismaletwo) + sum(t1.undisfemaletwo)) AS unDis_num,(sum(t1.ocmale) + sum(t1.ocfemale)) AS oc,t1.total_consultations AS total_cons_disease,t1.sre AS sre, t1.pf AS pf, t1.pv AS pv,t1.pmix AS pmix,t2.zonal_code AS zon_code,t3.regional_code AS reg_code, t4.district_code AS dis_code, t1.entry_date AS Entry_Date, t1.entry_time AS Entry_Time, t6.username AS User_ID, t6.contact_number AS con_number, t1.edit_date AS Edit_Date,t1.edit_time AS Edit_Time')
			  ->from('reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6')
			  ->where('t1.healthfacility_id = t5.id')
			  ->where('t1.region_id = t3.id')
			  ->where('t4.region_id = t3.id')
			  ->where('t3.zone_id = t2.id')
			  ->where('t5.district_id = t4.id')
			  ->where('t1.user_id = t6.id')
			  ->order_by('t1.id DESC');
			  
			return $query = $this->db->get();
			
	}   
	
	
	function get_export_records($region_id,$district_id,$healthfacility_id,$from,$to,$reporting_year,$reporting_year2)
	{
		$sql = 'SELECT t1.*,t2.*,t3.*,t4.*,t5.*,t6.contact_number AS User_Contact,t6.*
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.epdcalendar_id BETWEEN "'.$from.'" AND "'.$to.'"
		AND t1.reporting_year>="'.$reporting_year.'" AND t1.reporting_year <="'.$reporting_year2.'"
		AND t1.healthfacility_id = t5.id	
		AND t1.region_id = t3.id	
		AND t4.region_id = t3.id
		AND t3.zone_id = t2.id
		AND t5.district_id = t4.id
		AND t1.user_id = t6.id
		AND t1.draft !=1 ';
			
		
		if($region_id !=0)
		{
			$sql .='AND t3.id='.$region_id;
		}
		
		if($district_id !=0)
		{
			$sql .=' AND t3.id='.$district_id;
		}
		
		if($healthfacility_id !=0)
		{
			$sql .=' AND t5.id='.$healthfacility_id;
		}
		
		$sql .= ' ORDER BY t1.epdcalendar_id DESC';
		
		$query = $this->db->query($sql);
					  
		return $query->result();
	
	}
	
	function get_report_records()
	{
		  $array='array';
			$data = array();
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
