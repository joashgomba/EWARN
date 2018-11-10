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
	   
	   $currentWeek = (int)$weekNumber;
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reportingyear,$currentWeek)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reportingyear,$currentWeek)->row();
	   
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
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='ILI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AWD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='BD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   
			   if($row->disease_name=='OAD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Diph')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='WC')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Meas')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='NNT')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AFP')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AJS')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='VHF')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Mal')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Men')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='UnDis')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='SRE')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pf')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pmix')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pv')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
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
			   ';
			   
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
			
			
			if(empty($reportingform))
			{
				$user = '';
			}
			else
			{
			
			$user = $this->usersmodel->get_by_id($reportingform->user_id)->row();
			}
			
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
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='ILI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AWD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='BD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   
			   if($row->disease_name=='OAD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Diph')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='WC')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Meas')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='NNT')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AFP')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AJS')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='VHF')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Mal')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Men')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='UnDis')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='SRE')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pf')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pmix')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pv')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if(empty($reportingform))
			   {
				   $reportingdate = '';
				   $entrytime = '';
			   }
			   else
			   {
				   $reportingdate = date("d F Y", strtotime($reportingform->entry_date));
				   $entrytime = $reportingform->entry_time;
			   }
			   
			   $mapdata['info'] = '
			   Zone: '.$alertzone->zone.'<br>
			   Region: '.$alertregion->region.'<br>
			   District: '.$district->district.'<br>
			   Health Facility: '.$healthfacility->health_facility.'<br>
			   Alert: '.$row->disease_name.'<br>
			   Cases: '.$row->cases.'<br>			   
			   Date Reported: '.$reportingdate.'<br>
			   Time reported: '.$entrytime.'<br>
			   Reported by: '.$reporter.'<br>
			   Contacts: '.$contacts.'';
			   
			   $points[] = $mapdata;
			}
		
		endforeach;
		
	
		$data['points'] = $points;

		header('Content-Type: application/json');
    	echo json_encode( $data );

       //$this->load->view('maps/getmap', $data);
	}
	
   public function fullscreen()
   {
      		
	   $data = array();
	   $reportingyear = date('Y');
	   $weekNumber = date("W");
	   
	   $currentWeek = (int)$weekNumber;
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reportingyear,$currentWeek)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reportingyear,$currentWeek)->row();
	   
	  
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	   
	   //$rows = $this->db->get('alerts');
	   
		 $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
		 
		 $rows = $this->alertsmodel->get_by_locations(0,0,0,$period_one,$period_two,$reportingyear, $reportingyear,0);
	 	   
	  	   
	   $data['level'] = 4;
	   
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
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='ILI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AWD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='BD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   
			   if($row->disease_name=='OAD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Diph')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='WC')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Meas')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='NNT')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AFP')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AJS')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='VHF')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Mal')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Men')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='UnDis')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='SRE')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pf')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pmix')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pv')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
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
			   ';
			   
			   $points[] = $mapdata;
			}
		
		endforeach;
	
		$data['points'] = $points;

       $this->load->view('maps/fullscreen', $data);
   }
   
   public function getfullscreen()
   {
			
	$data = array();
	 
	  $level = 4;
		
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
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='ILI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AWD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='BD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   
			   if($row->disease_name=='OAD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Diph')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='WC')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Meas')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='NNT')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AFP')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='AJS')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='VHF')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Mal')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Men')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='UnDis')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='SRE')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pf')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pmix')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
			   }
			   
			   if($row->disease_name=='Pv')
			   {
				   $mapdata['icon'] = ''.base_url().'img/icon.png';
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
			   Reported by: '.$reporter.'';
			   
			   $points[] = $mapdata;
			}
		
		endforeach;
	
		$data['points'] = $points;

       $this->load->view('maps/getfullscreen', $data);
   }
   
   public function get_date($date)
   {
	  
	  $today =  base64_encode($date);
	   
	   redirect('maps/hfsmaps/'.$today, 'refresh');
   }
   
   public function hfsmaps($today)
   {
	  
	   $result = base64_decode($today);
	   
	   if(empty($result))
	   {
		   redirect('maps/fullscreen/', 'refresh');
	   }
	   else
	   {
	   
		   $ddate = $result;
		   $duedt = explode("-", $ddate);
		   $date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
		   $week  = (int)date('W', $date);
			
			
			$currentWeek = (int)$week;
			$time=strtotime($result);
			$month=date("F",$time);
			$year=date("Y",$time);
			
			echo "Weekn ummer: " . $currentWeek;
			echo "<br>Reporting year: " . $year;
	   }
   }
   
   public function fullscreen_hfs()
   {
      		
	   $data = array();
	   $reportingyear = date('Y');
	   $weekNumber = date("W");
	   
	   $currentWeek = (int)$weekNumber;
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reportingyear,$currentWeek)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reportingyear,$currentWeek)->row();
	   
	  
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	   
	   //$rows = $this->db->get('alerts');
	   
		 $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
		 
		 //$rows = $this->alertsmodel->get_by_locations(0,0,0,$period_one,$period_two,$reportingyear, $reportingyear,0);
		 $rows = $this->alertsmodel->get_hf_alerts_locations(0,0,0,$period_one,$period_two,$reportingyear, $reportingyear,0);
	 	   
			  	   
	   $data['level'] = 4;
	   
	   	$mapdata = array();
		$gps = array();
		$points = array();
		
			
		//foreach ($rows->result() as $row): 
		foreach ($rows as $key=>$row): 
		
				
			if(!empty($row->lat))
			{
			   $gps['lat'] = $row->lat;
			   $gps['lng'] = $row->long;
			   
			   $user = $this->usersmodel->get_by_hf_id($row->hf_id)->row();		
			   
			   $hfreporting = $this->reportingformsmodel->get_by_period_hf($period_one, $row->hf_id);
			   $reporting = count($hfreporting);
			   
			   $hfwithalert = $this->alertsmodel->get_by_locations_hf(0,0,0,$period_one,$period_two,$reportingyear, $reportingyear,$row->hf_id);
			   $hfalertcount = count($hfwithalert);
			   
			   $hfalerts = '';
			   
			    if($hfalertcount>0)//hfs with alert
				{
					foreach ($hfwithalert as $hfkey=>$hfalert)
					{
						if(empty($hfalert->notes))
						{
							$action = 'Waiting Action';
						}
						else
						{
							$action = $hfalert->notes;
						}
						
						$hfalerts .= $hfalert->disease_name.' '.$hfalert->cases.' ('.$action.')<br>';
					}
				}
			   
			  		   
			   $mapdata['position'] = $gps;
			   
			   if($reporting==0)
			   {
				   $mapdata['icon'] = ''.base_url().'img/hf_with_no_data.png';
			   }
			   else
			   {
				   if($hfalertcount>0)//hfs with alert
				   {
				   		$hfreporting_id = $this->alertsmodel->get_by_locations_hf_status(0,0,0,$period_one,$period_two,$reportingyear, $reportingyear,0,$row->hf_id);
						
						if($hfreporting_id==0)//status is one and there are alerts so action was taken
						{
							$mapdata['icon'] = ''.base_url().'img/hf_with_alert_action.png';
						}
						else
						{
							$reportingform = $this->reportingformsmodel->get_by_reporting_period_hf($period_one, $hfreporting_id)->row();
							
							if(empty($reportingform))
							{
								$mapdata['icon'] = ''.base_url().'img/hf_with_alerts.png';
							}
							else
							{
							
								$current_date_time = date('Y-m-d h:i:s ', time());							
								$date_time_reporting = $reportingform->entry_time;
								
								$t1 = StrToTime ($current_date_time);
								$t2 = StrToTime ($date_time_reporting);
								$diff = $t1 - $t2;
								$hours = $diff / ( 60 * 60 );
								if($hours>48)
								{
									$mapdata['icon'] = ''.base_url().'img/hf_with_alert_late.png';
								}
								else
								{
									$mapdata['icon'] = ''.base_url().'img/hf_with_alerts.png';
								}
							
							}
							
							
						}
						
						
				   }
				   else //hfs with no alerts and data entered
				   {
					   $mapdata['icon'] = ''.base_url().'img/hf_data_no_alerts.png';
				   }
			   }  
			   
			    if($hfalertcount>0)//hfs with alert
				{
					$mapdata['info'] = '
				   Zone: '.$row->zone.'<br>
				   Region: '.$row->region.'<br>
				   District: '.$row->district.'<br>
				   Health Facility: '.$row->health_facility.'<br>
				   Focal Point: '.$user->fname.' '.$user->lname.'<br>
				   Phone No.: '.$user->contact_number.'
				   <hr>
				   Week/Year: '.$reportingperiod_one->week_no.'/'.$reportingperiod_one->epdyear.'<br>
				   Cases:<br>
				   '.$hfalerts.'
				   ';
					   
				}
				else
				{
					$mapdata['info'] = '
				   Zone: '.$row->zone.'<br>
				   Region: '.$row->region.'<br>
				   District: '.$row->district.'<br>
				   Health Facility: '.$row->health_facility.'<br>
				   Focal Point: '.$user->fname.' '.$user->lname.'<br>
				   Phone No.: '.$user->contact_number.'
				   ';
				}
			
			   
			   
			   $points[] = $mapdata;
			}
		
		endforeach;
	
		$data['points'] = $points;

       $this->load->view('maps/fullscreen_hfs', $data);
   }
   
    public function getfullscreen_hfs()
   {
			
	$data = array();
	 
	  $level = 4;
		
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
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	  
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	   
	   //$alerts = $this->alertsmodel->get_by_locations($zon_id,$reg_id,$dist_id,$period_one,$period_two,$reporting_year, $reporting_year2,0);
	
	   $rows = $this->alertsmodel->get_hf_alerts_locations($zon_id,$reg_id,$dist_id,$period_one,$period_two,$reporting_year, $reporting_year,0);
	 	   
			  	   
	   $data['level'] = $level;
	   
	   	$mapdata = array();
		$gps = array();
		$points = array();
		
			
		//foreach ($rows->result() as $row): 
		foreach ($rows as $key=>$row): 
		
				
			if(!empty($row->lat))
			{
			   $gps['lat'] = $row->lat;
			   $gps['lng'] = $row->long;
			   
			   $user = $this->usersmodel->get_by_hf_id($row->hf_id)->row();		
			   
			   $hfreporting = $this->reportingformsmodel->get_by_period_hf($period_one, $row->hf_id);
			   $reporting = count($hfreporting);
			   
			   $hfwithalert = $this->alertsmodel->get_by_locations_hf($zon_id,$reg_id,$dist_id,$period_one,$period_two,$reporting_year, $reporting_year,$row->hf_id);
			   $hfalertcount = count($hfwithalert);
			   
			   $hfalerts = '';
			   
			    if($hfalertcount>0)//hfs with alert
				{
					foreach ($hfwithalert as $hfkey=>$hfalert)
					{
						if(empty($hfalert->notes))
						{
							$action = 'Waiting Action';
						}
						else
						{
							$action = $hfalert->notes;
						}
						
						$hfalerts .= $hfalert->disease_name.' '.$hfalert->cases.' ('.$action.')<br>';
					}
				}
			   
			  		   
			   $mapdata['position'] = $gps;
			   
			   if($reporting==0)
			   {
				   $mapdata['icon'] = ''.base_url().'img/hf_with_no_data.png';
			   }
			   else
			   {
				   if($hfalertcount>0)//hfs with alert
				   {
				   		$hfreporting_id = $this->alertsmodel->get_by_locations_hf_status($zon_id,$reg_id,$dist_id,$period_one,$period_two,$reporting_year, $reporting_year,0,$row->hf_id);
						
						if($hfreporting_id==0)//status is one and there are alerts so action was taken
						{
							$mapdata['icon'] = ''.base_url().'img/hf_with_alert_action.png';
						}
						else
						{
							$reportingform = $this->reportingformsmodel->get_by_reporting_period_hf($period_one, $hfreporting_id)->row();
							
							if(empty($reportingform))
							{
								$mapdata['icon'] = ''.base_url().'img/hf_with_alerts.png';
							}
							else
							{
							
								$current_date_time = date('Y-m-d h:i:s ', time());							
								$date_time_reporting = $reportingform->entry_time;
								
								$t1 = StrToTime ($current_date_time);
								$t2 = StrToTime ($date_time_reporting);
								$diff = $t1 - $t2;
								$hours = $diff / ( 60 * 60 );
								if($hours>48)
								{
									$mapdata['icon'] = ''.base_url().'img/hf_with_alert_late.png';
								}
								else
								{
									$mapdata['icon'] = ''.base_url().'img/hf_with_alerts.png';
								}
							
							}
							
							
						}
						
						
				   }
				   else //hfs with no alerts and data entered
				   {
					   $mapdata['icon'] = ''.base_url().'img/hf_data_no_alerts.png';
				   }
			   }  
			   
			    if($hfalertcount>0)//hfs with alert
				{
					$mapdata['info'] = '
				   Zone: '.$row->zone.'<br>
				   Region: '.$row->region.'<br>
				   District: '.$row->district.'<br>
				   Health Facility: '.$row->health_facility.'<br>
				   Focal Point: '.$user->fname.' '.$user->lname.'<br>
				   Phone No.: '.$user->contact_number.'
				   <hr>
				   Week/Year: '.$reportingperiod_one->week_no.'/'.$reportingperiod_one->epdyear.'<br>
				   Cases:<br>
				   '.$hfalerts.'
				   ';
					   
				}
				else
				{
					$mapdata['info'] = '
				   Zone: '.$row->zone.'<br>
				   Region: '.$row->region.'<br>
				   District: '.$row->district.'<br>
				   Health Facility: '.$row->health_facility.'<br>
				   Focal Point: '.$user->fname.' '.$user->lname.'<br>
				   Phone No.: '.$user->contact_number.'
				   ';
				}
			
			   
			   
			   $points[] = $mapdata;
			}
		
		endforeach;
	
		$data['points'] = $points;

       $this->load->view('maps/fullscreen_hfs', $data);
   }
   
   
   
   public function gsnnetworks()
   {
	   $data = array();
	   $mapdata = array();
	   $gps = array();
	   $points = array();
	   
	  $rows = $this->db->get('clinics');
	  
	  
	  foreach ($rows->result() as $row): 
	  				
			if(!empty($row->lat))
			{
				
			   $gps['lat'] = $row->lat;
			   $gps['lng'] = $row->long;
			   
			   $mapdata['position'] = $gps;
			   $mapdata['icon'] = ''.base_url().'img/hf_with_alert_action.png';
			   
			   $mapdata['info'] = 'Program:'.$row->program_one.'<br>
			   Name: '.$row->name.'<br>
			   Contact Person: '.$row->contact_person.'<br>
			   Physical Address: '.$row->physical_address.'<br>
			   ';
			   
			   /**
			    $mapdata['info'] = '
				   Program: '.$row->program_one.'<br>
				   Name: '.$row->name.'<br>
				   Contact Person: '.$row->contact_person.'<br>
				   Physical Address: '.$row->physical_address.'<br>
				   Telephone Contact: '.$row->telephone_contact.'
				   ';
				   
				**/
			   
			   $points[] = $mapdata;
			  
			}
			
			 
			
      endforeach;
	  
	  $data['points'] = $points;

	  
	  $this->load->view('maps/gsnmaps', $data);
	   
   }
 
}
