<?php

class Healthfacilities extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('healthfacilitiesmodel');
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
           'rows' => $this->healthfacilitiesmodel->get_combined_list(),
       );
       $this->load->view('healthfacilities/index', $data);
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
	   $data['zones']            = $this->zonesmodel->get_list();
	   $data['districts'] = $this->districtsmodel->get_list();
       $this->load->view('healthfacilities/add',$data);
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
	  
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('health_facility', 'Health facility', 'trim|required');
       $this->form_validation->set_rules('hf_code', 'Hf code', 'trim|required');
       $this->form_validation->set_rules('district_id', 'District', 'trim|required');
	   $this->form_validation->set_rules('focal_person_name', 'Focal Person Name', 'trim|required');
	   $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'health_facility' => $this->input->post('health_facility'),
               'hf_code' => $this->input->post('hf_code'),
               'district_id' => $this->input->post('district_id'),
			   'organization' => $this->input->post('organization'),
			   'health_facility_type' => $this->input->post('health_facility_type'),
			   'otherval' => $this->input->post('othervalue'),
			   'catchment_population' => $this->input->post('catchment_population'),
			   'focal_person_name' => $this->input->post('focal_person_name'),
			   'contact_number' => $this->input->post('contact_number'),
			   'email' => $this->input->post('email'),
           );
           $this->db->insert('healthfacilities', $data);
           redirect('healthfacilities', 'refresh');
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
	  
	   $row = $this->db->get_where('healthfacilities', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   
	   $data['districts'] = $this->districtsmodel->get_list();
       $this->load->view('healthfacilities/edit', $data);
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
       $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
	   $this->form_validation->set_rules('health_facility', 'Health facility', 'trim|required');
       $this->form_validation->set_rules('hf_code', 'Hf code', 'trim|required');
       $this->form_validation->set_rules('district_id', 'District id', 'trim|required');
	   $this->form_validation->set_rules('focal_person_name', 'Focal Person Name', 'trim|required');
	   $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
	   
	   
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'health_facility' => $this->input->post('health_facility'),
               'hf_code' => $this->input->post('hf_code'),
               'district_id' => $this->input->post('district_id'),
			   'organization' => $this->input->post('organization'),
			   'health_facility_type' => $this->input->post('health_facility_type'),
			   'otherval' => $this->input->post('othervalue'),
			   'catchment_population' => $this->input->post('catchment_population'),
			   'focal_person_name' => $this->input->post('focal_person_name'),
			   'contact_number' => $this->input->post('contact_number'),
			   'email' => $this->input->post('email'),
           );
           $this->db->where('id', $id);
           $this->db->update('healthfacilities', $data);
           redirect('healthfacilities', 'refresh');
       }
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
	  
	   $this->db->delete('healthfacilities', array('id' => $id));
       redirect('healthfacilities', 'refresh');
   }

}
