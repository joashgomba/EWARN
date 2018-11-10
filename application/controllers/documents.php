<?php

class Documents extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('documentsmodel');
   }

   public function index()
   {
       
	    //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	   $level = $this->erkanaauth->getField('level');
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   /**
	    1- zonal
        2- Regional
        3 - Health facility
        4- National
        5 - stake holder
	   **/
	   
	  	   
	   
	     
	  if($level==1)//zonal
	  {
		  $document_level=2;
		  $zone_id = $this->erkanaauth->getField('zone_id');
		  $data = array(
           'rows' => $this->documentsmodel->get_list_zone($zone_id,$country_id)
       	  );
	  }
	  
	   if($level==2)//regional
	  {
		  $document_level=3;
		  $region_id = $this->erkanaauth->getField('region_id');
		  $data = array(
           'rows' => $this->documentsmodel->get_list_region($region_id,$country_id)
       );
	  }
	  
	   if($level==3)//HF
	  {
		  $document_level=4;
		   $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
		  $data = array(
           'rows' => $this->documentsmodel->get_list_level($document_level,$country_id)
       );
	  }
	  
	   if($level==4)//National
	  {
		  $document_level=1;
		  		   
		  $data = array(
           'rows' => $this->documentsmodel->get_list_level($document_level,$country_id)
        );
	  }
	  
	  if($level==6)//District
	  {
		  $document_level=6;
		  $district_id = $this->erkanaauth->getField('district_id');
		  $data = array(
           'rows' => $this->documentsmodel->get_list_district($district_id,$country_id)
       	  );
	  }
	  
	  if($level==5)//Stakeholder
	  {
		  $document_level=1;
		  		   
		  $data = array(
           'rows' => $this->documentsmodel->get_list_level($document_level,$country_id)
        );
	  }
	  
	  if(getRole() == 'SuperAdmin' || getRole() == 'Admin')//zonal
	  {
		  $document_level=2;
		  $zone_id = $this->erkanaauth->getField('zone_id');
		  $data = array(
           'rows' => $this->documentsmodel->get_list_country($country_id)
       	  );
	  }
	  
	  $data['level'] = $level;
	   
       $this->load->view('documents/index', $data);
   }

   public function add()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();
	   $data['error'] = '';
	   
	   $level = $this->erkanaauth->getField('level');
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   $data['level'] = $level;
		
	  if(getRole() == 'SuperAdmin')
	  {

		$data['regions'] = $this->regionsmodel->get_list();
		$data['districts'] = $this->districtsmodel->get_list();
		$data['zones'] = $this->zonesmodel->get_list();
		$data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();

	  }
	  
	  if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['admindistricts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
            
        }
		
		if($level==6)//District
	   {
		   	   
		   $district_id = $this->erkanaauth->getField('district_id');
		   $district = $this->districtsmodel->get_by_id($district_id)->row();		   
		   $region = $this->regionsmodel->get_by_id($district->region_id)->row();
		   $data['district_id'] = $district_id;
		   $data['district'] = $district;
		   $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
		   $data['districts'] = $this->districtsmodel->get_by_region($region->id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
		   
	   }
	   
	   if($level==2)//FP
	   {
		   	   
		   $region_id = $this->erkanaauth->getField('region_id');		   
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
		   $data['districts'] = $this->districtsmodel->get_by_region($region->id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
		   
	   }
	   
	   if($level==1)//zonal
	   {
		   $zone_id = $this->erkanaauth->getField('zone_id');
		   $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
		   $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
	   }
	   
	   if($level==4)//national
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		  $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_country_list($country_id);
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   
	   $data['country_id'] = $country_id;
	   $data['countries'] = $this->countriesmodel->get_list();
	   
	    
	   $this->load->view('documents/add',$data);
   }

   public function add_validate()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('title', 'Title', 'trim|required');
       $this->form_validation->set_rules('description', 'Description', 'trim|required');
	   
	   $file_element_name = 'userfile';
      
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
		   $config['upload_path'] = './documents/';
		  $config['allowed_types'] = 'gif|jpg|png|doc|txt|pdf|xls|docx|xlxs';
           $config['allowed_types'] = '*';
           $config['overwrite'] = TRUE;
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name))
			{
				$error = array('error' => $this->upload->display_errors());
				
				$data = array();
				$data['error'] = $error;
				
				$this->load->view('documents/add',$data);
	
			}
			else
			{
				$filedata = $this->upload->data();
				 $level = $this->erkanaauth->getField('level');
				   /**
					1- zonal
					2- Regional
					3 - Health facility
					4- National
					5 - stake holder
				   **/
				  
				  if($level==1)
				  {
					  $document_level=2;
				  }
				  
				   if($level==2)
				  {
					  $document_level=3;
				  }
				  
				   if($level==3)
				  {
					  $document_level=4;
				  }
				  
				   if($level==4)
				  {
					  $document_level=1;
				  }
				
			   $data = array(
				   'title' => $this->input->post('title'),
				   'description' => $this->input->post('description'),
				   'docname' => $filedata['file_name'],
				   'doctype' => $filedata['file_type'],
				   'docsize' => $filedata['file_size'],
				   'date_added' => date('Y-m-d'),
				   'level' => $document_level,
				   'zone_id' => $this->input->post('zone_id'),
				   'region_id' => $this->input->post('region_id'),
				   'district_id' => $this->input->post('district_id'),
				   'country_id' => $this->input->post('country_id'),
			   );
			  $this->db->insert('documents', $data);
			   redirect('documents','refresh');
			}
       }
   }

   public function edit($id)
   {
       //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	   $row = $this->db->get_where('documents', array('id' => $id))->row();
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
	  
       $this->load->view('documents/edit', $data);
   }

   public function edit_validate($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('title', 'Title', 'trim|required');
       $this->form_validation->set_rules('description', 'Description', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'title' => $this->input->post('title'),
               'description' => $this->input->post('description'),
           );
           $this->db->where('id', $id);
           $this->db->update('documents', $data);
           redirect('documents','refresh');
       }
   }
   
   public function files()
   {
	   $data = array();
	   $this->load->view('documents/myuploads',$data);
   }
   
   public function add_files()
   {
	   
	   $file_element_name = 'userfile';
	   $path = $this->input->post('path');
	   
	   $mypath = './'.$path.'/';
	   
	  // echo $mypath;
	   
	  		$config['upload_path'] = './';
	  		$config['overwrite'] = 'TRUE';
		  	$config['allowed_types'] = '*';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name))
			{
				$error = array('error' => $this->upload->display_errors());
				
				$data = array();
				$data['error'] = $error;
				
				$errors = $this->upload->display_errors('<p>', '</p>');			
				
				echo $errors;
			}
			else
			{
				echo 'success';
				
			}
   }
   
   public function addqueries()
   {
	   /**
		$fields = array('diphofivemale' => array('type' => 'VARCHAR(100)'),
		'diphofivefemale' => array('type' => 'VARCHAR(100)'),
		'wcofivemale' => array('type' => 'VARCHAR(100)'),
		'wcofivefemale' => array('type' => 'VARCHAR(100)'),
		'measofivemale' => array('type' => 'VARCHAR(100)'),
		'measofivefemale' => array('type' => 'VARCHAR(100)'),
		'afpofivemale' => array('type' => 'VARCHAR(100)'),
		'afpofivefemale' => array('type' => 'VARCHAR(100)'),
		'suspectedmenegitisofivemale' => array('type' => 'VARCHAR(100)'),
		'suspectedmenegitisofivefemale' => array('type' => 'VARCHAR(100)')
		);
		$this->dbforge->add_column('reportingforms', $fields);
		**/
		
		$rows = $this->reportingformsmodel->get_combined_list();
		
		foreach ($rows->result() as $row):
		 echo $row->reportingform_id.' - '.$row->reporting_year.'- ('.$row->diphofivemale.')<br>';
		endforeach;
	

   }

   public function delete($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	   $this->db->delete('documents', array('id' => $id));
       $this->index();
   }

}
