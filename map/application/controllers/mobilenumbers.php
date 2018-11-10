<?php

class Mobilenumbers extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('mobilenumbersmodel');
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
           'rows' => $this->db->get('mobilenumbers'),
       );
	   
       $this->load->view('mobilenumbers/index', $data);
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
	   $data['zones'] = $this->zonesmodel->get_list();
	   $data['regions'] = $this->regionsmodel->get_list();
       $this->load->view('mobilenumbers/add',$data);
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
	   $this->form_validation->set_rules('name', 'Name', 'trim|required');
       $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
	   $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
       $this->form_validation->set_rules('sector', 'Sector', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region', 'trim|required');
       $this->form_validation->set_rules('phone_number', 'Phone number', 'trim|required');
      
	  if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
		   		'name' => $this->input->post('name'),
               'designation' => $this->input->post('designation'),
			   'organization' => $this->input->post('organization'),
               'sector' => $this->input->post('sector'),
			   'zone_id' => $this->input->post('zone_id'),
               'region_id' => $this->input->post('region_id'),
			   'district_id' => $this->input->post('district_id'),
               'phone_number' => $this->input->post('phone_number'),
               
           );
           $this->db->insert('mobilenumbers', $data);
           redirect('mobilenumbers', 'refresh');
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
	  
	   $row = $this->db->get_where('mobilenumbers', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   $data['zones'] = $this->zonesmodel->get_list();
	   $data['regions'] = $this->regionsmodel->get_list();
       $this->load->view('mobilenumbers/edit', $data);
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
	   $this->form_validation->set_rules('name', 'Name', 'trim|required');
       $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
	   $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
       $this->form_validation->set_rules('sector', 'Sector', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region', 'trim|required');
       $this->form_validation->set_rules('phone_number', 'Phone number', 'trim|required');
       
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
		   		'name' => $this->input->post('name'),
               'designation' => $this->input->post('designation'),
			   'organization' => $this->input->post('organization'),
               'sector' => $this->input->post('sector'),
			   'zone_id' => $this->input->post('zone_id'),
               'region_id' => $this->input->post('region_id'),
               'phone_number' => $this->input->post('phone_number'),
               
           );
           $this->db->where('id', $id);
           $this->db->update('mobilenumbers', $data);
           redirect('mobilenumbers', 'refresh');
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
	  
	   $this->db->delete('mobilenumbers', array('id' => $id));
       redirect('mobilenumbers', 'refresh');
   }

}
