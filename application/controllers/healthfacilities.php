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

	 
	 if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	  if (getRole() == 'SuperAdmin') {
		$count = count($this->healthfacilitiesmodel->get_list());
	  }
	 
	 if (getRole() == 'Admin') {
		
		$count = count($this->healthfacilitiesmodel->get_list_by_country($country_id));
	 }
	 
	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/healthfacilities/index/';
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
			   'rows' => $this->healthfacilitiesmodel->get_paged_list($config['per_page'],$this->uri->segment(3)),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->healthfacilitiesmodel->get_country_paged_list($config['per_page'],$this->uri->segment(3),$country_id),
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

       $data['country_id'] = $country_id;
       $data['zone_id'] = 0;
       $data['region_id'] = 0;
       $data['district_id'] = 0;
		
       $this->load->view('healthfacilities/index', $data);
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
			   'rows' => $this->healthfacilitiesmodel->search_list($search),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->healthfacilitiesmodel->search_country_list($search,$country_id),
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
		
       $this->load->view('healthfacilities/search', $data);
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
	  $district_id = $this->input->post('district_id');
	  
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
	  
	  if(empty($district_id))
	  {
		  $district_id = 0;
	  }
	  else
	  {
		  $district_id = $this->input->post('district_id');
	  }
	  	  
	   $count = count($this->healthfacilitiesmodel->get_list_by_parameters($country_id,$zone_id,$region_id,$district_id));
	  
	  
	    $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/healthfacilities/healthfacilityfilter/'.$country_id.'/'.$zone_id.'/'.$region_id.'/'.$district_id;
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
			   'rows' => $this->healthfacilitiesmodel->get_paged_list_by_parameters($config['per_page'],$this->uri->segment(6),$country_id,$zone_id,$region_id,$district_id),
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

       $data['country_id'] = $country_id;
       $data['zone_id'] = $zone_id;
       $data['region_id'] = $region_id;
       $data['district_id'] = $district_id;

       $this->load->view('healthfacilities/index', $data);
   }

   public function export($country_id,$zone_id,$region_id,$district_id)
   {
       //ensure that the user is logged in
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }


       if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
       {
           redirect('home', 'refresh');
       }

       $rows = $this->healthfacilitiesmodel->get_list_by_admin_regions($country_id,$zone_id,$region_id,$district_id);

       $table = '<table border="1" width="100%">
        <thead>
        <tr><th>#</th><th>Database ID</th><th>Health Facility</th><th>HF Code</th><th>Zone</th><th>Region</th><th>District</th><th>Activated</th></tr>
</thead>
<tbody>';
       $i = 0;
       foreach ($rows as $row):
        $i++;
           $table .= '<tr><td>'.$i.'</td><td>'.$row['healthfacility_id'].'</td><td>'.$row['health_facility'].'</td><td>'.$row['hf_code'].'</td><td>'.$row['zone'].'</td><td>'.$row['region'].'</td><td>'.$row['district'].'</td>';
           if($row['activated']==1)
           {
               $activated =  'Yes';
           }
           else
           {
               $activated = 'No';
           }
           $table .= '<td>'.$activated.'</td></tr>';

       endforeach;

       $table .= '</tbody></table>';

       //echo $table;


       $filename = "HF_List_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-word");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");


       $this->output->append_output($table);
   }
   
   public function healthfacilityfilter($country_id,$zone_id,$region_id,$district_id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	    $count = count($this->healthfacilitiesmodel->get_list_by_parameters($country_id,$zone_id,$region_id,$district_id));
	  
	  
	    $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/healthfacilities/healthfacilityfilter/'.$country_id.'/'.$zone_id.'/'.$region_id.'/'.$district_id;
		$config['total_rows'] = $count;
		$config['per_page'] = 10;
		$config['uri_segment'] = 7;
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
			   'rows' => $this->healthfacilitiesmodel->get_paged_list_by_parameters($config['per_page'],$this->uri->segment(7),$country_id,$zone_id,$region_id,$district_id),
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
	   
	   
       $this->load->view('healthfacilities/index', $data);
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
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
		$data['country'] = $country;
		
       $this->load->view('healthfacilities/add',$data);
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
			   'catchment_population' => $this->input->post('catchment_population'),
			   'focal_person_name' => $this->input->post('focal_person_name'),
			   'contact_number' => $this->input->post('contact_number'),
			   'email' => $this->input->post('email'),
			   'activated' => 1,
			   'otherval' => $this->input->post('othervalue'),
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

	 if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  
	   $row = $this->db->get_where('healthfacilities', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   
	   $district = $this->districtsmodel->get_by_id($row->district_id)->row();
	   $region = $this->regionsmodel->get_by_id($district->region_id)->row();
	   $zone = $this->zonesmodel->get_by_id($region->zone_id)->row();
	   $country = $this->countriesmodel->get_by_id($zone->country_id)->row();
	   
	   $data['districts'] = $this->districtsmodel->get_by_region($region->id);
       $this->load->view('healthfacilities/edit', $data);
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
       //$this->form_validation->set_rules('organization', 'Organization', 'trim|required');
	   $this->form_validation->set_rules('health_facility', 'Health facility', 'trim|required');
       $this->form_validation->set_rules('hf_code', 'Hf code', 'trim|required');
       $this->form_validation->set_rules('district_id', 'District', 'trim|required');
	   //$this->form_validation->set_rules('focal_person_name', 'Focal Person Name', 'trim|required');
	  // $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required');
	   
	   
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'health_facility' => $this->input->post('health_facility'),
               'hf_code' => $this->input->post('hf_code'),
               'district_id' => $this->input->post('district_id'),
			   'organization' => $this->input->post('organization'),
			   'health_facility_type' => $this->input->post('health_facility_type'),
			   'catchment_population' => $this->input->post('catchment_population'),
			   'focal_person_name' => $this->input->post('focal_person_name'),
			   'contact_number' => $this->input->post('contact_number'),
			   'email' => $this->input->post('email'),
			   'activated' => $this->input->post('activated'),
			   'otherval' => $this->input->post('othervalue'),
           );
           $this->db->where('id', $id);
           $this->db->update('healthfacilities', $data);
           redirect('healthfacilities', 'refresh');
       }
   }
   
   public function activation()
   {
	   $activation = $this->input->post('activation');
	   
	   if (!empty($_POST['healthfacility_id'])) {
		   foreach ($_POST['healthfacility_id'] as $row => $id) {
			   $healthfacility_id = $id;
			   
			   $data = array(
               'activated' => $activation,
           		);
				
           		$this->db->where('id', $healthfacility_id);
				$this->db->update('healthfacilities', $data);
			   
		   }
		   
	   }
	   
	   redirect('healthfacilities', 'refresh');
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

   public function merge($old_id,$new_id)
   {
       $forms = $this->formsmodel->get_by_hf($old_id);
       $formalerts = $this->formalertsmodel->get_by_hf($old_id);
       $formsdata = $this->formsdatamodel->get_by_hf($old_id);
       $users = $this->usersmodel->get_by_hf($old_id);


        foreach($forms as $key=>$form):

            $data = array(
                'healthfacility_id' => $new_id,
            );
            $this->db->where('id', $form['id']);
            $this->db->update('forms', $data);

        endforeach;

       foreach($formalerts as $key=>$formalert):

           $mydata = array(
               'healthfacility_id' => $new_id,
           );
           $this->db->where('id', $formalert['id']);
           $this->db->update('formalerts', $mydata);

       endforeach;

       foreach($formsdata as $key=>$formdata):

           $thedata = array(
               'healthfacility_id' => $new_id,
           );
           $this->db->where('id', $formdata['id']);
           $this->db->update('formsdata', $thedata);

       endforeach;

       foreach($users as $key=>$user):

           $userdata = array(
               'healthfacility_id' => $new_id,
           );
           $this->db->where('id', $user['id']);
           $this->db->update('users', $userdata);

       endforeach;



       $this->db->delete('healthfacilities', array('id' => $old_id));


       echo 'SUCCESS';

   }

   public function generate_users(){

       $rows = $this->healthfacilitiesmodel->get_list_by_admin_regions(1,0,0,0);
       $table = '<table border="1" width="100%">';

       $table .= '<tr><td>Zone</td><td>Region</td><td>District</td><td>Health Facility</td><td>Activated</td><td>Username</td><td>Password</td></tr>';

       foreach ($rows as $row):

          $added = $this->usersmodel->get_by_hf_id($row['healthfacility_id'])->row();
          $district = $this->districtsmodel->get_by_id($row['district_id'])->row();
          $region = $this->regionsmodel->get_by_id($district->region_id)->row();
          $zone = $this->zonesmodel->get_by_id($region->zone_id)->row();

        $pword = $this->generatePassword(9,0);
        $password=md5($pword);

            if(empty($added))
            {
                $string = trim($row['health_facility']);
                //$str = str_replace(' ','',$string);
                //$username = strtolower($str);
                //$username = '-';

                $str = str_replace('/',' ',$string);
                $uname = str_replace('-',' ',$str);
                $strn = str_replace('.',' ',$uname);

                //$username = $this->random_username($row['health_facility']);
                $genname = $this->random_username($strn);

                if(is_numeric($genname)){
                    $nrRand = rand(0, 100);
                    $username = strtolower($strn.trim($nrRand));
                }
                else{
                    $username = $genname;
                }

                $data = array(
                    'fname' => $row['health_facility'],
                    'lname' => $row['health_facility'],
                    'healthfacility_id' => $row['healthfacility_id'],
                    'organization' => $row['health_facility'],
                    'email' => '-',
                    'contact_number' => 0,
                    'username' => $username,
                    'password' => $password,
                    'role_id' => 3,
                    'active' => 1,
                    'level' => 3,
                    'zone_id' => $zone->id,
                    'region_id' => $region->id,
                    'district_id' => $district->id,
                    'country_id' => 1,
                );
                $this->db->insert('users', $data);
                $id = $this->db->insert_id();

                //add profile
                $profiledata = array(
                    'user_id' => $id,
                    'date_of_birth' => '0000-00-00',
                    'gender' => '',
                    'address' => '-',
                    'post_code' => '-',
                    'city' => $district->district,
                    'country' => 'Somalia',
                    'telephone' => '-',
                    'extension' => '-',
                    'mobile' => '-',
                    'official_email' =>  '-',
                    'personal_email' => '-',
                    'facebook' => '-',
                    'twitter' => '-',
                    'google_plus' => '-',
                    'residential_address' => '-',
                    'photo' => '-',
                    'about_me' => $row['health_facility'],
                );
                $this->db->insert('profiles', $profiledata);
            }
            else{
                $username = $added->username;
                $data = array(
                    'username' => $username,
                    'password' => $password,
                    'active' => $this->input->post('active'),
                );
                $this->db->where('id', $added->id);
                $this->db->update('users', $data);
            }

           if($row['activated']==1)
           {
               $activated =  'Yes';
           }
           else
           {
               $activated = 'No';
           }

               $table .= '<tr><td>'.$row['zone'].'</td><td>'.$row['region'].'</td><td>'.$row['district'].'</td><td>'.$row['health_facility'].'</td><td>'.$activated.'</td><td>'.$username.'</td><td>'.$pword.'</td></tr>';

       endforeach;

       $table .= '</table>';

       echo $table;
   }



    function generatePassword($length=9, $strength=0) {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    function random_username($string) {
        $pattern = " ";
        $firstPart = strstr(strtolower($string), $pattern, true);
        $secondPart = substr(strstr(strtolower($string), $pattern, false), 0,3);
        $nrRand = rand(0, 100);

        $username = trim($firstPart).trim($secondPart).trim($nrRand);
        return $username;
    }

    function generateRandomUsername($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
