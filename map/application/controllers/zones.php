<?php

class Zones extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('zonesmodel');
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
           'rows' => $this->db->get('zones'),
       );
       $this->load->view('zones/index', $data);
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
	   $this->load->view('zones/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('zone', 'Zone', 'trim|required');
       $this->form_validation->set_rules('zonal_code', 'Zonal code', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'zone' => $this->input->post('zone'),
               'zonal_code' => $this->input->post('zonal_code'),
           );
           $this->db->insert('zones', $data);
           redirect('zones', 'refresh');
       }
   }

   public function edit($id)
   {
       if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $row = $this->db->get_where('zones', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
       $this->load->view('zones/edit', $data);
   }

   public function edit_validate($id)
   {
       if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('zone', 'Zone', 'trim|required');
       $this->form_validation->set_rules('zonal_code', 'Zonal code', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'zone' => $this->input->post('zone'),
               'zonal_code' => $this->input->post('zonal_code'),
           );
           $this->db->where('id', $id);
           $this->db->update('zones', $data);
           redirect('zones', 'refresh');
       }
   }

   public function delete($id)
   {
       if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $this->db->delete('zones', array('id' => $id));
       redirect('zones', 'refresh');
   }

}
