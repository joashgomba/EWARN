<?php
error_reporting(0);
class Formcapture extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('formsmodel');
   }
   
   
   function index()
	{
	   $user_id = $_POST['userID'];
	   $zone_id = $_POST['zone'];
	   $region_id = $_POST['region'];
	   $district_id = $_POST['district'];
	   $healthfacility_id = $_POST['facility'];
	   $val = $_POST['form'];
	   $reporting_year  = $_POST['reporting_year'];
	   $week_no = $_POST['week_no'];
		   
	   //ensure that all the data has been captured by the form
	   if(empty($user_id) || empty($zone_id) || empty($region_id) || empty($district_id) || empty($healthfacility_id) || empty($val) || empty($reporting_year)|| empty($week_no)){
		   
			echo json_encode(
					array("message" => "Please enter all the required information.")
					);	   
	   }
	   else
	   {
		   
			$healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
			$district   = $this->districtsmodel->get_by_id($district_id)->row();
			$region = $this->regionsmodel->get_by_id($region_id)->row();
			$zone   = $this->zonesmodel->get_by_id($zone_id)->row();
				
			$user = $this->usersmodel->get_by_id($user_id)->row();
				
			$sre  = $this->input->post('sre');
			$pf   = $this->input->post('pf');
			$pv   = $this->input->post('pv');
			$pmix = $this->input->post('pmix');
		
			$total_positive = $pf + $pv + $pmix;
				
			$total_negative = $sre - $total_positive;
					
			$undismale= $this->input->post('undismale');
			$undisfemale  = $this->input->post('undisfemale');
			$undismaletwo = $this->input->post('undismaletwo');
			$undisfemaletwo   = $this->input->post('undisfemaletwo');
			$ocmale   = $this->input->post('ocmale');
			$ocfemale = $this->input->post('ocfemale');
					
			
			//check if the country has the entered reporting period
			
			$country_id = $user->country_id;
			$reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$week_no,$country_id)->row();
			
			
			if (empty($reportingperiod)) {
				echo json_encode(
					array("message" => "The reporting period you entered has not been added to your country. Please contact the system administrator for assistance.")
					);
			} else {
				
				//check if disease varriable is in the correct format
				if( strpos( $val, "#" ) === false ) 
				{
					echo json_encode(
						array("message" => "Invalid Data Format for Diseases.")
					);
				}
				else 
				{
					$reportingform = $this->formsmodel->get_by_period_hf($reportingperiod->id, $healthfacility_id);
					//check if the health facility has data entered for the reporting period
					if (!empty($reportingform)) {
						 echo json_encode(
							array("message" => "There is data entered for that period and health facillity.")
						);
					  } else {
						  
						  //save the submitted form data
						  
						  $data = array(
						   'week_no' => $this->input->post('week_no'),
						   'reporting_year' => $this->input->post('reporting_year'),
						   'reporting_date' => date('Y-m-d'),
						   'epicalendar_id' => $reportingperiod->id,
						   'user_id' => $user_id,
						   'healthfacility_id' => $healthfacility_id,
						   'district_id' => $district->id,
						   'region_id' => $region->id,
						   'zone_id' => $zone->id,
						   'contact_number' => 'N/A',
						   'supporting_ngo' => 'N/A',
						   'undisonedesc' => $this->input->post('undisonedesc'),
						   'undismale' => $this->input->post('undismale'),
						   'undisfemale' => $this->input->post('undisfemale'),
						   'undissecdesc' => $this->input->post('undissecdesc'),
						   'undismaletwo' => $this->input->post('undismaletwo'),
						   'undisfemaletwo' => $this->input->post('undisfemaletwo'),
						   'ocmale' => $this->input->post('ocmale'),
						   'ocfemale' => $this->input->post('ocfemale'),
						   'total_consultations' => $this->input->post('total_consultations'),
						   'sre' => $this->input->post('sre'),
						   'pf' => $this->input->post('pf'),
						   'pv' => $this->input->post('pv'),
						   'pmix' => $this->input->post('pmix'),
						   'total_positive' => $total_positive,
						   'total_negative' => $total_negative,
						   'approved_dist' => 0,
						   'approved_region' => 0,
						   'approved_zone' => 0,
						   'approved_national' => 0,
						   'draft' => 0,
						   'alert_sent' => 0,
						   'entry_date' => date('Y-m-d'),
						   'entry_time' => date("Y-m-d h:i:s"),
						   'edit_date' => date('Y-m-d'),
						   'edit_time' => date("Y-m-d h:i:s"),
						   'key' => 'Mobile APP',
						   'country_id' => $country_id,
					   );
					   $this->db->insert('forms', $data);
					   
					   
					   $form_id = $this->db->insert_id();//get the ID of the saved record
					   
					   
						$j=0;
					
						$diseasecount = $this->diseasesmodel->get_country_list($country_id);
						$country_diseases = count($diseasecount);
					
						$loop_limit = $country_diseases*4;
						for($i=0;$i<=$loop_limit;$i++)
						{
							
							$str = explode( "#", $val )[$i];
							preg_match_all('!\d+!', $str, $matches);
							//print_r($matches);
							
							$words = preg_replace('/[0-9]+/', '', $str);					
								
							$j++;
							
							if($words=='_u_f_m-')
							{
								$under_five_male = $matches[0][1];
							}
							else
							{
								
							}
							
							$total_under_five =0;
							if($j<=4){
						
							if($words=='_u_f_f-')
							{
								$under_five_female = 0+$matches[0][1];
								
							}
							
							else
							{
								//$under_five_female = '';
							}
							
							if($words=='_o_f_m-')
							{
								$over_five_male = 0+$matches[0][1];
							}
							else
							{
								//$over_five_male = '';
							}
							
							if($words=='_o_f_f-')
							{
								$over_five_female = 0+$matches[0][1];
							}
							
							else
							{
								//$over_five_female = '';
							}
							
							$total_under_five = ($under_five_male+$under_five_female);
							$total_over_five = ($over_five_male+$over_five_female);
							$total_disease = ($total_under_five+$total_over_five);
							
							$disease_id = $matches[0][0];
							
							$disease = $this->diseasesmodel->get_by_id($disease_id)->row();
							
							//when it reaches the forth element, save the records in the database
							if($j==4)
							{
												
								//capture the form data
								$formdata = array(
								   'form_id' => $form_id,
								   'epicalendar_id' => $reportingperiod->id,
								   'healthfacility_id' => $healthfacility_id,
								   'district_id' => $district->id,
								   'region_id' => $region->id,
								   'zone_id' => $zone->id,
								   'disease_id' => $disease->id,
								   'disease_name' => $disease->disease_code,
								   'male_under_five' => $under_five_male,
								   'female_under_five' => $under_five_female,
								   'male_over_five' => $over_five_male,
								   'female_over_five' => $over_five_female,
								   'total_under_five' => $total_under_five,
								   'total_over_five' => $total_over_five,
								   'total_disease' => $total_disease,
								   );
								   
								   $this->db->insert('formsdata', $formdata);	
								   
								   //disease alert check and entry
								   if($disease->alert_threshold==0)
									{
										$threshold = $disease->alert_threshold;
									}
									else
									{
										$threshold = ($disease->alert_threshold-1);
										
									}	
									
									//check if disease meets the threshold for alert
									if ($total_disease > $threshold) {
								
										$alertdata = array(
											'reportingform_id' => $form_id,
											'reportingperiod_id' => $reportingperiod->id,
											'disease_id' => $disease->id,
											'disease_name' => $disease->disease_code,
											'healthfacility_id' => $healthfacility_id,
											'district_id' => $district->id,
											'region_id' => $region->id,
											'zone_id' => $zone->id,
											'cases' => $total_disease,
											'deaths' => 0,
											'notes' => '',
											'verification_status' => 0,
											'include_bulletin' => 0
										);
										$this->db->insert('formalerts', $alertdata);
										
										
									}			
							
							}//end fourth element check
						
						}
						else
						{
							//reset the varriable loop checker 
							$j=1;
						}
							
							
						}//end disease capture loop
						
						 
						//display notification to the user
						  
						echo json_encode(
						array("message" => "The records have been successfully saved to the database.")
						);
						  
					  }//end health facility creporting period check
					  
					
					
				}//end disease varriable format check
				
								
				 
			 }// end year reporting period check	
		 
		 
	   }//end empty varriables check
		
		
	}   
	
	
	function captureform()
	{
		
		$data = array();
		$this->load->view('forms/captureform', $data);
		
	}
   

}
