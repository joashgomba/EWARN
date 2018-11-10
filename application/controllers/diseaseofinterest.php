<?php

class Diseaseofinterest extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('diseaseofinterestmodel');
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
	   $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	   $limit = count($diseasecount);
	   
	   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	   
       $data = array(
           'diseases' => $diseases,
		   'country_id' => $country_id,
       );
	   
       $this->load->view('diseaseofinterest/configure', $data);
   }

    public function edit_validate()
   {
       if (!$this->erkanaauth->try_session_login()) {
       	redirect('login','refresh');
       }
	   
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')
	  {
		redirect('home', 'refresh');
	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	  $diseasecount = $this->diseasesmodel->get_country_list($country_id);
	  $limit = count($diseasecount);
	  
	  $delete = $this->diseaseofinterestmodel->delete_by_country($country_id);
	   
	  $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
	  
	  foreach ($diseases->result() as $disease):
	  	$field = 'disease_'.$disease->id;
		
		if(!isset($_POST[''.$field.'']))
		{
			$prioritydisease = '';
		}
		else
		{
		
			$prioritydisease = trim(addslashes(htmlspecialchars(rawurldecode($_POST[''.$field.'']))));
		}
		
		if(empty($prioritydisease))
		{
			
		}
		else
		{
			$data = array(
               'country_id' => $country_id,
               'disease_id' => $prioritydisease,
           );
           $this->db->insert('diseaseofinterest', $data);
		}
	  
	    endforeach;	   
	             
        redirect('diseaseofinterest','refresh');
      
   }

  
}
