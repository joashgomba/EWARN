<?php

class Documents extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('documentsmodel');
   }

   public function index()
   {
       
	    //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	   $level = $this->erkanaauth->getField('level');
	   /**
	    1- zonal
        2- Regional
        3 - Health facility
        4- National
        5 - stake holder
	   **/
	  
	  if($level==1)
	  {
		  $document_level=2;
	  }
	  
	   if($level==2)
	  {
		  $document_level=3;
	  }
	  
	   if($level==3)
	  {
		  $document_level=4;
	  }
	  
	   if($level==4)
	  {
		  $document_level=1;
	  }
	   $data = array(
           'rows' => $this->documentsmodel->get_list_level($document_level)
       );
       $this->load->view('documents/index', $data);
   }

   public function add()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $data = array();
	   $data['error'] = '';
	   $this->load->view('documents/add',$data);
   }

   public function add_validate()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('title', 'Title', 'trim|required');
       $this->form_validation->set_rules('description', 'Description', 'trim|required');
	   
	   $file_element_name = 'userfile';
      
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
		   $config['upload_path'] = './documents/';
		  	$config['allowed_types'] = 'gif|jpg|png|doc|txt|pdf|xls|docx|xlxs';
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name))
			{
				$error = array('error' => $this->upload->display_errors());
				
				$data = array();
				$data['error'] = $error;
				
				$this->load->view('documents/add',$data);
	
			}
			else
			{
				$filedata = $this->upload->data();
				 $level = $this->erkanaauth->getField('level');
				   /**
					1- zonal
					2- Regional
					3 - Health facility
					4- National
					5 - stake holder
				   **/
				  
				  if($level==1)
				  {
					  $document_level=2;
				  }
				  
				   if($level==2)
				  {
					  $document_level=3;
				  }
				  
				   if($level==3)
				  {
					  $document_level=4;
				  }
				  
				   if($level==4)
				  {
					  $document_level=1;
				  }
				
			   $data = array(
				   'title' => $this->input->post('title'),
				   'description' => $this->input->post('description'),
				   'docname' => $filedata['file_name'],
				   'doctype' => $filedata['file_type'],
				   'docsize' => $filedata['file_size'],
				   'date_added' => date('Y-m-d'),
				   'level' => $document_level,
			   );
			   $this->db->insert('documents', $data);
			   redirect('documents','refresh');
			}
       }
   }

   public function edit($id)
   {
       //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	   $row = $this->db->get_where('documents', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
       $this->load->view('documents/edit', $data);
   }

   public function edit_validate($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('title', 'Title', 'trim|required');
       $this->form_validation->set_rules('description', 'Description', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'title' => $this->input->post('title'),
               'description' => $this->input->post('description'),
           );
           $this->db->where('id', $id);
           $this->db->update('documents', $data);
           redirect('documents','refresh');
       }
   }

   public function delete($id)
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	   $this->db->delete('documents', array('id' => $id));
       $this->index();
   }

}
