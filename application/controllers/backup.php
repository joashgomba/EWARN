<?php

class Backup extends CI_Controller {

   function __construct()
   {
       parent::__construct();
   }

   public function index()
   {
       /**
	   if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
		**/
		
				// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup();
		
		// Load the file helper and write the file to your server
		//$this->load->helper('file');
		//write_file('./backups/mybackup.gz', $backup);
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download('mybackup-'.date('Y-m-d').'.gz', $backup); 
		
		
   }

    
}
