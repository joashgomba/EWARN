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
		
		
	   $level = $this->erkanaauth->getField('level');
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	 $current_week = date('W');
	$current_year = date('Y');
	 
	//$current_week = 29;
	//$current_year = 2017;
	 
	 $week_array = $this->getStartAndEndDate($current_week,$current_year);
	
	  $end_date = $week_array['week_start'];
		
	  $start_date = date('Y-m-d', strtotime('-10 weeks', strtotime($end_date)));
	  
	  $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);
	  
	  $epicalendaridArray = array();
	  $yearArray = array();
	  $weekArray = array();
	 
	  foreach($epilists as $key=>$epilist)
	  {
		$epicalendaridArray[] =  $epilist->id;  
		$yearArray[] =  $epilist->epdyear; 
		$weekArray[] =  $epilist->week_no; 
		
	  }
	  
	  //if the country has no calendar added
	  if(empty($epicalendaridArray))
	  {
		  $from_date = DateTime::createFromFormat("Y-m-d", $start_date);
		  $from_year =  $from_date->format("Y");
		  
		  $to_date = DateTime::createFromFormat("Y-m-d", $end_date);
		  $to_year =  $to_date->format("Y");
		  
		  $from_week = date("W", strtotime($start_date));
		  $to_week = date("W", strtotime($end_date));
		  
		  $first = 0;
		  $last = 0;
	  }
	  else
	  {
	  
		  $first = reset($epicalendaridArray);
		  $last = end($epicalendaridArray);
		  
		  $from_year = reset($yearArray);
		  $to_year = end($yearArray);
		  
		  $from_week = reset($weekArray);
		  $to_week = end($weekArray);
	  }
	  
	 
	 
	  $country = $this->countriesmodel->get_by_id($country_id)->row();
	  
	  $last_week = ($current_week-1);
		
	  $epicalendar = $this->epdcalendarmodel->get_by_year_week_country($current_year,$last_week,$country_id)->row();
		
		if(empty($epicalendar))
		{
			$epicalendar_id = 0;
		}
		else
		{
			$epicalendar_id = $epicalendar->id;
		}
	  
	    
	    $zon_id = 0;
	  	$reg_id = 0;
	  	$dist_id = 0;
	  	$hf_id = 0;
	   
	   $points = array();
	
	//$maps = $this->formalertsmodel->get_sum_by_period_map($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	
	$maps = $this->formalertsmodel->get_list_by_period($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id);
	
	
	foreach($maps as $key=>$map)
	{
		if(empty($map->lat))
		{
			//do not show
		}
		else
		{
			
			$gps['lat'] = $map->lat;
			$gps['lng'] = $map->long;
			$mapdata['position'] = $gps;
			$mapdata['icon'] = ''.base_url().'img/warning.png';
			$mapdata['info'] = '
			   Zone: '.$map->zone.'<br>
			   Region: '.$map->region.'<br>
			   District: '.$map->district.'<br>
			   Health Facility: '.$map->health_facility.'<br>
			   Alert: '.$map->disease_name.'<br>
			   Cases: '.$map->cases.'<br>
			   Date Reported: '.date("d F Y", strtotime($map->entry_date)).'<br>
			   Time reported: '.$map->entry_time.'<br>
			   Reported by: '.$map->username.'<br>
			   Contact: '.$map->contact_number.'<br>
			   ';
		
			   
			   $points[] = $mapdata;
		}
		
	}
	
	$diseasecount = $this->diseasesmodel->get_country_list($country_id);
	$limit = count($diseasecount);
			   
   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
			   
	$country = $this->countriesmodel->get_by_id($country_id)->row();
	
	
	$data['regions'] = $this->regionsmodel->get_list();
	$data['districts'] = $this->districtsmodel->get_list();
	$data['zones'] = $this->zonesmodel->get_country_list($country_id);
	$data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();

	 
	$data['diseases'] = $diseases;	  
	$data['countries'] = $this->countriesmodel->get_list();
	$data['country_id'] = $country_id;	
	$data['points'] = $points;
	$data['to_year'] = $to_year;
	$data['to_week'] = $to_week;
	$data['map_center'] = $country->map_center;

       $this->load->view('maps/index', $data);
   }
   
   
  function getStartAndEndDate($week, $year) {
	  $dto = new DateTime();
	  $dto->setISODate($year, $week);
	  $ret['week_start'] = $dto->format('Y-m-d');
	  $dto->modify('+6 days');
	  $ret['week_end'] = $dto->format('Y-m-d');
	  return $ret;
  }



	function getmap()
	{
		if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
		
	  $data = array();
	 
	  $level = $this->erkanaauth->getField('level');
			  
	  $zone_id = $this->input->post('zone_id');
	  $region_id = $this->input->post('region_id');
	  $district_id = $this->input->post('district_id');
	  $healthfacility_id = $this->input->post('healthfacility_id');
	  $disease_id = $this->input->post('disease_id');
	  $verification_status = $this->input->post('verification_status');
	   
	   $reporting_year = $this->input->post('reporting_year');
	   $from = $this->input->post('from');
	   $reporting_year2 = $this->input->post('reporting_year2');
	   $to = $this->input->post('to');
	   
	   if (getRole() == 'SuperAdmin')
	   {
		   $country_id = $this->input->post('country_id');
	   }
	   else
	   {
		   $country_id = $this->erkanaauth->getField('country_id');
	   }

	   if(empty($country_id))
       {
           $country_id = $this->erkanaauth->getField('country_id');
       }
	  
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
	   
	   if(empty($healthfacility_id))
	   {
		   $hf_id = 0;
		   $data['healthfacility'] = 'All';
	   }
	   else
	   {
		   $hf_id = $healthfacility_id;
		   $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
		   $data['healthfacility'] = $healthfacility->health_facility;
	   }
	   
	   
	   //get the list using the EPI calendar
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$from,$country_id)->row();
	    $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week_country($reporting_year2,$to,$country_id)->row();
			   
			   if(empty($reportingperiod_one))
				{
					$period_one = 0;
				}
				else
				{
					$period_one = $reportingperiod_one->id;
				}
				
				if(empty($reportingperiod_two))
				{
					$period_two = 0;
				}
				else
				{
					$period_two = $reportingperiod_two->id;
				}
	   
	 
		 $data['level'] = $level;
		 
		 
		 
		  $points = array();


        $startdate = $reportingperiod_one->from;
        $enddate = $reportingperiod_two->to;

        $region_id = $this->input->post('region_id');

        $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);

        $epicalendaridArray = array();

        foreach($epilists as $key=>$epilist)
        {
            $epicalendaridArray[] =  $epilist->id;


        }
	
		
	//$maps = $this->formalertsmodel->get_list_by_epi_periods_disease_status($period_one,$period_two,$dist_id,$reg_id,$zon_id,$hf_id,$disease_id,$verification_status);
        $maps = $this->formalertsmodel->get_list_by_epi_array_disease_status($epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$disease_id,$verification_status);

	
	foreach($maps as $key=>$map)
	{
		if(empty($map->lat))
		{
			//do not show
		}
		else
		{
			
			$gps['lat'] = $map->lat;
			$gps['lng'] = $map->long;
			$mapdata['position'] = $gps;
			$mapdata['icon'] = ''.base_url().'img/warning.png';
			$mapdata['info'] = '
			   Zone: '.$map->zone.'<br>
			   Region: '.$map->region.'<br>
			   District: '.$map->district.'<br>
			   Health Facility: '.$map->health_facility.'<br>
			   Alert: '.$map->disease_name.'<br>
			   Cases: '.$map->cases.'<br>
			   Date Reported: '.date("d F Y", strtotime($map->entry_date)).'<br>
			   Time reported: '.$map->entry_time.'<br>
			   Reported by: '.$map->username.'<br>
			   Contact: '.$map->contact_number.'<br>
			   ';
		
			   
			   $points[] = $mapdata;
		}
		
	}
	   
	$diseasecount = $this->diseasesmodel->get_country_list($country_id);
	$limit = count($diseasecount);
			   
   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);   
   
   if(empty($zone_id))
   {
	   $data['regions'] = $this->regionsmodel->get_list();
	   $data['districts'] = $this->districtsmodel->get_list();
	   $data['zones'] = $this->zonesmodel->get_country_list($country_id);
	   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
   }
   else
   {
		$data['zones'] = $this->zonesmodel->get_country_list($country_id);
		$data['regions']           = $this->regionsmodel->get_by_zone($zone_id);
		if(empty($region_id))
		{
			$data['districts'] = $this->districtsmodel->get_list();
			$data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
		}
		else
		{
			$data['districts']        = $this->districtsmodel->get_by_region($region_id);
			$data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
		}
		
		if(empty($district_id))
		{
			$data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
		}
		else
		{
			$data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district($district_id);
		}
   }
		
		
	$country = $this->countriesmodel->get_by_id($country_id)->row();
		 
	$data['zone_id'] = $zon_id;
	$data['region_id'] = $reg_id;
	$data['district_id'] = $dist_id;
	$data['healthfacility_id'] = $hf_id ; 
	$data['countries'] = $this->countriesmodel->get_list();
	$data['country'] = $country;	
	$data['country_id'] = $country_id;	
	$data['diseases'] = $diseases;	
	$data['points'] = $points;
	$data['to_year'] = $reporting_year2;
	$data['to_week'] = $to;
	$data['map_center'] = $country->map_center;
	
	$data['points'] = $points;

       $this->load->view('maps/getmap', $data);
	}
	
   public function fullscreen()
   {
	   
	   if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
      		
	   $data = array();
		
		
	   $level = $this->erkanaauth->getField('level');
	  
	   $active = $this->erkanaauth->getField('active');
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	 $current_week = date('W');
	 $current_year = date('Y');
	 
	 //$current_week = 29;
	 //$current_year = 2017;
	 
	 $week_array = $this->getStartAndEndDate($current_week,$current_year);
	
	  $end_date = $week_array['week_start'];
		
	  $start_date = date('Y-m-d', strtotime('-10 weeks', strtotime($end_date)));
	  
	  $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);
	  
	  $epicalendaridArray = array();
	  $yearArray = array();
	  $weekArray = array();
	 
	  foreach($epilists as $key=>$epilist)
	  {
		$epicalendaridArray[] =  $epilist->id;  
		$yearArray[] =  $epilist->epdyear; 
		$weekArray[] =  $epilist->week_no; 
		
	  }
	  
	  //if the country has no calendar added
	  if(empty($epicalendaridArray))
	  {
		  $from_date = DateTime::createFromFormat("Y-m-d", $start_date);
		  $from_year =  $from_date->format("Y");
		  
		  $to_date = DateTime::createFromFormat("Y-m-d", $end_date);
		  $to_year =  $to_date->format("Y");
		  
		  $from_week = date("W", strtotime($start_date));
		  $to_week = date("W", strtotime($end_date));
		  
		  $first = 0;
		  $last = 0;
	  }
	  else
	  {
	  
		  $first = reset($epicalendaridArray);
		  $last = end($epicalendaridArray);
		  
		  $from_year = reset($yearArray);
		  $to_year = end($yearArray);
		  
		  $from_week = reset($weekArray);
		  $to_week = end($weekArray);
	  }
	  
	 
	 
	  $country = $this->countriesmodel->get_by_id($country_id)->row();
	  
	  $last_week = ($current_week-1);
		
	  $epicalendar = $this->epdcalendarmodel->get_by_year_week_country($current_year,$last_week,$country_id)->row();
		
		if(empty($epicalendar))
		{
			$epicalendar_id = 0;
		}
		else
		{
			$epicalendar_id = $epicalendar->id;
		}
	  
	    
	    $zon_id = 0;
	  	$reg_id = 0;
	  	$dist_id = 0;
	  	$hf_id = 0;
	   
	   $points = array();
	
	//$maps = $this->formalertsmodel->get_sum_by_period_map($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	
	$maps = $this->formalertsmodel->get_list_by_period($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id);
	
	
	foreach($maps as $key=>$map)
	{
		if(empty($map->lat))
		{
			//do not show
		}
		else
		{
			
			$gps['lat'] = $map->lat;
			$gps['lng'] = $map->long;
			$mapdata['position'] = $gps;
			$mapdata['icon'] = ''.base_url().'img/warning.png';
			$mapdata['info'] = '
			   Zone: '.$map->zone.'<br>
			   Region: '.$map->region.'<br>
			   District: '.$map->district.'<br>
			   Health Facility: '.$map->health_facility.'<br>
			   Alert: '.$map->disease_name.'<br>
			   Cases: '.$map->cases.'<br>
			   Date Reported: '.date("d F Y", strtotime($map->entry_date)).'<br>
			   Time reported: '.$map->entry_time.'<br>
			   Reported by: '.$map->username.'<br>
			   Contact: '.$map->contact_number.'<br>
			   ';
		
			   
			   $points[] = $mapdata;
		}
		
	}
	
	$diseasecount = $this->diseasesmodel->get_country_list($country_id);
	$limit = count($diseasecount);
			   
   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
			   
	$data['zone_id'] = $zon_id;
	$data['region_id'] = $reg_id;		   
	
	$data['regions'] = $this->regionsmodel->get_list();
	$data['districts'] = $this->districtsmodel->get_list();
	$data['zones'] = $this->zonesmodel->get_country_list($country_id);
	$data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();

	 
	$data['diseases'] = $diseases;	  
	$data['countries'] = $this->countriesmodel->get_list();
	$data['country_id'] = $country_id;	
	$data['points'] = $points;
	$data['to_year'] = $to_year;
	$data['to_week'] = $to_week;
	$data['map_center'] = $country->map_center;

       $this->load->view('maps/fullscreen', $data);
   }
   
   public function getfullscreen()
   {
	   
	   if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
	 
	   $data = array();
	 
	  $level = $this->erkanaauth->getField('level');
			  
	  $zone_id = $this->input->post('zone_id');
	  $region_id = $this->input->post('region_id');
	  $district_id = $this->input->post('district_id');
	  $healthfacility_id = $this->input->post('healthfacility_id');
	  $disease_id = 0;
	  $verification_status = 2;
	   
	   $reporting_year = $this->input->post('reporting_year');
	   $from = $this->input->post('week_no');
	   $reporting_year2 = $this->input->post('reporting_year2');
	   $to = $this->input->post('week_no2');
	   
	  $country_id = $this->erkanaauth->getField('country_id');
	  
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
	   
	   if(empty($healthfacility_id))
	   {
		   $hf_id = 0;
		   $data['healthfacility'] = 'All';
	   }
	   else
	   {
		   $hf_id = $healthfacility_id;
		   $healthfacility = $this->districtsmodel->get_by_id($healthfacility_id)->row();
		   $data['healthfacility'] = $healthfacility->health_facility;
	   }
	   
	   
	   //get the list using the EPI calendar
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$from,$country_id)->row();
	    $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week_country($reporting_year2,$to,$country_id)->row();
			   
			   if(empty($reportingperiod_one))
				{
					$period_one = 0;
				}
				else
				{
					$period_one = $reportingperiod_one->id;
				}
				
				if(empty($reportingperiod_two))
				{
					$period_two = 0;
				}
				else
				{
					$period_two = $reportingperiod_two->id;
				}
	   
	 
		 $data['level'] = $level;
		 
		 
		 
		  $points = array();

       $startdate = $reportingperiod_one->from;
       $enddate = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);

       $epicalendaridArray = array();


       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;


       }
	
		
	//$maps = $this->formalertsmodel->get_list_by_epi_periods_disease_status($period_one,$period_two,$dist_id,$reg_id,$zon_id,$hf_id,$disease_id,$verification_status);
       $maps = $this->formalertsmodel->get_list_by_epi_array_disease_status($epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$disease_id,$verification_status);


       foreach($maps as $key=>$map)
	{
		if(empty($map->lat))
		{
			//do not show
		}
		else
		{
			
			$gps['lat'] = $map->lat;
			$gps['lng'] = $map->long;
			$mapdata['position'] = $gps;
			$mapdata['icon'] = ''.base_url().'img/warning.png';
			$mapdata['info'] = '
			   Zone: '.$map->zone.'<br>
			   Region: '.$map->region.'<br>
			   District: '.$map->district.'<br>
			   Health Facility: '.$map->health_facility.'<br>
			   Alert: '.$map->disease_name.'<br>
			   Cases: '.$map->cases.'<br>
			   Date Reported: '.date("d F Y", strtotime($map->entry_date)).'<br>
			   Time reported: '.$map->entry_time.'<br>
			   Reported by: '.$map->username.'<br>
			   Contact: '.$map->contact_number.'<br>
			   ';
		
			   
			   $points[] = $mapdata;
		}
		
	}
	   
	$diseasecount = $this->diseasesmodel->get_country_list($country_id);
	$limit = count($diseasecount);
			   
   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);   	
		
	$data['districts'] = $this->districtsmodel->get_list();
	$data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	
	if(empty($zone_id))
	{
		$data['regions'] = $this->regionsmodel->get_list();
		$data['zones'] = $this->zonesmodel->get_country_list($country_id);
	}
	else
	{
		$data['zones'] = $this->zonesmodel->get_country_list($country_id);
		$data['regions']           = $this->regionsmodel->get_by_zone($zone_id);
	}
	
	$data['zone_id'] = $zon_id;
	$data['region_id'] = $reg_id;
	
	$country = $this->countriesmodel->get_by_id($country_id)->row();
	 
	  
	$data['countries'] = $this->countriesmodel->get_list();
	$data['country_id'] = $country_id;	
	$data['diseases'] = $diseases;	
	$data['points'] = $points;
	$data['to_year'] = $reporting_year2;
	$data['to_week'] = $to;	
	$data['points'] = $points;
	$data['map_center'] = $country->map_center;

       $this->load->view('maps/fullscreen', $data);
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


    public function generate_map()
    {
        $healthfacilities = $this->formalertsmodel->get_all_hfs(0,0,1);

        $points = array();

        $map_elements = 'http://maps.google.com/maps/api/staticmap?center=Somalia&zoom=5&size=512x512&maptype=hybrid';


        foreach($healthfacilities as $key=>$healthfacility)
        {
            if(empty($healthfacility->lat))
            {
                //do not show
            }
            else
            {

                $map_elements .= '&markers=icon:http://www.drcdatabase.org/img/letter_h.png|label:H|'.$healthfacility->lat.','.$healthfacility->long.'';

                $gps_coord['lat'] = $healthfacility->lat;
                $gps_coord['lng'] = $healthfacility->long;
                $map_data['position'] = $gps_coord;

                $map_data['icon'] = ''.base_url().'img/drogerie.png';
                $map_data['info'] = '
			   Zone: '.$healthfacility->zone.'<br>
			   Region: '.$healthfacility->region.'<br>
			   District: '.$healthfacility->district.'<br>
			   Health Facility: '.$healthfacility->health_facility.'<br>
			   Focal Point: '.$healthfacility->focal_person_name.'<br>
			   Phone Number: '.$healthfacility->contact_number.'				  
			   ';


                $points[] = $map_data;
            }
        }

        $map_elements .= '&sensor=false';

        echo $map_elements;

        /**
        $image = file_get_contents($map_elements);


        $fp  = fopen('somalia_hf_sites.jpg', 'w+');

        fputs($fp, $image);
        fclose($fp);
        unset($image);

        **/


        $country = $this->countriesmodel->get_by_id(1)->row();
        $data['zone_id'] = 1;
        $data['region_id'] = 1;


        $data['regions'] = $this->regionsmodel->get_list();
        $data['zones'] = $this->zonesmodel->get_country_list(1);
        $data['points'] = $points;
        $data['map_center'] = $country->map_center;

       // $this->load->view('maps/fullscreen_hfs', $data);
    }

   public function fullscreen_all_hfs()
   {
       $healthfacilities = $this->formalertsmodel->get_all_hfs(0,0,1);

       $points = array();


       foreach($healthfacilities as $key=>$healthfacility)
       {
           if(empty($healthfacility->lat))
           {
               //do not show
           }
           else
           {

               $gps_coord['lat'] = $healthfacility->lat;
               $gps_coord['lng'] = $healthfacility->long;
               $map_data['position'] = $gps_coord;

               $map_data['icon'] = 'http://www.drcdatabase.org/img/letter_h.png';
               $map_data['info'] = '
			   Zone: '.$healthfacility->zone.'<br>
			   Region: '.$healthfacility->region.'<br>
			   District: '.$healthfacility->district.'<br>
			   Health Facility: '.$healthfacility->health_facility.'<br>
			   Focal Point: '.$healthfacility->focal_person_name.'<br>
			   Phone Number: '.$healthfacility->contact_number.'				  
			   ';


               $points[] = $map_data;
           }
       }

       $country = $this->countriesmodel->get_by_id(1)->row();
       $data['zone_id'] = 1;
       $data['region_id'] = 1;


       $data['regions'] = $this->regionsmodel->get_list();
       $data['zones'] = $this->zonesmodel->get_country_list(1);
       $data['points'] = $points;
       $data['map_center'] = $country->map_center;

       $this->load->view('maps/fullscreen_all', $data);
   }
   
   public function fullscreen_hfs()
   {
	   $data = array();
	   
	   $level = $this->erkanaauth->getField('level');
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   $zone_id = 0;
	   $region_id = 0;
	   
	 $current_week = date('W');
	 $current_year = date('Y');
	 
	  //$current_week = 29;
	  //$current_year = 2017;
	   
	  $country = $this->countriesmodel->get_by_id($country_id)->row();
	  
	  $last_week = ($current_week-1);
		
	  $epicalendar = $this->epdcalendarmodel->get_by_year_week_country($current_year,$last_week,$country_id)->row();
		
	  if(empty($epicalendar))
	  {
		 $epicalendar_id = 0;
	   }
	   else
	   {
		  $epicalendar_id = $epicalendar->id;
		}
	
	   //get all the health facilities that submitted
	   $maps = $this->formalertsmodel->get_active_hf_period($epicalendar_id,$zone_id,$region_id);
	   
	   $idarrays = array();
	   foreach($maps as $key=>$map)
	   {
		   $idarrays[] = $map->healthfacility_id;
	   }
	   
	   	
	//Health facilities that did not submit
	
	$healthfacilities = $this->formalertsmodel->get_inactive_hf_period($epicalendar_id,$zone_id,$region_id,$country_id,$idarrays);
	
	$points = array();
	
	
	 foreach($healthfacilities as $key=>$healthfacility)
	   {
		if(empty($healthfacility->lat))
		{
			//do not show
		}
		else
		{
						
			$gps_coord['lat'] = $healthfacility->lat;
			$gps_coord['lng'] = $healthfacility->long;
			$map_data['position'] = $gps_coord;
			
			$map_data['icon'] = ''.base_url().'img/hf_with_no_data.png';
			$map_data['info'] = '
			   Zone: '.$healthfacility->zone.'<br>
			   Region: '.$healthfacility->region.'<br>
			   District: '.$healthfacility->district.'<br>
			   Health Facility: '.$healthfacility->health_facility.'<br>
			   Focal Point: '.$healthfacility->focal_person_name.'<br>
			   Phone Number: '.$healthfacility->contact_number.'				  
			   ';
		
			   
			   $points[] = $map_data;
		}
	   }
	   
	   
	   foreach($maps as $key=>$map)
	   {
		if(empty($map->lat))
		{
			//do not show
		}
		else
		{
									
			$gps['lat'] = $map->lat;
			$gps['lng'] = $map->long;
			$mapdata['position'] = $gps;
			
			if($map->No_Alerts==0)
			{
				//has data but no alerts
				$mapdata['icon'] = ''.base_url().'img/hf_data_no_alerts.png';
			}
			else
			{
				if($map->No_Action>0)
				{
					if($map->No_Alerts==$map->No_Action)
					{
						//healthfacility with alerts and all action taken
						$mapdata['icon'] = ''.base_url().'img/hf_with_alert_action.png';
					}
					else
					{
						$mapdata['icon'] = ''.base_url().'img/hf_with_alerts.png';
					}
				}
				else
				{
					//healthfacility with alerts
					$mapdata['icon'] = ''.base_url().'img/hf_with_alerts.png';
					
				}
				
			}
			$mapdata['info'] = '
			   Zone: '.$map->zone.'<br>
			   Region: '.$map->region.'<br>
			   District: '.$map->district.'<br>
			   Health Facility: '.$map->health_facility.'<br>
			   Focal Point: '.$map->focal_person_name.'<br>
			   Phone Number: '.$map->contact_number.'
			   <hr>
				   Week/Year: '.$epicalendar->week_no.'/'.$epicalendar->epdyear.'<br>
				  
			   ';
		
			   
			   $points[] = $mapdata;
		}
		
	}
	
	  $data['zone_id'] = $zone_id;
	  $data['region_id'] = $region_id;
	
	   
	   $data['regions'] = $this->regionsmodel->get_list();
	   $data['zones'] = $this->zonesmodel->get_country_list($country_id);	   	   	
	   $data['points'] = $points;
	   $data['map_center'] = $country->map_center;

       $this->load->view('maps/fullscreen_hfs', $data);
   }
   
    public function getfullscreen_hfs()
   {
			
	$data = array();	 
	  
	  $zone_id = $this->input->post('zone_id');
	  $region_id = $this->input->post('region_id');
	  $healthfacility_id = $this->input->post('healthfacility_id');
	  
	  
	  $level = $this->erkanaauth->getField('level');
	  $country_id = $this->erkanaauth->getField('country_id');
	  $country = $this->countriesmodel->get_by_id($country_id)->row();
	   
	   $reporting_year = $this->input->post('reporting_year');
	   $from = $this->input->post('week_no');
	   
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
	   
	   $epicalendar = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$from,$country_id)->row();
		
	  if(empty($epicalendar))
	  {
		 $epicalendar_id = 0;
	   }
	   else
	   {
		  $epicalendar_id = $epicalendar->id;
		}
		
		
		//get all the health facilities that submitted
	   $maps = $this->formalertsmodel->get_active_hf_period($epicalendar_id,$zone_id,$region_id);
	   
	   $idarrays = array();
	   foreach($maps as $key=>$map)
	   {
		   $idarrays[] = $map->healthfacility_id;
	   }
	   
	   	
	//Health facilities that did not submit
	
	$healthfacilities = $this->formalertsmodel->get_inactive_hf_period($epicalendar_id,$zone_id,$region_id,$country_id,$idarrays);
	
	
	 foreach($healthfacilities as $key=>$healthfacility)
	   {
		if(empty($healthfacility->lat))
		{
			//do not show
		}
		else
		{
						
			$gps_coord['lat'] = $healthfacility->lat;
			$gps_coord['lng'] = $healthfacility->long;
			$map_data['position'] = $gps_coord;
			
			$map_data['icon'] = ''.base_url().'img/hf_with_no_data.png';
			$map_data['info'] = '
			   Zone: '.$healthfacility->zone.'<br>
			   Region: '.$healthfacility->region.'<br>
			   District: '.$healthfacility->district.'<br>
			   Health Facility: '.$healthfacility->health_facility.'<br>
			   Focal Point: '.$healthfacility->focal_person_name.'<br>
			   Phone Number: '.$healthfacility->contact_number.'				  
			   ';
		
			   
			   $points[] = $map_data;
		}
	   }
	   
	   
	   foreach($maps as $key=>$map)
	   {
		if(empty($map->lat))
		{
			//do not show
		}
		else
		{
									
			$gps['lat'] = $map->lat;
			$gps['lng'] = $map->long;
			$mapdata['position'] = $gps;
			
			if($map->No_Alerts==0)
			{
				//has data but no alerts
				$mapdata['icon'] = ''.base_url().'img/hf_data_no_alerts.png';
			}
			else
			{
				if($map->No_Action>0)
				{
					if($map->No_Alerts==$map->No_Action)
					{
						//healthfacility with alerts and all action taken
						$mapdata['icon'] = ''.base_url().'img/hf_with_alert_action.png';
					}
					else
					{
						$mapdata['icon'] = ''.base_url().'img/hf_with_alerts.png';
					}
				}
				else
				{
					//healthfacility with alerts
					$mapdata['icon'] = ''.base_url().'img/hf_with_alerts.png';
					
				}
				
			}
			$mapdata['info'] = '
			   Zone: '.$map->zone.'<br>
			   Region: '.$map->region.'<br>
			   District: '.$map->district.'<br>
			   Health Facility: '.$map->health_facility.'<br>
			   Focal Point: '.$map->focal_person_name.'<br>
			   Phone Number: '.$map->contact_number.'
			   <hr>
				   Week/Year: '.$epicalendar->week_no.'/'.$epicalendar->epdyear.'<br>
				  
			   ';
		
			   
			   $points[] = $mapdata;
		}
		
	}
	   
	   if(empty($zone_id))
		{
			$data['regions'] = $this->regionsmodel->get_list();
			$data['zones'] = $this->zonesmodel->get_country_list($country_id);
		}
		else
		{
			$data['zones'] = $this->zonesmodel->get_country_list($country_id);
			$data['regions']           = $this->regionsmodel->get_by_zone($zone_id);
		}
	
	  $data['zone_id'] = $zon_id;
	  $data['region_id'] = $reg_id;
	   	
		$data['points'] = $points;
		$data['map_center'] = $country->map_center;

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
