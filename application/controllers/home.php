<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//session_start(); //we need to call PHP's session object to access it through CI

class Home extends CI_Controller {



 function __construct()
 {

   parent::__construct();
   $this->load->model('reportsmodel');
   
  }

 function index()
 {
	 //ensure that the user is logged in
	 
	 
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();
	  
	  $level = $this->erkanaauth->getField('level');
	  
	   $active = $this->erkanaauth->getField('active');
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
	   
	   if($active==0)
	   {
		   redirect('home/logout','refresh');
	   }
	  /**
	 if(getRole() != 'SuperAdmin')
	  {
		//redirect('http://ewarn.emro.who.int/'.$country->country_code.'/index.php/home.html', 'refresh');

	  }

	  **/
	  
	  //get the cases for the last 10 weeks back from current week	  
	 //$current_week = date('W');
	 //$current_year = date('Y');
	 
	 $current_week = 29;
	 $current_year = 2017;
	
	 
	  $week_array = $this->getStartAndEndDate($current_week,$current_year);
	
	  $end_date = $week_array['week_start'];
		
	  $start_date = date('Y-m-d', strtotime('-4 weeks', strtotime($end_date)));
	  
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
	  
	  if($level==3)//HF
	   {
		   	   
		   $hf_id = $this->erkanaauth->getField('healthfacility_id'); 
		   $healthfacility = $this->healthfacilitiesmodel->get_by_id($hf_id)->row();
		   $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
		   $dist_id = $district->id;		   		   
		   $region = $this->regionsmodel->get_by_id($district->region_id)->row();
		   $reg_id = $region->id;
		   $zone = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $zon_id = $zone->id;
		   $data['healthfacility'] = $healthfacility;
		   		   
	   }
	 
	  
	 if($level==6)//District
	   {
		   	   
		   $dist_id = $this->erkanaauth->getField('district_id');
		   $district = $this->districtsmodel->get_by_id($dist_id)->row();		   
		   $region = $this->regionsmodel->get_by_id($district->region_id)->row();
		   $reg_id = $region->id;
		   $zone = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $zon_id = $zone->id;
		   $hf_id = 0;
		   $data['district'] = $district;
		   		   
	   }
	 
	  if($level==2)//FP
	   {
		   	   
		   $reg_id = $this->erkanaauth->getField('region_id');		   
		   $region = $this->regionsmodel->get_by_id($reg_id)->row();
		   $zone = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $zon_id = $zone->id;
		   $dist_id = 0;
		   $hf_id = 0;
		   $data['region'] = $region;
		   
	   }
	   
	   if($level==1)//zonal
	   {
		   $zon_id = $this->erkanaauth->getField('zone_id');
		   $zone = $this->zonesmodel->get_by_id($zon_id)->row();
		   $reg_id = 0;
		   $dist_id = 0;
		   $hf_id = 0;
		   $data['zone'] = $zone;
		   
	   }
	   
	   if($level==4)//national
	   {
		  $zon_id = 0;
	  	  $reg_id = 0;
	  	  $dist_id = 0;
	  	  $hf_id = 0;
	   }
	   
	   if($level==5)//stakeholder
	   {
		  $zon_id = 0;
	  	  $reg_id = 0;
	  	  $dist_id = 0;
	  	  $hf_id = 0;
	   }
	  
	 
	  	  
	 
	 $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	 $limit = count($diseasecount);
			   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   
	   
	   unset($diseasecount);
	   
	   
	   $diseasearray = array();
			   
	   foreach ($diseases->result() as $disease):
			$diseasearray[] = $disease->disease_code;
		
						
	   endforeach;


       //$lists = $this->reportsmodel->get_full_list_case_epi_week($from_year,$to_year,$first,$last,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	   $lists = $this->reportsmodel->get_full_list_case_epi_week($from_year,$to_year,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	   
	   $table = '<table id="datatable" border="1"><thead>';		
		$table .= '
		<tr>
		<th>&nbsp;</th>';
		
		foreach ($diseases->result() as $disease):
			$table .= '<th>'.$disease->disease_code.'</th>';
									
		endforeach;
		
			
		$table .= '</tr>
		</thead>
		<tbody>';
		
		$bgcolor = 'bgcolor="#CCCCCC"';		
		foreach ($lists as $key => $list) {
			
			if($bgcolor == 'bgcolor="#CCCCCC"')
			{
				$bgcolor = '';
			}
			else
			{
				$bgcolor = 'bgcolor="#CCCCCC"';
			}
			
			$table .= '<tr '.$bgcolor.'>';
			
			$table .= '<th>Wk'.$list->week_no.' '.$list->reporting_year.'</th>';
			
			foreach($diseasearray as $key=>$diseasecode):
				$disease_element = $diseasecode;
				$table .= '<td>'.$list->$disease_element.'</td>';
				
				unset($disease_element);
			
			endforeach;
			
			
			$table .= '</tr>';
			
		}
		
		
		$table .= '
		</tbody>
		</table>';
		
		unset($bgcolor);
		
		
		$data['table'] = $table;
		
		//if the current week is the first week of the year		
		$find_last_week = ($current_week-1);
		if($find_last_week=0)
		{
			$last_year = ($current_year-1);
			$last_week = 52;
			$query_year = $last_year;
		}
		else
		{
			$query_year = $current_year;
			$last_week = ($current_week-1);
		}
		
		$epicalendar = $this->epdcalendarmodel->get_by_year_week_country($query_year,$last_week,$country_id)->row();
		
		if(empty($epicalendar))
		{
			$epicalendar_id = 0;
		}
		else
		{
			$epicalendar_id = $epicalendar->id;
		}
		
		$formsdata = $this->formsdatamodel->age_gender_totals($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id);		
		
		
		//http://irq-data.emro.who.int/ewarn/
		
		//PERCENTAGE OF REPORTED CASES BY AGE
		
		$total_male = 0;
		$total_female = 0;
		$under_five_total = 0;
		$over_five_total = 0;
			
		foreach($formsdata as $key=>$formdata)
		{
			$total_male = $formdata->total_male;
			$total_female = $formdata->total_female;
			$under_five_total = $formdata->under_five_total;
			$over_five_total = $formdata->over_five_total;
		}
		
				
		//PERCENTAGE OF REPORTED CASES BY SEX
		//Total consultations and number of reporting sites by EPI week		
		
		 $baseline_date = date('Y-m-d', strtotime('-10 weeks', strtotime($end_date)));
		 
		 $first_week = date("W", strtotime($baseline_date));
		 $last_week = date("W", strtotime($end_date));
		 
		 $first_year = date("Y", strtotime($baseline_date));
		 $last_year = date("Y", strtotime($end_date));
		 
		  $epi_lists = $this->epdcalendarmodel->get_list_by_date($baseline_date,$end_date,$country_id);
		  $categories = '';
		  $consultations_column = '';
		  $reporting_sites_column = '';
		  
		
		  foreach($epi_lists as $key=>$epi_list)
		  {
			   $consultations = $this->formsmodel->getconsultations($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);
			   $reporting_sites = $this->formsmodel->getreportingsites($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);
			   
			   $categories .=  "'WK.".$epi_list->week_no."',";			   
			   $consultations_column .= $consultations.',';
			   $reporting_sites_column .= $reporting_sites.',';			 
			
		  }


		 	  
		//Proportion of cases of diarrohea and respiratory category diseases 
		   
	  $mydiseases =  $this->diseasesmodel->get_by_category_country_limit(1,2,$country_id,$limit);
	  
	  unset($limit);
	 		   
	 
	   $mydiseasearray = array();
	   
	   $label = '';
			   
	   foreach ($mydiseases as $key=>$mydisease):
			$mydiseasearray[] = $mydisease->disease_code;
			
			$label .= $mydisease->disease_code.", ";
						
	   endforeach; 
		
		
			$series = '';
			
	
	
		$average_lists = $this->formsmodel->get_diseases_average($baseline_date,$end_date,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$mydiseasearray);
	   
	   foreach($mydiseasearray as $key=>$mydiseasecode):
	   
	   		$series .= '{';
			$series .= "name: '".$mydiseasecode."',";
			$series .= 'data: [';
			
			$average = $mydiseasecode.'_average';
					
			foreach($average_lists as $key=>$average_list)
		   {
			  $series .= number_format($average_list->$average).',';
			  
		   }
				
				
			$series .= ']';
			
			 $series .= '},';
			
		endforeach;
		
				
		
		//disease of interest
		$diseasesofinterest = $this->diseaseofinterestmodel->get_combined_list($country_id); 
		
		$diseseinterestarray = array();
		
		
		//$theseries = "";
		//$thecategories = "";
		foreach($diseasesofinterest as $key=>$diseaseofinterest):
		
			$diseseinterestarray[] = $diseaseofinterest->disease_code;
			/**
			
			$thecode = $diseaseofinterest->disease_code;
			
			$theseries .= "{";
			
			$theseries .= "name: '".$diseaseofinterest->disease_code."',";
			$theseries .= "data: [";
			
			foreach($epi_lists as $key=>$epi_list)
		   {
			     
			   $thecategories .= "'WK.".$epi_list->week_no."',";
			   
			   $seriesdata = $this->formsdatamodel->disease_interest_epi($epi_list->id,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseaseofinterest->disease_code);
			   
			   $theseries .= $seriesdata.',';	
			   	
			
		   }
			
			$theseries .= "]";
			
			$theseries .= "},";
			
			**/
		
		endforeach;
		
	
		
		unset($epi_lists);
		
		
		
		$epi_id_one = $this->epdcalendarmodel->get_by_country_date($country_id,$baseline_date);
		$epi_id_two = $this->epdcalendarmodel->get_by_country_date($country_id,$end_date);
		
		//$interest_lists = $this->formsdatamodel->disease_interest_numbers($epi_id_one,$epi_id_two,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);
        $interest_lists = $this->formsdatamodel->disease_interest_epi_numbers($epicalendaridArray,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);
		$interestseries = '';
		$interestcategory = '';

     foreach($interest_lists as $key=>$interest_list)
     {

         $interestcategory .= "'WK.".$interest_list->week_no."',";

     }
		
	   
	   foreach($diseseinterestarray as $key=>$diseaseinterestcode):
	   
	   		$interestseries .= '{';
			$interestseries .= "name: '".$diseaseinterestcode."',";
			$interestseries .= 'data: [';

           $diseaselists = $this->reportsmodel->get_list_disease_sum($epicalendaridArray, $dist_id, $reg_id, $zon_id, $hf_id,$diseaseinterestcode);
           foreach($diseaselists as $key=>$diseaselist)
           {
               $interestseries .= $diseaselist->Disease_Total.',';
           }
				
			$interestseries .= ']';
			
			$interestseries .= '},';
			
		endforeach;
		

		$healthfacilities = $this->healthfacilitiesmodel->get_list_by_country($country_id);
		
		$total_facilities = count($healthfacilities);
		
		
		//Alerts
		
		$alerts = $this->formalertsmodel->get_sum_by_period($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
		$alert_list = '';
		foreach($alerts as $key=>$alert)
		{
			foreach ($diseases->result() as $disease):
				$disease_element = $disease->disease_code;
								
				if(empty($alert->$disease_element))
				{
					
				}
				else
				{
					$alert_list .= '<li class="text-info">
					<i class="icon-remove red"></i>
					<strong>'.$alert->$disease_element.'</strong> '.$disease->disease_name.'</li>';
				}
			
			endforeach;
		}
		
		$UnDis_alerts = $this->formalertsmodel->get_sum_by_disease_period($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id,'UnDis');
		if($UnDis_alerts!=0)
		{
			$alert_list .= '<li class="text-info">
					<i class="icon-remove red"></i>
					<strong>'.$UnDis_alerts.'</strong> Other unusual diseases or deaths</li>';
		}
		
		$Pf_alerts = $this->formalertsmodel->get_sum_by_disease_period($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id,'Pf');
		if($Pf_alerts!=0)
		{
			$alert_list .= '<li class="text-info">
					<i class="icon-remove red"></i>
					<strong>'.$Pf_alerts.'</strong> Falciparum positive</li>';
		}
		
		$SRE_alerts = $this->formalertsmodel->get_sum_by_disease_period($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id,'SRE');
		if($SRE_alerts!=0)
		{
			$alert_list .= '<li class="text-info">
					<i class="icon-remove red"></i>
					<strong>'.$SRE_alerts.'</strong> Slides/RDT examined</li>';
		}
		
		
		$cases = $this->formalertsmodel->get_total_alerts($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id);
		
		$true_cases = $this->formalertsmodel->get_total_true_alerts($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id);
		
		
		$truealerts = $this->formalertsmodel->get_sum_by_period_true($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
		$true_alert_list = '';
		foreach($truealerts as $key=>$truealert)
		{
			foreach ($diseases->result() as $disease):
				$disease_element = $disease->disease_code;
								
				if(empty($truealert->$disease_element))
				{
					
				}
				else
				{
					$true_alert_list .= '<li class="text-error">
					<strong>'.$truealert->$disease_element.' '.$disease->disease_name.'</strong></li>';
				}
			
			endforeach;
		}
		
	//MAP
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
	
	
	//immediate reporting
	$reportstable = '<table id="customers" border="1"><thead>
	
	<tr><th>Date</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th>
	</thead>
	<tbody>';
	
	 $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($current_year, 40, $country_id)->row();
	 
	 if(empty($reportingperiod))
	 {
		$reportstable .= '<tr><td>No reporting period added</td></tr>';
	 }
	 else
	 {
		$reportingperiod_id = $reportingperiod->id;
		if ($level == 3) {//HF
		 $healthfacility_id = $this->erkanaauth->getField('district_id');
			     $emergencyalerts = $this->emergenciesmodel->get_by_period_healthfacility($reportingperiod_id,$healthfacility_id);
					   
			   }
			   
			   if ($level == 6) {//District
			   	 $district_id = $this->erkanaauth->getField('district_id');
			     $emergencyalerts = $this->emergenciesmodel->get_by_period_district($reportingperiod_id,$district_id);
					   
			   }
			   elseif($level==2)//region
	   		   {
				   $region_id = $this->erkanaauth->getField('region_id');
				   $emergencyalerts = $this->emergenciesmodel->get_by_period_region($reportingperiod_id,$region_id);
			   }
			   elseif($level==1)//zonal
			   {
				   $zone_id = $this->erkanaauth->getField('zone_id');
					$emergencyalerts = $this->emergenciesmodel->get_by_period_zone($reportingperiod_id,$zone_id);	   
			   }
			   else
			   {
				  
			   		$emergencyalerts = $this->emergenciesmodel->get_by_period($reportingperiod_id);
			   }
			   
		$alertscount = count($emergencyalerts);
		
		
			   
		 if(empty($emergencyalerts))
		 {
			$reportstable .= '<tr><td colspan="7">no alerts available</td></tr>';	   
		 }
		 else
		 {
			 //$reportstable .= '<tr><td colspan="7"><strong>Emergency Alerts Count: '.$alertscount.'</strong></td></tr>';
			 $bg = 'bgcolor="#CCCCCC"';
			 
			 foreach($emergencyalerts as $key => $emergencyalert)
			 {
					  $reporting_period = $this->epdcalendarmodel->get_by_id($emergencyalert['epicalendar_id'])->row();
					  $healthfacility = $this->healthfacilitiesmodel->get_by_id($emergencyalert['healthfacility_id'])->row();
					  $thedistrict = $this->districtsmodel->get_by_id($emergencyalert['district_id'])->row();
					  $theregion = $this->regionsmodel->get_by_id($thedistrict->region_id)->row();
					  
					  $thedisease = $this->diseasesmodel->get_by_id($emergencyalert['disease_id'])->row();
					  
					  if(empty($thedisease))
					  {
						  $disease_name = $emergencyalert['other'];
					  }
					  else
					  {
						  $disease_name = $thedisease->disease_name;
					  }
										 
					 $cases = 	($emergencyalert['male_under_five']+$emergencyalert['female_under_five']+$emergencyalert['male_over_five']+$emergencyalert['female_over_five']);	
					 
					if($bg == 'bgcolor="#CCCCCC"')
					{
						$bg = '';
					}
					else
					{
						$bg = 'bgcolor="#CCCCCC"';
					}		   
					  
				  $reportstable .= '<tr '.$bg.'><td>'.$emergencyalert['reporting_date'].'</td><td>'.$disease_name.'</td><td>'.$healthfacility->health_facility.'</td><td>'.$thedistrict->district.'</td><td>'.$theregion->region.'</td><td>'.$cases.'</td><td>'.$emergencyalert['death'].'</td></tr>';
				  }
			 
		 }
	 }
	 
	 $reportstable .= '</tbody></table>';
	
	/**
		
	foreach($maps as $key=>$map)
	{
		
		foreach ($diseases->result() as $disease):
		
		
		
		$count_element = $disease->disease_code;
		
		if(empty($map->lat))
		{
			//do not show
		}
		else
		{
			
			$gps['lat'] = $map->lat;
			$gps['lng'] = $map->long;
			$mapdata['position'] = $gps;
			$mapdata['icon'] = ''.base_url().'img/icon.png';
			$mapdata['info'] = '
			   Zone: '.$map->zone.'<br>
			   Region: '.$map->region.'<br>
			   District: '.$map->district.'<br>
			   Health Facility: '.$map->health_facility.'<br>
			   Alert: '.$disease->disease_code.'<br>
			   Cases: '.$map->$count_element.'<br>
			   Date Reported: '.date("d F Y", strtotime($map->entry_date)).'<br>
			   Time reported: '.$map->entry_time.'<br>
			   Reported by: '.$map->username.'<br>
			   ';
		
			   
			   $points[] = $mapdata;
		}
		
		
		endforeach;
	}
	
	**/
	
	//MAP AJAX
	//https://stackoverflow.com/questions/27373600/fetch-data-from-database-and-plot-it-on-google-map
	//https://www.sofasurfer.org/blog/2011/06/27/dynamic-google-map-markers-via-simple-json-file/
	//http://thisinterestsme.com/generating-google-maps-markers-with-php/
	//http://wsnippets.com/responsive-airbnb-style-google-map-property-listing-using-ajax-php-mysql-and-twitter-bootstrap/
	
	
	$data['points'] = $points;
	$data['total_cases'] = $cases;	
	$data['true_cases'] = $true_cases;
	$data['alert_list'] = $alert_list;	
	$data['true_alert_list'] = $true_alert_list;	
	$data['points'] = $points;	
	$data['series'] = $series;
	$data['label'] = $label;
	$data['interestseries'] = $interestseries;
	$data['reportstable'] = $reportstable;
	$data['interestcategory'] = $interestcategory;
	//$data['thecategories'] = $thecategories;	
	//$data['theseries'] = $theseries;
	
		
	  $data['first_week'] = $first_week;
	  $data['last_week'] = $last_week;
	  $data['first_year'] = $first_year;
	  $data['last_year'] = $last_year;
	  
	  $data['total_facilities'] = $total_facilities;
	  $data['categories'] = $categories;
	  $data['consultations_column'] = $consultations_column;
	  $data['reporting_sites_column'] = $reporting_sites_column;
	  $data['total_male'] = $total_male;	
	  $data['total_female'] = $total_female;
	  $data['under_five_total'] = $under_five_total;
	  $data['over_five_total'] = $over_five_total; 
	  $data['level'] = $level;
	  $data['country'] = $country;
	  $data['from_year'] = $from_year;
	  $data['from_week'] = $from_week;
	  $data['to_year'] = $to_year;
	  $data['to_week'] = $to_week;
	  $data['current_week'] = $current_week;
	  $data['current_year'] = $current_year;
		
		
   	$this->load->view('home/home_view', $data); 
	
	

 }
 
 function getalerts()
 {
	 $points = array();
	
	//$maps = $this->formalertsmodel->get_sum_by_period_map($epicalendar_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	//get_list_by_period_disease
	
	$maps = $this->formalertsmodel->get_list_by_period(184,0,0,0,0);
	
	foreach($maps as $key=>$map)
	{
		if(empty($map->lat))
		{
			//do not show
		}
		else
		{
			
			//$gps['lat'] = $map->lat;
			//$gps['lng'] = $map->long;
			//$mapdata['position'] = $gps;
			
			$mapdata['title'] = 'Alert '.$map->health_facility;
			$mapdata['lat'] = $map->lat;
			$mapdata['description'] = $map->lat;
			
			
			//$mapdata['icon'] = ''.base_url().'img/warning.png';
			$mapdata['content'] = 'xxxx';
		
			   
			   $points[] = $mapdata;
		}
		
	}
	
	echo json_encode($points,JSON_HEX_QUOT | JSON_HEX_TAG);
 }
  
 function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+6 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
}

 function logout()
 {

   $this->erkanaauth->logout();
   $this->session->sess_destroy();

   redirect('login', 'refresh');
   /**
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
   **/
 

 }
 
}

?>