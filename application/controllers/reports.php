<?php

class Reports extends CI_Controller {

   function __construct()
   {
       parent::__construct();
	   $this->load->model('reportsmodel');
	   $this->load->model('exportmodel');
   }

   public function index()
   {
      $this->weeklydiseasecasesquery();
   }
   
   public function weeklydiseasecasesquery()
   {
	      //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

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
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
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
	   
	   $data['level'] = $level;

       $this->load->view('reports/weeklydiseasecasesquery', $data);
   }
   
   public function weeklydiseasealertsquery()
   {
	       //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	   $data = array();
	   
	    $level = $this->erkanaauth->getField('level');
		
		if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {
            
            redirect('home', 'refresh');
            
        }
		
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
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
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
	   
	   $data['level'] = $level;

       $this->load->view('reports/weeklydiseasealertsquery', $data);
   }
   
   public function weeklydiseasealerts()
   {
	   if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();
	  
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
	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	   
	   	   
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	    $status = 0;
		
	   $categories = '';
	   $sarivalues = '';
	   $awdvalues = '';
	   $diphvalues = '';
	   $wcvalues = '';
	   $measvalues = '';
	   $afpvalues = '';
	   $vhfvalues = '';
	   $menvalues = '';
	   
	   if ($reporting_year == $reporting_year2) {
           for($i=$period_one;$i<=$period_two;$i++)
			{
				$thereportingperiod = $this->epdcalendarmodel->get_by_id($i)->row();
				$categories .= "'Wk".$thereportingperiod->week_no."',";
				$alerts = $this->reportsmodel->get_sum_by_period_locations($zon_id, $reg_id, $dist_id, $hf_id, $i,$status);
				$numalerts = count($alerts);
					
					if($numalerts==0)
					{
						 $sarivalues .= '0,';
						   $awdvalues .= '0,';
						   $diphvalues .= '0,';
						   $wcvalues .= '0,';
						   $measvalues .= '0,';
						   $afpvalues .= '0,';
						   $vhfvalues .= '0,';
						   $menvalues .= '0,';
					}
					else
					{
						foreach($alerts as $key=>$alert)
						{
							if($alert->disease_name=='SARI')
							{
								 $sarivalues .= $alert->reported_cases.',';
								   
							}
							
							if($alert->disease_name=='AWD')
							{
								 $awdvalues .= $alert->reported_cases.',';
								
							}
							
							if($alert->disease_name=='Diph')
							{
								 $diphvalues .= $alert->reported_cases.',';
								
							}
							
							if($alert->disease_name=='WC')
							{
								 $wcvalues .= $alert->reported_cases.',';
								
							}
							
							if($alert->disease_name=='Meas')
							{
								 $measvalues .= $alert->reported_cases.',';
								
							}
							
							if($alert->disease_name=='AFP')
							{
								 $afpvalues .= $alert->reported_cases.',';
							
							}
							
							if($alert->disease_name=='VHF')
							{
								 $vhfvalues .= $alert->reported_cases.',';
							}
							
							if($alert->disease_name=='Men')
							{
								 $menvalues .= $alert->reported_cases.',';
								 
							}
							
						}
					}
			}
        } else {
            if ($reporting_year2 > $reporting_year) {
				
				if($reporting_year=='2012')
				{
					for($i=$period_two;$i<=$period_one;$i++)
					{
						$thereportingperiod = $this->epdcalendarmodel->get_by_id($i)->row();
						$categories .= "'Wk".$thereportingperiod->week_no."',";
						
					$alerts = $this->reportsmodel->get_sum_by_period_locations($zon_id, $reg_id, $dist_id, $hf_id, $i,$status);
					
					$numalerts = count($alerts);
					
					if($numalerts==0)
					{
						$sarivalues .= '0,';
						   $awdvalues .= '0,';
						   $diphvalues .= '0,';
						   $wcvalues .= '0,';
						   $measvalues .= '0,';
						   $afpvalues .= '0,';
						   $vhfvalues .= '0,';
						   $menvalues .= '0,';
					}
					else
					{
						foreach($alerts as $key=>$alert)
						{
							if($alert->disease_name=='SARI')
							{
								 $sarivalues .= $alert->reported_cases.',';
								   
							}
							
							if($alert->disease_name=='AWD')
							{
								 $awdvalues .= $alert->reported_cases.',';
								
							}
							
							if($alert->disease_name=='Diph')
							{
								 $diphvalues .= $alert->reported_cases.',';
								
							}
							
							if($alert->disease_name=='WC')
							{
								 $wcvalues .= $alert->reported_cases.',';
								
							}
							
							if($alert->disease_name=='Meas')
							{
								 $measvalues .= $alert->reported_cases.',';
								
							}
							
							if($alert->disease_name=='AFP')
							{
								 $afpvalues .= $alert->reported_cases.',';
							
							}
							
							if($alert->disease_name=='VHF')
							{
								 $vhfvalues .= $alert->reported_cases.',';
							}
							
							if($alert->disease_name=='Men')
							{
								 $menvalues .= $alert->reported_cases.',';
								 
							}
							
						  }
						}
					}

				}
				else
				{
					for($i=$period_one;$i<=$period_two;$i++)
					{
						$thereportingperiod = $this->epdcalendarmodel->get_by_id($i)->row();
						$categories .= "'Wk".$thereportingperiod->week_no."',";
						$alerts = $this->reportsmodel->get_sum_by_period_locations($zon_id, $reg_id, $dist_id, $hf_id, $i,$status);
						$numalerts = count($alerts);
					
						if($numalerts==0)
						{
							$sarivalues .= '0,';
						   $awdvalues .= '0,';
						   $diphvalues .= '0,';
						   $wcvalues .= '0,';
						   $measvalues .= '0,';
						   $afpvalues .= '0,';
						   $vhfvalues .= '0,';
						   $menvalues .= '0,';
						}
						else
						{
							foreach($alerts as $key=>$alert)
							{
								if($alert->disease_name=='SARI')
								{
									 $sarivalues .= $alert->reported_cases.',';
									   
								}
								
								if($alert->disease_name=='AWD')
								{
									 $awdvalues .= $alert->reported_cases.',';
									
								}
								
								if($alert->disease_name=='Diph')
								{
									 $diphvalues .= $alert->reported_cases.',';
									
								}
								
								if($alert->disease_name=='WC')
								{
									 $wcvalues .= $alert->reported_cases.',';
									
								}
								
								if($alert->disease_name=='Meas')
								{
									 $measvalues .= $alert->reported_cases.',';
									
								}
								
								if($alert->disease_name=='AFP')
								{
									 $afpvalues .= $alert->reported_cases.',';
								
								}
								
								if($alert->disease_name=='VHF')
								{
									 $vhfvalues .= $alert->reported_cases.',';
								}
								
								if($alert->disease_name=='Men')
								{
									 $menvalues .= $alert->reported_cases.',';
									 
								}
								
							}
						}
					}
				}
            }
            
        }
		
		$alerts = $this->reportsmodel->get_sum_by_period_locations($zon_id, $reg_id, $dist_id, $hf_id, $i,$status);
	   
	    $data['categories'] = $categories;
		$data['sarivalues'] =$sarivalues;
	   $data['awdvalues'] =$awdvalues;
	   $data['diphvalues'] =$diphvalues;
	   $data['wcvalues'] =$wcvalues;
	   $data['measvalues'] =$measvalues;
	   $data['afpvalues'] =$afpvalues;
	   $data['vhfvalues'] =$vhfvalues;
	   $data['menvalues'] =$menvalues;
	 
	    $sumtables = $this->reportsmodel->sum_alerts($zon_id, $reg_id, $dist_id, $hf_id, $period_one, $period_two, $reporting_year, $reporting_year2,$status);
		
		$tbl = '
		<style>
				#datatable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#datatable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#datatable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#datatable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="datatable">
		<thead>';
		
		$class = 'class="alt"';
		$tbl .= '
		<tr><th></th><th>SARI</th><th>AWD</th><th>Diph</th><th>WC</th><th>Meas</th><th>AFP</th><th>VHF</th><th>Men</th></tr>
		</thead>
		<tbody>';
		for($i=$period_one;$i<=$period_two;$i++)
	    {
			
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
			
			if ($i>52 && $i<105)
			{
				
			}
			else
			{
			
				$calendar = $this->epdcalendarmodel->get_by_id($i)->row();
				
				$sari_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'SARI');
				$awd_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'AWD');
				$Diph_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'Diph');
				$wc_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'WC');
				$meas_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'Meas');
				$afp_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'AFP');
				$vhf_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'VHF');
				$men_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'Men');
				
					
				$tbl .= '<tr '.$class.'><th>Wk'.$calendar->week_no.'</th><td>'.number_format($sari_alarts).'</td><td>'.number_format($awd_alarts).'</td><td>'.number_format($Diph_alarts).'</td><td>'.number_format($wc_alarts).'</td><td>'.number_format($meas_alarts).'</td><td>'.number_format($afp_alarts).'</td><td>'.number_format($vhf_alarts).'</td><td>'.number_format($men_alarts).'</td></tr>';	
			}
		}
		
		$tbl .= '
		</tbody>
		</table>';
		
		$data['tbl']= $tbl;
		
		$typebtbl = '
		<style>
				#datatable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#datatable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#datatable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#datatable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="datatable">
		<thead>';
		
		
		$typebtbl .= '
		<tr><th></th><th>Mal</th><th>BD</th><th>OAD</th></tr>
		</thead>
		<body>';
			
		for($i=$period_one;$i<=$period_two;$i++)
	    {
			
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
			
			if ($i>52 && $i<105)
			{
				
			}
			else
			{
			
				$calendar = $this->epdcalendarmodel->get_by_id($i)->row();
				
				$mal_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'Mal');
				$bd_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'BD');
				$oad_alarts = $this->reportsmodel->sum_alerts_disease($zon_id, $reg_id, $dist_id, $hf_id, $i, $i, $calendar->epdyear, $calendar->epdyear,$status,'OAD');
				
				$typebtbl .= '<tr '.$class.'><th>Wk'.$calendar->week_no.'</th><td>'.number_format($mal_alarts).'</td><td>'.number_format($bd_alarts).'</td><td>'.number_format($oad_alarts).'</td></tr>';
			}
			
			
		}
		
		$typebtbl .= '
		</tbody>
		</table>';
		
		$data['typebtbl']= $typebtbl;
		
		$table = '
		<style>
				#datatable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#datatable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#datatable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#datatable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="datatable" border="1">
		<thead>
		 <tr><th colspan="3">Type A alerts</th></tr>
                            <tr><th>Week</th><th>Disease</th><th>Alerts</th></tr>
                            </thead>';
		
		$table .= '<tbody>';
		$class = 'class="alt"';
		foreach($sumtables as $key=>$sumtable)
		{
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
			
		if($sumtable->disease_name=='SARI' || $sumtable->disease_name=='AWD' || $sumtable->disease_name=='Diph' || $sumtable->disease_name=='WC' || $sumtable->disease_name=='Meas' || $sumtable->disease_name=='AFP' || $sumtable->disease_name=='VHF' || $sumtable->disease_name=='Men')
		{
			$reportingperiod = $this->epdcalendarmodel->get_by_id($sumtable->reportingperiod_id)->row();
			$table .= '<tr '.$class.'><td>'.$reportingperiod->epdyear.'/'.$reportingperiod->week_no.'</td><td>'.$sumtable->disease_name.'</td><td>'.$sumtable->reported_cases.'</td></tr>';
		}
								
		}
		$table .= '</tbody>';
		
		
		$typebtable = '
		<style>
				#datatable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#datatable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#datatable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#datatable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="datatable" border="1">
		<thead>
		 <tr><th colspan="3">Type B alerts</th></tr>
                            <tr><th>Week</th><th>Disease</th><th>Cases</th></tr>
                            </thead>';
		
		$typebtable .= '<tbody>';
		$class = 'class="alt"';
		foreach($sumtables as $key=>$sumtable)
		{
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
			
		if($sumtable->disease_name=='ILI' || $sumtable->disease_name=='BD' || $sumtable->disease_name=='OAD' || $sumtable->disease_name=='NNT' || $sumtable->disease_name=='AJS' || $sumtable->disease_name=='Mal')
		{
			$reportingperiod = $this->epdcalendarmodel->get_by_id($sumtable->reportingperiod_id)->row();
			$typebtable .= '<tr '.$class.'><td>'.$reportingperiod->epdyear.'/'.$reportingperiod->week_no.'</td><td>'.$sumtable->disease_name.'</td><td>'.$sumtable->reported_cases.'</td></tr>';
		}
								
		}
		$typebtable .= '</tbody>';
		
		$data['table'] = $table;
		$data['typebtable'] = $typebtable;
		
		$data['reporting_year'] = $reporting_year;
		$data['from'] = $from;
		$data['reporting_year2'] = $reporting_year2;
		$data['to'] = $to;
		
		
		$this->load->view('reports/weeklydiseasealerts', $data);
   }
   
   public function weeklydiseasecasesreport()
   {
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();
	  
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
	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();
	  
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	  
	  
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	   $forms = $this->exportmodel->get_export_records($reg_id,$dist_id,$hf_id,$period_one,$period_two,$reporting_year,$reporting_year2);
	   
	  
	   $tbl = '
		<style>
				#datatable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#datatable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#datatable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#datatable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="datatable" border="1"><thead>';
		
		$tbl .= '
		
		<tr>
		<th>&nbsp;</th><th>SARI</th><th>ILI</th><th>AWD</th><th>BD</th><th>OAD</th><th>Diph</th><th>WC</th><th>Meas</th><th>NNT</th><th>AFP</th>
		<th>AJS</th><th>VHF</th><th>Mal</th><th>Men</th>
		</tr></thead>';
		
		$class = 'class="alt"';
	   
	   $table = '
		<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:1.0em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#0000CC;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1"><thead>';
		$table .= '<tr><th>week_year</th><th>week_no</th><th>Zon_name</th><th>reg_name</th><th>d_name</th>
		<th>org_name</th><th>hf_name</th><th>hft</th><th>hfc</th><th>ili_lt_5</th><th>ili_gt_5</th><th>sari_lt_5</th><th>sari_gt_5</th>
		<th>awd_lt_5</th><th>awd_gt_5</th><th>bd_lt_5</th><th>bd_gt_5</th><th>oad_lt_5</th><th>oad_gt_5</th><th>diph</th><th>wc</th><th>meas</th><th>nnt</th><th>afp</th><th>ajs</th><th>vhf</th><th>mal_lt_5</th><th>mal_gt_5</th><th>men</th><th>unDis_name</th><th>unDis_num</th><th>unDis_name</th><th>unDis_num</th><th>oc</th><th>total_cons_disease</th><th>sre</th><th>pf</th><th>pv</th><th>pmix</th><th>zon_code</th>
		<th>reg_code</th><th>dis_code</th><th>Entry_Date</th><th>Entry_Time</th><th>User_ID</th><th>con_number</th><th>Edit_Date</th><th>Edit_Time</th>
		</tr>';
		$table .= '</thead><tbody>';
		
		
		
		foreach($forms as $key=>$form)
		{
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
		
			$sariutot = $form->sariufivemale+$form->sariufivefemale;
						$sariotot = $form->sariofivemale + $form->sariofivefemale;
						$saritot =  $sariutot + $sariotot;
						$iliutot = $form->iliufivemale + $form->iliufivefemale;
						$iliotot = $form->iliofivemale + $form->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $form->awdufivemale + $form->awdufivefemale;
						$awdotot = $form->awdofivemale + $form->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $form->bdufivemale + $form->bdufivefemale;
						$bdotot = $form->bdofivemale + $form->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $form->oadufivemale + $form->oadufivefemale;
						$oadotot = $form->oadofivemale + $form->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $form->diphmale + $form->diphfemale;
						$wctot = $form->wcmale + $form->wcfemale;
						$meastot = $form->measmale + $form->measfemale;
						$nnttot = $form->nntmale + $form->nntfemale;
						$afptot = $form->afpmale + $form->afpfemale;
						$ajstot = $form->ajsmale + $form->ajsfemale;
						$vhftot = $form->vhfmale + $form->vhffemale;
						$malutot = $form->malufivemale + $form->malufivefemale;
						$malotot = $form->malofivemale+$form->malofivefemale;
						$maltotal = $malutot + $malotot;
						$mentot = $form->suspectedmenegitismale + $form->suspectedmenegitisfemale;
						$undistot = $form->undismale + $form->undisfemale;
						$undistwotot = $form->undismaletwo + $form->undisfemaletwo;
						$octot = $form->ocmale + $form->ocfemale;
						
			$table .= '<tr><td>'.$form->reporting_year.'</td><td>'.$form->week_no.'</td><td>'.$form->zone.'</td><td>'.$form->region.'</td><td>'.$form->district.'</td>
		<td>'.$form->organization.'</td><td>'.$form->health_facility.'</td><td>'.$form->health_facility_type.'</td><td>'.$form->hf_code.'</td><td>'.$iliutot.'</td><td>'.$iliotot.'</td><td>'.$sariutot.'</td><td>'.$sariotot.'</td>
		<td>'.$awdutot.'</td><td>'.$awdotot.'</td><td>'.$bdutot.'</td><td>'.$bdotot.'</td><td>'.$oadutot.'</td><td>'.$oadotot.'</td><td>'.$diphtot.'</td><td>'.$wctot.'</td><td>'.$meastot.'</td><td>'.$nnttot.'</td><td>'.$afptot.'</td><td>'.$ajstot.'</td><td>'.$vhftot.'</td><td>'.$malutot.'</td><td>'.$malotot.'</td><td>'.$mentot.'</td><td>'.$form->undisonedesc.'</td><td>'.$undistot.'</td><td>'.$form->undissecdesc.'</td><td>'.$undistwotot.'</td><td>'.$octot.'</td><td>'.$form->total_consultations.'</td><td>'.$form->sre.'</td><td>'.$form->pf.'</td><td>'.$form->pv.'</td><td>'.$form->pmix.'</td><td>'.$form->zonal_code.'</td>
		<td>'.$form->regional_code.'</td><td>'.$form->district_code.'</td><td>'.$form->entry_date.'</td><td>'.$form->entry_time.'</td><td>'.$form->username.'</td><td>'.$form->User_Contact.'</td><td>'.$form->edit_date.'</td><td>'.$form->edit_time.'</td>
		</tr>';
		
		$tbl .= '<tr '.$class.'>
		<th>WK '.$form->reporting_year.'/'.$form->week_no.'</th><td>'.$saritot.'</td><td>'.$ilitot.'</td><td>'.$awdtot.'</td><td>'.$bdtot.'</td><td>'.$oadtot.'</td><td>'.$diphtot.'</td><td>'.$wctot.'</td><td>'.$meastot.'</td><td>'.$nnttot.'</td><td>'.$afptot.'</td>
		<td>'.$ajstot.'</td><td>'.$vhftot.'</td><td>'.$maltotal.'</td><td>'.$mentot.'</td>
		</tr>';
		
		}
		
		$table .= '</tbody></table>';
		
		
		echo $tbl;
		echo $table;
	   
   }
   
   public function weeklydiseasecases()
   {
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();
	  
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
	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();
	  
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	  
	  
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
   	   
	   $sumtables = $this->reportsmodel->weekly_diseases($zon_id,$reg_id,$dist_id,$hf_id,$period_one,$period_two,$reporting_year,$reporting_year2);
				
		$table = '
		<style>
				#datatable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#datatable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#datatable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#datatable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="datatable" border="1"><thead>';
		
		$table .= '
		
		<tr>
		<th>&nbsp;</th><th>SARI</th><th>ILI</th><th>AWD</th><th>BD</th><th>OAD</th><th>Diph</th><th>WC</th><th>Meas</th><th>NNT</th><th>AFP</th>
		<th>AJS</th><th>VHF</th><th>Mal</th><th>Men</th>
		</tr></thead>';
		
		$class = 'class="alt"';
		foreach($sumtables as $skey=>$sumtable)
		{
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
							
			//echo $sumtable->reporting_year.'/'.$sumtable->week_no.'<br>';
			$saritotal = $sumtable->sari_lt_5 + $sumtable->sari_gt_5;
			$ilitotal = $sumtable->ili_lt_5 + $sumtable->ili_gt_5;
			$awdtotal = $sumtable->awd_lt_5 + $sumtable->awd_gt_5;
			$bdtotal = $sumtable->bd_lt_5 + $sumtable->bd_gt_5;
			$oadtotal = $sumtable->oad_lt_5 + $sumtable->oad_gt_5;
			$diphtotal = $sumtable->diph + $sumtable->diph_gt_5;
			$wctotal = $sumtable->wc + $sumtable->wc_gt_5;
			$meastotal = $sumtable->meas +$sumtable->meas_gt_5;
			$nnttotal = $sumtable->nnt;
			$afptotal = $sumtable->afp + $sumtable->afp_gt_5;
			$ajstotal = $sumtable->ajs;
			$vhftotal = $sumtable->vhf;
			$maltotal = $sumtable->mal_lt_5 + $sumtable->mal_gt_5;
			$mentotal = $sumtable->men + $sumtable->men_gt_5;
			
			$table .= '<tr '.$class.'>
		<th>WK '.$sumtable->reporting_year.'/'.$sumtable->week_no.'</th><td>'.$saritotal.'</td><td>'.$ilitotal.'</td><td>'.$awdtotal.'</td><td>'.$bdtotal.'</td><td>'.$oadtotal.'</td><td>'.$diphtotal.'</td><td>'.$wctotal.'</td><td>'.$meastotal.'</td><td>'.$nnttotal.'</td><td>'.$afptotal.'</td>
		<td>'.$ajstotal.'</td><td>'.$vhftotal.'</td><td>'.$maltotal.'</td><td>'.$mentotal.'</td>
		</tr>';
			
		}
	    
		$table .= '</table>';
		
		$disttable = '
		<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1">
		<thead>
		<tr><td colspan="9"><strong>Weekly Distribution Type A Cases</strong></td></tr>
		<tr><th>&nbsp;</th><th>SARI</th><th>AWD</th><th>Diph</th><th>Wc</th><th>Meas</th><th>AFP</th><th>VHF</th><th>Men</th></tr>
		</thead>';
		
		foreach($sumtables as $skey=>$sumtable)
		{
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
							
			//echo $sumtable->reporting_year.'/'.$sumtable->week_no.'<br>';
			$saritotal = $sumtable->sari_lt_5 + $sumtable->sari_gt_5;
			$ilitotal = $sumtable->ili_lt_5 + $sumtable->ili_gt_5;
			$awdtotal = $sumtable->awd_lt_5 + $sumtable->awd_gt_5;
			$bdtotal = $sumtable->bd_lt_5 + $sumtable->bd_gt_5;
			$oadtotal = $sumtable->oad_lt_5 + $sumtable->oad_gt_5;
			$diphtotal = $sumtable->diph + $sumtable->diph_gt_5;
			$wctotal = $sumtable->wc + $sumtable->wc_gt_5;
			$meastotal = $sumtable->meas +$sumtable->meas_gt_5;
			$nnttotal = $sumtable->nnt;
			$afptotal = $sumtable->afp + $sumtable->afp_gt_5;
			$ajstotal = $sumtable->ajs;
			$vhftotal = $sumtable->vhf;
			$maltotal = $sumtable->mal_lt_5 + $sumtable->mal_gt_5;
			$mentotal = $sumtable->men + $sumtable->men_gt_5;
			
			$disttable .= '<tr '.$class.'>
		<td>WK '.$sumtable->reporting_year.'/'.$sumtable->week_no.'</td><td>'.$saritotal.'</td><td>'.$awdtotal.'</td><td>'.$diphtotal.'</td><td>'.$wctotal.'</td><td>'.$meastotal.'</td><td>'.$afptotal.'</td>
		<td>'.$vhftotal.'</td><td>'.$mentotal.'</td>
		</tr>';
			
		}
		
		$disttable .= '</table>';
		
		
		$typebtable = '
		<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1">
		<thead>
		<tr><td colspan="9"><strong>Weekly Distribution Type B Cases</strong></td></tr>
		<tr><th>&nbsp;</th><th>ILI</th><th>BD</th><th>OAD</th><th>NNT</th><th>AJS</th><th>Mal</th></tr>
		</thead>';
		
		foreach($sumtables as $skey=>$sumtable)
		{
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
							
			//echo $sumtable->reporting_year.'/'.$sumtable->week_no.'<br>';
			$saritotal = $sumtable->sari_lt_5 + $sumtable->sari_gt_5;
			$ilitotal = $sumtable->ili_lt_5 + $sumtable->ili_gt_5;
			$awdtotal = $sumtable->awd_lt_5 + $sumtable->awd_gt_5;
			$bdtotal = $sumtable->bd_lt_5 + $sumtable->bd_gt_5;
			$oadtotal = $sumtable->oad_lt_5 + $sumtable->oad_gt_5;
			$diphtotal = $sumtable->diph + $sumtable->diph_gt_5;
			$wctotal = $sumtable->wc + $sumtable->wc_gt_5;
			$meastotal = $sumtable->meas +$sumtable->meas_gt_5;
			$nnttotal = $sumtable->nnt;
			$afptotal = $sumtable->afp + $sumtable->afp_gt_5;
			$ajstotal = $sumtable->ajs;
			$vhftotal = $sumtable->vhf;
			$maltotal = $sumtable->mal_lt_5 + $sumtable->mal_gt_5;
			$mentotal = $sumtable->men + $sumtable->men_gt_5;
			
			$typebtable .= '<tr '.$class.'>
		<td>WK '.$sumtable->reporting_year.'/'.$sumtable->week_no.'</td><td>'.$ilitotal.'</td><td>'.$bdtotal.'</td><td>'.$oadtotal.'</td><td>'.$nnttotal.'</td><td>'.$ajstotal.'</td><td>'.$maltotal.'</td>
		</tr>';
			
		}
		
		
		$typebtable .= '</table>';
		
		$data['table'] = $table;
		$data['disttable'] = $disttable;
		$data['typebtable'] = $typebtable;
		$data['reporting_year'] = $reporting_year;
		$data['from'] = $from;
		$data['reporting_year2'] = $reporting_year2;
		$data['to'] = $to;
		
		
		$this->load->view('reports/weeklydiseasecases', $data);
   }
   
   public function weeklyhfalertsquery()
   {
	  //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

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
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
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
	   
	   $data['level'] = $level;

       $this->load->view('reports/weeklyhfalertsquery', $data);
   }
   
   public function weeklyhfalerts()
   {
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();
	  
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
	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	  	   
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	    $forms = $this->reportsmodel->get_export_records($zon_id,$reg_id,$dist_id,$hf_id,$period_one,$period_two,$reporting_year,$reporting_year2);		
		
		
		$frms = $this->reportsmodel->get_case_records($zon_id,$reg_id,$dist_id,$hf_id,$period_one,$period_two,$reporting_year,$reporting_year2);
		
		$tbl = '<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1"><thead>';
		$tbl .= '
		<tr><td colspan="9"><strong>Weekly distribution of Type A Cases</strong></td></tr>
		<tr>
		<th>Health Facility Name</th><th>SARI</th><th>AWD</th><th>Diph</th><th>WC</th><th>Meas</th><th>AFP</th>
		<th>VHF</th><th>Men</th>
		</tr></thead>';
		
		
		$typebtable = '
		<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1">
		<thead>
		<tr><td colspan="7"><strong>Weekly Distribution Type B Cases</strong></td></tr>
		<tr><th>Health Facility Name</th><th>ILI</th><th>BD</th><th>OAD</th><th>NNT</th><th>AJS</th><th>Mal</th></tr>
		</thead>';
		
		$class = 'class="alt"';
		foreach($frms as $skey=>$frm)
		{
					
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
			
			$saritot =  $frm->sari_lt_5 + $frm->sari_gt_5;
			
			$ilitot = $frm->ili_gt_5 + $frm->ili_lt_5;
		
			$awdtot = $frm->awd_gt_5 + $frm->awd_lt_5;
		
			$bdtot = $frm->bd_gt_5 + $frm->bd_lt_5;
		
			$oadtot = $frm->oad_lt_5 + $frm->oad_gt_5;
			
			$diphtot = $frm->diph + $frm->diph_gt_5;
			$wctot = $frm->wc + $frm->wc_gt_5;
			$meastot = $frm->meas + $frm->meas_gt_5;
			$nnttot = $frm->nnt;
			$afptot = $frm->afp + $frm->afp_gt_5;
			$ajstot = $frm->ajs;
			$vhftot = $frm->vhf;		
			$maltot = $frm->mal_lt_5 + $frm->mal_gt_5;
			$mentot = $frm->men + $frm->men_gt_5;
			$undistot = $frm->unDis_num;
			$undistwotot = $frm->unDis_num;
			$octot = $frm->oc;
			
			$tbl .= '<tr '.$class.'>
		<td>'.$frm->health_facility.'</td><td>'.$saritot.'</td><td>'.$awdtot.'</td><td>'.$diphtot.'</td><td>'.$wctot.'</td><td>'.$meastot.'</td><td>'.$afptot.'</td>
		<td>'.$vhftot.'</td><td>'.$mentot.'</td>
		</tr>';
		
		
			$typebtable .= '<tr '.$class.'>
		<td>'.$frm->health_facility.'</td><td>'.$ilitot.'</td><td>'.$bdtot.'</td><td>'.$oadtot.'</td><td>'.$nnttot.'</td><td>'.$ajstot.'</td><td>'.$maltot.'</td>
		</tr>';
			
		}
		
		$tbl .= '</table>';
		$typebtable .= '</table>';	
		
		$data['tbl'] = $tbl;
				
		
		$hfalerts = $this->reportsmodel->get_alerts_by_hf($zone_id, $region_id, $district_id, $healthfacility_id, $period_one, $period_two, $reporting_year, $reporting_year2,0);
		
		
		//alerts table
		$alertstable = '<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1"><thead>';
		
		$alertstable .= '
		<tr><td colspan="9"><strong> Weekly distribution of Type A Alerts</strong></td></tr>
		<tr>
		<th>Health Facility Name</th><th>SARI</th><th>AWD</th><th>Diph</th><th>WC</th><th>Meas</th><th>AFP</th><th>VHF</th><th>Men</th>
		</tr></thead>';
		
			$alertsbtable = '<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1"><thead>';
		
		$alertsbtable .= '
		<tr><td colspan="7"><strong>Weekly distribution of Type B Alerts</strong></td></tr>
		<tr>
		<th>Health Facility Name</th><th>ILI</th><th>BD</th><th>OAD</th><th>NNT</th><th>AJS</th><th>Mal</th>
		</tr></thead>';
		
		$alertclass = 'class="alt"';
		
		$reg_healthfacilities = $this->healthfacilitiesmodel->get_by_all_locations_approved_hf($zone_id, $region_id, $district_id, $healthfacility_id);
		
		
		
		foreach($reg_healthfacilities as $rhfkey=>$reg_healthfacility)
		{
			if($alertclass == 'class="alt"')
			{
				$alertclass = '';
			}
			else
			{
				$alertclass = 'class="alt"';
			}
			
			$sari = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'SARI');
			
			
			if(empty($sari->alerts_cases))
			  {
				  $saricases = 0;
			  }
			  else
			  {
				  $saricases = $sari->alerts_cases;
			  }
			  
			  $awd = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'AWD');
			if(empty($awd->alerts_cases))
			  {
				  $awdcases = 0;
			  }
			  else
			  {
				  $awdcases = $awd->alerts_cases;
			  }
			  
			  $diph = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'Diph');
			if(empty($diph->alerts_cases))
			  {
				  $diphcases = 0;
			  }
			  else
			  {
				  $diphcases = $diph->alerts_cases;
			  }
			  
			  $wc = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'WC');
			if(empty($wc->alerts_cases))
			  {
				  $wccases = 0;
			  }
			  else
			  {
				  $wccases = $wc->alerts_cases;
			  }
			  
			   $meas = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'Meas');
			if(empty($meas->alerts_cases))
			  {
				  $meascases = 0;
			  }
			  else
			  {
				  $meascases = $meas->alerts_cases;
			  }
			  
			  $afp = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'AFP');
			if(empty($afp->alerts_cases))
			  {
				  $afpcases = 0;
			  }
			  else
			  {
				  $afpcases = $afp->alerts_cases;
			  }
			  
			   $vhf = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'VHF');
			if(empty($vhf->alerts_cases))
			  {
				  $vhfcases = 0;
			  }
			  else
			  {
				  $vhfcases = $vhf->alerts_cases;
			  }
			  
			   $men = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'Men');
			if(empty($men->alerts_cases))
			  {
				  $mencases = 0;
			  }
			  else
			  {
				  $mencases = $men->alerts_cases;
			  }
			
			$alertstable .= '<tr '.$alertclass.'><td>'.$reg_healthfacility->health_facility.'</td><td>'.$saricases.'</td><td>'.$awdcases.'</td><td>'.$diphcases.'</td><td>'.$wccases.'</td><td>'.$meascases.'</td><td>'.$afpcases.'</td><td>'.$vhfcases.'</td><td>'.$mencases.'</td></tr>';
			
			 $ili = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'ILI');
			if(empty($ili->alerts_cases))
			  {
				  $ilicases = 0;
			  }
			  else
			  {
				  $ilicases = $ili->alerts_cases;
			  }
			  
			  $bd = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'BD');
			if(empty($bd->alerts_cases))
			  {
				  $bdcases = 0;
			  }
			  else
			  {
				  $bdcases = $bd->alerts_cases;
			  }
			  
			   $oad = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'OAD');
			if(empty($oad->alerts_cases))
			  {
				  $oadcases = 0;
			  }
			  else
			  {
				  $oadcases = $oad->alerts_cases;
			  }
			  
			   $nnt = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'NNT');
			if(empty($nnt->alerts_cases))
			  {
				  $nntcases = 0;
			  }
			  else
			  {
				  $nntcases = $nnt->alerts_cases;
			  }
			  
			$ajs = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'AJS');
			if(empty($ajs->alerts_cases))
			  {
				  $ajscases = 0;
			  }
			  else
			  {
				  $ajscases = $ajs->alerts_cases;
			  }
			  
			 $mal = $this->alertsmodel->sum_by_disease_outcome_hf($period_one, $period_two,1,$reg_healthfacility->healthfacility_id,'Mal');
			if(empty($mal->alerts_cases))
			  {
				  $malcases = 0;
			  }
			  else
			  {
				  $malcases = $mal->alerts_cases;
			  }
			
			$alertsbtable .= '<tr '.$alertclass.'><td>'.$reg_healthfacility->health_facility.'</td><td>'.$ilicases.'</td><td>'.$bdcases.'</td><td>'.$oadcases.'</td><td>'.$nntcases.'</td><td>'.$ajscases.'</td><td>'.$malcases.'</td></tr>';
		}
		/**
		foreach($hfalerts as $hfkey=>$hfalert)
		{
			if($alertclass == 'class="alt"')
			{
				$alertclass = '';
			}
			else
			{
				$alertclass = 'class="alt"';
			}
			
			$epicalendar = $this->epdcalendarmodel->get_by_id($hfalert->reportingperiod_id)->row();
			
			if($hfalert->disease_name=='SARI' || $hfalert->disease_name=='AWD' || $hfalert->disease_name=='Diph' || $hfalert->disease_name=='WC' || $hfalert->disease_name=='Meas' || $hfalert->disease_name=='AFP' || $hfalert->disease_name=='VHF' || $hfalert->disease_name=='Men')
			{
									
				$alertstable .= '<tr '.$alertclass.'>
			<td>'.$hfalert->health_facility.'</td><td>WK '.$epicalendar->epdyear.'/'.$epicalendar->week_no.'</td><td>'.$hfalert->disease_name.'</td><td>'.$hfalert->reported_cases.'</td>
			</tr>';
			}
			
		}
	    **/
		$alertstable .= '</table>';
		$alertsbtable .= '</table>';
		
	
		
				
		$data['alertstable'] = $alertstable;
		$data['alertsbtable'] = $alertsbtable;
		
		//cases tables
				
		$table = '
		<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#1F7EB8;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1"><thead>';
		
		$table .= '
		<tr><td colspan="16"><strong>Type A Cases</strong></td></tr>
		<tr>
		<th>Health Facility Name</th><th>Week</th><th>SARI</th><th>AWD</th><th>Diph</th><th>WC</th><th>Meas</th><th>AFP</th>
		<th>VHF</th><th>Men</th>
		</tr></thead>';
		
		$class = 'class="alt"';
		foreach($forms as $skey=>$form)
		{
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
							
			$sariutot = $form->sariufivemale+$form->sariufivefemale;
			$sariotot = $form->sariofivemale + $form->sariofivefemale;
			$saritot =  $sariutot + $sariotot;
			$iliutot = $form->iliufivemale + $form->iliufivefemale;
			$iliotot = $form->iliofivemale + $form->iliofivefemale;
			$ilitot = $iliutot + $iliotot;
			$awdutot = $form->awdufivemale + $form->awdufivefemale;
			$awdotot = $form->awdofivemale + $form->awdofivefemale;
			$awdtot = $awdotot + $awdutot;
			$bdutot = $form->bdufivemale + $form->bdufivefemale;
			$bdotot = $form->bdofivemale + $form->bdofivefemale;
			$bdtot = $bdutot + $bdotot;
			$oadutot = $form->oadufivemale + $form->oadufivefemale;
			$oadotot = $form->oadofivemale + $form->oadofivefemale;
			$oadtot = $oadotot + $oadutot;
			$diphtot = $form->diphmale + $form->diphfemale + $form->diphofivemale + $form->diphofivefemale;
			$wctot = $form->wcmale + $form->wcfemale + $form->wcofivemale + $form->wcofivefemale;
			$meastot = $form->measmale + $form->measfemale + $form->measofivemale + $form->measofivefemale;
			$nnttot = $form->nntmale + $form->nntfemale;
			$afptot = $form->afpmale + $form->afpfemale + $form->afpofivemale + $form->afpofivefemale;
			$ajstot = $form->ajsmale + $form->ajsfemale;
			$vhftot = $form->vhfmale + $form->vhffemale;
			$malutot = $form->malufivemale + $form->malufivefemale;
			$malotot = $form->malofivemale+$form->malofivefemale;			
			$maltot = $malotot + $malutot;
			$mentot = $form->suspectedmenegitismale + $form->suspectedmenegitisfemale + $form->suspectedmenegitisofivemale + $form->suspectedmenegitisofivefemale;
			$undistot = $form->undismale + $form->undisfemale;
			$undistwotot = $form->undismaletwo + $form->undisfemaletwo;
			$octot = $form->ocmale + $form->ocfemale;
			
			$table .= '<tr '.$class.'>
		<td>'.$form->health_facility.'</td><td>WK '.$form->reporting_year.'/'.$form->week_no.'</td><td>'.$saritot.'</td><td>'.$awdtot.'</td><td>'.$diphtot.'</td><td>'.$wctot.'</td><td>'.$meastot.'</td><td>'.$afptot.'</td>
		<td>'.$vhftot.'</td><td>'.$mentot.'</td>
		</tr>';
			
		}
	    
		$table .= '</table>';
		
			
		$data['table'] = $table;
		$data['typebtable'] = $typebtable;
		$data['reporting_year'] = $reporting_year;
		$data['from'] = $from;
		$data['reporting_year2'] = $reporting_year2;
		$data['to'] = $to;
		
		
		$this->load->view('reports/weeklyhfalerts', $data);
   }
   
    public function healthfacilityalerts()
   {
	  //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	   $data = array();
	   
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   
	   if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {
            
            redirect('home', 'refresh');
            
        }
		   
	   if ($level == 6) {//District
			$district_id = $this->erkanaauth->getField('district_id');			
			$district = $this->districtsmodel->get_by_id($district_id)->row();            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
			$data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
		}
		
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
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
	   }
	   
	   if($level==4)//national
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   if($level==5)//stakeholder
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		  $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   $data['level'] = $level;

       $this->load->view('reports/healthfacilityalerts', $data);
   }
   
   
   public function healthfacilityalertreport()
   {
	   if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();

       $level = $this->erkanaauth->getField('level');
       $country_id = $this->erkanaauth->getField('country_id');


       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

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
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;
	  
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
		   $data['thezone'] = 'All';
	   }
	   else
	   {
		   $zon_id = $zone_id;
		   $zone = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['thezone'] = $zone->zone;
	   }
	   
	   if(empty($region_id))
	   {
		   $reg_id = 0;
		   $data['theregion'] = 'All';
	   }
	   else
	   {
		   $reg_id = $region_id;
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['theregion'] = $region->region;
	   }
	   
	   if(empty($district_id))
	   {
		   $dist_id = 0;
		   $data['thedistrict'] = 'All';
	   }
	   else
	   {
		   $dist_id = $district_id;
		   $district = $this->districtsmodel->get_by_id($district_id)->row();
		   $data['thedistrict'] = $district->district;
	   }
	   
	   if(empty($healthfacility_id))
	   {
		   $hf_id = 0;
		   $data['thehealthfacility'] = 'All';
	   }
	   else
	   {
		   $hf_id = $healthfacility_id;
		   $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
		   $data['thehealthfacility'] = $healthfacility->health_facility;
	   }
	   


	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
			   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
			   

	   $diseasearray = array();
			   
	   foreach ($diseases->result() as $disease):
			$diseasearray[] = $disease->disease_code;
						
	   endforeach;


       $reportingperiodone = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiodtwo = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $startdate = $reportingperiodone->from;
       $enddate = $reportingperiodtwo->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;
           $yearArray[] =  $epilist->epdyear;
           $weekArray[] =  $epilist->week_no;


       }
	   
	   $lists = $this->reportsmodel->get_full_list_week_array($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);

	   $tbl = '
		<strong>Weekly distribution of Alerts</strong>
		<table id="listtable" border="1"><thead>';
		
		$tbl .= '
		<tr>
		<th>Health Facility Name</th>';
		
		foreach ($diseases->result() as $disease):
			$tbl .= '<th>'.$disease->disease_code.'</th>';						
		endforeach;
		
			
		$tbl .= '</tr>
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
			
			$tbl .= '<tr '.$bgcolor.'>';
			
			$tbl .= '<td>'.$list->health_facility.'</td>';
			
			foreach($diseasearray as $key=>$diseasecode):
			
				$alert_element = $diseasecode.'_total_alerts';
				$tbl .= '<td>'.$list->$alert_element.'</td>';
			
			endforeach;
			
			
			$tbl .= '</tr>';
			
		}
		
		
		$tbl .= '
		</tbody>
		</table>';
		
		$table = '<strong>Weekly distribution of Cases</strong>
		<table id="listtable" border="1"><thead>';		
		$table .= '
		<tr>
		<th>Health Facility Name</th>';
		
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
			
			$table .= '<td>'.$list->health_facility.'</td>';
			
			foreach($diseasearray as $key=>$diseasecode):
			
				$disease_element = $diseasecode;
				$table .= '<td>'.$list->$disease_element.'</td>';
			
			endforeach;
			
			
			$table .= '</tr>';
			
		}
		
		
		$table .= '
		</tbody>
		</table>';
		
		
		$data['table'] = $table;
		$data['tbl'] = $tbl;
		$data['reporting_year'] = $reporting_year;
		$data['from'] = $from;
		$data['reporting_year2'] = $reporting_year2;
		$data['to'] = $to;
        $data['zone_id'] = $zon_id;
        $data['region_id'] = $reg_id;
        $data['district_id'] = $dist_id;
        $data['healthfacility_id'] = $hf_id;
		
		
		$this->load->view('reports/healthfacilityalertreport', $data);
	   
	   
   }

   public function exporthfalert()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $country_id = $this->erkanaauth->getField('country_id');

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reportingyear');
       $from = $this->input->post('from');
       $reporting_year2 = $this->input->post('reportingyear2');
       $to = $this->input->post('to');

       if(empty($zone_id))
       {
           $zon_id = 0;
           $thezone = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $thezone = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $theregion = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $theregion = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $thedistrict = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $thedistrict = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $thehealthfacility = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $thehealthfacility = $healthfacility->health_facility;
       }

       $diseasecount = $this->diseasesmodel->get_country_list($country_id);
       $limit = count($diseasecount);

       $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);


       $diseasearray = array();

       foreach ($diseases->result() as $disease):
           $diseasearray[] = $disease->disease_code;

       endforeach;


       $reportingperiodone = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiodtwo = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $startdate = $reportingperiodone->from;
       $enddate = $reportingperiodtwo->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;
           $yearArray[] =  $epilist->epdyear;
           $weekArray[] =  $epilist->week_no;


       }

       $lists = $this->reportsmodel->get_full_list_week_array($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);

       $table = '<table id="listtable" border="1" width="100%">';
       $table .= '<tr bgcolor="#13C3E6"><th><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
       $table .= '<tr bgcolor="#13C3E6"><th>Weekly Health Facility Disease Alerts & Cases from '.$reporting_year.' week '.$from.' to '.$reporting_year2.' week '.$to.'</th></tr>';

       $table .= '</table>';

       $table .= '<table id="listtable" border="1" width="100%">
<tr><th>Weekly distribution of Alerts</th></tr>
        </table>';
       $table .= '
		<table id="listtable" border="1" width="100%"><thead>';

       $table .= '
		<tr>
		<th>Health Facility Name</th>';

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

           $table .= '<td>'.$list->health_facility.'</td>';

           foreach($diseasearray as $key=>$diseasecode):

               $alert_element = $diseasecode.'_total_alerts';
               $table .= '<td>'.$list->$alert_element.'</td>';

           endforeach;


           $table .= '</tr>';

       }


       $table .= '
		</tbody>
		</table>';

       $table .= '<table id="listtable" border="1" width="100%">
<tr><th>Weekly distribution of Cases</th></tr>
        </table>';

       $table .= '<table id="listtable" border="1" width="100%"><thead>';
       $table .= '
		<tr>
		<th>Health Facility Name</th>';

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

           $table .= '<td>'.$list->health_facility.'</td>';

           foreach($diseasearray as $key=>$diseasecode):

               $disease_element = $diseasecode;
               $table .= '<td>'.$list->$disease_element.'</td>';

           endforeach;


           $table .= '</tr>';

       }


       $table .= '
		</tbody>
		</table>';

       $filename = "Health_Facility_Alert_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");


       $this->output->append_output($table);
   }
   
   
   public function diseasealerts()
   {
	  //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	   $data = array();
	   
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {
            
            redirect('home', 'refresh');
            
        }
	   
	   if ($level == 6) {//District
			$district_id = $this->erkanaauth->getField('district_id');			
			$district = $this->districtsmodel->get_by_id($district_id)->row();            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
			$data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
		}
		
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
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
	   }
	   
	   if($level==4)//national
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   if($level==5)//stakeholder
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		  $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   $data['level'] = $level;

       $this->load->view('reports/diseasealerts', $data);
   }
   
   
   public function diseasealertreport()
   {
	   if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();
	  
	  $country_id = $this->erkanaauth->getField('country_id');

       $level = $this->erkanaauth->getField('level');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

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
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;

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
		   $data['thezone'] = 'All';
	   }
	   else
	   {
		   $zon_id = $zone_id;
		   $zone = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['thezone'] = $zone->zone;
	   }
	   
	   if(empty($region_id))
	   {
		   $reg_id = 0;
		   $data['theregion'] = 'All';
	   }
	   else
	   {
		   $reg_id = $region_id;
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['theregion'] = $region->region;
	   }
	   
	   if(empty($district_id))
	   {
		   $dist_id = 0;
		   $data['thedistrict'] = 'All';
	   }
	   else
	   {
		   $dist_id = $district_id;
		   $district = $this->districtsmodel->get_by_id($district_id)->row();
		   $data['thedistrict'] = $district->district;
	   }
	   
	   if(empty($healthfacility_id))
	   {
		   $hf_id = 0;
		   $data['thehealthfacility'] = 'All';
	   }
	   else
	   {
		   $hf_id = $healthfacility_id;
		   $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
		   $data['thehealthfacility'] = $healthfacility->health_facility;
	   }
	   

	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
			   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);

	   $diseasearray = array();
			   
	   foreach ($diseases->result() as $disease):
			$diseasearray[] = $disease->disease_code;
						
	   endforeach;


       $reportingperiodone = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiodtwo = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();


       $startdate = $reportingperiodone->from;
       $enddate = $reportingperiodtwo->to;

       $epicalendaridArray = array();

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;
           $yearArray[] =  $epilist->epdyear;
           $weekArray[] =  $epilist->week_no;


       }

       $lists = $this->reportsmodel->get_full_list_alert_week_array($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
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
			
			$table .= '<th>Wk'.$list->week_no.'</th>';
			
			foreach($diseasearray as $key=>$diseasecode):
				$disease_element = $diseasecode;
				$table .= '<td>'.$list->$disease_element.'</td>';
			
			endforeach;
			
			
			$table .= '</tr>';
			
		}
		
		
		$table .= '
		</tbody>
		</table>';
		
		
		$data['table'] = $table;
		$data['reporting_year'] = $reporting_year;
		$data['from'] = $from;
		$data['reporting_year2'] = $reporting_year2;
		$data['to'] = $to;
        $data['zone_id'] = $zon_id;
        $data['region_id'] = $reg_id;
        $data['district_id'] = $dist_id;
        $data['healthfacility_id'] = $hf_id;
		
		$this->load->view('reports/diseasealertreport', $data);
	   
	   
   }

   public function exportdiseasealert()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $country_id = $this->erkanaauth->getField('country_id');

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reportingyear');
       $from = $this->input->post('from');
       $reporting_year2 = $this->input->post('reportingyear2');
       $to = $this->input->post('to');


       if(empty($zone_id))
       {
           $zon_id = 0;
           $thezone = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $thezone = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $theregion = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $theregion = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $thedistrict = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $thedistrict = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $thehealthfacility = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $thehealthfacility = $healthfacility->health_facility;
       }

       $diseasecount = $this->diseasesmodel->get_country_list($country_id);
       $limit = count($diseasecount);

       $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);


       $diseasearray = array();

       foreach ($diseases->result() as $disease):
           $diseasearray[] = $disease->disease_code;

       endforeach;


       $reportingperiodone = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiodtwo = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();


       $startdate = $reportingperiodone->from;
       $enddate = $reportingperiodtwo->to;

       $epicalendaridArray = array();

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;
           $yearArray[] =  $epilist->epdyear;
           $weekArray[] =  $epilist->week_no;


       }

       $colspan = ($limit+1);


       $lists = $this->reportsmodel->get_full_list_alert_week_array($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
       $table = '<table id="datatable" border="1" width="100%"><thead>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="'.$colspan.'"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="'.$colspan.'">Weekly Disease Alerts from '.$reporting_year.' week '.$from.' to '.$reporting_year2.' week '.$to.'</th></tr>';
       $table .= '
		<tr bgcolor="#13C3E6">
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

           $table .= '<th>Wk'.$list->week_no.'</th>';

           foreach($diseasearray as $key=>$diseasecode):
               $disease_element = $diseasecode;
               $table .= '<td>'.$list->$disease_element.'</td>';

           endforeach;


           $table .= '</tr>';

       }


       $table .= '
		</tbody>
		</table>';


       $filename = "Weekly_Disease_Alerts_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");


       $this->output->append_output($table);

   }
   
     public function diseasecases()
   {
	  //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	   $data = array();
	   
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {
            
            redirect('home', 'refresh');
            
        }
	   
	   if ($level == 6) {//District
			$district_id = $this->erkanaauth->getField('district_id');			
			$district = $this->districtsmodel->get_by_id($district_id)->row();            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
			$data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
		}
		
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
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
	   }
	   
	   if($level==4)//national
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   if($level==5)//stakeholder
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		  $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   $data['level'] = $level;

       $this->load->view('reports/diseasecases', $data);
   }
   
   
   public function diseasecasesreport()
   {
	   if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();

       $level = $this->erkanaauth->getField('level');
       $country_id = $this->erkanaauth->getField('country_id');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

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
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;
	  
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
		   $data['thezone'] = 'All';
	   }
	   else
	   {
		   $zon_id = $zone_id;
		   $zone = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['thezone'] = $zone->zone;
	   }
	   
	   if(empty($region_id))
	   {
		   $reg_id = 0;
		   $data['theregion'] = 'All';
	   }
	   else
	   {
		   $reg_id = $region_id;
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['theregion'] = $region->region;
	   }
	   
	   if(empty($district_id))
	   {
		   $dist_id = 0;
		   $data['thedistrict'] = 'All';
	   }
	   else
	   {
		   $dist_id = $district_id;
		   $district = $this->districtsmodel->get_by_id($district_id)->row();
		   $data['thedistrict'] = $district->district;
	   }
	   
	   if(empty($healthfacility_id))
	   {
		   $hf_id = 0;
		   $data['thehealthfacility'] = 'All';
	   }
	   else
	   {
		   $hf_id = $healthfacility_id;
		   $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
		   $data['thehealthfacility'] = $healthfacility->health_facility;
	   }
	   
	   /**
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	  	   
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	   **/
	   
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


       $reportingperiodone = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiodtwo = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $epicalendaridArray = array();

       $startdate = $reportingperiodone->from;
       $enddate = $reportingperiodtwo->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);



       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;


       }
				
	   
	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
			   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
			   
	   $country_diseases = count($diseases);
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
			   
	   $diseasearray = array();
			   
	   foreach ($diseases->result() as $disease):
			$diseasearray[] = $disease->disease_code;
						
	   endforeach; 
	   
	   //$lists = $this->reportsmodel->get_full_list_case_week($reporting_year,$reporting_year2,$period_one,$period_two,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
       $lists = $this->reportsmodel->get_full_list_case_week_array($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);
	   	
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
			
			$table .= '<th>Wk'.$list->week_no.'</th>';
			
			foreach($diseasearray as $key=>$diseasecode):
				$disease_element = $diseasecode;
				$table .= '<td>'.$list->$disease_element.'</td>';
			
			endforeach;
			
			
			$table .= '</tr>';
			
		}
		
		
		$table .= '
		</tbody>
		</table>';
		
		
		$data['table'] = $table;
		$data['reporting_year'] = $reporting_year;
		$data['from'] = $from;
		$data['reporting_year2'] = $reporting_year2;
		$data['to'] = $to;
       $data['zone_id'] = $zon_id;
       $data['region_id'] = $reg_id;
       $data['district_id'] = $dist_id;
       $data['healthfacility_id'] = $hf_id;
		
		
		$this->load->view('reports/diseasecasesreport', $data);
	   
	   
   }

   public function exportdiseasecases()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $country_id = $this->erkanaauth->getField('country_id');


       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reportingyear');
       $from = $this->input->post('from');
       $reporting_year2 = $this->input->post('reportingyear2');
       $to = $this->input->post('to');

       if(empty($zone_id))
       {
           $zon_id = 0;
           $thezone = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $thezone = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $theregion = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $theregion = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $thedistrict = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $thedistrict = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $thehealthfacility = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $thehealthfacility = $healthfacility->health_facility;
       }

       $reportingperiodone = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiodtwo = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $epicalendaridArray = array();

       $startdate = $reportingperiodone->from;
       $enddate = $reportingperiodtwo->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);



       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;


       }


       $diseasecount = $this->diseasesmodel->get_country_list($country_id);
       $limit = count($diseasecount);

       $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);

       $diseasearray = array();

       foreach ($diseases->result() as $disease):
           $diseasearray[] = $disease->disease_code;

       endforeach;

       $lists = $this->reportsmodel->get_full_list_case_week_array($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseasearray);

       $colspan = ($limit+1);
       $table = '<table id="datatable" border="1" width="100%"><thead>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="'.$colspan.'"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="'.$colspan.'">Weekly Disease Cases from '.$reporting_year.' week '.$from.' to '.$reporting_year2.' week '.$to.'</th></tr>';
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

           $table .= '<th>Wk'.$list->week_no.'</th>';

           foreach($diseasearray as $key=>$diseasecode):
               $disease_element = $diseasecode;
               $table .= '<td>'.$list->$disease_element.'</td>';

           endforeach;


           $table .= '</tr>';

       }


       $table .= '
		</tbody>
		</table>';


       $filename = "Weekly_Disease_Cases_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");

       $this->output->append_output($table);
   }
   
   public function malariaquery()
   {
	  //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	   $data = array();
	   
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {
            
            redirect('home', 'refresh');
            
        }
	   
	   if ($level == 6) {//District
			$district_id = $this->erkanaauth->getField('district_id');			
			$district = $this->districtsmodel->get_by_id($district_id)->row();            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
			$data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
		}
		
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
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
	   }
	   
	   if($level==4)//national
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   if($level==5)//stakeholder
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		  $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   $data['level'] = $level;

       $this->load->view('reports/malariaquery', $data);
   }
   
   public function malariareport()
   {
	   
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

       $level = $this->erkanaauth->getField('level');
       $country_id = $this->erkanaauth->getField('country_id');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }



       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

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
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;

	  $data = array();
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
		   $data['thezone'] = 'All';
	   }
	   else
	   {
		   $zon_id = $zone_id;
		   $zone = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['thezone'] = $zone->zone;
	   }

	   if(empty($region_id))
	   {
		   $reg_id = 0;
		   $data['theregion'] = 'All';
	   }
	   else
	   {
		   $reg_id = $region_id;
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['theregion'] = $region->region;
	   }

	   if(empty($district_id))
	   {
		   $dist_id = 0;
		   $data['thedistrict'] = 'All';
	   }
	   else
	   {
		   $dist_id = $district_id;
		   $district = $this->districtsmodel->get_by_id($district_id)->row();
		   $data['thedistrict'] = $district->district;
	   }

	   if(empty($healthfacility_id))
	   {
		   $hf_id = 0;
		   $data['thehealthfacility'] = 'All';
	   }
	   else
	   {
		   $hf_id = $healthfacility_id;
		   $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
		   $data['thehealthfacility'] = $healthfacility->health_facility;
	   }
	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$from,$country_id)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week_country($reporting_year2,$to,$country_id)->row();
	   

	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	  
	  $region_id = $this->input->post('region_id');

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);

       $epicalendaridArray = array();

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;
           $yearArray[] =  $epilist->epdyear;
           $weekArray[] =  $epilist->week_no;


       }


	  //$sql = $this->reportsmodel->testmalaria_report($zon_id,$reg_id,0,0,$period_one,$period_two,$reporting_year,$reporting_year2);

	 //echo $sql;


	  //$lists = $this->formsmodel->malariareport($period_one, $period_two, $district_id, $region_id, $zone_id);

       $lists = $this->formsmodel->malaria_report($epicalendaridArray, $dist_id, $reg_id, $zon_id);
	  

				$class = 'class="alt"';
				$categories = '';
				$malariadata = '';
				$frdata = '';
				$sprdata = '';
				$malariaufivedata = '';
				$malariaofivedata = '';

	  $report_table = '<table id="listtable" border="1"><thead>
		<tr>
		<th>&nbsp;</th><th>Pv</th><th>Pf</th><th>Mixed</th><th>Spr</th><th>Fr</th><th># of Malaria reports</th><th>Slides tested</th><th>Slides positive</th></tr>
		</tr></thead>
		<tbody>';
		
		foreach ($lists as $key => $list) {
			
			if($class == 'class="alt"')
			{
				$class = '';
			}
			else
			{
				$class = 'class="alt"';
			}
			
			$totalslides = $list->totpv + $list->totpmix + $list->totpf;
			$sre = $list->totsre;
			
			
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
				$fr = ($list->totpf/$totalslides) * 100;
			}
			
			$malaria_total = $this->formsdatamodel->get_by_disease_period_locations($list->id,'Mal',$district_id, $region_id, $zone_id);
			
			$report_table .= '<tr '.$class.'>
			<td>WK '.$list->epdyear.'/'.$list->week_no.'</td><td>'.$list->totpv.'</td><td>'.$list->totpf.'</td><td>'.$list->totpmix.'</td><td>'.number_format($spr).'</td><td>'.number_format($fr).'</td><td>'.$malaria_total.'</td><td>'.$sre.'</td><td>'.$totalslides.'</td></tr>
			';
			
			$categories .= "'WK ".$list->epdyear."/".$list->week_no."', ";
			$malariadata .= "".$malaria_total.", ";
			$frdata .= "".number_format($fr).", ";
			$sprdata .= "".number_format($spr).", ";
			
			$under_five = $this->formsdatamodel->sum_by_under_five($list->id,'Mal',$district_id, $region_id, $zone_id);
			$over_five = $this->formsdatamodel->sum_by_over_five($list->id,'Mal',$district_id, $region_id, $zone_id);
			
			$malariaufivedata .= "".$under_five.", ";
			$malariaofivedata .= "".$over_five.", ";

			$under_five = NULL;
			$over_five = NULL;
			$malaria_total = NULL;

		}
		
		
		$report_table .= '</tbody></table>';
		
				   
	   $data['categories'] = $categories;
	   $data['malariadata'] = $malariadata;
	   $data['frdata'] = $frdata;
	   $data['sprdata'] = $sprdata;
	   $data['reporting_year'] = $reporting_year;
	   $data['from'] = $from;
	   $data['reporting_year2'] = $reporting_year2;
	   $data['to'] = $to;
	   $data['malariaufivedata'] = $malariaufivedata;
	   $data['malariaofivedata'] = $malariaofivedata;
	   $data['report_table'] = $report_table;
       $data['zone_id'] = $zon_id;
       $data['region_id'] = $reg_id;
       $data['district_id'] = $dist_id;
       $data['healthfacility_id'] = $hf_id;
       $data['country_id'] = $country_id;

		
		$this->load->view('reports/malariareport', $data);
	   
   }

   public function exportmalariareport()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $country_id = $this->erkanaauth->getField('country_id');


       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reportingyear');
       $from = $this->input->post('from');
       $reporting_year2 = $this->input->post('reportingyear2');
       $to = $this->input->post('to');

       if(empty($zone_id))
       {
           $zon_id = 0;
           $thezone = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $thezone = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $theregion = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $theregion = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $thedistrict = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $thedistrict = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $thehealthfacility = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $thehealthfacility = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$from,$country_id)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week_country($reporting_year2,$to,$country_id)->row();


       $startdate = $reportingperiod_one->from;
       $enddate = $reportingperiod_two->to;

       $region_id = $this->input->post('region_id');

       $epilists = $this->epdcalendarmodel->get_list_by_date($startdate,$enddate,$country_id);

       $epicalendaridArray = array();

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;
           $yearArray[] =  $epilist->epdyear;
           $weekArray[] =  $epilist->week_no;


       }


       $lists = $this->formsmodel->malaria_report($epicalendaridArray, $dist_id, $reg_id, $zon_id);


       $bgcolor = 'bgcolor="#CCCCCC"';

       $report_table = '<table id="listtable" border="1" width="100%"><thead>
<tr bgcolor="#13C3E6"><th colspan="9"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>
		<tr>
		<th>&nbsp;</th><th>Pv</th><th>Pf</th><th>Mixed</th><th>Spr</th><th>Fr</th><th># of Malaria reports</th><th>Slides tested</th><th>Slides positive</th></tr>
		</tr></thead>
		<tbody>';

       foreach ($lists as $key => $list) {

           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }

           $totalslides = $list->totpv + $list->totpmix + $list->totpf;
           $sre = $list->totsre;


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
               $fr = ($list->totpf/$totalslides) * 100;
           }

           $malaria_total = $this->formsdatamodel->get_by_disease_period_locations($list->id,'Mal',$district_id, $region_id, $zone_id);

           $report_table .= '<tr '.$bgcolor.'>
			<td>WK '.$list->epdyear.'/'.$list->week_no.'</td><td>'.$list->totpv.'</td><td>'.$list->totpf.'</td><td>'.$list->totpmix.'</td><td>'.number_format($spr).'</td><td>'.number_format($fr).'</td><td>'.$malaria_total.'</td><td>'.$sre.'</td><td>'.$totalslides.'</td></tr>
			';


       }


       $report_table .= '</tbody></table>';

       $filename = "Malaria_Report_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");


       $this->output->append_output($report_table);

   }
   
   

}
