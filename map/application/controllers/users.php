<?php

class Users extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('usersmodel');
   }

   public function index()
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
	   
	    $data['zones'] = $this->zonesmodel->get_list();
	   $data['regions'] = $this->regionsmodel->get_list();
	   $data['districts'] = $this->districtsmodel->get_list();
	   
       $this->load->view('users/index', $data);
   }
   
   public function export()
   {
	   $users = $this->usersmodel->get_list();
	   
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

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	  $zone_id = $this->input->post('zone_id');
	  $region_id = $this->input->post('region_id');
	  $district_id = $this->input->post('district_id');
	  $level = $this->input->post('level');
  
	    
	   $data = array(
           'rows' => $this->usersmodel->get_filter($zone_id,$region_id,$district_id,$level),
       );
	   
	    $data['zones'] = $this->zonesmodel->get_list();
	   $data['regions'] = $this->regionsmodel->get_list();
	   $data['districts'] = $this->districtsmodel->get_list();
	   
       $this->load->view('users/filterindex', $data);
   }

   public function add()
   {
	   //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $data = array();
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

	 
	  if(getRole() != 'SuperAdmin')

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
				  $zone_id = $dist_id;
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
				  $zone_id = $dist_id;
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
           );
           $this->db->insert('users', $data);
           redirect('users', 'refresh');
       }
   }

   public function edit($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	   $row = $this->db->get_where('users', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
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

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
       $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
       $this->form_validation->set_rules('healthfacility_id', 'Health Facility', 'trim|required');
       $this->form_validation->set_rules('username', 'Username', 'trim|required');
       //$this->form_validation->set_rules('password', 'Password', 'trim|required');
       $this->form_validation->set_rules('role_id', 'Role', 'trim|required');
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
               'healthfacility_id' => $this->input->post('healthfacility_id'),
			   'contact_number' => $this->input->post('contact_number'),
			   'email' => $this->input->post('email'),
               'username' => $this->input->post('username'),
               'password' => $password,
               'role_id' => $this->input->post('role_id'),
               'active' => $this->input->post('active'),
			   'level' => $this->input->post('level'),
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
	  	   
	   $districtselect = '<select name="district_id" id="district_id">';
	    	$districtselect .= '<option value="">All DIstricts</option>';   
	   foreach($districts as $key => $district)
       {
		   $districtselect .= '<option value="'.$district['id'].'">'.$district['district'].'</option>';
	   }
	   
	   $districtselect .= '</select>';
	   
	   echo $districtselect;
   }
   
   function getregions()
   {
	   $zone_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['zone_id']))));
	   
	   $regions = $this->regionsmodel->get_by_zone($zone_id);
	  	 
		 
	   $regionselect = '<select name="region_id" id="region_id" onChange="GetDistricts(this)">';
	    	$regionselect .= '<option value="">All Regions</option>';  
		 if(empty($regions))
		 {
			 $regionsdata = $this->regionsmodel->get_list();
			 foreach($regionsdata as $rkey => $regionsdatum)
		   {
			   $regionselect .= '<option value="'.$regionsdatum['id'].'">'.$regionsdatum['region'].'</option>';
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
	  	 
		 
	   $regionselect = '<select name="region_id" id="region_id" onChange="GetDistricts(this)">';
	    	$regionselect .= '<option value="">Select Region</option>';  
		 if(empty($regions))
		 {
			 $regionsdata = $this->regionsmodel->get_list();
			 foreach($regionsdata as $rkey => $regionsdatum)
		   {
			   $regionselect .= '<option value="'.$regionsdatum['id'].'">'.$regionsdatum['region'].'</option>';
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

}
