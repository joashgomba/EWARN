<?php

class Forms extends CI_Controller {

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
       $this->load->model('formsmodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   $user_id = $this->erkanaauth->getField('id');
        
        $level = $this->erkanaauth->getField('level');
		
		$country_id = $this->erkanaauth->getField('country_id');
        
        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 3 && $level != 6) {
            
            redirect('home', 'refresh');
            
        }
		
		if ($level == 2) {//region
            $region_id = $this->erkanaauth->getField('region_id');
            $count = count($this->formsmodel->get_list_by_region($region_id));
            
        }
		if ($level == 3) {// hf
            $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
            $count = count($this->formsmodel->get_list_by_hf($healthfacility_id));
            
        }
		if ($level == 6) {//district
		
		$district_id = $this->erkanaauth->getField('district_id');
            
            $count = count($this->formsmodel->get_list_by_dist($district_id));
            
        }
		
		if (getRole() == 'SuperAdmin') {
		
			$count = count($this->formsmodel->get_list());
	   
		}
		
		if (getRole() == 'Admin') {
		
			$count = count($this->formsmodel->get_list_by_country($country_id));
	   
		}
				
		$this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/forms/index/';
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-double-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-double-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		
		
		
		if ($level == 2) {//region
            $region_id = $this->erkanaauth->getField('region_id');
            $data = array(
			   'rows' => $this->formsmodel->get_paged_reg_list($config['per_page'],$this->uri->segment(3),$region_id),
		   );
            
        }
		if ($level == 3) {// hf
            $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
            $data = array(
			   'rows' => $this->formsmodel->get_paged_hf_list($config['per_page'],$this->uri->segment(3),$healthfacility_id),
		   );
            
        }
		if ($level == 6) {//district
		
		$district_id = $this->erkanaauth->getField('district_id');
            
            $data = array(
			   'rows' => $this->formsmodel->get_paged_dict_list($config['per_page'],$this->uri->segment(3),$district_id),
		   );
            
        }
		
		if (getRole() == 'SuperAdmin') {
		
			$data = array(
			   'rows' => $this->formsmodel->get_paged_list($config['per_page'],$this->uri->segment(3)),
		   );
	   
		}
		
		if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->formsmodel->get_paged_country_list($config['per_page'],$this->uri->segment(3),$country_id),
		   );
	   
		}
		
		/**
		$data = array(
           'rows' => $this->db->get('forms'),
       );
	   **/
	   
	          
        
        if ($level == 3) {
            
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
		else if ($level == 2) {
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region                   = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']             = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']           = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts']        = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
        }
		
		if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
		
        
        $data['level'] = $level;
	   
	   $data['links'] = $this->pagination->create_links();
        
        $data['level']           = $level;
        $data['alert_message']   = $this->session->flashdata('alert_message');
        $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
		
	   
	   
       $this->load->view('forms/index', $data);
   }
   
   
   public function search()
   {
	   if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   $user_id = $this->erkanaauth->getField('id');
        
       $level = $this->erkanaauth->getField('level');
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   $zoneid = $this->input->post('zone_id');
	   $regionid = $this->input->post('region_id');
	   $districtid = $this->input->post('district_id');
	   $healthfacilityid = $this->input->post('healthfacility_id');
	   $reportingyear = $this->input->post('reporting_year');
	   $weekno = $this->input->post('week_no');
	   
	   if(empty($zoneid))
	   {
		   $zone_id = 0;
	   }
	   else
	   {
		    $zone_id = $this->input->post('zone_id');
	   }
	   
	   if(empty($regionid))
	   {
		   if ($level == 2) {
            	$region_id = $this->erkanaauth->getField('region_id');
		   }
		   else
		   {
		     	$region_id = 0;
		   }
	   }
	   else
	   {
		    $region_id = $this->input->post('region_id');
	   }
	   
	   if(empty($districtid))
	   {
		   if ($level == 6) {//District
				$district_id = $this->erkanaauth->getField('district_id');
		   }
		   else
		   {
		   		$district_id = 0;
		   }
	   }
	   else
	   {
		    $district_id = $this->input->post('district_id');
	   }
	   
	   if(empty($healthfacilityid))
	   {
		   if ($level == 3) {
            
           		$healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
		   }
		   else
		   {
		   		$healthfacility_id = 0;
		   }
	   }
	   else
	   {
		    $healthfacility_id = $this->input->post('healthfacility_id');
	   }
	   
	   if(empty($reportingyear))
	   {
		   $reporting_year = 0;
	   }
	   else
	   {
		    $reporting_year = $this->input->post('reporting_year');
	   }
	   
	   if(empty($weekno))
	   {
		   $week_no = 0;
	   }
	   else
	   {
		    $week_no = $this->input->post('week_no');
	   }
	   
	   
        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 3 && $level != 6) {
            
            redirect('home', 'refresh');
            
        }
		
		
		
		$count = count($this->formsmodel->get_search_list($healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no));
	   
				
		//echo $count;
		
		$this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/forms/searchlist/'.$healthfacility_id.'/'.$district_id.'/'.$region_id.'/'.$zone_id.'/'.$reporting_year.'/'.$week_no;
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 8;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-double-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-double-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		//$this->formsmodel->get_paged_search_list($config['per_page'],$this->uri->segment(3),$healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no);
		
		$data = array(
			   'rows' => $this->formsmodel->get_paged_search_list($config['per_page'],$this->uri->segment(8),$healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no),
		   );
		/**
		$data = array(
           'rows' => $this->db->get('forms'),
       );
	   **/
	   
	   if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
        
        
        if ($level == 3) {
            
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
		else if ($level == 2) {
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region                   = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']             = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']           = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts']        = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
        }
        
        $data['level'] = $level;
	   
	   $data['links'] = $this->pagination->create_links();
        
        $data['level']           = $level;
        $data['alert_message']   = $this->session->flashdata('alert_message');
        $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
	   
	   
       $this->load->view('forms/index', $data);
	   
	   
   }
   
   
   public function searchlist($healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no)
   {
	   if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   $user_id = $this->erkanaauth->getField('id');
        
       $level = $this->erkanaauth->getField('level');
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	     
        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 3 && $level != 6) {
            
            redirect('home', 'refresh');
            
        }
		
		
		
		$count = count($this->formsmodel->get_search_list($healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no));
	   
				
		//echo $count;
		
		$this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/forms/searchlist/'.$healthfacility_id.'/'.$district_id.'/'.$region_id.'/'.$zone_id.'/'.$reporting_year.'/'.$week_no;
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 9;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-double-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-double-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		//$this->formsmodel->get_paged_search_list($config['per_page'],$this->uri->segment(3),$healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no);
		
		$data = array(
			   'rows' => $this->formsmodel->get_paged_search_list($config['per_page'],$this->uri->segment(9),$healthfacility_id,$district_id,$region_id,$zone_id,$reporting_year,$week_no),
		   );
		/**
		$data = array(
           'rows' => $this->db->get('forms'),
       );
	   **/
	   
	   if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
        
        
        if ($level == 3) {
            
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
		else if ($level == 2) {
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region                   = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']             = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']           = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts']        = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
        }
        
        $data['level'] = $level;
	   
	   $data['links'] = $this->pagination->create_links();
        
        $data['level']           = $level;
        $data['alert_message']   = $this->session->flashdata('alert_message');
        $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
	   
	   
       $this->load->view('forms/index', $data);
	   
	   
   }
   
    
   public function add()
   {
	    //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
  
        $level = $this->erkanaauth->getField('level');
        
        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 3 && $level != 6) {
            
            redirect('home', 'refresh');
            
        }
        
        $data = array();
		
		$country_id = $this->erkanaauth->getField('country_id');
        
        /**
        1- zonal
        2- Regional
        3 - Health facility
        4- National
        5 - stake holder
        **/
        
       
        
        if ($level == 3) {
            
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
		else if ($level == 2) {
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region                   = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']             = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']           = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts']        = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
        }
		
		 if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
        
        
        $data['level'] = $level;
	  
	   
	   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id));
	   
	 	   
	    $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	    $country_diseases = count($diseasecount);

	   
	   $total_formula = 'initialval + ';
	   
	   foreach ($diseases->result() as $disease):
	   
	    $total_formula .= $disease->disease_code.'_ufive_male + '.$disease->disease_code.'_ufive_female + '.$disease->disease_code.'_ofive_male + '.$disease->disease_code.'_ofive_female + ';
	   
	   endforeach;
	   
	   $total_formula .= '0';
	   
       $data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id));
	   
	   $data['total_formula'] = $total_formula;
	   $data['country_diseases'] = $country_diseases;
	   $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
	   $this->load->view('forms/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
        
        //ensure that the reporting period is not entered twice
		$country_id = $this->erkanaauth->getField('country_id');
        $reporting_year  = $this->input->post('reporting_year');
        $week_no         = $this->input->post('week_no');
        $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$week_no,$country_id)->row();
        
        if (!empty($reportingperiod)) {
            $reportingperiod_id = $reportingperiod->id;
        } else {
            $reportingperiod_id = 0;
        }
		
		//if the access level is 3 then the health facility
		$level = $this->erkanaauth->getField('level');
        if ($level == 3) {
            $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
            
        } else {
            $healthfacility_id = $this->input->post('healthfacility_id');
        }
        
        $reportingform = $this->formsmodel->get_by_period_hf($reportingperiod->id, $healthfacility_id);
        
        if (!empty($reportingform)) {
            $iscaptured = 1;
			redirect('forms/add', 'refresh');
        } else {
            $iscaptured = 0;
        }
		
	//load the validation library
       $this->load->library('form_validation');
       $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
       $this->form_validation->set_rules('reporting_year', 'Reporting year', 'trim|required|callback__check_Period[' . $iscaptured . ']');
       $this->form_validation->set_rules('reporting_date', 'Reporting date', 'trim|required');;
       $this->form_validation->set_rules('healthfacility_id', 'Health facility', 'trim|required');
       $this->form_validation->set_rules('district_id', 'District', 'trim|required');
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
            
            if (isset($_POST['draft_button'])) {
                //save as draft
                //$approved_hf = 0;
                $draft       = 1;
                
            } else if (isset($_POST['submit_button'])) {
                //$approved_hf = 1;
                $draft       = 0;
            }

           $epdcalendar = $this->epdcalendarmodel->get_by_id($reportingperiod->id)->row();
           $entry_date = $this->input->post('reporting_date');

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
               'week_no' => $this->input->post('week_no'),
               'reporting_year' => $this->input->post('reporting_year'),
               'reporting_date' => $this->input->post('reporting_date'),
               'epicalendar_id' => $reportingperiod->id,
               'user_id' => $user_id,
               'healthfacility_id' => $healthfacility_id,
               'district_id' => $district->id,
               'region_id' => $region->id,
               'zone_id' => $zone->id,
               'contact_number' => $this->input->post('contact_number'),
               'supporting_ngo' => $this->input->post('supporting_ngo'),
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
               'draft' => $draft,
               'alert_sent' => 0,
               'entry_date' => $this->input->post('reporting_date'),
               'entry_time' => $this->input->post('datetime'),
               'edit_date' => $this->input->post('reporting_date'),
               'edit_time' => $this->input->post('datetime'),
			   'country_id' => $country_id,
               'timely' => $timely,
           );
           $this->db->insert('forms', $data);
		   
		   
		   $form_id = $this->db->insert_id();//get the ID of the saved record
		   
		   $country_id = $this->erkanaauth->getField('country_id'); // the user's country
		   
		   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id));
	  
	   	//loop diseases and dynamically load the post varriables and load the form records table
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
			   'country_id' => $country_id,
               );
               
			   $this->db->insert('formsdata', $formdata);
			   
			   $under_five_male = NULL;
			   $under_five_female = NULL;
			   $over_five_male = NULL;
			   $over_five_female = NULL;		    
			   $diseasetotal = NULL;
		   
		   
		   endforeach;
		   
		   
		   //alerts
		   //send only when submit button is pressed
		   if (isset($_POST['submit_button'])) {
			   
			   $reportingperiod_id = $reportingperiod->id;
			   
			   $alertcases = '';
			   
			   //alerts for diseases
		   
			   foreach ($diseases->result() as $disease):
			   
				  $under_five_male = $this->input->post(''.$disease->disease_code.'_ufive_male');
				  $under_five_female = $this->input->post(''.$disease->disease_code.'_ufive_female');
				  $over_five_male = $this->input->post(''.$disease->disease_code.'_ofive_male');
				  $over_five_female = $this->input->post(''.$disease->disease_code.'_ofive_female');
				  
			   
				$diseasetotal = ($under_five_male+$under_five_female+$over_five_male+$over_five_female);
				
				if($disease->alert_type==1)
				{
					if($disease->alert_threshold==0)
					{
						$threshold = $disease->alert_threshold;
					}
					else
					{
						$threshold = ($disease->alert_threshold-1);
						
					}
						
						if ($diseasetotal > $threshold) {
							$alertcases .= ''.$disease->disease_code.'/' . $diseasetotal . ',';
							
							//$vpdcases .= ''.$disease->disease_code.'/' . $diseasetotal . ',';
							
							$alertdata = array(
								'reportingform_id' => $form_id,
								'reportingperiod_id' => $reportingperiod_id,
								'disease_id' => $disease->id,
								'disease_name' => $disease->disease_code,
								'healthfacility_id' => $healthfacility_id,
								'district_id' => $district->id,
								'region_id' => $region->id,
								'zone_id' => $zone->id,
								'cases' => $diseasetotal,
								'deaths' => 0,
								'notes' => '',
								'verification_status' => 0,
								'include_bulletin' => 0,
								'country_id' => $country_id,
							);
							$this->db->insert('formalerts', $alertdata);
						
						
						
					}//end if
					
				}
				else{
					//get average per disease week and calculate to get alert threshold
					$the_average = $this->formsdatamodel->health_facility_average($disease->id,$healthfacility_id,$disease->weeks);	
					$disease_threshold_condition = ($the_average * $disease->no_of_times);
					if ($diseasetotal > $disease_threshold_condition) {
						
						$alertcases .= ''.$disease->disease_code.'/' . $diseasetotal . ',';
							
							//$vpdcases .= ''.$disease->disease_code.'/' . $diseasetotal . ',';
							
							$alertdata = array(
								'reportingform_id' => $form_id,
								'reportingperiod_id' => $reportingperiod_id,
								'disease_id' => $disease->id,
								'disease_name' => $disease->disease_code,
								'healthfacility_id' => $healthfacility_id,
								'district_id' => $district->id,
								'region_id' => $region->id,
								'zone_id' => $zone->id,
								'cases' => $diseasetotal,
								'deaths' => 0,
								'notes' => '',
								'verification_status' => 0,
								'include_bulletin' => 0,
								'country_id' => $country_id,
							);
							$this->db->insert('formalerts', $alertdata);
						
					}
				}
				
				// Clear item and other variables from memory after each loop
				$under_five_male = NULL;
				$under_five_female = NULL;
				$over_five_male = NULL;
				$over_five_female = NULL;		    
				$diseasetotal = NULL;
				
			   endforeach;
		   
		   
		   $undis = $undismale + $undisfemale + $undismaletwo + $undisfemaletwo;
                if ($undis > 2) {
                    $alertcases .= 'UnDis/' . $undis . '';
                    
                    $alertdata = array(
                        'reportingform_id' => $form_id,
                        'reportingperiod_id' => $reportingperiod_id,
						'disease_id' => 0,
                        'disease_name' => 'UnDis',
                        'healthfacility_id' => $healthfacility_id,
                        'district_id' => $district->id,
                        'region_id' => $region->id,
                        'zone_id' => $zone->id,
                        'cases' => $undis,
                        'deaths' => 0,
                        'notes' => '',
                        'verification_status' => 0,
                        'include_bulletin' => 0,
						'country_id' => $country_id,
                    );
                    $this->db->insert('formalerts', $alertdata);
                }
				
				$totalpositive = ($pf + $pv + $pmix);
                if ($totalpositive != 0) {
                    $alertpf = ($pf / $totalpositive) * 100;
                    
                    if ($alertpf > 40) {
                        $alertcases .= 'Pf/' . $pf . '';
                        
                        $alertdata = array(
                            'reportingform_id' => $form_id,
                            'reportingperiod_id' => $reportingperiod_id,
							'disease_id' => 0,
                            'disease_name' => 'Pf',
                            'healthfacility_id' => $healthfacility_id,
                            'district_id' => $district->id,
                            'region_id' => $region->id,
                            'zone_id' => $zone->id,
                            'cases' => $pf,
                            'deaths' => 0,
                            'notes' => '',
                            'verification_status' => 0,
                            'include_bulletin' => 0,
							'country_id' => $country_id,
                        );
                        $this->db->insert('formalerts', $alertdata);
                    }
				}
				
				if($sre !=0)
				{
				
				 $srealert = ($totalpositive / $sre) * 100;
                    
                    if ($srealert > 50) {
                        $alertcases .= 'SRE/' . $sre . '';
                        
                        $alertdata = array(
                            'reportingform_id' => $form_id,
                            'reportingperiod_id' => $reportingperiod_id,
							'disease_id' => 0,
                            'disease_name' => 'SRE',
                            'healthfacility_id' => $healthfacility_id,
                            'district_id' => $district->id,
                            'region_id' => $region->id,
                            'zone_id' => $zone->id,
                            'cases' => $sre,
                            'deaths' => 0,
                            'notes' => '',
                            'verification_status' => 0,
                            'include_bulletin' => 0,
							'country_id' => $country_id,
                        );
                        $this->db->insert('formalerts', $alertdata);
                    }
				}
					
					
					if (!empty($alertcases)) {
					//send SMS and email
					
						//echo $alertcases;	
						
						//update table that alert is sent
						$updatedata = array(
							'alert_sent' => 1
						);
						$this->db->where('id', $form_id);
						$this->db->update('reportingforms', $updatedata);
						
					}
	   
	   			}//end submit button check
				
		  $this->session->set_flashdata('sucsess_message', 'Record successfully added.');
		   
           redirect('forms/add','refresh');
       }
   }
   
    public function healthfacility()
    {
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        
        $level = $this->erkanaauth->getField('level');
		$country_id = $this->erkanaauth->getField('country_id');
        
        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 3 && $level != 6) {
            
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
		
		 if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
        
        
        if ($level == 3) {
            
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
		else if ($level == 2) {
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region                   = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']             = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']           = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts']        = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
        }
        
        
	  
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
	   
	   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   
	   $total_formula = 'initialval + ';
	   
	   foreach ($diseases->result() as $disease):
	   
	    $total_formula .= $disease->disease_code.'_ufive_male + '.$disease->disease_code.'_ufive_female + '.$disease->disease_code.'_ofive_male + '.$disease->disease_code.'_ofive_female + ';
		
			   
	   endforeach;
	   
	   $total_formula .= '0';
	   
	   $data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   
	   $data['total_formula'] = $total_formula;
	   $data['level'] = $level;
	   $data['alert_message']   = $this->session->flashdata('alert_message');
       $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
        
        $this->load->view('forms/hfedit', $data);
    }
	
	public function update_form()
    {
		
		$id = $this->input->post('id');
        //ensure that the user is logged in
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
		
		$country_id = $this->erkanaauth->getField('country_id');
		
		
		$reportingform = $this->formsmodel->get_by_id($id)->row();
		$sre  = $this->input->post('sre');
        $pf   = $this->input->post('pf');
        $pv   = $this->input->post('pv');
        $pmix = $this->input->post('pmix');
		
		 $total_positive = $pf + $pv + $pmix;
		 $total_negative = $sre - $total_positive;
        
        if (isset($_POST['draft_button'])) {
            
            $draft       = 1;
            
        } else if (isset($_POST['submit_button'])) {
            
            $draft       = 0;
        }
		
		$this->load->library('form_validation');
        $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
        $this->form_validation->set_rules('reporting_year', 'Reporting year', 'trim|required');
		
		if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {
			
			$user_id = $this->erkanaauth->getField('id');
			$reporting_year    = $this->input->post('reporting_year');
            $week_no           = $this->input->post('week_no');
            //$healthfacility_id = $this->input->post('healthfacility_id');
			$healthfacility_id = $this->input->post('hf_id');
            
            $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$week_no,$country_id)->row();
			
			$form_period = $this->formsmodel->get_by_period_hf($reportingperiod->id, $healthfacility_id);
			
			
			//$new_hf_id = $this->input->post('hf_id');
			
			//if changing health facility, make sure the new health facility selected does  not have records for the reporting period to avoid double entry
			/**
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
			**/
			
			
			$data = array(
               'healthfacility_id' => $healthfacility_id,
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
               'draft' => $draft,
			   'undisonedesc' => $this->input->post('undisonedesc'),
               'undismale' => $this->input->post('undismale'),
               'undisfemale' => $this->input->post('undisfemale'),
               'undissecdesc' => $this->input->post('undissecdesc'),
               'undismaletwo' => $this->input->post('undismaletwo'),
               'undisfemaletwo' => $this->input->post('undisfemaletwo'),
               'ocmale' => $this->input->post('ocmale'),
               'ocfemale' => $this->input->post('ocfemale'),			   
               'edit_date' => $this->input->post('reporting_date'),
               'edit_time' => $this->input->post('datetime')
           );
           $this->db->where('id', $id);
           $this->db->update('forms', $data);
		   
		   
		   $country_id = $this->erkanaauth->getField('country_id'); // the user's country
		   
		   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id));
	  
	   	//loop diseases and dynamically load the post varriables and load the form records table
			foreach ($diseases->result() as $disease):
			
			$male_under_five = $this->input->post(''.$disease->disease_code.'_ufive_male');
			$female_under_five = $this->input->post(''.$disease->disease_code.'_ufive_female');
			$male_over_five = $this->input->post(''.$disease->disease_code.'_ofive_male');
			$female_over_five = $this->input->post(''.$disease->disease_code.'_ofive_female');
			
				$total_under_five = ($male_under_five + $female_under_five);
				$total_over_five = ($male_over_five + $female_over_five);
				$total_disease = ($total_under_five + $total_over_five);
			
				$formdata = array(
               'form_id' => $id,
			   'healthfacility_id' => $healthfacility_id,
			   'disease_name' => $disease->disease_code,
               'male_under_five' => $this->input->post(''.$disease->disease_code.'_ufive_male'),
               'female_under_five' => $this->input->post(''.$disease->disease_code.'_ufive_female'),
               'male_over_five' => $this->input->post(''.$disease->disease_code.'_ofive_male'),
               'female_over_five' => $this->input->post(''.$disease->disease_code.'_ofive_female'),
			   'total_under_five' => $total_under_five,
			   'total_over_five' => $total_over_five,
			   'total_disease' => $total_disease,
               );
               
			   $this->db->update('formsdata', $formdata, array('form_id' => $id,'healthfacility_id' => $healthfacility_id,'disease_id' => $disease->id));
		   
		   
		   endforeach;
		 		   
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($reportingform->healthfacility_id)->row();
            //$district       = $this->districtsmodel->get_by_id($reportingform->district_id)->row();
           //$region         = $this->regionsmodel->get_by_id($reportingform->region_id)->row();
            //$zone           = $this->zonesmodel->get_by_id($reportingform->zone_id)->row();
			$district       = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
            $region         = $this->regionsmodel->get_by_id($district->region_id)->row();
            $zone           = $this->zonesmodel->get_by_id($region->zone_id)->row();
			
			if(empty($region))
			{
				$region_id = 0;
			}
			else
			{
				$region_id = $region->id;
			}
            
            $user              = $this->usersmodel->get_by_id($reportingform->user_id)->row();
                        
            $reportingperiod_id = $reportingform->epicalendar_id;
			
			if (isset($_POST['submit_button'])) {
				//clear the alerts table and update with the new alert information
                if ($reportingform->alert_sent == 1) {
                    $this->db->delete('formalerts', array(
                        'reportingform_id' => $id
                    ));
                }
							   
			   $alertcases = '';
			   
			   //delete all disease alerts
			   $this->db->delete('formalerts', array('reportingform_id' => $id));
			   
			   //alerts for diseases
		   
			   foreach ($diseases->result() as $disease):
			   
				  $under_five_male = $this->input->post(''.$disease->disease_code.'_ufive_male');
				  $under_five_female = $this->input->post(''.$disease->disease_code.'_ufive_female');
				  $over_five_male = $this->input->post(''.$disease->disease_code.'_ofive_male');
				  $over_five_female = $this->input->post(''.$disease->disease_code.'_ofive_female');
				  
			   
				$diseasetotal = ($under_five_male+$under_five_female+$over_five_male+$over_five_female);
				
				if($disease->alert_type==1)
				{
					if($disease->alert_threshold==0)
					{
						$threshold = $disease->alert_threshold;
					}
					else
					{
						$threshold = ($disease->alert_threshold-1);
							
					}//end else
						
						if ($diseasetotal > $threshold) {
							$alertcases .= ''.$disease->disease_code.'/' . $diseasetotal . ',';
							
							//$vpdcases .= ''.$disease->disease_code.'/' . $diseasetotal . ',';
							
							$alertdata = array(
								'reportingform_id' => $id,
								'reportingperiod_id' => $reportingperiod_id,
								'disease_id' => $disease->id,
								'disease_name' => $disease->disease_code,
								'healthfacility_id' => $healthfacility_id,
								'district_id' => $district->id,
								'region_id' => $region_id,
								'zone_id' => $zone->id,
								'cases' => $diseasetotal,
								'deaths' => 0,
								'notes' => '',
								'verification_status' => 0,
								'include_bulletin' => 0,
								'country_id' => $country_id,
							);
							$this->db->insert('formalerts', $alertdata);
						}//end if
						
					
					
				}
				else{
					//get average per disease week and calculate to get alert threshold
					$the_average = $this->formsdatamodel->health_facility_average($disease->id,$healthfacility_id,$disease->weeks);	
					$disease_threshold_condition = ($the_average * $disease->no_of_times);
					if ($diseasetotal > $disease_threshold_condition) {
						
						$alertcases .= ''.$disease->disease_code.'/' . $diseasetotal . ',';
							
							//$vpdcases .= ''.$disease->disease_code.'/' . $diseasetotal . ',';
							
							$alertdata = array(
								'reportingform_id' => $id,
								'reportingperiod_id' => $reportingperiod_id,
								'disease_id' => $disease->id,
								'disease_name' => $disease->disease_code,
								'healthfacility_id' => $healthfacility_id,
								'district_id' => $district->id,
								'region_id' => $region_id,
								'zone_id' => $zone->id,
								'cases' => $diseasetotal,
								'deaths' => 0,
								'notes' => '',
								'verification_status' => 0,
								'include_bulletin' => 0,
								'country_id' => $country_id,
							);
							$this->db->insert('formalerts', $alertdata);
						
					}
				}
				
				// Clear item and other variables from memory after each loop
				$under_five_male = NULL;
				$under_five_female = NULL;
				$over_five_male = NULL;
				$over_five_female = NULL;		    
				$diseasetotal = NULL;
				
			   endforeach;
			   
			    $undismale                = $this->input->post('undismale');
				$undisfemale              = $this->input->post('undisfemale');
				$undismaletwo             = $this->input->post('undismaletwo');
				$undisfemaletwo           = $this->input->post('undisfemaletwo');
				$ocmale                   = $this->input->post('ocmale');
				$ocfemale                 = $this->input->post('ocfemale');
				
				$undis = $undismale + $undisfemale + $undismaletwo + $undisfemaletwo;
                if ($undis > 2) {
                    $alertcases .= 'UnDis/' . $undis . '';
                    
                    $alertdata = array(
                        'reportingform_id' => $id,
                        'reportingperiod_id' => $reportingperiod_id,
						'disease_id' => 0,
                        'disease_name' => 'UnDis',
                        'healthfacility_id' => $healthfacility_id,
                        'district_id' => $district->id,
                        'region_id' => $region_id,
                        'zone_id' => $zone->id,
                        'cases' => $undis,
                        'deaths' => 0,
                        'notes' => '',
                        'verification_status' => 0,
                        'include_bulletin' => 0,
						'country_id' => $country_id,
                    );
                    $this->db->insert('formalerts', $alertdata);
                }
				
				$totalpositive = ($pf + $pv + $pmix);
                if ($totalpositive != 0) {
                    $alertpf = ($pf / $totalpositive) * 100;
                    
                    if ($alertpf > 40) {
                        $alertcases .= 'Pf/' . $pf . '';
                        
                        $alertdata = array(
                            'reportingform_id' => $id,
                            'reportingperiod_id' => $reportingperiod_id,
							'disease_id' => 0,
                            'disease_name' => 'Pf',
                            'healthfacility_id' => $healthfacility_id,
                            'district_id' => $district->id,
                            'region_id' => $region_id,
                            'zone_id' => $zone->id,
                            'cases' => $pf,
                            'deaths' => 0,
                            'notes' => '',
                            'verification_status' => 0,
                            'include_bulletin' => 0,
							'country_id' => $country_id,
                        );
                        $this->db->insert('formalerts', $alertdata);
                    }
				}
				
				if($sre !=0)
				{
				
				 $srealert = ($totalpositive / $sre) * 100;
                    
                    if ($srealert > 50) {
                        $alertcases .= 'SRE/' . $sre . '';
                        
                        $alertdata = array(
                            'reportingform_id' => $id,
                            'reportingperiod_id' => $reportingperiod_id,
							'disease_id' => 0,
                            'disease_name' => 'SRE',
                            'healthfacility_id' => $healthfacility_id,
                            'district_id' => $district->id,
                            'region_id' => $region_id,
                            'zone_id' => $zone->id,
                            'cases' => $sre,
                            'deaths' => 0,
                            'notes' => '',
                            'verification_status' => 0,
                            'include_bulletin' => 0,
							'country_id' => $country_id,
                        );
                        $this->db->insert('formalerts', $alertdata);
                    }
				}
				
			}
			
		   
		   $this->session->set_flashdata('sucsess_message', 'Record successfully updated.');
		   		   
           redirect('forms','refresh');
			
		}
		
	}
	
	
	 public function view($id)
   {
       
	   
	     //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	  $country_id = $this->erkanaauth->getField('country_id');
      $level = $this->erkanaauth->getField('level');
        
        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 3 && $level != 6) {
            
            redirect('home', 'refresh');
            
        }
        
        $data = array();
        
        /**
        1- zonal
        2- Regional
        3 - Health facility
        4- National
        5 - stake holder
		6 - District
        **/
        
        if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
		
		 if(!is_numeric($id)) {
       	   redirect('forms/add','refresh');
         }
		
		$row = $this->db->get_where('forms', array('id' => $id))->row();
		
		if(empty($row)) {
       	   redirect('forms/add','refresh');
        }
		
			   
	   if(getRole() != 'SuperAdmin')
	   {
			  if($row->country_id !=$country_id)
			  {
					redirect('home', 'refresh');
			  }
		  }
		
				
		 $district = $this->districtsmodel->get_by_id($row->district_id)->row();            
         $region = $this->regionsmodel->get_by_id($row->region_id)->row();
		 $zone = $this->zonesmodel->get_by_id($row->zone_id)->row();
		 $healthfacility = $this->healthfacilitiesmodel->get_by_id($row->healthfacility_id)->row();
            
                 
        
        $data['level'] = $level;
	  
	   $country_id = $this->erkanaauth->getField('country_id');
	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
	   
	   
	   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   
	   $total_formula = 'initialval + ';
	   
	   foreach ($diseases->result() as $disease):
	   
	    $total_formula .= $disease->disease_code.'_ufive_male + '.$disease->disease_code.'_ufive_female + '.$disease->disease_code.'_ofive_male + '.$disease->disease_code.'_ofive_female + ';
	   
	   endforeach;
	   
	   $total_formula .= '0';
	   
       $data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   $data['reportingperiod'] = $this->epdcalendarmodel->get_by_id($row->epicalendar_id)->row();
	   
	   $data['lists'] = $this->formsmodel->get_by_facility_data($row->id,$limit);
	   
	   $data['zone']= $zone;
	   $data['region']=$region;
	   $data['district'] = $district;
	   $data['healthfacility']=$healthfacility;
	   
	   $data['total_formula'] = $total_formula;
	   $data['alert_message']   = $this->session->flashdata('alert_message');
       $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
	   $data['row'] = $row;
	  
       $this->load->view('forms/view', $data);
   }
   
   
   
   public function edit($id)
   {
       
	   
	     //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	  $country_id = $this->erkanaauth->getField('country_id');
      $level = $this->erkanaauth->getField('level');
        
        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 3 && $level != 6) {
            
            redirect('home', 'refresh');
            
        }
        
        $data = array();
        
        /**
        1- zonal
        2- Regional
        3 - Health facility
        4- National
        5 - stake holder
		6 - District
        **/
        
        if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
		
		 if(!is_numeric($id)) {
       	   redirect('forms/add','refresh');
         }
		
		$row = $this->db->get_where('forms', array('id' => $id))->row();
		
		if(empty($row)) {
       	   redirect('forms/add','refresh');
        }
		
			   
	   if(getRole() != 'SuperAdmin')
	   {
			  if($row->country_id !=$country_id)
			  {
					redirect('home', 'refresh');
			  }
		  }
		
				
		 $district = $this->districtsmodel->get_by_id($row->district_id)->row();            
         $region = $this->regionsmodel->get_by_id($row->region_id)->row();
		 $zone = $this->zonesmodel->get_by_id($row->zone_id)->row();
		 $healthfacility = $this->healthfacilitiesmodel->get_by_id($row->healthfacility_id)->row();
            
                 
        
        $data['level'] = $level;
		
	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
	   
	 	   
	   
	   /***/
	    $country_id = $this->erkanaauth->getField('country_id');
	   
	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
	   
	   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   
	   $total_formula = 'initialval + ';
	   
	   foreach ($diseases->result() as $disease):
	   
	    $total_formula .= $disease->disease_code.'_ufive_male + '.$disease->disease_code.'_ufive_female + '.$disease->disease_code.'_ofive_male + '.$disease->disease_code.'_ofive_female + ';
		
			   
	   endforeach;
	   
	   $total_formula .= '0';
	   
	   $data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   
	   $data['total_formula'] = $total_formula;
	   
	   /***/
	   
       $data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   $data['reportingperiod'] = $this->epdcalendarmodel->get_by_id($row->epicalendar_id)->row();
	   
	   $lists = $this->formsmodel->get_by_facility_data($row->id,$limit);
	   
	   $data['lists'] = $lists;
	   
	   $edittable = '';
	   
	   foreach ($lists as $key => $list): 
				
						$edittable .= '<div class="control-group">
									<label class="control-label" for="form-field-5">'.$list->disease_name.' &lt; 5</label>

									<div class="controls">
										<input class="span5" type="text" name="'.$list->disease_code.'_ufive_male" id="'.$list->disease_code.'_ufive_male" value="'.$list->male_under_five.'" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" placeholder="Male" onClick="checkvalid()" />
										<input class="span5" type="text" name="'.$list->disease_code.'_ufive_female" id="'.$list->disease_code.'_ufive_female" value="'.$list->female_under_five.'" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" placeholder="Female" />
                                        
									</div>
								</div>';
								
						$edittable .= '<div class="control-group">
									<label class="control-label" for="form-field-5">'.$list->disease_name.' &gt; 5</label>

									<div class="controls">
										<input class="span5" type="text" name="'.$list->disease_code.'_ofive_male" id="'.$list->disease_code.'_ofive_male" value="'.$list->male_over_five.'" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" placeholder="Male" />
										<input class="span5" type="text" name="'.$list->disease_code.'_ofive_female" id="'.$list->disease_code.'_ofive_female"  value="'.$list->female_over_five.'" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" placeholder="Female" />
									</div>
								</div>
								';
						$edittable .= '<hr>';
					
					endforeach;
	   
	   $data['zone']= $zone;
	   $data['region']=$region;
	   $data['district'] = $district;
	   $data['healthfacility']=$healthfacility;
	   
	   $data['edittable']=$edittable;
	   
	   $data['total_formula'] = $total_formula;
	   $data['alert_message']   = $this->session->flashdata('alert_message');
       $data['sucsess_message'] = $this->session->flashdata('sucsess_message');
	   $data['row'] = $row;
	  
       $this->load->view('forms/edit', $data);
   }

   public function edit_validate($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
       $this->form_validation->set_rules('reporting_year', 'Reporting year', 'trim|required');
       $this->form_validation->set_rules('reporting_date', 'Reporting date', 'trim|required');
       $this->form_validation->set_rules('epicalendar_id', 'Epicalendar id', 'trim|required');
       $this->form_validation->set_rules('user_id', 'User id', 'trim|required');
       $this->form_validation->set_rules('healthfacility_id', 'Healthfacility id', 'trim|required');
       $this->form_validation->set_rules('district_id', 'District id', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region id', 'trim|required');
       $this->form_validation->set_rules('zone_id', 'Zone id', 'trim|required');
       $this->form_validation->set_rules('contact_number', 'Contact number', 'trim|required');
       $this->form_validation->set_rules('supporting_ngo', 'Supporting ngo', 'trim|required');
       $this->form_validation->set_rules('total_consultations', 'Total consultations', 'trim|required');
       $this->form_validation->set_rules('sre', 'Sre', 'trim|required');
       $this->form_validation->set_rules('pf', 'Pf', 'trim|required');
       $this->form_validation->set_rules('pmix', 'Pmix', 'trim|required');
       $this->form_validation->set_rules('total_positive', 'Total positive', 'trim|required');
       $this->form_validation->set_rules('total_negative', 'Total negative', 'trim|required');
       $this->form_validation->set_rules('approved_dist', 'Approved dist', 'trim|required');
       $this->form_validation->set_rules('approved_region', 'Approved region', 'trim|required');
       $this->form_validation->set_rules('approved_zone', 'Approved zone', 'trim|required');
       $this->form_validation->set_rules('draft', 'Draft', 'trim|required');
       $this->form_validation->set_rules('alert_sent', 'Alert sent', 'trim|required');
       $this->form_validation->set_rules('entry_date', 'Entry date', 'trim|required');
       $this->form_validation->set_rules('entry_time', 'Entry time', 'trim|required');
       $this->form_validation->set_rules('edit_date', 'Edit date', 'trim|required');
       $this->form_validation->set_rules('edit_time', 'Edit time', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'week_no' => $this->input->post('week_no'),
               'reporting_year' => $this->input->post('reporting_year'),
               'reporting_date' => $this->input->post('reporting_date'),
               'epicalendar_id' => $this->input->post('epicalendar_id'),
               'user_id' => $this->input->post('user_id'),
               'healthfacility_id' => $this->input->post('healthfacility_id'),
               'district_id' => $this->input->post('district_id'),
               'region_id' => $this->input->post('region_id'),
               'zone_id' => $this->input->post('zone_id'),
               'contact_number' => $this->input->post('contact_number'),
               'supporting_ngo' => $this->input->post('supporting_ngo'),
               'total_consultations' => $this->input->post('total_consultations'),
               'sre' => $this->input->post('sre'),
               'pf' => $this->input->post('pf'),
               'pmix' => $this->input->post('pmix'),
               'total_positive' => $this->input->post('total_positive'),
               'total_negative' => $this->input->post('total_negative'),
               'approved_dist' => $this->input->post('approved_dist'),
               'approved_region' => $this->input->post('approved_region'),
               'approved_zone' => $this->input->post('approved_zone'),
               'draft' => $this->input->post('draft'),
               'alert_sent' => $this->input->post('alert_sent'),
               'entry_date' => $this->input->post('entry_date'),
               'entry_time' => $this->input->post('entry_time'),
               'edit_date' => $this->input->post('edit_date'),
               'edit_time' => $this->input->post('edit_time'),
           );
           $this->db->where('id', $id);
           $this->db->update('forms', $data);
           redirect('forms','refresh');
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
	
	
	public function getperiodbyhf()
    {
        $week_no           = trim(addslashes(htmlspecialchars(rawurldecode($_POST['week_no']))));
        $reporting_year    = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
        $healthfacility_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['healthfacility_id']))));
		$country_id = $this->erkanaauth->getField('country_id');
        if (empty($week_no)) {
            //echo '<div class="alert alert-danger">Please select the Week No.</div>';
        } else if (empty($reporting_year)) {
            //echo '<div class="alert alert-danger">Please select the Reporting year</div>';
        } else {
            $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year, $week_no, $country_id)->row();
			
            
            if (empty($reportingperiod)) {
                echo 'No reporting period added';
				echo '<input type="hidden" name="period_check" id="period_check" value="">';
            } else {
                
                $reportperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year, $week_no, $country_id)->row();
                
                
                $reportingform = $this->formsmodel->get_by_period_hf($reportperiod->id, $healthfacility_id);
                
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
		$country_id = $this->erkanaauth->getField('country_id');
        
        if (empty($week_no)) {
            //echo '<div class="alert alert-danger">Please select the Week No.</div>';
        } else if (empty($reporting_year)) {
            //echo '<div class="alert alert-danger">Please select the Reporting year</div>';
        } else {
            $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year, $week_no, $country_id)->row();
            
            if (empty($reportingperiod)) {
                echo 'No reporting period added';
            } else {
                
                //echo ' <input type="text" readonly="" name="reporting_period" id="reporting_period" value="'.$reportingperiod->from.' to  '.$reportingperiod->to.'">';
                echo '<strong>' . date("d F Y", strtotime($reportingperiod->from)) . ' to  ' . date("d F Y", strtotime($reportingperiod->to)) . '</strong>';
            }
        }
    }
	
	
	 public function getreportdetails()
    {
        $reporting_year    = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
        $week_no           = trim(addslashes(htmlspecialchars(rawurldecode($_POST['week_no']))));
        $district_id       = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
        $healthfacility_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['healthfacility_id']))));
		
		$country_id = $this->erkanaauth->getField('country_id');
		
		$diseasecount = $this->diseasesmodel->get_country_list($country_id);
	    $limit = count($diseasecount);
	   
		$diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
        
        $level = $this->erkanaauth->getField('level');
        
        if (empty($reporting_year) || empty($week_no) || empty($healthfacility_id)) {
            echo '<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Data Required</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            <div class="alert alert-danger">Please select all the required data</div>
                                            
                                            </div>
                                            
                                         </div>
			 </div>';
        } else {
            $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year, $week_no, $country_id)->row();
            
            if (empty($reportingperiod)) {
                echo '<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Data Required</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            <div class="alert alert-danger">No reporting period added</div>
                                            
                                            </div>
                                            
                                         </div>';
            } else {
                $reportingform = $this->formsmodel->get_by_reporting_period_hf($reportingperiod->id, $healthfacility_id)->row();
                
                if (empty($reportingform)) {
                    echo '<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Data Required</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
                                            <div class="alert alert-danger">No data available on the selected period</div>
                                            
                                            </div>
                                            
                                         </div>';
                } else {
                    $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
                    $dist_id        = $healthfacility->district_id;
                    
                    $healthfacilities = $this->healthfacilitiesmodel->get_by_district($dist_id);
				 
                    $edittable = '<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Health Events Under Surveillance</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">';
                    
                    //if the form has been approved at the district level then the user cannot edit it
                    if ($reportingform->approved_dist == 1) {
                        $edittable .= ' <div class="alert alert-info">This entry has been validated at the district level. You can only view but not edit.</div>';
                    }
                    
                    if ($level == 3) {
                        $edittable .= '<div><input type="hidden" name="hf_id" id="hf_id" value="' . $healthfacility_id . '">
						<input type="hidden" name="id" id="id" value="' . $reportingform->id . '"></div>';
                    } else {
						 $edittable .= '<div><input type="hidden" name="hf_id" id="hf_id" value="' . $healthfacility_id . '">
						<input type="hidden" name="id" id="id" value="' . $reportingform->id . '"></div>';
                        /**
                        $edittable .= '<div class="row-fluid">
									<div class="span6">
									
									<div class="control-group"><label class="control-label" for="form-field-1">Change Health Facility: </label><div class="controls">
									<select name="hf_id" id="hf_id">';
                        foreach ($healthfacilities as $key => $healthfacility) {
                            if ($healthfacility['id'] == $healthfacility_id) {
                                $selected = 'selected="selected"';
                            } else {
                                $selected = '';
                            }
                            $edittable .= '<option value="' . $healthfacility['id'] . '" ' . $selected . '>' . $healthfacility['health_facility'] . '</option>';
                        }
                        $edittable .= '</select>
									</div>
									</div>
									
									</div>
									<div class="span6">
									
									<div class="control-group"><input type="hidden" name="id" id="id" value="' . $reportingform->id . '">&nbsp;<div class="controls">
									&nbsp;
									</div>
									</div>
									
									</div>
									</div>	
								';
								
								**/
                    }
                    
					
					$edittable .= '<div class="row-fluid">
						<div class="span12">
                        <div class="alert alert-info">
										<button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>

										<strong>
											<i class="icon-remove"></i>
											Note!
										</strong>

										This is a zero reporting form and all fields are required. In instances where there are no cases please enter zero (0).
										<br />
									</div>';
					$lists = $this->formsmodel->get_by_facility_data($reportingform->id,$limit);
									
					//foreach ($diseases->result() as $disease):
					foreach ($lists as $key => $list): 
					
					//get the disease numbers
					//$formdata = $this->formsdatamodel->get_by_form_healthfacility_disease($reportingform->id, $healthfacility_id,$disease->id)->row();
						$edittable .= '<div class="control-group">
									<label class="control-label" for="form-field-5">'.$list->disease_name.' &lt; 5</label>

									<div class="controls">
										<input class="span5" type="text" name="'.$list->disease_code.'_ufive_male" id="'.$list->disease_code.'_ufive_male" value="'.$list->male_under_five.'" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" placeholder="Male" onClick="checkvalid()" />
										<input class="span5" type="text" name="'.$list->disease_code.'_ufive_female" id="'.$list->disease_code.'_ufive_female" value="'.$list->female_under_five.'" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" placeholder="Female" />
                                        
									</div>
								</div>';
								
						$edittable .= '<div class="control-group">
									<label class="control-label" for="form-field-5">'.$list->disease_name.' &gt; 5</label>

									<div class="controls">
										<input class="span5" type="text" name="'.$list->disease_code.'_ofive_male" id="'.$list->disease_code.'_ofive_male" value="'.$list->male_over_five.'" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" placeholder="Male" />
										<input class="span5" type="text" name="'.$list->disease_code.'_ofive_female" id="'.$list->disease_code.'_ofive_female"  value="'.$list->female_over_five.'" onkeypress="return isNumberKey(event)" maxlength="5" onfocus="change(this,"#FF0000","#FFCCFF","#000000")" onblur="change(this,"","","")" placeholder="Female" />
									</div>
								</div>
								<hr />';
					
					endforeach;		
									
					
					
					$edittable .= '</div>
                        
                  </div>';
                    
                    
                    $edittable .= ' </div>
                                            
                                         </div>';
					$edittable .= '<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Other Unusual Diseases or Deaths</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												
										
                                        
					<div class="row-fluid">
						<div class="span12">
                        
                        
                        <div class="row-fluid">
									<div class="span4"><input type="text" name="undisonedesc" id="undisonedesc" value="' . $reportingform->undisonedesc . '" ></div>
									<div class="span4"><input type="text" name="undismale" id="undismale" value="' . $reportingform->undismale . '" onkeypress="return isNumberKey(event)" maxlength="5" requred="required"></div>
                                    <div class="span4"><input type="text" name="undisfemale" id="undisfemale" value="' . $reportingform->undisfemale . '" onkeypress="return isNumberKey(event)" maxlength="5" requred="required"></div>
						</div>
                        <hr>
                         <div class="row-fluid">
									<div class="span4"><input type="text" name="undissecdesc" id="undissecdesc" value="' . $reportingform->undissecdesc . '"></div>
									<div class="span4"><input type="text" name="undismaletwo" id="undismaletwo" value="' . $reportingform->undismaletwo . '" onkeypress="return isNumberKey(event)" maxlength="5" requred="required"></div>
                                    <div class="span4"><input type="text" name="undisfemaletwo" id="undisfemaletwo" value="' . $reportingform->undisfemaletwo . '" onkeypress="return isNumberKey(event)" maxlength="5" requred="required"></div>
						</div>
                        
                        <hr>
                        
                        <div class="row-fluid">
									<div class="span4">Other Consultations</div>
									<div class="span4"><input type="text" name="ocmale" id="ocmale" value="' . $reportingform->ocmale . '" requred="required"></div>
                                    <div class="span4"><input type="text" name="ocfemale" id="ocfemale" value="' . $reportingform->ocfemale . '" onkeypress="return isNumberKey(event)" maxlength="5" requred="required"> </div>
						</div>
                        
                        <hr>
                        
                        <div class="row-fluid">
									<div class="span4">Total Consultations</div>
									<div class="span4"><input type="text" name="total_consultations" id="total_consultations" value="' . $reportingform->total_consultations . '" readonly ="readonly" requred="required"></div>
                                    <div class="span4"><input type="button" value="CALCULATE" onClick="CalcConsultations()" ></div>
						</div>
                                
                                
                                
                        
                        </div>
                        
                  </div>
												
												
											</div>
										</div>
									</div>';
									
				$edittable .= '<div class="widget-box">
										<div class="widget-header widget-header-flat">
											<h4>Malaria Tests</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main">
												
<div class="control-group"><label class="control-label" for="form-field-1">Slides/RDT examined: </label><div class="controls"><input type="text" name="sre" id="sre" value="' . $reportingform->sre . '" onkeypress="return isNumberKey(event)" maxlength="5" requred="required"/>                           </div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Falciparum positive: </label><div class="controls"><input type="text" name="pf" id="pf" value="' . $reportingform->pf . '" onkeypress="return isNumberKey(event)" maxlength="5" requred="required"  />                              </div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Vivax positive: </label><div class="controls"><input type="text" name="pv" id="pv" value="' . $reportingform->pv . '" onkeypress="return isNumberKey(event)" maxlength="5"  requred="required" />                              </div>
</div>

<div class="control-group"><label class="control-label" for="form-field-1">Mixed Positive: </label><div class="controls"><input type="text" name="pmix" id="pmix" value="' . $reportingform->pmix . '" onkeypress="return isNumberKey(event)" maxlength="5" requred="required"  />                              </div>
</div>
												
												
											</div>
										</div>
									</div>';
                    
                    
                    if ($reportingform->approved_dist == 1) {
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
	
   public function mergeexport()
   {
	    $lists = $this->formsmodel->export_merge();
		
		$country_id = 1;
		
		 $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   	 $limit = count($diseasecount);
			   
		 $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
			   
		  $country_diseases = count($diseases);
		  $country = $this->countriesmodel->get_by_id($country_id)->row();
			   
		$diseasearray = array();
		foreach ($diseases->result() as $disease):
			$diseasearray[] = $disease->disease_code;
						
		endforeach; 
		$lists = $this->formsmodel->export_merge($diseasearray);
		
		$table = '<table width="100%" border="1">';
		$table .= '<thead>
		<tr>
		<th>Week No.</th><th>Year</th><th>Reporting date</th><th>EPI ID</th><th>User ID</th><th>Health facility ID</th><th>Contact No.</th><th>Region ID</th><th>District ID</th><th>Zone ID</th><th>Supporting NGO</th>';
		
		foreach ($diseases->result() as $disease):
			
			$table .= '<th>'.$disease->disease_code.'</th>';
			$table .= '<th>Disease ID</th>';
			$table .= '<th>'.$disease->disease_code.'_M_U_F</th>';
			$table .= '<th>'.$disease->disease_code.'_F_U_F</th>';
			$table .= '<th>'.$disease->disease_code.'_M_O_F</th>';
			$table .= '<th>'.$disease->disease_code.'_F_O_F</th>';
			$table .= '<th>'.$disease->disease_code.'_T_U_F</th>';
			$table .= '<th>'.$disease->disease_code.'_T_O_F</th>';
			
		endforeach;
		
		
		$table .= '
		<th>undisonedesc</th><th>undismale</th><th>undisfemale</th><th>undissecdesc</th><th>undismaletwo</th><th>undisfemaletwo</th><th>ocmale</th><th>ocfemale</th><th>total_consultations</th><th>SRE</th><th>Pf</th><th>Pv</th><th>Pmix</th><th>Total +</th><th>Total -</th><th>approved_dist</th><th>approved_region</th><th>approved_zone</th><th>approved_national</th><th>draft</th><th>alert_sent</th><th>entry_time</th><th>edit_date</th><th>edit_time</th><th>country_id</th>
		</tr>		
		</thead>
		<tbody>';
		
	
		
		$lists = $this->formsmodel->export_merge($diseasearray);	

		foreach ($lists as $key => $list) {
			$table .= '<tr>';
			$table .= '<td>'.$list->week_no.'</td><td>'.$list->reporting_year.'</td><td>'.$list->reporting_date.'</td><td>'.$list->epicalendar_id.'</td><td>'.$list->user_id.'</td><td>'.$list->healthfacility_id.'</td><td>'.$list->contact_number.'</td><td>'.$list->region_id.'</td><td>'.$list->district_id.'</td><td>'.$list->zone_id.'</td><td>'.$list->supporting_ngo.'</td>';
			
			foreach($diseasearray as $key=>$diseasecode):
				$male_under_five = $diseasecode.'_M_U_F';
				$female_under_five = $diseasecode.'_F_U_F';
				$male_over_five = $diseasecode.'_M_O_F';
				$female_over_five = $diseasecode.'_F_O_F';
				$under_element = $diseasecode.'_T_U_F';
				$over_element = $diseasecode.'_T_O_F';
				$disease_id = $diseasecode.'_ID';
				
				$table .= '<td>'.$list->$diseasecode.'</td>';
				$table .= '<td>'.$list->$disease_id.'</td>';
				$table .= '<td>'.$list->$male_under_five.'</td>';
				$table .= '<td>'.$list->$female_under_five.'</td>';
				$table .= '<td>'.$list->$male_over_five.'</td>';
				$table .= '<td >'.$list->$female_over_five.'</td>';				
				$table .= '<td >'.$list->$under_element.'</td>';
				$table .= '<td>'.$list->$over_element.'</td>';
								
			endforeach;
			
			$table .= '<td>'.$list->undisonedesc.'</td><td>'.$list->undismale.'</td><td>'.$list->undisfemale.'</td><td>'.$list->undissecdesc.'</td><td>'.$list->undismaletwo.'</td><td>'.$list->undisfemaletwo.'</td><td>'.$list->ocmale.'</td><td>'.$list->ocfemale.'</td><td>'.$list->total_consultations.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td><td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_positive.'</td><td>'.$list->total_negative.'</td><td>'.$list->approved_dist.'</td><td>'.$list->approved_region.'</td><td>'.$list->approved_zone.'</td><td>'.$list->approved_national.'</td><td>'.$list->draft.'</td><td>'.$list->alert_sent.'</td><td>'.$list->entry_time.'</td><td>'.$list->edit_date.'</td><td>'.$list->edit_time.'</td><td>'.$list->country_id.'</td>';
			
			$table .= '</tr>';
		}
		
		$table .= '
		</tbody>
		</table>';
		
		
		$filename = "Forms_Export_".date('dmY-his').".xls";
		
		$this->output->set_header("Content-Type: application/vnd.ms-word");
		$this->output->set_header("Expires: 0");
		$this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header("content-disposition: attachment;filename=".$filename."");
		
		
		$this->output->append_output($table);
   }
   
   
   public function mergedatabases()
   {
	    $lists = $this->formsmodel->export_merge();
		
		$country_id = 1;
		
		 $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   	 $limit = count($diseasecount);
			   
		 $diseases  = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
			   
		  $country_diseases = count($diseases);
		  $country = $this->countriesmodel->get_by_id($country_id)->row();
			   
		$diseasearray = array();
		foreach ($diseases->result() as $disease):
			$diseasearray[] = $disease->disease_code;
						
		endforeach; 
					
				
		$lists = $this->formsmodel->export_merge();	
		
		//last ID was 25657
		
		foreach ($lists as $key => $list) {
			
			$data = array(
						   'week_no' => $list->week_no,
						   'reporting_year' => $list->reporting_year,
						   'reporting_date' => $list->reporting_date,
						   'epicalendar_id' => $list->epicalendar_id,
						   'user_id' => $list->user_id,
						   'healthfacility_id' => $list->healthfacility_id,
						   'district_id' => $list->district_id,
						   'region_id' => $list->region_id,
						   'zone_id' => $list->zone_id,
						   'contact_number' => $list->contact_number,
						   'supporting_ngo' => $list->supporting_ngo,
						   'undisonedesc' => $list->undisonedesc,
						   'undismale' => $list->undismale,
						   'undisfemale' => $list->undisfemale,
						   'undissecdesc' => $list->undissecdesc,
						   'undismaletwo' => $list->undismaletwo,
						   'undisfemaletwo' => $list->undisfemaletwo,
						   'ocmale' => $list->ocmale,
						   'ocfemale' => $list->ocfemale,
						   'total_consultations' => $list->total_consultations,
						   'sre' => $list->sre,
						   'pf' => $list->pf,
						   'pv' => $list->pv,
						   'pmix' => $list->pmix,
						   'total_positive' => $list->total_positive,
						   'total_negative' => $list->total_negative,
						   'approved_dist' => $list->approved_dist,
						   'approved_region' => $list->approved_region,
						   'approved_zone' => $list->approved_zone,
						   'approved_national' => $list->approved_national,
						   'draft' => $list->draft,
						   'alert_sent' => $list->alert_sent,
						   'entry_date' => $list->entry_date,
						   'entry_time' => $list->entry_time,
						   'edit_date' => $list->edit_date,
						   'edit_time' => $list->edit_time,
						   'key' => $list->id,
					   );
					   $this->db->insert('forms', $data);
					   
					   $form_id = $this->db->insert_id();//get the ID of the saved record 
					   
			foreach($diseasearray as $key=>$diseasecode):
				$male_under_five = $diseasecode.'_M_U_F';
				$female_under_five = $diseasecode.'_F_U_F';
				$male_over_five = $diseasecode.'_M_O_F';
				$female_over_five = $diseasecode.'_F_O_F';
				$under_element = $diseasecode.'_T_U_F';
				$over_element = $diseasecode.'_T_O_F';
				$disease_element = $diseasecode.'_ID';
				
				//last ID was 358780
				$formdata = array(
							   'form_id' => $form_id,
							   'epicalendar_id' => $list->epicalendar_id,
							   'healthfacility_id' => $list->healthfacility_id,
							   'district_id' => $list->district_id,
							   'region_id' => $list->region_id,
							   'zone_id' => $list->zone_id,
							   'disease_id' => $list->$disease_element,
							   'disease_name' => $diseasecode,
							   'male_under_five' => $list->$male_under_five,
							   'female_under_five' => $list->$female_under_five,
							   'male_over_five' => $list->$male_over_five,
							   'female_over_five' => $list->$female_over_five,
							   'total_under_five' => $list->$under_element,
							   'total_over_five' => $list->$over_element,
							   'total_disease' => $list->$diseasecode,
				);
						   
				$this->db->insert('formsdata', $formdata);
				
								
			endforeach;
			
		
			
			
		}
		
		echo 'DATABASE MERGE COMPLETED';
   }
   
   
   public function mergealerts()
   {
	   $lists = $this->formsmodel->generatealerts();	
		
		foreach ($lists as $key => $list) {
			
			$disease = $this->diseasesmodel->get_by_id($list->disease_id)->row();
			
			if(empty($disease))
			{
				//figure out Pf,Sre and Pv
			}
			else
			{
				if($disease->alert_threshold==0)
				{
					$threshold = $disease->alert_threshold;
				}
				else
				{
					$threshold = ($disease->alert_threshold-1);
				}
				
				if ($list->total_disease > $threshold) {
					
					$alertdata = array(
										'reportingform_id' => $list->form_id,
										'reportingperiod_id' => $list->epicalendar_id,
										'disease_id' => $list->disease_id,
										'disease_name' => $list->disease_name,
										'healthfacility_id' => $list->healthfacility_id,
										'district_id' => $list->district_id,
										'region_id' => $list->region_id,
										'zone_id' => $list->zone_id,
										'cases' => $list->total_disease,
										'deaths' => 0,
										'notes' => 'None',
										'verification_status' => 0,
										'include_bulletin' => 0
									);
					$this->db->insert('formalerts', $alertdata);
					
				}// end total check
			}// end empty check
			
			
		}
		
		echo 'DATABASE MERGE COMPLETED';
	   
   }
   
   
   public function joinalerts()
   {
	   $forms = $this->formsmodel->getforms();
	   
	   //last alert ID 16044
	   
	   foreach ($forms as $key => $form) {
		   
		   $fieldname = 'key';
		   $alerts = $this->formsmodel->getalerts($form->$fieldname);
		   
		   foreach ($alerts as $key => $alert):
		   
		   $data = array(
               'reportingform_id' => $form->$fieldname,
               'reportingperiod_id' => $form->epicalendar_id,
               'disease_id' => $alert->disease_id,
               'disease_name' => $alert->disease_name,
               'healthfacility_id' => $form->healthfacility_id,
               'district_id' => $form->district_id,
               'region_id' => $form->region_id,
               'zone_id' => $form->zone_id,
               'cases' => $alert->cases,
               'deaths' => $alert->deaths,
               'notes' => 'N/A',
               'verification_status' => $alert->verification_status,
               'include_bulletin' => $alert->include_bulletin,
               'outcome' => $alert->outcome,
           );
           $this->db->insert('formalerts', $data);
		   
		   
		   endforeach;
		   
	   }
	   
	   echo 'DATABASE ALERT MERGE COMPLETED';
   }


   public function updaterecords()
   {
       $data = array(
           'country_id' => 1,
       );
       $id=0;
       $this->db->where('country_id', $id);
       $this->db->update('formalerts', $data);

       echo 'SUCCESSFUL UPDATE';
   }

   public function updatetimeliness()
   {
       $forms = $this->formsmodel->get_list();

       foreach($forms as $form):


           $epdcalendar = $this->epdcalendarmodel->get_by_id($form['epicalendar_id'])->row();

           // Create a new DateTime object
           $date = new DateTime($epdcalendar->to);

           // Reports have to be submitted the next monday
           $date->modify('next monday');

           // Output
           $validation_date = $date->format('Y-m-d');


            if($form['reporting_date']>$validation_date)
            {
                $timely = 0;
            }
            else
            {
                $timely = 1;
            }
           /**
           if($form['reporting_date']==$epdcalendar->from)
           {
               $date = 'SAME';
           }
           else
           {
               $date = 'NOT SAME';
           }


           echo $epdcalendar->from.' - '.$form['reporting_date'].' ('.$timely.'/'.$date.') <br>';

            **/


           $data = array(
               'timely' => $timely,
           );

           $this->db->where('id', $form['id']);
           $this->db->update('forms', $data);



       endforeach;
   }

   public function delete($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->db->delete('forms', array('id' => $id));
       redirect('forms','refresh');
   }

   public function theweek()
   {
       $ddate = "2018-08-13";
       $date = new DateTime($ddate);
       $week = $date->format("W");
       echo "Weeknummer: $week";
   }







}
