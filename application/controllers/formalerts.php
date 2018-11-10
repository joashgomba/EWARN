<?php

class Formalerts extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('formalertsmodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $data = array(
           'rows' => $this->db->get('formalerts'),
       );
       $this->load->view('formalerts/index', $data);
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
			   
			 			   
			   if ($level == 6) {//District
			   	 $district_id = $this->erkanaauth->getField('district_id');
			     $alerts = $this->formalertsmodel->get_by_period_district($reportingperiod_id,$district_id);
					   
			   }
			   elseif($level==2)//region
	   		   {
				   $region_id = $this->erkanaauth->getField('region_id');
				   $alerts = $this->formalertsmodel->get_by_period_region($reportingperiod_id,$region_id);
			   }
			   elseif($level==1)//zonal
			   {
				   
				   $zone_id = $this->erkanaauth->getField('zone_id');
					$alerts = $this->formalertsmodel->get_by_period_zone($reportingperiod_id,$zone_id);	   
					
			   }
			   else
			   {
			   		$alerts = $this->formalertsmodel->get_by_period($reportingperiod_id);
			   }
			   
			   $count = count($alerts);
			   
			   if(empty($alerts))
			   {
				   $table = '<table id="listtable" >
                  <thead>
                  <tr><th>Week No</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th><th>Action</th><th>Verification Status</th><th>Bulletin Include</th><th>Edit</th></tr>
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
				   $table .= '<tr><td><strong>Alerts Count: '.$count.'</strong></td></tr>';
				   $table .= '</table>';
				   
				   $table .= '<table id="listtable" >
                  <thead>
                  <tr><th>Week No</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th><th>Action</th><th>Verification Status</th><th>Bulletin Include</th><th>Edit</th></tr>
                  </thead>
                  <tbody>';
				  
				  foreach($alerts as $key => $alert)
				  {
					  $reporting_period = $this->epdcalendarmodel->get_by_id($alert['reportingperiod_id'])->row();
					  $healthfacility = $this->healthfacilitiesmodel->get_by_id($alert['healthfacility_id'])->row();
					  $district = $this->districtsmodel->get_by_id($alert['district_id'])->row();
					  $region = $this->regionsmodel->get_by_id($district->region_id)->row();
					  $zone = $this->zonesmodel->get_by_id($alert['zone_id'])->row();
					  
					  if($zone->country_id != $country_id)
					  {
					  }
					  else
					  {
					  
					  if($alert['verification_status']==0)
					  {
						  $verification_status = 'FALSE';
					  }
					  else
					  {
						  $verification_status = 'TRUE';
					  }
					  
					  if($alert['include_bulletin']==0)
					  {
						  $include_bulletin = 'FALSE';
					  }
					  else
					  {
						  $include_bulletin = 'TRUE';
					  }
					  
					   
					  
				  $table .= '<tr><td>'.$reporting_period->week_no.'/'.$reporting_period->epdyear.'</td><td>'.$alert['disease_name'].'</td><td>'.$healthfacility->health_facility.'</td><td>'.$district->district.'</td><td>'.$region->region.'</td><td>'.$alert['cases'].'</td><td>'.$alert['deaths'].'</td><td>'.$alert['notes'].'</td><td>'.$verification_status.'</td><td>'.$include_bulletin.'</td><td><a href="'.base_url().'index.php/formalerts/edit/'.$alert['id'].'" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a></td></tr>';
																
					  }
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
       $this->load->view('formalerts/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('reportingform_id', 'Reportingform id', 'trim|required');
       $this->form_validation->set_rules('reportingperiod_id', 'Reportingperiod id', 'trim|required');
       $this->form_validation->set_rules('disease_id', 'Disease id', 'trim|required');
       $this->form_validation->set_rules('disease_name', 'Disease name', 'trim|required');
       $this->form_validation->set_rules('healthfacility_id', 'Healthfacility id', 'trim|required');
       $this->form_validation->set_rules('district_id', 'District id', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region id', 'trim|required');
       $this->form_validation->set_rules('zone_id', 'Zone id', 'trim|required');
       $this->form_validation->set_rules('cases', 'Cases', 'trim|required');
       $this->form_validation->set_rules('deaths', 'Deaths', 'trim|required');
       $this->form_validation->set_rules('notes', 'Notes', 'trim|required');
       $this->form_validation->set_rules('verification_status', 'Verification status', 'trim|required');
       $this->form_validation->set_rules('include_bulletin', 'Include bulletin', 'trim|required');
       $this->form_validation->set_rules('outcome', 'Outcome', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'reportingform_id' => $this->input->post('reportingform_id'),
               'reportingperiod_id' => $this->input->post('reportingperiod_id'),
               'disease_id' => $this->input->post('disease_id'),
               'disease_name' => $this->input->post('disease_name'),
               'healthfacility_id' => $this->input->post('healthfacility_id'),
               'district_id' => $this->input->post('district_id'),
               'region_id' => $this->input->post('region_id'),
               'zone_id' => $this->input->post('zone_id'),
               'cases' => $this->input->post('cases'),
               'deaths' => $this->input->post('deaths'),
               'notes' => $this->input->post('notes'),
               'verification_status' => $this->input->post('verification_status'),
               'include_bulletin' => $this->input->post('include_bulletin'),
               'outcome' => $this->input->post('outcome'),
           );
           $this->db->insert('formalerts', $data);
           redirect('formalerts','refresh');
       }
   }

   public function edit($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $row = $this->db->get_where('formalerts', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   $data = array(
           'row' => $row,
       );
	   
	   $reportingperiod = $this->epdcalendarmodel->get_by_id($row->reportingperiod_id)->row();
	   $district = $this->districtsmodel->get_by_id($row->district_id)->row();
	   $region = $this->regionsmodel->get_by_id($row->region_id)->row();
	   $zone = $this->zonesmodel->get_by_id($row->zone_id)->row();
	   
	   $data['reportingperiod'] = $reportingperiod;
	   $data['district'] = $district;
	   $data['region'] = $region;
	   $data['zone'] = $zone;
	   
       $this->load->view('formalerts/edit', $data);
   }

   public function edit_validate($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('cases', 'Cases', 'trim|required');
       $this->form_validation->set_rules('deaths', 'Deaths', 'trim|required');
       //$this->form_validation->set_rules('notes', 'Notes', 'trim|required');
       $this->form_validation->set_rules('verification_status', 'Verification status', 'trim|required');
       $this->form_validation->set_rules('include_bulletin', 'Include bulletin', 'trim|required');
       $this->form_validation->set_rules('outcome', 'Outcome', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'cases' => $this->input->post('cases'),
			   'deaths' => $this->input->post('deaths'),
               'notes' => $this->input->post('notes'),
               'verification_status' => $this->input->post('verification_status'),
               'include_bulletin' => $this->input->post('include_bulletin'),
			   'outcome' => $this->input->post('outcome'),
           );
           $week_no = $this->input->post('week_no');
		   $year_no = $this->input->post('year_no');
		   
           $this->db->where('id', $id);
           $this->db->update('formalerts', $data);
		   redirect('formalerts/alertlist/'.$week_no.'/'.$year_no.'', 'refresh');;
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
		   echo '<div class="alert alert-danger">Please select the reporting year and Week No.</div>';
		   $table = '';
	   }
	   else
	   {
		   $reportingperiod = $this->epdcalendarmodel->get_by_year_week_country($reporting_year, $week_no, $country_id)->row();
		   
		   if(empty($reportingperiod))
		   {
			   $table =  '<div class="alert alert-danger">No reporting period added</div>';
			   
		   }
		   else
		   {
			   $reportingperiod_id = $reportingperiod->id;
			    if ($level == 6) {//District
			   	 $district_id = $this->erkanaauth->getField('district_id');
			     $alerts = $this->formalertsmodel->get_by_period_district($reportingperiod_id,$district_id);
					   
			   }
			   elseif($level==2)//region
	   		   {
				   $region_id = $this->erkanaauth->getField('region_id');
				   $alerts = $this->formalertsmodel->get_by_period_region($reportingperiod_id,$region_id);
			   }
			   elseif($level==1)//zonal
			   {
				   $zone_id = $this->erkanaauth->getField('zone_id');
					$alerts = $this->formalertsmodel->get_by_period_zone($reportingperiod_id,$zone_id);	   
			   }
			   else
			   {
			   		$alerts = $this->formalertsmodel->get_by_period($reportingperiod_id);
			   }
			   
			   $count = count($alerts);
			   
			   if(empty($alerts))
			   {
				   $table = '<table id="listtable" >
                  <thead>
                  <tr><th>Week No</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th><th>Action</th><th>Verification Status</th><th>Bulletin Include</th><th>Edit</th></tr>
                  </thead>
                  <tbody>';
				  $table .= '<tr><td colspan="10">no alerts available</td></tr>';
				  $table .= '</tbody>
                  </table>';
				   
				  
			   }
			   else
			   {
				   
								   
				   $table = '<table id="customers">';
				   $table .= '<tr><td><strong>Alerts Count: '.$count.'</strong></td></tr>';
				   $table .= '</table>';
				   
				   $table .= '<table id="listtable" >
                  <thead>
                  <tr><th>Week No</th><th>Disease Name</th><th>Health Facility</th><th>District</th><th>Region</th><th>Cases</th><th>Deaths</th><th>Action</th><th>Verification Status</th><th>Bulletin Include</th><th>Edit</th></tr>
                  </thead>
                  <tbody>';
				  
				  foreach($alerts as $key => $alert)
				  {
					  $reporting_period = $this->epdcalendarmodel->get_by_id($alert['reportingperiod_id'])->row();
					  $healthfacility = $this->healthfacilitiesmodel->get_by_id($alert['healthfacility_id'])->row();
					  $district = $this->districtsmodel->get_by_id($alert['district_id'])->row();
					  $region = $this->regionsmodel->get_by_id($district->region_id)->row();
					  
					  $zone = $this->zonesmodel->get_by_id($alert['zone_id'])->row();
					  
					  if($zone->country_id != $country_id)
					  {
					  }
					  else
					  {
					  
					  if($alert['verification_status']==0)
					  {
						  $verification_status = 'FALSE';
					  }
					  else
					  {
						  $verification_status = 'TRUE';
					  }
					  
					  if($alert['include_bulletin']==0)
					  {
						  $include_bulletin = 'FALSE';
					  }
					  else
					  {
						  $include_bulletin = 'TRUE';
					  }
					  
				  $table .= '<tr><td>'.$reporting_period->week_no.'/'.$reporting_period->epdyear.'</td><td>'.$alert['disease_name'].'</td><td>'.$healthfacility->health_facility.'</td><td>'.$district->district.'</td><td>'.$region->region.'</td><td>'.$alert['cases'].'</td><td>'.$alert['deaths'].'</td><td>'.$alert['notes'].'</td><td>'.$verification_status.'</td><td>'.$include_bulletin.'</td><td><a href="'.base_url().'index.php/formalerts/edit/'.$alert['id'].'" class="tooltip-success" data-rel="tooltip" title="Edit">
																	<span class="green">
																		<i class="icon-edit bigger-120"></i>
																	</span>
																</a></td></tr>';
																
																
					  }
				  }
				  $table .= '</tbody>
                  </table>';
				  
				  
			   }
		   }
	   }
	   
	   $data['table'] = $table;
	   $data['week_no'] = $week_no;
	   $data['reporting_year'] = $reporting_year;
	   
	   $this->load->view('formalerts/alertslist', $data);
   }

   public function delete($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->db->delete('formalerts', array('id' => $id));
       redirect('formalerts','refresh');
   }

}
