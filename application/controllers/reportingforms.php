<?php

class Reportingforms extends CI_Controller
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
        $this->load->model('reportingformsmodel');
    }
    
    public function index()
    {
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        $user_id = $this->erkanaauth->getField('id');
        
        $level = $this->erkanaauth->getField('level');
        
        if (getRole() != 'SuperAdmin' && $level != 2 && $level != 3 && $level != 6) {
            
            redirect('home', 'refresh');
            
        }
        
        if ($level == 3) //HF
            {
            $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
            $data              = array(
                'rows' => $this->reportingformsmodel->get_hf_list($healthfacility_id)
            );
            /**
            $data = array(
            'rows' => $this->reportingformsmodel->get_user_list($user_id),
            );
            **/
		} elseif ($level == 6) //District FP
            {
            $distrcit_id = $this->erkanaauth->getField('distrcit_id');
            
            $data = array(
                'rows' => $this->reportingformsmodel->get_district_list($distrcit_id)
            );
        
        } elseif ($level == 2) //Regional FP
            {
            $region_id = $this->erkanaauth->getField('region_id');
            
            $data = array(
                'rows' => $this->reportingformsmodel->get_region_list($region_id)
            );
        } else {
            $data = array(
                'rows' => $this->reportingformsmodel->get_combined_list()
            );
        }
        
        $data['level']           = $level;
        $data['alert_message']   = $this->session->flashdata('alert_message');
        $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
        $this->load->view('reportingforms/index', $data);
    }
    
    
    public function add()
    {
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
		$country_id = $this->erkanaauth->getField('country_id');
        
        if (getRole() != 'SuperAdmin' && $level != 2 && $level != 3 && $level != 6) {
            
            redirect('home', 'refresh');
            
        }
        
        $data = array();
        
        /**
        1- zonal
        2- Regional
        3 - Health facility
        4- National
        5 - stake holder
        **/
        
        if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
        
        
        if ($level == 3) {//HF
            
            $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
            
            
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            
            $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            
            $data['healthfacility'] = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        } 
		else if ($level == 6) {//District
			$district_id = $this->erkanaauth->getField('district_id');
			
			
			$district = $this->districtsmodel->get_by_id($district_id)->row();
            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
			$data['healthfacilities'] = $this->db->get_where('healthfacilities', array('district_id' => $district->id));
		}
		else if ($level == 2) {//Regional
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region                   = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']             = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']           = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts']        = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
        }
        
        $data['level'] = $level;
		
		$country = $this->countriesmodel->get_by_id($country_id)->row();
		
		$data['country'] = $country;
        
        
        
        $this->load->view('reportingforms/add', $data);
    }
    
    
    public function add_validate()
    {
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        
        $sre  = $this->input->post('sre');
        $pf   = $this->input->post('pf');
        $pv   = $this->input->post('pv');
        $pmix = $this->input->post('pmix');
        
        $totpositive = $pf + $pv + $pmix;
        
        //ensure that the reporting period is not entered twice
        $reporting_year  = $this->input->post('reporting_year');
        $week_no         = $this->input->post('week_no');
        $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
        
        if (!empty($reportingperiod)) {
            $reportingperiod_id = $reportingperiod->id;
        } else {
            $reportingperiod_id = 0;
        }
        
        $level = $this->erkanaauth->getField('level');
        if ($level == 3) {
            $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
            
        } else {
            $healthfacility_id = $this->input->post('healthfacility_id');
        }
        
        $reportingform = $this->reportingformsmodel->get_by_period_hf($reportingperiod->id, $healthfacility_id);
        
        if (!empty($reportingform)) {
            $iscaptured = 1;
			redirect('reportingforms/add', 'refresh');
        } else {
            $iscaptured = 0;
        }
        
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('week_no', 'Week No', 'trim|required');
        $this->form_validation->set_rules('reporting_year', 'Reporting year', 'trim|required|callback__check_Period[' . $iscaptured . ']');
        $this->form_validation->set_rules('reporting_date', 'Reporting date', 'trim|required');
        $this->form_validation->set_rules('district_id', 'District', 'trim|required');
        $this->form_validation->set_rules('healthfacility_id', 'Health Facility', 'trim|required');
        /**
        //$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required');
        //$this->form_validation->set_rules('supporting_ngo', 'Supporting ngo', 'trim|required');
        $this->form_validation->set_rules('sariufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliufivefemale', 'blank', 'trim|required|numeric');	   
        $this->form_validation->set_rules('iliofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliofivefemale', 'blank', 'trim|required|numeric');	   
        $this->form_validation->set_rules('awdufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('diphmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('diphfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('wcmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('wcfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('measmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('measfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('nntmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('nntfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('afpmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('afpfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ajsmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ajsfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('vhfmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('vhffemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('suspectedmenegitismale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('suspectedmenegitisfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisonedesc', 'blank', 'trim|required');
        $this->form_validation->set_rules('undismale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undissecdesc', 'blank', 'trim|required');
        $this->form_validation->set_rules('undismaletwo', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisfemaletwo', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ocmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ocfemale', 'blank', 'trim|required|numeric');
        //$this->form_validation->set_rules('total_consultations', 'Total consultations', 'trim|required');
        $this->form_validation->set_rules('sre', 'blank', 'trim|required|numeric|callback__check_Sre['.$totpositive.']');
        $this->form_validation->set_rules('pf', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('pv', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('pmix', 'blank', 'trim|required|numeric');
        //$this->form_validation->set_rules('totalnegative', 'blank', 'trim|required');
        
        **/
        if ($this->form_validation->run() == false) {
            $this->add();
            
        } else {
            
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
            $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
            $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
            
            
            $user_id = $this->erkanaauth->getField('id');
            
            $user = $this->usersmodel->get_by_id($user_id)->row();
            
            $sariufivemale            = $this->input->post('sariufivemale');
            $sariufivefemale          = $this->input->post('sariufivefemale');
            $sariofivemale            = $this->input->post('sariofivemale');
            $sariofivefemale          = $this->input->post('sariofivefemale');
            $iliufivemale             = $this->input->post('iliufivemale');
            $iliufivefemale           = $this->input->post('iliufivefemale');
            $iliofivemale             = $this->input->post('iliofivemale');
            $iliofivefemale           = $this->input->post('iliofivefemale');
            $awdufivemale             = $this->input->post('awdufivemale');
            $awdufivefemale           = $this->input->post('awdufivefemale');
            $awdofivemale             = $this->input->post('awdofivemale');
            $awdofivefemale           = $this->input->post('awdofivefemale');
            $bdufivemale              = $this->input->post('bdufivemale');
            $bdufivefemale            = $this->input->post('bdufivefemale');
            $bdofivemale              = $this->input->post('bdofivemale');
            $bdofivefemale            = $this->input->post('bdofivefemale');
            $oadufivemale             = $this->input->post('oadufivemale');
            $oadufivefemale           = $this->input->post('oadufivefemale');
            $oadofivemale             = $this->input->post('oadofivemale');
            $oadofivefemale           = $this->input->post('oadofivefemale');
            $diphmale                 = $this->input->post('diphmale');
            $diphfemale               = $this->input->post('diphfemale');
			$diphofivemale            = $this->input->post('diphofivemale');
            $diphofivefemale          = $this->input->post('diphofivefemale');
            $wcmale                   = $this->input->post('wcmale');
            $wcfemale                 = $this->input->post('wcfemale');
			$wcofivemale              = $this->input->post('wcofivemale');
            $wcofivefemale            = $this->input->post('wcofivefemale');
            $measmale                 = $this->input->post('measmale');
            $measfemale               = $this->input->post('measfemale');
			$measofviemale            = $this->input->post('measofviemale');
            $measofivefemale          = $this->input->post('measofivefemale');
            $nntmale                  = $this->input->post('nntmale');
            $nntfemale                = $this->input->post('nntfemale');
            $afpmale                  = $this->input->post('afpmale');
            $afpfemale                = $this->input->post('afpfemale');
			$afpofivemale             = $this->input->post('afpofivemale');
            $afpofivefemale           = $this->input->post('afpofivefemale');
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
            $undisonedesc             = $this->input->post('undisonedesc');
            $undismale                = $this->input->post('undismale');
            $undisfemale              = $this->input->post('undisfemale');
            $undissecdesc             = $this->input->post('undissecdesc');
            $undismaletwo             = $this->input->post('undismaletwo');
            $undisfemaletwo           = $this->input->post('undisfemaletwo');
            $ocmale                   = $this->input->post('ocmale');
            $ocfemale                 = $this->input->post('ocfemale');
            
            
            $total_consultations = $sariufivemale + $sariufivefemale + $sariofivemale + $sariofivefemale + $iliufivemale + $iliufivefemale + $iliofivemale + $iliofivefemale + $awdufivemale + $awdufivefemale + $awdofivemale + $awdofivefemale + $bdufivemale + $bdufivefemale + $bdofivemale + $bdofivefemale + $oadufivemale + $oadufivefemale + $oadofivemale + $oadofivefemale + $diphmale + $diphfemale + $diphofivemale + $diphofivefemale + $wcmale + $wcfemale + $wcofivemale + $wcofivefemale + $measmale + $measfemale + $measofivemale + $measofivefemale + $nntmale + $nntfemale + $afpmale + $afpfemale + $afpofivemale + $afpofivefemale + $ajsmale + $ajsfemale + $vhfmale + $vhffemale + $malufivemale + $malufivefemale + $malofivemale + $malofivefemale + $suspectedmenegitismale + $suspectedmenegitisfemale + $suspectedmenegitisofivemale + $suspectedmenegitisofivefemale + $undismale + $undisfemale + $undismaletwo + $undisfemaletwo + $ocmale + $ocfemale;
            
            $sre  = $this->input->post('sre');
            $pf   = $this->input->post('pf');
            $pv   = $this->input->post('pv');
            $pmix = $this->input->post('pmix');
            
            $total_positive = $pf + $pv + $pmix;
            
            $total_negative = $sre - $total_positive;
            
            if (isset($_POST['draft_button'])) {
                //save as draft
                $approved_hf = 0;
                $draft       = 1;
                
            } else if (isset($_POST['submit_button'])) {
                $approved_hf = 1;
                $draft       = 0;
            }
            
            
            $data = array(
                'week_no' => $this->input->post('week_no'),
                'reporting_year' => $this->input->post('reporting_year'),
                'reporting_date' => $this->input->post('reporting_date'),
                'epdcalendar_id' => $reportingperiod->id,
                'user_id' => $user_id,
                'healthfacility_id' => $healthfacility_id,
                'contact_number' => $this->input->post('contact_number'),
                'health_facility_code' => $healthfacility->hf_code,
                'supporting_ngo' => $this->input->post('supporting_ngo'),
                'region_id' => $region->id,
                'sariufivemale' => $this->input->post('sariufivemale'),
                'sariufivefemale' => $this->input->post('sariufivefemale'),
                'sariofivemale' => $this->input->post('sariofivemale'),
                'sariofivefemale' => $this->input->post('sariofivefemale'),
                'iliufivemale' => $this->input->post('iliufivemale'),
                'iliufivefemale' => $this->input->post('iliufivefemale'),
                'iliofivemale' => $this->input->post('iliofivemale'),
                'iliofivefemale' => $this->input->post('iliofivefemale'),
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
                'undisonedesc' => $this->input->post('undisonedesc'),
                'undismale' => $this->input->post('undismale'),
                'undisfemale' => $this->input->post('undisfemale'),
                'undissecdesc' => $this->input->post('undissecdesc'),
                'undismaletwo' => $this->input->post('undismaletwo'),
                'undisfemaletwo' => $this->input->post('undisfemaletwo'),
                'ocmale' => $this->input->post('ocmale'),
                'ocfemale' => $this->input->post('ocfemale'),
                'total_consultations' => $total_consultations,
                'sre' => $this->input->post('sre'),
                'pf' => $this->input->post('pf'),
                'pv' => $this->input->post('pv'),
                'pmix' => $this->input->post('pmix'),
                'totalnegative' => $total_negative,
                'total_positive' => $total_positive,
                'approved_hf' => $approved_hf,
                'approved_regional' => 0,
                'approved_zone' => 0,
                'draft' => $draft,
                'alert_sent' => 0,
                'entry_date' => $this->input->post('reporting_date'),
                'entry_time' => $this->input->post('datetime'),
                'edit_date' => $this->input->post('reporting_date'),
				'edit_time' => $this->input->post('datetime'),
                'diphofivemale' => $this->input->post('diphofivemale'),
				'diphofivefemale' => $this->input->post('diphofivefemale'),
				'wcofivemale' => $this->input->post('wcofivemale'),
				'wcofivefemale' => $this->input->post('wcofivefemale'),
				'measofivemale' => $this->input->post('measofivemale'),
				'measofivefemale' => $this->input->post('measofivefemale'),
				'afpofivemale' => $this->input->post('afpofivemale'),
				'afpofivefemale' => $this->input->post('afpofivefemale'),
				'suspectedmenegitisofivemale' => $this->input->post('suspectedmenegitisofivemale'),
				'suspectedmenegitisofivefemale' => $this->input->post('suspectedmenegitisofivefemale'),
				
            );
			
			//date("Y-m-d H:i:s")
			
            $this->db->insert('reportingforms', $data);
            
            $reportingform_id = $this->db->insert_id();
            
            $action = 'Added the report to the database.';
            
            //enter audit trail information
            $auditdata = array(
                'user_id' => $user_id,
                'reportingform_id' => $reportingform_id,
                'date_of_action' => $this->input->post('datetime'),
                'action' => $action
            );
            $this->db->insert('audittrail', $auditdata);
            
            if (!empty($_POST['fields'])) {
                foreach ($_POST['fields'] as $rrow => $rid) {
                    
                    $disease = $rid;
                    $male    = $_POST['male'][$rrow];
                    $female  = $_POST['female'][$rrow];
                    
                    $otherconsultdata = array(
                        'reportingform_id' => $reportingform_id,
                        'disease' => $disease,
                        'malevalue' => $male,
                        'femalevalue' => $female
                    );
                    
                    $this->db->insert('otherconsultations', $otherconsultdata);
                    
                }
            }
            
            if (isset($_POST['submit_button'])) {
                
                //save any alerts
                
                $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
                
                $creditamount         = $systemcredit->amount;
                $dollarrate           = $systemcredit->dollar_rate;
                $amountkenyashillings = $creditamount * $dollarrate;
                
                
                $alertcases = '';
                $vpdcases   = '';
                $wbdcases   = '';
                $vbdcases   = '';
                
                
                $reportingperiod_id = $reportingperiod->id;
                
                $sari = $sariufivemale + $sariufivefemale + $sariofivemale + $sariofivefemale;
                if ($sari > 0) {
                    $alertcases .= 'SARI/' . $sari . ',';
                    
                    $vpdcases .= 'SARI/' . $sari . ',';
                    
                    $alertdata = array(
                        'reportingform_id' => $reportingform_id,
                        'reportingperiod_id' => $reportingperiod_id,
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
                
                //
                
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
                
                //
                
                
                $awd = $awdufivemale + $awdufivefemale + $awdofivemale + $awdofivefemale;
                if ($awd > 0) {
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
                    
                    $alertdata = array(
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
                //
                
                
                $diph = $diphmale + $diphfemale + $diphofivemale + $diphofivefemale;
                if ($diph > 0) {
                    $alertcases .= 'Diph/' . $diph . ',';
                    $vpdcases .= 'Diph/' . $diph . ',';
                    
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
                    $alertdata = array(
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
                
                $afp = $afpmale + $afpfemale + $afpofivefemale + $afpofivemale;
                if ($afp > 0) {
                    $alertcases .= 'AFP/' . $afp . ',';
                    $vpdcases .= 'AFP/' . $afp . ',';
                    
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
                
                $ajs = $ajsmale + $ajsfemale;
                if ($ajs > 4) {
                    $alertcases .= 'AJS/' . $ajs . ',';
                    $wbdcases .= 'AJS/' . $ajs . ',';
                    
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
                
                //$undis = $undismale + $undisfemale + $undissecdesc + $undismaletwo + $undisfemaletwo + $ocmale + $ocfemale;
				$undis = $undismale + $undisfemale + $undismaletwo + $undisfemaletwo;
                if ($undis > 2) {
                    $alertcases .= 'UnDis/' . $undis . '';
                    
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
                
                
                $totalpositive = ($pf + $pv + $pmix);
                if ($totalpositive != 0) {
                    $alertpf = ($pf / $totalpositive) * 100;
                    
                    if ($alertpf > 40) {
                        $alertcases .= 'Pf/' . $pf . '';
                        
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
                        
                        $alertdata = array(
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
                    
                    /**
                    VPD - 1
                    VPD+WBD - 5
                    VPD+VBD - 6
                    WBD - 2
                    WBD+VBD - 7
                    VBD - 3
                    ALL - 4
                    **/
                    //collect the numbers to send from the database	
                    
                    $total_sms = 0;
                    
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
                    
					//update table that alert is sent
                    $updatedata = array(
                        'alert_sent' => 1
                    );
                    $this->db->where('id', $reportingform_id);
                    $this->db->update('reportingforms', $updatedata);
                    
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
									'date_sent' => date('Y-m-d'),
									'date_time_sent' => date("Y-m-d H:i:s")
								);
					$this->smsreportsmodel->save($smsdata);
                   
                    
                }
            }
			
			
            
            redirect('reportingforms', 'refresh');
        }
        
        
    }
    
    function testsend()
    {
        $thehost    = 'smsplus1.routesms.com';
        $theport    = '8080';
        $uname      = 'smartads';
        $pword      = 'sma56rtw';
        $themsgtype = 0;
        $thedlr     = 0;
        $sender     = 'eDEWS';
        
        $gsm = array();
        
        $gsm[] = '254721937404';
		//$gsm[] = '252907036693';
		//$gsm[] = '252618855736';
        //$gsm[] = '252634400016';					
        //$gsm[] = '252618855736';
        
        /**
        
        $gsm[] = '252907794164';
        
        $gsm[] = '252907331259';
        
        $gsm[] = '252907363526';
        
        $gsm[] = '252615463636';
        
        $gsm[] = '252615599929';
        
        $gsm[] = '252615553366';
        
        $gsm[] = '25290736690';
        
        $gsm[] = '254736100177';
        
        $gsm[] = '254737357838';
        
        $gsm[] = '254716350367';
        **/
        
        $limit = (sizeof($gsm) - 1);
        
        $numbers = '';
        
        for ($i = 0; $i <= $limit; $i++) {
            if ($gsm[$i] == end($gsm)) {
                $numbers .= $gsm[$i];
            } else {
                //url encode the comma
                $numbers .= $gsm[$i] . urlencode(',');
            }
        }
        
        //send SMS
        $messagetext = "Zone: Central \n Region: Benadir \n District: Abdiaziz \n Health facility: Abidaziz MCH \n Week/Year: 1/2013 \n Period: 2012-12-31 to 2013-01-06 \n ---\n Alerts/Cases: SRE/1 \n Reported by: Joash \n Phone No: 254721937404";
        
        // Note: replace sign "+" with "%2b" for sender and message text or it will be replaced with empty space
        $sender      = str_replace("+", "%2b", $sender);
        $messagetext = str_replace("+", "%2b", $messagetext);
        
        //send the SMS to the number
        $response = $this->Submit($thehost, $theport, $uname, $pword, $sender, $messagetext, $numbers, $themsgtype, $thedlr);
    }
	
	public function infobiptest()
	{
		//send the SMS to the numbers in the group
						$username = 'adverts';
						$password = 'sadvert009';
						$sender 		= 'eDEWS';
						$isflash 		= 0;      	//Is flash message (1 or 0)
						$type			= 'longSMS';//msg type ("bookmark" - for wap push, "longSMS" for text messages only)
						$bookmark 		= '';
						
						$sender = str_replace("+","%2b",$sender);
						
						$gsm = array();
						
						$gsm[] = '254721937404';
						//$gsm[] = '0792875968';
						
						  //send SMS
        $messagetext = "Zone: Central \n Region: Benadir \n District: Abdiaziz \n Health facility: Abidaziz MCH \n Week/Year: 1/2013 \n Period: 2012-12-31 to 2013-01-06 \n -------------------- \n Alerts/Cases: SRE/1 \n Reported by: Joash \n Phone No: 254721937404";
		
					$messagetext = str_replace("+","%2b",$messagetext);
					
					$response = $this->SendSMS($username,$password,$sender,$messagetext,$isflash, $gsm, $type, $bookmark); //IsFlash must be 0 or 1
	}
    
    
    public function healthfacility()
    {
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
        if (getRole() != 'SuperAdmin' && $level != 2 && $level != 3 && $level !=6) {
            
            redirect('home', 'refresh');
            
        }
        
        $data                    = array();
        $data['alert_message']   = $this->session->flashdata('alert_message');
        $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
        
        
        if (getRole() == 'SuperAdmin') {
            $data['districts']        = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            $data['regions']          = $this->regionsmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }
        
        
        if ($level == 3) {
            
            $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
            
            
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            
            $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            
            $data['district'] = $district;
            
            $data['zone']   = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            
            $data['healthfacility'] = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        }else if ($level == 6) {//District
			$district_id = $this->erkanaauth->getField('district_id');
			
			
			$district = $this->districtsmodel->get_by_id($district_id)->row();
            
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
			$data['healthfacilities'] = $this->db->get_where('healthfacilities', array('district_id' => $district->id));
		} 
		
		else if ($level == 2) {
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region                   = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']             = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']           = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts']        = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
        }
        
        
        
        //1 - zone
        //2 - region
        //3 - health faciity
        
        $data['level'] = $level;
        
        $this->load->view('reportingforms/hfedit', $data);
    }
    
    
    public function edit($id)
    {
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
        if (getRole() != 'SuperAdmin' && $level != 2 && $level != 3) {
            
            redirect('home', 'refresh');
            
        }
        
        $row  = $this->db->get_where('reportingforms', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        
        $healthfacility_id = $row->healthfacility_id;
        $healthfacility    = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        $district          = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        
        if ($level == 2) {
            
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district($district->id);
        } else {
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district($district->id);
        }
		        
        $data['otherconsultations'] = $this->otherconsultationsmodel->get_by_reportingform_id($row->id);
        $data['district'] = $district;
        
        $data['region'] = $this->regionsmodel->get_by_id($district->region_id)->row();
        
        $data['healthfacility'] = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        
        $data['user']  = $this->usersmodel->get_by_id($row->user_id)->row();
        $data['level'] = $level;
		
        
        $data['alert_message']   = $this->session->flashdata('alert_message');
        $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
        
        $this->load->view('reportingforms/edit', $data);
    }
    
    public function update_form()
    {
        
        $id = $this->input->post('id');
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $reportingform = $this->reportingformsmodel->get_by_id($id)->row();
        
        $sre  = $this->input->post('sre');
        $pf   = $this->input->post('pf');
        $pv   = $this->input->post('pv');
        $pmix = $this->input->post('pmix');
        
        $totpositive = $pf + $pv + $pmix;
        
        if (isset($_POST['draft_button'])) {
            //save as draft
            $approved_hf = 0;
            $draft       = 1;
            
        } else if (isset($_POST['submit_button'])) {
            $approved_hf = 1;
            $draft       = 0;
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
        $this->form_validation->set_rules('reporting_year', 'Reporting year', 'trim|required');
        //$this->form_validation->set_rules('reporting_date', 'Reporting date', 'trim|required');
        //$this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required');
        // $this->form_validation->set_rules('supporting_ngo', 'Supporting ngo', 'trim|required');
        /**
        $this->form_validation->set_rules('sariufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliufivefemale', 'blank', 'trim|required|numeric');	   
        $this->form_validation->set_rules('iliofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliofivefemale', 'blank', 'trim|required|numeric');	   
        $this->form_validation->set_rules('awdufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('diphmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('diphfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('wcmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('wcfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('measmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('measfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('nntmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('nntfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('afpmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('afpfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ajsmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ajsfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('vhfmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('vhffemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('suspectedmenegitismale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('suspectedmenegitisfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisonedesc', 'blank', 'trim|required');
        $this->form_validation->set_rules('undismale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undissecdesc', 'blank', 'trim|required');
        $this->form_validation->set_rules('undismaletwo', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisfemaletwo', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ocmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ocfemale', 'blank', 'trim|required|numeric');
        //$this->form_validation->set_rules('total_consultations', 'Total consultations', 'trim|required');
        $this->form_validation->set_rules('sre', 'blank', 'trim|required|numeric|callback__check_Sre['.$totpositive.']');
        $this->form_validation->set_rules('pf', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('pv', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('pmix', 'blank', 'trim|required|numeric');
        //$this->form_validation->set_rules('totalnegative', 'blank', 'trim|required');
        **/
        if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {
            
            
            $user_id = $this->erkanaauth->getField('id');
            
            
            $sariufivemale            = $this->input->post('sariufivemale');
            $sariufivefemale          = $this->input->post('sariufivefemale');
            $sariofivemale            = $this->input->post('sariofivemale');
            $sariofivefemale          = $this->input->post('sariofivefemale');
            $iliufivemale             = $this->input->post('iliufivemale');
            $iliufivefemale           = $this->input->post('iliufivefemale');
            $iliofivemale             = $this->input->post('iliofivemale');
            $iliofivefemale           = $this->input->post('iliofivefemale');
            $awdufivemale             = $this->input->post('awdufivemale');
            $awdufivefemale           = $this->input->post('awdufivefemale');
            $awdofivemale             = $this->input->post('awdofivemale');
            $awdofivefemale           = $this->input->post('awdofivefemale');
            $bdufivemale              = $this->input->post('bdufivemale');
            $bdufivefemale            = $this->input->post('bdufivefemale');
            $bdofivemale              = $this->input->post('bdofivemale');
            $bdofivefemale            = $this->input->post('bdofivefemale');
            $oadufivemale             = $this->input->post('oadufivemale');
            $oadufivefemale           = $this->input->post('oadufivefemale');
            $oadofivemale             = $this->input->post('oadofivemale');
            $oadofivefemale           = $this->input->post('oadofivefemale');
            $diphmale                 = $this->input->post('diphmale');
            $diphfemale               = $this->input->post('diphfemale');
			$diphofivemale            = $this->input->post('diphofivemale');
            $diphofivefemale          = $this->input->post('diphofivefemale');
            $wcmale                   = $this->input->post('wcmale');
            $wcfemale                 = $this->input->post('wcfemale');
			$wcofivemale              = $this->input->post('wcofivemale');
            $wcofivefemale            = $this->input->post('wcofivefemale');
            $measmale                 = $this->input->post('measmale');
            $measfemale               = $this->input->post('measfemale');
			$measofviemale            = $this->input->post('measofviemale');
            $measofivefemale          = $this->input->post('measofivefemale');
            $nntmale                  = $this->input->post('nntmale');
            $nntfemale                = $this->input->post('nntfemale');
            $afpmale                  = $this->input->post('afpmale');
            $afpfemale                = $this->input->post('afpfemale');
			$afpofivemale             = $this->input->post('afpofivemale');
            $afpofivefemale           = $this->input->post('afpofivefemale');
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
            $undisonedesc             = $this->input->post('undisonedesc');
            $undismale                = $this->input->post('undismale');
            $undisfemale              = $this->input->post('undisfemale');
            $undissecdesc             = $this->input->post('undissecdesc');
            $undismaletwo             = $this->input->post('undismaletwo');
            $undisfemaletwo           = $this->input->post('undisfemaletwo');
            $ocmale                   = $this->input->post('ocmale');
            $ocfemale                 = $this->input->post('ocfemale');
            
            
            $total_consultations = ($sariufivemale + $sariufivefemale + $sariofivemale + $sariofivefemale + $iliufivemale + $iliufivefemale + $iliofivemale + $iliofivefemale + $awdufivemale + $awdufivefemale + $awdofivemale + $awdofivefemale + $bdufivemale + $bdufivefemale + $bdofivemale + $bdofivefemale + $oadufivemale + $oadufivefemale + $oadofivemale + $oadofivefemale + $diphmale + $diphfemale + $diphofivemale + $diphofivefemale + $wcmale + $wcfemale + $wcofivemale + $wcofivefemale + $measmale + $measfemale + $measofivemale + $measofivefemale + $nntmale + $nntfemale + $afpmale + $afpfemale + $afpofivemale + $afpofivefemale + $ajsmale + $ajsfemale + $vhfmale + $vhffemale + $malufivemale + $malufivefemale + $malofivemale + $malofivefemale + $suspectedmenegitismale + $suspectedmenegitisfemale + $suspectedmenegitisofivemale + $suspectedmenegitisofivefemale + $undismale + $undisfemale + $undismaletwo + $undisfemaletwo + $ocmale + $ocfemale);
            
            
            $sre  = $this->input->post('sre');
            $pf   = $this->input->post('pf');
            $pv   = $this->input->post('pv');
            $pmix = $this->input->post('pmix');
            
            $total_positive = $pf + $pv + $pmix;
            
            $total_negative = $sre - $total_positive;
            
            $reporting_year    = $this->input->post('reporting_year');
            $week_no           = $this->input->post('week_no');
            $healthfacility_id = $this->input->post('healthfacility_id');
            
            $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
            
            $form_period = $this->reportingformsmodel->get_by_period_hf($reportingperiod->id, $healthfacility_id);
            
            $new_hf_id = $this->input->post('hf_id');
            
            if ($healthfacility_id != $new_hf_id) {
                if (!empty($form_period)) {
                    $hf_id = $healthfacility_id;
                    $this->session->set_flashdata('alert_message', 'There is data already entered for the period and health facility that you attempted to edit to.');
                } else {
                    $hf_id = $this->input->post('hf_id');
                    $this->session->set_flashdata('sucsess_message', 'Record successfully updated.');
                    
                }
            } else {
                $hf_id = $this->input->post('healthfacility_id');
                $this->session->set_flashdata('sucsess_message', 'Record successfully updated.');
            }
            
            $data = array(
                'healthfacility_id' => $hf_id,
                'sariufivemale' => $this->input->post('sariufivemale'),
                'sariufivefemale' => $this->input->post('sariufivefemale'),
                'sariofivemale' => $this->input->post('sariofivemale'),
                'sariofivefemale' => $this->input->post('sariofivefemale'),
                'iliufivemale' => $this->input->post('iliufivemale'),
                'iliufivefemale' => $this->input->post('iliufivefemale'),
                'iliofivemale' => $this->input->post('iliofivemale'),
                'iliofivefemale' => $this->input->post('iliofivefemale'),
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
                'undisonedesc' => $this->input->post('undisonedesc'),
                'undismale' => $this->input->post('undismale'),
                'undisfemale' => $this->input->post('undisfemale'),
                'undissecdesc' => $this->input->post('undissecdesc'),
                'undismaletwo' => $this->input->post('undismaletwo'),
                'undisfemaletwo' => $this->input->post('undisfemaletwo'),
                'ocmale' => $this->input->post('ocmale'),
                'ocfemale' => $this->input->post('ocfemale'),
                'total_consultations' => $total_consultations,
                'sre' => $this->input->post('sre'),
                'pf' => $this->input->post('pf'),
                'pv' => $this->input->post('pv'),
                'pmix' => $this->input->post('pmix'),
                'totalnegative' => $total_negative,
                'total_positive' => $total_positive,
                'approved_hf' => $approved_hf,
                'approved_regional' => 0,
                'approved_zone' => 0,
                'draft' => $draft,
                'edit_date' => $this->input->post('edit_date'),
                'edit_time' => $this->input->post('edit_datetime'),
				'diphofivemale' => $this->input->post('diphofivemale'),
				'diphofivefemale' => $this->input->post('diphofivefemale'),
				'wcofivemale' => $this->input->post('wcofivemale'),
				'wcofivefemale' => $this->input->post('wcofivefemale'),
				'measofivemale' => $this->input->post('measofivemale'),
				'measofivefemale' => $this->input->post('measofivefemale'),
				'afpofivemale' => $this->input->post('afpofivemale'),
				'afpofivefemale' => $this->input->post('afpofivefemale'),
				'suspectedmenegitisofivemale' => $this->input->post('suspectedmenegitisofivemale'),
				'suspectedmenegitisofivefemale' => $this->input->post('suspectedmenegitisofivefemale'),
            );
            $this->db->where('id', $id);
            $this->db->update('reportingforms', $data);
			
			//insert new consultations for the reporting form
						
			if (!empty($_POST['fields'])) {
                foreach ($_POST['fields'] as $rrow => $rid) {
                    
                    $disease = $rid;
                    $male    = $_POST['male'][$rrow];
                    $female  = $_POST['female'][$rrow];
                    
                    $otherconsultdata = array(
                        'reportingform_id' => $id,
                        'disease' => $disease,
                        'malevalue' => $male,
                        'femalevalue' => $female
                    );
                    
                    $this->db->insert('otherconsultations', $otherconsultdata);
                    
                }
            }
            
            
            $action = 'Edited the reporting form.';
            
            //enter audit trail information
            $auditdata = array(
                'user_id' => $user_id,
                'reportingform_id' => $id,
                'date_of_action' => $this->input->post('edit_datetime'),
                'action' => $action
            );
            $this->db->insert('audittrail', $auditdata);
            
            $reporting_form = $this->reportingformsmodel->get_by_id($id)->row();
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($reporting_form->healthfacility_id)->row();
            $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
            $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
            $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
            
            $healthfacility_id = $reporting_form->healthfacility_id;
            $user              = $this->usersmodel->get_by_id($reporting_form->user_id)->row();
            
            $reportingform_id = $id;
            
            $reportingperiod_id = $reporting_form->epdcalendar_id;
            
            if (isset($_POST['submit_button'])) {
                if ($reportingform->alert_sent == 1) {
                    $this->db->delete('alerts', array(
                        'reportingform_id' => $reportingform_id
                    ));
                }
                
                //save any alerts and send SMSs
				  $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
                
                $creditamount         = $systemcredit->amount;
                $dollarrate           = $systemcredit->dollar_rate;
                $amountkenyashillings = $creditamount * $dollarrate;
                
                
                $alertcases = '';
                $vpdcases   = '';
                $wbdcases   = '';
                $vbdcases   = '';
                
                
                $reportingperiod_id = $reportingperiod->id;
                
                $sari = $sariufivemale + $sariufivefemale + $sariofivemale + $sariofivefemale;
                if ($sari > 0) {
                    $alertcases .= 'SARI/' . $sari . ',';
                    
                    $vpdcases .= 'SARI/' . $sari . ',';
                    
                    $alertdata = array(
                        'reportingform_id' => $reportingform_id,
                        'reportingperiod_id' => $reportingperiod_id,
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
                
                //
                
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
                
                //
                
                
                $awd = $awdufivemale + $awdufivefemale + $awdofivemale + $awdofivefemale;
                if ($awd > 0) {
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
                    
                    $alertdata = array(
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
                //
                
                
                $diph = $diphmale + $diphfemale + $diphofivefemale + $diphofivemale;
                if ($diph > 0) {
                    $alertcases .= 'Diph/' . $diph . ',';
                    $vpdcases .= 'Diph/' . $diph . ',';
                    
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
                
                $wc = $wcmale + $wcfemale + $wcofivefemale + $wcofivemale;
                if ($wc > 4) {
                    $alertcases .= 'WC/' . $wc . ',';
                    $vpdcases .= 'WC/' . $wc . ',';
                    $alertdata = array(
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
                
                $meas = $measmale + $measfemale + $measofivefemale + $measofviemale;
                if ($meas > 0) {
                    $alertcases .= 'Meas/' . $meas . ',';
                    $vpdcases .= 'Meas/' . $meas . ',';
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
                
                $afp = $afpmale + $afpfemale + $afpofivefemale + $afpofivemale;
                if ($afp > 0) {
                    $alertcases .= 'AFP/' . $afp . ',';
                    $vpdcases .= 'AFP/' . $afp . ',';
                    
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
                
                $ajs = $ajsmale + $ajsfemale;
                if ($ajs > 4) {
                    $alertcases .= 'AJS/' . $ajs . ',';
                    $wbdcases .= 'AJS/' . $ajs . ',';
                    
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
                
                $men = $suspectedmenegitismale + $suspectedmenegitisfemale + $suspectedmenegitisofivefemale + $suspectedmenegitisofivemale;
                if ($men > 1) {
                    $alertcases .= 'Men/' . $men . ',';
                    
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
                
                $undis = $undismale + $undisfemale + $undismaletwo + $undisfemaletwo;
                if ($undis > 2) {
                    $alertcases .= 'UnDis/' . $undis . '';
                    
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
                
                
                $totalpositive = ($pf + $pv + $pmix);
                if ($totalpositive != 0) {
                    $alertpf = ($pf / $totalpositive) * 100;
                    
                    if ($alertpf > 40) {
                        $alertcases .= 'Pf/' . $pf . '';
                        
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
                        
                        $alertdata = array(
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
                    
                    /**
                    VPD - 1
                    VPD+WBD - 5
                    VPD+VBD - 6
                    WBD - 2
                    WBD+VBD - 7
                    VBD - 3
                    ALL - 4
                    **/
                    //collect the numbers to send from the database	
                    
                    $total_sms = 0;
                    
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
                            //$resp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vpdmessagetext,$vpdzonenumberstosend,$themsgtype,$thedlr);
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
                            //$regresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vpdregmessagetext,$vpdregionnumberstosend,$themsgtype,$thedlr);
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
                           // $wbdzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdzmessagetext,$wbdzonenumberstosend,$themsgtype,$thedlr);
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
                           //$wbdregresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdregmessagetext,$wbdregionnumberstosend,$themsgtype,$thedlr);
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
                            //$vbdzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vbdzmessagetext,$vbdzonenumberstosend,$themsgtype,$thedlr);
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
                           // $wbdregresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vbdregmessagetext,$vbdregionnumberstosend,$themsgtype,$thedlr);
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
                       // $allzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allzmessagetext,$numberstosendzone,$themsgtype,$thedlr);	
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
                        //$allrresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allrmessagetext,$numberstosendregion,$themsgtype,$thedlr);	
                    }
                    
					
					//message for Genever test
					$mymessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
							
                    //update table that alert is sent
                    $updatedata = array(
                        'alert_sent' => 1
                    );
                    $this->db->where('id', $reportingform_id);
                    $this->db->update('reportingforms', $updatedata);
                    
                    $sms_rate  = $systemcredit->sms_rate;
                    $smscost   = $total_sms * $sms_rate;
                    $newamount = ($creditamount - $smscost);
                    /**
                    $updatecredit = array(
                    'amount' => $newamount,
                    );
                    $this->db->where('id', 1);
                    $this->db->update('systemcredit', $updatecredit);
                    
                    **/
                }
                
               
                
            }
            
            
            
            redirect('reportingforms/healthfacility', 'refresh');
        }
    }
    
    public function edit_validate($id)
    {
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $reportingform = $this->reportingformsmodel->get_by_id($id)->row();
        
        $reporting_year = $reportingform->reporting_year;
        $week_no        = $reportingform->week_no;
        
        
        $healthfacility_id = $this->input->post('oldhf_id');
        
        $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
        
        $form_period = $this->reportingformsmodel->get_by_period_hf($reportingperiod->id, $healthfacility_id);
        
        $new_hf_id = $this->input->post('healthfacility_id');
        
        if ($healthfacility_id != $new_hf_id) {
            if (!empty($form_period)) {
                $hf_id = $healthfacility_id;
                $this->session->set_flashdata('alert_message', 'There is data already entered for the period and health facility that you attempted to edit to.');
            } else {
                $hf_id = $this->input->post('hf_id');
                $this->session->set_flashdata('sucsess_message', 'Record successfully updated.');
                
            }
        } else {
            $hf_id = $this->input->post('healthfacility_id');
            $this->session->set_flashdata('sucsess_message', 'Record successfully updated.');
        }
        
        
        $sre  = $this->input->post('sre');
        $pf   = $this->input->post('pf');
        $pv   = $this->input->post('pv');
        $pmix = $this->input->post('pmix');
        
        $totpositive = $pf + $pv + $pmix;
        
        if (isset($_POST['draft_button'])) {
            //save as draft
            $approved_hf = 0;
            $draft       = 1;
            
        } else if (isset($_POST['submit_button'])) {
            $approved_hf = 1;
            $draft       = 0;
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('healthfacility_id', 'Health Facility', 'trim|required');
        /**
        $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
        $this->form_validation->set_rules('reporting_year', 'Reporting year', 'trim|required');
        $this->form_validation->set_rules('reporting_date', 'Reporting date', 'trim|required');
        $this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required');
        $this->form_validation->set_rules('supporting_ngo', 'Supporting ngo', 'trim|required');
        
        $this->form_validation->set_rules('sariufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('sariofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliufivefemale', 'blank', 'trim|required|numeric');	   
        $this->form_validation->set_rules('iliofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('iliofivefemale', 'blank', 'trim|required|numeric');	   
        $this->form_validation->set_rules('awdufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('awdofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('bdofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('oadofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('diphmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('diphfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('wcmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('wcfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('measmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('measfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('nntmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('nntfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('afpmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('afpfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ajsmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ajsfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('vhfmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('vhffemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malufivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malufivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malofivemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('malofivefemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('suspectedmenegitismale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('suspectedmenegitisfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisonedesc', 'blank', 'trim|required');
        $this->form_validation->set_rules('undismale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisfemale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undissecdesc', 'blank', 'trim|required');
        $this->form_validation->set_rules('undismaletwo', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('undisfemaletwo', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ocmale', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('ocfemale', 'blank', 'trim|required|numeric');
        //$this->form_validation->set_rules('total_consultations', 'Total consultations', 'trim|required');
        $this->form_validation->set_rules('sre', 'blank', 'trim|required|numeric|callback__check_Sre['.$totpositive.']');
        $this->form_validation->set_rules('pf', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('pv', 'blank', 'trim|required|numeric');
        $this->form_validation->set_rules('pmix', 'blank', 'trim|required|numeric');
        **/
        //$this->form_validation->set_rules('totalnegative', 'blank', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {
            
            
            $user_id = $this->erkanaauth->getField('id');
            
            $sariufivemale            = $this->input->post('sariufivemale');
            $sariufivefemale          = $this->input->post('sariufivefemale');
            $sariofivemale            = $this->input->post('sariofivemale');
            $sariofivefemale          = $this->input->post('sariofivefemale');
            $iliufivemale             = $this->input->post('iliufivemale');
            $iliufivefemale           = $this->input->post('iliufivefemale');
            $iliofivemale             = $this->input->post('iliofivemale');
            $iliofivefemale           = $this->input->post('iliofivefemale');
            $awdufivemale             = $this->input->post('awdufivemale');
            $awdufivefemale           = $this->input->post('awdufivefemale');
            $awdofivemale             = $this->input->post('awdofivemale');
            $awdofivefemale           = $this->input->post('awdofivefemale');
            $bdufivemale              = $this->input->post('bdufivemale');
            $bdufivefemale            = $this->input->post('bdufivefemale');
            $bdofivemale              = $this->input->post('bdofivemale');
            $bdofivefemale            = $this->input->post('bdofivefemale');
            $oadufivemale             = $this->input->post('oadufivemale');
            $oadufivefemale           = $this->input->post('oadufivefemale');
            $oadofivemale             = $this->input->post('oadofivemale');
            $oadofivefemale           = $this->input->post('oadofivefemale');
            $diphmale                 = $this->input->post('diphmale');
            $diphfemale               = $this->input->post('diphfemale');
			$diphofivemale            = $this->input->post('diphofivemale');
            $diphofivefemale          = $this->input->post('diphofivefemale');
            $wcmale                   = $this->input->post('wcmale');
            $wcfemale                 = $this->input->post('wcfemale');
			$wcofivemale              = $this->input->post('wcofivemale');
            $wcofivefemale            = $this->input->post('wcofivefemale');
            $measmale                 = $this->input->post('measmale');
            $measfemale               = $this->input->post('measfemale');
			$measofviemale            = $this->input->post('measofviemale');
            $measofivefemale          = $this->input->post('measofivefemale');
            $nntmale                  = $this->input->post('nntmale');
            $nntfemale                = $this->input->post('nntfemale');
            $afpmale                  = $this->input->post('afpmale');
            $afpfemale                = $this->input->post('afpfemale');
			$afpofivemale             = $this->input->post('afpofivemale');
            $afpofivefemale           = $this->input->post('afpofivefemale');
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
            $undisonedesc             = $this->input->post('undisonedesc');
            $undismale                = $this->input->post('undismale');
            $undisfemale              = $this->input->post('undisfemale');
            $undissecdesc             = $this->input->post('undissecdesc');
            $undismaletwo             = $this->input->post('undismaletwo');
            $undisfemaletwo           = $this->input->post('undisfemaletwo');
            $ocmale                   = $this->input->post('ocmale');
            $ocfemale                 = $this->input->post('ocfemale');
            
            
            $tot_consultations = $sariufivemale + $sariufivefemale + $sariofivemale + $sariofivefemale + $iliufivemale + $iliufivefemale + $iliofivemale + $iliofivefemale + $awdufivemale + $awdufivefemale + $awdofivemale + $awdofivefemale + $bdufivemale + $bdufivefemale + $bdofivemale + $bdofivefemale + $oadufivemale + $oadufivefemale + $oadofivemale + $oadofivefemale + $diphmale + $diphfemale + $diphofivemale + $diphofivefemale + $wcmale + $wcfemale + $wcofivemale + $wcofivefemale + $measmale + $measfemale + $measofivemale + $measofivefemale + $nntmale + $nntfemale + $afpmale + $afpfemale + $afpofivemale + $afpofivefemale + $ajsmale + $ajsfemale + $vhfmale + $vhffemale + $malufivemale + $malufivefemale + $malofivemale + $malofivefemale + $suspectedmenegitismale + $suspectedmenegitisfemale + $suspectedmenegitisofivemale + $suspectedmenegitisofivefemale + $undismale + $undisfemale + $undismaletwo + $undisfemaletwo + $ocmale + $ocfemale;
            
            $total_consultations = $tot_consultations + $undismale + $undisfemale + $ocmale + $ocfemale;
            
            $sre  = $this->input->post('sre');
            $pf   = $this->input->post('pf');
            $pv   = $this->input->post('pv');
            $pmix = $this->input->post('pmix');
            
            $total_positive = $pf + $pv + $pmix;
            
            $total_negative = $sre - $total_positive;
            
                  
                     
            $data = array(
                'healthfacility_id' => $hf_id,
                'sariufivemale' => $this->input->post('sariufivemale'),
                'sariufivefemale' => $this->input->post('sariufivefemale'),
                'sariofivemale' => $this->input->post('sariofivemale'),
                'sariofivefemale' => $this->input->post('sariofivefemale'),
                'iliufivemale' => $this->input->post('iliufivemale'),
                'iliufivefemale' => $this->input->post('iliufivefemale'),
                'iliofivemale' => $this->input->post('iliofivemale'),
                'iliofivefemale' => $this->input->post('iliofivefemale'),
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
                'undisonedesc' => $this->input->post('undisonedesc'),
                'undismale' => $this->input->post('undismale'),
                'undisfemale' => $this->input->post('undisfemale'),
                'undissecdesc' => $this->input->post('undissecdesc'),
                'undismaletwo' => $this->input->post('undismaletwo'),
                'undisfemaletwo' => $this->input->post('undisfemaletwo'),
                'ocmale' => $this->input->post('ocmale'),
                'ocfemale' => $this->input->post('ocfemale'),
                'total_consultations' => $total_consultations,
                'sre' => $this->input->post('sre'),
                'pf' => $this->input->post('pf'),
                'pv' => $this->input->post('pv'),
                'pmix' => $this->input->post('pmix'),
                'totalnegative' => $total_negative,
                'total_positive' => $total_positive,
                'approved_hf' => $approved_hf,
                'approved_regional' => 0,
                'approved_zone' => 0,
                'edit_date' => $this->input->post('edit_date'),
                'edit_time' => $this->input->post('edit_datetime'),
				'diphofivemale' => $this->input->post('diphofivemale'),
				'diphofivefemale' => $this->input->post('diphofivefemale'),
				'wcofivemale' => $this->input->post('wcofivemale'),
				'wcofivefemale' => $this->input->post('wcofivefemale'),
				'measofivemale' => $this->input->post('measofivemale'),
				'measofivefemale' => $this->input->post('measofivefemale'),
				'afpofivemale' => $this->input->post('afpofivemale'),
				'afpofivefemale' => $this->input->post('afpofivefemale'),
				'suspectedmenegitisofivemale' => $this->input->post('suspectedmenegitisofivemale'),
				'suspectedmenegitisofivefemale' => $this->input->post('suspectedmenegitisofivefemale'),
            );
            $this->db->where('id', $id);
            $this->db->update('reportingforms', $data);
            
			//delet previous consultations
			$this->otherconsultationsmodel->delete_by_reportingform_id($id);
			
			//insert new consultations for the reporting form
						
			if (!empty($_POST['fields'])) {
                foreach ($_POST['fields'] as $rrow => $rid) {
                    
                    $disease = $rid;
                    $male    = $_POST['male'][$rrow];
                    $female  = $_POST['female'][$rrow];
                    
                    $otherconsultdata = array(
                        'reportingform_id' => $id,
                        'disease' => $disease,
                        'malevalue' => $male,
                        'femalevalue' => $female
                    );
                    
                    $this->db->insert('otherconsultations', $otherconsultdata);
                    
                }
            }
            
            $action = 'Edited the reporting form.';
            
            //enter audit trail information
            $auditdata = array(
                'user_id' => $user_id,
                'reportingform_id' => $id,
                'date_of_action' => $this->input->post('edit_datetime'),
                'action' => $action
            );
            $this->db->insert('audittrail', $auditdata);
            
            
            $reporting_form = $this->reportingformsmodel->get_by_id($id)->row();
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($reporting_form->healthfacility_id)->row();
            $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
            $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
            $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
			
			
			            
            $healthfacility_id = $reporting_form->healthfacility_id;
            $user              = $this->usersmodel->get_by_id($reporting_form->user_id)->row();
            
            $reportingform_id = $id;
            
            $reportingperiod_id = $reporting_form->epdcalendar_id;
			
			$reportingperiod = $this->epdcalendarmodel->get_by_id($reporting_form->epdcalendar_id)->row();
			
			$reporting_year = $reportingperiod->epdyear;
            $week_no        = $reportingperiod->week_no;
			
			            
            if (isset($_POST['submit_button'])) {
                
                if ($reportingform->alert_sent == 1) {
                    $this->db->delete('alerts', array(
                        'reportingform_id' => $reportingform_id
                    ));
                }
                
                 $systemcredit = $this->systemcreditmodel->get_by_id(1)->row();
                
                $creditamount         = $systemcredit->amount;
                $dollarrate           = $systemcredit->dollar_rate;
                $amountkenyashillings = $creditamount * $dollarrate;
                
                
                $alertcases = '';
                $vpdcases   = '';
                $wbdcases   = '';
                $vbdcases   = '';
                
                
                //$reportingperiod_id = $reportingperiod->id;
                
                $sari = $sariufivemale + $sariufivefemale + $sariofivemale + $sariofivefemale;
                if ($sari > 0) {
                    $alertcases .= 'SARI/' . $sari . ',';
                    
                    $vpdcases .= 'SARI/' . $sari . ',';
                    
                    $alertdata = array(
                        'reportingform_id' => $reportingform_id,
                        'reportingperiod_id' => $reportingperiod_id,
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
                
                //
                
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
                
                //
                
                
                $awd = $awdufivemale + $awdufivefemale + $awdofivemale + $awdofivefemale;
                if ($awd > 0) {
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
                    
                    $alertdata = array(
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
                //
                
                
                $diph = $diphmale + $diphfemale + $diphofivemale + $diphofivefemale;
                if ($diph > 0) {
                    $alertcases .= 'Diph/' . $diph . ',';
                    $vpdcases .= 'Diph/' . $diph . ',';
                    
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
                
                $wc = $wcmale + $wcfemale + $diphofivemale + $diphofivefemale;
                if ($wc > 4) {
                    $alertcases .= 'WC/' . $wc . ',';
                    $vpdcases .= 'WC/' . $wc . ',';
                    $alertdata = array(
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
                
                $ajs = $ajsmale + $ajsfemale;
                if ($ajs > 4) {
                    $alertcases .= 'AJS/' . $ajs . ',';
                    $wbdcases .= 'AJS/' . $ajs . ',';
                    
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
                
                $undis = $undismale + $undisfemale + $undismaletwo + $undisfemaletwo;
                if ($undis > 2) {
                    $alertcases .= 'UnDis/' . $undis . '';
                    
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
                
                
                $totalpositive = ($pf + $pv + $pmix);
                if ($totalpositive != 0) {
                    $alertpf = ($pf / $totalpositive) * 100;
                    
                    if ($alertpf > 40) {
                        $alertcases .= 'Pf/' . $pf . '';
                        
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
                        
                        $alertdata = array(
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
                    
                    /**
                    VPD - 1
                    VPD+WBD - 5
                    VPD+VBD - 6
                    WBD - 2
                    WBD+VBD - 7
                    VBD - 3
                    ALL - 4
                    **/
                    //collect the numbers to send from the database	
                    
                    $total_sms = 0;
                    
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
                            //$resp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vpdmessagetext,$vpdzonenumberstosend,$themsgtype,$thedlr);
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
                            //$regresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vpdregmessagetext,$vpdregionnumberstosend,$themsgtype,$thedlr);
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
                            //$wbdzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdzmessagetext,$wbdzonenumberstosend,$themsgtype,$thedlr);
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
                            //$wbdregresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$wbdregmessagetext,$wbdregionnumberstosend,$themsgtype,$thedlr);
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
                            //$vbdzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vbdzmessagetext,$vbdzonenumberstosend,$themsgtype,$thedlr);
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
                            //$wbdregresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$vbdregmessagetext,$vbdregionnumberstosend,$themsgtype,$thedlr);
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
                        //$allzresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allzmessagetext,$numberstosendzone,$themsgtype,$thedlr);	
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
                        //$allrresp = $this->Submit($thehost,$theport,$uname,$pword,$sender,$allrmessagetext,$numberstosendregion,$themsgtype,$thedlr);	
                    }
                    
					
					//message for Genever test
					$mymessagetext = "Zone: " . $zone->zone . "\n District: " . $district->district . "\n Health facility: " . $healthfacility->health_facility . "\n Week/Year: " . $week_no . "/" . $reporting_year . "\n Period: " . $reportingperiod->from . " to " . $reportingperiod->to . "\n --------------------\n Alerts/Cases: " . $alertcases . "\n Reported by: " . $user->username . "\n Phone No: " . $healthfacility->contact_number . "
							";
							
                    //update table that alert is sent
                    $updatedata = array(
                        'alert_sent' => 1
                    );
                    $this->db->where('id', $reportingform_id);
                    $this->db->update('reportingforms', $updatedata);
                    
                    $sms_rate  = $systemcredit->sms_rate;
                    $smscost   = $total_sms * $sms_rate;
                    $newamount = ($creditamount - $smscost);
                    /**
                    $updatecredit = array(
                    'amount' => $newamount,
                    );
                    $this->db->where('id', 1);
                    $this->db->update('systemcredit', $updatecredit);
                    
                    **/
                }
            }
            
            redirect('reportingforms', 'refresh');
        }
    }
    
    
    public function _check_Sre($sre, $params)
    {
        
        list($totpositive) = explode(',', $params);
        
        
        
        if ($totpositive > $sre) {
            $this->form_validation->set_message('_check_Sre', 'Positive cases must be less than slides/RDTs examined i.e. ' . $sre);
            return FALSE;
        }
        
        return TRUE;
        
    }
    
    public function _check_Period($year, $params)
    {
        
        list($issaved) = explode(',', $params);
        
        
        if ($issaved == 1) {
            $this->form_validation->set_message('_check_Period', 'There is data entered for that period and health facillity.');
            return FALSE;
        }
        
        return TRUE;
        
    }
    
    public function getperiodbyhf()
    {
        $week_no           = trim(addslashes(htmlspecialchars(rawurldecode($_POST['week_no']))));
        $reporting_year    = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
        $healthfacility_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['healthfacility_id']))));
        if (empty($week_no)) {
            //echo '<div class="alert alert-danger">Please select the Week No.</div>';
        } else if (empty($reporting_year)) {
            //echo '<div class="alert alert-danger">Please select the Reporting year</div>';
        } else {
            $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
            
            if (empty($reportingperiod)) {
                echo 'No reporting period added';
            } else {
                
                $reportperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
                
                
                $reportingform = $this->reportingformsmodel->get_by_period_hf($reportperiod->id, $healthfacility_id);
                
                if (!empty($reportingform)) {
                    foreach ($reportingform as $key => $reportingform) {
                        if ($reportingform['draft'] == 1) {
                           // echo '<strong><font color="#FF0000">The reporting period for this health facility has been captured as a draft previously, please use "Edit Form" to "submit data".</font></strong>';
                        } else {
                            echo '<strong><font color="#FF0000">The reporting period for this health facility has been captured. Please enter another period.</font></strong>';
                        }
                    }
                    
                    echo '<input type="hidden" name="period_check" id="period_check" value="1">';
                } else {
                    echo '<strong>' . date("d F Y", strtotime($reportingperiod->from)) . ' to  ' . date("d F Y", strtotime($reportingperiod->to)) . '</strong>';
                    echo '<input type="hidden" name="period_check" id="period_check" value="0">';
                }
                
                
            }
        }
    }
    
    public function getperiod()
    {
        $week_no        = trim(addslashes(htmlspecialchars(rawurldecode($_POST['week_no']))));
        $reporting_year = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
        
        if (empty($week_no)) {
            //echo '<div class="alert alert-danger">Please select the Week No.</div>';
        } else if (empty($reporting_year)) {
            //echo '<div class="alert alert-danger">Please select the Reporting year</div>';
        } else {
            $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
            
            if (empty($reportingperiod)) {
                echo 'No reporting period added';
            } else {
                
                //echo ' <input type="text" readonly="" name="reporting_period" id="reporting_period" value="'.$reportingperiod->from.' to  '.$reportingperiod->to.'">';
                echo '<strong>' . date("d F Y", strtotime($reportingperiod->from)) . ' to  ' . date("d F Y", strtotime($reportingperiod->to)) . '</strong>';
            }
        }
    }
    
    function gethealthfacilities()
    {
        $district_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
        
        $healthfailities = $this->healthfacilitiesmodel->get_by_district($district_id);
        
        $district = $this->districtsmodel->get_by_id($district_id)->row();
        
        
        $level = $this->erkanaauth->getField('level');
        
        $facilityselect = '<select name="healthfacility_id" id="healthfacility_id">';
        
        if (!empty($healthfailities)) {
            foreach ($healthfailities as $key => $healthfacility) {
                $facilityselect .= '<option value="' . $healthfacility['id'] . '">' . $healthfacility['health_facility'] . '</option>';
            }
        } else {
			 $facilityselect .= '<option value="">No Health Facility</option>';
			/**
            if ($level == 2) {
                $region_id           = $this->erkanaauth->getField('region_id');
                $region              = $this->regionsmodel->get_by_id($region_id)->row();
                $healthfailitiesdata = $this->healthfacilitiesmodel->get_by_region($region->id);
                foreach ($healthfailitiesdata->result() as $healthfailitiesdatum) {
                    $facilityselect .= '<option value="' . $healthfailitiesdatum->healthfacility_id . '">' . $healthfailitiesdatum->health_facility . '</option>';
                }
                
            } else {
                $healthfailitiesdata = $this->healthfacilitiesmodel->get_list();
                foreach ($healthfailitiesdata as $hkey => $healthfailitiesdatum) {
                    $facilityselect .= '<option value="' . $healthfailitiesdatum['id'] . '">' . $healthfailitiesdatum['health_facility'] . '</option>';
                }
            }
			
			**/
        }
        
        $facilityselect .= '</select>';
        
        echo $facilityselect;
        
    }
    
    public function getreportdetails()
    {
        $reporting_year    = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
        $week_no           = trim(addslashes(htmlspecialchars(rawurldecode($_POST['week_no']))));
        $district_id       = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
        $healthfacility_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['healthfacility_id']))));
        
        $level = $this->erkanaauth->getField('level');
        
        if (empty($reporting_year) || empty($week_no) || empty($healthfacility_id)) {
            echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">Please select all the required data</div></td></tr>
                              </tbody>
                            </table>';
        } else {
            $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
            
            if (empty($reportingperiod)) {
                echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">No reporting period added</div></td></tr>
                              </tbody>
                            </table>';
            } else {
                $reportingform = $this->reportingformsmodel->get_by_reporting_period_hf($reportingperiod->id, $healthfacility_id)->row();
                
                if (empty($reportingform)) {
                    echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">No data available on the selected period.</div></td></tr>
                              </tbody>
                            </table>';
                } else {
                    $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
                    $dist_id        = $healthfacility->district_id;
                    
                    $healthfacilities = $this->healthfacilitiesmodel->get_by_district($dist_id);
					
                    
                    $edittable = '<table id="customers">
                             <tbody>';
                    
                    //if($reportingform->approved_hf==1)
                    if ($reportingform->approved_regional == 1) {
                        $edittable .= '<tr><td colspan="3">	<p class="alert alert-info">
													This form has been submitted and has been validated, therefore you can only view but you cannot edit it.
												</p>
			</td></tr>';
                    }
                    
                    if ($level == 3) {
                        $edittable .= '							
								<tr><td><input type="hidden" name="hf_id" id="hf_id" value="' . $healthfacility_id . '"></td><td colspan="2">&nbsp;</td></tr>';
                    } else {
                        
                        $edittable .= '	
												
								<tr class="alt"><td>Change health facility</td><td colspan="2">&nbsp;</td></tr>
								 <tr><td>Health Facility</td><td>';
                        $edittable .= '<select name="hf_id" id="hf_id">';
                        foreach ($healthfacilities as $key => $healthfacility) {
                            if ($healthfacility['id'] == $healthfacility_id) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
                            $edittable .= '<option value="' . $healthfacility['id'] . '" ' . $selected . '>' . $healthfacility['health_facility'] . '</option>';
                        }
                        $edittable .= '</select>';
                        $edittable .= '</td><td colspan="2"></td></tr>';
                    }
                    
                    $edittable .= '<tr><th colspan="2">Health Events Under Surveillance</th><th colspan="2">Total Cases</th></tr>
                              
                               <tr class="alt"><td valign="top">Respiratory Diseases</td><td valign="top">Male</td><td valign="top">Female</td></tr>';
                    
                    $edittable .= '<tr><td >Severe acute respiratory infection <5yr</td><td><input type="text" name="sariufivemale" id="sariufivemale" value="' . $reportingform->sariufivemale . '" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" ></td><td><input type="text" name="sariufivefemale" id="sariufivefemale" value="' . $reportingform->sariufivefemale . '">
							   <input type="hidden" name="id" id="id" value="' . $reportingform->id . '">
							   </td></tr>';
                    
                    $edittable .= '<tr><td >Severe acute respiratory infection >5yr</td><td><input type="text" name="sariofivemale" id="sariofivemale" value="' . $reportingform->sariofivemale . '"></td><td><input type="text" name="sariofivefemale" id="sariofivefemale" value="' . $reportingform->sariofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Influenza like illnesses <5yr</td><td><input type="text" name="iliufivemale" id="iliufivemale" value="' . $reportingform->iliufivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="iliufivefemale" id="iliufivefemale" value="' . $reportingform->iliufivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Influenza like illnesses >5yr</td><td><input type="text" name="iliofivemale" id="iliofivemale" value="' . $reportingform->iliofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="iliofivefemale" id="iliofivefemale" value="' . $reportingform->iliofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    
                    $edittable .= '<tr class="alt"><td valign="top" colspan="3">Gastro Intestinal Tract Disease</td></tr>';
                    $edittable .= '<tr><td >Acute Watery Diarrhea/Sus.Cholera <5yr</td><td><input type="text" name="awdufivemale" id="awdufivemale" value="' . $reportingform->awdufivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="awdufivefemale" id="awdufivefemale" value="' . $reportingform->awdufivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Acute Watery Diarrhea/Sus.Cholera >5yr</td><td><input type="text" name="awdofivemale" id="awdofivemale" value="' . $reportingform->awdofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="awdofivefemale" id="awdofivefemale" value="' . $reportingform->awdofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Bloody Diarrhea/Sus.Shigellosis <5yr</td><td><input type="text" name="bdufivemale" id="bdufivemale" value="' . $reportingform->bdufivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="bdufivefemale" id="bdufivefemale" value="' . $reportingform->bdufivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Bloody Diarrhea/Sus.Shigellosis >5yr</td><td><input type="text" name="bdofivemale" id="bdofivemale" value="' . $reportingform->bdofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="bdofivefemale" id="bdofivefemale" value="' . $reportingform->bdofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Other Acute Diarrhea <5yr</td><td><input type="text" name="oadufivemale" id="oadufivemale" value="' . $reportingform->oadufivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="oadufivefemale" id="oadufivefemale" value="' . $reportingform->oadufivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Other Acute Diarrhea >5yr</td><td><input type="text" name="oadofivemale" id="oadofivemale" value="' . $reportingform->oadofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="oadofivefemale" id="oadofivefemale" value="' . $reportingform->oadofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr class="alt"><td valign="top" colspan="3">Vaccine Preventable Diseases</td></tr>';
                    $edittable .= '<tr><td >Suspected Diphtheria <5yr</td><td><input type="text" name="diphmale" id="diphmale" value="' . $reportingform->diphmale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="diphfemale" id="diphfemale" value="' . $reportingform->diphfemale . '"></td></tr>';
					
                    $edittable .= '<tr><td >Suspected Diphtheria >5yr</td><td><input type="text" name="diphofivemale" id="diphofivemale" value="' . $reportingform->diphofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="diphofivefemale" id="diphofivefemale" value="' . $reportingform->diphofivefemale . '"></td></tr>';
					
                    $edittable .= '<tr><td >Suspected Whooping Cough <5yr</td><td><input type="text" name="wcmale" id="wcmale" value="' . $reportingform->wcmale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="wcfemale" id="wcfemale" value="' . $reportingform->wcfemale . '"></td></tr>';
					
					$edittable .= '<tr><td >Suspected Whooping Cough >5yr</td><td><input type="text" name="wcofivemale" id="wcofivemale" value="' . $reportingform->wcofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="wcofivefemale" id="wcofivefemale" value="' . $reportingform->wcofivefemale . '"></td></tr>';
					
                    $edittable .= '<tr><td >Suspected Measles <5yr</td><td><input type="text" name="measmale" id="measmale" value="' . $reportingform->measmale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="measfemale" id="measfemale" value="' . $reportingform->measfemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
					$edittable .= '<tr><td >Suspected Measles >5yr</td><td><input type="text" name="measofivemale" id="measofivemale" value="' . $reportingform->measofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="measofivefemale" id="measofivefemale" value="' . $reportingform->measofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
					
                    $edittable .= '<tr><td >Neonatal Tetanus</td><td><input type="text" name="nntmale" id="nntmale" value="' . $reportingform->nntmale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="nntfemale" id="nntfemale" value="' . $reportingform->nntfemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
                    $edittable .= '<tr><td >Acute Flaccid Paralysis <5yr</td><td><input type="text" name="afpmale" id="afpmale" value="' . $reportingform->afpmale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="afpfemale" id="afpfemale" value="' . $reportingform->afpfemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
					$edittable .= '<tr><td >Acute Flaccid Paralysis >5yr</td><td><input type="text" name="afpofivemale" id="afpofivemale" value="' . $reportingform->afpofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="afpofivefemale" id="afpofivefemale" value="' . $reportingform->afpofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
					
                    $edittable .= '<tr class="alt"><td valign="top" colspan="4">Other Communicable Diseases</td></tr>';
                    
                    $edittable .= '<tr><td >Suspected Acute Jaundice Syndrome</td><td><input type="text" name="ajsmale" id="ajsmale" value="' . $reportingform->ajsmale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="ajsfemale" id="ajsfemale" value="' . $reportingform->ajsfemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Suspected Viral Hemorrhagic Fever</td><td><input type="text" name="vhfmale" id="vhfmale" value="' . $reportingform->vhfmale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="vhffemale" id="vhffemale" value="' . $reportingform->vhffemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Confirmed Malaria <5yr</td><td><input type="text" name="malufivemale" id="malufivemale" value="' . $reportingform->malufivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="malufivefemale" id="malufivefemale" value="' . $reportingform->malufivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td >Confirmed Malaria >5yr</td><td><input type="text" name="malofivemale" id="malofivemale" value="' . $reportingform->malofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="malofivefemale" id="malofivefemale" value="' . $reportingform->malofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
                    $edittable .= '<tr><td>Suspected Meningitis <5yr</td><td><input type="text" name="suspectedmenegitismale" id="suspectedmenegitismale" value="' . $reportingform->suspectedmenegitismale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="suspectedmenegitisfemale" id="suspectedmenegitisfemale" value="' . $reportingform->suspectedmenegitisfemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
					$edittable .= '<tr><td>Suspected Meningitis >5yr</td><td><input type="text" name="suspectedmenegitisofivemale" id="suspectedmenegitisofivemale" value="' . $reportingform->suspectedmenegitisofivemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="suspectedmenegitisofivefemale" id="suspectedmenegitisofivefemale" value="' . $reportingform->suspectedmenegitisofivefemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
					
                    $edittable .= '<tr class="alt"><td valign="top" colspan="3">Other Unusual Diseases or Deaths</td></tr>';
                    $edittable .= '<tr><td><input type="text" name="undisonedesc" id="undisonedesc" value="' . $reportingform->undisonedesc . '"></td><td><input type="text" name="undismale" id="undismale" value="' . $reportingform->undismale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="undisfemale" id="undisfemale" value="' . $reportingform->undisfemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td><input type="text" name="undissecdesc" id="undissecdesc" value="' . $reportingform->undissecdesc . '" ></td><td><input type="text" name="undismaletwo" id="undismaletwo" value="' . $reportingform->undismaletwo . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td><input type="text" name="undisfemaletwo" id="undisfemaletwo" value="' . $reportingform->undisfemaletwo . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
					
					/**$edittable .= '<tr><td colspan="4"> <div id="container">
            <p id="add_field"><a href="javascript:void(0)" class="btn btn-success"><span>Add Fields</span></a></p>
        </div></td></tr>';**/
		$edittable .= '<tr><td colspan="4"> <div id="dynamicInput">

</div>
<input type="button" value="Add Fields" onClick="addInput(\'dynamicInput\');" class="btn btn-success"></td></tr>';
					
                    $edittable .= '<tr><td>Other Consultations</td><td><input type="text" name="ocmale" id="ocmale" value="' . $reportingform->ocmale . '"></td><td><input type="text" name="ocfemale" id="ocfemale" value="' . $reportingform->ocfemale . '" onkeypress="return isNumberKey(event)" maxlength="5"></td></tr>';
                    $edittable .= '<tr><td>Total Consultations</td><td><input type="text" name="total_consultations" id="total_consultations" value="' . $reportingform->total_consultations . '" readonly ="readonly"></td><td><input type="button" value="CALCULATE" onClick="CalcConsultations()" >&nbsp;</td></tr>';
                    $edittable .= '<tr class="alt"><td valign="top" colspan="3">Malaria Tests</td></tr>';
                    $edittable .= '<tr><td>Slides/RDT examined</td><td><input type="text" name="sre" id="sre" value="' . $reportingform->sre . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td>&nbsp;</td></tr>';
                    $edittable .= '<tr><td>Falciparum positive</td><td><input type="text" name="pf" id="pf" value="' . $reportingform->pf . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td>&nbsp;</td></tr>';
                    $edittable .= '<tr><td>Vivax positive</td><td><input type="text" name="pv" id="pv" value="' . $reportingform->pv . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td>&nbsp;</td></tr>';
                    $edittable .= '<tr><td>Mixed positive</td><td><input type="text" name="pmix" id="pmix" value="' . $reportingform->pmix . '" onkeypress="return isNumberKey(event)" maxlength="5"></td><td>&nbsp;</td></tr>';
                    
                    
                    $edittable .= '</tbody>
                            </table>';
                    
                    //if($reportingform->approved_hf==1)
                    if ($reportingform->approved_regional == 1) {
                        //do not show submit buttons
                    } else {
                        $edittable .= '<div class="form-actions"><input type="submit" name="draft_button" value="save to draft only" class="btn" onClick="return(draftvalidate())" />
&nbsp; &nbsp; &nbsp;
<input type="submit" name="submit_button" value="Submit report" class="btn btn-info" onClick="return(validate())" /></div>';
                    }
                    
                    echo $edittable;
                }
            }
        }
    }
    
    public function delete($id)
    {
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $this->db->delete('reportingforms', array(
            'id' => $id
        ));
        redirect('reportingforms', 'refresh');
    }
	
	 function getalldistricts()
    {
        $region_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['region_id']))));
        
        $districts = $this->districtsmodel->get_by_region($region_id);
        
        $districtselect = '<select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">';
       // $districtselect .= '<option value="">Select District</option>';
        //$districtselect .= '<option value="0">-All Districts-</option>';
        
        if (!empty($districts)) {
            foreach ($districts as $key => $district) {
                $districtselect .= '<option value="' . $district['id'] . '">' . $district['district'] . '</option>';
            }
        } else {
            if (getRole() == 'SuperAdmin') {
                $districts = $this->districtsmodel->get_list();
                foreach ($districts as $key => $district) {
                    $districtselect .= '<option value="' . $district['id'] . '">' . $district['district'] . '</option>';
                }
            } else {
                $districts = $this->districtsmodel->get_by_region($region_id);
                foreach ($districts as $key => $district) {
                    $districtselect .= '<option value="' . $district['id'] . '">' . $district['district'] . '</option>';
                }
            }
        }
        
        $districtselect .= '</select>';
        
        echo $districtselect;
    }
    
    function getdistricts()
    {
        $region_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['region_id']))));
        
        $districts = $this->districtsmodel->get_by_region($region_id);
		
		$user_country_id = $this->erkanaauth->getField('country_id');
        $user_country = $this->countriesmodel->get_by_id($user_country_id)->row();
        
        $districtselect = '<select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">';
        $districtselect .= '<option value="">Select '.$user_country->third_admin_level_label.'</option>';
        $districtselect .= '<option value="">-All '.$user_country->third_admin_level_label.'-</option>';
        
        if (!empty($districts)) {
            foreach ($districts as $key => $district) {
                $districtselect .= '<option value="' . $district['id'] . '">' . $district['district'] . '</option>';
            }
        } else {
			
			 $districtselect .= '<option value="">No records</option>';
			/**
            if (getRole() == 'SuperAdmin') {
                $districts = $this->districtsmodel->get_list();
                foreach ($districts as $key => $district) {
                    $districtselect .= '<option value="' . $district['id'] . '">' . $district['district'] . '</option>';
                }
            } else {
                $districts = $this->districtsmodel->get_by_region($region_id);
                foreach ($districts as $key => $district) {
                    $districtselect .= '<option value="' . $district['id'] . '">' . $district['district'] . '</option>';
                }
            }
			
			**/
        }
        
        $districtselect .= '</select>';
        
        echo $districtselect;
    }
	
	public function moverecords()
	{
		
		$records = $this->reportingformsmodel->get_list();
		
		//$table = '<table border="1">';
		
		
		$diseases = $this->diseasesmodel->get_list();
		
		foreach($records as $key=>$record):
		
		/**
		$table .= '<tr><td>'.$record['week_no'].'</td><td>'.$record['reporting_year'].'</td><td>'.$record['reporting_date'].'</td><td>'.$record['epdcalendar_id'].'</td><td>'.$record['user_id'].'</td><td>'.$record['healthfacility_id'].'</td><td>'.$record['contact_number'].'</td><td>'.$record['health_facility_code'].'</td><td>'.$record['supporting_ngo'].'</td><td>'.$record['region_id'].'</td><td>'.$record['undisonedesc'].'</td><td>'.$record['undismale'].'</td><td>'.$record['undisfemale'].'</td><td>'.$record['undissecdesc'].'</td><td>'.$record['undismaletwo'].'</td><td>'.$record['undisfemaletwo'].'</td><td>'.$record['ocmale'].'</td><td>'.$record['ocfemale'].'</td><td>'.$record['total_consultations'].'</td><td>'.$record['sre'].'</td><td>'.$record['pf'].'</td><td>'.$record['pv'].'</td><td>'.$record['pmix'].'</td><td>'.$record['totalnegative'].'</td><td>'.$record['total_positive'].'</td></tr>';
		**/
		
		$healthfacility = $this->healthfacilitiesmodel->get_by_id($record['healthfacility_id'])->row();
        $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        $region = $this->regionsmodel->get_by_id($district->region_id)->row();
		$zone = $this->zonesmodel->get_by_id($region->zone_id)->row();
		
		$data = array(
               'week_no' => $record['week_no'],
               'reporting_year' => $record['reporting_year'],
               'reporting_date' => $record['reporting_date'],
               'epicalendar_id' => $record['epdcalendar_id'],
               'user_id' => $record['user_id'],
               'healthfacility_id' => $record['healthfacility_id'],
               'district_id' => $district->id,
               'region_id' => $region->id,
               'zone_id' => $zone->id,
               'contact_number' => $record['contact_number'],
               'supporting_ngo' => $record['supporting_ngo'],
			   'undisonedesc' => $record['undisonedesc'],
               'undismale' => $record['undismale'],
               'undisfemale' => $record['undisfemale'],
               'undissecdesc' => $this->input->post('undissecdesc'),
               'undismaletwo' => $this->input->post('undismaletwo'),
               'undisfemaletwo' => $this->input->post('undisfemaletwo'),
               'ocmale' => $record['ocmale'],
               'ocfemale' => $record['ocfemale'],
               'total_consultations' => $record['total_consultations'],
               'sre' => $record['sre'],
               'pf' => $record['pf'],
			   'pv' => $record['pv'],
               'pmix' => $record['pmix'],
               'total_positive' => $record['total_positive'],
               'total_negative' => $record['totalnegative'],
               'approved_dist' => 1,
               'approved_region' => 1,
               'approved_zone' => 1,
			   'approved_national' => 1,
               'draft' => 0,
               'alert_sent' => 1,
               'entry_date' => $record['entry_date'],
               'entry_time' => $record['entry_time'],
               'edit_date' => $record['edit_date'],
               'edit_time' => $record['edit_time'],
           );
           $this->db->insert('forms', $data);
		   
		   
		   $form_id = $this->db->insert_id();//get the ID of the saved record
		   
		   /**
		   SARI
		   ILI
		   AWD
		   BD
		   OAD
		   Diph
		   WC
		   MEAS
		   NNT
		   AFP
		   AJS
		   VHF
		   Mal
		   Men
		   */
		   
		   foreach($diseases as $key=>$disease):
		   
			   if($disease['disease_code']== 'SARI')
			   {
				   $male_under_five = $record['sariufivemale'];
				   $female_under_five = $record['sariufivefemale'];
				   $male_over_five = $record['sariofivemale'];
				   $female_over_five = $record['sariofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'ILI')
			   {
				   $male_under_five = $record['iliufivemale'];
				   $female_under_five = $record['iliufivefemale'];
				   $male_over_five = $record['iliofivemale'];
				   $female_over_five = $record['iliofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'AWD')
			   {
				   $male_under_five = $record['awdufivemale'];
				   $female_under_five = $record['awdufivefemale'];
				   $male_over_five = $record['awdofivemale'];
				   $female_over_five = $record['awdofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'BD')
			   {
				   $male_under_five = $record['bdufivemale'];
				   $female_under_five = $record['bdufivefemale'];
				   $male_over_five = $record['bdofivemale'];
				   $female_over_five = $record['bdofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'OAD')
			   {
				   $male_under_five = $record['oadufivemale'];
				   $female_under_five = $record['oadufivefemale'];
				   $male_over_five = $record['oadofivemale'];
				   $female_over_five = $record['oadofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'Diph')
			   {
				   $male_under_five = $record['diphmale'];
				   $female_under_five = $record['diphfemale'];
				   $male_over_five = $record['diphofivemale'];
				   $female_over_five = $record['diphofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'WC')
			   {
				   $male_under_five = $record['wcmale'];
				   $female_under_five = $record['wcfemale'];
				   $male_over_five = $record['wcofivemale'];
				   $female_over_five = $record['wcofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			    if($disease['disease_code']== 'Meas')
			   {
				   $male_under_five = $record['measmale'];
				   $female_under_five = $record['measfemale'];
				   $male_over_five = $record['measofivemale'];
				   $female_over_five = $record['measofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'NNT')
			   {
				   $male_under_five = $record['nntmale'];
				   $female_under_five = $record['nntfemale'];
				   $male_over_five = 0;
				   $female_over_five = 0;
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			    if($disease['disease_code']== 'AFP')
			   {
				   $male_under_five = $record['afpmale'];
				   $female_under_five = $record['afpfemale'];
				   $male_over_five = $record['afpofivemale'];
				   $female_over_five = $record['afpofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			    if($disease['disease_code']== 'AJS')
			   {
				   $male_under_five = $record['ajsmale'];
				   $female_under_five = $record['ajsfemale'];
				   $male_over_five = 0;
				   $female_over_five = 0;
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'VHF')
			   {
				   $male_under_five = $record['vhfmale'];
				   $female_under_five = $record['vhffemale'];
				   $male_over_five = 0;
				   $female_over_five = 0;
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'Mal')
			   {
				   $male_under_five = $record['malufivemale'];
				   $female_under_five = $record['malufivefemale'];
				   $male_over_five = $record['malofivemale'];
				   $female_over_five = $record['malofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   if($disease['disease_code']== 'Men')
			   {
				   $male_under_five = $record['suspectedmenegitismale'];
				   $female_under_five = $record['suspectedmenegitisfemale'];
				   $male_over_five = $record['suspectedmenegitisofivemale'];
				   $female_over_five = $record['suspectedmenegitisofivefemale'];
				   $total_under_five = $male_under_five + $female_under_five;
				   $total_over_five = $male_over_five + $female_over_five;
				   $total_disease = $total_under_five + $total_over_five;
			   }
			   
			   $formdata = array(
				   'form_id' => $form_id,
				   'epicalendar_id' => $record['epdcalendar_id'],
				   'healthfacility_id' => $record['healthfacility_id'],
				   'district_id' => $district->id,
				   'region_id' => $region->id,
				   'zone_id' => $zone->id,
				   'disease_id' => $disease['id'],
				   'disease_name' => $disease['disease_code'],
				   'male_under_five' => $male_under_five,
				   'female_under_five' => $female_under_five,
				   'male_over_five' => $male_over_five,
				   'female_over_five' => $female_over_five,
				   'total_under_five' => $total_under_five,
				   'total_over_five' => $total_over_five,
				   'total_disease' => $total_disease,
				   );
				   
				   $this->db->insert('formsdata', $formdata);
				   
				   
				   $male_under_five = NULL;
				   $female_under_five = NULL;
				   $male_over_five = NULL;
				   $female_over_five = NULL;
				   $total_under_five = NULL;
				   $total_over_five = NULL;
				   $total_disease = NULL;
				   
				endforeach;
		   
			$alerts = $this->alertsmodel->get_list_by_form($form_id);
			
			foreach($alerts as $key=>$alert)
			{
				$data = array(
				   'reportingform_id' => $form_id,
				   'reportingperiod_id' => $record['epdcalendar_id'],
				   'disease_id' => $this->input->post('disease_id'),
				   'disease_name' => $alert['disease_name'],
				   'healthfacility_id' => $alert['healthfacility_id'],
				   'district_id' => $alert['district_id'],
				   'region_id' => $alert['region_id'],
				   'zone_id' => $alert['zone_id'],
				   'cases' => $alert['cases'],
				   'deaths' => $alert['deaths'],
				   'notes' => $alert['notes'],
				   'verification_status' => $alert['verification_status'],
				   'include_bulletin' => $alert['include_bulletin'],
				   'outcome' => $alert['outcome'],
			   );
			   $this->db->insert('formalerts', $data);
			}
			
			$healthfacility = NULL;
			$district = NULL;
			$region = NULL;
			$zone = NULL;
		
		endforeach;
		
		//$table .= '</table>';
		
		//echo $table;

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
	
	
	public function getcolumns()
	{
		
		$tables = $this->reportingformsmodel->get_columns();
	   
	   foreach($tables as $key=>$table)
	   {
		   //echo $table->Field.'<br>';
		   
		   echo 'var '.$table->Field.';<br>';
		   /**
		   echo 'if( document.frm.'.$table->Field.'.value == "" )<br>';
		    echo '{<br>';
			 echo '&nbsp;&nbsp;'.$table->Field.' =0;<br>';
		   echo '}<br>';
		   echo 'else<br>';
		   echo '{<br>';
			   echo '&nbsp;&nbsp;'.$table->Field.' = parseInt(document.frm.'.$table->Field.'.value);<br>
		   }<br><br>';
		   
		   **/
	   }		
	}
    
}
