<?php
//error_reporting(0);
class Formcapture extends CI_Controller {

   function __construct()
   {
       parent::__construct();
	   $this->output->set_header('Access-Control-Allow-Origin: *');
       $this->load->model('formsmodel');
   }
   
   
   function index()
   {
        /**
	   $json = '{
			"zone_id": "1",
			"region_id": "1",
			"district_id": "1",
			"health_facility_id": "1",
			"reporting_year": "2018",
			"reporting_week": "29",
			"reporting_date": "2018-04-09",
			"reporter_id": "1",
			"health_events": {
				"1_u_f_m": "1",
				"1_u_f_f": "2",
				"1_o_f_m": "3",
				"1_o_f_f": "4",
				"2_u_f_m": "5",
				"2_u_f_f": "6",
				"2_o_f_m": "7",
				"2_o_f_f": "8",
				"3_u_f_m": "9",
				"3_u_f_f": "10",
				"3_o_f_m": "11",
				"3_o_f_f": "12",
				"4_u_f_m": "9",
				"4_u_f_f": "10",
				"4_o_f_m": "11",
				"4_o_f_f": "12",
				"5_u_f_m": "9",
				"5_u_f_f": "10",
				"5_o_f_m": "11",
				"5_o_f_f": "12",
				"6_u_f_m": "9",
				"6_u_f_f": "10",
				"6_o_f_m": "11",
				"6_o_f_f": "12",
				"7_u_f_m": "9",
				"7_u_f_f": "10",
				"7_o_f_m": "11",
				"7_o_f_f": "12",
				"8_u_f_m": "9",
				"8_u_f_f": "10",
				"8_o_f_m": "11",
				"8_o_f_f": "12",
				"9_u_f_m": "9",
				"9_u_f_f": "10",
				"9_o_f_m": "11",
				"9_o_f_f": "12",
				"10_u_f_m": "9",
				"10_u_f_f": "10",
				"10_o_f_m": "11",
				"10_o_f_f": "12",
				"11_u_f_m": "9",
				"11_u_f_f": "10",
				"11_o_f_m": "11",
				"11_o_f_f": "12",
				"12_u_f_m": "9",
				"12_u_f_f": "10",
				"12_o_f_m": "11",
				"12_o_f_f": "12",
				"13_u_f_m": "9",
				"13_u_f_f": "10",
				"13_o_f_m": "11",
				"13_o_f_f": "12",
				"14_u_f_m": "9",
				"14_u_f_f": "10",
				"14_o_f_m": "11",
				"14_o_f_f": "12"
			 
			},
			"other_unusual_diseases": {
				 "description_one": "N/A", 
				 "male_one": "0", 
				 "female_one": "0",
				 "description_two": "N/A", 
				 "male_two": "0", 
				 "female_two": "0",
				 "oc_male": "0", 
				 "oc_female": "0"
			 
			},
			"malaria_tests": {
				"rdt_examined": "0",
				"falciparum_positive": "0",
				"vivax_positive": "0",
				"mixed_positive": "0"
			}
		}';
		
        **/
		
		//$json = $_POST['surveillance_data'];
		
		
		
		//$arr = json_decode($json,true);//decode object
		$arr = json_decode(file_get_contents("php://input"),true);
		
		//check if empty and if right format
		if(empty($arr)|| !is_array($arr))
		{
			echo json_encode(
				array("message" => "Please enter all the required information.")
			);	
		}
		else
		{
			$zone_id = $arr['zone_id'];
			$region_id = $arr['region_id'];
			$district_id = $arr['district_id'];
			$healthfacility_id = $arr['health_facility_id'];
			$reporting_year = $arr['reporting_year'];
			$week_no = $arr['reporting_week'];
			$reporting_date = $arr['reporting_date'];
			$user_id = $arr['reporter_id'];			
			$health_events = $arr['health_events'];
			$other_unusual_diseases = $arr['other_unusual_diseases'];
			$undisonedesc = $other_unusual_diseases['description_one'];
			$undismale = $other_unusual_diseases['male_one'];
			$undisfemale = $other_unusual_diseases['female_one'];
			$undissecdesc = $other_unusual_diseases['description_two'];
			$undismaletwo = $other_unusual_diseases['male_two'];
			$undisfemaletwo = $other_unusual_diseases['female_two'];
			$ocmale = $other_unusual_diseases['oc_male'];
			$ocfemale = $other_unusual_diseases['oc_female'];
			$malaria_tests = $arr['malaria_tests'];
			$sre = $malaria_tests['rdt_examined'];
			$pf = $malaria_tests['falciparum_positive'];
			$pv = $malaria_tests['vivax_positive'];
			$pmix = $malaria_tests['mixed_positive'];
			
			$total_positive = $pf + $pv + $pmix;
            
            $total_negative = $sre - $total_positive;
			
			//start calculating total consultations
			$total_consultations = ($undismale+$undisfemale+$undismaletwo+$undisfemaletwo+$ocmale+$ocfemale);
			
			$user = $this->usersmodel->get_by_id($user_id)->row();
			
			//check if the country has the entered reporting period
			
			$country_id = $user->country_id;
			$reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$week_no,$country_id)->row();
			if (empty($reportingperiod)) {
				echo json_encode(
					array("message" => "The reporting period you entered has not been added to your country. Please contact the system administrator for assistance.")
					);
			} else {
				$reportingform = $this->formsmodel->get_by_period_hf($reportingperiod->id, $healthfacility_id);
				//check if the health facility has data entered for the reporting period
				if (!empty($reportingform)) {
					 echo json_encode(
							array("message" => "There is data already entered for that period and health facillity.")
					 );
				} else {
					//save the records
                    $epdcalendar = $this->epdcalendarmodel->get_by_id($reportingperiod->id)->row();
                    $entry_date = $reporting_date;

                    // Create a new DateTime object
                    $date = new DateTime($epdcalendar->to);

                    // Reports have to be submitted the next monday
                    $date->modify('next monday');

                    // Output
                    $validation_date = $date->format('Y-m-d');

                    if($entry_date>$validation_date)
                    {
                        $timely = 0;
                    }
                    else{
                        $timely = 1;
                    }

					$data = array(
						   'week_no' => $week_no,
						   'reporting_year' => $reporting_year,
						   'reporting_date' => $reporting_date,
						   'epicalendar_id' => $reportingperiod->id,
						   'user_id' => $user_id,
						   'healthfacility_id' => $healthfacility_id,
						   'district_id' => $district_id,
						   'region_id' => $region_id,
						   'zone_id' => $zone_id,
						   'contact_number' => 'N/A',
						   'supporting_ngo' => 'N/A',
						   'undisonedesc' => $undisonedesc,
						   'undismale' => $undismale,
						   'undisfemale' => $undisfemale,
						   'undissecdesc' => $undissecdesc,
						   'undismaletwo' => $undismaletwo,
						   'undisfemaletwo' => $undisfemaletwo,
						   'ocmale' => $ocmale,
						   'ocfemale' => $ocfemale,
						   'total_consultations' => 0,
						   'sre' => $sre,
						   'pf' => $pf,
						   'pv' => $pv,
						   'pmix' => $pmix,
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
						   'key' => 'APP',
						   'country_id' => $country_id,
                           'timely' => $timely,
					   );
					   $this->db->insert('forms', $data);
					   
					   
					   $form_id = $this->db->insert_id();//get the ID of the saved record
					   
					   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id));
					   
					   //loop diseases and dynamically load the post varriables and load the form records table
						foreach ($diseases->result() as $disease):	
											
							$male_u_f = $disease->id.'_u_f_m';
							$female_u_f = $disease->id.'_u_f_f';
							$male_o_f = $disease->id.'_o_f_m';
							$female_o_f = $disease->id.'_o_f_f';
							
							$under_five_male =  $health_events["".$male_u_f.""];
							$under_five_female =  $health_events["".$female_u_f.""];
							$over_five_male =  $health_events["".$male_o_f.""];
							$over_five_female =  $health_events["".$female_o_f.""];
							$total_under_five = ($under_five_male+$under_five_female);
							$total_over_five = ($over_five_male+$over_five_female);
							$total_disease = ($total_under_five+$total_over_five);
							
							$total_consultations = ($total_consultations+$total_disease);
							
							//capture the form data
								$formdata = array(
								   'form_id' => $form_id,
								   'epicalendar_id' => $reportingperiod->id,
								   'healthfacility_id' => $healthfacility_id,
								   'district_id' => $district_id,
								   'region_id' => $region_id,
								   'zone_id' => $zone_id,
								   'disease_id' => $disease->id,
								   'disease_name' => $disease->disease_code,
								   'male_under_five' => $under_five_male,
								   'female_under_five' => $under_five_female,
								   'male_over_five' => $over_five_male,
								   'female_over_five' => $over_five_female,
								   'total_under_five' => $total_under_five,
								   'total_over_five' => $total_over_five,
								   'total_disease' => $total_disease,
                                    'country_id' => $country_id,
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
											'district_id' => $district_id,
											'region_id' => $region_id,
											'zone_id' => $zone_id,
											'cases' => $total_disease,
											'deaths' => 0,
											'notes' => '',
											'verification_status' => 0,
											'include_bulletin' => 0,
                                            'country_id' => $country_id,
										);
										$this->db->insert('formalerts', $alertdata);
										
										
									}
							
						
						endforeach;//end disease loop
						
					   //update the records witht the total consultations						
					   $updatedata = array(
						   'total_consultations' => $total_consultations,
					   );
						
					   $this->db->where('id', $form_id);
					   $this->db->update('forms', $updatedata);
					
					//display notification to the user
					echo json_encode(
						array("message" => "The records have been successfully saved to the database.")
					);
					
				}//end HF reporting period check
				
				
			}//end country reporting period check
			
		}//end empty and format check
	}   
	
	
	function emergencyalerts()
	{
		/**
		$json = '{
			"zone_id": "1",
			"region_id": "1",
			"district_id": "1",
			"health_facility_id": "1",
			"reporting_year": "2017",
			"reporting_week": "27",
			"reporting_date": "2017-05-15",
			"reporter_id": "1",
			"disease": "14",
			"male_under_5": "10",
			"female_under_5": "5",
			"male_over_5": "3",
			"female_over_5": "6",
			"deaths": "15"
		}';
		
		**/
		
		//$json = $_POST['emergency_alert'];
		
		//$arr = json_decode($json,true);//decode object
		
		$arr = json_decode(file_get_contents("php://input"),true);
		
		//check if empty and if right format
		if(empty($arr)|| !is_array($arr))
		{
			echo json_encode(
				array("message" => "Please enter all the required information.")
			);	
		}
		else
		{
		
			$zone_id = $arr['zone_id'];
			$region_id = $arr['region_id'];
			$district_id = $arr['district_id'];
			$healthfacility_id = $arr['health_facility_id'];		
			$reporting_year = $arr['reporting_year'];		
			$week_no = $arr['reporting_week'];		
			$reporting_date = $arr['reporting_date'];		
			$disease_id = $arr['disease'];		
			$male_under_five = $arr['male_under_5'];		
			$female_under_five = $arr['female_under_5'];		
			$male_over_five = $arr['male_over_5'];		
			$female_over_five = $arr['female_over_5'];		
			$death = $arr['deaths'];
			$user_id = $arr['reporter_id'];
			
			$user = $this->usersmodel->get_by_id($user_id)->row();
			$country_id = $user->country_id;
			
			$reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$week_no,$country_id)->row();
			if (empty($reportingperiod)) {
				echo json_encode(
					array("message" => "The reporting period you entered has not been added to your country. Please contact the system administrator for assistance.")
					);
			} else {
			
				$data = array(
				   'healthfacility_id' => $healthfacility_id,
				   'district_id' => $district_id,
				   'region_id' => $region_id,
				   'zone_id' => $zone_id,
				   'country_id' => $country_id,
				   'week_no' => $week_no,
				   'reporting_year' => $reporting_year,
				   'epicalendar_id' => $reportingperiod->id,
				   'reporting_date' => date('Y-m-d'),
				   'user_id' => $user_id,
				   'disease_id' => $disease_id,
				   'male_under_five' => $male_under_five,
				   'female_under_five' => $female_under_five,
				   'male_over_five' => $male_over_five,
				   'female_over_five' => $female_over_five,
				   'other' => 0,
				   'death' => $death,
				   'action_taken' => '',
				   'verification_status' => 0,
			   );
			   $this->db->insert('emergencies', $data);
			   
			   //display notification to the user
				echo json_encode(
					array("message" => "The records have been successfully saved to the database.")
				);

		   
			}//end reporting period check
		   
		}//end empty and format check
		
	}
	
	  

}
