<?php

class Mobile extends CI_Controller
{
	 //input parameters ---------------------
	var $username;                          //your username
	var $password;                          //your password
	var $sender;                            //sender text
	var $message;                           //message text
	var $flash;                             //Is flash message (1 or 0)
	var $inputgsmnumbers = array();         //destination gsm numbers
	var $type;                              //msg type ("bookmark" - for wap push, "longSMS" for text messages only)
	var $bookmark;                          //wap url (example: www.google.com)
	var $sendDateTime; 						//this is the time the SMS is scheduled to go out
	//--------------------------------------

	var $host;
	var $path;
	var $XMLgsmnumbers;
	var $xmldata;
	var $request_data;
	var $response = '';
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('alertsmodel');
    }
    
    public function index()
    {
        $data = array();
        
        $this->load->view('mobile/index', $data);
    }
    
    public function home()
    {
        $data = array();
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }      
        
        $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
		
		if(empty($healthfacility_id))
		{
			redirect('login','refresh');
		}
        
                
        $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        
        $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        
        $region = $this->regionsmodel->get_by_id($district->region_id)->row();
        
        $data['district'] = $district;
        
        $data['healthfacility_id'] = $healthfacility_id;
        $data['region']            = $this->regionsmodel->get_by_id($region->id)->row();
        
        $data['districts'] = $this->districtsmodel->get_by_region($region->id);
        
        $data['healthfacility'] = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        
        $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        
        $this->load->view('mobile/home', $data);
    }
    
    function add_validate()
    {
        
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        
        $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
        
        $reporting_year  = $this->input->post('reporting_year');
        $week_no         = $this->input->post('week_no');
        $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
        
        $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
        $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
        
        $user_id = $this->erkanaauth->getField('id');
        
        $reportingperiod_id = $reportingperiod->id;
		
		$dateposted = $this->input->post('reporting_date');
		$datetime = $this->input->post('datetime');
		if(empty($dateposted))
		{
			$date_entered = date('Y-m-d');
		}
		else
		{
			$date_entered = $dateposted;
		}
		
		if(empty($datetime))
		{
			$datetime_entered = date("Y-m-d H:i:s");
		}
		else
		{
			$datetime_entered = $dateposted;
		}
        
        $data = array(
            'week_no' => $this->input->post('week_no'),
            'reporting_year' => $this->input->post('reporting_year'),
            'reporting_date' => date('Y-m-d'),
            'epdcalendar_id' => $reportingperiod->id,
            'user_id' => $user_id,
            'healthfacility_id' => $healthfacility_id,
            'contact_number' => $healthfacility->contact_number,
            'health_facility_code' => $healthfacility->hf_code,
            'supporting_ngo' => $healthfacility->organization,
            'region_id' => $region->id,
            'sariufivemale' => $this->input->post('sariufivemale'),
            'sariufivefemale' => $this->input->post('sariufivefemale'),
            'sariofivemale' => $this->input->post('sariofivemale'),
            'sariofivefemale' => $this->input->post('sariofivefemale'),
            'iliufivemale' => $this->input->post('iliufivemale'),
            'iliufivefemale' => $this->input->post('iliufivefemale'),
            'iliofivemale' => $this->input->post('iliofivemale'),
            'iliofivefemale' => $this->input->post('iliofivefemale'),
            'awdufivemale' => '',
            'awdufivefemale' => '',
            'awdofivemale' => '',
            'awdofivefemale' => '',
            'bdufivemale' => '',
            'bdufivefemale' => '',
            'bdofivemale' => '',
            'bdofivefemale' => '',
            'oadufivemale' => '',
            'oadufivefemale' => '',
            'oadofivemale' => '',
            'oadofivefemale' => '',
            'diphmale' => '',
            'diphfemale' => '',
            'wcmale' => '',
            'wcfemale' => '',
            'measmale' => '',
            'measfemale' => '',
            'nntmale' => '',
            'nntfemale' => '',
            'afpmale' => '',
            'afpfemale' => '',
            'ajsmale' => '',
            'ajsfemale' => '',
            'vhfmale' => '',
            'vhffemale' => '',
            'malufivemale' => '',
            'malufivefemale' => '',
            'malofivemale' => '',
            'malofivefemale' => '',
            'suspectedmenegitismale' => '',
            'suspectedmenegitisfemale' => '',
            'undisonedesc' => '',
            'undismale' => '',
            'undisfemale' => '',
            'undissecdesc' => '',
            'undismaletwo' => '',
            'undisfemaletwo' => '',
            'ocmale' => '',
            'ocfemale' => '',
            'total_consultations' => '',
            'sre' => '',
            'pf' => '',
            'pv' => '',
            'pmix' => '',
            'totalnegative' => '',
            'total_positive' => '',
            'approved_hf' => 0,
            'approved_regional' => 0,
            'approved_zone' => 0,
            'draft' => 1,
            'alert_sent' => 0,
            'entry_date' => $date_entered,
            'entry_time' => $datetime_entered,
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered,
			'diphofivemale' => '',
			'diphofivefemale' => '',
			'wcofivemale' => '',
			'wcofivefemale' => '',
			'measofivemale' => '',
			'measofivefemale' => '',
			'afpofivemale' => '',
			'afpofivefemale' => '',
			'suspectedmenegitisofivemale' => '',
			'suspectedmenegitisofivefemale' => '',
        );
        $this->db->insert('reportingforms', $data);
        
        $reportingform_id = $this->db->insert_id();
        
        $action = 'Added the report to the database.';
        
        //enter audit trail information
        $auditdata = array(
            'user_id' => $user_id,
            'reportingform_id' => $reportingform_id,
            'date_of_action' => $datetime_entered,
            'action' => $action
        );
        $this->db->insert('audittrail', $auditdata);
        
        
        $sariufivemale   = $this->input->post('sariufivemale');
        $sariufivefemale = $this->input->post('sariufivefemale');
        $sariofivemale   = $this->input->post('sariofivemale');
        $sariofivefemale = $this->input->post('sariofivefemale');
        $iliufivemale    = $this->input->post('iliufivemale');
        $iliufivefemale  = $this->input->post('iliufivefemale');
        $iliofivemale    = $this->input->post('iliofivemale');
        $iliofivefemale  = $this->input->post('iliofivefemale');
        
        $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
        
        $creditamount         = $systemcredit->amount;
        $dollarrate           = $systemcredit->dollar_rate;
        $amountkenyashillings = $creditamount * $dollarrate;
        
        
        $alertcases = '';
        $vpdcases   = '';
        $wbdcases   = '';
        $vbdcases   = '';
        
        $sari = $sariufivemale + $sariufivefemale + $sariofivemale + $sariofivefemale;
        if ($sari > 0) {
            $alertcases .= 'SARI/' . $sari . ',';
            
            $vpdcases .= 'SARI/' . $sari . ',';
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'SARI',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $sari,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $ili        = $iliufivemale + $iliufivefemale + $iliofivemale + $iliofivefemale;
        $ilireports = $this->reportingformsmodel->get_list_by_hf($healthfacility_id);
        $totili     = 0;
        
        foreach ($ilireports as $ilikey => $ilireport) {
            $totili = $totili + $ilireport['oadufivemale'] + $ilireport['oadufivefemale'] + $ilireport['oadofivemale'] + $ilireport['oadofivefemale'];
        }
        
        $iliwk3 = $ili;
        
        $iliavg = ($totili / 3);
        
        $ilicondition = ($iliavg * 2);
        
        if ($ili > $ilicondition) {
            /*
            avg = (wk1 + wk2 +wk3)/3
            
            if($mal > 2(avg))
            */
            $alertcases .= 'ILI/' . $ili . ',';
            $vpdcases .= 'ILI/' . $ili . ',';
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'ILI',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $ili,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        
        if (!empty($alertcases)) {
            $thehost    = 'smsplus1.routesms.com';
            $theport    = '8080';
            $uname      = 'smartads';
            $pword      = 'sma56rtw';
            $themsgtype = 0;
            $thedlr     = 0;
            $sender     = 'eDEWS';
            $total_sms  = 0;
            
            if (!empty($vpdcases)) {
                
                //zone numbers
                $vpdzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 1);
                //region numbers
                $vpdregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 1);
                
                $totvpdzonenumbers   = count($vpdzonenumbers);
                $totvpdregionnumbers = count($vpdregionnumbers);
                
                $total_sms = $total_sms + $totvpdzonenumbers + $totvpdregionnumbers;
                
                $vpdzonenumberstosend   = '';
                $vpdregionnumberstosend = '';
                
                //populate the numberstosend varriable with the numbers
                if (!empty($vpdzonenumbers)) {
                    foreach ($vpdzonenumbers as $vzkey => $vpdzonenumber) {
                        $vpdzonenumberstosend .= $vpdzonenumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $vpdmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $vpdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender         = str_replace("+", "%2b", $sender);
                    $vpdmessagetext = str_replace("+", "%2b", $vpdmessagetext);
                    
                    //send the SMS to the number
                    $resp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vpdmessagetext,$vpdzonenumberstosend,$themsgtype,$thedlr);
                }
                
                if (!empty($vpdregionnumbers)) {
                    foreach ($vpdregionnumbers as $vrkey => $vpdregionnumber) {
                        $vpdregionnumberstosend .= $vpdregionnumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $vpdregmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $vpdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender            = str_replace("+", "%2b", $sender);
                    $vpdregmessagetext = str_replace("+", "%2b", $vpdregmessagetext);
                    
                    //send the SMS to the number
                    $regresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vpdregmessagetext,$vpdregionnumberstosend,$themsgtype,$thedlr);
                }
            }
            
            if (!empty($wbdcases)) {
                //zone numbers
                $wbdzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 2);
                //region numbers
                $wbdregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 2);
                
                $totwbdzonenumbers   = count($wbdzonenumbers);
                $totwbdregionnumbers = count($wbdregionnumbers);
                
                $total_sms = $total_sms + $totwbdzonenumbers + $totwbdregionnumbers;
                
                $wbdzonenumberstosend   = '';
                $wbdregionnumberstosend = '';
                
                //populate the numberstosend varriable with the numbers
                if (!empty($wbdzonenumberstosend)) {
                    foreach ($wbdzonenumbers as $bzkey => $wbdzonenumber) {
                        $wbdzonenumberstosend .= $wbdzonenumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $wbdzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $wbdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender          = str_replace("+", "%2b", $sender);
                    $wbdzmessagetext = str_replace("+", "%2b", $wbdzmessagetext);
                    
                    //send the SMS to the number
                    $wbdzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdzmessagetext,$wbdzonenumberstosend,$themsgtype,$thedlr);
                }
                
                if (!empty($wbdregionnumbers)) {
                    foreach ($wbdregionnumbers as $wrkey => $wbdregionnumber) {
                        $wbdregionnumberstosend .= $wbdregionnumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $wbdregmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $wbdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender            = str_replace("+", "%2b", $sender);
                    $wbdregmessagetext = str_replace("+", "%2b", $wbdregmessagetext);
                    
                    //send the SMS to the number
                    $wbdregresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdregmessagetext,$wbdregionnumberstosend,$themsgtype,$thedlr);
                }
            }
            
            //zone numbers
            $allzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 4);
            //region numbers
            $allregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 4);
            
            $totallzonenumbers   = count($allzonenumbers);
            $totallregionnumbers = count($allregionnumbers);
            
            $total_sms = $total_sms + $totallzonenumbers + $totallregionnumbers;
            
            $numberstosendzone   = '';
            $numberstosendregion = '';
            
            if (!empty($allzonenumbers)) {
                foreach ($allzonenumbers as $allzkey => $allzonenumber) {
                    $numberstosendzone .= $allzonenumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allzmessagetext = str_replace("+", "%2b", $allzmessagetext);
                
                //send the SMS to the number
                $allzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allzmessagetext,$numberstosendzone,$themsgtype,$thedlr);	
            }
            
            
            if (!empty($allregionnumbers)) {
                foreach ($allregionnumbers as $allrkey => $allregionnumber) {
                    $numberstosendregion .= $allregionnumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allrmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allrmessagetext = str_replace("+", "%2b", $allrmessagetext);
                
                //send the SMS to the number
                $allrresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allrmessagetext,$numberstosendregion,$themsgtype,$thedlr);	
            }
			
			
			$nationalnumbers   = $this->mobilenumbersmodel->get_by_all_sector(0,0,0,4);
					$totalnationalnumbers   = count($nationalnumbers);
					
					                   
                    $total_sms = $total_sms + $totalnationalnumbers;
                    
                    $numberstosendnational = '';
					$gsm = array();
                    
                    if (!empty($nationalnumbers)) {
                        foreach ($nationalnumbers as $allnatkey => $nationalnumber) {
							
							$thenumber = $nationalnumber['phone_number'];
							$countrycode = substr($thenumber, 0, 3);
							if($countrycode==254)
							{
								$gsm[] = $nationalnumber['phone_number'];
							}
							else
							{
                            	$numberstosendnational .= $nationalnumber['phone_number'] . urlencode(',');
							}
                        }
                        
                        //send SMS
                        $mymessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
							                        
                        // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
						$this_msg = $mymessagetext;
                        $sender          = str_replace("+", "%2b", $sender);
                        $mymessagetext = str_replace("+", "%2b", $mymessagetext);
                        
						if(!empty($gsm))
						{
							$username = 'adverts';
							$password = 'sadvert009';
							$sender 		= 'eDEWS';
							$isflash 		= 0;      	//Is flash message (1 or 0)
							$type			= 'longSMS';//msg type ("bookmark" - for wap push, "longSMS" for text messages only)
							$bookmark 		= '';
							$response = $this->SendSMS($username,$password,$sender,$mymessagetext,$isflash, $gsm, $type, $bookmark);
						}
                        //send the SMS to the number
						
						if(!empty($numberstosendnational))
						{
                        	$allnatresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$mymessagetext,$numberstosendnational,$themsgtype,$thedlr);	
						}
                    }
                    
            
            $sms_rate  = $systemcredit->sms_rate;
            $smscost   = $total_sms * $sms_rate;
            $newamount = ($creditamount - $smscost);
			
            
            $updatecredit = array(
            'amount' => $newamount,
            );
			
			$this->systemcreditmodel->update(1, $updatecredit);
            
			$smsdata = array('text' => $this_msg,
									'number_sent' => $total_sms,
									'amount_spent' => $smscost,
									'date_sent' => $date_entered,
									'date_time_sent' => $datetime_entered
								);
								
			$this->smsreportsmodel->save($smsdata);
            
           
            
        }
        
        $this->secondstep($reportingform_id);
    }
    
    public function secondstep($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        $data = array();
       
		$row = $this->db->get_where('reportingforms', array('id' => $id))->row();
        $data = array(
            'row' => $row
        );
        
        $this->load->view('mobile/secondsrep', $data);
        
        
    }
    
    function addsecond()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        
        $id      = $this->input->post('reportingform_id');
        $user_id = $this->erkanaauth->getField('id');
        
        $reportingform_id = $this->input->post('reportingform_id');
		
		        
        $reportingform = $this->reportingformsmodel->get_by_id($reportingform_id)->row();
        
        $healthfacility_id = $reportingform->healthfacility_id;
		        
        $reportingperiod = $this->epdcalendarmodel->get_by_id($reportingform->epdcalendar_id)->row();
        
        $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
        $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
        
        $user_id = $this->erkanaauth->getField('id');
        
        $reportingperiod_id = $reportingform->epdcalendar_id;
		
		$dateposted = $this->input->post('reporting_date');
		$datetime = $this->input->post('datetime');
		if(empty($dateposted))
		{
			$date_entered = date('Y-m-d');
		}
		else
		{
			$date_entered = $dateposted;
		}
		
		if(empty($datetime))
		{
			$datetime_entered = date("Y-m-d H:i:s");
		}
		else
		{
			$datetime_entered = $dateposted;
		}
        
        $data = array(
            'awdufivemale' => $this->input->post('awdufivemale'),
            'awdufivefemale' => $this->input->post('awdufivefemale'),
            'awdofivemale' => $this->input->post('awdofivemale'),
            'awdofivefemale' => $this->input->post('awdofivefemale'),
            'bdufivemale' => $this->input->post('bdufivemale'),
            'bdufivefemale' => $this->input->post('bdufivefemale'),
            'bdofivemale' => $this->input->post('bdofivemale'),
            'bdofivefemale' => $this->input->post('bdofivefemale'),
            'oadufivemale' => $this->input->post('oadufivemale'),
            'oadufivefemale' => $this->input->post('oadufivefemale'),
            'oadofivemale' => $this->input->post('oadofivemale'),
            'oadofivefemale' => $this->input->post('oadofivefemale'),
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered
        );
        $this->db->where('id', $id);
        $this->db->update('reportingforms', $data);
        
        
        $action = 'Updated the report on the database.';
        
        //enter audit trail information
        $auditdata = array(
            'user_id' => $user_id,
            'reportingform_id' => $id,
            'date_of_action' => $datetime_entered,
            'action' => $action
        );
        $this->db->insert('audittrail', $auditdata);
        
        $awdufivemale   = $this->input->post('awdufivemale');
        $awdufivefemale = $this->input->post('awdufivefemale');
        $awdofivemale   = $this->input->post('awdofivemale');
        $awdofivefemale = $this->input->post('awdofivefemale');
        $bdufivemale    = $this->input->post('bdufivemale');
        $bdufivefemale  = $this->input->post('bdufivefemale');
        $bdofivemale    = $this->input->post('bdofivemale');
        $bdofivefemale  = $this->input->post('bdofivefemale');
        $oadufivemale   = $this->input->post('oadufivemale');
        $oadufivefemale = $this->input->post('oadufivefemale');
        $oadofivemale   = $this->input->post('oadofivemale');
        $oadofivefemale = $this->input->post('oadofivefemale');
        
        $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
        
        $creditamount         = $systemcredit->amount;
        $dollarrate           = $systemcredit->dollar_rate;
        $amountkenyashillings = $creditamount * $dollarrate;
        
        
        $alertcases = '';
        $vpdcases   = '';
        $wbdcases   = '';
        $vbdcases   = '';
        
        $awd = $awdufivemale + $awdufivefemale + $awdofivemale + $awdofivefemale;
        if ($awd > 0) {
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'AWD');
            $alertcases .= 'AWD/' . $awd . ',';
            $wbdcases .= 'AWD/' . $awd . ',';
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'AWD',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $awd,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $bd = $bdufivemale + $bdufivefemale + $bdofivemale + $bdofivefemale;
        if ($bd > 4) {
            $alertcases .= 'BD/' . $bd . ',';
            $wbdcases .= 'BD/' . $bd . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'BD');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'BD',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $bd,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        //
        $oad    = $oadufivemale + $oadufivefemale + $oadofivemale + $oadofivefemale;
        $hfrpts = $this->reportingformsmodel->get_list_by_hf($healthfacility_id);
        $totoad = 0;
        
        foreach ($hfrpts as $hkey => $hfrpt) {
            $totoad = $totoad + $hfrpt['oadufivemale'] + $hfrpt['oadufivefemale'] + $hfrpt['oadofivemale'] + $hfrpt['oadofivefemale'];
        }
        
        $oadwk3 = $oad;
        
        $oadavg = ($totoad / 3);
        
        $oadcondition = ($oadavg * 2);
        
        if ($oad > $oadcondition) {
            /*
            avg = (wk1 + wk2 +wk3)/3
            
            if($mal > 2(avg))
            */
            $alertcases .= 'OAD/' . $oad . ',';
            $wbdcases .= 'OAD/' . $oad . ',';
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'OAD');
            $alertdata   = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'OAD',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $oad,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        if (!empty($alertcases)) {
            $thehost    = 'smsplus1.routesms.com';
            $theport    = '8080';
            $uname      = 'smartads';
            $pword      = 'sma56rtw';
            $themsgtype = 0;
            $thedlr     = 0;
            $sender     = 'eDEWS';
            $total_sms  = 0;
            
            if (!empty($wbdcases)) {
                //zone numbers
                $wbdzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 2);
                //region numbers
                $wbdregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 2);
                
                $totwbdzonenumbers   = count($wbdzonenumbers);
                $totwbdregionnumbers = count($wbdregionnumbers);
                
                $total_sms = $total_sms + $totwbdzonenumbers + $totwbdregionnumbers;
                
                $wbdzonenumberstosend   = '';
                $wbdregionnumberstosend = '';
                
                //populate the numberstosend varriable with the numbers
                if (!empty($wbdzonenumberstosend)) {
                    foreach ($wbdzonenumbers as $bzkey => $wbdzonenumber) {
                        $wbdzonenumberstosend .= $wbdzonenumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $wbdzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $wbdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender          = str_replace("+", "%2b", $sender);
                    $wbdzmessagetext = str_replace("+", "%2b", $wbdzmessagetext);
                    
                    //send the SMS to the number
                    $wbdzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdzmessagetext,$wbdzonenumberstosend,$themsgtype,$thedlr);
                }
                
                if (!empty($wbdregionnumbers)) {
                    foreach ($wbdregionnumbers as $wrkey => $wbdregionnumber) {
                        $wbdregionnumberstosend .= $wbdregionnumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $wbdregmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $wbdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender            = str_replace("+", "%2b", $sender);
                    $wbdregmessagetext = str_replace("+", "%2b", $wbdregmessagetext);
                    
                    //send the SMS to the number
                    $wbdregresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdregmessagetext,$wbdregionnumberstosend,$themsgtype,$thedlr);
                }
            }
            
            //zone numbers
            $allzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 4);
            //region numbers
            $allregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 4);
            
            $totallzonenumbers   = count($allzonenumbers);
            $totallregionnumbers = count($allregionnumbers);
            
            $total_sms = $total_sms + $totallzonenumbers + $totallregionnumbers;
            
            $numberstosendzone   = '';
            $numberstosendregion = '';
            
            if (!empty($allzonenumbers)) {
                foreach ($allzonenumbers as $allzkey => $allzonenumber) {
                    $numberstosendzone .= $allzonenumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allzmessagetext = str_replace("+", "%2b", $allzmessagetext);
                
                //send the SMS to the number
                $allzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allzmessagetext,$numberstosendzone,$themsgtype,$thedlr);	
            }
            
            
            if (!empty($allregionnumbers)) {
                foreach ($allregionnumbers as $allrkey => $allregionnumber) {
                    $numberstosendregion .= $allregionnumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allrmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allrmessagetext = str_replace("+", "%2b", $allrmessagetext);
                
                //send the SMS to the number
                $allrresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allrmessagetext,$numberstosendregion,$themsgtype,$thedlr);	
            }
			
			$nationalnumbers   = $this->mobilenumbersmodel->get_by_all_sector(0,0,0,4);
					$totalnationalnumbers   = count($nationalnumbers);
					
					                   
                    $total_sms = $total_sms + $totalnationalnumbers;
                    
                    $numberstosendnational = '';
					$gsm = array();
                    
                    if (!empty($nationalnumbers)) {
                        foreach ($nationalnumbers as $allnatkey => $nationalnumber) {
							
							$thenumber = $nationalnumber['phone_number'];
							$countrycode = substr($thenumber, 0, 3);
							if($countrycode==254)
							{
								$gsm[] = $nationalnumber['phone_number'];
							}
							else
							{
                            	$numberstosendnational .= $nationalnumber['phone_number'] . urlencode(',');
							}
                        }
                        
                        //send SMS
                        $mymessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
							                        
                        // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
						$this_msg = $mymessagetext;
                        $sender          = str_replace("+", "%2b", $sender);
                        $mymessagetext = str_replace("+", "%2b", $mymessagetext);
                        
						if(!empty($gsm))
						{
							$username = 'adverts';
							$password = 'sadvert009';
							$sender 		= 'eDEWS';
							$isflash 		= 0;      	//Is flash message (1 or 0)
							$type			= 'longSMS';//msg type ("bookmark" - for wap push, "longSMS" for text messages only)
							$bookmark 		= '';
							$response = $this->SendSMS($username,$password,$sender,$mymessagetext,$isflash, $gsm, $type, $bookmark);
						}
                        //send the SMS to the number
						
						if(!empty($numberstosendnational))
						{
                        	$allnatresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$mymessagetext,$numberstosendnational,$themsgtype,$thedlr);	
						}
                    }
            
            $sms_rate  = $systemcredit->sms_rate;
            $smscost   = $total_sms * $sms_rate;
            $newamount = ($creditamount - $smscost);
			
             $updatecredit = array(
                    'amount' => $newamount,
                    );
                    //$this->db->where('id', 1);
                    //$this->db->update('systemcredit', $updatecredit);
					$this->systemcreditmodel->update(1, $updatecredit);
					
					$smsdata = array(
									'text' => $this_msg,
									'number_sent' => $total_sms,
									'amount_spent' => $smscost,
									'date_sent' => $date_entered,
									'date_time_sent' => $datetime_entered
								);
					$this->smsreportsmodel->save($smsdata);
            
        }
        
        $this->thirdstep($id);
    }
    
    function thirdstep($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        $data = array();
        
        $row  = $this->db->get_where('reportingforms', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        
        $this->load->view('mobile/thirdstep', $data);
    }
    
    function addthird()
    {
        
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        
        $id      = $this->input->post('reportingform_id');
        $user_id = $this->erkanaauth->getField('id');
        
        $reportingform_id = $this->input->post('reportingform_id');
        
        $reportingform = $this->reportingformsmodel->get_by_id($reportingform_id)->row();
        
        $healthfacility_id = $reportingform->healthfacility_id;
        
        $reportingperiod = $this->epdcalendarmodel->get_by_id($reportingform->epdcalendar_id)->row();
        
        $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
        $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
        
        $reportingperiod_id = $reportingform->epdcalendar_id;
		
		$dateposted = $this->input->post('reporting_date');
		$datetime = $this->input->post('datetime');
		if(empty($dateposted))
		{
			$date_entered = date('Y-m-d');
		}
		else
		{
			$date_entered = $dateposted;
		}
		
		if(empty($datetime))
		{
			$datetime_entered = date("Y-m-d H:i:s");
		}
		else
		{
			$datetime_entered = $dateposted;
		}
        
        $data = array(
            'diphmale' => $this->input->post('diphmale'),
            'diphfemale' => $this->input->post('diphfemale'),
            'wcmale' => $this->input->post('wcmale'),
            'wcfemale' => $this->input->post('wcfemale'),
            'measmale' => $this->input->post('measmale'),
            'measfemale' => $this->input->post('measfemale'),
            'nntmale' => $this->input->post('nntmale'),
            'nntfemale' => $this->input->post('nntfemale'),
            'afpmale' => $this->input->post('afpmale'),
            'afpfemale' => $this->input->post('afpfemale'),
			'diphofivemale' => $this->input->post('diphofivemale'),
		    'diphofivefemale' => $this->input->post('diphofivefemale'),
			'wcofivemale' => $this->input->post('wcofivemale'),
			'wcofivefemale' => $this->input->post('wcofivefemale'),
			'measofivemale' => $this->input->post('measofivemale'),
			'measofivefemale' => $this->input->post('measofivefemale'),
			'afpofivemale' => $this->input->post('afpofivemale'),
			'afpofivefemale' => $this->input->post('afpofivefemale'),
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered
        );
        $this->db->where('id', $id);
        $this->db->update('reportingforms', $data);
        
        $action = 'Updated the report on the database.';
        
        //enter audit trail information
        $auditdata = array(
            'user_id' => $user_id,
            'reportingform_id' => $id,
            'date_of_action' => $datetime_entered,
            'action' => $action
        );
        $this->db->insert('audittrail', $auditdata);
        
        $diphmale   = $this->input->post('diphmale');
        $diphfemale = $this->input->post('diphfemale');
        $wcmale     = $this->input->post('wcmale');
        $wcfemale   = $this->input->post('wcfemale');
        $measmale   = $this->input->post('measmale');
        $measfemale = $this->input->post('measfemale');
        $nntmale    = $this->input->post('nntmale');
        $nntfemale  = $this->input->post('nntfemale');
        $afpmale    = $this->input->post('afpmale');
        $afpfemale  = $this->input->post('afpfemale');
		$diphofivemale            = $this->input->post('diphofivemale');
        $diphofivefemale          = $this->input->post('diphofivefemale');
		$wcofivemale              = $this->input->post('wcofivemale');
        $wcofivefemale            = $this->input->post('wcofivefemale');
		$measofviemale            = $this->input->post('measofviemale');
        $measofivefemale          = $this->input->post('measofivefemale');
		$afpofivemale             = $this->input->post('afpofivemale');
        $afpofivefemale           = $this->input->post('afpofivefemale');
        
        $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
        
        $creditamount         = $systemcredit->amount;
        $dollarrate           = $systemcredit->dollar_rate;
        $amountkenyashillings = $creditamount * $dollarrate;
        
        
        $alertcases = '';
        $vpdcases   = '';
        $wbdcases   = '';
        $vbdcases   = '';
        
        $diph = $diphmale + $diphfemale + $diphofivefemale + $diphofivemale;
        if ($diph > 0) {
            $alertcases .= 'Diph/' . $diph . ',';
            $vpdcases .= 'Diph/' . $diph . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'Diph');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'Diph',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $diph,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $wc = $wcmale + $wcfemale + $wcofivemale + $wcofivefemale;
        if ($wc > 4) {
            $alertcases .= 'WC/' . $wc . ',';
            $vpdcases .= 'WC/' . $wc . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'WC');
            $alertdata   = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'WC',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $wc,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $meas = $measmale + $measfemale + $measofviemale + $measofivefemale;
        if ($meas > 0) {
            $alertcases .= 'Meas/' . $meas . ',';
            $vpdcases .= 'Meas/' . $meas . ',';
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'Meas');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'Meas',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $meas,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $nnt = $nntmale + $nntfemale;
        if ($nnt > 0) {
            $alertcases .= 'NNT/' . $nnt . ',';
            $vpdcases .= 'NNT/' . $nnt . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'NNT');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'NNT',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $nnt,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $afp = $afpmale + $afpfemale + $afpofivemale + $afpofivefemale;
        if ($afp > 0) {
            $alertcases .= 'AFP/' . $afp . ',';
            $vpdcases .= 'AFP/' . $afp . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'AFP');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'AFP',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $afp,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        if (!empty($alertcases)) {
            $thehost    = 'smsplus1.routesms.com';
            $theport    = '8080';
            $uname      = 'smartads';
            $pword      = 'sma56rtw';
            $themsgtype = 0;
            $thedlr     = 0;
            $sender     = 'eDEWS';
            $total_sms  = 0;
            
            if (!empty($vpdcases)) {
                
                //zone numbers
                $vpdzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 1);
                //region numbers
                $vpdregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 1);
                
                $totvpdzonenumbers   = count($vpdzonenumbers);
                $totvpdregionnumbers = count($vpdregionnumbers);
                
                $total_sms = $total_sms + $totvpdzonenumbers + $totvpdregionnumbers;
                
                $vpdzonenumberstosend   = '';
                $vpdregionnumberstosend = '';
                
                //populate the numberstosend varriable with the numbers
                if (!empty($vpdzonenumbers)) {
                    foreach ($vpdzonenumbers as $vzkey => $vpdzonenumber) {
                        $vpdzonenumberstosend .= $vpdzonenumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $vpdmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $vpdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender         = str_replace("+", "%2b", $sender);
                    $vpdmessagetext = str_replace("+", "%2b", $vpdmessagetext);
                    
                    //send the SMS to the number
                    $resp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vpdmessagetext,$vpdzonenumberstosend,$themsgtype,$thedlr);
                }
                
                if (!empty($vpdregionnumbers)) {
                    foreach ($vpdregionnumbers as $vrkey => $vpdregionnumber) {
                        $vpdregionnumberstosend .= $vpdregionnumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $vpdregmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $vpdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender            = str_replace("+", "%2b", $sender);
                    $vpdregmessagetext = str_replace("+", "%2b", $vpdregmessagetext);
                    
                    //send the SMS to the number
                    $regresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vpdregmessagetext,$vpdregionnumberstosend,$themsgtype,$thedlr);
                }
            }
            
            //zone numbers
            $allzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 4);
            //region numbers
            $allregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 4);
            
            $totallzonenumbers   = count($allzonenumbers);
            $totallregionnumbers = count($allregionnumbers);
            
            $total_sms = $total_sms + $totallzonenumbers + $totallregionnumbers;
            
            $numberstosendzone   = '';
            $numberstosendregion = '';
            
            if (!empty($allzonenumbers)) {
                foreach ($allzonenumbers as $allzkey => $allzonenumber) {
                    $numberstosendzone .= $allzonenumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allzmessagetext = str_replace("+", "%2b", $allzmessagetext);
                
                //send the SMS to the number
                $allzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allzmessagetext,$numberstosendzone,$themsgtype,$thedlr);	
            }
            
            
            if (!empty($allregionnumbers)) {
                foreach ($allregionnumbers as $allrkey => $allregionnumber) {
                    $numberstosendregion .= $allregionnumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allrmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allrmessagetext = str_replace("+", "%2b", $allrmessagetext);
                
                //send the SMS to the number
                $allrresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allrmessagetext,$numberstosendregion,$themsgtype,$thedlr);	
            }
            
			$nationalnumbers   = $this->mobilenumbersmodel->get_by_all_sector(0,0,0,4);
					$totalnationalnumbers   = count($nationalnumbers);
					
					                   
                    $total_sms = $total_sms + $totalnationalnumbers;
                    
                    $numberstosendnational = '';
					$gsm = array();
                    
                    if (!empty($nationalnumbers)) {
                        foreach ($nationalnumbers as $allnatkey => $nationalnumber) {
							
							$thenumber = $nationalnumber['phone_number'];
							$countrycode = substr($thenumber, 0, 3);
							if($countrycode==254)
							{
								$gsm[] = $nationalnumber['phone_number'];
							}
							else
							{
                            	$numberstosendnational .= $nationalnumber['phone_number'] . urlencode(',');
							}
                        }
                        
                        //send SMS
                        $mymessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
							                        
                        // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
						$this_msg = $mymessagetext;
                        $sender          = str_replace("+", "%2b", $sender);
                        $mymessagetext = str_replace("+", "%2b", $mymessagetext);
                        
						if(!empty($gsm))
						{
							$username = 'adverts';
							$password = 'sadvert009';
							$sender 		= 'eDEWS';
							$isflash 		= 0;      	//Is flash message (1 or 0)
							$type			= 'longSMS';//msg type ("bookmark" - for wap push, "longSMS" for text messages only)
							$bookmark 		= '';
							$response = $this->SendSMS($username,$password,$sender,$mymessagetext,$isflash, $gsm, $type, $bookmark);
						}
                        //send the SMS to the number
						
						if(!empty($numberstosendnational))
						{
                        	$allnatresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$mymessagetext,$numberstosendnational,$themsgtype,$thedlr);	
						}
                    }
            
            $sms_rate  = $systemcredit->sms_rate;
            $smscost   = $total_sms * $sms_rate;
            $newamount = ($creditamount - $smscost);
           
		   //update credit information 
            $updatecredit = array(
            'amount' => $newamount,
            );
            
			
			$updatecredit = array(
                    'amount' => $newamount,
                    );
                    //$this->db->where('id', 1);
                    //$this->db->update('systemcredit', $updatecredit);
					$this->systemcreditmodel->update(1, $updatecredit);
					
					$smsdata = array(
									'text' => $this_msg,
									'number_sent' => $total_sms,
									'amount_spent' => $smscost,
									'date_sent' => $date_entered,
									'date_time_sent' => $datetime_entered
								);
					$this->smsreportsmodel->save($smsdata);
            
        
        }
        
        $this->fourthstep($id);
    }
    
    function fourthstep($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        $data = array();
        
        $row  = $this->db->get_where('reportingforms', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        
        $this->load->view('mobile/fourthstep', $data);
        
    }
    
    function addfourth()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        
        $id      = $this->input->post('reportingform_id');
        $user_id = $this->erkanaauth->getField('id');
        
        $reportingform_id = $this->input->post('reportingform_id');
        
        $reportingform = $this->reportingformsmodel->get_by_id($reportingform_id)->row();
        
        $healthfacility_id = $reportingform->healthfacility_id;
        
        $reportingperiod = $this->epdcalendarmodel->get_by_id($reportingform->epdcalendar_id)->row();
        
        $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
        $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
        
        $reportingperiod_id = $reportingperiod->id;
        
		$dateposted = $this->input->post('reporting_date');
		$datetime = $this->input->post('datetime');
		if(empty($dateposted))
		{
			$date_entered = date('Y-m-d');
		}
		else
		{
			$date_entered = $dateposted;
		}
		
		if(empty($datetime))
		{
			$datetime_entered = date("Y-m-d H:i:s");
		}
		else
		{
			$datetime_entered = $dateposted;
		}
		
        $data = array(
            'ajsmale' => $this->input->post('ajsmale'),
            'ajsfemale' => $this->input->post('ajsfemale'),
            'vhfmale' => $this->input->post('vhfmale'),
            'vhffemale' => $this->input->post('vhffemale'),
            'malufivemale' => $this->input->post('malufivemale'),
            'malufivefemale' => $this->input->post('malufivefemale'),
            'malofivemale' => $this->input->post('malofivemale'),
            'malofivefemale' => $this->input->post('malofivefemale'),
            'suspectedmenegitismale' => $this->input->post('suspectedmenegitismale'),
            'suspectedmenegitisfemale' => $this->input->post('suspectedmenegitisfemale'),
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered,
			'suspectedmenegitisofivemale' => $this->input->post('suspectedmenegitisofivemale'),
			'suspectedmenegitisofivefemale' => $this->input->post('suspectedmenegitisofivefemale')
        );
        $this->db->where('id', $id);
        $this->db->update('reportingforms', $data);
        
        $action = 'Updated the report on the database.';
        
        //enter audit trail information
        $auditdata = array(
            'user_id' => $user_id,
            'reportingform_id' => $id,
            'date_of_action' => date("Y-m-d H:i:s"),
            'action' => $action
        );
        $this->db->insert('audittrail', $auditdata);
        
        
        $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
        
        $creditamount         = $systemcredit->amount;
        $dollarrate           = $systemcredit->dollar_rate;
        $amountkenyashillings = $creditamount * $dollarrate;
        
        
        $alertcases = '';
        $vpdcases   = '';
        $wbdcases   = '';
        $vbdcases   = '';
        
        $ajsmale                  = $this->input->post('ajsmale');
        $ajsfemale                = $this->input->post('ajsfemale');
        $vhfmale                  = $this->input->post('vhfmale');
        $vhffemale                = $this->input->post('vhffemale');
        $malufivemale             = $this->input->post('malufivemale');
        $malufivefemale           = $this->input->post('malufivefemale');
        $malofivemale             = $this->input->post('malofivemale');
        $malofivefemale           = $this->input->post('malofivefemale');
        $suspectedmenegitismale   = $this->input->post('suspectedmenegitismale');
        $suspectedmenegitisfemale = $this->input->post('suspectedmenegitisfemale');
		$suspectedmenegitisofivemale   = $this->input->post('suspectedmenegitisofivemale');
        $suspectedmenegitisofivefemale = $this->input->post('suspectedmenegitisofivefemale');
        
        $ajs = $ajsmale + $ajsfemale;
        if ($ajs > 4) {
            $alertcases .= 'AJS/' . $ajs . ',';
            $wbdcases .= 'AJS/' . $ajs . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'AJS');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'AJS',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $ajs,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $vhf = $vhfmale + $vhffemale;
        if ($vhf > 0) {
            $alertcases .= 'VHF/' . $vhf . ',';
            $vbdcases .= 'VHF/' . $vhf . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'VHF');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'VHF',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $vhf,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $mal       = $malufivemale + $malufivefemale + $malofivemale + $malofivefemale;
        $hfreports = $this->reportingformsmodel->get_list_by_hf($healthfacility_id);
        $totmal    = 0;
        
        foreach ($hfreports as $key => $hfreport) {
            $totmal = $totmal + $hfreport['malufivemale'] + $hfreport['malufivefemale'] + $hfreport['malofivemale'] + $hfreport['malofivefemale'];
        }
        
        $wk3 = $mal;
        
        $avg = ($totmal / 3);
        
        $malcondition = ($avg * 2);
        
        if ($mal > $malcondition) {
            /*
            avg = (wk1 + wk2 +wk3)/3
            
            if($mal > 2(avg))
            */
            $alertcases .= 'Mal/' . $mal . ',';
            $vbdcases .= 'Mal/' . $mal . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'Mal');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'Mal',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $mal,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        $men = $suspectedmenegitismale + $suspectedmenegitisfemale + $suspectedmenegitisofivemale + $suspectedmenegitisofivefemale;
        if ($men > 1) {
            $alertcases .= 'Men/' . $men . ',';
            
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'Men');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'Men',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $men,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        if (!empty($alertcases)) {
            $thehost    = 'smsplus1.routesms.com';
            $theport    = '8080';
            $uname      = 'smartads';
            $pword      = 'sma56rtw';
            $themsgtype = 0;
            $thedlr     = 0;
            $sender     = 'eDEWS';
            $total_sms  = 0;
            
            if (!empty($wbdcases)) {
                //zone numbers
                $wbdzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 2);
                //region numbers
                $wbdregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 2);
                
                $totwbdzonenumbers   = count($wbdzonenumbers);
                $totwbdregionnumbers = count($wbdregionnumbers);
                
                $total_sms = $total_sms + $totwbdzonenumbers + $totwbdregionnumbers;
                
                $wbdzonenumberstosend   = '';
                $wbdregionnumberstosend = '';
                
                //populate the numberstosend varriable with the numbers
                if (!empty($wbdzonenumberstosend)) {
                    foreach ($wbdzonenumbers as $bzkey => $wbdzonenumber) {
                        $wbdzonenumberstosend .= $wbdzonenumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $wbdzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $wbdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender          = str_replace("+", "%2b", $sender);
                    $wbdzmessagetext = str_replace("+", "%2b", $wbdzmessagetext);
                    
                    //send the SMS to the number
                    $wbdzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdzmessagetext,$wbdzonenumberstosend,$themsgtype,$thedlr);
                }
                
                if (!empty($wbdregionnumbers)) {
                    foreach ($wbdregionnumbers as $wrkey => $wbdregionnumber) {
                        $wbdregionnumberstosend .= $wbdregionnumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $wbdregmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $wbdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender            = str_replace("+", "%2b", $sender);
                    $wbdregmessagetext = str_replace("+", "%2b", $wbdregmessagetext);
                    
                    //send the SMS to the number
                    $wbdregresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdregmessagetext,$wbdregionnumberstosend,$themsgtype,$thedlr);
                }
            }
            
            if (!empty($vbdcases)) {
                //zone numbers
                $vbdzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 3);
                //region numbers
                $vbdregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 3);
                
                $totvbdzonenumbers   = count($vbdzonenumbers);
                $totvbdregionnumbers = count($vbdregionnumbers);
                
                $total_sms = $total_sms + $totvbdzonenumbers + $totvbdregionnumbers;
                
                $vbdzonenumberstosend   = '';
                $vbdregionnumberstosend = '';
                
                //populate the numberstosend varriable with the numbers
                if (!empty($vbdzonenumbers)) {
                    foreach ($vbdzonenumbers as $vzkey => $vbdzonenumber) {
                        $vbdzonenumberstosend .= $vbdzonenumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $vbdzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $vbdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender          = str_replace("+", "%2b", $sender);
                    $vbdzmessagetext = str_replace("+", "%2b", $vbdzmessagetext);
                    
                    //send the SMS to the number
                    $vbdzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vbdzmessagetext,$vbdzonenumberstosend,$themsgtype,$thedlr);
                }
                
                if (!empty($vbdregionnumbers)) {
                    foreach ($vbdregionnumbers as $vbdrkey => $vbdregionnumber) {
                        $vbdregionnumberstosend .= $vbdregionnumber['phone_number'] . urlencode(',');
                    }
                    
                    //send SMS
                    $vbdregmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $vbdcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                    
                    // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                    $sender            = str_replace("+", "%2b", $sender);
                    $vbdregmessagetext = str_replace("+", "%2b", $vbdregmessagetext);
                    
                    //send the SMS to the number
                    $wbdregresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vbdregmessagetext,$vbdregionnumberstosend,$themsgtype,$thedlr);
                }
            }
            
            //zone numbers
            $allzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 4);
            //region numbers
            $allregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 4);
            
            $totallzonenumbers   = count($allzonenumbers);
            $totallregionnumbers = count($allregionnumbers);
            
            $total_sms = $total_sms + $totallzonenumbers + $totallregionnumbers;
            
            $numberstosendzone   = '';
            $numberstosendregion = '';
            
            if (!empty($allzonenumbers)) {
                foreach ($allzonenumbers as $allzkey => $allzonenumber) {
                    $numberstosendzone .= $allzonenumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allzmessagetext = str_replace("+", "%2b", $allzmessagetext);
                
                //send the SMS to the number
                $allzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allzmessagetext,$numberstosendzone,$themsgtype,$thedlr);	
            }
            
            
            if (!empty($allregionnumbers)) {
                foreach ($allregionnumbers as $allrkey => $allregionnumber) {
                    $numberstosendregion .= $allregionnumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allrmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allrmessagetext = str_replace("+", "%2b", $allrmessagetext);
                
                //send the SMS to the number
                $allrresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allrmessagetext,$numberstosendregion,$themsgtype,$thedlr);	
            }
            
			$nationalnumbers   = $this->mobilenumbersmodel->get_by_all_sector(0,0,0,4);
					$totalnationalnumbers   = count($nationalnumbers);
					
					                   
                    $total_sms = $total_sms + $totalnationalnumbers;
                    
                    $numberstosendnational = '';
					$gsm = array();
                    
                    if (!empty($nationalnumbers)) {
                        foreach ($nationalnumbers as $allnatkey => $nationalnumber) {
							
							$thenumber = $nationalnumber['phone_number'];
							$countrycode = substr($thenumber, 0, 3);
							if($countrycode==254)
							{
								$gsm[] = $nationalnumber['phone_number'];
							}
							else
							{
                            	$numberstosendnational .= $nationalnumber['phone_number'] . urlencode(',');
							}
                        }
                        
                        //send SMS
                        $mymessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
							                        
                        // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
						$this_msg = $mymessagetext;
                        $sender          = str_replace("+", "%2b", $sender);
                        $mymessagetext = str_replace("+", "%2b", $mymessagetext);
                        
						if(!empty($gsm))
						{
							$username = 'adverts';
							$password = 'sadvert009';
							$sender 		= 'eDEWS';
							$isflash 		= 0;      	//Is flash message (1 or 0)
							$type			= 'longSMS';//msg type ("bookmark" - for wap push, "longSMS" for text messages only)
							$bookmark 		= '';
							$response = $this->SendSMS($username,$password,$sender,$mymessagetext,$isflash, $gsm, $type, $bookmark);
						}
                        //send the SMS to the number
						
						if(!empty($numberstosendnational))
						{
                        	$allnatresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$mymessagetext,$numberstosendnational,$themsgtype,$thedlr);	
						}
                    }
                    
					
            $sms_rate  = $systemcredit->sms_rate;
            $smscost   = $total_sms * $sms_rate;
            $newamount = ($creditamount - $smscost);
			
           $updatecredit = array(
                    'amount' => $newamount,
                    );
                    //$this->db->where('id', 1);
                    //$this->db->update('systemcredit', $updatecredit);
					$this->systemcreditmodel->update(1, $updatecredit);
					
					$smsdata = array(
									'text' => $this_msg,
									'number_sent' => $total_sms,
									'amount_spent' => $smscost,
									'date_sent' => $date_entered,
									'date_time_sent' => $datetime_entered
								);
					$this->smsreportsmodel->save($smsdata);
        }
        
        $this->fifthstep($id);
    }
    
    function fifthstep($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        $data = array();
        
        $row  = $this->db->get_where('reportingforms', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        
        $this->load->view('mobile/fifthstep', $data);
    }
    
    function addfifth()
    {
        $id      = $this->input->post('reportingform_id');
        $user_id = $this->erkanaauth->getField('id');
        
        $reportingform_id = $this->input->post('reportingform_id');
        
        $reportingform = $this->reportingformsmodel->get_by_id($reportingform_id)->row();
        
        $healthfacility_id = $reportingform->healthfacility_id;
        
        $reportingperiod = $this->epdcalendarmodel->get_by_id($reportingform->epdcalendar_id)->row();
        
        $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
        $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
        
        $reportingperiod_id = $reportingperiod->id;
        
		$dateposted = $this->input->post('reporting_date');
		$datetime = $this->input->post('datetime');
		if(empty($dateposted))
		{
			$date_entered = date('Y-m-d');
		}
		else
		{
			$date_entered = $dateposted;
		}
		
		if(empty($datetime))
		{
			$datetime_entered = date("Y-m-d H:i:s");
		}
		else
		{
			$datetime_entered = $dateposted;
		}
		
        $data = array(
            'undisonedesc' => $this->input->post('undisonedesc'),
            'undismale' => $this->input->post('undismale'),
            'undisfemale' => $this->input->post('undisfemale'),
            'undissecdesc' => $this->input->post('undissecdesc'),
            'undismaletwo' => $this->input->post('undismaletwo'),
            'undisfemaletwo' => $this->input->post('undisfemaletwo'),
            'ocmale' => $this->input->post('ocmale'),
            'ocfemale' => $this->input->post('ocfemale'),
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered
        );
        $this->db->where('id', $id);
        $this->db->update('reportingforms', $data);
        
        $action = 'Updated the report on the database.';
        
        //enter audit trail information
        $auditdata = array(
            'user_id' => $user_id,
            'reportingform_id' => $id,
            'date_of_action' => $datetime_entered,
            'action' => $action
        );
        $this->db->insert('audittrail', $auditdata);
        
        
        $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
        
        $creditamount         = $systemcredit->amount;
        $dollarrate           = $systemcredit->dollar_rate;
        $amountkenyashillings = $creditamount * $dollarrate;
        
        
        $alertcases = '';
        $vpdcases   = '';
        $wbdcases   = '';
        $vbdcases   = '';
        
        
        $undisonedesc   = $this->input->post('undisonedesc');
        $undismale      = $this->input->post('undismale');
        $undisfemale    = $this->input->post('undisfemale');
        $undissecdesc   = $this->input->post('undissecdesc');
        $undismaletwo   = $this->input->post('undismaletwo');
        $undisfemaletwo = $this->input->post('undisfemaletwo');
        $ocmale         = $this->input->post('ocmale');
        $ocfemale       = $this->input->post('ocfemale');
        
        $undis = $undismale + $undisfemale + $undismaletwo + $undisfemaletwo;
        if ($undis > 2) {
            $alertcases .= 'UnDis/' . $undis . '';
            $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'UnDis');
            
            $alertdata = array(
                'reportingform_id' => $reportingform_id,
                'reportingperiod_id' => $reportingperiod_id,
                'disease_name' => 'UnDis',
                'healthfacility_id' => $healthfacility_id,
                'district_id' => $district->id,
                'region_id' => $region->id,
                'zone_id' => $zone->id,
                'cases' => $undis,
                'deaths' => 0,
                'notes' => '',
                'verification_status' => 0,
                'include_bulletin' => 0
            );
            $this->db->insert('alerts', $alertdata);
        }
        
        
        if (!empty($alertcases)) {
            
            $thehost    = 'smsplus1.routesms.com';
            $theport    = '8080';
            $uname      = 'smartads';
            $pword      = 'sma56rtw';
            $themsgtype = 0;
            $thedlr     = 0;
            $sender     = 'eDEWS';
            $total_sms  = 0;
            
            //zone numbers
            $allzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 4);
            //region numbers
            $allregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 4);
            
            $totallzonenumbers   = count($allzonenumbers);
            $totallregionnumbers = count($allregionnumbers);
            
            $total_sms = $total_sms + $totallzonenumbers + $totallregionnumbers;
            
            $numberstosendzone   = '';
            $numberstosendregion = '';
            
            if (!empty($allzonenumbers)) {
                foreach ($allzonenumbers as $allzkey => $allzonenumber) {
                    $numberstosendzone .= $allzonenumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allzmessagetext = str_replace("+", "%2b", $allzmessagetext);
                
                //send the SMS to the number
                $allzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allzmessagetext,$numberstosendzone,$themsgtype,$thedlr);	
            }
            
            
            if (!empty($allregionnumbers)) {
                foreach ($allregionnumbers as $allrkey => $allregionnumber) {
                    $numberstosendregion .= $allregionnumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allrmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allrmessagetext = str_replace("+", "%2b", $allrmessagetext);
                
                //send the SMS to the number
                $allrresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allrmessagetext,$numberstosendregion,$themsgtype,$thedlr);	
            }
            
            $nationalnumbers   = $this->mobilenumbersmodel->get_by_all_sector(0,0,0,4);
					$totalnationalnumbers   = count($nationalnumbers);
					
					                   
                    $total_sms = $total_sms + $totalnationalnumbers;
                    
                    $numberstosendnational = '';
					$gsm = array();
                    
                    if (!empty($nationalnumbers)) {
                        foreach ($nationalnumbers as $allnatkey => $nationalnumber) {
							
							$thenumber = $nationalnumber['phone_number'];
							$countrycode = substr($thenumber, 0, 3);
							if($countrycode==254)
							{
								$gsm[] = $nationalnumber['phone_number'];
							}
							else
							{
                            	$numberstosendnational .= $nationalnumber['phone_number'] . urlencode(',');
							}
                        }
                        
                        //send SMS
                        $mymessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
							                        
                        // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
						$this_msg = $mymessagetext;
                        $sender          = str_replace("+", "%2b", $sender);
                        $mymessagetext = str_replace("+", "%2b", $mymessagetext);
                        
						if(!empty($gsm))
						{
							$username = 'adverts';
							$password = 'sadvert009';
							$sender 		= 'eDEWS';
							$isflash 		= 0;      	//Is flash message (1 or 0)
							$type			= 'longSMS';//msg type ("bookmark" - for wap push, "longSMS" for text messages only)
							$bookmark 		= '';
							$response = $this->SendSMS($username,$password,$sender,$mymessagetext,$isflash, $gsm, $type, $bookmark);
						}
                        //send the SMS to the number
						
						if(!empty($numberstosendnational))
						{
                        	$allnatresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$mymessagetext,$numberstosendnational,$themsgtype,$thedlr);	
						}
                    }
					
            $sms_rate  = $systemcredit->sms_rate;
            $smscost   = $total_sms * $sms_rate;
            $newamount = ($creditamount - $smscost);
          
            $updatecredit = array(
                    'amount' => $newamount,
                    );
                    //$this->db->where('id', 1);
                    //$this->db->update('systemcredit', $updatecredit);
					$this->systemcreditmodel->update(1, $updatecredit);
					
					$smsdata = array(
									'text' => $this_msg,
									'number_sent' => $total_sms,
									'amount_spent' => $smscost,
									'date_sent' => $date_entered,
									'date_time_sent' => $datetime_entered
								);
					$this->smsreportsmodel->save($smsdata);
            
          
        }
        
        $this->sixthstep($id);
    }
    
    function sixthstep($id)
    {
        
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        $data = array();
        
        $row  = $this->db->get_where('reportingforms', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        
        $this->load->view('mobile/sixthstep', $data);
    }
    
    function addsixth()
    {
        
        $id      = $this->input->post('reportingform_id');
        $user_id = $this->erkanaauth->getField('id');
        
        $reportingform_id = $this->input->post('reportingform_id');
        
        $reportingform = $this->reportingformsmodel->get_by_id($reportingform_id)->row();
        
        $healthfacility_id = $reportingform->healthfacility_id;
        
        $reportingperiod = $this->epdcalendarmodel->get_by_id($reportingform->epdcalendar_id)->row();
        
        $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
        $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
        
        $reportingperiod_id = $reportingperiod->id;
		
		$dateposted = $this->input->post('reporting_date');
		$datetime = $this->input->post('datetime');
		if(empty($dateposted))
		{
			$date_entered = date('Y-m-d');
		}
		else
		{
			$date_entered = $dateposted;
		}
		
		if(empty($datetime))
		{
			$datetime_entered = date("Y-m-d H:i:s");
		}
		else
		{
			$datetime_entered = $dateposted;
		}
        
        $data = array(
            'sre' => $this->input->post('sre'),
            'pf' => $this->input->post('pf'),
            'pv' => $this->input->post('pv'),
            'pmix' => $this->input->post('pmix'),
            'approved_hf' => 1,
            'draft' => 0,
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered
            
        );
        $this->db->where('id', $id);
        $this->db->update('reportingforms', $data);
        
        
        $row = $this->db->get_where('reportingforms', array(
            'id' => $id
        ))->row();
        
        $sariufivemale            = $row->sariufivemale;
        $sariufivefemale          = $row->sariufivefemale;
        $sariofivemale            = $row->sariofivemale;
        $sariofivefemale          = $row->sariofivefemale;
        $iliufivemale             = $row->iliufivemale;
        $iliufivefemale           = $row->iliufivefemale;
        $iliofivemale             = $row->iliofivemale;
        $iliofivefemale           = $row->iliofivefemale;
        $awdufivemale             = $row->awdufivemale;
        $awdufivefemale           = $row->awdufivefemale;
        $awdofivemale             = $row->awdofivemale;
        $awdofivefemale           = $row->awdofivefemale;
        $bdufivemale              = $row->bdufivemale;
        $bdufivefemale            = $row->bdufivefemale;
        $bdofivemale              = $row->bdofivemale;
        $bdofivefemale            = $row->bdofivefemale;
        $oadufivemale             = $row->oadufivemale;
        $oadufivefemale           = $row->oadufivefemale;
        $oadofivemale             = $row->oadofivemale;
        $oadofivefemale           = $row->oadofivefemale;
        $diphmale                 = $row->diphmale;
        $diphfemale               = $row->diphfemale;
		$diphofivemale            = $row->diphofivemale;
        $diphofivefemale          = $row->diphofivefemale;
        $wcmale                   = $row->wcmale;
        $wcfemale                 = $row->wcfemale;
		$wcofivemale              = $row->wcofivemale;
        $wcofivefemale            = $row->wcofivefemale;
        $measmale                 = $row->measmale;
        $measfemale               = $row->measfemale;
		$measofivemale            = $row->measofivemale;
        $measofivefemale          = $row->measofivefemale;
        $nntmale                  = $row->nntmale;
        $nntfemale                = $row->nntfemale;
        $afpmale                  = $row->afpmale;
        $afpfemale                = $row->afpfemale;
		$afpofivemale             = $row->afpofivemale;
        $afpofivefemale           = $row->afpofivefemale;
        $ajsmale                  = $row->ajsmale;
        $ajsfemale                = $row->ajsfemale;
        $vhfmale                  = $row->vhfmale;
        $vhffemale                = $row->vhffemale;
        $malufivemale             = $row->malufivemale;
        $malufivefemale           = $row->malufivefemale;
        $malofivemale             = $row->malofivemale;
        $malofivefemale           = $row->malofivefemale;
        $suspectedmenegitismale   = $row->suspectedmenegitismale;
        $suspectedmenegitisfemale = $row->suspectedmenegitisfemale;
		$suspectedmenegitisofivemale   = $row->suspectedmenegitisofivemale;
        $suspectedmenegitisofivefemale = $row->suspectedmenegitisofivefemale;
        $undisonedesc             = $row->undisonedesc;
        $undismale                = $row->undismale;
        $undisfemale              = $row->undisfemale;
        $undissecdesc             = $row->undissecdesc;
        $undismaletwo             = $row->undismaletwo;
        $undisfemaletwo           = $row->undisfemaletwo;
        $ocmale                   = $row->ocmale;
        $ocfemale                 = $row->ocfemale;
        
        $total_consultations = $sariufivemale + $sariufivefemale + $sariofivemale + $sariofivefemale + $iliufivemale + $iliufivefemale + $iliofivemale + $iliofivefemale + $awdufivemale + $awdufivefemale + $awdofivemale + $awdofivefemale + $bdufivemale + $bdufivefemale + $bdofivemale + $bdofivefemale + $oadufivemale + $oadufivefemale + $oadofivemale + $oadofivefemale + $diphmale + $diphfemale + $diphofivemale + $diphofivefemale + $wcmale + $wcfemale + $wcofivemale + $wcofivefemale + $measmale + $measfemale + $measofivemale + $measofivefemale + $nntmale + $nntfemale + $afpmale + $afpfemale + $afpofivemale + $afpofivefemale + $ajsmale + $ajsfemale + $vhfmale + $vhffemale + $malufivemale + $malufivefemale + $malofivemale + $malofivefemale + $suspectedmenegitismale + $suspectedmenegitisfemale + $suspectedmenegitisofivemale + $suspectedmenegitisofivefemale + $undismale + $undisfemale + $undismaletwo + $undisfemaletwo + $ocmale + $ocfemale;
        
        $update_data = array(
            'total_consultations' => $total_consultations,
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered
        );
        $this->db->where('id', $id);
        $this->db->update('reportingforms', $update_data);
        
        $action = 'Updated the report on the database.';
        
        //enter audit trail information
        $auditdata = array(
            'user_id' => $user_id,
            'reportingform_id' => $id,
            'date_of_action' => $datetime_entered,
            'action' => $action
        );
        $this->db->insert('audittrail', $auditdata);
        
        
        $sre  = $this->input->post('sre');
        $pf   = $this->input->post('pf');
        $pv   = $this->input->post('pv');
        $pmix = $this->input->post('pmix');
        
        $totpositive    = $pf + $pv + $pmix;
        $total_negative = $sre - $total_positive;
        
        
        $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
        
        $creditamount         = $systemcredit->amount;
        $dollarrate           = $systemcredit->dollar_rate;
        $amountkenyashillings = $creditamount * $dollarrate;
        
        
        $alertcases = '';
        $vpdcases   = '';
        $wbdcases   = '';
        $vbdcases   = '';
        
        
        $reportingperiod_id = $reportingperiod->id;
        
        if ($totalpositive != 0) {
            $alertpf = ($pf / $totalpositive) * 100;
            
            if ($alertpf > 40) {
                $alertcases .= 'Pf/' . $pf . '';
                $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'Pf');
                
                $alertdata = array(
                    'reportingform_id' => $reportingform_id,
                    'reportingperiod_id' => $reportingperiod_id,
                    'disease_name' => 'Pf',
                    'healthfacility_id' => $healthfacility_id,
                    'district_id' => $district->id,
                    'region_id' => $region->id,
                    'zone_id' => $zone->id,
                    'cases' => $pf,
                    'deaths' => 0,
                    'notes' => '',
                    'verification_status' => 0,
                    'include_bulletin' => 0
                );
                $this->db->insert('alerts', $alertdata);
            }
            
            $srealert = ($totalpositive / $sre) * 100;
            
            if ($srealert > 50) {
                $alertcases .= 'SRE/' . $sre . '';
                $alertdelete = $this->alertsmodel->delete_by_reportingform_id_disease($reportingform_id, 'SRE');
                $alertdata   = array(
                    'reportingform_id' => $reportingform_id,
                    'reportingperiod_id' => $reportingperiod_id,
                    'disease_name' => 'SRE',
                    'healthfacility_id' => $healthfacility_id,
                    'district_id' => $district->id,
                    'region_id' => $region->id,
                    'zone_id' => $zone->id,
                    'cases' => $sre,
                    'deaths' => 0,
                    'notes' => '',
                    'verification_status' => 0,
                    'include_bulletin' => 0
                );
                $this->db->insert('alerts', $alertdata);
            }
        }
        
        if (!empty($alertcases)) {
            $thehost    = 'smsplus1.routesms.com';
            $theport    = '8080';
            $uname      = 'smartads';
            $pword      = 'sma56rtw';
            $themsgtype = 0;
            $thedlr     = 0;
            $sender     = 'eDEWS';
            $total_sms  = 0;
            
            //zone numbers
            $allzonenumbers   = $this->mobilenumbersmodel->get_by_zone_sector($zone->id, 4);
            //region numbers
            $allregionnumbers = $this->mobilenumbersmodel->get_by_region_sector($region->id, 4);
            
            $totallzonenumbers   = count($allzonenumbers);
            $totallregionnumbers = count($allregionnumbers);
            
            $total_sms = $total_sms + $totallzonenumbers + $totallregionnumbers;
            
            $numberstosendzone   = '';
            $numberstosendregion = '';
            
            if (!empty($allzonenumbers)) {
                foreach ($allzonenumbers as $allzkey => $allzonenumber) {
                    $numberstosendzone .= $allzonenumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allzmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allzmessagetext = str_replace("+", "%2b", $allzmessagetext);
                
                //send the SMS to the number
                $allzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allzmessagetext,$numberstosendzone,$themsgtype,$thedlr);	
            }
            
            
            if (!empty($allregionnumbers)) {
                foreach ($allregionnumbers as $allrkey => $allregionnumber) {
                    $numberstosendregion .= $allregionnumber['phone_number'] . urlencode(',');
                }
                
                //send SMS
                $allrmessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
                
                // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
                $sender          = str_replace("+", "%2b", $sender);
                $allrmessagetext = str_replace("+", "%2b", $allrmessagetext);
                
                //send the SMS to the number
                $allrresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allrmessagetext,$numberstosendregion,$themsgtype,$thedlr);	
            }
            
			
			$nationalnumbers   = $this->mobilenumbersmodel->get_by_all_sector(0,0,0,4);
			$totalnationalnumbers   = count($nationalnumbers);
					
					                   
                    $total_sms = $total_sms + $totalnationalnumbers;
                    
                    $numberstosendnational = '';
					$gsm = array();
                    
                    if (!empty($nationalnumbers)) {
                        foreach ($nationalnumbers as $allnatkey => $nationalnumber) {
							
							$thenumber = $nationalnumber['phone_number'];
							$countrycode = substr($thenumber, 0, 3);
							if($countrycode==254)
							{
								$gsm[] = $nationalnumber['phone_number'];
							}
							else
							{
                            	$numberstosendnational .= $nationalnumber['phone_number'] . urlencode(',');
							}
                        }
                        
                        //send SMS
                        $mymessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
							                        
                        // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
						$this_msg = $mymessagetext;
                        $sender          = str_replace("+", "%2b", $sender);
                        $mymessagetext = str_replace("+", "%2b", $mymessagetext);
                        
						if(!empty($gsm))
						{
							$username = 'adverts';
							$password = 'sadvert009';
							$sender 		= 'eDEWS';
							$isflash 		= 0;      	//Is flash message (1 or 0)
							$type			= 'longSMS';//msg type ("bookmark" - for wap push, "longSMS" for text messages only)
							$bookmark 		= '';
							$response = $this->SendSMS($username,$password,$sender,$mymessagetext,$isflash, $gsm, $type, $bookmark);
						}
                        //send the SMS to the number
						
						if(!empty($numberstosendnational))
						{
                        	$allnatresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$mymessagetext,$numberstosendnational,$themsgtype,$thedlr);	
						}
                    }
            
            $sms_rate  = $systemcredit->sms_rate;
            $smscost   = $total_sms * $sms_rate;
            $newamount = ($creditamount - $smscost);
            
            $updatecredit = array(
            'amount' => $newamount,
            );
           // $this->db->where('id', 1);
            //$this->db->update('systemcredit', $updatecredit);
			
			$this->systemcreditmodel->update(1, $updatecredit);
			
			//update table that alert is sent
                    $updatedata = array(
                        'alert_sent' => 1
                    );
                    $this->db->where('id', $reportingform_id);
                    $this->db->update('reportingforms', $updatedata);
			
			//update the SMS reports table
			
			$smsdata = array('text' => $this_msg,
									'number_sent' => $total_sms,
									'amount_spent' => $smscost,
									'date_sent' => $date_entered,
									'date_time_sent' => $datetime_entered
								);
					$this->smsreportsmodel->save($smsdata);
            
            
        }
        
        $this->laststep($id);
    }
    
    function laststep($id)
    {
        
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        
        if (empty($id)) {
            redirect('mobile/home', 'refresh');
        }
        $data = array();
        
        $row  = $this->db->get_where('reportingforms', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        
        $this->load->view('mobile/finalstep', $data);
    }
    
    function edit()
    {
        
        $data = array();
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        
        $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
        
        $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        
        $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        
        $region = $this->regionsmodel->get_by_id($district->region_id)->row();
        
        $data['district'] = $district;
        
        $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
        
        $data['districts'] = $this->districtsmodel->get_by_region($region->id);
        
        $data['healthfacility'] = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        
        $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        $data['error']            = '';
        
        $this->load->view('mobile/edit', $data);
    }
    
    function getdata()
    {
        $reporting_year = $this->input->post('reporting_year');
        $week_no        = $this->input->post('week_no');
		
		$healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
        
        $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
       
        $reportingform = $this->reportingformsmodel-> get_by_reporting_period_hf($reportingperiod->id, $healthfacility_id)->row();
        
        if (empty($reportingform)) {
            
            
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            
            $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            
            $data['district'] = $district;
            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            
            $data['healthfacility'] = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
            $data['error'] = 'There are no records for the selected period.';
            
            $this->load->view('mobile/edit', $data);
        } else {
            
            $id = $reportingform->id;
            
            $row  = $this->db->get_where('reportingforms', array(
                'id' => $id
            ))->row();
            $data = array(
                'row' => $row
            );
            
            $this->load->view('mobile/editpage', $data);
        }
    }
    
    
    function saveupdateone()
    {
        $id      = $this->input->post('reportingform_id');
        $user_id = $this->erkanaauth->getField('id');
		
		$dateposted = $this->input->post('reporting_date');
		$datetime = $this->input->post('datetime');
		if(empty($dateposted))
		{
			$date_entered = date('Y-m-d');
		}
		else
		{
			$date_entered = $dateposted;
		}
		
		if(empty($datetime))
		{
			$datetime_entered = date("Y-m-d H:i:s");
		}
		else
		{
			$datetime_entered = $dateposted;
		}
		
        $data    = array(
            'sariufivemale' => $this->input->post('sariufivemale'),
            'sariufivefemale' => $this->input->post('sariufivefemale'),
            'sariofivemale' => $this->input->post('sariofivemale'),
            'sariofivefemale' => $this->input->post('sariofivefemale'),
            'iliufivemale' => $this->input->post('iliufivemale'),
            'iliufivefemale' => $this->input->post('iliufivefemale'),
            'iliofivemale' => $this->input->post('iliofivemale'),
            'iliofivefemale' => $this->input->post('iliofivefemale'),
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered
        );
        
        $this->db->where('id', $id);
        $this->db->update('reportingforms', $data);
        
        $action = 'Updated the report on the database.';
        
        //enter audit trail information
        $auditdata = array(
            'user_id' => $user_id,
            'reportingform_id' => $id,
            'date_of_action' => $datetime_entered,
            'action' => $action
        );
        $this->db->insert('audittrail', $auditdata);
        
        $this->steptwoedit($id);
    }
    
    function steptwoedit($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
        $data = array();
        
        $row  = $this->db->get_where('reportingforms', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        
        $this->load->view('mobile/editsecondstep', $data);
        
    }
    
    function editsecond()
    {
        $id      = $this->input->post('reportingform_id');
        $user_id = $this->erkanaauth->getField('id');
        
		
		$dateposted = $this->input->post('reporting_date');
		$datetime = $this->input->post('datetime');
		if(empty($dateposted))
		{
			$date_entered = date('Y-m-d');
		}
		else
		{
			$date_entered = $dateposted;
		}
		
		if(empty($datetime))
		{
			$datetime_entered = date("Y-m-d H:i:s");
		}
		else
		{
			$datetime_entered = $dateposted;
		}
		
        $data = array(
            'awdufivemale' => $this->input->post('awdufivemale'),
            'awdufivefemale' => $this->input->post('awdufivefemale'),
            'awdofivemale' => $this->input->post('awdofivemale'),
            'awdofivefemale' => $this->input->post('awdofivefemale'),
            'bdufivemale' => $this->input->post('bdufivemale'),
            'bdufivefemale' => $this->input->post('bdufivefemale'),
            'bdofivemale' => $this->input->post('bdofivemale'),
            'bdofivefemale' => $this->input->post('bdofivefemale'),
            'oadufivemale' => $this->input->post('oadufivemale'),
            'oadufivefemale' => $this->input->post('oadufivefemale'),
            'oadofivemale' => $this->input->post('oadofivemale'),
            'oadofivefemale' => $this->input->post('oadofivefemale'),
            'edit_date' => $date_entered,
            'edit_time' => $datetime_entered
        );
        $this->db->where('id', $id);
        $this->db->update('reportingforms', $data);
        
        $action = 'Updated the report on the database.';
        
        //enter audit trail information
        $auditdata = array(
            'user_id' => $user_id,
            'reportingform_id' => $id,
            'date_of_action' => $datetime_entered,
            'action' => $action
        );
        $this->db->insert('audittrail', $auditdata);
        
        $this->thirdstep($id);
    }
    
    function logout()
    {
        
        $this->erkanaauth->logout();
        
        redirect('mobile', 'refresh');
        
        
    }
	
	 private function sms_unicode($message)
    {
        $hex1 = '';
        if (function_exists('iconv')) {
            $latin = @iconv('UTF-8', 'ISO-8859-1', $message);
            if (strcmp($latin, $message)) {
                $arr  = unpack('H*hex', @iconv('UTF-8', 'UCS-2BE', $message));
                $hex1 = strtoupper($arr['hex']);
            }
            if ($hex1 == '') {
                $hex2 = '';
                
                $hex = '';
                
                for ($i = 0; $i < strlen($message); $i++) {
                    $hex = dechex(ord($message[$i]));
                    $len = strlen($hex);
                    $add = 4 - $len;
                    if ($len < 4) {
                        for ($j = 0; $j < $add; $j++) {
                            $hex = "0" . $hex;
                        }
                    }
                    $hex2 .= $hex;
                }
                return $hex2;
            } else {
                return $hex1;
            }
        } else {
            print 'iconv Function Not Exists !';
        }
    }
	
	public function Submit($thehost, $theport, $uname, $pword, $sender, $messagetext, $routesmsnumbers, $themsgtype, $thedlr)
    {
        if ($themsgtype == "2" || $themsgtype == "6") {
            //call the functio of string to HEX.
            $messagetext = $this->sms_unicode($messagetext);
            try {
                //smpp http Url to send sms
                
                $live_url  = "http://" . $thehost . ":" . $theport . "/bulksms/bulksms?username=" . $uname . "&password=" . $pword . "&type=" . $themsgtype . "&dlr=" . $thedlr . "&destination=" . $routesmsnumbers . "&source=" . $sender . "&message=" . $messagetext . "";
                $parse_url = file($live_url);
                //echo $parse_url[0];
                return $parse_url[0];
            }
            catch (Exception $e) {
                echo 'Message:' . $e->getMessage();
            }
        } else {
            $messagetext = urlencode($messagetext);
            try {
                //smpp http Url to send sms
                
                $live_url = "http://" . $thehost . ":" . $theport . "/bulksms/bulksms?username=" . $uname . "&password=" . $pword . "&type=" . $themsgtype . "&dlr=" . $thedlr . "&destination=" . $routesmsnumbers . "&source=" . $sender . "&message=" . $messagetext . "";
                
                $parse_url = file($live_url);
                //echo $parse_url[0];
                return $parse_url[0];
            }
            catch (Exception $e) {
                echo 'Message:' . $e->getMessage();
            }
        }
    }
	
	//infobip functions
	function SendSMS($username, $password, $sender, $message, $flash, $inputgsmnumbers, $type, $bookmark)
	{
		$this->username = $username;
		$this->password = $password;
		$this->sender = htmlspecialchars($sender, ENT_QUOTES);
		$this->message = htmlspecialchars($message, ENT_QUOTES);
		$this->flash = $flash;
		$this->inputgsmnumbers = $inputgsmnumbers;
		$this->type = $type;
		$this->bookmark = $bookmark;

		//$this->host = "www.infobip.com";
		//$this->path = "/AddOn/SMSService/XML/XMLInput.aspx";
		$this->host = "api.infobip.com";
		$this->path = "/api/v3/sendsms/xml";

		$this->convertGSMnumberstoXML();
		$this->prepareXMLdata();

                $this->response = $this->doPost($this->path,$this->request_data,$this->host);
                return $this->response;
	}
	
	function convertGSMnumberstoXML()
	{
		$gsmcount = count($this->inputgsmnumbers); #counts gsm numbers

		for ( $i = 0; $i < $gsmcount; $i++ )
		{
			$this->XMLgsmnumbers .= "<gsm>" . $this->inputgsmnumbers[$i] . "</gsm>";
		}
	}
	
	function preparescheduleXMLdata()
	{
		$this->xmldata = "<SMS><authentification><username>" . $this->username . "</username><password>" . $this->password . "</password></authentification><message><sender>" . $this->sender . "</sender><text>" . $this->message . "</text><sendDateTime>" . $this->sendDateTime . "</sendDateTime><flash>" . $this->flash . "</flash><type>" . $this->type . "</type><bookmark>" . $this->bookmark . "</bookmark></message><recipients>" . $this->XMLgsmnumbers . "</recipients></SMS>";
		$this->request_data = 'XML=' . $this->xmldata;
	}
	
	function prepareXMLdata()
	{
		$this->xmldata = "<SMS><authentification><username>" . $this->username . "</username><password>" . $this->password . "</password></authentification><message><sender>" . $this->sender . "</sender><text>" . $this->message . "</text><flash>" . $this->flash . "</flash><type>" . $this->type . "</type><bookmark>" . $this->bookmark . "</bookmark></message><recipients>" . $this->XMLgsmnumbers . "</recipients></SMS>";
		$this->request_data = 'XML=' . $this->xmldata;
	}
	
	function doPost($uri,$postdata,$host){
	   $da = fsockopen($host, 80, $errno, $errstr);
	   if (!$da) 
	   {
		   return "$errstr ($errno)";
	   }
	   else {
		   $salida ="POST $uri  HTTP/1.1\r\n";
		   $salida.="Host: $host\r\n";
		   $salida.="User-Agent: PHP Script\r\n";
		   $salida.="Content-Type: text/xml\r\n";
		   $salida.="Content-Length: ".strlen($postdata)."\r\n";
		   $salida.="Connection: close\r\n\r\n";
		   $salida.=$postdata;
		   fwrite($da, $salida);
					 while (!feof($da))
			   $response.=fgets($da, 128);
		   $response=split("\r\n\r\n",$response);
		   $header=$response[0];
		   $responsecontent=$response[1];
		   if(!(strpos($header,"Transfer-Encoding: chunked")===false)){
			   $aux=split("\r\n",$responsecontent);
			   for($i=0;$i<count($aux);$i++)
				   if($i==0 || ($i%2==0))
					   $aux[$i]="";
			   $responsecontent=implode("",$aux);
		   }//if
		   return chop($responsecontent);
	   }//else
	}	
    
    
}
