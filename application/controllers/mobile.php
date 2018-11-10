<?php

class Mobile extends CI_Controller
{
	    
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
		/**
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }      
        
        $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
		$country_id = $this->erkanaauth->getField('country_id');
		
		**/
		
		$healthfacility_id = 1;
		$country_id = 1;
		
					
		if(empty($healthfacility_id)|| $healthfacility_id==0)
		{
			redirect('mobile/logout','refresh');
		}
		
		$healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        
        $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
        
        $region = $this->regionsmodel->get_by_id($district->region_id)->row();
        
        $data['district'] = $district;
		
		$diseasecategories = $this->diseasecategoriesmodel->get_list();
		$disease_element = array();
		foreach($diseasecategories as $key=>$diseasecategory):
		
		$disease_element[] = $diseasecategory['id'];
		
		endforeach;
		
		$first = reset($disease_element);
        $last = end($disease_element);
		
		$diseasecount = $this->diseasesmodel->get_country_list($country_id);
	    $country_diseases = count($diseasecount);
	
	  
	    $data['first'] = $first;
		$data['last'] = $last;
		
		$data['diseasecategories'] = $diseasecategories;
		$data['country_diseases'] = $country_diseases;
		
		$data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id));
		
		$data['country_id'] = $country_id;
        
        $data['healthfacility_id'] = $healthfacility_id;
        $data['region']            = $this->regionsmodel->get_by_id($region->id)->row();
        
        $data['districts'] = $this->districtsmodel->get_by_region($region->id);
        
        $data['healthfacility'] = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
        
        $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
		
		$data['sucsess_message'] = $this->session->flashdata('sucsess_message');
        
        $this->load->view('mobile/form', $data);
		
	}
	
	function add_validate()
	{
	  if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   //ensure that the reporting period is not entered twice
		$country_id = $this->erkanaauth->getField('country_id');
        $reporting_year  = $this->input->post('reporting_year');
        $week_no         = $this->input->post('week_no');
		$healthfacility_id = $this->input->post('healthfacility_id');
		
        $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$week_no,$country_id)->row();
        
        if (!empty($reportingperiod)) {
            $reportingperiod_id = $reportingperiod->id;
        } else {
            $reportingperiod_id = 0;
        }
		
		$reportingform = $this->formsmodel->get_by_period_hf($reportingperiod->id, $healthfacility_id);
        
        if (!empty($reportingform)) {
            $iscaptured = 1;
			redirect('mobile/home', 'refresh');
        } else {
            $iscaptured = 0;
        }
		
		//load the validation library
       $this->load->library('form_validation');
       $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
       $this->form_validation->set_rules('reporting_year', 'Reporting year', 'trim|required|callback__check_Period[' . $iscaptured . ']');
       $this->form_validation->set_rules('healthfacility_id', 'Health facility', 'trim|required');
	   $this->form_validation->set_rules('disease_check', 'No Disease Submitted', 'trim|required');
       
	  //if all validation rules are not met then load the form else save records to the database
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
		   
		   $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
           $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
           $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   
		   //get the user ID of the currently logged in user
			$user_id = $this->erkanaauth->getField('id');
            
            $user = $this->usersmodel->get_by_id($user_id)->row();
			
			$sre  = $this->input->post('sre');
            $pf   = $this->input->post('pf');
            $pv   = $this->input->post('pv');
            $pmix = $this->input->post('pmix');
            
            $total_positive = $pf + $pv + $pmix;
            
            $total_negative = $sre - $total_positive;
			
			$undismale                = $this->input->post('undismale');
            $undisfemale              = $this->input->post('undisfemale');
            $undismaletwo             = $this->input->post('undismaletwo');
            $undisfemaletwo           = $this->input->post('undisfemaletwo');
            $ocmale                   = $this->input->post('ocmale');
            $ocfemale                 = $this->input->post('ocfemale');
			
			$total_consultations = ($undismale+$undisfemale+$undismaletwo+$undisfemaletwo+$ocmale+$ocfemale);
			
			$diseases = $this->db->get_where('diseases', array('country_id' => $country_id));
		   
		   foreach ($diseases->result() as $disease):
		   
		    	$male_under_five = $this->input->post(''.$disease->disease_code.'_ufive_male');
				$female_under_five = $this->input->post(''.$disease->disease_code.'_ufive_female');
				$male_over_five = $this->input->post(''.$disease->disease_code.'_ofive_male');
				$female_over_five = $this->input->post(''.$disease->disease_code.'_ofive_female');
			
				$total_under_five = ($male_under_five + $female_under_five);
				$total_over_five = ($male_over_five + $female_over_five);
				$total_disease = ($total_under_five + $total_over_five);
				
				
				$total_consultations = ($total_under_five+$total_over_five+$total_disease);
				
				
		   endforeach;
			
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
               'contact_number' => $user->contact_number,
               'supporting_ngo' => 'WHO',
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
               'total_positive' => $total_positive,
               'total_negative' => $total_negative,
               'approved_dist' => 0,
               'approved_region' => 0,
               'approved_zone' => 0,
			   'approved_national' => 0,
               'draft' => 0,
               'alert_sent' => 0,
               'entry_date' => date('Y-m-d'),
               'entry_time' => date('Y-m-d h:i:s'),
               'edit_date' => date('Y-m-d'),
               'edit_time' => date('Y-m-d h:i:s'),
			   'country_id' => $country_id,
           );
           $this->db->insert('forms', $data);
		   
		   $form_id = $this->db->insert_id();//get the ID of the saved record
		   
		   	   
		   foreach ($diseases->result() as $disease):
		   
		    	$male_under_five = $this->input->post(''.$disease->disease_code.'_ufive_male');
				$female_under_five = $this->input->post(''.$disease->disease_code.'_ufive_female');
				$male_over_five = $this->input->post(''.$disease->disease_code.'_ofive_male');
				$female_over_five = $this->input->post(''.$disease->disease_code.'_ofive_female');
			
				$total_under_five = ($male_under_five + $female_under_five);
				$total_over_five = ($male_over_five + $female_over_five);
				$total_disease = ($total_under_five + $total_over_five);
				
				$formdata = array(
               'form_id' => $form_id,
			   'epicalendar_id' => $reportingperiod->id,
			   'healthfacility_id' => $healthfacility_id,
               'district_id' => $district->id,
               'region_id' => $region->id,
               'zone_id' => $zone->id,
               'disease_id' => $disease->id,
			   'disease_name' => $disease->disease_code,
               'male_under_five' => $this->input->post(''.$disease->disease_code.'_ufive_male'),
               'female_under_five' => $this->input->post(''.$disease->disease_code.'_ufive_female'),
               'male_over_five' => $this->input->post(''.$disease->disease_code.'_ofive_male'),
               'female_over_five' => $this->input->post(''.$disease->disease_code.'_ofive_female'),
			   'total_under_five' => $total_under_five,
			   'total_over_five' => $total_over_five,
			   'total_disease' => $total_disease,
               );
               
			   $this->db->insert('formsdata', $formdata);
		   
		   
		   endforeach;
		   
		   
		  $this->session->set_flashdata('sucsess_message', 'Record successfully added.');
		   
		   
		   redirect('mobile/home', 'refresh');
		   
		   
	   }
	}
    
     function edit()
    {
        
        $data = array();
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('mobile', 'refresh');
            
        }
		
		$country_id = $this->erkanaauth->getField('country_id');
        
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
		
		//$healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
		$country_id = $this->erkanaauth->getField('country_id');
		$healthfacility_id = 86;
		
		$data = array();
		
		
		$reportperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year, $week_no, $country_id)->row();
		
		if(empty($reportperiod))
		{
			$data['error'] = 'There are no EPI records for the selected period for your country.';
            
            $this->load->view('mobile/edit', $data);
		}
		else
		{
			
			$row  = $this->db->get_where('forms', array('epicalendar_id' => $reportperiod->id,'healthfacility_id' => $healthfacility_id))->row();
			
			if(empty($row))
			{
				$data['error'] = '<strong><font color="#FF0000">There are no records for the selected period.</font></strong>';
            
            	$this->load->view('mobile/edit', $data);
			}
			else
			{
				$data['row'] = $row;
				$diseasecategories = $this->diseasecategoriesmodel->get_list();
				$disease_element = array();
				foreach($diseasecategories as $key=>$diseasecategory):
				
				$disease_element[] = $diseasecategory['id'];
				
				endforeach;
				
				$first = reset($disease_element);
				$last = end($disease_element);
				
				$diseasecount = $this->diseasesmodel->get_country_list($country_id);
	            $limit = count($diseasecount);
			
			  
				$data['first'] = $first;
				$data['last'] = $last;
				
				$data['limit'] = $limit;
				
				$data['diseasecategories'] = $diseasecategories;
		
				$data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id));
				
				$data['country_id'] = $country_id;
				
				$data['healthfacility_id'] = $healthfacility_id;
				
				$this->load->view('mobile/editpage', $data);
			}
			
		}
		
		
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
	
	
	 function logout()
    {
        
        $this->erkanaauth->logout();
        
        redirect('mobile', 'refresh');
        
        
    }
    
}
