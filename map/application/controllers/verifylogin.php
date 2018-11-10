<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->library('erkanaauth');
   $this->load->database();
 }

 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
   
  
   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
   $this->form_validation->set_error_delimiters('<div class="alert info">', '</div>');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('login/login_view');
   }
   else
   {
     //Go to private area
    redirect('home');
   }

 }

 function check_database($password)
 {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');

   $this->load->helper('security');
   $pass = do_hash($password,'md5');
	  
	  if ($this->erkanaauth->try_login(array('username'=>$username, 'password'=>$pass))) {
		return TRUE;
	  } else {
     $this->form_validation->set_message('check_database', 'Invalid username or password');
	 
     return false;
   }
 }
}
?>