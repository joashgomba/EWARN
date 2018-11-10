<?php

class Countries extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('countriesmodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $data = array(
           'rows' => $this->db->get('countries'),
       );
       $this->load->view('countries/index', $data);
   }

   public function add()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
       $data = array();
       $this->load->view('countries/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
       $this->load->library('form_validation');
       $this->form_validation->set_rules('country_name', 'Country name', 'trim|required');
       $this->form_validation->set_rules('country_code', 'Country code', 'trim|required');
       $this->form_validation->set_rules('first_admin_level_label', 'First admin level label', 'trim|required');
       $this->form_validation->set_rules('second_admin_level_label', 'Second admin level label', 'trim|required');
       $this->form_validation->set_rules('third_admin_level_label', 'Third admin level label', 'trim|required');
	   $this->form_validation->set_rules('map_center', 'Map Center', 'trim|required');
	   $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
	   $this->form_validation->set_rules('contact_email', 'Contact Email', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'country_name' => $this->input->post('country_name'),
               'country_code' => $this->input->post('country_code'),
               'first_admin_level_label' => $this->input->post('first_admin_level_label'),
               'second_admin_level_label' => $this->input->post('second_admin_level_label'),
               'third_admin_level_label' => $this->input->post('third_admin_level_label'),
			   'map_center' => $this->input->post('map_center'),
			   'contact_person' => $this->input->post('contact_person'),
			   'contact_email' => $this->input->post('contact_email'),
           );
           $this->db->insert('countries', $data);
           redirect('countries','refresh');
       }
   }

   public function edit($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
       $row = $this->db->get_where('countries', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
       $this->load->view('countries/edit', $data);
   }

   public function edit_validate($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
       $this->load->library('form_validation');
       $this->form_validation->set_rules('country_name', 'Country name', 'trim|required');
       $this->form_validation->set_rules('country_code', 'Country code', 'trim|required');
       $this->form_validation->set_rules('first_admin_level_label', 'First admin level label', 'trim|required');
       $this->form_validation->set_rules('second_admin_level_label', 'Second admin level label', 'trim|required');
       $this->form_validation->set_rules('third_admin_level_label', 'Third admin level label', 'trim|required');
	   $this->form_validation->set_rules('map_center', 'Map Center', 'trim|required');
	   $this->form_validation->set_rules('contact_person', 'Contact Person', 'trim|required');
	   $this->form_validation->set_rules('contact_email', 'Contact Email', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'country_name' => $this->input->post('country_name'),
               'country_code' => $this->input->post('country_code'),
               'first_admin_level_label' => $this->input->post('first_admin_level_label'),
               'second_admin_level_label' => $this->input->post('second_admin_level_label'),
               'third_admin_level_label' => $this->input->post('third_admin_level_label'),
			   'map_center' => $this->input->post('map_center'),
			   'contact_person' => $this->input->post('contact_person'),
			   'contact_email' => $this->input->post('contact_email'),
           );
           $this->db->where('id', $id);
           $this->db->update('countries', $data);
           redirect('countries','refresh');
       }
   }

   public function delete($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
       $this->db->delete('countries', array('id' => $id));
       redirect('countries','refresh');
   }

}
