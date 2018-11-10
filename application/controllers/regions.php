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

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	  if (getRole() == 'SuperAdmin') {
		$count = count($this->regionsmodel->get_list());
	  }
	 
	 if (getRole() == 'Admin') {
		
		$count = count($this->regionsmodel->get_list_by_country($country_id));
	 }
		 
	 
	    $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/regions/index/';
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
			   'rows' => $this->regionsmodel->get_paged_list($config['per_page'],$this->uri->segment(3)),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->regionsmodel->get_paged_country_list($config['per_page'],$this->uri->segment(3),$country_id),
		   );
	    }
		
		$data['links'] = $this->pagination->create_links();
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
		
		if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);;
            
        }
	   
	   
       $this->load->view('regions/index', $data);
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
			   'rows' => $this->regionsmodel->search_list($search),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->regionsmodel->search_country_list($search,$country_id),
		   );
	    }
		
		
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
		
		if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);;
            
        }
		
		$this->load->view('regions/search', $data);
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
	  $zone_id = $this->input->post('zone_id');
	  
	   if(empty($country_id))
		 {
			 if(getRole() == 'Admin')
			 {
				 $country_id = $this->erkanaauth->getField('country_id');
			 }
			 else
			 {
			 	$country_id = 0;
			 }
		 }
		 else
		 {
			 $country_id = $this->input->post('country_id');
		 }
		  if(empty($zone_id))
		 {
			 $zone_id = 0;
			 $count = count($this->regionsmodel->get_list_by_country($country_id));
		 }
		 else
		 {
			 $zone_id = $this->input->post('zone_id');
			 if($zone_id==0)
			 {
				 $count = count($this->regionsmodel->get_list_by_country($country_id));
			 }
			 else
			 {
			 	$count = count($this->regionsmodel->get_list_by_country_zone($country_id,$zone_id));
			 }
		 }
	  
	  		 
	 
	    $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/regions/regionfilter/'.$country_id.'/'.$zone_id;
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
		
		if(empty($zone_id))
		 {
			 $data = array(
			   'rows' => $this->regionsmodel->get_paged_country_list($config['per_page'],$this->uri->segment(4),$country_id),
		   );
		 }
		 else
		 {
			 $zone_id = $this->input->post('zone_id');
			 if($zone_id==0)
			 {
				 $data = array(
			   'rows' => $this->regionsmodel->get_paged_country_list($config['per_page'],$this->uri->segment(4),$country_id),
		   );
			 }
			 else
			 {
			 	$data = array(
			   'rows' => $this->regionsmodel->get_paged_filter_list($config['per_page'],$this->uri->segment(4),$country_id,$zone_id),
		   );
			 }
		 }
		
				
		$data['links'] = $this->pagination->create_links();
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
		
		if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);;
            
        }
	   
	   
       $this->load->view('regions/index', $data);
   }
   
    public function regionfilter($country_id,$zone_id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  
	   
			 if($zone_id==0)
			 {
				 $count = count($this->regionsmodel->get_list_by_country($country_id));
			 }
			 else
			 {
			 	$count = count($this->regionsmodel->get_list_by_country_zone($country_id,$zone_id));
			 }
		
	 
	    $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/regions/regionfilter/'.$country_id.'/'.$zone_id;
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 5;
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
		
		if(empty($zone_id))
		 {
			 $data = array(
			   'rows' => $this->regionsmodel->get_paged_country_list($config['per_page'],$this->uri->segment(5),$country_id),
		   );
		 }
		 else
		 {
			 $zone_id = $this->input->post('zone_id');
			 if($zone_id==0)
			 {
				 $data = array(
			   'rows' => $this->regionsmodel->get_paged_country_list($config['per_page'],$this->uri->segment(5),$country_id),
		   );
			 }
			 else
			 {
			 	$data = array(
			   'rows' => $this->regionsmodel->get_paged_filter_list($config['per_page'],$this->uri->segment(5),$country_id,$zone_id),
		   );
			 }
		 }
		
				
		$data['links'] = $this->pagination->create_links();
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
		
		if (getRole() == 'SuperAdmin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_list();
            
        }
		
		if (getRole() == 'Admin') {
            $data['regions']          = $this->regionsmodel->get_list();
            $data['districts']   = $this->districtsmodel->get_list();
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            
        }
	   
	   
       $this->load->view('regions/index', $data);
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
	   
       $data['zones'] = $this->zonesmodel->get_list();	   
	   $data['country'] = $country;
	   
	   $data['countries'] = $this->countriesmodel->get_list();
	   $this->load->view('regions/add',$data);
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
       $this->form_validation->set_rules('region', 'Region', 'trim|required');
       $this->form_validation->set_rules('regional_code', 'Regional code', 'trim|required');
       $this->form_validation->set_rules('zone_id', 'Zone', 'trim|required');
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

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	
	  
	   $row = $this->db->get_where('regions', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   
	   $zone = $this->zonesmodel->get_by_id($row->zone_id)->row();
	
       $data['zones'] = $this->zonesmodel->get_country_list($zone->country_id);
       $this->load->view('regions/edit', $data);
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

	 
	 if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	   $this->db->delete('regions', array('id' => $id));
       redirect('regions', 'refresh');
   }



}
