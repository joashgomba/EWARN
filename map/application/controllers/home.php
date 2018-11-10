<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//session_start(); //we need to call PHP's session object to access it through CI

class Home extends CI_Controller {



 function __construct()
 {

   parent::__construct();
   
  }

 function index()
 {
	 //ensure that the user is logged in
	 
	 /**
	   if($this->session->userdata('logged_in'))
	   {
		 $session_data = $this->session->userdata('logged_in');
		 $data['username'] = $session_data['username'];
		 $this->load->view('home_view', $data);
	   }
	   else
	   {
		 //If no session, redirect to login page
		 redirect('login', 'refresh');
	   }
	 
	 **/
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }
	  
	  $level = $this->erkanaauth->getField('level');
	  
	   $active = $this->erkanaauth->getField('active');
	   
	   if($active==0)
	   {
		   redirect('home/logout','refresh');
	   }
	  
	  if ($level == 2) //regional
	  {
		  $title = 'Regional';
	  }
	  
	  if ($level == 4) //National
	  {
		  $title = 'National';
	  }
	  if ($level == 1) //zonal
	  {
		  $title = 'Zonal';
	  }
	  
	   if ($level == 3) //HF
	  {
		  $title = 'Health Facility';
	  }
	 
	 
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
           'rows' => $this->bulletinsmodel->get_by_level_limit($level),
		   'documents' => $this->documentsmodel->get_by_level_limit($document_level),
       );
	   
	   $data['title'] = $title;
		
   	$this->load->view('home/home_view', $data); 

 }

 function logout()
 {

   $this->erkanaauth->logout();
   $this->session->sess_destroy();

   redirect('login', 'refresh');
   /**
   $this->session->unset_userdata('logged_in');
   session_destroy();
   redirect('home', 'refresh');
   **/
 

 }
 
}

?>