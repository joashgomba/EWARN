<?php

class Districts extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('districtsmodel');
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
           'rows' => $this->districtsmodel->get_combined_list(),
       );
       $this->load->view('districts/index', $data);
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
	   $data['regions'] = $this->regionsmodel->get_list();
       $this->load->view('districts/add',$data);
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
       $this->form_validation->set_rules('district', 'District', 'trim|required');
       $this->form_validation->set_rules('district_code', 'District code', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'district' => $this->input->post('district'),
               'district_code' => $this->input->post('district_code'),
               'region_id' => $this->input->post('region_id'),
           );
           $this->db->insert('districts', $data);
           redirect('districts', 'refresh');
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
	  
	   $row = $this->db->get_where('districts', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   $data['regions'] = $this->regionsmodel->get_list();
       $this->load->view('districts/edit', $data);
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
       $this->form_validation->set_rules('district', 'District', 'trim|required');
       $this->form_validation->set_rules('district_code', 'District code', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region id', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'district' => $this->input->post('district'),
               'district_code' => $this->input->post('district_code'),
               'region_id' => $this->input->post('region_id'),
           );
           $this->db->where('id', $id);
           $this->db->update('districts', $data);
           redirect('districts', 'refresh');
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
	  
	   $this->db->delete('districts', array('id' => $id));
       redirect('districts', 'refresh');
   }

}
