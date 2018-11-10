<?php

class Diseases extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('diseasesmodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	  if (getRole() == 'SuperAdmin') {
		$count = count($this->diseasesmodel->get_list());
	  }
	 
	 if (getRole() == 'Admin') {
		
			$count = count($this->diseasesmodel->get_country_list($country_id));
	 }
	 
	 
	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/diseases/index/';
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
			   'rows' => $this->diseasesmodel->get_paged_list($config['per_page'],$this->uri->segment(3)),
		   );
	   
		}
		
		 if (getRole() == 'Admin') {
		
			$data = array(
			   'rows' => $this->diseasesmodel->get_paged_country_list($config['per_page'],$this->uri->segment(3),$country_id),
		   );
	    }
		
	   $data['links'] = $this->pagination->create_links();
	   
	   $data['countries'] = $this->countriesmodel->get_list();
	   $data['country_id'] = $country_id;
	   
       $this->load->view('diseases/index', $data);
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
	  
	  $count = count($this->diseasesmodel->get_country_list($country_id));
	 
	 
	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/diseases/diseasesfilter/'.$country_id;
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
			   'rows' => $this->diseasesmodel->get_paged_country_list($config['per_page'],$this->uri->segment(3),$country_id),
		   );
	   	
		$data['links'] = $this->pagination->create_links();
		
		$data['countries'] = $this->countriesmodel->get_list();
		$data['country_id'] = $country_id;
	 
	  
       $this->load->view('diseases/index', $data);
   }
   
   public function diseasesfilter($country_id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	   if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $count = count($this->diseasesmodel->get_country_list($country_id));
	 
	 
	 $this->load->library('pagination');
		$config['use_page_numbers'] = FALSE;
		$config['base_url'] = base_url().'index.php/diseases/diseasesfilter/'.$country_id;
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
			   'rows' => $this->diseasesmodel->get_paged_country_list($config['per_page'],$this->uri->segment(4),$country_id),
		   );
	   	
		$data['links'] = $this->pagination->create_links();
		$data['country_id'] = $country_id;
		
		$data['countries'] = $this->countriesmodel->get_list();
	 
	  
       $this->load->view('diseases/index', $data);
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
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  
	  
       $data = array();
	   $data['country_id'] = $country_id;
	   $data['countries'] = $this->countriesmodel->get_list();
	   $data['diseasecategories'] = $this->diseasecategoriesmodel->get_list();
       $this->load->view('diseases/add',$data);
   }

   public function add_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       $this->form_validation->set_rules('country_id', 'Country', 'trim|required');
       $this->form_validation->set_rules('diseasecategory_id', 'Disease category', 'trim|required');
	   $this->form_validation->set_rules('color_code', 'Colour code', 'trim|required');
       $this->form_validation->set_rules('disease_code', 'Disease code', 'trim|required');
       $this->form_validation->set_rules('disease_name', 'Disease name', 'trim|required');
       $this->form_validation->set_rules('case_definition', 'Case definition', 'trim|required');
       $this->form_validation->set_rules('alert_type', 'Alert type', 'trim|required');
       //$this->form_validation->set_rules('alert_threshold', 'Alert threshold', 'trim|required');
       //$this->form_validation->set_rules('no_of_times', 'No of times', 'trim|required');
       //$this->form_validation->set_rules('weeks', 'Weeks', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
		   
		   $disease_code = trim($this->input->post('disease_code'));
           $data = array(
               'country_id' => $this->input->post('country_id'),
               'diseasecategory_id' => $this->input->post('diseasecategory_id'),
               'disease_code' => $disease_code,
               'disease_name' => $this->input->post('disease_name'),
               'case_definition' => $this->input->post('case_definition'),
               'alert_type' => $this->input->post('alert_type'),
               'alert_threshold' => $this->input->post('alert_threshold'),
               'no_of_times' => $this->input->post('no_of_times'),
               'weeks' => $this->input->post('weeks'),
			   'color_code' => $this->input->post('color_code'),
           );
           $this->db->insert('diseases', $data);
           redirect('diseases','refresh');
       }
   }

   public function edit($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $row = $this->db->get_where('diseases', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   
	    $country_id = $this->erkanaauth->getField('country_id');
	   
		   if(getRole() != 'SuperAdmin')
		  {
			  if($row->country_id !=$country_id)
			  {
					redirect('home', 'refresh');
			  }
		  }
	  
	   $data['countries'] = $this->countriesmodel->get_list();
	   $data['diseasecategories'] = $this->diseasecategoriesmodel->get_list();
	   $data['country_id'] = $country_id;
       $this->load->view('diseases/edit', $data);
   }

   public function edit_validate($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->load->library('form_validation');
       //$this->form_validation->set_rules('country_id', 'Country id', 'trim|required');
       $this->form_validation->set_rules('diseasecategory_id', 'Disease category', 'trim|required');
	   $this->form_validation->set_rules('color_code', 'Colour code', 'trim|required');
       //$this->form_validation->set_rules('disease_code', 'Disease code', 'trim|required');
       $this->form_validation->set_rules('disease_name', 'Disease name', 'trim|required');
       $this->form_validation->set_rules('case_definition', 'Case definition', 'trim|required');
       //$this->form_validation->set_rules('alert_type', 'Alert type', 'trim|required');
       //$this->form_validation->set_rules('alert_threshold', 'Alert threshold', 'trim|required');
       //$this->form_validation->set_rules('no_of_times', 'No of times', 'trim|required');
       //$this->form_validation->set_rules('weeks', 'Weeks', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
		   
		   $alert_type = $this->input->post('alert_type');
		   
		   if($alert_type==1)
		   {
			   $data = array(
			   'diseasecategory_id' => $this->input->post('diseasecategory_id'),
               'disease_name' => $this->input->post('disease_name'),
               'case_definition' => $this->input->post('case_definition'),
			   'alert_threshold' => $this->input->post('alert_threshold'),
			   'color_code' => $this->input->post('color_code'),
           		);
		   }
		   else
		   {
			    $data = array(
			   'diseasecategory_id' => $this->input->post('diseasecategory_id'),
               'disease_name' => $this->input->post('disease_name'),
               'case_definition' => $this->input->post('case_definition'),
			   'no_of_times' => $this->input->post('no_of_times'),
			   'weeks' => $this->input->post('weeks'),
			   'color_code' => $this->input->post('color_code'),
           		);
		   }
		   
           
           $this->db->where('id', $id);
           $this->db->update('diseases', $data);
           redirect('diseases','refresh');
       }
   }
   
   
   public function generateform($country_id)
   {
	   $diseases =  $this->db->get_where('diseases', array('country_id' => $country_id));
	   
	   $this->db->select_max('id');
	   $row = $this->db->get_where('diseases', array('country_id' => $country_id))->row();
	  
	   
	   $formJSON = '{"fields":[';
	   
	   foreach ($diseases->result() as $disease): 
	   
	   	if($disease->id == $row->id)
		{
			$coma = '';
		}
		else
		{
			$coma = ',';
		}
	   
	   	$formJSON .= '{"label":"'.$disease->disease_code.' <5 Male","field_type":"text","required":true,"field_options":{"size":"medium","description":"'.$disease->disease_code.'< 5 Male","minlength":"1","maxlength":"2","min_max_length_units":"characters","name"="'.$disease->disease_code.'_ufive_male"},"cid":"'.$disease->disease_code.'_ufive_male"},';
		$formJSON .= '{"label":"'.$disease->disease_code.' <5 Female","field_type":"text","required":true,"field_options":{"size":"medium","description":"'.$disease->disease_code.'< 5 Female","minlength":"1","maxlength":"2","min_max_length_units":"characters","name"="'.$disease->disease_code.'_ufive_female"},"cid":"'.$disease->disease_code.'_ufive_female"},';
		
		$formJSON .= '{"label":"'.$disease->disease_code.' >5 Male","field_type":"text","required":true,"field_options":{"size":"medium","description":"'.$disease->disease_code.'> 5 Male","minlength":"1","maxlength":"2","min_max_length_units":"characters","name"="'.$disease->disease_code.'_ofive_male"},"cid":"'.$disease->disease_code.'_ofive_male"},';
		$formJSON .= '{"label":"'.$disease->disease_code.' >5 Female","field_type":"text","required":true,"field_options":{"size":"medium","description":"'.$disease->disease_code.'> 5 Female","minlength":"1","maxlength":"2","min_max_length_units":"characters","name"="'.$disease->disease_code.'_ofive_female"},"cid":"'.$disease->disease_code.'_ofive_female"}'.$coma.'';
		$formJSON .= '<br>';
	   
	   endforeach;
	   
	   $formJSON .= ']}';
	   
	   echo $formJSON;
   }

   public function delete($id)
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
       $this->db->delete('diseases', array('id' => $id));
       redirect('diseases','refresh');
   }

}
