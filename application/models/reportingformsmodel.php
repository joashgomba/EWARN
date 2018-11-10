<?php

class Reportingformsmodel extends CI_Model
{
    
    private $tbl_roles = 'reportingforms';
    function __construct()
    {
        parent::__construct();
    }
    
    //get all the roles
    
    function get_list()
    {
        
        $data = array();
        
        $Q = $this->db->get('reportingforms');
        
        if ($Q->num_rows() > 0) {
            
            foreach ($Q->result_array() as $row) {
                
                $data[] = $row;
                
            }
            
        }
        
        $Q->free_result();
        
        return $data;
        
    }
    
    function get_combined_list()
    {
        $array = 'array';
        $data  = array();
        //$this->db->select('t1.*,t1.id AS reportingform_id, t2.*')->from('reportingforms AS t1, healthfacilities AS t2')->where('t1.healthfacility_id = t2.id')->where('t1.approved_regional = 0')->order_by('t1.id DESC');
		
		$this->db->select('t1.*,t1.id AS reportingform_id, t2.*')->from('reportingforms AS t1, healthfacilities AS t2')->where('t1.healthfacility_id = t2.id')->order_by('t1.id DESC');
        
        return $this->db->get();
    }
    
    function get_list_by_hf($healthfacility_id)
    {
        
        $data = array();
        $this->db->where('healthfacility_id', $healthfacility_id)->order_by('id DESC')->limit(3);
        $Q = $this->db->get('reportingforms');
        
        
        if ($Q->num_rows() > 0) {
            
            foreach ($Q->result_array() as $row) {
                
                $data[] = $row;
                
            }
            
        }
        
        $Q->free_result();
        
        return $data;
        
    }
    
    function get_by_period_region_list($epdcalendar_id, $region_id, $draft)
    {
        
        $data = array();
        $this->db->where('epdcalendar_id', $epdcalendar_id)->where('region_id', $region_id)->where('draft', $draft);
        $Q = $this->db->get('reportingforms');
        
        if ($Q->num_rows() > 0) {
            
            foreach ($Q->result_array() as $row) {
                
                $data[] = $row;
                
            }
            
        }
        
        $Q->free_result();
        
        return $data;
        
    }
    
    function get_by_period_list($epdcalendar_id, $draft)
    {
        
        $data = array();
        $this->db->where('epdcalendar_id', $epdcalendar_id)
			     ->where('draft', $draft);
        $Q = $this->db->get('reportingforms');
        
        if ($Q->num_rows() > 0) {
            
            foreach ($Q->result_array() as $row) {
                
                $data[] = $row;
                
            }
            
        }
        
        $Q->free_result();
        
        return $data;
        
    }
    
    function get_by_period_hf($epdcalendar_id, $healthfacility_id)
    {
        
        $data = array();
        $this->db->where('epdcalendar_id', $epdcalendar_id)
		         ->where('healthfacility_id', $healthfacility_id);
        $Q = $this->db->get('reportingforms');
        
        if ($Q->num_rows() > 0) {
            
            foreach ($Q->result_array() as $row) {
                
                $data[] = $row;
                
            }
            
        }
        
        $Q->free_result();
        
        return $data;
        
    }
	
	function get_district_list($district_id)
    {
        $array = 'array';
        $data  = array();
        $this->db->select('t1.*,t1.id AS reportingform_id, t2.*')->from('reportingforms AS t1, healthfacilities AS t2')->where('t1.healthfacility_id = t2.id')->where('t2.district_id', $district_id)->order_by('t1.id DESC');
        
        return $this->db->get();
    }
    
    function get_region_list($region_id)
    {
        $array = 'array';
        $data  = array();
        $this->db->select('t1.*,t1.id AS reportingform_id, t2.*')->from('reportingforms AS t1, healthfacilities AS t2')->where('t1.healthfacility_id = t2.id')->where('t1.region_id', $region_id)->order_by('t1.id DESC');
        
        return $this->db->get();
    }
    
    function get_hf_list($healthfacility_id)
    {
        $array = 'array';
        $data  = array();
        $this->db->select('t1.*,t1.id AS reportingform_id, t2.*')->from('reportingforms AS t1, healthfacilities AS t2')->where('t1.healthfacility_id = t2.id')->where('t1.healthfacility_id', $healthfacility_id)->order_by('t1.id DESC');
        
        return $this->db->get();
    }
    
    function get_user_list($user_id)
    {
        $array = 'array';
        $data  = array();
        $this->db->select('t1.*,t1.id AS reportingform_id, t2.*')->from('reportingforms AS t1, healthfacilities AS t2')->where('t1.healthfacility_id = t2.id')->where('t1.user_id', $user_id)->order_by('t1.id DESC');
        
        return $this->db->get();
    }
    
    
    function get_approved_hf_list($approved)
    {
        $array = 'array';
        $data  = array();
        $this->db->select('t1.*,t1.id AS reportingform_id, t2.*')->from('reportingforms AS t1, healthfacilities AS t2')->where('t1.healthfacility_id = t2.id')->where('t1.approved_hf', $approved)->order_by('t1.id DESC');
        
        return $this->db->get();
    }
    
    function get_reporting_hf_by_period_zone($epdcalendar_id, $zone_id)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
			FROM reportingforms, healthfacilities, regions, districts, zones
			WHERE healthfacilities.id = reportingforms.healthfacility_id
			AND reportingforms.epdcalendar_id = ' . $epdcalendar_id . '
			AND reportingforms.draft =0
			AND regions.zone_id = zones.id
			AND districts.region_id = regions.id
			AND healthfacilities.district_id = districts.id
			AND reportingforms.region_id = regions.id
			AND zones.id =' . $zone_id;
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function get_reporting_hf_by_period_region($epdcalendar_id, $region_id)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
			FROM reportingforms, healthfacilities, regions, districts, zones
			WHERE healthfacilities.id = reportingforms.healthfacility_id
			AND reportingforms.epdcalendar_id = ' . $epdcalendar_id . '
			AND reportingforms.draft =0
			AND regions.zone_id = zones.id
			AND districts.region_id = regions.id
			AND healthfacilities.district_id = districts.id
			AND reportingforms.region_id = regions.id
			AND regions.id =' . $region_id;
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function get_reporting_hf_by_period_district($epdcalendar_id, $district_id)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
			FROM reportingforms, healthfacilities, regions, districts, zones
			WHERE healthfacilities.id = reportingforms.healthfacility_id
			AND reportingforms.epdcalendar_id = ' . $epdcalendar_id . '
			AND reportingforms.draft =0
			AND regions.zone_id = zones.id
			AND districts.region_id = regions.id
			AND healthfacilities.district_id = districts.id
			AND reportingforms.region_id = regions.id
			AND districts.id =' . $district_id;
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    function get_reporting_hf_by_period($epdcalendar_id)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.healthfacility_id
		FROM reportingforms, healthfacilities
		WHERE healthfacilities.id = reportingforms.healthfacility_id
		AND reportingforms.epdcalendar_id = ' . $epdcalendar_id . '
		AND reportingforms.draft=0';
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function sum_consultation_by_zone($epdcalendar_id,$zone_id)
	{
		$data = array();
		$sql = 'SELECT DISTINCT healthfacilities.id,(sum(reportingforms.iliufivemale) + sum( 	reportingforms.iliufivefemale)) AS ili_lt_5,(sum(reportingforms.iliofivemale) + sum(reportingforms.iliofivefemale)) AS ili_gt_5,(
sum( reportingforms.sariufivemale ) + sum( reportingforms.sariufivefemale )
) AS sari_lt_5, (
sum( reportingforms.sariofivemale ) + sum( reportingforms.sariofivefemale )
) AS sari_gt_5,(sum(reportingforms.awdufivemale) + sum(reportingforms.awdufivefemale)) AS awd_lt_5,(sum(reportingforms.awdofivemale) + sum(reportingforms.awdofivefemale)) AS awd_gt_5,(sum(reportingforms.bdufivemale) + sum(reportingforms.bdufivefemale)) AS bd_lt_5,(sum(reportingforms.bdofivemale) + sum(reportingforms.bdofivefemale)) AS bd_gt_5,(sum(reportingforms.oadufivemale) + sum(reportingforms.oadufivefemale)) AS oad_lt_5,(sum(reportingforms.oadofivemale) + sum(reportingforms.oadofivefemale)) AS oad_gt_5,(sum(reportingforms.diphmale) + sum(reportingforms.diphfemale)) AS diph,(sum(reportingforms.wcmale) + sum(reportingforms.wcfemale)) AS wc,(sum(reportingforms.measmale) + sum(reportingforms.measfemale)) AS meas,(sum(reportingforms.nntmale) + sum(reportingforms.nntfemale)) AS nnt,(sum(reportingforms.afpmale) + sum(reportingforms.afpfemale)) AS afp,(sum(reportingforms.ajsmale) + sum(reportingforms.ajsfemale)) AS ajs,(sum(reportingforms.vhfmale) + sum(reportingforms.vhffemale)) AS vhf,(sum(reportingforms.malufivemale) + sum(reportingforms.malufivefemale)) AS mal_lt_5,(sum(reportingforms.malofivemale) + sum(reportingforms.malofivefemale)) AS mal_gt_5,(sum(reportingforms.suspectedmenegitismale) + sum(reportingforms.suspectedmenegitisfemale)) AS men, reportingforms.undisonedesc AS unDis_name,(sum(reportingforms.undismale) + sum(reportingforms.undisfemale)) AS unDis_num, reportingforms.undissecdesc AS unDis_name,(sum(reportingforms.undismaletwo) + sum(reportingforms.undisfemaletwo)) AS unDis_num,(sum(reportingforms.ocmale) + sum(reportingforms.ocfemale)) AS oc, SUM(reportingforms.total_consultations) AS Cons, SUM(reportingforms.sre) AS toSre, SUM(reportingforms.pf) AS toPf, SUM(reportingforms.pv) AS toPv, SUM(reportingforms.pmix) AS toPmix, SUM(reportingforms.total_positive) AS toPos, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND zones.id =' . $zone_id;
        
        $query = $this->db->query($sql);
		
		foreach ($query->result_array() as $row){

		       $sari_ztotal = $row['sari_lt_5'] + $row['sari_gt_5'];
                    $ili_ztotal  = $row['ili_lt_5'] + $row['ili_gt_5'];
                    $awd_ztotal  = $row['awd_lt_5'] + $row['awd_gt_5'];
                    $bd_ztotal   = $row['bd_lt_5'] + $row['bd_gt_5'];
                    $oad_ztotal  = $row['oad_lt_5'] + $row['oad_gt_5'];
                    $diph_ztotal = $row['diph'];
                    $wc_ztotal   = $row['wc'];
                    $meas_ztotal = $row['meas'];
                    $nnt_ztotal  = $row['nnt'];
                    $afp_ztotal  = $row['afp'];
                    $ajs_ztotal  = $row['ajs'];
                    $vhf_ztotal  = $row['vhf'];
                    $mal_ztotal  = $row['mal_lt_5'] + $row['mal_gt_5'];
                    $men_ztotal  = $row['men'];
					$oc_ztotal  = $row['oc'];
					
					$zonaldiseasesconsulted = array(
                       'SARI' => $sari_ztotal,
                        'ILI' => $ili_ztotal,
                        'AWD' => $awd_ztotal,
                        'BD' => $bd_ztotal,
                        'OAD' => $oad_ztotal,
                        'Diph' => $diph_ztotal,
                        'WC' => $wc_ztotal,
                        'Meas' => $meas_ztotal,
                        'NNT' => $nnt_ztotal,
                        'AFP' => $afp_ztotal,
                        'AJS' => $ajs_ztotal,
                        'VHF' => $vhf_ztotal,
                        'Mal' => $mal_ztotal,
                        'Men' => $men_ztotal,
						'Oc' => $oc_ztotal
                    );

		 }
			   
	   $totalconsultations = array_sum($zonaldiseasesconsulted);
	   
	   return $totalconsultations;
	}
	
	function sum_consultation_by_region($epdcalendar_id,$region_id)
	{
		$data = array();
		$sql = 'SELECT DISTINCT healthfacilities.id,(sum(reportingforms.iliufivemale) + sum( 	reportingforms.iliufivefemale)) AS ili_lt_5,(sum(reportingforms.iliofivemale) + sum(reportingforms.iliofivefemale)) AS ili_gt_5,(
sum( reportingforms.sariufivemale ) + sum( reportingforms.sariufivefemale )
) AS sari_lt_5, (
sum( reportingforms.sariofivemale ) + sum( reportingforms.sariofivefemale )
) AS sari_gt_5,(sum(reportingforms.awdufivemale) + sum(reportingforms.awdufivefemale)) AS awd_lt_5,(sum(reportingforms.awdofivemale) + sum(reportingforms.awdofivefemale)) AS awd_gt_5,(sum(reportingforms.bdufivemale) + sum(reportingforms.bdufivefemale)) AS bd_lt_5,(sum(reportingforms.bdofivemale) + sum(reportingforms.bdofivefemale)) AS bd_gt_5,(sum(reportingforms.oadufivemale) + sum(reportingforms.oadufivefemale)) AS oad_lt_5,(sum(reportingforms.oadofivemale) + sum(reportingforms.oadofivefemale)) AS oad_gt_5,(sum(reportingforms.diphmale) + sum(reportingforms.diphfemale)) AS diph,(sum(reportingforms.wcmale) + sum(reportingforms.wcfemale)) AS wc,(sum(reportingforms.measmale) + sum(reportingforms.measfemale)) AS meas,(sum(reportingforms.nntmale) + sum(reportingforms.nntfemale)) AS nnt,(sum(reportingforms.afpmale) + sum(reportingforms.afpfemale)) AS afp,(sum(reportingforms.ajsmale) + sum(reportingforms.ajsfemale)) AS ajs,(sum(reportingforms.vhfmale) + sum(reportingforms.vhffemale)) AS vhf,(sum(reportingforms.malufivemale) + sum(reportingforms.malufivefemale)) AS mal_lt_5,(sum(reportingforms.malofivemale) + sum(reportingforms.malofivefemale)) AS mal_gt_5,(sum(reportingforms.suspectedmenegitismale) + sum(reportingforms.suspectedmenegitisfemale)) AS men, reportingforms.undisonedesc AS unDis_name,(sum(reportingforms.undismale) + sum(reportingforms.undisfemale)) AS unDis_num, reportingforms.undissecdesc AS unDis_name,(sum(reportingforms.undismaletwo) + sum(reportingforms.undisfemaletwo)) AS unDis_num,(sum(reportingforms.ocmale) + sum(reportingforms.ocfemale)) AS oc, SUM(reportingforms.total_consultations) AS Cons, SUM(reportingforms.sre) AS toSre, SUM(reportingforms.pf) AS toPf, SUM(reportingforms.pv) AS toPv, SUM(reportingforms.pmix) AS toPmix, SUM(reportingforms.total_positive) AS toPos, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND regions.id =' . $region_id;
        
        $query = $this->db->query($sql);
		
		foreach ($query->result_array() as $row){

		       $sari_ztotal = $row['sari_lt_5'] + $row['sari_gt_5'];
                    $ili_ztotal  = $row['ili_lt_5'] + $row['ili_gt_5'];
                    $awd_ztotal  = $row['awd_lt_5'] + $row['awd_gt_5'];
                    $bd_ztotal   = $row['bd_lt_5'] + $row['bd_gt_5'];
                    $oad_ztotal  = $row['oad_lt_5'] + $row['oad_gt_5'];
                    $diph_ztotal = $row['diph'];
                    $wc_ztotal   = $row['wc'];
                    $meas_ztotal = $row['meas'];
                    $nnt_ztotal  = $row['nnt'];
                    $afp_ztotal  = $row['afp'];
                    $ajs_ztotal  = $row['ajs'];
                    $vhf_ztotal  = $row['vhf'];
                    $mal_ztotal  = $row['mal_lt_5'] + $row['mal_gt_5'];
                    $men_ztotal  = $row['men'];
					$oc_ztotal  = $row['oc'];
					
					$zonaldiseasesconsulted = array(
                       'SARI' => $sari_ztotal,
                        'ILI' => $ili_ztotal,
                        'AWD' => $awd_ztotal,
                        'BD' => $bd_ztotal,
                        'OAD' => $oad_ztotal,
                        'Diph' => $diph_ztotal,
                        'WC' => $wc_ztotal,
                        'Meas' => $meas_ztotal,
                        'NNT' => $nnt_ztotal,
                        'AFP' => $afp_ztotal,
                        'AJS' => $ajs_ztotal,
                        'VHF' => $vhf_ztotal,
                        'Mal' => $mal_ztotal,
                        'Men' => $men_ztotal,
						'Oc' => $oc_ztotal
                    );

		 }
			   
	   $totalconsultations = array_sum($zonaldiseasesconsulted);
	   
	   return $totalconsultations;
	}
    
		
    function sum_total_consultations($epdcalendar_id)
    {
        $sql = 'SELECT SUM( total_consultations ) AS Consultations
		FROM reportingforms
		WHERE epdcalendar_id =' . $epdcalendar_id . '
		AND draft =0';
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function disease_sum_period($epdcalendar_id)
    {
		$sql = 'SELECT DISTINCT healthfacilities.id,(sum(reportingforms.iliufivemale) + sum(reportingforms.iliufivefemale)) AS ili_lt_5,(sum(reportingforms.iliofivemale) + sum(reportingforms.iliofivefemale)) AS ili_gt_5,(sum( reportingforms.sariufivemale ) + sum( reportingforms.sariufivefemale )
) AS sari_lt_5, (sum( reportingforms.sariofivemale ) + sum( reportingforms.sariofivefemale )
) AS sari_gt_5,(sum(reportingforms.awdufivemale) + sum(reportingforms.awdufivefemale)) AS awd_lt_5,(sum(reportingforms.awdofivemale) + sum(reportingforms.awdofivefemale)) AS awd_gt_5,(sum(reportingforms.bdufivemale) + sum(reportingforms.bdufivefemale)) AS bd_lt_5,(sum(reportingforms.bdofivemale) + sum(reportingforms.bdofivefemale)) AS bd_gt_5,(sum(reportingforms.oadufivemale) + sum(reportingforms.oadufivefemale)) AS oad_lt_5,(sum(reportingforms.oadofivemale) + sum(reportingforms.oadofivefemale)) AS oad_gt_5,(sum(reportingforms.diphmale) + sum(reportingforms.diphfemale)) AS diph,(sum(reportingforms.wcmale) + sum(reportingforms.wcfemale)) AS wc,(sum(reportingforms.measmale) + sum(reportingforms.measfemale)) AS meas,(sum(reportingforms.nntmale) + sum(reportingforms.nntfemale)) AS nnt,(sum(reportingforms.afpmale) + sum(reportingforms.afpfemale)) AS afp,(sum(reportingforms.ajsmale) + sum(reportingforms.ajsfemale)) AS ajs,(sum(reportingforms.vhfmale) + sum(reportingforms.vhffemale)) AS vhf,(sum(reportingforms.malufivemale) + sum(reportingforms.malufivefemale)) AS mal_lt_5,(sum(reportingforms.malofivemale) + sum(reportingforms.malofivefemale)) AS mal_gt_5,(sum(reportingforms.suspectedmenegitismale) + sum(reportingforms.suspectedmenegitisfemale)) AS men, reportingforms.undisonedesc AS unDis_name,(sum(reportingforms.undismale) + sum(reportingforms.undisfemale)) AS unDis_num, reportingforms.undissecdesc AS unDis_name,(sum(reportingforms.undismaletwo) + sum(reportingforms.undisfemaletwo)) AS unDis_num,(sum(reportingforms.ocmale) + sum(reportingforms.ocfemale)) AS oc, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
';

		$query = $this->db->query($sql);
        
        return $query->result();
	}
    
    function sum_diseases_by_period_zone($epdcalendar_id, $zone_id)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id,(sum(reportingforms.iliufivemale) + sum( 	reportingforms.iliufivefemale)) AS ili_lt_5,(sum(reportingforms.iliofivemale) + sum(reportingforms.iliofivefemale)) AS ili_gt_5,(
sum( reportingforms.sariufivemale ) + sum( reportingforms.sariufivefemale )
) AS sari_lt_5, (
sum( reportingforms.sariofivemale ) + sum( reportingforms.sariofivefemale )
) AS sari_gt_5,(sum(reportingforms.awdufivemale) + sum(reportingforms.awdufivefemale)) AS awd_lt_5,(sum(reportingforms.awdofivemale) + sum(reportingforms.awdofivefemale)) AS awd_gt_5,(sum(reportingforms.bdufivemale) + sum(reportingforms.bdufivefemale)) AS bd_lt_5,(sum(reportingforms.bdofivemale) + sum(reportingforms.bdofivefemale)) AS bd_gt_5,(sum(reportingforms.oadufivemale) + sum(reportingforms.oadufivefemale)) AS oad_lt_5,(sum(reportingforms.oadofivemale) + sum(reportingforms.oadofivefemale)) AS oad_gt_5,(sum(reportingforms.diphmale) + sum(reportingforms.diphfemale)) AS diph,(sum(reportingforms.wcmale) + sum(reportingforms.wcfemale)) AS wc,(sum(reportingforms.measmale) + sum(reportingforms.measfemale)) AS meas,(sum(reportingforms.nntmale) + sum(reportingforms.nntfemale)) AS nnt,(sum(reportingforms.afpmale) + sum(reportingforms.afpfemale)) AS afp,(sum(reportingforms.ajsmale) + sum(reportingforms.ajsfemale)) AS ajs,(sum(reportingforms.vhfmale) + sum(reportingforms.vhffemale)) AS vhf,(sum(reportingforms.malufivemale) + sum(reportingforms.malufivefemale)) AS mal_lt_5,(sum(reportingforms.malofivemale) + sum(reportingforms.malofivefemale)) AS mal_gt_5,(sum(reportingforms.suspectedmenegitismale) + sum(reportingforms.suspectedmenegitisfemale)) AS men, reportingforms.undisonedesc AS unDis_name,(sum(reportingforms.undismale) + sum(reportingforms.undisfemale)) AS unDis_num, reportingforms.undissecdesc AS unDis_name,(sum(reportingforms.undismaletwo) + sum(reportingforms.undisfemaletwo)) AS unDis_num,(sum(reportingforms.ocmale) + sum(reportingforms.ocfemale)) AS oc, SUM(reportingforms.total_consultations) AS Cons, SUM(reportingforms.sre) AS toSre, SUM(reportingforms.pf) AS toPf, SUM(reportingforms.pv) AS toPv, SUM(reportingforms.pmix) AS toPmix, SUM(reportingforms.total_positive) AS toPos, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND zones.id =' . $zone_id;
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function sum_diseases_by_period_region_field($epdcalendar_id, $region_id, $field)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id,(sum(reportingforms.iliufivemale) + sum( 	reportingforms.iliufivefemale)) AS ili_lt_5,(sum(reportingforms.iliofivemale) + sum(reportingforms.iliofivefemale)) AS ili_gt_5,(
sum( reportingforms.sariufivemale ) + sum( reportingforms.sariufivefemale )
) AS sari_lt_5, (
sum( reportingforms.sariofivemale ) + sum( reportingforms.sariofivefemale )
) AS sari_gt_5,(sum(reportingforms.awdufivemale) + sum(reportingforms.awdufivefemale)) AS awd_lt_5,(sum(reportingforms.awdofivemale) + sum(reportingforms.awdofivefemale)) AS awd_gt_5,(sum(reportingforms.bdufivemale) + sum(reportingforms.bdufivefemale)) AS bd_lt_5,(sum(reportingforms.bdofivemale) + sum(reportingforms.bdofivefemale)) AS bd_gt_5,(sum(reportingforms.oadufivemale) + sum(reportingforms.oadufivefemale)) AS oad_lt_5,(sum(reportingforms.oadofivemale) + sum(reportingforms.oadofivefemale)) AS oad_gt_5,(sum(reportingforms.diphmale) + sum(reportingforms.diphfemale)) AS diph,(sum(reportingforms.wcmale) + sum(reportingforms.wcfemale)) AS wc,(sum(reportingforms.measmale) + sum(reportingforms.measfemale)) AS meas,(sum(reportingforms.nntmale) + sum(reportingforms.nntfemale)) AS nnt,(sum(reportingforms.afpmale) + sum(reportingforms.afpfemale)) AS afp,(sum(reportingforms.ajsmale) + sum(reportingforms.ajsfemale)) AS ajs,(sum(reportingforms.vhfmale) + sum(reportingforms.vhffemale)) AS vhf,(sum(reportingforms.malufivemale) + sum(reportingforms.malufivefemale)) AS mal_lt_5,(sum(reportingforms.malofivemale) + sum(reportingforms.malofivefemale)) AS mal_gt_5,(sum(reportingforms.suspectedmenegitismale) + sum(reportingforms.suspectedmenegitisfemale)) AS men, reportingforms.undisonedesc AS unDis_name,(sum(reportingforms.undismale) + sum(reportingforms.undisfemale)) AS unDis_num, reportingforms.undissecdesc AS unDis_name,(sum(reportingforms.undismaletwo) + sum(reportingforms.undisfemaletwo)) AS unDis_num,(sum(reportingforms.ocmale) + sum(reportingforms.ocfemale)) AS oc, SUM(reportingforms.total_consultations) AS Cons, SUM(reportingforms.sre) AS toSre, SUM(reportingforms.pf) AS toPf, SUM(reportingforms.pv) AS toPv, SUM(reportingforms.pmix) AS toPmix, SUM(reportingforms.total_positive) AS toPos, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND regions.id =' . $region_id;
        
        $query = $this->db->query($sql);
        
        foreach ($query->result_array() as $row){
			    $mal_tot  = $row['mal_lt_5'] + $row['mal_gt_5'];
					$sre_tot = $row['toSre'];
					$pf_tot = $row['toPf'];
					$pv_tot = $row['toPv'];
					$pmix_tot = $row['toPmix'];
					$total_pos = $row['toPos'];
					
					$totslidesone = $row['toPv'] + $row['toPmix'] + $row['toPf'];
					$srtot = $row['toSre'];
					
					if($totslidesone==0)
					{
						$spr_one = 0;
						$fr_one = 0;
					}
					else
					{
					
						$spr_one = ($totslidesone/$srtot) * 100;
						$fr_one = ($row['toPf']/$totslidesone) * 100;
					}
					

		 }
		 
		 if($field=='Pf')
		 {
			 return $pf_tot;
		 }
		 
		 if($field=='Pv')
		 {
			 return $pv_tot;
		 }
		 
		 if($field=='Mixed')
		 {
			 return $pmix_tot;
		 }
		 
		 if($field=='SPR')
		 {
			 return $spr_one;
		 }
		 
		 if($field=='FR')
		 {
			 return $fr_one;
		 }
		 
		 if($field=='PSL')
		 {
			 return $total_pos;
		 }
		 
		 if($field=='TST')
		 {
			 return $totslidesone;
		 }
		 
		 if($field=='CS')
		 {
			 return $mal_tot;
		 }
    }
	
	function sum_diseases_by_period_district_field($epdcalendar_id, $district_id, $field)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id,(sum(reportingforms.iliufivemale) + sum( 	reportingforms.iliufivefemale)) AS ili_lt_5,(sum(reportingforms.iliofivemale) + sum(reportingforms.iliofivefemale)) AS ili_gt_5,(
sum( reportingforms.sariufivemale ) + sum( reportingforms.sariufivefemale )
) AS sari_lt_5, (
sum( reportingforms.sariofivemale ) + sum( reportingforms.sariofivefemale )
) AS sari_gt_5,(sum(reportingforms.awdufivemale) + sum(reportingforms.awdufivefemale)) AS awd_lt_5,(sum(reportingforms.awdofivemale) + sum(reportingforms.awdofivefemale)) AS awd_gt_5,(sum(reportingforms.bdufivemale) + sum(reportingforms.bdufivefemale)) AS bd_lt_5,(sum(reportingforms.bdofivemale) + sum(reportingforms.bdofivefemale)) AS bd_gt_5,(sum(reportingforms.oadufivemale) + sum(reportingforms.oadufivefemale)) AS oad_lt_5,(sum(reportingforms.oadofivemale) + sum(reportingforms.oadofivefemale)) AS oad_gt_5,(sum(reportingforms.diphmale) + sum(reportingforms.diphfemale)) AS diph,(sum(reportingforms.wcmale) + sum(reportingforms.wcfemale)) AS wc,(sum(reportingforms.measmale) + sum(reportingforms.measfemale)) AS meas,(sum(reportingforms.nntmale) + sum(reportingforms.nntfemale)) AS nnt,(sum(reportingforms.afpmale) + sum(reportingforms.afpfemale)) AS afp,(sum(reportingforms.ajsmale) + sum(reportingforms.ajsfemale)) AS ajs,(sum(reportingforms.vhfmale) + sum(reportingforms.vhffemale)) AS vhf,(sum(reportingforms.malufivemale) + sum(reportingforms.malufivefemale)) AS mal_lt_5,(sum(reportingforms.malofivemale) + sum(reportingforms.malofivefemale)) AS mal_gt_5,(sum(reportingforms.suspectedmenegitismale) + sum(reportingforms.suspectedmenegitisfemale)) AS men, reportingforms.undisonedesc AS unDis_name,(sum(reportingforms.undismale) + sum(reportingforms.undisfemale)) AS unDis_num, reportingforms.undissecdesc AS unDis_name,(sum(reportingforms.undismaletwo) + sum(reportingforms.undisfemaletwo)) AS unDis_num,(sum(reportingforms.ocmale) + sum(reportingforms.ocfemale)) AS oc, SUM(reportingforms.total_consultations) AS Cons, SUM(reportingforms.sre) AS toSre, SUM(reportingforms.pf) AS toPf, SUM(reportingforms.pv) AS toPv, SUM(reportingforms.pmix) AS toPmix, SUM(reportingforms.total_positive) AS toPos, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND districts.id =' . $district_id;
        
        $query = $this->db->query($sql);
        
        foreach ($query->result_array() as $row){
			    $mal_tot  = $row['mal_lt_5'] + $row['mal_gt_5'];
					$sre_tot = $row['toSre'];
					$pf_tot = $row['toPf'];
					$pv_tot = $row['toPv'];
					$pmix_tot = $row['toPmix'];
					$total_pos = $row['toPos'];
					
					$totslidesone = $row['toPv'] + $row['toPmix'] + $row['toPf'];
					$srtot = $row['toSre'];
					
					if($totslidesone==0)
					{
						$spr_one = 0;
						$fr_one = 0;
					}
					else
					{
					
						$spr_one = ($totslidesone/$srtot) * 100;
						$fr_one = ($row['toPf']/$totslidesone) * 100;
					}
					

		 }
		 
		 if($field=='Pf')
		 {
			 return $pf_tot;
		 }
		 
		 if($field=='Pv')
		 {
			 return $pv_tot;
		 }
		 
		 if($field=='Mixed')
		 {
			 return $pmix_tot;
		 }
		 
		 if($field=='SPR')
		 {
			 return $spr_one;
		 }
		 
		 if($field=='FR')
		 {
			 return $fr_one;
		 }
		 
		 if($field=='PSL')
		 {
			 return $total_pos;
		 }
		 
		 if($field=='TST')
		 {
			 return $totslidesone;
		 }
		 
		 if($field=='CS')
		 {
			 return $mal_tot;
		 }
    }
	
	function sum_diseases_by_period_region($epdcalendar_id, $region_id)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id,(sum(reportingforms.iliufivemale) + sum( 	reportingforms.iliufivefemale)) AS ili_lt_5,(sum(reportingforms.iliofivemale) + sum(reportingforms.iliofivefemale)) AS ili_gt_5,(
sum( reportingforms.sariufivemale ) + sum( reportingforms.sariufivefemale )
) AS sari_lt_5, (
sum( reportingforms.sariofivemale ) + sum( reportingforms.sariofivefemale )
) AS sari_gt_5,(sum(reportingforms.awdufivemale) + sum(reportingforms.awdufivefemale)) AS awd_lt_5,(sum(reportingforms.awdofivemale) + sum(reportingforms.awdofivefemale)) AS awd_gt_5,(sum(reportingforms.bdufivemale) + sum(reportingforms.bdufivefemale)) AS bd_lt_5,(sum(reportingforms.bdofivemale) + sum(reportingforms.bdofivefemale)) AS bd_gt_5,(sum(reportingforms.oadufivemale) + sum(reportingforms.oadufivefemale)) AS oad_lt_5,(sum(reportingforms.oadofivemale) + sum(reportingforms.oadofivefemale)) AS oad_gt_5,(sum(reportingforms.diphmale) + sum(reportingforms.diphfemale)) AS diph,(sum(reportingforms.wcmale) + sum(reportingforms.wcfemale)) AS wc,(sum(reportingforms.measmale) + sum(reportingforms.measfemale)) AS meas,(sum(reportingforms.nntmale) + sum(reportingforms.nntfemale)) AS nnt,(sum(reportingforms.afpmale) + sum(reportingforms.afpfemale)) AS afp,(sum(reportingforms.ajsmale) + sum(reportingforms.ajsfemale)) AS ajs,(sum(reportingforms.vhfmale) + sum(reportingforms.vhffemale)) AS vhf,(sum(reportingforms.malufivemale) + sum(reportingforms.malufivefemale)) AS mal_lt_5,(sum(reportingforms.malofivemale) + sum(reportingforms.malofivefemale)) AS mal_gt_5,(sum(reportingforms.suspectedmenegitismale) + sum(reportingforms.suspectedmenegitisfemale)) AS men, reportingforms.undisonedesc AS unDis_name,(sum(reportingforms.undismale) + sum(reportingforms.undisfemale)) AS unDis_num, reportingforms.undissecdesc AS unDis_name,(sum(reportingforms.undismaletwo) + sum(reportingforms.undisfemaletwo)) AS unDis_num,(sum(reportingforms.ocmale) + sum(reportingforms.ocfemale)) AS oc, SUM(reportingforms.total_consultations) AS Cons, SUM(reportingforms.sre) AS toSre, SUM(reportingforms.pf) AS toPf, SUM(reportingforms.pv) AS toPv, SUM(reportingforms.pmix) AS toPmix, SUM(reportingforms.total_positive) AS toPos, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND regions.id =' . $region_id;
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function sum_diseases_by_period_district($epdcalendar_id, $district_id)
    {
        $sql = 'SELECT DISTINCT healthfacilities.id,(sum(reportingforms.iliufivemale) + sum( 	reportingforms.iliufivefemale)) AS ili_lt_5,(sum(reportingforms.iliofivemale) + sum(reportingforms.iliofivefemale)) AS ili_gt_5,(
sum( reportingforms.sariufivemale ) + sum( reportingforms.sariufivefemale )
) AS sari_lt_5, (
sum( reportingforms.sariofivemale ) + sum( reportingforms.sariofivefemale )
) AS sari_gt_5,(sum(reportingforms.awdufivemale) + sum(reportingforms.awdufivefemale)) AS awd_lt_5,(sum(reportingforms.awdofivemale) + sum(reportingforms.awdofivefemale)) AS awd_gt_5,(sum(reportingforms.bdufivemale) + sum(reportingforms.bdufivefemale)) AS bd_lt_5,(sum(reportingforms.bdofivemale) + sum(reportingforms.bdofivefemale)) AS bd_gt_5,(sum(reportingforms.oadufivemale) + sum(reportingforms.oadufivefemale)) AS oad_lt_5,(sum(reportingforms.oadofivemale) + sum(reportingforms.oadofivefemale)) AS oad_gt_5,(sum(reportingforms.diphmale) + sum(reportingforms.diphfemale)) AS diph,(sum(reportingforms.wcmale) + sum(reportingforms.wcfemale)) AS wc,(sum(reportingforms.measmale) + sum(reportingforms.measfemale)) AS meas,(sum(reportingforms.nntmale) + sum(reportingforms.nntfemale)) AS nnt,(sum(reportingforms.afpmale) + sum(reportingforms.afpfemale)) AS afp,(sum(reportingforms.ajsmale) + sum(reportingforms.ajsfemale)) AS ajs,(sum(reportingforms.vhfmale) + sum(reportingforms.vhffemale)) AS vhf,(sum(reportingforms.malufivemale) + sum(reportingforms.malufivefemale)) AS mal_lt_5,(sum(reportingforms.malofivemale) + sum(reportingforms.malofivefemale)) AS mal_gt_5,(sum(reportingforms.suspectedmenegitismale) + sum(reportingforms.suspectedmenegitisfemale)) AS men, reportingforms.undisonedesc AS unDis_name,(sum(reportingforms.undismale) + sum(reportingforms.undisfemale)) AS unDis_num, reportingforms.undissecdesc AS unDis_name,(sum(reportingforms.undismaletwo) + sum(reportingforms.undisfemaletwo)) AS unDis_num,(sum(reportingforms.ocmale) + sum(reportingforms.ocfemale)) AS oc, SUM(reportingforms.total_consultations) AS Cons, SUM(reportingforms.sre) AS toSre, SUM(reportingforms.pf) AS toPf, SUM(reportingforms.pv) AS toPv, SUM(reportingforms.pmix) AS toPmix, SUM(reportingforms.total_positive) AS toPos, reportingforms.healthfacility_id, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND districts.id =' . $district_id;
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function sum_diseases_by_age_period($epdcalendar_id)
    {
			$sql = 'SELECT t1.reporting_year AS week_year,t1.week_no,sum(t1.iliufivemale) AS ili_lt_male, sum(t1.iliufivefemale) AS ili_lt_female,sum(t1.iliofivemale) AS ili_gt_male, sum(t1.iliofivefemale) AS ili_gt_female,sum(t1.awdufivemale) AS awd_lt_male, sum(t1.awdufivefemale) AS awd_lt_female,sum(t1.awdofivemale) AS awd_gt_male, sum(t1.awdofivefemale) AS awd_gt_female,sum(t1.bdufivemale) AS bd_lt_male, sum(t1.bdufivefemale) AS bd_lt_female,sum(t1.bdofivemale) AS bd_gt_male, sum(t1.bdofivefemale) AS bd_gt_female,sum(t1.oadufivemale) AS oad_lt_male, sum(t1.oadufivefemale) AS oad_lt_female,sum(t1.oadofivemale) AS oad_gt_male, sum(t1.oadofivefemale) AS oad_gt_female,sum(t1.malufivemale) AS mal_lt_male, sum(t1.malufivefemale) AS mal_lt_female,sum(t1.malofivemale) AS mal_gt_male, sum(t1.malofivefemale) AS mal_gt_female
	FROM reportingforms AS t1
	WHERE epdcalendar_id = '.$epdcalendar_id.'
	AND draft=0';
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function sum_diseases_by_age_period_zone($epdcalendar_id,$zone_id)
    {
			$sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.reporting_year AS week_year,reportingforms.week_no,sum(reportingforms.iliufivemale) AS ili_lt_male, sum(reportingforms.iliufivefemale) AS ili_lt_female,sum(reportingforms.iliofivemale) AS ili_gt_male, sum(reportingforms.iliofivefemale) AS ili_gt_female,sum(reportingforms.awdufivemale) AS awd_lt_male, sum(reportingforms.awdufivefemale) AS awd_lt_female,sum(reportingforms.awdofivemale) AS awd_gt_male, sum(reportingforms.awdofivefemale) AS awd_gt_female,sum(reportingforms.bdufivemale) AS bd_lt_male, sum(reportingforms.bdufivefemale) AS bd_lt_female,sum(reportingforms.bdofivemale) AS bd_gt_male, sum(reportingforms.bdofivefemale) AS bd_gt_female,sum(reportingforms.oadufivemale) AS oad_lt_male, sum(reportingforms.oadufivefemale) AS oad_lt_female,sum(reportingforms.oadofivemale) AS oad_gt_male, sum(reportingforms.oadofivefemale) AS oad_gt_female,sum(reportingforms.malufivemale) AS mal_lt_male, sum(reportingforms.malufivefemale) AS mal_lt_female,sum(reportingforms.malofivemale) AS mal_gt_male, sum(reportingforms.malofivefemale) AS mal_gt_female, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND zones.id =' . $zone_id;
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
	
	function sum_diseases_by_age_period_region($epdcalendar_id,$region_id)
    {
			$sql = 'SELECT DISTINCT healthfacilities.id, reportingforms.reporting_year AS week_year,reportingforms.week_no,sum(reportingforms.iliufivemale) AS ili_lt_male, sum(reportingforms.iliufivefemale) AS ili_lt_female,sum(reportingforms.iliofivemale) AS ili_gt_male, sum(reportingforms.iliofivefemale) AS ili_gt_female,sum(reportingforms.awdufivemale) AS awd_lt_male, sum(reportingforms.awdufivefemale) AS awd_lt_female,sum(reportingforms.awdofivemale) AS awd_gt_male, sum(reportingforms.awdofivefemale) AS awd_gt_female,sum(reportingforms.bdufivemale) AS bd_lt_male, sum(reportingforms.bdufivefemale) AS bd_lt_female,sum(reportingforms.bdofivemale) AS bd_gt_male, sum(reportingforms.bdofivefemale) AS bd_gt_female,sum(reportingforms.oadufivemale) AS oad_lt_male, sum(reportingforms.oadufivefemale) AS oad_lt_female,sum(reportingforms.oadofivemale) AS oad_gt_male, sum(reportingforms.oadofivefemale) AS oad_gt_female,sum(reportingforms.malufivemale) AS mal_lt_male, sum(reportingforms.malufivefemale) AS mal_lt_female,sum(reportingforms.malofivemale) AS mal_gt_male, sum(reportingforms.malofivefemale) AS mal_gt_female, regions. * , districts. * , zones. *
FROM reportingforms, healthfacilities, regions, districts, zones
WHERE healthfacilities.id = reportingforms.healthfacility_id
AND reportingforms.epdcalendar_id ='.$epdcalendar_id.'
AND reportingforms.draft =0
AND regions.zone_id = zones.id
AND districts.region_id = regions.id
AND healthfacilities.district_id = districts.id
AND reportingforms.region_id = regions.id
AND regions.id =' . $region_id;
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    function sum_diseases_by_period($epdcalendar_id)
    {
        $sql = 'SELECT t1.reporting_year AS week_year,t1.week_no,(sum(t1.iliufivemale) + sum( 	t1.iliufivefemale)) AS ili_lt_5,(sum(t1.iliofivemale) + sum(t1.iliofivefemale)) AS ili_gt_5,(sum(t1.sariufivemale) + sum(t1.sariufivefemale)) AS sari_lt_5,(sum(t1.sariofivemale) + sum(t1.sariofivefemale)) AS sari_gt_5,(sum(t1.awdufivemale) + sum(t1.awdufivefemale)) AS awd_lt_5,(sum(t1.awdofivemale) + sum(t1.awdofivefemale)) AS awd_gt_5,(sum(t1.bdufivemale) + sum(t1.bdufivefemale)) AS bd_lt_5,(sum(t1.bdofivemale) + sum(t1.bdofivefemale)) AS bd_gt_5,(sum(t1.oadufivemale) + sum(t1.oadufivefemale)) AS oad_lt_5,(sum(t1.oadofivemale) + sum(t1.oadofivefemale)) AS oad_gt_5,(sum(t1.diphmale) + sum(t1.diphfemale)) AS diph,(sum(t1.wcmale) + sum(t1.wcfemale)) AS wc,(sum(t1.measmale) + sum(t1.measfemale)) AS meas,(sum(t1.nntmale) + sum(t1.nntfemale)) AS nnt,(sum(t1.afpmale) + sum(t1.afpfemale)) AS afp,(sum(t1.ajsmale) + sum(t1.ajsfemale)) AS ajs,(sum(t1.vhfmale) + sum(t1.vhffemale)) AS vhf,(sum(t1.malufivemale) + sum(t1.malufivefemale)) AS mal_lt_5,(sum(t1.malofivemale) + sum(t1.malofivefemale)) AS mal_gt_5,(sum(t1.suspectedmenegitismale) + sum(t1.suspectedmenegitisfemale)) AS men, t1.undisonedesc AS unDis_name,(sum(t1.undismale) + sum(t1.undisfemale)) AS unDis_num, t1.undissecdesc AS unDis_name,(sum(t1.undismaletwo) + sum(t1.undisfemaletwo)) AS unDis_num,(sum(t1.ocmale) + sum(t1.ocfemale)) AS oc
	FROM reportingforms AS t1
	WHERE epdcalendar_id = ' . $epdcalendar_id . '
	AND draft=0';
        
        $query = $this->db->query($sql);
        
        return $query->result();
    }
    
    function get_approved_hf_region_list($approved, $region_id)
    {
        $array = 'array';
        $data  = array();
        $this->db->select('t1.*,t1.id AS reportingform_id, t2.*')->from('reportingforms AS t1, healthfacilities AS t2')->where('t1.healthfacility_id = t2.id')->where('t1.approved_hf', $approved)->where('t1.region_id', $region_id)->order_by('t1.id DESC');
        
        return $this->db->get();
    }
    
    function get_test_list($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id)
    {
        $sql = 'SELECT t1.*,t1.id AS reportingform_id,t2.*,t3.*,t4.*,t5.*,t5.id AS hf_id,t6.contact_number AS User_Contact,t6.*
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.reporting_year>="' . $reporting_year . '" AND t1.reporting_year <="' . $reporting_year2 . '" ';
        
        if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.week_no <=' . $to . '
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
        
        if ($zone_id != 0) {
            $sql .= 'AND t2.id=' . $zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id=' . $region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t4.id=' . $district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND t5.id=' . $healthfacility_id;
        }
        
        $sql .= ' ORDER BY t1.id DESC';
        
        return $sql;
        
    }
    
    function get_full_list($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id)
    {
        $sql = 'SELECT t1.*,t1.id AS reportingform_id,t2.*,t3.*,t4.*,t5.*,t5.id AS hf_id,t6.contact_number AS User_Contact,t6.*
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.reporting_year>="' . $reporting_year . '" AND t1.reporting_year <="' . $reporting_year2 . '" ';
        
        if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.week_no>="' . $from . '" AND t1.week_no <="' . $to . '"
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
                    $sql .= 'AND t1.week_no>="' . $from . '" AND t1.week_no <="' . $to . '"
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
            $sql .= 'AND t2.id=' . $zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id=' . $region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t4.id=' . $district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND t5.id=' . $healthfacility_id;
        }
        
        $sql .= ' ORDER BY t1.id DESC';
        
        $query = $this->db->query($sql);
        
        return $query->result();
        
    }
	
	function get_full_list_level($reporting_year, $reporting_year2, $from, $to, $district_id, $region_id, $zone_id, $healthfacility_id,$level)
    {
        $sql = 'SELECT t1.*,t1.id AS reportingform_id,t2.*,t3.*,t4.*,t5.*,t5.id AS hf_id,t6.contact_number AS User_Contact,t6.*
		FROM reportingforms AS t1, zones AS t2,regions AS t3, districts AS t4, healthfacilities AS t5,users AS t6
		WHERE t1.reporting_year>="' . $reporting_year . '" AND t1.reporting_year <="' . $reporting_year2 . '" ';
        
        if ($reporting_year == $reporting_year2) {
            $sql .= 'AND t1.week_no>="' . $from . '" AND t1.week_no <="' . $to . '"
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
                    $sql .= 'AND t1.week_no>="' . $from . '" AND t1.week_no <="' . $to . '"
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
            $sql .= 'AND t2.id=' . $zone_id;
        }
        
        if ($region_id != 0) {
            $sql .= ' AND t3.id=' . $region_id;
        }
        
        if ($district_id != 0) {
            $sql .= ' AND t4.id=' . $district_id;
        }
        
        if ($healthfacility_id != 0) {
            $sql .= ' AND t5.id=' . $healthfacility_id;
        }
		
		if($level==1)//zonal
		{
			$sql .= ' AND approved_regional=1';
		}
		
		if($level==4)//national
		{
			$sql .= ' AND approved_zone=1';
		}
        
        $sql .= ' ORDER BY t1.id DESC';
        
        $query = $this->db->query($sql);
        
        return $query->result();
        
    }
	
	function test($week_no,$reporting_year)
	{
		$data = '';		
		$sql = 'SELECT (sum( reportingforms.measmale ) + sum( reportingforms.measfemale )) AS total_meas
				FROM reportingforms
				WHERE reporting_year ="'.$reporting_year.'"
				AND week_no ="'.$week_no.'"';
		
		return $sql;
	}
	
	function get_meas_by_year_period($week_no,$reporting_year)
	{
		$data = '';		
		$sql = 'SELECT (sum( reportingforms.measmale ) + sum( reportingforms.measfemale )) AS total_meas
				FROM reportingforms
				WHERE reporting_year ="'.$reporting_year.'"
				AND week_no ="'.$week_no.'"';
		$query = $this->db->query($sql);
        
        foreach ($query->result() as $row){

		   $data = $row;

		 }
		
		return $data;
	}
	
	function get_meas_by_year_period_zone($week_no,$reporting_year,$zone_id)
	{
		$data = '';
		
		
		$sql = 'SELECT DISTINCT healthfacilities.id, (sum( reportingforms.measmale ) + sum( reportingforms.measfemale )) AS total_meas, regions. * , districts. * , zones. *
				FROM reportingforms, healthfacilities, regions, districts, zones
				WHERE healthfacilities.id = reportingforms.healthfacility_id
				AND reportingforms.draft =0
				AND regions.zone_id = zones.id
				AND districts.region_id = regions.id
				AND healthfacilities.district_id = districts.id
				AND reportingforms.region_id = regions.id
				AND reportingforms.reporting_year ="'.$reporting_year.'"
				AND reportingforms.week_no ="'.$week_no.'"
				AND zones.id =' . $zone_id;
		$query = $this->db->query($sql);
        
        foreach ($query->result() as $row){

		   $data = $row;

		 }
		
		return $data;
	}
	
	function get_meas_by_year_period_region($week_no,$reporting_year,$region_id)
	{
		$data = '';
		
		
		$sql = 'SELECT DISTINCT healthfacilities.id, (sum( reportingforms.measmale ) + sum( reportingforms.measfemale )) AS total_meas, regions. * , districts. * , zones. *
				FROM reportingforms, healthfacilities, regions, districts, zones
				WHERE healthfacilities.id = reportingforms.healthfacility_id
				AND reportingforms.draft =0
				AND regions.zone_id = zones.id
				AND districts.region_id = regions.id
				AND healthfacilities.district_id = districts.id
				AND reportingforms.region_id = regions.id
				AND reportingforms.reporting_year ="'.$reporting_year.'"
				AND reportingforms.week_no ="'.$week_no.'"
				AND regions.id =' . $region_id;
		$query = $this->db->query($sql);
        
        foreach ($query->result() as $row){

		   $data = $row;

		 }
		
		return $data;
	}
    
    function get_dist_list($reporting_year, $reporting_year2, $from, $to, $district_id)
    {
        
        $query = $this->db->query("SELECT t1.*,t1.id AS reportingform_id, t2.*,t3.*
	 	FROM reportingforms AS t1, healthfacilities AS t2,districts AS t3
	 	WHERE t1.week_no>='" . $from . "' AND t1.week_no <='" . $to . "'
		AND t1.reporting_year>='" . $reporting_year . "' AND t1.reporting_year <='" . $reporting_year2 . "'
	 	AND t3.id = '" . $district_id . "'
		AND t1.draft = '0'
	 	AND t2.id = t1.healthfacility_id
		AND t3.id = t2.district_id
	 	ORDER BY t1.id DESC");
        
        return $query->result();
        
    }
    
    function get_hf_dist_data_list($reporting_year, $reporting_year2, $from, $to, $healthfacility_id, $district_id)
    {
        
        $query = $this->db->query("SELECT t1.*,t1.id AS reportingform_id, t2.*,t3.*
	 	FROM reportingforms AS t1, healthfacilities AS t2,districts AS t3
	 	WHERE t1.week_no>='" . $from . "' AND t1.week_no <='" . $to . "'
		AND t1.reporting_year>='" . $reporting_year . "' AND t1.reporting_year <='" . $reporting_year2 . "'
	 	AND t1.healthfacility_id = '" . $healthfacility_id . "'
		AND t3.id = '" . $district_id . "'
		AND t1.draft = '0'
	 	AND t2.id = t1.healthfacility_id
		AND t3.id = t2.district_id
	 	ORDER BY t1.id DESC");
        
        return $query->result();
        
    }
    
    function get_hf_data_list($reporting_year, $reporting_year2, $from, $to, $healthfacility_id)
    {
        
        $query = $this->db->query("SELECT t1.*,,t1.id AS reportingform_id, t2.*
	 	FROM reportingforms AS t1, healthfacilities AS t2
	 	WHERE t1.week_no>='" . $from . "' AND t1.week_no <='" . $to . "'
		AND t1.reporting_year>='" . $reporting_year . "' AND t1.reporting_year <='" . $reporting_year2 . "'
	 	AND t1.healthfacility_id = '" . $healthfacility_id . "'
		AND t1.draft = '0'
	 	AND t2.id = t1.healthfacility_id
	 	ORDER BY t1.id DESC");
        
        return $query->result();
        
    }
	
	function get_data_list($reporting_year, $reporting_year2, $from, $to)
    {
        
        $query = $this->db->query("SELECT t1.*,t1.id AS reportingform_id, t2.*
	 	FROM reportingforms AS t1, healthfacilities AS t2
	 	WHERE t1.week_no>='" . $from . "' AND t1.week_no <='" . $to . "'
	 	AND t1.reporting_year>='" . $reporting_year . "' AND t1.reporting_year <='" . $reporting_year2 . "'
	 	AND t2.id = t1.healthfacility_id
		AND t1.draft = '0'
	 	ORDER BY t1.id DESC");
        
        return $query->result();
        
    }
    
    // get number of roles in database
    
    function count_all()
    {
        
        return $this->db->count_all($this->tbl_roles);
        
    }
    
    // get roles with paging
    
    function get_paged_list($limit = 10, $offset = 0)
    {
        
        $this->db->order_by('id', 'asc');
        
        return $this->db->get($this->tbl_roles, $limit, $offset);
        
    }
    
    function get_by_reporting_period_hf($epdcalendar_id, $healthfacility_id)
    {
        
        $this->db->where('epdcalendar_id', $epdcalendar_id)->where('healthfacility_id', $healthfacility_id);
        
        return $this->db->get($this->tbl_roles);
        
    }
    
    function get_by_reporting_period($epdcalendar_id)
    {
        
        $this->db->where('epdcalendar_id', $epdcalendar_id);
        
        return $this->db->get($this->tbl_roles);
        
    }
	
	
	function get_columns()
	{
		$sql = "SHOW COLUMNS FROM reportingforms;";
	   $query = $this->db->query($sql);
        
       return $query->result();
	}
    
    // get role by id
    
    
    
    function get_by_id($id)
    {
        
        $this->db->where('id', $id);
        
        return $this->db->get($this->tbl_roles);
        
    }
    
    // add new role
    
    function save($role)
    {
        
        $this->db->insert($this->tbl_roles, $role);
        
        return $this->db->insert_id();
        
    }
    
    // update role by id
    
    function update($id, $role)
    {
        
        $this->db->where('id', $id);
        
        $this->db->update($this->tbl_roles, $role);
        
    }
    
    // delete role by id
    
    function delete($id)
    {
        
        $this->db->where('id', $id);
        
        $this->db->delete($this->tbl_roles);
        
    }
}
