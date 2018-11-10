<?php

class Regions extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('regionsmodel');
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
           'rows' => $this->regionsmodel->get_combined_list(),
       );
	   
	   
       $this->load->view('regions/index', $data);
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
	   $this->load->view('regions/add',$data);
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
       $this->form_validation->set_rules('region', 'Region', 'trim|required');
       $this->form_validation->set_rules('regional_code', 'Regional code', 'trim|required');
       $this->form_validation->set_rules('zone_id', 'Zone id', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'region' => $this->input->post('region'),
               'regional_code' => $this->input->post('regional_code'),
               'zone_id' => $this->input->post('zone_id'),
           );
           $this->db->insert('regions', $data);
           redirect('regions', 'refresh');
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
	  
	   $row = $this->db->get_where('regions', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	
       $data['zones'] = $this->zonesmodel->get_list();
       $this->load->view('regions/edit', $data);
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
       $this->form_validation->set_rules('region', 'Region', 'trim|required');
       $this->form_validation->set_rules('regional_code', 'Regional code', 'trim|required');
       $this->form_validation->set_rules('zone_id', 'Zone id', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'region' => $this->input->post('region'),
               'regional_code' => $this->input->post('regional_code'),
               'zone_id' => $this->input->post('zone_id'),
           );
           $this->db->where('id', $id);
           $this->db->update('regions', $data);
           redirect('regions', 'refresh');
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
	  
	   $this->db->delete('regions', array('id' => $id));
       redirect('regions', 'refresh');
   }

}
