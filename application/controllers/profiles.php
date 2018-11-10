<?php

class Profiles extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('profilesmodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

		}
		
	   $this->edit();
   }

   public function add()
   {
       if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

		}
		
	   redirect('profiles/edit','refresh');
   }

   public function add_validate()
   {
	   if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

		}
		
       $this->load->library('form_validation');
	   $this->form_validation->set_rules('username', 'Username', 'trim|required');
	   $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
	   $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
       $this->form_validation->set_rules('date_of_birth', 'Date of birth', 'trim|required');
       $this->form_validation->set_rules('about_me', 'About Me', 'trim|required');
	   
	   $file_element_name = 'userfile';
	   
       if ($this->form_validation->run() == false) {
           $this->edit();
       } else {
		   
		   $passvalue = $this->input->post('password');
		   
		   if(empty($passvalue))
		   {
			   $password = $this->input->post('oldpassword');
		   }
		   else
		   {
			   $password = md5($passvalue);
		   }
		   
		   $user_id = $this->input->post('user_id');
		   
		   $userdata = array(
               'fname' => $this->input->post('fname'),
               'lname' => $this->input->post('lname'),
               'username' => $this->input->post('username'),
               'password' => $password,
           );
           $this->db->where('id', $user_id);
           $this->db->update('users', $userdata);
		   
		   
           $data = array(
		       'user_id' => $user_id,
               'date_of_birth' => $this->input->post('date_of_birth'),
			   'gender' => $this->input->post('gender'),
               'address' => $this->input->post('address'),
               'post_code' => $this->input->post('post_code'),
               'city' => $this->input->post('city'),
               'country' => $this->input->post('country'),
               'telephone' => $this->input->post('telephone'),
               'extension' => $this->input->post('extension'),
               'mobile' => $this->input->post('mobile'),
               'official_email' => $this->input->post('official_email'),
               'personal_email' => $this->input->post('personal_email'),
               'facebook' => $this->input->post('facebook'),
               'twitter' => $this->input->post('twitter'),
               'google_plus' => $this->input->post('google_plus'),
               'residential_address' => $this->input->post('residential_address'),
			   'photo' => '',
               'about_me' => $this->input->post('about_me'),
           );
           $this->db->insert('profiles', $data);
		   $id = $this->db->insert_id();
		   
		   $config['upload_path'] = './profilepics/';
		   $config['overwrite'] = 'TRUE';
		   $config['allowed_types'] = 'gif|jpg|png|';
		   $this->load->library('upload', $config);
		   
		   if (!$this->upload->do_upload($file_element_name))
		   {
		   }
		   else
		   {
			   $filedata = $this->upload->data();
			   $profiledata = array(
				   'photo' => $filedata['file_name'],
			   );
			   
			   $this->db->where('id', $id);
           	   $this->db->update('profiles', $profiledata);
			   
			   $rconfig['image_library'] = 'gd2';
				$rconfig['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				//$rconfig['create_thumb'] = TRUE;
				$rconfig['maintain_ratio'] = TRUE;
				$rconfig['width'] = 180;
				$rconfig['height'] = 200;
				
				$this->load->library('image_lib', $rconfig);
				
				$this->image_lib->resize();
		   }
		   
		   
           redirect('profiles/edit','refresh');
       }
   }

   public function edit()
   {
       if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

		}
		
		$user_id = $this->erkanaauth->getField('id');
		
		$profile = $this->profilesmodel->get_by_user_id($user_id)->row();
		
		if(empty($profile))
		{
			$id = 0;
		}
		else
		{
			$id = $profile->id;
		}
		
	   $row = $this->db->get_where('profiles', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
	   
	   $data['user'] = $this->usersmodel->get_by_id($user_id)->row();
       $this->load->view('profiles/edit', $data);
   }

   public function edit_validate($id)
   {
	   if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

		}
		
       $this->load->library('form_validation');
	   $this->form_validation->set_rules('username', 'Username', 'trim|required');
	   $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
	   $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
       $this->form_validation->set_rules('date_of_birth', 'Date of birth', 'trim|required');
       $this->form_validation->set_rules('about_me', 'About Me', 'trim|required');
	   
	   $file_element_name = 'userfile';
	   
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
		   
		   $passvalue = $this->input->post('password');
		   
		   if(empty($passvalue))
		   {
			   $password = $this->input->post('oldpassword');
		   }
		   else
		   {
			   $password = md5($passvalue);
		   }
		   
		   $user_id = $this->input->post('user_id');
		   
		   $userdata = array(
               'fname' => $this->input->post('fname'),
               'lname' => $this->input->post('lname'),
               'username' => $this->input->post('username'),
               'password' => $password,
           );
           $this->db->where('id', $user_id);
           $this->db->update('users', $userdata);
		   
		   
           $data = array(
               'date_of_birth' => $this->input->post('date_of_birth'),
			   'gender' => $this->input->post('gender'),
               'address' => $this->input->post('address'),
               'post_code' => $this->input->post('post_code'),
               'city' => $this->input->post('city'),
               'country' => $this->input->post('country'),
               'telephone' => $this->input->post('telephone'),
               'extension' => $this->input->post('extension'),
               'mobile' => $this->input->post('mobile'),
               'official_email' => $this->input->post('official_email'),
               'personal_email' => $this->input->post('personal_email'),
               'facebook' => $this->input->post('facebook'),
               'twitter' => $this->input->post('twitter'),
               'google_plus' => $this->input->post('google_plus'),
               'residential_address' => $this->input->post('residential_address'),
               'about_me' => $this->input->post('about_me'),
           );
           $this->db->where('id', $id);
           $this->db->update('profiles', $data);
		   
		   $config['upload_path'] = './profilepics/';
		   $config['overwrite'] = 'TRUE';
		   $config['allowed_types'] = 'gif|jpg|png|';
		   $this->load->library('upload', $config);
		   
		   if (!$this->upload->do_upload($file_element_name))
		   {
		   }
		   else
		   {
			   $filedata = $this->upload->data();
			   $profiledata = array(
				   'photo' => $filedata['file_name'],
			   );
			   
			   $this->db->where('id', $id);
           	   $this->db->update('profiles', $profiledata);
			   
			   $rconfig['image_library'] = 'gd2';
				$rconfig['source_image'] = $this->upload->upload_path.$this->upload->file_name;
				//$rconfig['create_thumb'] = TRUE;
				$rconfig['maintain_ratio'] = TRUE;
				$rconfig['width'] = 180;
				$rconfig['height'] = 200;
				
				$this->load->library('image_lib', $rconfig);
				
				$this->image_lib->resize();
		   }
		   
		   
           redirect('profiles/edit','refresh');
       }
   }

   public function delete($id)
   {
       redirect('profiles/edit','refresh');
   }

}
