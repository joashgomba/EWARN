<?php

class Bulletin extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'url',
            'my_path'
        ));
        $this->load->model('bulletinsmodel');
		$this->load->model('reportsmodel');
        $this->load->library('Pdf');
    }
    
    public function index()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
        //accessible to all 
        if (getRole() != 'SuperAdmin' && $level != 1 && $level != 2 && $level != 3 && $level != 4 && $level != 5 && $level != 6) {
            redirect('home', 'refresh');
        }
        
		
        $data = array(
            'rows' => $this->bulletinsmodel->get_by_level(4)
        );
		
		$data['level'] = $level;
        $this->load->view('bulletins/index', $data);
    }
	
	public function template()
	{
		//$current_week = date('W');
		//$current_year = date('Y');
		 
		$current_week = 28;
		$current_year = 2017;
		
		$country_id = $this->erkanaauth->getField('country_id');
		$country = $this->countriesmodel->get_by_id($country_id)->row();
		
		
		if($current_week==52)
		{
			$next_week = 1;
			$current_year = $current_year+1;
		}
		else
		{
			$next_week = ($current_week+1);
		}
		
		$epicalendar = $this->epdcalendarmodel->get_by_year_week_country($current_year,$current_week,$country_id)->row();
		
		//$week_array = $this->getStartAndEndDate($current_week,$current_year);
		$week_array = $this->getStartAndEndDate($next_week,$current_year);
		
		$zon_id = 0;
	  	$reg_id = 0;
	  	$dist_id = 0;
	  	$hf_id = 0;
		
		$yearepilists = $this->epdcalendarmodel->get_list_by_year_country($current_year,$country_id);
		$epiyearidArray = array();
		
		foreach($yearepilists as $key=>$yearepilist):
		
			$epiyearidArray[] = $yearepilist['id'];
		endforeach;
		
		$first_id = reset($epiyearidArray);
        $last_id = end($epiyearidArray);
		
		
		/***HIGHLIGH SECTTION **/
		
		$reporting_facilities = $this->formsmodel->getreportingsites($epicalendar->id, $dist_id,$reg_id,$zon_id,$hf_id);
		
		$healthfacilities = $this->healthfacilitiesmodel->get_list_by_country($country_id);
		$total_facilities = count($healthfacilities);
		
		$zones = $this->zonesmodel->get_country_list($country_id);
		$total_zones = count($zones);
		
		if($total_facilities==0)
		{
			$hf_percentage=0;
		}
		else
		{
			$hf_percentage = ($reporting_facilities/$total_facilities)*100;
		}
		
		$consultations = $this->formsmodel->getconsultations($epicalendar->id, $dist_id,$reg_id,$zon_id,$hf_id);
		
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
		
		$previousepi = $this->epdcalendarmodel->get_by_year_week_country($query_year,$last_week,$country_id)->row();
		$previous_consultations = $this->formsmodel->getconsultations($previousepi->id, $dist_id,$reg_id,$zon_id,$hf_id);
		
		
		$previous_reporting_facilities = $this->formsmodel->getreportingsites($previousepi->id, $dist_id,$reg_id,$zon_id,$hf_id);
		if($total_facilities==0)
		{
			$prev_hf_percentage=0;
		}
		else
		{
			$prev_hf_percentage = ($previous_reporting_facilities/$total_facilities)*100;
		}
		
		
		
	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
			   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);	   
	   
	   $diseasearray = array();
	   
	   $colors = "";	   
	   foreach ($diseases->result() as $disease):
	   
			$diseasearray[] = $disease->disease_code;
			//$hex = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);	
			//$colors .= "'".$hex."',";
			
			$colors .= "'".$disease->color_code."',";
								
	   endforeach; 
	   
	   
	   $lists = $this->reportsmodel->get_full_list_case_single_week($epicalendar->id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	   
	   //find the highest number of mobirdity
	   
	   $highlightArray = array();
	   	   
	   foreach($lists as $key=>$list)
	   {
		   foreach($diseasearray as $key=>$diseasecode):
				$disease_element = $diseasecode;
				
				$highlightArray["".$diseasecode.""] = $list->$disease_element;
			
			endforeach;
	   }
	   
	   $highest_highlight_num    = max($highlightArray);
	   $highest_disease = array_keys($highlightArray, max($highlightArray));
	   
	   $total_highlight = $consultations; 
	   $previous_total_highlight = $previous_consultations; 
	   	   
	   if($total_highlight==0)
	   {
		   $highlight_percentage = 0;
	   }
	   else
	   {
		   $highlight_percentage = ($highest_highlight_num/$total_highlight)*100;
	   }
	   
	 				
		$highlight = '<ul>';
		$highlight .= '<li>Reports were received from '.$reporting_facilities.' out of '.$total_facilities.' reporting facilities ('.number_format($hf_percentage,1).'%) in week '.$epicalendar->week_no.'. Compared to '.$previous_reporting_facilities.' ('.number_format($prev_hf_percentage,1).'%) in week '.$previousepi->week_no.'.</li>';		
			
		$highlight .= '<li>The total number of consultatations reported during the reporting week was '.number_format($consultations).' compared to '.number_format($previous_consultations).' consultations during week '.$previousepi->week_no.'. </li>';
		
		
		  
		  //first paragraph
		  $highlight .= '<li>The highest number of consultations in week '.$epicalendar->week_no.' were ';
		   $positions = $this->top_three_positions($highlightArray);
		   $total_percent = 0;
		   
		   $highestdiseaseArray = array();
		 
			foreach($positions as $key=>$position)
			{
							
			   if($total_highlight==0)
			   {
				   $disease_percentage = 0;
			   }
			   else
			   {
				    $disease_percentage = ($position/$total_highlight)*100;
			   }
			   
			   			   
			   if($position==min($positions))
			   {
				   $highlight .= 'followed by ';
			   }
			   
			   $highlight .= $key.'('.number_format($position).' cases)';
			   
			   if($position!=min($positions))
			   {
				   $highlight .= ', ';
			   }
			   else
			   {
				   $highlight .= ' ';
			   }
			   
			   $highestdiseaseArray[] = $key;
			}
			
					
			$highlight .= '</li>';
			
			
			//disease of interest
		$diseasesofinterest = $this->diseaseofinterestmodel->get_combined_list($country_id); 
		
		$diseseinterestarray = array();
		$interestidArray = array();
		foreach($diseasesofinterest as $key=>$diseaseofinterest):
		
			$diseseinterestarray[] = $diseaseofinterest->disease_code;
			$interestidArray[] = $diseaseofinterest->id;
			
		endforeach;
		
		$first_interest_id = reset($interestidArray);
        $last_interest_id = end($interestidArray);
		
		$interest_diseases = '';	
		$diseases_of_interest = '';	
		
		foreach($diseseinterestarray as $key=>$diseaseinterestcode):
		
			$interest_cases = $this->formsdatamodel->disease_interest_epi($epicalendar->id,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseaseinterestcode);
			$previous_cases = $this->formsdatamodel->disease_interest_epi($previousepi->id,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseaseinterestcode);
			
			$cummulative_cases = $this->formsdatamodel->cummulative_interest_figures($first_id,$last_id,$country_id,$diseaseinterestcode);
			
			$interest_diseases .= '<li><strong>'.number_format($cummulative_cases).'</strong> cumulative cases of '.$diseaseinterestcode.'</li>';
			
				
			if($previous_cases<$interest_cases)
			{
				$interesttext = 'There was an increase in the number of '.$diseaseinterestcode.' cases from';
				$conjoin = 'to';
			}
			else if($previous_cases>$interest_cases)
			{
				$interesttext = 'The number of '.$diseaseinterestcode.' decreased from ';
				$conjoin = 'to';
			}
			else
			{
				$interesttext = 'There was no change on the number of '.$diseaseinterestcode.' cases with the number remaining at';
				$conjoin = 'and';
			}
			
			$highlight .= '<li>'.$interesttext.' '.number_format($previous_cases).' cases in week '.$previousepi->week_no.' '.$conjoin.' '.number_format($interest_cases).' cases in week '.$epicalendar->week_no.'</li>';
		 
		 
		 endforeach;
		
		
		
		$highlight .= '</ul>';
		
		/***END HIGHLIGHT***/
		
		/***Cumulative figures***/
		
		$cases = $this->formalertsmodel->get_total_alerts($epicalendar->id,$dist_id,$reg_id,$zon_id,$hf_id);
		$true_cases = $this->formalertsmodel->get_total_true_alerts($epicalendar->id,$dist_id,$reg_id,$zon_id,$hf_id);
		
			
		$cummulative_consultations = $this->formsdatamodel->cummulative_figures($first_id,$last_id,$country_id);
		
		
		$cumulative_figures = '<ul>';
		
				
		$cumulative_figures .= '<li><strong>'.number_format($cummulative_consultations).'</strong> total consultations</li>';
		$cumulative_figures .= $interest_diseases;
		$cumulative_figures .= '<li><strong>'.$reporting_facilities.'</strong> health facilities submitted reports in week '.$epicalendar->week_no.'</li>';
		$cumulative_figures .= '<li><strong>'.$cases.'</strong> Alerts were received from all regions</li>';
		$cumulative_figures .= '<li><strong>'.$true_cases.'</strong> were true alerts</li>';
		
		$cumulative_figures .= '</ul>';
		
		/******/
		
		
	
	    $end_date = $week_array['week_start'];
		
		$baseline_date = date('Y-m-d', strtotime('-10 weeks', strtotime($end_date)));
		 
		 $first_week = date("W", strtotime($baseline_date));
		 $last_week = date("W", strtotime($end_date));
		 
		 $first_year = date("Y", strtotime($baseline_date));
		 $last_year = date("Y", strtotime($end_date));
		 
		 /****End consultations and reporting rates****/
		 
		 $epi_lists = $this->epdcalendarmodel->get_list_by_date($baseline_date,$end_date,$country_id);
		 $categories = '';
		 $consultations_column = '';
		 $reporting_sites_column = '';
		 
		 foreach($epi_lists as $key=>$epi_list)
		  {
			   $consultations = $this->formsmodel->getconsultations($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);
			   $reporting_sites = $this->formsmodel->getreportingsites($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);
			   
			   $categories .=  "'Wk".$epi_list->week_no."',";			   
			   $consultations_column .= $consultations.',';
			   $reporting_sites_column .= $reporting_sites.',';			 
			
		  }
		  
		  
		  //zone reporting rates
		  
		  $zonecategories    = "";
          $zonereportingrate = "";
		
		  foreach($zones as $key=>$zone)
		  {
			$thezonehf = $this->healthfacilitiesmodel->get_by_zone($zone['id']);
			$hfsinzone          = count($thezonehf->result());
			
			$zone_reporting_sites = $this->formsmodel->getreportingsites($epicalendar->id, $dist_id,$reg_id,$zone['id'],$hf_id);
			 if ($zone_reporting_sites == 0) {
                $percentagezonereporting = 0;
            } else {
                $percentagezonereporting = ($zone_reporting_sites / $hfsinzone) * 100;
            }
			
			$zonecategories .= "'" . $zone['zone'] . "',";
			
			$zonereportingrate .= number_format($percentagezonereporting, 1) . ", ";
			  
		  }
			  
	  
	  	/****End consultations and reporting rates****/
		
		/**alerts map **/
			
			$points = array();
			
			$maps = $this->formalertsmodel->get_list_by_period($epicalendar->id,$dist_id,$reg_id,$zon_id,$hf_id);
			
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
			
			/**End alerts map***/
			
			
			/******EPI curve******/
			
			$epi_id_one = $this->epdcalendarmodel->get_by_country_date($country_id,$baseline_date);
			$epi_id_two = $this->epdcalendarmodel->get_by_country_date($country_id,$end_date);
			
			$interest_lists = $this->formsdatamodel->disease_interest_numbers($epi_id_one,$previousepi->id,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);
			
			$interestseries = '';
			$interestcategory = '';
			
			$seriescolor = "";
			
			
			//foreach($diseseinterestarray as $key=>$diseaseinterestcode):
			foreach($diseasesofinterest as $key=>$diseaseofinterest):
	   
	   		$interestseries .= '{';
			$interestseries .= "name: '".$diseaseofinterest->disease_code."',";
			$interestseries .= 'data: [';
			
			$seriescolor .= "'".$diseaseofinterest->color_code."',";
			
			$elem = $diseaseofinterest->disease_code;
			
			foreach($interest_lists as $key=>$interest_list)
		   {
			  $interestseries .= number_format($interest_list->$elem).',';
			  
			 
			  
		   }
				
				
			$interestseries .= ']';
			
			$interestseries .= '},';
			
		endforeach;
			
			/********End EPI curve************/
			
	/***Number of alerts received and reported***/
	 $alerts = $this->reportsmodel->get_full_list_alert_week($query_year,$current_year,$previousepi->id,$epicalendar->id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	 
	 $graphcategories = '';
	 $alertseries = '';
		  
	 foreach ($alerts as $key => $alert) {
				  
		$graphcategories .= "'Wk".$alert->week_no."',";				  
	}
	
	foreach($diseasearray as $key=>$diseasecode):
		  	
			$alertseries .= "{
                name: '".$diseasecode."',
				data: [";
		  
			  foreach ($alerts as $key => $alert) {
				  
				  $alert_element = $diseasecode;
				  
				  $alertseries .= $alert->$alert_element.",";
				  
			  }
			  
			 $alertseries .= "]";
			  
			 $alertseries .= "},";
		  
	endforeach;
		  		
		
		/***End alerts received**/
	 
	 		
	/***********Summary of diseases reported***********/
	
	$caselists = $this->reportsmodel->get_full_list_case_week($first_year,$last_year,$previousepi->id,$epicalendar->id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	
	//$caselists = $this->formsmodel->get_full_list($first_year, $last_year, $previousepi->id,$epicalendar->id, $dist_id, $reg_id, $zon_id, $hf_id,$diseasearray);
	
	//get previous week data
		 $previouslists = $this->reportsmodel->get_full_list_case_single_week($previousepi->id,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
		 
		$leadingdiseasetable = '<table border="1" id="datatable">';
		$leadingdiseasetable .= '<tr bgcolor="#892A24" bordercolor="#892A24"><td><font color="#FFFFFF">Disease/syndrome</font></td>';
		
		foreach ($caselists as $key => $caselist):
			
				$leadingdiseasetable .='<td colspan="3" align="center"><font color="#FFFFFF">Epi week ' . $caselist->week_no . '</font></td>';
				
			endforeach;
			
			$leadingdiseasetable .= '</tr>';
			 $leadingdiseasetable .= '<tr bgcolor="#892A24"><td>&nbsp;</td><td><font color="#FFFFFF">Cases &lt;5</font></td><td><font color="#FFFFFF">Cases &gt;5</font></td><td><font color="#FFFFFF">Total Cases</font></td><td><font color="#FFFFFF">Cases &lt;5</font></td><td><font color="#FFFFFF">Cases &gt;5</font></td><td><font color="#FFFFFF">Total Cases</font></td></tr>';
		
		$total_current_week = 0;
	    $total_previous_week = 0;
		$bg_color = 'bgcolor="#CCCCCC"';
		
		foreach($diseasearray as $key=>$highestdiseasecode)
			 {
				 
				 if($bg_color == 'bgcolor="#CCCCCC"')
				 {
					 $bg_color = '';
				 }
				 else
				 {
					 $bg_color = 'bgcolor="#CCCCCC"';
				 }
			 	$leadingdiseasetable .= '<tr '.$bg_color.'><td>'.$highestdiseasecode.'</td>';
				 foreach ($caselists as $key => $caselist):
				 
				 	$high_disease_element = $highestdiseasecode;
					$under_five_element = $highestdiseasecode.'_T_U_F';
					$over_five_element = $highestdiseasecode.'_T_O_F';
					
					if($caselist->epicalendar_id==$epicalendar->id)
					{
						/**
						if($total_highlight==0)
						{
							$disease_week_percentage = 0;
						}
						else
						{
							$disease_week_percentage = ($caselist->$high_disease_element/$total_highlight)*100;
						}
						**/
						$total_current_week = $total_current_week+$caselist->$high_disease_element;
						
					}
					else
					{
						/**
						if($previous_total_highlight==0)
						{
							$disease_week_percentage = 0;
						}
						else
						{
							$disease_week_percentage = ($caselist->$high_disease_element/$previous_total_highlight)*100;
						}
						**/
						
						$total_previous_week = $total_previous_week+$caselist->$high_disease_element;
					}
				 
				 	$leadingdiseasetable .= '<td>'.number_format($caselist->$under_five_element).'</td><td>'.number_format($caselist->$over_five_element).'</td><td>'.number_format($caselist->$high_disease_element).'</td>';
				 endforeach;
				 
				 $leadingdiseasetable .= '</tr>';
			 }
			 
			 
		$leadingdiseasetable .= '</table>';
		/***********Summary of diseases reported***********/
		
		/**Trends of malaria morbidity in week **/
		
		$alert_end_date = $week_array['week_start'];
			
		  $alert_start_date = date('Y-m-d', strtotime('-4 weeks', strtotime($alert_end_date)));
		  
		  $alertepilists = $this->epdcalendarmodel->get_list_by_date($alert_start_date,$alert_end_date,$country_id);
		  
		  $alertepicalendaridArray = array();
		  $alertyearArray = array();
		  $alertweekArray = array();
		 
		  foreach($alertepilists as $key=>$alertepilist)
		  {
			$alertepicalendaridArray[] =  $alertepilist->id;  
			$alertyearArray[] =  $alertepilist->epdyear; 
			$alertweekArray[] =  $alertepilist->week_no; 
			
		  }
		  
		  //if the country has no calendar added
		  if(empty($alertepicalendaridArray))
		  {
			
			  $firstid = 0;
			  $lastid = 0;
			  $alert_from_date = DateTime::createFromFormat("Y-m-d", $alert_start_date);
			  $alert_from_year =  $alert_from_date->format("Y");
			  
			  $alert_to_date = DateTime::createFromFormat("Y-m-d", $alert_end_date);
			  $alert_to_year =  $alert_to_date->format("Y");
			  
			  $alert_from_week = date("W", strtotime($alert_start_date));
			  $alert_to_week = date("W", strtotime($alert_end_date));
		  }
		  else
		  {
		  
			  $firstid = reset($alertepicalendaridArray);
			  $lastid = end($alertepicalendaridArray);
			  
			  $alert_from_year = reset($alertyearArray);
			  $alert_to_year = end($alertyearArray);
			  
			  $alert_from_week = reset($alertweekArray);
			  $alert_to_week = end($alertweekArray);
			  
		  }
		  
		
		$malarialists = $this->formsmodel->malariareport($firstid,$lastid,$dist_id,$reg_id,$zon_id);
		$malariacategories = '';
		$malariadata = '';
		$frdata = '';
		$sprdata = '';
		$malariaufivedata = '';
		$malariaofivedata = '';
		
		foreach ($malarialists as $key => $malarialist) {
			
			$totalslides = $malarialist->totpv + $malarialist->totpmix + $malarialist->totpf;
			$sre = $malarialist->totsre;
			
			if($totalslides==0)
			{
				$spr = 0;
				$fr = 0;
			}
			else
			{
				if($sre==0)
				{
					$spr = 0;
				}
				else
				{
					$spr = ($totalslides/$sre) * 100;
				}
				$fr = ($malarialist->totpf/$totalslides) * 100;
			}
			
			$malariacategories .= "'WK ".$malarialist->epdyear."/".$malarialist->week_no."', ";
			$frdata .= "".number_format($fr).", ";
			$sprdata .= "".number_format($spr).", ";
			
			
		}
		
		unset($malarialists);
		
		$mallists = $this->formsmodel->malariadata($firstid,$lastid,$dist_id,$reg_id,$zon_id);
		
		
		foreach ($mallists as $key => $mallist) {
			
			$malariaufivedata .= "".$mallist->disease_under_five.", ";
			$malariaofivedata .= "".$mallist->disease_over_five.", ";
			
		}
		
		unset($mallists);
		
		
		/**End rends of malaria morbidity in week **/
		
		
		/**Summary of malaria morbidity**/
		
		$zonesarray = array();
		foreach($zones as $key=>$zone)
		{
			$zonesarray[] = $zone['id'];
		}
		
		$malariareports = $this->formsmodel->malaria_week_report_zones($epicalendar->id,$zonesarray);
		$malariazonereports = $this->formsdatamodel->malaria_week_report_zones($epicalendar->id,$zonesarray);
		
		
		$malariatable = '<table border="1" id="datatable">';
		
		$malariatable .= '<tr bgcolor="#892A24" bordercolor="#892A24"><td><font color="#FFFFFF">&nbsp;</font></td>';
		
		
		foreach($zones as $key=>$zone)
		{
			$malariatable .= '<td><font color="#FFFFFF">'.$zone['zone'].'</font></td>';  
			  
		}
		
		$malariatable .= '</tr>';
		
				
		for($i=1;$i<=7;$i++)
		{
			if($i==1)
			{
				$td_element = 'Pf';
			}
			if($i==2)
			{
				$td_element = 'Pv';
			}
			if($i==3)
			{
				$td_element = 'Mixed';
			}
			if($i==4)
			{
				$td_element = 'SPR';
			}
			if($i==5)
			{
				$td_element = 'FR';
			}
			if($i==6)
			{
				$td_element = 'Total +ve Slides';
			}
			if($i==7)
			{
				$td_element = 'Total Slides Tested';
			}
			$malariatable .= '<tr><td>'.$td_element.'</td>';
		
				foreach($zonesarray as $key=>$zoneid)
				{
					$malariatable .= '<td>';
					
					foreach($malariareports as $key=>$malariareport):
					
					if($i==1)
					{
						
						if($malariareport->zone_id==$zoneid)
						{
							$malariatable .= $malariareport->totpf;
						}
						else
						{
							$malariatable .= 0;
						}
						
					}
					if($i==2)
					{
						if($malariareport->zone_id==$zoneid)
						{
							$malariatable .= $malariareport->totpv;
						}
						else
						{
							$malariatable .= 0;
						}
					}
					if($i==3)
					{
						if($malariareport->zone_id==$zoneid)
						{
							$malariatable .= $malariareport->totpmix;
						}
						else
						{
							$malariatable .= 0;
						}
					}
					if($i==4)
					{
						
						if($malariareport->zone_id==$zoneid)
						{
							
							if($malariareport->totsre==0)
							{
								$malariatable .= '0%';
							}
							else
							{
								if($malariareport->slides_tested==0)
								{
									$malariatable .= '0%';
								}
								else
								{
									$spr = ($malariareport->slides_tested/$malariareport->totsre) * 100;
									$malariatable .= number_format($spr).'%';
								}
							}
							
						}
						else
						{
							$malariatable .= '0%';
						}
					
					}
					if($i==5)
					{
						if($malariareport->zone_id==$zoneid)
						{
							if($malariareport->totsre==0)
							{
								$malariatable .= '0%';
							}
							else
							{
								if($malariareport->slides_tested==0)
								{
									$malariatable .= '0%';
								}
								else
								{
									$fr = ($malariareport->totpf/$malariareport->slides_tested) * 100;
									$malariatable .= number_format($fr).'%';
								}
								
							}
						}
						else
						{
							$malariatable .= '0%';
						}
						
					
					}
					if($i==6)
					{
						if($malariareport->zone_id==$zoneid)
						{
							$malariatable .= $malariareport->positive_slides;
						}
						else
						{
							$malariatable .= 0;
						}
					}
					if($i==7)
					{
						if($malariareport->zone_id==$zoneid)
						{
							$malariatable .= $malariareport->slides_tested;
						}
						else
						{
							$malariatable .= 0;
						}
					}
					
					endforeach;
					
					$malariatable .= '</td>';  
					  
				}
				
				
				$malariatable .= '</tr>';
		}
		
		$malariatable .= '<tr><td>Clinically Suspected</td>';
		
		foreach($zonesarray as $key=>$zoneid)
		{
		  $malariatable .= '<td>';
					
		   foreach($malariazonereports as $key=>$malariazonereport):
		   
				if($malariazonereport->zone_id==$zoneid)
				{
					$malariatable .= $malariazonereport->diease_total;
				}
				else
				{
					$malariatable .= 0;
				}
		   
		   endforeach;
		   
		   $malariatable .= '</td>';
		}
					
					
		
		
		$malariatable .= '</tr>';
		
		
		$malariatable .= '</table>';
		
		unset($malariazonereports);
		unset($malariareports);
		
		
		/**end 	Summary of malaria morbidity **/
		
		
		/*******Summary of diseases of interest by region********/
		$final_date = $week_array['week_start'];
		$first_date = date('Y-m-d', strtotime('-3 weeks', strtotime($final_date)));
		$epilists = $this->epdcalendarmodel->get_list_by_date($first_date,$final_date,$country_id);
	  
	  //$epicalendaridArray = array();
	  //$yearArray = array();
	  //$weekArray = array();
	  
	  //$first_interest_id = reset($interestidArray);
     // $last_interest_id = end($interestidArray);
	 
	 $thedisease = $this->diseasesmodel->get_by_id($first_interest_id)->row();
	  
	  $interesttable = '<table border="1" id="datatable">';
	  $interesttable .= '<tr bgcolor="#892A24" bordercolor="#892A24"><td colspan="10"><font color="#FFFFFF">Summary of '.$thedisease->disease_name.' cases by region as of week '.$epicalendar->week_no.', '.$epicalendar->epdyear.'</font></td></tr>';
	  $interesttable .= '<tr bgcolor="#892A24" bordercolor="#892A24"><td><font color="#FFFFFF">Region</font></td>';
	 
	  $intarray[] = array();
	  foreach($epilists as $key=>$epilist)
	  {
		$intarray[] =  $epilist->id;  
		//$yearArray[] =  $epilist->epdyear; 
		//$weekArray[] =  $epilist->week_no; 
		
		$interesttable .= '<td colspan="3"><font color="#FFFFFF">Week '.$epilist->week_no.'</font></td>';
		
	  }

	  
	   $interesttable .= '</tr>';
	   
	   $interesttable .= '<tr bgcolor="#892A24"><td>&nbsp;</td><td><font color="#FFFFFF">Cases &lt;5</font></td><td><font color="#FFFFFF">Cases &gt;5</font></td><td><font color="#FFFFFF">Total Cases</font></td><td><font color="#FFFFFF">Cases &lt;5</font></td><td><font color="#FFFFFF">Cases &gt;5</font></td><td><font color="#FFFFFF">Total Cases</font></td><td><font color="#FFFFFF">Cases &lt;5</font></td><td><font color="#FFFFFF">Cases &gt;5</font></td><td><font color="#FFFFFF">Total Cases</font></td></tr>';
	   
	   $regionarray = array();
	   $regions = $this->regionsmodel->get_by_country($country_id);
	   
	   
	   foreach($regions as $key=>$region)
	   {
		   $regionarray[] = $region->id;
		   
	   }
	   
	   
	   $regionsinterest = $this->diseaseofinterestmodel->get_cases_by_region($firstid,$lastid,$first_interest_id,$regionarray);
		
		
		
	   foreach($regions as $key=>$region)
	   {
		  
		   
		   
		   if($bg_color == 'bgcolor="#CCCCCC"')
		   {
				$bg_color = '';
		   }
		   else
		   {
			   $bg_color = 'bgcolor="#CCCCCC"';
		   }
		   
		   $interesttable .= '<tr '.$bg_color.'><td>'.$region->region.'</td>';
		  
		 	$j = 0;
		    foreach($epilists as $key=>$epilist)
			{
				
				
				
				/**
				$epicases = $this->diseaseofinterestmodel->get_cases_by_region_disease($region->id, $first_interest_id, $epilist->id);
				
				$interesttable .= '<td>'.$epicases->under_five.'</td><td>'.$epicases->over_five.'</td><td>'.number_format($epicases->disease_total).'</td>';
				
				**/
				
				
				
				foreach($regionsinterest as $key=>$regioninterest):
				
				$j++;
				
				$under_five = "Region_".$region->id."_T_U_F";
				$over_five = "Region_".$region->id."_T_O_F";
				$total_cases = "Region_".$region->id;
				
				/**
				
					if($regioninterest->epicalendar_id==$epilist->id)
					{
						**/
						$under_five_col = $regioninterest->$under_five;
						$over_five_col = $regioninterest->$over_five;
						$cases_col = $regioninterest->$total_cases;
					/**	
						echo $regioninterest->epicalendar_id.''.$epilist->id.'<br>';
					}
					else
					{
						$under_five_col = 0;
						$over_five_col = 0;
						$cases_col = 0;
					}
					**/
					
				if($j<=3)
				{
					$interesttable .= '<td>'.number_format($under_five_col).'</td><td>'.number_format($over_five_col).'</td><td>'.number_format($cases_col).'</td>';	
				}
			
				
					
					
				endforeach;
			
								
			}
		   
		   
		   
		   $interesttable .= '</tr>';
	   }	
	   
	    
	  
	  $interesttable .= '</table>';
	  
	  
	  unset($regionarray);
	  unset($regions);
	  unset($regionsinterest);
	  unset($j);
	  unset($under_five);
	  unset($over_five);
	  unset($total_cases);

	  
	  $secdisease = $this->diseasesmodel->get_by_id($last_interest_id)->row();
	  
	  $lastinteresttable = '<table border="1" id="datatable">';
	  $lastinteresttable .= '<tr bgcolor="#892A24" bordercolor="#892A24"><td colspan="10"><font color="#FFFFFF">Summary of '.$secdisease->disease_name.' cases by region as of week '.$epicalendar->week_no.', '.$epicalendar->epdyear.'</font></td></tr>';
	  $lastinteresttable .= '<tr bgcolor="#892A24" bordercolor="#892A24"><td><font color="#FFFFFF">Region</font></td>';
	 
	  
	  foreach($epilists as $key=>$epilist)
	  {
				
		$lastinteresttable .= '<td colspan="3"><font color="#FFFFFF">Week '.$epilist->week_no.'</font></td>';
		
	  }

	  
	   $lastinteresttable .= '</tr>';
	   
	   $lastinteresttable .= '<tr bgcolor="#892A24"><td>&nbsp;</td><td><font color="#FFFFFF">Cases &lt;5</font></td><td><font color="#FFFFFF">Cases &gt;5</font></td><td><font color="#FFFFFF">Total Cases</font></td><td><font color="#FFFFFF">Cases &lt;5</font></td><td><font color="#FFFFFF">Cases &gt;5</font></td><td><font color="#FFFFFF">Total Cases</font></td><td><font color="#FFFFFF">Cases &lt;5</font></td><td><font color="#FFFFFF">Cases &gt;5</font></td><td><font color="#FFFFFF">Total Cases</font></td></tr>';
	   
	   $regionarray = array();
	   $regions = $this->regionsmodel->get_by_country($country_id);
	   
	   
	   foreach($regions as $key=>$region)
	   {
		   $regionarray[] = $region->id;
		   
	   }
	   
	   
	   $regionsinterest = $this->diseaseofinterestmodel->get_cases_by_region($firstid,$lastid,$last_interest_id,$regionarray);
		
		
		
	   foreach($regions as $key=>$region)
	   {
		  
		   if($bg_color == 'bgcolor="#CCCCCC"')
		   {
				$bg_color = '';
		   }
		   else
		   {
			   $bg_color = 'bgcolor="#CCCCCC"';
		   }
		   
		   $lastinteresttable .= '<tr '.$bg_color.'><td>'.$region->region.'</td>';
		  
		 	$j = 0;
		    foreach($epilists as $key=>$epilist)
			{
				
				 
				 
				
				/**
				$epicases = $this->diseaseofinterestmodel->get_cases_by_region_disease($region->id, $first_interest_id, $epilist->id);
				
				$interesttable .= '<td>'.$epicases->under_five.'</td><td>'.$epicases->over_five.'</td><td>'.number_format($epicases->disease_total).'</td>';
				
				**/
				
				
				
				foreach($regionsinterest as $key=>$regioninterest):
				
				$j++;
				
				$under_five = "Region_".$region->id."_T_U_F";
				$over_five = "Region_".$region->id."_T_O_F";
				$total_cases = "Region_".$region->id;
				
				/**
				
					if($regioninterest->epicalendar_id==$epilist->id)
					{
						**/
						$under_five_col = $regioninterest->$under_five;
						$over_five_col = $regioninterest->$over_five;
						$cases_col = $regioninterest->$total_cases;
					/**	
						echo $regioninterest->epicalendar_id.''.$epilist->id.'<br>';
					}
					else
					{
						$under_five_col = 0;
						$over_five_col = 0;
						$cases_col = 0;
					}
					**/
					
				if($j<=3)
				{
					$lastinteresttable .= '<td>'.number_format($under_five_col).'</td><td>'.number_format($over_five_col).'</td><td>'.number_format($cases_col).'</td>';	
				}
			
				
					
					
				endforeach;
				
							
			}
		   
		   
		   
		   $lastinteresttable .= '</tr>';
	   }	
	   
	    
	  
	  $lastinteresttable .= '</table>';
		
		unset($epiyearidArray);
		unset($yearepilists);
		
		
	    /*****Summary of epidemic prone diseases and syndromes in different districts******/
	  $districts = $this->districtsmodel->get_by_country($country_id);
	  
	  $districtarray = array();
	  
	  foreach($districts as $key=>$district)
	  {
		  $districtarray[] = $district->id;
	  }
	  
	  		
	  $districtdiseases = $this->formsmodel->location_disease_week($epicalendar->id,$districtarray,$diseasearray);
	  
	  $colspan = ($limit+1);
	  
	  $summarytable = '<table border="1" id="datatable">';
	  $summarytable .= '<thead>';
	  $summarytable .= '<tr bgcolor="#892A24"><td colspan="'.$colspan.'"><font color="#FFFFFF">Summary of epidemic prone diseases and syndromes in different '.$country->third_admin_level_label.' of '.$country->country_name.' as of week '.$epicalendar->week_no.'</font></td></tr>';
	  
	  $summarytable .= '<tr bgcolor="#892A24"><td><font color="#FFFFFF">'.$country->third_admin_level_label.'</font></td>';
	  
	  foreach($diseasearray as $key=>$highestdiseasecode)
	  {
		 $summarytable .= '<td><font color="#FFFFFF">'.$highestdiseasecode.'</font></td>';
				
	  }
	 
	 $summarytable .= '</tr>
	 </thead>
	 <tbody>';
	 
	 
	 
	 /**
	 foreach($districts as $key=>$district)
	  {
		  $summarytable .= '<tr><td>'.$district->district.'</td>';
		  $k = 0;
		  foreach($districtdiseases as $key=>$districtdisease):
		 foreach($diseasearray as $key=>$highestdiseasecode)
		 {
			   
				
					$k++;
					$disease_element = $highestdiseasecode;
					$district_element = $district->id;
					
					
					if($district->id==$districtdisease->district_id)
					{
						$total_disease_cases = $districtdisease->$disease_element;
						$summarytable .= '<td>'.$total_disease_cases.'</td>';
					}
					
					
				
			    
			  
		   }
		   
		   endforeach;
		  
		  
		  $summarytable .= '</tr>';
	  }
	  
	  **/
	  
	  foreach($districtdiseases as $key=>$districtdisease):
	  
	  	  if($bg_color == 'bgcolor="#CCCCCC"')
		  {
			 $bg_color = '';
		   }
		   else
		   {
			   $bg_color = 'bgcolor="#CCCCCC"';
		   }
	  
	  	 $summarytable .= '<tr '.$bg_color.'><td>'.$districtdisease->district.'</td>';
	  
		 foreach($diseasearray as $key=>$highestdiseasecode)
		 {
			  $disease_element = $highestdiseasecode;
			  $district_element = $district->id;
			
			  $total_disease_cases = $districtdisease->$disease_element;
			  $summarytable .= '<td>'.$total_disease_cases.'</td>';			  	    
			  
		  }
		  
		 $summarytable .= '</tr>';
		   
	endforeach;
	 
	
	 $summarytable .= '
	 </tbody>
	 </table>';
		
		
					
		$data = array();
		
		$data['first_year'] = $first_year;
	    $data['last_year'] = $last_year;
	    $data['first_week'] = $first_week;
	    $data['last_week'] = $last_week;
		$data['map_center'] = $country->map_center;
		$data['epicalendar'] =  $epicalendar;
		$data['country'] =  $country;
		$data['highlight'] =  $highlight;
		$data['cumulative_figures'] = $cumulative_figures;
		$data['zonereportingrate'] =  $zonereportingrate;
		$data['zonecategories'] =  $zonecategories;
		$data['consultations_column'] =  $consultations_column;
		$data['reporting_sites_column'] =  $reporting_sites_column;
		$data['total_facilities'] =  $total_facilities;
		$data['categories'] =  $categories;
		$data['graphcategories'] = $graphcategories;
	    $data['alertseries'] = $alertseries;
		$data['points'] =  $points;
		$data['interestseries'] = $interestseries;
		$data['previous_week'] = $previousepi->week_no;
		$data['leadingdiseasetable'] = $leadingdiseasetable;
		$data['malariacategories'] = $malariacategories;
		$data['frdata'] = $frdata;
	    $data['sprdata'] = $sprdata;
		$data['malariaufivedata'] = $malariaufivedata;
	    $data['malariaofivedata'] = $malariaofivedata;
		$data['malariatable'] = $malariatable;
		$data['interesttable'] = $interesttable;
		$data['lastinteresttable'] = $lastinteresttable;
		$data['summarytable'] = $summarytable;
		$data['diseases'] = $diseases;
		$data['previousepi'] = $previousepi;
		$data['colors'] = $colors;
		$data['seriescolor'] = $seriescolor;
		
		
		$this->load->view('bulletins/newtemplate', $data);
	}
	
	
	function top_three_positions($array){

	  // Sort the array from max to min
	  arsort($array);
	
	  // Unset everything in  sorted array after the first three elements
	  $count = 0;
	  foreach($array as $key => $ar){
		if($count > 2){
		   unset($array[$key]);
		}
		$count++;
	  }
	
	  // Return array with top 3 values with their indexes preserved.
	  return $array;
	}

	
	
	function getStartAndEndDate($week, $year) {
		  $dto = new DateTime();
		  $dto->setISODate($year, $week);
		  $ret['week_start'] = $dto->format('Y-m-d');
		  $dto->modify('+6 days');
		  $ret['week_end'] = $dto->format('Y-m-d');
		  return $ret;
	}
	
	
}
