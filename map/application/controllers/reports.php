<?php

class Reports extends CI_Controller {

   function __construct()
   {
       parent::__construct();
	   $this->load->model('reportsmodel');
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
                            <tr><th>Week</th><th>Disease</th><th>Cases</th></tr>
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
			$diphtotal = $sumtable->diph;
			$wctotal = $sumtable->wc;
			$meastotal = $sumtable->meas;
			$nnttotal = $sumtable->nnt;
			$afptotal = $sumtable->afp;
			$ajstotal = $sumtable->ajs;
			$vhftotal = $sumtable->vhf;
			$maltotal = $sumtable->mal_lt_5 + $sumtable->mal_gt_5;
			$mentotal = $sumtable->men;
			
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
			$diphtotal = $sumtable->diph;
			$wctotal = $sumtable->wc;
			$meastotal = $sumtable->meas;
			$nnttotal = $sumtable->nnt;
			$afptotal = $sumtable->afp;
			$ajstotal = $sumtable->ajs;
			$vhftotal = $sumtable->vhf;
			$maltotal = $sumtable->mal_lt_5 + $sumtable->mal_gt_5;
			$mentotal = $sumtable->men;
			
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
			$diphtotal = $sumtable->diph;
			$wctotal = $sumtable->wc;
			$meastotal = $sumtable->meas;
			$nnttotal = $sumtable->nnt;
			$afptotal = $sumtable->afp;
			$ajstotal = $sumtable->ajs;
			$vhftotal = $sumtable->vhf;
			$maltotal = $sumtable->mal_lt_5 + $sumtable->mal_gt_5;
			$mentotal = $sumtable->men;
			
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
		<tr><td colspan="16"><strong>Type A Alerts</strong></td></tr>
		<tr>
		<th>Health Facility Name</th><th>Week</th><th>Disease</th><th>No. of Alerts</th>
		</tr></thead>';
		
		$alertclass = 'class="alt"';
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
	    
		$alertstable .= '</table>';
		
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
		<tr><td colspan="16"><strong>Type B Alerts</strong></td></tr>
		<tr>
		<th>Health Facility Name</th><th>Week</th><th>Disease</th><th>No. of Alerts</th>
		</tr></thead>';
		
		$alertclass = 'class="alt"';
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
			
			if($hfalert->disease_name=='ILI' || $hfalert->disease_name=='BD'|| $hfalert->disease_name=='OAD' || $hfalert->disease_name=='NNT' || $hfalert->disease_name=='AJS' || $hfalert->disease_name=='Mal')
			{
									
				$alertsbtable .= '<tr '.$alertclass.'>
			<td>'.$hfalert->health_facility.'</td><td>WK '.$epicalendar->epdyear.'/'.$epicalendar->week_no.'</td><td>'.$hfalert->disease_name.'</td><td>'.$hfalert->reported_cases.'</td>
			</tr>';
			}
			
		}
	    
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
			$saritot =  $sariutot + $sariutot;
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
			$maltot = $malotot + $malutot;
			$mentot = $form->suspectedmenegitismale + $form->suspectedmenegitisfemale;
			$undistot = $form->undismale + $form->undisfemale;
			$undistwotot = $form->undismaletwo + $form->undisfemaletwo;
			$octot = $form->ocmale + $form->ocfemale;
			
			$table .= '<tr '.$class.'>
		<td>'.$form->health_facility.'</td><td>WK '.$form->reporting_year.'/'.$form->week_no.'</td><td>'.$saritot.'</td><td>'.$oadtot.'</td><td>'.$diphtot.'</td><td>'.$wctot.'</td><td>'.$meastot.'</td><td>'.$afptot.'</td>
		<td>'.$vhftot.'</td><td>'.$mentot.'</td>
		</tr>';
			
		}
	    
		$table .= '</table>';
		
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
		<tr><th>Health Facility Name</th><th>Week</th><th>ILI</th><th>BD</th><th>OAD</th><th>NNT</th><th>AJS</th><th>Mal</th></tr>
		</thead>';
		
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
			$saritot =  $sariutot + $sariutot;
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
			$maltot = $malotot + $malutot;
			$mentot = $form->suspectedmenegitismale + $form->suspectedmenegitisfemale;
			$undistot = $form->undismale + $form->undisfemale;
			$undistwotot = $form->undismaletwo + $form->undisfemaletwo;
			$octot = $form->ocmale + $form->ocfemale;
			
			$typebtable .= '<tr '.$class.'>
		<td>'.$form->health_facility.'</td><td>WK '.$form->reporting_year.'/'.$form->week_no.'</td><td>'.$ilitot.'</td><td>'.$bdtot.'</td><td>'.$oadtot.'</td><td>'.$nnttot.'</td><td>'.$ajstot.'</td><td>'.$maltot.'</td>
		</tr>';
			
		}
		
		
		$typebtable .= '</table>';
		
		$data['table'] = $table;
		$data['typebtable'] = $typebtable;
		$data['reporting_year'] = $reporting_year;
		$data['from'] = $from;
		$data['reporting_year2'] = $reporting_year2;
		$data['to'] = $to;
		
		
		$this->load->view('reports/weeklyhfalerts', $data);
   }
   
   public function malariaquery()
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
	   
	   $data['level'] = $level;

       $this->load->view('reports/malariaquery', $data);
   }
   
   public function malariareport()
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
	  
	  $region_id = $this->input->post('region_id');
	  
	   	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	   
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	  $sql = $this->reportsmodel->testmalaria_report($zon_id,$reg_id,0,0,$period_one,$period_two,$reporting_year,$reporting_year2);
	  
	  //echo $sql;
	   
	   $forms = $this->reportsmodel->malaria_report($zon_id,$reg_id,0,0,$period_one,$period_two,$reporting_year,$reporting_year2);
	   
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
		<tr>
		<th>&nbsp;</th><th>Pv</th><th>Pf</th><th>Mixed</th><th>Spr</th><th>Fr</th><th># of Malaria reports</th><th>Slides tested</th><th>Slides positive</th></tr>
		</tr></thead>';
		
		$categories = '';
		$malariadata = '';
		$frdata = '';
		$sprdata = '';
		
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
			$saritot =  $sariutot + $sariutot;
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
			$maltot = $malotot + $malutot;
			$mentot = $form->suspectedmenegitismale + $form->suspectedmenegitisfemale;
			$undistot = $form->undismale + $form->undisfemale;
			$undistwotot = $form->undismaletwo + $form->undisfemaletwo;
			$octot = $form->ocmale + $form->ocfemale;
			
				
			$saritotal = $form->sari_lt_5 + $form->sari_gt_5;
			$ilitotal = $form->ili_lt_5 + $form->ili_gt_5;
			$awdtotal = $form->awd_lt_5 + $form->awd_gt_5;
			$bdtotal = $form->bd_lt_5 + $form->bd_gt_5;
			$oadtotal = $form->oad_lt_5 + $form->oad_gt_5;
			$diphtotal = $form->diph;
			$wctotal = $form->wc;
			$meastotal = $form->meas;
			$nnttotal = $form->nnt;
			$afptotal = $form->afp;
			$ajstotal = $form->ajs;
			$vhftotal = $form->vhf;
			$maltotal = $form->mal_lt_5 + $form->mal_gt_5;
			$mentotal = $form->men;
			
			$totalslides = $form->totpv + $form->totpmix + $form->totpf;
			$sre = $form->totsre;
			
			
			if($totalslides==0)
			{
				$spr = 0;
				$fr = 0;
			}
			else
			{
			
				$spr = ($totalslides/$sre) * 100;
				$fr = ($form->totpf/$totalslides) * 100;
			}
			
			$table .= '<tr>
			<td>WK '.$form->reporting_year.'/'.$form->week_no.'</td><td>'.$form->totpv.'</td><td>'.$form->totpf.'</td><td>'.$form->totpmix.'</td><td>'.number_format($spr).'</td><td>'.number_format($fr).'</td><td>'.$maltotal.'</td><td>'.$sre.'</td><td>'.$totalslides.'</td></tr>
			</tr>
			</tr>';
			
			$categories .= "'WK ".$form->reporting_year."/".$form->week_no."', ";
			$malariadata .= "".$maltotal.", ";
			$frdata .= "".number_format($fr).", ";
			$sprdata .= "".number_format($spr).", ";
			
		}
	    
		$table .= '</table>';
	   
	   $data['categories'] = $categories;
	   $data['malariadata'] = $malariadata;
	   $data['frdata'] = $frdata;
	   $data['sprdata'] = $sprdata;
	   $data['table'] = $table;
	   $data['reporting_year'] = $reporting_year;
	   $data['from'] = $from;
	   $data['reporting_year2'] = $reporting_year2;
	   $data['to'] = $to;
		
		
		$this->load->view('reports/malariareport', $data);
	   
   }
   
   

}
