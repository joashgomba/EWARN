<?php

class Emergencies extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('emergenciesmodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	 	 
       $data = array(
           'rows' => $this->db->get('emergencies'),
       );
       $this->load->view('emergencies/index', $data);
   }
   
   
   function getlist()
   {
	   $week_no = trim(addslashes(htmlspecialchars(rawurldecode($_POST['week_no']))));
	   $reporting_year = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
	   $country_id = $this->erkanaauth->getField('country_id');
	   $level = $this->erkanaauth->getField('level');
	   
	   	   
	   if(empty($week_no) || empty($reporting_year)){
		   echo '<div class="alert alert-danger">Please select the reporting year and Week No.</div>';
	   }
	   else
	   {
		   $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year, $week_no, $country_id)->row();
		   
		   
		   
		   if(empty($reportingperiod))
		   {
			   echo '<div class="alert alert-danger">No reporting period added</div>';
		   }
		   else
		   {
			   $reportingperiod_id = $reportingperiod->id;
			   
			   if ($level == 3) {//HF
			   	 $healthfacility_id = $this->erkanaauth->getField('district_id');
			     $alerts = $this->emergenciesmodel->get_by_period_healthfacility($reportingperiod_id,$healthfacility_id);
					   
			   }
			   
			   if ($level == 6) {//District
			   	 $district_id = $this->erkanaauth->getField('district_id');
			     $alerts = $this->emergenciesmodel->get_by_period_district($reportingperiod_id,$district_id);
					   
			   }
			   elseif($level==2)//region
	   		   {
				   $region_id = $this->erkanaauth->getField('region_id');
				   $alerts = $this->emergenciesmodel->get_by_period_region($reportingperiod_id,$region_id);
			   }
			   elseif($level==1)//zonal
			   {
				   $zone_id = $this->erkanaauth->getField('zone_id');
					$alerts = $this->emergenciesmodel->get_by_period_zone($reportingperiod_id,$zone_id);	   
			   }
			   else
			   {
			   		$alerts = $this->emergenciesmodel->get_by_period($reportingperiod_id);
			   }
			   
			   $count = count($alerts);
			   
			   if(empty($alerts))
			   {
				   $table = '<table id="listtable" >
                  <thead>
                  <tr><th>Week No</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th><th>Action</th><th>Verification Status</th><th>Edit</th></tr>
                  </thead>
                  <tbody>';
				  $table .= '<tr><td colspan="11">no alerts available</td></tr>';
				  $table .= '</tbody>
                  </table>';
				   
				   echo $table ;
			   }
			   else
			   {
				   
								   
				   $table = '<table id="customers">';
				   $table .= '<tr><td><strong>Emergency Alerts Count: '.$count.'</strong></td></tr>';
				   $table .= '</table>';
				   
				   $table .= '<table id="listtable" >
                  <thead>
                  <tr><th>Week No</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th><th>Action</th><th>Verification Status</th><th>Edit</th></tr>
                  </thead>
                  <tbody>';
				  
				  foreach($alerts as $key => $alert)
				  {
					  $reporting_period = $this->epdcalendarmodel->get_by_id($alert['epicalendar_id'])->row();
					  $healthfacility = $this->healthfacilitiesmodel->get_by_id($alert['healthfacility_id'])->row();
					  $district = $this->districtsmodel->get_by_id($alert['district_id'])->row();
					  $region = $this->regionsmodel->get_by_id($district->region_id)->row();
					  
					  $disease = $this->diseasesmodel->get_by_id($alert['disease_id'])->row();
					  
					  if(empty($disease))
					  {
						  $disease_name = $alert['other'];
					  }
					  else
					  {
						  $disease_name = $disease->disease_name;
					  }
					  
					  if($alert['verification_status']==0)
					  {
						  $verification_status = 'FALSE';
					  }
					  else
					  {
						  $verification_status = 'TRUE';
					  }
					  
					 
					 $cases = 	($alert['male_under_five']+$alert['female_under_five']+$alert['male_over_five']+$alert['female_over_five']);			   
					  
				  $table .= '<tr><td>'.$reporting_period->week_no.'/'.$reporting_period->epdyear.'</td><td>'.$disease_name.'</td><td>'.$healthfacility->health_facility.'</td><td>'.$district->district.'</td><td>'.$region->region.'</td><td>'.$cases.'</td><td>'.$alert['death'].'</td><td>'.$alert['action_taken'].'</td><td>'.$verification_status.'</td><td><a href="'.base_url().'index.php/emergencies/edit/'.$alert['id'].'" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a></td></tr>';
				  }
				  $table .= '</tbody>
                  </table>';
				  
				  echo $table ;
			   }
		   }
	   }
	   
   }

   public function add()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $data = array();
	   
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
		
		$data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id));
       $this->load->view('emergencies/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('healthfacility_id', 'Healthfacility', 'trim|required');
       $this->form_validation->set_rules('district_id', 'District', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region', 'trim|required');
       $this->form_validation->set_rules('zone_id', 'Zone', 'trim|required');
       $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
       $this->form_validation->set_rules('reporting_year', 'Reporting year', 'trim|required');
       $this->form_validation->set_rules('reporting_date', 'Reporting date', 'trim|required');
       $this->form_validation->set_rules('disease_id', 'Disease', 'trim|required');
       $this->form_validation->set_rules('male_under_five', 'Male under five', 'trim|required');
       $this->form_validation->set_rules('female_under_five', 'Female under five', 'trim|required');
       $this->form_validation->set_rules('male_over_five', 'Male over five', 'trim|required');
       $this->form_validation->set_rules('female_over_five', 'Female over five', 'trim|required');
       $this->form_validation->set_rules('death', 'Death', 'trim|required');
       //$this->form_validation->set_rules('action_taken', 'Action taken', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
		   
		   $country_id = $this->erkanaauth->getField('country_id');
		   $user_id = $this->erkanaauth->getField('id');
		   $week_no = $this->input->post('week_no');
           $reporting_year = $this->input->post('reporting_year');
		   $epicalendar = $this->epdcalendarmodel->get_by_year_week_country($reporting_year,$week_no,$country_id)->row();
		   
           $data = array(
               'healthfacility_id' => $this->input->post('healthfacility_id'),
               'district_id' => $this->input->post('district_id'),
               'region_id' => $this->input->post('region_id'),
               'zone_id' => $this->input->post('zone_id'),
               'country_id' => $country_id,
               'week_no' => $this->input->post('week_no'),
               'reporting_year' => $this->input->post('reporting_year'),
               'epicalendar_id' => $epicalendar->id,
               'reporting_date' => $this->input->post('reporting_date'),
               'user_id' => $user_id,
               'disease_id' => $this->input->post('disease_id'),
               'male_under_five' => $this->input->post('male_under_five'),
               'female_under_five' => $this->input->post('female_under_five'),
               'male_over_five' => $this->input->post('male_over_five'),
               'female_over_five' => $this->input->post('female_over_five'),
               'other' => $this->input->post('other'),
               'death' => $this->input->post('death'),
               'action_taken' => '',
			   'verification_status' => 0,
           );
           $this->db->insert('emergencies', $data);
           redirect('emergencies','refresh');
       }
   }

   public function edit($id)
   {
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
        
        $row = $this->db->get_where('emergencies', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   
	   	   
	   
          $data['regions']          = $this->regionsmodel->get_list();
          $data['districts']   = $this->districtsmodel->get_list();
          $data['zones']            = $this->zonesmodel->get_country_list($country_id);
          $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        
        $data['level'] = $level;
		
		$data['diseases'] = $this->db->get_where('diseases', array('country_id' => $country_id));
      
       $this->load->view('emergencies/edit', $data);
   }

   public function edit_validate($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       
       $this->form_validation->set_rules('male_under_five', 'Male under five', 'trim|required');
       $this->form_validation->set_rules('female_under_five', 'Female under five', 'trim|required');
       $this->form_validation->set_rules('male_over_five', 'Male over five', 'trim|required');
       $this->form_validation->set_rules('female_over_five', 'Female over five', 'trim|required');
       $this->form_validation->set_rules('death', 'Deaths', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'male_under_five' => $this->input->post('male_under_five'),
               'female_under_five' => $this->input->post('female_under_five'),
               'male_over_five' => $this->input->post('male_over_five'),
               'female_over_five' => $this->input->post('female_over_five'),
               'death' => $this->input->post('death'),
               'action_taken' => $this->input->post('action_taken'),
			   'verification_status' => $this->input->post('verification_status'),
           );
           $this->db->where('id', $id);
           $this->db->update('emergencies', $data);
		   
		   $week_no = $this->input->post('week_no');
		   $year_no = $this->input->post('year_no');
		   
		   
		   redirect('emergencies/alertlist/'.$week_no.'/'.$year_no.'', 'refresh');
       }
   }
   
   public function alertlist($week_no,$reporting_year)
   {
	   if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
		
		$data = array();
		$level = $this->erkanaauth->getField('level');
		
		$country_id = $this->erkanaauth->getField('country_id');
		
		
	    if(empty($week_no) || empty($reporting_year)){
		    $table = '<div class="alert alert-danger">Please select the reporting year and Week No.</div>';
	   }
	   else
	   {
		   $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year, $week_no, $country_id)->row();
		   
		   
		   
		   if(empty($reportingperiod))
		   {
			   $table = '<div class="alert alert-danger">No reporting period added</div>';
		   }
		   else
		   {
			   $reportingperiod_id = $reportingperiod->id;
			   
			    if ($level == 3) {//HF
			   	 $healthfacility_id = $this->erkanaauth->getField('district_id');
			     $alerts = $this->emergenciesmodel->get_by_period_healthfacility($reportingperiod_id,$healthfacility_id);
					   
			   }
			   
			   if ($level == 6) {//District
			   	 $district_id = $this->erkanaauth->getField('district_id');
			     $alerts = $this->emergenciesmodel->get_by_period_district($reportingperiod_id,$district_id);
					   
			   }
			   elseif($level==2)//region
	   		   {
				   $region_id = $this->erkanaauth->getField('region_id');
				   $alerts = $this->emergenciesmodel->get_by_period_region($reportingperiod_id,$region_id);
			   }
			   elseif($level==1)//zonal
			   {
				   $zone_id = $this->erkanaauth->getField('zone_id');
					$alerts = $this->emergenciesmodel->get_by_period_zone($reportingperiod_id,$zone_id);	   
			   }
			   else
			   {
			   		$alerts = $this->emergenciesmodel->get_by_period($reportingperiod_id);
			   }
			   
			   $count = count($alerts);
			   
			   if(empty($alerts))
			   {
				   $table = '<table id="listtable" >
                  <thead>
                  <tr><th>Week No</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th><th>Action</th><th>Verification Status</th><th>Edit</th></tr>
                  </thead>
                  <tbody>';
				  $table .= '<tr><td colspan="11">no alerts available</td></tr>';
				  $table .= '</tbody>
                  </table>';
				   
				   echo $table ;
			   }
			   else
			   {
				   
								   
				   $table = '<table id="customers">';
				   $table .= '<tr><td><strong>Emergency Alerts Count: '.$count.'</strong></td></tr>';
				   $table .= '</table>';
				   
				   $table .= '<table id="listtable" >
                  <thead>
                  <tr><th>Week No</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th><th>Action</th><th>Verification Status</th><th>Edit</th></tr>
                  </thead>
                  <tbody>';
				  
				  foreach($alerts as $key => $alert)
				  {
					  $reporting_period = $this->epdcalendarmodel->get_by_id($alert['epicalendar_id'])->row();
					  $healthfacility = $this->healthfacilitiesmodel->get_by_id($alert['healthfacility_id'])->row();
					  $district = $this->districtsmodel->get_by_id($alert['district_id'])->row();
					  $region = $this->regionsmodel->get_by_id($district->region_id)->row();
					  
					  $disease = $this->diseasesmodel->get_by_id($alert['disease_id'])->row();
					  
					  if(empty($disease))
					  {
						  $disease_name = $alert['other'];
					  }
					  else
					  {
						  $disease_name = $disease->disease_name;
					  }
					  
					  if($alert['verification_status']==0)
					  {
						  $verification_status = 'FALSE';
					  }
					  else
					  {
						  $verification_status = 'TRUE';
					  }
					  
					 
					 $cases = 	($alert['male_under_five']+$alert['female_under_five']+$alert['male_over_five']+$alert['female_over_five']);			   
					  
				  $table .= '<tr><td>'.$reporting_period->week_no.'/'.$reporting_period->epdyear.'</td><td>'.$disease_name.'</td><td>'.$healthfacility->health_facility.'</td><td>'.$district->district.'</td><td>'.$region->region.'</td><td>'.$cases.'</td><td>'.$alert['death'].'</td><td>'.$alert['action_taken'].'</td><td>'.$verification_status.'</td><td><a href="'.base_url().'index.php/emergencies/edit/'.$alert['id'].'" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a></td></tr>';
				  }
				  $table .= '</tbody>
                  </table>';
				  
				 
			   }
		   }
	   }
	   
	   $data['table'] = $table;
	   $data['week_no'] = $week_no;
	   $data['reporting_year'] = $reporting_year;
	   
	   $this->load->view('emergencies/alertslist', $data);
		
		
   }

   public function delete($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->db->delete('emergencies', array('id' => $id));
       redirect('emergencies','refresh');
   }

}
