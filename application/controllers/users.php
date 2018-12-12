<?php

class Users extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('usersmodel');
   }

   public function index_old()
   {
       
	  //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	  
	   
	   $data = array(
           'rows' => $this->db->get('users'),
       );
	   
	   $data['countries'] = $this->countriesmodel->get_list();
	    $data['zones'] = $this->zonesmodel->get_list();
	   $data['regions'] = $this->regionsmodel->get_list();
	   $data['districts'] = $this->districtsmodel->get_list();
	   
       $this->load->view('users/index', $data);
   }
   
   
   public function index()
   {
	   if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	  if (getRole() == 'SuperAdmin') {
		$count = count($this->usersmodel->get_list());
	  }

	 if (getRole() == 'Admin') {
		
			$count = count($this->usersmodel->get_list_by_country($country_id));
	 }


	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/users/index/';
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
		
		if (getRole() == 'SuperAdmin') {
		
			$data = array(
			   'rows' => $this->usersmodel->get_paged_list($config['per_page'],$this->uri->segment(3)),
		   );
	   
		}

		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->usersmodel->get_paged_country_list($config['per_page'],$this->uri->segment(3),$country_id),
		   );
	    }
		
		$data['links'] = $this->pagination->create_links();
		
	if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            
        }
		  
	   $data['countries'] = $this->countriesmodel->get_list();
	   $data['country_id'] = $country_id;
	  
	  $this->load->view('users/index', $data);
	  
	   
	   
   }
   
   public function export()
   {
	   
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   if (getRole() == 'Admin') {
	   	$users = $this->usersmodel->get_list_by_country($country_id);
	   }
	   else
	   {
		   $users = $this->usersmodel->get_list();
	   }
	   
	   $table = '<style>
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
		$table .= '<tr><th>First Name</th><th>Lats Name</th><th>Health Facility</th><th>Organization</th><th>Email</th><th>Contact Number</th><th>Registration Type</th><th>Zone</th><th>Region</th><th>District</th>';
	   foreach($users as $key=>$user)
	   {
		  if($user['level']==2)
			{
				$level= 'Regioinal FP';
			}
			else if($user['level']==3)
			{
				$level= 'HF';
			}
			else if($user['level']==1)
			{
				$level= 'Zone';
			}
			else if($user['level']==4)
			{
				$level= 'National';
			}
			else if($user['level']==6)
			{
				$level= 'District FP';
			}
			else
			{
				$level= 'Stake holder';
			} 
			
			$healthfacility_id = $user['healthfacility_id'];
			$zone_id = $user['zone_id'];
			$region_id = $user['region_id'];
			$district_id = $user['district_id'];
			
			if($zone_id==0)
			{
				$zone = '';
			}
			else
			{
				$thezone = $this->zonesmodel->get_by_id($zone_id)->row();
				
				$zone = $thezone->zone;
			}
			
			if($region_id==0)
			{
				$region = '';
			}
			else
			{
				$theregion = $this->regionsmodel->get_by_id($region_id)->row();
				
				$region = $theregion->region;
			}
			
			if($district_id==0)
			{
				$district = '';
			}
			else
			{
				$thedistrict = $this->districtsmodel->get_by_id($district_id)->row();
				
				$district = $thedistrict->district;
			}
			
			if($healthfacility_id==0)
			{
				$healthfacility = '';
			}
			else
			{
				$health_facility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
				
				$healthfacility = $health_facility->health_facility;
			}
		  
		   $table .= '<tr><td>'.$user['fname'].'</td><td>'.$user['lname'].'</td><td>'.$healthfacility.'</td><td>'.$user['organization'].'</td><td>'.$user['email'].'</td><td>'.$user['contact_number'].'</td><td>'.$level.'</td><td>'.$zone.'</td><td>'.$region.'</td><td>'.$district.'</td>';
	   }
	   
	   $table .= '</tbody></table>';
	   
	   $filename = "Users_List_".date('dmY-his').".xls";
		
		$this->output->set_header("Content-Type: application/vnd.ms-word");
		$this->output->set_header("Expires: 0");
		$this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header("content-disposition: attachment;filename=".$filename."");
		
		
		$this->output->append_output($table);
   }
   
   public function filter()
   {
	   
	   //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {

		redirect('home', 'refresh');

	  }
	  
	  $country_id = $this->input->post('country_id');
	  $zone_id = $this->input->post('zone_id');
	  $region_id = $this->input->post('region_id');
	  $district_id = $this->input->post('district_id');
	  $level = $this->input->post('level');
	  
	     if(empty($country_id))
		 {
			 if(getRole() == 'Admin')
			 {
				 $country_id = $this->erkanaauth->getField('country_id');
			 }
			 else
			 {
			 	$country_id = 0;
			 }
		 }
		 else
		 {
			 $country_id = $this->input->post('country_id');
		 }
		  if(empty($zone_id))
		 {
			 $zone_id = 0;
		 }
		 else
		 {
			 $zone_id = $this->input->post('zone_id');
		 }
		 
		  if(empty($region_id))
		 {
			 $region_id = 0;
		 }
		  else
		 {
			 $region_id = $this->input->post('region_id');
		 }
		 
		 if(empty($district_id))
		 {
			$district_id = 0;
		 }
		  else
		 {
			 $district_id = $this->input->post('district_id');
		 }
		 
		  if(empty($level))
		 {
			 $level = 0;
		 }
		  else
		 {
			 $level = $this->input->post('level');
		 }
	  
	  $count = count($this->usersmodel->get_filter_list($country_id,$zone_id,$region_id,$district_id,$level));
	  
	  //echo $count;
	  
	  
	  $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/users/userfilter/'.$country_id.'/'.$zone_id.'/'.$region_id.'/'.$district_id.'/'.$level.'/';
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 7;
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
  
	    
	   $data = array(
           'rows' => $this->usersmodel->get_paged_filter_list($config['per_page'],$this->uri->segment(7),$country_id,$zone_id,$region_id,$district_id,$level),
       );
	   
	   
	   if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);;
            
        }
		
		$data['countries'] = $this->countriesmodel->get_list();
		
		$data['links'] = $this->pagination->create_links();
		
		$data['country_id'] = $country_id;
	 
	   
       $this->load->view('users/index', $data);
   }
   
   public function userfilter($country_id,$zone_id,$region_id,$district_id,$level)
   {
	   
	   //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {

		redirect('home', 'refresh');

	  }
	  
	  
	  
	  $count = count($this->usersmodel->get_filter_list($country_id,$zone_id,$region_id,$district_id,$level));
	  
	  //echo $count;
	  
	  
	  $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/users/userfilter/'.$country_id.'/'.$zone_id.'/'.$region_id.'/'.$district_id.'/'.$level.'/';
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
  
	    
	   $data = array(
           'rows' => $this->usersmodel->get_paged_filter_list($config['per_page'],$this->uri->segment(8),$country_id,$zone_id,$region_id,$district_id,$level),
       );
	   
	   
	   if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);;
            
        }
		
		$data['countries'] = $this->countriesmodel->get_list();
		
		$data['links'] = $this->pagination->create_links();
	 
	   
       $this->load->view('users/index', $data);
   }
   
   
   public function find($letter)
   {
	   
	   //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {

		redirect('home', 'refresh');

	  }
	  
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	  if(getRole() == 'SuperAdmin')
	  {
		   $count = count($this->usersmodel->get_letter_filter_list($letter));
	  }
	  
	  if(getRole() == 'Admin')
	  {
		 $count = count($this->usersmodel->get_letter_country_filter_list($letter,$country_id));
		  
	  }
	  
	  
	  
	  //echo $count;
	  
	  
	  $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/users/findfilter/'.$letter.'/';
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
  
	   if(getRole() == 'SuperAdmin')
	  {
		   $data = array(
			   'rows' => $this->usersmodel->get_paged_letter_filter_list($config['per_page'],$this->uri->segment(3),$letter),
		   );
	  }
	  
	  if(getRole() == 'Admin')
	  {
		  $data = array(
			   'rows' => $this->usersmodel->get_paged_letter_country_filter_list($config['per_page'],$this->uri->segment(3),$letter,$country_id),
		   );
		  
	  }
	   
	   
	   if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);;
            
        }
		
		$data['countries'] = $this->countriesmodel->get_list();
		
		$data['links'] = $this->pagination->create_links();
	 
	   
       $this->load->view('users/index', $data);
   }
   
    public function findfilter($letter)
   {
	   
	   //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {

		redirect('home', 'refresh');

	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	  if(getRole() == 'SuperAdmin')
	  {
		   $count = count($this->usersmodel->get_letter_filter_list($letter));
	  }
	  
	  if(getRole() == 'Admin')
	  {
		 $count = count($this->usersmodel->get_letter_country_filter_list($letter,$country_id));
		  
	  }
	  
	  
	  $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/users/findfilter/'.$letter.'/';
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 4;
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
  
	    
	   if(getRole() == 'SuperAdmin')
	  {
		   $data = array(
			   'rows' => $this->usersmodel->get_paged_letter_filter_list($config['per_page'],$this->uri->segment(4),$letter),
		   );
	  }
	  
	  if(getRole() == 'Admin')
	  {
		  $data = array(
			   'rows' => $this->usersmodel->get_paged_letter_country_filter_list($config['per_page'],$this->uri->segment(4),$letter,$country_id),
		   );
		  
	  }
	   
	   
	   
	   if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);;
            
        }
		
		$data['countries'] = $this->countriesmodel->get_list();
		
		$data['links'] = $this->pagination->create_links();
	 
	   
       $this->load->view('users/index', $data);
   }

   public function add()
   {
	   //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	   $data = array();
	   $data['country_id'] = $country_id;
	   $data['countries'] = $this->countriesmodel->get_list();
	   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   $data['zones'] = $this->zonesmodel->get_list();
	   $data['regions'] = $this->regionsmodel->get_list();
	   $data['districts'] = $this->districtsmodel->get_list();
	   $data['roles'] = $this->role->get_list();
       $this->load->view('users/add',$data);
   }

   public function add_validate()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	   $hfid = $this->input->post('healthfacility_id');
	  $level = $this->input->post('level');
		  
		  if($level==3)
		  {
			  if(empty($hfid))
			  {
				  $is_required = 1;
			  }
			  else
			  {
				  $is_required = 0;
			  }
		  }
		  else
		  {
			  $is_required = 0;
		  }
		 
		 
	   $this->load->library('form_validation');
	   $this->form_validation->set_rules('level', 'Registration Type', 'trim|required|callback__check_Captured['.$is_required.']');
       $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
       $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
       //$this->form_validation->set_rules('healthfacility_id', 'Health Facility', 'trim|required');
       $this->form_validation->set_rules('username', 'Username', 'trim|required');
       $this->form_validation->set_rules('password', 'Password', 'trim|required');
	   $this->form_validation->set_rules('retypepassword', 'Retype Password', 'trim|required');	   
       $this->form_validation->set_rules('role_id', 'Role', 'trim|required');
       $this->form_validation->set_rules('active', 'Active', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
		   
		  if($level==3)//HF
		  {
			  $healthfacility_id = $this->input->post('healthfacility_id');
			  $district_id = $this->input->post('district_id');
			  $region_id = $this->input->post('region_id');
			  $zone_id = $this->input->post('zone_id');
		  }
		  
		   if($level==6)//District
		  {
			  $healthfacility_id = 0;
			  $dist_id = $this->input->post('district_id');
			  
			  if(empty($dist_id))
			  {
				  $district_id = 0;
			  }
			  else
			  {
				  $district_id = $dist_id;
			  }
			  
			  $region_id = $this->input->post('region_id');
			  $zone_id = $this->input->post('zone_id');
		  }
		  
		  if($level==2)//FP
		  {
			  $healthfacility_id = 0;
			  $dist_id = $this->input->post('district_id');
			  
			  if(empty($dist_id))
			  {
				  $district_id = 0;
			  }
			  else
			  {
				  $district_id = $dist_id;
			  }
			  
			  $region_id = $this->input->post('region_id');
			  $zone_id = $this->input->post('zone_id');
		  }
		  
		  if($level==1)//Zonal
		  {
			 $healthfacility_id = 0;
			 $zone_id = $this->input->post('zone_id');
			 
			  $dist_id = $this->input->post('district_id');
			  
			  if(empty($dist_id))
			  {
				  $district_id = 0;
			  }
			  else
			  {
				  $district_id = $dist_id;
			  }
			  
			  $reg_id = $this->input->post('region_id');
			  
			  if(empty($reg_id))
			  {
				  $region_id = 0;
			  }
			  else
			  {
				  $region_id = $reg_id;
			  }
		  }
		  
		  if($level==4)//National
		  {
			 $healthfacility_id = 0;
			 $zn_id = $this->input->post('zone_id');
			 
			 if(empty($zn_id))
			  {
				  $zone_id = 0;
			  }
			  else
			  {
				  $zone_id = $this->input->post('zone_id');
			  }
			 
			  $dist_id = $this->input->post('district_id');
			  
			  if(empty($dist_id))
			  {
				  $district_id = 0;
			  }
			  else
			  {
				  $district_id = $dist_id;
			  }
			  
			  $reg_id = $this->input->post('region_id');
			  
			  if(empty($reg_id))
			  {
				  $region_id = 0;
			  }
			  else
			  {
				  $region_id = $reg_id;
			  }
		  }
		  
		  if($level==5)//Stake Holder
		  {
			  $healthfacility_id = 0;
			 $zn_id = $this->input->post('zone_id');
			 
			 if(empty($zn_id))
			  {
				  $zone_id = 0;
			  }
			  else
			  {
				  $zone_id = $this->input->post('zone_id');
			  }
			 
			  $dist_id = $this->input->post('district_id');
			  
			  if(empty($dist_id))
			  {
				  $district_id = 0;
			  }
			  else
			  {
				  $district_id = $dist_id;
			  }
			  
			  $reg_id = $this->input->post('region_id');
			  
			  if(empty($reg_id))
			  {
				  $region_id = 0;
			  }
			  else
			  {
				  $region_id = $reg_id;
			  }
		  }
		  
		  
		     $data = array(
               'fname' => $this->input->post('fname'),
               'lname' => $this->input->post('lname'),
               'healthfacility_id' => $healthfacility_id,
			   'organization' => $this->input->post('organization'),
			   'email' => $this->input->post('email'),
			   'contact_number' => $this->input->post('contact_number'),
               'username' => $this->input->post('username'),
               'password' => md5($this->input->post('password')),
               'role_id' => $this->input->post('role_id'),
               'active' => $this->input->post('active'),
			   'level' => $this->input->post('level'),
			   'zone_id' => $zone_id,
			   'region_id' => $region_id,
			   'district_id' => $district_id,
			   'country_id' => $this->input->post('country_id'),
           );
           $this->db->insert('users', $data);		   
		   $id = $this->db->insert_id();
		   
		   
		    $fname = $this->input->post('fname');
            $lname = $this->input->post('lname');
			$designation = 'Staff';
			$organization = $this->input->post('organization');
			$contact_number = $this->input->post('contact_number');
			$email = $this->input->post('email');
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$country_id = $this->input->post('country_id');
			
			$country = $this->countriesmodel->get_by_id($country_id)->row();
			
			$row = $this->db->get_where('users', array('id' => $id))->row();
			
			$about_me = 'My name is '.$fname.' '.$lname.'. I work at '.$organization.' as the '.$designation.' and my current location is '.$country->country_name.'. I can be reached through the following number '.$contact_number;
		   
		   //add profile
		   $data = array(
               'user_id' => $row->id,
               'date_of_birth' => '0000-00-00',
			   'gender' => '',
               'address' => '',
               'post_code' => '',
               'city' => 'City',
               'country' => $country->country_name,
               'telephone' => $this->input->post('contact_number'),
               'extension' => '',
               'mobile' => '',
               'official_email' =>  $this->input->post('email'),
               'personal_email' => '',
               'facebook' => '',
               'twitter' => '',
               'google_plus' => '',
               'residential_address' => '',
               'photo' => '',
			   'about_me' => $about_me,
           );
           $this->db->insert('profiles', $data);
		   
		   
		
			if($row->healthfacility_id !=0)
			{
				 $hfdata = array(
					  'activated' => 1,
				  );
				   
				   $healthfacility_id = $row->healthfacility_id;
				   
				   $this->db->where('id', $healthfacility_id);
				   $this->db->update('healthfacilities', $hfdata);
			}


           $this->load->library('email');

            //SMTP & mail configuration
           $config = array(
               'protocol'  => 'smtp',
               'smtp_host' => 'ssl://smtp.googlemail.com',
               'smtp_port' => 465,
               'smtp_user' => 'ewarnemro@gmail.com',
               'smtp_pass' => 'ewarnpass',
               'mailtype'  => 'html',
               'charset'   => 'utf-8'
           );
           $this->email->initialize($config);
           $this->email->set_mailtype("html");
           $this->email->set_newline("\r\n");

            //Email content
           $htmlContent = '<p><strong>Password Activation on EWARN</strong></p>';
           $htmlContent .= '<p>Hi '.$fname.' '.$lname.'. You have been added as a new user on the EWARN platform. Please find your login details below:
           <br><br>
           Username: '.$username.'<br>
           Password: '.$password.'<br><br>
           Kind regards,<br>
           EWARN Team           
           </p>
           <p><i>This is an autogenerated email, please do not repond.</i></p>';

           $this->email->to($email);
           $this->email->from('ewarnemro@gmail.com','EWARN');
           $this->email->subject('Password Activation on EWARN');
           $this->email->message($htmlContent);

           $this->email->send();
		   
		   
           redirect('users', 'refresh');
       }
   }

   public function edit($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	   $row = $this->db->get_where('users', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );

	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   if(getRole() != 'SuperAdmin')
	  {
		  if($row->country_id !=$country_id)
		  {
				redirect('home', 'refresh');
		  }
	  }
	  
	  if(getRole() == 'Admin' && $row->role_id==1) 
	  {
		  redirect('users', 'refresh');
	  }
	  
	   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   $data['roles'] = $this->role->get_list();
       $this->load->view('users/edit', $data);
   }

   public function edit_validate($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	 if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
       $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
       //$this->form_validation->set_rules('healthfacility_id', 'Health Facility', 'trim|required');
       $this->form_validation->set_rules('username', 'Username', 'trim|required');
       //$this->form_validation->set_rules('password', 'Password', 'trim|required');
       //$this->form_validation->set_rules('role_id', 'Role', 'trim|required');
       $this->form_validation->set_rules('active', 'Active', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
		   
		   $passvalue = $this->input->post('password');
		   
		   if(empty($passvalue))
		   {
			   $password = $this->input->post('oldpassword');
		   }
		   else
		   {
			   $password = md5($passvalue);
		   }
           $data = array(
               'fname' => $this->input->post('fname'),
               'lname' => $this->input->post('lname'),
			   'contact_number' => $this->input->post('contact_number'),
			   'email' => $this->input->post('email'),
               'username' => $this->input->post('username'),
               'password' => $password,
               'active' => $this->input->post('active'),
           );
           $this->db->where('id', $id);
           $this->db->update('users', $data);
           redirect('users', 'refresh');
       }
   }
   
    public function _check_Captured($level,$params)
   {
	   
	    list($isrequired) = explode(',', $params);
		
		  
	   if($isrequired==1)
	   {
		   $this->form_validation->set_message('_check_Captured', 'You must select a health facility.');
		   return FALSE;
	   }
	   
		   return TRUE;
	 
   }

   public function delete($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	   $this->db->delete('users', array('id' => $id));
       redirect('users', 'refresh');
   }
   
   public function deactivate($id)
   {
	    $data = array(
              'active' => 0,
           );
           $this->db->where('id', $id);
           $this->db->update('users', $data);
           redirect('users', 'refresh');
   }
   
   public function activate($id)
   {
	    $data = array(
              'active' => 1,
           );
           $this->db->where('id', $id);
           $this->db->update('users', $data);
		   
		$row = $this->db->get_where('users', array('id' => $id))->row();
		
		if($row->healthfacility_id !=0)
		{
			 $hfdata = array(
				  'activated' => 1,
			  );
			   
			   $healthfacility_id = $row->healthfacility_id;
			   
			   $this->db->where('id', $healthfacility_id);
			   $this->db->update('healthfacilities', $hfdata);
		}
	
           redirect('users', 'refresh');
   }
   
   function gethealthfacility()
   {
	    $hfcode = trim(addslashes(htmlspecialchars(rawurldecode($_POST['hfcode']))));
		
		if(empty($hfcode))
		{
			echo '<tr><td colspan="2"><div class="alert alert-danger">Please select all the required data</div></td></tr>';
		}
		else
		{
			$healthfacility = $this->healthfacilitiesmodel->get_by_hfcode($hfcode)->row();
			if(empty($healthfacility))
			{
				echo '<tr><td colspan="2"><div class="alert alert-danger">Please enter the correct health facility code</div></td></tr>';
			}
			else
			{
				$hfdata = '<table><tr><td>Health Facility Name</td><td><input type="text" name="hfname" id="hfname" value="'.$healthfacility->health_facility.'"></td></tr>';
				$hfdata .= '<tr><td>Catchment Population</td><td><input type="text" name="hfname" id="hfname" value="'.$healthfacility->catchment_population.'">
				<input type="hidden" name="healthfacility_id" id="healthfacility_id" value="'.$healthfacility->id.'">
				</td></tr>';
				$hfdata .= '<tr><td>Health Facility Type</td><td>
				<select name="health_facility_type" id="health_facility_type">
				<option value="">-Select facility type-</option>
				<option value="MCH">MCH</option>
				<option value="Hospital">Hospital</option>
				<option value="Other">Other</option>
				</select>
				
				</td></tr>';
				$hfdata .= '</table>';
				
				echo $hfdata;
			}
		}
   }
   
   function getdistricts()
   {
	   $region_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['region_id']))));
	   
	   $districts = $this->districtsmodel->get_by_region($region_id);
	   
	   $user_country_id = $this->erkanaauth->getField('country_id');
$user_country = $this->countriesmodel->get_by_id($user_country_id)->row();


	  	   
	   $districtselect = '<select name="district_id" id="district_id">';
	    	$districtselect .= '<option value="">All '.$user_country->third_admin_level_label.'</option>';   
	   foreach($districts as $key => $district)
       {
		   $districtselect .= '<option value="'.$district['id'].'">'.$district['district'].'</option>';
	   }
	   
	   $districtselect .= '</select>';
	   
	   echo $districtselect;
   }
   
   function getzones()
   {
	   $country_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['country_id']))));
	   
	   $zones = $this->zonesmodel->get_country_list($country_id);
	   
       $country = $this->countriesmodel->get_by_id($country_id)->row();
	   
	   if(empty($country))
	   {
		    $user_country_id = $this->erkanaauth->getField('country_id');
			$country = $this->countriesmodel->get_by_id($user_country_id)->row();

	   }
	  	 
		 
	   $zoneselect = '<select name="zone_id" id="zone_id" onChange="GetRegions(this)">';
	    $zoneselect .= '<option value="">All '.$country->first_admin_level_label.'</option>';  
		 if(empty($zones))
		 {
			 
			   $zoneselect .= '<option value="">No Zones</option>';
		  
		 }
		 else
		 { 
		   foreach($zones as $key => $zone)
		   {
			   $zoneselect .= '<option value="'.$zone['id'].'">'.$zone['zone'].'</option>';
		   }
		 }
	   
	   $zoneselect .= '</select>';
	   
	   echo $zoneselect;
   }
   
   function getregions()
   {
	   $zone_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['zone_id']))));
	   
	   $regions = $this->regionsmodel->get_by_zone($zone_id);
	   
	    $user_country_id = $this->erkanaauth->getField('country_id');
$user_country = $this->countriesmodel->get_by_id($user_country_id)->row();
	  	 
		 
	   $regionselect = '<select name="region_id" id="region_id" onChange="GetDistricts(this)">';
	    	$regionselect .= '<option value="">All '.$user_country->second_admin_level_label.'</option>';  
		 if(empty($regions))
		 {
			 $regionsdata = $this->regionsmodel->get_list();
			 foreach($regionsdata as $rkey => $regionsdatum)
		   {
			  // $regionselect .= '<option value="'.$regionsdatum['id'].'">'.$regionsdatum['region'].'</option>';
			   
		   }
		 }
		 else
		 { 
		   foreach($regions as $key => $region)
		   {
			   $regionselect .= '<option value="'.$region['id'].'">'.$region['region'].'</option>';
		   }
		 }
	   
	   $regionselect .= '</select>';
	   
	   echo $regionselect;
   }
   
   function getallregions()
   {
	   $zone_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['zone_id']))));
	   
	   $regions = $this->regionsmodel->get_by_zone($zone_id);
	   $user_country_id = $this->erkanaauth->getField('country_id');
       $user_country = $this->countriesmodel->get_by_id($user_country_id)->row(); 
		 
	   $regionselect = '<select name="region_id" id="region_id" onChange="GetDistricts(this)">';
	    	$regionselect .= '<option value="">Select '.$user_country->second_admin_level_label.'</option>';  
		 if(empty($regions))
		 {
			 $regionselect .= '<option value="">No records</option>';
			 /**
			 $regionsdata = $this->regionsmodel->get_list();
			 foreach($regionsdata as $rkey => $regionsdatum)
		   {
			   $regionselect .= '<option value="'.$regionsdatum['id'].'">'.$regionsdatum['region'].'</option>';
		   }
		   
		   **/
		 }
		 else
		 { 
		   foreach($regions as $key => $region)
		   {
			   $regionselect .= '<option value="'.$region['id'].'">'.$region['region'].'</option>';
		   }
		 }
	   
	   $regionselect .= '</select>';
	   
	   echo $regionselect;
   }
   
   
    function gethealthfacilities()
    {
        $district_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
        
        $healthfailities = $this->healthfacilitiesmodel->get_by_district($district_id);
        
        $district = $this->districtsmodel->get_by_id($district_id)->row();
		if (!empty($healthfailities)) {
			
			$facilityselect = '<select name="healthfacility_id" id="healthfacility_id">';
			
			 foreach ($healthfailities as $key => $healthfacility):
                $facilityselect .= '<option value="' . $healthfacility['id'] . '">' . $healthfacility['health_facility'] . '</option>';
			 endforeach;
			 
			 $facilityselect .= '</select>';
		}
		else
		{
			$facilityselect = ' <div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">
											<i class="icon-remove"></i>
										</button>

										<strong>
											<i class="icon-remove"></i>
											Note!
										</strong>
Please select all the administrative levels to get the health facility.
										<br />
									</div>';
			$facilityselect .= '<input type="hidden" name="healthfacility_id" id="healthfacility_id" value="0">';
		}
        
        
                
        echo $facilityselect;
        
    }


    function get_users($region_id)
    {
        $rows = $this->usersmodel->get_list_by_regions($region_id);

        foreach ($rows as $row):

            echo $row['id'].' | '.$row['fname'].' | '.$row['lname'].''.$row['district_id'].'<br>';

        endforeach;

    }

    function updateuser($user_id,$region_id)
    {
        $data = array(
            'region_id' => $region_id,
        );
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }
	
	
	function getroles()
	{
		
		$level = trim(addslashes(htmlspecialchars(rawurldecode($_POST['level']))));
		$roles = $this->role->get_list();	
		
		$select = '<select name="role_id" id="role_id">';
		
		if($level==4)
		{
			if(getRole() == 'Admin')
			{
				$select .= '<option value="3" selected="selected">User</option>';
				$select .= '<option value="2" >Admin</option>';
			}
			else
			{
				foreach($roles as $key => $role)
				{
					 if($role['id']==3){
						 $selected = 'selected="selected"';
					 }
					 else
					 {
						 $selected = '';
					 }
					 
					$select .= '<option value="'.$role['id'].'" '.$selected.'>'.$role['name'].'</option>';
				}
			}
		}
		else
		{
			$select .= '<option value="3">User</option>';
		}
		
		$select .= '</select>';
		
		echo $select;
	}
   
   function checkusername()
   {
	    $username = trim(addslashes(htmlspecialchars(rawurldecode($_POST['username']))));
      
	  $user = $this->usersmodel->get_by_username($username)->row();
	  $count=count($user);
      $HTML='';
      if($count > 0){
        $HTML='<font color="#FF0000"><strong>USERNAME ALREADY EXISTS</strong>';
      }else{
        $HTML='<font color="#00FF33"><strong>USERNAME AVAILABLE</strong></font>';
      }
      echo $HTML;
	
   }
   
   public function activation()
   {
	   $activation = $this->input->post('activation');
	   
	   if (!empty($_POST['user_id'])) {
		   foreach ($_POST['user_id'] as $row => $id) {
			   $user_id = $id;
			   
			   $data = array(
               'active' => $activation,
           		);
				
           		$this->db->where('id', $user_id);
				$this->db->update('users', $data);
				
				$user = $this->usersmodel->get_by_id($user_id)->row();
				
				if($activation==1)
				{
					if($user->healthfacility_id !=0)
					{
						  $hfdata = array(
						  'activated' => 1,
						  );
					   
					   $healthfacility_id = $user->healthfacility_id;
					   
					   $this->db->where('id', $healthfacility_id);
					   $this->db->update('healthfacilities', $hfdata);
					}
				}
			   
		   }
		   
	   }
	   
	   redirect('users', 'refresh');
   }

    public function sendemail(){

       //https://www.codexworld.com/codeigniter-send-email-gmail-smtp-server/
        //Load email library
        $this->load->library('email');

//SMTP & mail configuration
        $config = array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'ewarnemro@gmail.com',
            'smtp_pass' => 'ewarnpass',
            'mailtype'  => 'html',
            'charset'   => 'utf-8'
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

//Email content
        $htmlContent = '<h1>Password Activation on EWARN</h1>';
        $htmlContent .= '<p>Hi Joash Gomba. You have been added as a new user on the EWARN platform. Please find your login details below:
           <br><br>
           <strong>Username:</strong> xxxxx<br>
           <strong>Password:</strong> yyyyy<br><br>
           Kind regards,<br><br>
           EWARN Team           
           </p>
           
           <p>This is an autogenerated email, please do not repond.</p>';

        $this->email->to('joash_gomba@yahoo.com');
        $this->email->from('ewarnemro@gmail.com','Joash Gomba');
        $this->email->subject('How to send email via SMTP server in CodeIgniter');
        $this->email->message($htmlContent);

        $this->email->send();


        /**
        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 25,
        'smtp_user' => 'joashgomba@gmail.com',
        'smtp_pass' => '1Menkaure$',
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from("joashgomba@gmail.com", "Joash Gomba");
        $this->email->to("jasgomba@yahoo.com");
        $this->email->subject("Testing EMails");
        $this->email->message("It would be cool if you received this email");
        if (!$this->email->send()) {
        show_error($this->email->print_debugger()); }
        else {
        echo 'Your Email has been sent';
        }

         **/


    }

}
