<?php

class Validate extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('regionsmodel');
   }

   public function index()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 $level = $this->erkanaauth->getField('level');
	 $country_id = $this->erkanaauth->getField('country_id');
	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin' &&  $level !=2 && $level !=1 && $level !=4 && $level != 6)
	  {

		redirect('home', 'refresh');

	  }
	   $data = array();
	   
		$data['level'] = $level;
		
		
		
	   
	   if ($level == 6) {//District
			$district_id = $this->erkanaauth->getField('district_id');
			
			
			$district = $this->districtsmodel->get_by_id($district_id)->row();
            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
			$data['healthfacilities'] = $this->db->get_where('healthfacilities', array('district_id' => $district->id));
	   }
	   if($level==2)//region
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
	   
	   if(getRole() == 'SuperAdmin')
	  {

		$data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		  $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		  $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();

	  }
	  
	  if(getRole() == 'Admin')
	  {

		$data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		  $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		  $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();

	  }
	  
	  $data['countries'] = $this->countriesmodel->get_list();
	  $data['country_id'] = $country_id;
	  
	   
	   
       $this->load->view('forms/validate', $data);
   }
   
   function getlist()
   {
	   $reporting_year = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
	   $reporting_year2 = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year2']))));
	   $from = trim(addslashes(htmlspecialchars(rawurldecode($_POST['from']))));
	   $to = trim(addslashes(htmlspecialchars(rawurldecode($_POST['to']))));
	   $district_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
	   $healthfacility_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['healthfacility_id']))));
	   $gender = trim(addslashes(htmlspecialchars(rawurldecode($_POST['gender']))));
	   $zone_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['zone_id']))));
	   $region_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['region_id']))));
	   
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   //if(empty($reporting_year) || empty($reporting_year2) || empty($from) || empty($to) || empty($district_id)){
		   if(empty($reporting_year) || empty($reporting_year2) || empty($from) || empty($to)){
			echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">Please select all the required data</div></td></tr>
                              </tbody>
                            </table>';
		}
		else
		{
		
			if($reporting_year>$reporting_year2)
			{
				echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">The from year/week value cannot be greater than the to year/week value</div></td></tr>
                              </tbody>
                            </table>';
			}
			else
			{
				
				if(empty($healthfacility_id))
				{
					$hf_id = 0;
				}
				else
				{
					$hf_id = $healthfacility_id;
				}
				
				if(empty($district_id))
				{
					if($level==6)
					{
						$dist_id = $this->erkanaauth->getField('district_id'); 
					}
					else
					{
						$dist_id = 0;
					}
				}
				else
				{
					$dist_id = $district_id;
				}
				
				
				
				if(empty($region_id))
				{
					if($level==2)
					{
						$reg_id = $this->erkanaauth->getField('region_id');
					}
					else
					{
						$reg_id = 0;
					}
				}
				else
				{
					$reg_id = $region_id;
				}
				
				if(empty($zone_id))
				{
					if($level==1)
					{
						$zn_id = $this->erkanaauth->getField('zone_id');
					}
					else
					{
						$zn_id = 0;
					}
				}
				else
				{
					$zn_id = $zone_id;
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
	   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id));
	   
	   $country_diseases = count($diseases);
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
				
	   //query based on submitted values
	   
	     $sql = $this->formsmodel->get_full_list_export_test($reporting_year,$reporting_year2,$period_one,$period_two,$dist_id,$reg_id,$zn_id,$hf_id);
		 
		 //echo $sql;
	   $lists = $this->formsmodel->get_full_list_export($reporting_year,$reporting_year2,$period_one,$period_two,$dist_id,$reg_id,$zn_id,$hf_id);
				
				$table = '   <style>
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
				</style>';
				
				
				if($gender==1)
				{
				
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
							
							
								//$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease_limit($list->id, $list->healthfacility_id,$disease->id,1)->row();
								
								//$disease_under_five = ($formdata->male_under_five+$formdata->female_under_five);
								//$disease_over_five = ($formdata->male_over_five+$formdata->female_over_five);
								$disease_under_five = $formdata->total_under_five;
								$disease_over_five = $formdata->total_over_five;
								
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$disease_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$disease_over_five.'</td>';
								
								$disease_under_five = NULL;
								$disease_over_five = NULL;
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+$list->undisfemale);
							$undis_two = ($list->undismaletwo+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$oc_total.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==2)
				{
						$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th colspan="2">'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th colspan="2">'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					
					foreach ($diseases->result() as $disease):
						 $table .= '<th>M</th>';
						$table .= '<th>F</th>';
						$table .= '<th>M</th>';
						$table .= '<th>F</th>';
					endforeach;
					
					
					$table .= '<th>&nbsp;</th><th >&nbsp;</th><th >&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
						<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*4;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->male_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->female_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+$list->undisfemale);
							$undis_two = ($list->undismaletwo+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$oc_total.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==3)
				{
						$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>M</th>';
						$table .= '<th>M</th>';
					endforeach;
					
					$table .= '<th>M</th><th >M</th><th >M</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->male_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+0);
							$undis_two = ($list->undismaletwo+0);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$list->ocmale.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==4)
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>F</th>';
						$table .= '<th>F</th>';
					endforeach;
					
					$table .= '<th>M</th><th >M</th><th >M</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->female_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->female_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = (0+$list->undisfemale);
							$undis_two = (0+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$list->ocfemale.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
					
				echo $table;	
					
					
				
				
				
		}
	}
}
   
   
   
   function validatedata($id,$reporting_year,$reporting_year2,$from,$to,$gender,$zone_id=0,$region_id=0,$district_id=0,$healthfacility_id=0)
   {
	 
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	
		 if($level==6)//district
		 {
			 $data = array(
				   'approved_dist' => 1,				   
				   'approved_region' => 0,
				   'approved_zone' => 0,
				   'approved_national' => 0,
			   );
			  $this->db->where('id', $id);
			  $this->db->update('forms', $data);
		 }
		 
		 if($level==2)//regional
		 {
			 $data = array(
				   'approved_dist' => 1,
				   'approved_region' => 1,
				   'approved_zone' => 0,
				   'approved_national' => 0,
			   );
			  $this->db->where('id', $id);
			  $this->db->update('forms', $data);
		 }
		 
		  if($level==1)//zone
		 {
			 $data = array(
				   'approved_dist' => 1,
				   'approved_region' => 1,
				   'approved_zone' => 1,
				   'approved_national' => 0,
			   );
			   $this->db->where('id', $id);
			   $this->db->update('forms', $data);
		 }
		 
		 if($level==4)//National
		 {
			 $data = array(
				   'approved_dist' => 1,
				   'approved_region' => 1,
				   'approved_zone' => 1,
				   'approved_national' => 1,
			   );
			   
			   $this->db->where('id', $id);
			   $this->db->update('forms', $data);
		 }
		 
		 
		 if(empty($healthfacility_id) || $healthfacility_id==0)
				{
					$hf_id = 0;
				}
				else
				{
					$hf_id = $healthfacility_id;
				}
				
				if(empty($district_id) || $district_id==0)
				{
					if($level==6)
					{
						$dist_id = $this->erkanaauth->getField('district_id'); 
					}
					else
					{
						$dist_id = 0;
					}
				}
				else
				{
					$dist_id = $district_id;
				}
				
				
				
				if(empty($region_id) || $region_id==0)
				{
					if($level==2)
					{
						$reg_id = $this->erkanaauth->getField('region_id');
					}
					else
					{
						$reg_id = 0;
					}
				}
				else
				{
					$reg_id = $region_id;
				}
				
				if(empty($zone_id) || $zone_id==0)
				{
					if($level==1)
					{
						$zn_id = $this->erkanaauth->getField('zone_id');
					}
					else
					{
						$zn_id = 0;
					}
				}
				else
				{
					$zn_id = $zone_id;
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
	   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id));
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
				
	   //query based on submitted values
	   $lists = $this->formsmodel->get_full_list_export($reporting_year,$reporting_year2,$period_one,$period_two,$dist_id,$reg_id,$zn_id,$hf_id);
				
				$table = '   <style>
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
				</style>';
				
				
				if($gender==1)
				{
				
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
								$disease_under_five = ($formdata->male_under_five+$formdata->female_under_five);
								$disease_over_five = ($formdata->male_over_five+$formdata->female_over_five);
								
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$disease_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$disease_over_five.'</td>';
								
								$disease_under_five = NULL;
								$disease_over_five = NULL;
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+$list->undisfemale);
							$undis_two = ($list->undismaletwo+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$oc_total.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==2)
				{
						$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th colspan="2">'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th colspan="2">'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					
					foreach ($diseases->result() as $disease):
						 $table .= '<th>M</th>';
						$table .= '<th>F</th>';
						$table .= '<th>M</th>';
						$table .= '<th>F</th>';
					endforeach;
					
					
					$table .= '<th>&nbsp;</th><th >&nbsp;</th><th >&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
						<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*4;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->male_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->female_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+$list->undisfemale);
							$undis_two = ($list->undismaletwo+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$oc_total.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==3)
				{
						$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>M</th>';
						$table .= '<th>M</th>';
					endforeach;
					
					$table .= '<th>M</th><th >M</th><th >M</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->male_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+0);
							$undis_two = ($list->undismaletwo+0);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$list->ocmale.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==4)
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>F</th>';
						$table .= '<th>F</th>';
					endforeach;
					
					$table .= '<th>M</th><th >M</th><th >M</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->female_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->female_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = (0+$list->undisfemale);
							$undis_two = (0+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$list->ocfemale.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
					
				echo $table;	
   }
   
   
    function invalidate($id,$reporting_year,$reporting_year2,$from,$to,$gender,$zone_id=0,$region_id=0,$district_id=0,$healthfacility_id=0)
   {
	 
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	
		 if($level==6)//district
		 {
			 $data = array(
				   'approved_dist' => 0,				   
				   'approved_region' => 0,
				   'approved_zone' => 0,
				   'approved_national' => 0,
			   );
			  $this->db->where('id', $id);
			  $this->db->update('forms', $data);
		 }
		 
		 if($level==2)//regional
		 {
			 $data = array(
				   'approved_dist' => 1,
				   'approved_region' => 0,
				   'approved_zone' => 0,
				   'approved_national' => 0,
			   );
			  $this->db->where('id', $id);
			  $this->db->update('forms', $data);
		 }
		 
		  if($level==1)//zone
		 {
			 $data = array(
				   'approved_dist' => 1,
				   'approved_region' => 1,
				   'approved_zone' => 0,
				   'approved_national' => 0,
			   );
			   $this->db->where('id', $id);
			   $this->db->update('forms', $data);
		 }
		 
		 if($level==4)//National
		 {
			 $data = array(
				   'approved_dist' => 1,
				   'approved_region' => 1,
				   'approved_zone' => 0,
				   'approved_national' => 0,
			   );
			   
			   $this->db->where('id', $id);
			   $this->db->update('forms', $data);
		 }
		 
		 
		 if(empty($healthfacility_id) || $healthfacility_id==0)
				{
					$hf_id = 0;
				}
				else
				{
					$hf_id = $healthfacility_id;
				}
				
				if(empty($district_id) || $district_id==0)
				{
					if($level==6)
					{
						$dist_id = $this->erkanaauth->getField('district_id'); 
					}
					else
					{
						$dist_id = 0;
					}
				}
				else
				{
					$dist_id = $district_id;
				}
				
				
				
				if(empty($region_id) || $region_id==0)
				{
					if($level==2)
					{
						$reg_id = $this->erkanaauth->getField('region_id');
					}
					else
					{
						$reg_id = 0;
					}
				}
				else
				{
					$reg_id = $region_id;
				}
				
				if(empty($zone_id) || $zone_id==0)
				{
					if($level==1)
					{
						$zn_id = $this->erkanaauth->getField('zone_id');
					}
					else
					{
						$zn_id = 0;
					}
				}
				else
				{
					$zn_id = $zone_id;
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
	   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id));
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
				
	   //query based on submitted values
	   $lists = $this->formsmodel->get_full_list_export($reporting_year,$reporting_year2,$period_one,$period_two,$dist_id,$reg_id,$zn_id,$hf_id);
				
				$table = '   <style>
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
				</style>';
				
				
				if($gender==1)
				{
				
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
								$disease_under_five = ($formdata->male_under_five+$formdata->female_under_five);
								$disease_over_five = ($formdata->male_over_five+$formdata->female_over_five);
								
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$disease_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$disease_over_five.'</td>';
								
								$disease_under_five = NULL;
								$disease_over_five = NULL;
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+$list->undisfemale);
							$undis_two = ($list->undismaletwo+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$oc_total.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==2)
				{
						$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th colspan="2">'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th colspan="2">'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					
					foreach ($diseases->result() as $disease):
						 $table .= '<th>M</th>';
						$table .= '<th>F</th>';
						$table .= '<th>M</th>';
						$table .= '<th>F</th>';
					endforeach;
					
					
					$table .= '<th>&nbsp;</th><th >&nbsp;</th><th >&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
						<th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*4;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->male_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->female_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+$list->undisfemale);
							$undis_two = ($list->undismaletwo+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$oc_total.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==3)
				{
						$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>M</th>';
						$table .= '<th>M</th>';
					endforeach;
					
					$table .= '<th>M</th><th >M</th><th >M</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else
					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->male_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->male_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = ($list->undismale+0);
							$undis_two = ($list->undismaletwo+0);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$list->ocmale.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
				else if($gender==4)
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr><th>Week</th><th>HFC Name</th>';
					
					$disease_count = 0;
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>'.$disease->disease_code.' < 5yr</th>';
						$table .= '<th>'.$disease->disease_code.' > 5yr</th>';
					endforeach;
					
					$table .= '<th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
						
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th>';
					foreach ($diseases->result() as $disease):
						$disease_count++;
						$table .= '<th>F</th>';
						$table .= '<th>F</th>';
					endforeach;
					
					$table .= '<th>M</th><th >M</th><th >M</th><th>SRE</th><th>Pf</th>
						<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th></tr>';
					$table .= '</thead>';
					$table .= '<tbody>';
					
					
					$total_diseases = $disease_count*2;
					$colspan = $total_diseases+12;
					
					
					if(empty($lists))
					{
							$table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
					}
					else

					{
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
							
							$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
							$user = $this->usersmodel->get_by_id($list->user_id)->row();
							$table .= '<td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
																
								//check if disease had alert and change the cell color to red
								
								$alert = $this->formalertsmodel->get_by_form_period_disease($list->id, $list->healthfacility_id,$disease->id,$list->epicalendar_id)->row();
								
								if(!empty($alert))
								{
									$tdcolor = 'bgcolor="#FF0000"';
								}
								else
								{
									$tdcolor = '';
								}
								
								$table .= '<td '.$tdcolor.'>'.$formdata->female_under_five.'</td>';
								$table .= '<td '.$tdcolor.'>'.$formdata->female_over_five.'</td>';
								
								
								$formdata = NULL;
								$tdcolor = NULL;
								$alert = NULL;
							endforeach;
							
							$oc_total = ($list->ocmale+$list->ocfemale);
							
							$undis_one = (0+$list->undisfemale);
							$undis_two = (0+$list->undisfemaletwo);
							
							//for OC and UNDIS also check if alert threshold met and change the column color to red
							$undisalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'UnDis',$list->epicalendar_id)->row();
							
							if(!empty($undisalert))
							{
								$undisdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$undisdcolor = '';
							}
							
							$pfalert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'Pf',$list->epicalendar_id)->row();
							
							if(!empty($pfalert))
							{
								$pftdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$pftdcolor = '';
							}
							
							$srealert = $this->formalertsmodel->get_by_form_period_disease_name($list->id, $list->healthfacility_id,'SRE',$list->epicalendar_id)->row();
							
							if(!empty($srealert))
							{
								$srtdcolor = 'bgcolor="#FF0000"';
							}
							else
							{
								$srtdcolor = '';
							}
							
							
							
							$table .= '<td '.$undisdcolor.'>'.$undis_one.'</td><td '.$undisdcolor.'>'.$undis_two.'</td><td>'.$list->ocfemale.'</td><td '.$srtdcolor.'>'.$list->sre.'</td><td '.$pftdcolor.'>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
							if(empty($user))
								{
									$table .= '<td>&nbsp;</td>';
								}
								else
								{
									$table .= '<td>'.$user->username.'</td>';
								}
								
								if($level==6)//district
								{
									if($list->approved_region==0)
									{
										if($list->approved_dist==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else if($list->approved_dist==1)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->second_admin_level_label.'</span></td>';
									}
								}
								
								if($level==2)//region
								{
									if($list->approved_zone==0)
									{
										if($list->approved_region==0)
										{
											/**
											if($list->approved_dist==0)
											{
												$table .= '<td><span class="label label-important arrowed-in">Not Approved '.$country->third_admin_level_label.'</span></td>';
											}
											else
											{
												$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
											}
											**/
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved '.$country->first_admin_level_label.'</span></td>';
									}
								}
								
								if($level==1)//zonal
								{
									if($list->approved_national==0)
									{
										if($list->approved_zone==0)
										{
											$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
										}
										else
										{
											$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
										}
									}
									else
									{
										$table .= '<td><span class="label label-important arrowed-in">Approved National Level</span></td>';
									}
								}
								
								if($level==4)//National
								{
									if($list->approved_zone==0)
									{
										$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-success radius-4">Validate</a></td>';
									}
									else
									{
										$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-danger radius-4">Invalidate</a></td>';
									}
								}
								
								$table .= '</tr>';
								
							$oc_total = NULL;
							$undis_one = NULL;
							$undis_two = NULL;
							$healthfacility = NULL;
							$user = NULL;
							$srtdcolor = NULL;
							$pftdcolor = NULL;
							$undisdcolor = NULL;
							$undisalert = NULL;
							$pfalert = NULL;
							$srealert = NULL;
						}
					}
					
					
					$table .= '</tbody>';
					$table .= '</table>';
				}
					
				echo $table;	
   }

  function gethealthfacilities()
   {
	   $district_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
	   
	   $healthfailities = $this->healthfacilitiesmodel->get_by_district($district_id);
	   
	   $district = $this->districtsmodel->get_by_id($district_id)->row();
	   
	   
	   $level = $this->erkanaauth->getField('level');
	  	   
	   $facilityselect = '<select name="healthfacility_id" id="healthfacility_id">';
	     $facilityselect .= '<option value="">-All health facilities-</option>';	
		if(!empty($healthfailities))
		{	
		   foreach($healthfailities as $key => $healthfacility)
		   {
			   $facilityselect .= '<option value="'.$healthfacility['id'].'">'.$healthfacility['health_facility'].'</option>';
		   }
		}
		else
		{
		   if($level ==2)
	 	   {
			   $region_id = $this->erkanaauth->getField('region_id');
			   $region = $this->regionsmodel->get_by_id($region_id)->row();
			   $healthfailitiesdata = $this->healthfacilitiesmodel->get_by_region($region->id);
			   foreach($healthfailitiesdata->result() as $healthfailitiesdatum)
               {
				   $facilityselect .= '<option value="'.$healthfailitiesdatum->id.'">'.$healthfailitiesdatum->health_facility.'</option>';
			   }
				
	 	   }
		   elseif($level ==1)
		   {
			   $zone_id = $this->erkanaauth->getField('zone_id');
			   $zone = $this->zonesmodel->get_by_id($zone_id)->row();
			   $healthfailitiesdata = $this->healthfacilitiesmodel->get_by_zone($zone->id);
			   foreach($healthfailitiesdata->result() as $healthfailitiesdatum)
               {
				   $facilityselect .= '<option value="'.$healthfailitiesdatum->healthfacility_id.'">'.$healthfailitiesdatum->health_facility.'</option>';
			   }
				
		   }
		   else
		   {
			   $healthfailitiesdata = $this->healthfacilitiesmodel->get_list();
				foreach($healthfailitiesdata as $hkey => $healthfailitiesdatum)
			   {
				   $facilityselect .= '<option value="'.$healthfailitiesdatum['id'].'">'.$healthfailitiesdatum['health_facility'].'</option>';
			   }
		   }
		}
	   
	   $facilityselect .= '</select>';
	   
	   echo $facilityselect;
									
   }
   
   
    public function export()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 $level = $this->erkanaauth->getField('level');
	 $country_id = $this->erkanaauth->getField('country_id');
	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin' &&  $level !=2 && $level !=1 && $level !=4 && $level != 6)
	  {

		redirect('home', 'refresh');

	  }
	   $data = array();
	   
	  $data['level'] = $level;
			   
	   if ($level == 6) {//District
			$district_id = $this->erkanaauth->getField('district_id');
			
			
			$district = $this->districtsmodel->get_by_id($district_id)->row();
            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
			$data['healthfacilities'] = $this->db->get_where('healthfacilities', array('district_id' => $district->id));
	   }
	   if($level==2)//region
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
	   
	   if(getRole() == 'SuperAdmin')
	  {

		$data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		  $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		  $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();

	  }
	  
	  if(getRole() == 'Admin')
	  {

		$data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		  $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		  $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();

	  }
	  
	   $data['countries'] = $this->countriesmodel->get_list();
	  $data['country_id'] = $country_id;
	   
       $this->load->view('forms/export', $data);
   }
   
   public function exportlist()
   {
	   
	   if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
		
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   $region_id = $this->input->post('region_id');
	   $district_id = $this->input->post('district_id');
	   $healthfacility_id = $this->input->post('healthfacility_id');
	   
	   $reporting_year = $this->input->post('reporting_year');
	   $from = $this->input->post('from');
	   $reporting_year2 = $this->input->post('reporting_year2');
	   $to = $this->input->post('to');
	   
	   if(empty($healthfacility_id))
				{
					$hf_id = 0;
				}
				else
				{
					$hf_id = $healthfacility_id;
				}
				
				if(empty($district_id))
				{
					if($level==6)
					{
						$dist_id = $this->erkanaauth->getField('district_id'); 
					}
					else
					{
						$dist_id = 0;
					}
				}
				else
				{
					$dist_id = $district_id;
				}
				
				
				
				if(empty($region_id))
				{
					if($level==2)
					{
						$reg_id = $this->erkanaauth->getField('region_id');
					}
					else
					{
						$reg_id = 0;
					}
				}
				else
				{
					$reg_id = $region_id;
				}
				
				if(empty($zone_id))
				{
					if($level==1)
					{
						$zn_id = $this->erkanaauth->getField('zone_id');
					}
					else
					{
						$zn_id = 0;
					}
				}
				else
				{
					$zn_id = $zone_id;
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
	   
	   $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id));
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
				
	   //query based on submitted values
	   $lists = $this->formsmodel->get_full_list_export($reporting_year,$reporting_year2,$period_one,$period_two,$dist_id,$reg_id,$zn_id,$hf_id);
	   
	   
	   $table = '<table border="1">';
	$table .= '<thead>';
	  $table .= '<tr bgcolor="#438eb9"><th>week_year</th><th>week_no</th><th>Zon_name</th><th>reg_name</th><th>d_name</th>
		<th>org_name</th><th>hf_name</th><th>hft</th><th>hfc</th>';
					
	  $disease_count = 0;
	  foreach ($diseases->result() as $disease):
		$disease_count++;
		$table .= '<th>'.strtolower($disease->disease_code).'_lt_5</th>';
		$table .= '<th>'.strtolower($disease->disease_code).'_gt_5</th>';
	  endforeach;
	
							
		$table .= '<th>unDis_name</th><th >unDis_num</th><th>unDis_name</th><th >unDis_num</th><th>oc</th><th>total_cons_disease</th><th>sre</th><th>pf</th><th>pv</th><th>pmix</th><th>zon_code</th>
		<th>reg_code</th><th>dis_code</th><th>Entry_Date</th><th>Entry_Time</th><th>User_ID</th><th>con_number</th><th>Edit_Date</th><th>Edit_Time</th></tr>';
		$table .= '</thead>';
		$table .= '<tbody>';
		
		  
	  $total_diseases = $disease_count*2;
	  $colspan = $total_diseases+28;
	  
	  if(empty($lists))
	  {
		 $table .= '<tr><td colspan="'.$colspan.'">No Data Submitted from HFCs</td></tr>';
	  }
	  else
	  {
			$bgcolor = 'bgcolor="#CCCCCC"';
			foreach ($lists as $key => $list):
				if($bgcolor == 'bgcolor="#CCCCCC"')
				{
					$bgcolor = '';
				}
				else
				{
					$bgcolor = 'bgcolor="#CCCCCC"';
				}
				
				$table .= '<tr '.$bgcolor.'>';
							
				$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
				$user = $this->usersmodel->get_by_id($list->user_id)->row();
				$zone = $this->zonesmodel->get_by_id($list->zone_id)->row();
				$region = $this->regionsmodel->get_by_id($list->region_id)->row();
				$district = $this->districtsmodel->get_by_id($list->district_id)->row();
				
				$table .= '<td>'.$list->reporting_year.'</td><td>'.$list->week_no.'</td><td>'.$zone->zone.'</td><td>'.$region->region.'</td><td>'.$district->district.'</td><td>'.$healthfacility->organization.'</td><td>'.$healthfacility->health_facility.'</td><td>'.$healthfacility->health_facility_type.'</td><td>'.$healthfacility->hf_code.'</td>';
				
				//loop through the diseases and get the values submitted
							foreach ($diseases->result() as $disease):
							
								$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($list->id, $list->healthfacility_id,$disease->id)->row();
								
								$disease_under_five = ($formdata->male_under_five+$formdata->female_under_five);
								$disease_over_five = ($formdata->male_over_five+$formdata->female_over_five);
								
																
								$table .= '<td>'.$disease_under_five.'</td>';
								$table .= '<td>'.$disease_over_five.'</td>';
								
								$disease_under_five = NULL;
								$disease_over_five = NULL;
								$formdata = NULL;
							endforeach;
							
				$oc_total = ($list->ocmale+$list->ocfemale);
							
				$undis_one = ($list->undismale+$list->undisfemale);
				$undis_two = ($list->undismaletwo+$list->undisfemaletwo);
							
				$table .= '<td>'.$list->undisonedesc.'</td><td>'.$undis_one.'</td><td>'.$list->undissecdesc.'</td><td>'.$undis_two.'</td><td>'.$oc_total.'</td><td>'.$list->total_consultations.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$zone->zonal_code.'</td>
		<td>'.$region->regional_code.'</td><td>'.$district->district_code.'</td><td>'.$list->entry_date.'</td><td>'.$list->entry_time.'</td><td>'.$user->username.'</td><td>'.$user->contact_number.'</td><td>'.$list->edit_date.'</td><td>'.$list->edit_time.'</td>';
				
				$table .= '</tr>';
				
				$oc_total = NULL;
				$undis_one = NULL;
				$undis_two = NULL;
				$healthfacility = NULL;
				$user = NULL;
										
			endforeach;
	  }
	  
		
		$table .= '</tbody>';		
		$table .= '</table>';
		
		$filename = "Weekly_Reporting_Forms_".date('dmY-his').".xls";
		
		$this->output->set_header("Content-Type: application/vnd.ms-word");
		$this->output->set_header("Expires: 0");
		$this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header("content-disposition: attachment;filename=".$filename."");
		
		
		$this->output->append_output($table);
   }

}
