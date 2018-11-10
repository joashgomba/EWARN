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

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	   if (getRole() == 'SuperAdmin') {
		$count = count($this->districtsmodel->get_list());
	  }
	 
	 if (getRole() == 'Admin') {
		
		$count = count($this->districtsmodel->get_list_by_country($country_id));
	 }
	 
	 
	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/districts/index/';
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
			   'rows' => $this->districtsmodel->get_paged_list($config['per_page'],$this->uri->segment(3)),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->districtsmodel->get_country_list($config['per_page'],$this->uri->segment(3),$country_id),
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
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            
        }
		
       $this->load->view('districts/index', $data);
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
	  $region_id = $this->input->post('region_id');
	  
	  if(empty($zone_id))
	  {
		  $zone_id = 0;
	  }
	  else
	  {
		  $zone_id = $this->input->post('zone_id');
	  }
	  
	  if(empty($region_id))
	  {
		  $region_id = 0;
	  }
	  else
	  {
		  $region_id = $this->input->post('region_id');
	  }
	  	  
	   $count = count($this->districtsmodel->get_list_by_parameters($country_id,$zone_id,$region_id));
	  
	  
	    $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/districts/districtfilter/'.$country_id.'/'.$zone_id.'/'.$region_id;
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
		
		$data = array(
			   'rows' => $this->districtsmodel->get_paged_list_by_parameters($config['per_page'],$this->uri->segment(5),$country_id,$zone_id,$region_id),
		   );
		
				
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
	   
	   
       $this->load->view('districts/index', $data);
   }
   
   public function districtfilter($country_id,$zone_id,$region_id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  	  	  
	   $count = count($this->districtsmodel->get_list_by_parameters($country_id,$zone_id,$region_id));
	  
	  
	    $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/districts/districtfilter/'.$country_id.'/'.$zone_id.'/'.$region_id;
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 6;
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
			   'rows' => $this->districtsmodel->get_paged_list_by_parameters($config['per_page'],$this->uri->segment(6),$country_id,$zone_id,$region_id),
		   );
		
				
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
	   
	   
       $this->load->view('districts/index', $data);
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
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  $search = $this->input->post('search');
	  
	   if (getRole() == 'SuperAdmin') {
		
			$data = array(
			   'rows' => $this->districtsmodel->search_list($search),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->districtsmodel->search_country_list($search,$country_id),
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
            $data['zones']            = $this->zonesmodel->get_country_list($country_id);
            
        }
		
       $this->load->view('districts/search', $data);
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
	   
	   $data['countries'] = $this->countriesmodel->get_list();	   
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
		
		$data['country_id'] = $country_id;
		$data['country'] = $country;
       $this->load->view('districts/add',$data);
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
       $this->form_validation->set_rules('district', 'District', 'trim|required');
       $this->form_validation->set_rules('district_code', 'District code', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region', 'trim|required');
	   $this->form_validation->set_rules('lat', 'Latitude', 'trim|required');
	   $this->form_validation->set_rules('long', 'Longitude', 'trim|required');
	   
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'district' => $this->input->post('district'),
               'district_code' => $this->input->post('district_code'),
               'region_id' => $this->input->post('region_id'),
			    'lat' => $this->input->post('lat'),
			   'long' => $this->input->post('long'),
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

	 
	 if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  //$result = urldecode(base64_decode($id));
	  
	   $row = $this->db->get_where('districts', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   
	   $region = $this->regionsmodel->get_by_id($row->region_id)->row();
	   $zone = $this->zonesmodel->get_by_id($region->zone_id)->row();
	   $country = $this->countriesmodel->get_by_id($zone->country_id)->row();
	   $data['regions'] = $this->regionsmodel->get_list_by_country($country->id);
       $this->load->view('districts/edit', $data);
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
       $this->form_validation->set_rules('district', 'District', 'trim|required');
       $this->form_validation->set_rules('district_code', 'District code', 'trim|required');
       $this->form_validation->set_rules('region_id', 'Region id', 'trim|required');
	   $this->form_validation->set_rules('lat', 'Latitude', 'trim|required');
	   $this->form_validation->set_rules('long', 'Longitude', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'district' => $this->input->post('district'),
               'district_code' => $this->input->post('district_code'),
               'region_id' => $this->input->post('region_id'),
			   'lat' => $this->input->post('lat'),
			   'long' => $this->input->post('long'),
           );
           $this->db->where('id', $id);
           $this->db->update('districts', $data);
           redirect('districts', 'refresh');
		   
		   //echo $region_id;
       }
   }
   
   public function gpslist()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	 if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	   $data = array(
           'rows' => $this->districtsmodel->get_combined_list(),
       );
       $this->load->view('districts/gpsindex', $data);
   }
   
    public function gpsedit($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	   $row = $this->db->get_where('districts', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   $data['regions'] = $this->regionsmodel->get_list();
       $this->load->view('districts/gpsedit', $data);
   }
   
   public function gpsedit_validate($id)
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
       $this->form_validation->set_rules('lat', 'Latitude', 'trim|required');
       $this->form_validation->set_rules('long', 'Longitude code', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->gpsedit($id);
       } else {
           $data = array(
               'lat' => $this->input->post('lat'),
               'long' => $this->input->post('long'),
           );
           $this->db->where('id', $id);
           $this->db->update('districts', $data);
           redirect('districts/gpslist', 'refresh');
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
	  
	   $this->db->delete('districts', array('id' => $id));
       redirect('districts', 'refresh');
   }


    public function merge($old_id,$new_id)
    {
        $forms = $this->formsmodel->get_by_district($old_id);
        $formalerts = $this->formalertsmodel->get_by_district($old_id);
        $formsdata = $this->formsdatamodel->get_by_district($old_id);
        $users = $this->usersmodel->get_by_district($old_id);
        $healthfacilities = $this->healthfacilitiesmodel->get_by_district($old_id);


        foreach($forms as $key=>$form):

            $data = array(
                'district_id' => $new_id,
            );
            $this->db->where('id', $form['id']);
            $this->db->update('forms', $data);

        endforeach;

        foreach($formalerts as $key=>$formalert):

            $mydata = array(
                'district_id' => $new_id,
            );
            $this->db->where('id', $formalert['id']);
            $this->db->update('formalerts', $mydata);

        endforeach;

        foreach($formsdata as $key=>$formdata):

            $thedata = array(
                'district_id' => $new_id,
            );
            $this->db->where('id', $formdata['id']);
            $this->db->update('formsdata', $thedata);

        endforeach;

        foreach($users as $key=>$user):

            $userdata = array(
                'district_id' => $new_id,
            );
            $this->db->where('id', $user['id']);
            $this->db->update('users', $userdata);

        endforeach;

        foreach($healthfacilities as $key=>$healthfacility):

            $hfdata = array(
                'district_id' => $new_id,
            );
            $this->db->where('id', $healthfacility['id']);
            $this->db->update('users', $hfdata);

        endforeach;



        $this->db->delete('districts', array('id' => $old_id));


        echo 'SUCCESS';

    }

}
