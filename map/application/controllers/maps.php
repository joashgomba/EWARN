<?php

class Maps extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('alertsmodel');
   }

   public function index()
   {
       
	   if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
		
	   $data = array();
	   $reportingyear = date('Y');
	   $weekNumber = date("W");
	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reportingyear,1)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reportingyear,$weekNumber)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	   
	   //$rows = $this->db->get('alerts');
	   
	    $level = $this->erkanaauth->getField('level');
		 
	
		if($level==2)//FP
	   {
		   
		   $region_id = $this->erkanaauth->getField('region_id');		   
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
		   $data['districts'] = $this->districtsmodel->get_by_region($region->id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
		   
		   $thezone = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   
		   $rows = $this->alertsmodel->get_by_locations($thezone->id,$region_id,0,$period_one,$period_two,$reportingyear, $reportingyear,0);
		 
		   
	   }
	   if($level==1)//zonal
	   {
		   $zone_id = $this->erkanaauth->getField('zone_id');
		   $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
		   $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone->id);
		   
		     
		   $thedistrict = $this->districtsmodel->get_by_region($region->id);
		   
		    $rows = $this->alertsmodel->get_by_locations($zone_id,0,0,$period_one,$period_two,$reportingyear, $reportingyear,0);
	   }
	   
	   if($level==4)//national
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
		 
		 $rows = $this->alertsmodel->get_by_locations(0,0,0,$period_one,$period_two,$reportingyear, $reportingyear,0);
	   }
	   
	   if($level==5)//stakeholder
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
		 
		 $rows = $this->alertsmodel->get_by_locations(0,0,0,$period_one,$period_two,$reportingyear, $reportingyear,0);
	   }
	   
	   $data['level'] = $level;
	   
	   	$mapdata = array();
		$gps = array();
		$points = array();
		
		//foreach ($rows->result() as $row): 
		foreach ($rows as $key=>$row): 
		
			$district = $this->districtsmodel->get_by_id($row->district_id)->row();
			$healthfacility = $this->healthfacilitiesmodel->get_by_id($row->healthfacility_id)->row();
			$alertzone = $this->zonesmodel->get_by_id($row->zone_id)->row();
			$alertregion = $this->regionsmodel->get_by_id($row->region_id)->row();
			$reportingform = $this->reportingformsmodel->get_by_id($row->reportingform_id)->row();
			$user = $this->usersmodel->get_by_id($reportingform->user_id)->row();
			
			if(empty($user))
			{
				$reporter = '';
				$contacts = '';
			}
			else
			{
				$reporter =$user->username;
				$contacts = $user->contact_number;
			}
			
			
			
			if(!empty($district->lat))
			{
			   $gps['lat'] = $district->lat;
			   $gps['lng'] = $district->long;
			   
			   $mapdata['position'] = $gps;
			   
			   if($row->disease_name=='SARI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vbd.png';
			   }
			   
			   if($row->disease_name=='ILI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vbd.png';
			   }
			   
			   if($row->disease_name=='AWD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   if($row->disease_name=='BD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   
			   if($row->disease_name=='OAD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   if($row->disease_name=='Diph')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='WC')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='Meas')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='NNT')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='AFP')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='AJS')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($row->disease_name=='VHF')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($row->disease_name=='Mal')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($row->disease_name=='Men')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($row->disease_name=='UnDis')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   $mapdata['labelContent'] = $row->cases;
			   //markerWithLabel.js 
			   	   
			   $mapdata['info'] = '
			   Zone: '.$alertzone->zone.'<br>
			   Region: '.$alertregion->region.'<br>
			   District: '.$district->district.'<br>
			   Health Facility: '.$healthfacility->health_facility.'<br>
			   Alert: '.$row->disease_name.'<br>
			   Cases: '.$row->cases.'<br>
			   Date Reported: '.date("d F Y", strtotime($reportingform->entry_date)).'<br>
			   Time reported: '.$reportingform->entry_time.'<br>
			   Reported by: '.$reporter.'<br>
			   Contacts: '.$contacts.'';
			   
			   $points[] = $mapdata;
			}
		
		endforeach;
	
		$data['points'] = $points;

       $this->load->view('maps/index', $data);
   }


	function getmap()
	{
		if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
		
	$data = array();
	 
	  $level = $this->erkanaauth->getField('level');
		
		if($level==2)//FP
	   {
		   	   
		   $region_id = $this->erkanaauth->getField('region_id');		   
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
		   $data['districts'] = $this->districtsmodel->get_by_region($region->id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
		   
	   }
	   if($level==1)//zonal
	   {
		   $zone_id = $this->erkanaauth->getField('zone_id');
		   $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
		   $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone->id);
	   }
	   
	   if($level==4)//national
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		  $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   if($level==5)//stakeholder
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		  $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	 
	  
	  $zone_id = $this->input->post('zone_id');
	  $region_id = $this->input->post('region_id');
	  $district_id = $this->input->post('district_id');
	  $healthfacility_id = $this->input->post('healthfacility_id');
	   
	   $reporting_year = $this->input->post('reporting_year');
	   $from = $this->input->post('week_no');
	   $reporting_year2 = $this->input->post('reporting_year2');
	   $to = $this->input->post('week_no2');
	   
	    if(empty($zone_id))
	   {
		   $zon_id = 0;
		   $data['zone'] = 'All';
	   }
	   else
	   {
		   $zon_id = $zone_id;
		   $zone = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['zone'] = $zone->zone;
	   }
	   
	   if(empty($region_id))
	   {
		   $reg_id = 0;
		   $data['region'] = 'All';
	   }
	   else
	   {
		   $reg_id = $region_id;
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['region'] = $region->region;
	   }
	   
	   if(empty($district_id))
	   {
		   $dist_id = 0;
		   $data['district'] = 'All';
	   }
	   else
	   {
		   $dist_id = $district_id;
		   $district = $this->districtsmodel->get_by_id($district_id)->row();
		   $data['district'] = $district->district;
	   }
	   
	   
	    $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	  
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	   
	   $alerts = $this->alertsmodel->get_by_locations($zon_id,$reg_id,$dist_id,$period_one,$period_two,$reporting_year, $reporting_year2,0);
	   
		
		 $data['level'] = $level;
	   
	   	$mapdata = array();
		$gps = array();
		$points = array();
		
		foreach ($alerts as $key=>$row): 
		
			$district = $this->districtsmodel->get_by_id($row->district_id)->row();
			$healthfacility = $this->healthfacilitiesmodel->get_by_id($row->healthfacility_id)->row();
			$alertzone = $this->zonesmodel->get_by_id($row->zone_id)->row();
			$alertregion = $this->regionsmodel->get_by_id($row->region_id)->row();
			$reportingform = $this->reportingformsmodel->get_by_id($row->reportingform_id)->row();
			$user = $this->usersmodel->get_by_id($reportingform->user_id)->row();
			
			if(empty($user))
			{
				$reporter = '';
				$contacts = '';
			}
			else
			{
				$reporter =$user->username;
				$contacts = $user->contact_number;
			}
			
			if(!empty($district->lat))
			{
			   $gps['lat'] = $district->lat;
			   $gps['lng'] = $district->long;
			   
			   $mapdata['position'] = $gps;
			   
			   if($row->disease_name=='SARI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vbd.png';
			   }
			   
			   if($row->disease_name=='ILI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vbd.png';
			   }
			   
			   if($row->disease_name=='AWD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   if($row->disease_name=='BD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   
			   if($row->disease_name=='OAD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   if($row->disease_name=='Diph')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='WC')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='Meas')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='NNT')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='AFP')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($row->disease_name=='AJS')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($row->disease_name=='VHF')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($row->disease_name=='Mal')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($row->disease_name=='Men')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($row->disease_name=='UnDis')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   $mapdata['info'] = '
			   Zone: '.$alertzone->zone.'<br>
			   Region: '.$alertregion->region.'<br>
			   District: '.$district->district.'<br>
			   Health Facility: '.$healthfacility->health_facility.'<br>
			   Alert: '.$row->disease_name.'<br>
			   Cases: '.$row->cases.'<br>
			   Date Reported: '.date("d F Y", strtotime($reportingform->entry_date)).'<br>
			   Time reported: '.$reportingform->entry_time.'<br>
			   Reported by: '.$reporter.'<br>
			   Contacts: '.$contacts.'';
			   
			   $points[] = $mapdata;
			}
		
		endforeach;
	
		$data['points'] = $points;

       $this->load->view('maps/getmap', $data);
	}
 
}
