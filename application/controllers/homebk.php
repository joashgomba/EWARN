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
	   
	   $country_id = $this->erkanaauth->getField('country_id');
	   
	   if($active==0)
	   {
		   redirect('home/logout','refresh');
	   }
	  
	  if ($level == 1) //zonal
	  {
		  $title = 'Zonal';
	  }
	  if ($level == 2) //regional
	  {
		  $title = 'Regional';
	  }
	   if ($level == 3) //HF
	  {
		  $title = 'Health Facility';
	  }
	  if ($level == 4) //National
	  {
		  $title = 'National';
	  }
	  if ($level == 5) //Stakeholder
	  {
		  $title = 'National';
	  }
	   if ($level == 6) //District
	  {
		  $title = 'District';
	  }
	  
	  
	  
	  
	 
	 
	  if($level==1)//zonal
	  {
		  $document_level=2;
		  $zone_id = $this->erkanaauth->getField('zone_id');
		   $data = array(
           'rows' => $this->bulletinsmodel->get_by_level_limit($level),
		   'documents' => $this->documentsmodel->get_by_zonal_limit($zone_id),
       );
	  }
	  
	   if($level==2)//regional
	  {
		  $document_level=3;
		  $region_id = $this->erkanaauth->getField('region_id');
		   $data = array(
           'rows' => $this->bulletinsmodel->get_by_level_limit($level),
		   'documents' => $this->documentsmodel->get_by_region_limit($region_id),
       );
	  }
	  
	   if($level==6)//district
	  {
		  $document_level=6;
		  $district_id = $this->erkanaauth->getField('district_id');
		   $data = array(
           'rows' => $this->bulletinsmodel->get_by_level_limit($level),
		   'documents' => $this->documentsmodel->get_by_district_limit($district_id),
       );
	  }
	  
	   if($level==3)//HF
	  {
		  $document_level=4;
		   $data = array(
           'rows' => $this->bulletinsmodel->get_by_level_limit($level),
		   'documents' => $this->documentsmodel->get_by_level_limit($document_level),
       );
	  }
	  
	   if($level==4)//national
	  {
		  $document_level=1;
		   $data = array(
           'rows' => $this->bulletinsmodel->get_by_level_limit($level),
		   'documents' => $this->documentsmodel->get_by_level_limit($document_level),
       );
	  }
	  
	  if($level==5)//Stakeholder
	  {
		  $document_level=1;
		   $data = array(
           'rows' => $this->bulletinsmodel->get_by_level_limit(4),
		   'documents' => $this->documentsmodel->get_by_level_limit($document_level),
       );
	  }
	  
	  $data['primaryrows'] = $this->bulletinsmodel->get_by_level_limit(4);
	  $data['primarydocs'] = $this->bulletinsmodel->get_by_level_limit(1);
	  
	  
	  $current_week = date('W');
	  $current_year = date('Y');
	 
	$week_array = $this->getStartAndEndDate($current_week,$current_year);
	
	$start_date = $week_array['week_start'];
		
	$end_date = date('Y-m-d', strtotime('-10 weeks', strtotime($start_date)));
	



	  
	  
	  
	  $data['level'] = $level;
	   
	   $data['title'] = $title;
		
   	$this->load->view('home/home_view', $data); 

 }
 
 function getStartAndEndDate($week, $year) {
  $dto = new DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+6 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
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