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

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	   if (getRole() == 'SuperAdmin') {
		$count = count($this->zonesmodel->get_list());
	  }
	 
	 if (getRole() == 'Admin') {
		
			$count = count($this->zonesmodel->get_country_list($country_id));
	 }
	 
	 
	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/zones/index/';
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-double-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-double-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		
		if (getRole() == 'SuperAdmin') {
		
			$data = array(
			   'rows' => $this->zonesmodel->get_paged_list($config['per_page'],$this->uri->segment(3)),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->zonesmodel->get_paged_country_list($config['per_page'],$this->uri->segment(3),$country_id),
		   );
	    }
		
		$data['links'] = $this->pagination->create_links();
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
	 
	  
       $this->load->view('zones/index', $data);
   }
   
   public function search()
   {
	     //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $search = $this->input->post('search');
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	  if (getRole() == 'SuperAdmin') {
		
			$data = array(
			   'rows' => $this->zonesmodel->search_list($search),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->zonesmodel->search_country_list($search,$country_id),
		   );
	    }
		
		
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
		
		$this->load->view('zones/search', $data);
   }
   
   public function filter()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $country_id = $this->input->post('country_id');
	  
	  $count = count($this->zonesmodel->get_country_list($country_id));
	 
	 
	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/zones/zonesfilter/'.$country_id;
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-double-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-double-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		
		
		$data = array(
			   'rows' => $this->zonesmodel->get_paged_country_list($config['per_page'],$this->uri->segment(3),$country_id),
		   );
	   	
		$data['links'] = $this->pagination->create_links();
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
	 
	  
       $this->load->view('zones/index', $data);
   }
   
    public function zonesfilter($country_id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  
	  $count = count($this->zonesmodel->get_country_list($country_id));
	 
	 
	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/zones/zonesfilter/'.$country_id;
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = '<ul>';
		$config['full_tag_close'] = '</ul>';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-double-angle-left"></i>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-double-angle-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);
		
		
		$data = array(
			   'rows' => $this->zonesmodel->get_paged_country_list($config['per_page'],$this->uri->segment(4),$country_id),
		   );
	   	
		$data['links'] = $this->pagination->create_links();
		
		$data['countries'] = $this->countriesmodel->get_list();
	 
	  
       $this->load->view('zones/index', $data);
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
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
	  $data['country'] = $country;
	  
	  $data['countries'] = $this->countriesmodel->get_list();
	   $this->load->view('zones/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin'&& getRole() != 'Admin')

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
			   'country_id' => $this->input->post('country_id'),
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

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
  
	   $row = $this->db->get_where('zones', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   
	   $data['countries'] = $this->countriesmodel->get_list();
	   $country_id = $this->erkanaauth->getField('country_id');
	   $country = $this->countriesmodel->get_by_id($country_id)->row();
	  $data['country'] = $country;
	   
	   
       $this->load->view('zones/edit', $data);
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
       $this->form_validation->set_rules('zone', 'Zone', 'trim|required');
       $this->form_validation->set_rules('zonal_code', 'Zonal code', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'zone' => $this->input->post('zone'),
               'zonal_code' => $this->input->post('zonal_code'),
			   'country_id' => $this->input->post('country_id'),
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

	 
	  if(getRole() != 'SuperAdmin'&& getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }
	  
	   $this->db->delete('zones', array('id' => $id));
       redirect('zones', 'refresh');
   }

}
