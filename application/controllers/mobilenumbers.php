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

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $country_id = $this->erkanaauth->getField('country_id');
	  
	   $data = array(
           'rows' => $this->mobilenumbersmodel->get_list_by_country($country_id),
       );
	   
       $this->load->view('mobilenumbers/index', $data);
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
	  
	   $data = array();
	   
	   $data['diseasecategories'] = $this->diseasecategoriesmodel->get_list();
	   $country_id = $this->erkanaauth->getField('country_id');	   
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
	   $data['country_id'] = $country_id;	   
	   $data['country'] = $country;	   
	   $data['countries'] = $this->countriesmodel->get_list();	  
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

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $this->load->library('form_validation');
	   $this->form_validation->set_rules('name', 'Name', 'trim|required');
       $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
	   $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
       $this->form_validation->set_rules('diseasecategory_id', 'Sector', 'trim|required');
	   $this->form_validation->set_rules('country_id', 'Country', 'trim|required');
      // $this->form_validation->set_rules('region_id', 'Region', 'trim|required');
       $this->form_validation->set_rules('phone_number', 'Phone number', 'trim|required');
	   $this->form_validation->set_rules('email', 'Email', 'trim|required');
      
	  if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
		   		'name' => $this->input->post('name'),
               'designation' => $this->input->post('designation'),
			   'organization' => $this->input->post('organization'),
               'diseasecategory_id' => $this->input->post('diseasecategory_id'),
			   'zone_id' => $this->input->post('zone_id'),
               'region_id' => $this->input->post('region_id'),
			   'district_id' => $this->input->post('district_id'),
               'phone_number' => $this->input->post('phone_number'),
			   'email' => $this->input->post('email'),
			   'country_id' => $this->input->post('country_id'),
               
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

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $country_id = $this->erkanaauth->getField('country_id');
	  
	   $row = $this->db->get_where('mobilenumbers', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   $data['zones'] = $this->zonesmodel->get_list();
	   $data['regions'] = $this->regionsmodel->get_list();
	   
	   $data['country_id'] = $country_id;
	   
	   $data['diseasecategories'] = $this->diseasecategoriesmodel->get_list();
       $this->load->view('mobilenumbers/edit', $data);
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
	   $this->form_validation->set_rules('name', 'Name', 'trim|required');
       $this->form_validation->set_rules('designation', 'Designation', 'trim|required');
	   $this->form_validation->set_rules('organization', 'Organization', 'trim|required');
       $this->form_validation->set_rules('diseasecategory_id', 'Sector', 'trim|required');
       $this->form_validation->set_rules('phone_number', 'Phone number', 'trim|required');
	    $this->form_validation->set_rules('email', 'Email', 'trim|required');
       
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
		   	   'name' => $this->input->post('name'),
               'designation' => $this->input->post('designation'),
			   'organization' => $this->input->post('organization'),
               'diseasecategory_id' => $this->input->post('diseasecategory_id'),
               'phone_number' => $this->input->post('phone_number'),
			   'email' => $this->input->post('email'),
               
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

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $this->db->delete('mobilenumbers', array('id' => $id));
       redirect('mobilenumbers', 'refresh');
   }

}
