<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Manageusers extends CI_Controller {

 // num of records per page

 private $limit = 1000;



 function __construct()

 {

   parent::__construct();

   

  // load library

	 $this->load->library(array('table','form_validation','erkanaauth'));

	// load helper

	$this->load->helper('url');

	$this->load->library('Email');

	// load model

	$this->load->model('user','',TRUE); 

	$this->load->model('role','',TRUE); 

	$this->load->model('common','',TRUE);

	$this->load->model('memberphoto','',TRUE);

   

 }

 



 function index($offset = 0)

 {

   

      //ensure that the user is logged in

      

	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	  

	  if (getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }

	  

	  // offset

		$uri_segment = 3;

		$offset = $this->uri->segment($uri_segment);



		// load data

		$users = $this->user->get_paged_list($this->limit, $offset)->result();



		// generate pagination

		$this->load->library('pagination');

		$config['base_url'] = site_url('manageusers/index/');

 		$config['total_rows'] = $this->user->count_all();

 		$config['per_page'] = $this->limit;

		$config['uri_segment'] = $uri_segment;

		$config['next_link'] = 'Next';

		$config['prev_link'] = 'Previous';

		$config['prev_tag_open'] = '<span class="disabled_tnt_pagination">';

		$config['prev_tag_close'] = '</span>';

		$config['cur_tag_open'] = '<span class="active_tnt_link">';

		$config['cur_tag_close'] = '</span>';

		

		

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		

		$template = $this->common->loadtemplate();


		// generate table data

		$this->load->library('table');

		$this->table->set_empty("&nbsp;");

		$this->table->set_heading('First Name', 'Last Name', 'Email', 'Group','Username', 'Actions');

		$i = 0 + $offset;

		foreach ($users as $user){
			
			if($user->role_id==1)
			{
				$role = 'Administrator';
			}
			
			if($user->role_id==2)
			{
				$role = 'Business Partner';
			}
			
			if($user->role_id==3)
			{
				$role = 'Stockist';
			}
			
			if($user->role_id==4)
			{
				$role = 'Sales Person';
			}

			$this->table->add_row($user->fname, $user->lname, $user->email, $role, $user->username,

				//anchor('manageusers/view/'.$user->id,'view',array('class'=>'edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary', 'role'=>'button')).' '.

				anchor('manageusers/update/'.$user->id,'Edit',array('class'=>'update')).' '.

				anchor('manageusers/delete/'.$user->id,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure want to delete this user?')"))

			);

		}

		$this->table->set_template($template);

		$data['table'] = $this->table->generate();

		

    

	 	$this->load->view('users/index_view', $data);

	

	

   

 }

 function stockists($offset = 0)

 {

   

      //ensure that the user is logged in

      

	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	  

	  if (getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }

	

	  // offset

		$uri_segment = 3;

		$offset = $this->uri->segment($uri_segment);



		// load data

		$users = $this->user->get_paged_role($this->limit, $offset, 3)->result();



		// generate pagination

		$this->load->library('pagination');

		$config['base_url'] = site_url('manageusers/index/');

 		$config['total_rows'] = $this->user->count_all();

 		$config['per_page'] = $this->limit;

		$config['uri_segment'] = $uri_segment;

		$config['next_link'] = 'Next';

		$config['prev_link'] = 'Previous';

		$config['prev_tag_open'] = '<span class="disabled_tnt_pagination">';

		$config['prev_tag_close'] = '</span>';

		$config['cur_tag_open'] = '<span class="active_tnt_link">';

		$config['cur_tag_close'] = '</span>';

		

		

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		

		$template = $this->common->loadtemplate();

		

			

		

		// generate table data

		$this->load->library('table');

		$this->table->set_empty("&nbsp;");

		$this->table->set_heading('First Name', 'Last Name', 'Email', 'Username', 'Actions');

		$i = 0 + $offset;

		foreach ($users as $user){

			$this->table->add_row($user->fname, $user->lname, $user->email, $user->username,

				//anchor('manageusers/view/'.$user->id,'view',array('class'=>'edit_button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary', 'role'=>'button')).' '.

				anchor('manageusers/update/'.$user->id,'Edit',array('class'=>'update')).' '.

				anchor('manageusers/delete/'.$user->id,'Delete',array('class'=>'delete','onclick'=>"return confirm('Are you sure want to delete this user?')"))

			);

		}

		$this->table->set_template($template);

		$data['table'] = $this->table->generate();

		

    

	 	$this->load->view('users/index_view', $data);

	

	

   

 }


function register(){

 

   


		// set common properties

		$data['title'] = 'Add new user';

		$data['message'] = '';

		$data['action'] = site_url('manageusers/addUser');

		$data['link_back'] = anchor('manageusers/index/','Back to list',array('class'=>'back'));

		

		//get the roles

		$data['roles']= $this->role->get_list();
		
		$data['users']= $this->user->get_list();

		// load view

		 $filename = get_filenames('./application/views/common/');

		

			$directory = './application/views/common';

			$filepath = set_realpath($directory);

			$link_to_file = $filepath.''.$filename[0];

			

			$data['include']= $link_to_file;

			

		$this->load->view('users/registeruser', $data);

		

	

}
 

 function add(){

 

   if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	}

	

	if (getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }

		



		// set common properties

		$data['title'] = 'Add new user';

		$data['message'] = '';

		$data['action'] = site_url('manageusers/addUser');

		$data['link_back'] = anchor('manageusers/index/','Back to list',array('class'=>'back'));

		

		//get the roles

		$data['roles']= $this->role->get_list();
		
		$data['users']= $this->user->get_list();

		// load view

		 $filename = get_filenames('./application/views/common/');

		

			$directory = './application/views/common';

			$filepath = set_realpath($directory);

			$link_to_file = $filepath.''.$filename[0];

			

			$data['include']= $link_to_file;

			

		$this->load->view('users/userAdd', $data);

		

	

}



function addUser(){



    if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	}

	 if (getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }

	  

	  

		// set common properties

		$data['title'] = 'Add new User';

		$data['action'] = site_url('manageusers/addUser');

		$data['link_back'] = anchor('manageusers/index/','Back to list of users',array('class'=>'back'));



		

			// set validation properties

			$this->_set_add_rules();

	

				// run validation

				if ($this->form_validation->run() == FALSE){

				

				//get the roles

				$data['roles']= $this->role->get_list();
				$data['users']= $this->user->get_list();

					

					// load view

					$this->load->view('users/userAdd', $data);

				}else{

					// save data

					$user = array('fname' => $this->input->post('fname'),

									'lname' => $this->input->post('lname'),

									'email' => $this->input->post('email'),
									'countrycode' => $this->input->post('countrycode'),
									'mobile' => $this->input->post('mobile'),
									'telnumber' => $this->input->post('telnumber'),
									'idno' => $this->input->post('idno'),
									'authorizationletter' => $this->input->post('authorizationletter'),
									'country' => $this->input->post('country'),
									'town' => $this->input->post('town'),
									'postaladdress' => $this->input->post('postaladdress'),
									'physicaladdress' => $this->input->post('physicaladdress'),
									'salesoutlet' => $this->input->post('salesoutlet'),
									'refferedby' => $this->input->post('refferedby'),
									'referrername' => $this->input->post('referrername'),

									'username' => $this->input->post('username'),

									'password' => md5($this->input->post('password')),

									'role_id' => $this->input->post('role_id'),

									'active' => $this->input->post('active')									

									);

									

					$id = $this->user->save($user);

		

					// set form input name="id"

					$this->form_validation->id = $id;
					
					$file_element_name = 'userfile';
			
					$config['upload_path'] = './upload';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
					
					//(‘iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|gif|jpg|jpeg|png’)
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name))
		     {
		         $error = $this->upload->display_errors('', '');
				 $this->data['error'] = '<div class="form_error">'.$error.'</div>';
				 
				 
				 
		     } 
			else
			{
			 
				$filedata = $this->upload->data();                           
	            $data = array(
	                    'imagename' => $filedata['file_name'],
						'imagesize' => $filedata['file_type'],
						'imagetype' => $filedata['file_size'],
						'imagelink' => $filedata['full_path'],
						'imgext' => $filedata['file_ext'],
						'user_id' => $id
	            );
				
				$bookid = $this->memberphoto->save($data);
			}

								

					redirect('manageusers','refresh');

		}

}



function registeruser(){



		// set common properties

		$data['title'] = 'Add new User';

		$data['action'] = site_url('manageusers/addUser');

		$data['link_back'] = anchor('manageusers/index/','Back to list of users',array('class'=>'back'));


			// set validation properties

			//$this->_set_add_rules();
	
		
		 $this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');

	   	$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean');

	   $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|matches[comemail]');
	   
	
	    $this->form_validation->set_rules('comemail', 'Confirm Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('countrycode', 'Country Code', 'trim|required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'trim|required');
		
		   $this->form_validation->set_rules('idno', 'Id Number', 'trim|required');
		   
		    //$this->form_validation->set_rules('userfile', 'Photo', 'trim|required');
		   
		   $this->form_validation->set_rules('physicaladdress', 'Physical Address', 'trim|required');

	   $this->form_validation->set_rules('username', 'Username','trim|required|min_length[6]|max_length[12]|xss_clean');

	   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		

				// run validation

				if ($this->form_validation->run() == FALSE){

				

				//get the roles

				$data['roles']= $this->role->get_list();
				$data['users']= $this->user->get_list();

					

					// load view

					$this->load->view('users/registeruser', $data);

				}else{

					// save data
					
					$referredby = $this->input->post('refferedby');
					
					if($referredby==1)
					{
						$referrername = $this->input->post('referrername');
						$refferedby = 0;
						$bpmobile = '';
						$bppassport= '';
					}
					
					if($referredby==4)
					{
						$referrername = 'Stockist';
						$refferedby = 0;
						$bpmobile = '';
						$bppassport= '';
					}
					
					if($referredby==3)
					{
						$referrername = 'One Drop Perfume Media';
						$refferedby = 0;
						$bpmobile = '';
						$bppassport= '';
					}
					
					if($referredby==2)
					{
						$idno = $this->input->post('refidno');
						$refuser = $this->user->get_by_pass_or_id($idno)->row();
						$bpmobile = $this->input->post('refmobnumber');
						$bppassport= $this->input->post('refidno');
						
						if(empty($refuser->id))
						{
							$referrername = '';
							$refferedby = 0;
						}
						else {
							$referrername = $refuser->fname.''.$refuser->lname;
							$refferedby = $refuser->id;
						}
						
						
					}

					$user = array('fname' => $this->input->post('fname'),

									'lname' => $this->input->post('lname'),

									'email' => $this->input->post('email'),
									'countrycode' => $this->input->post('countrycode'),
									'mobile' => $this->input->post('mobile'),
									'telnumber' => $this->input->post('telnumber'),
									'idno' => $this->input->post('idno'),
									'authorizationletter' => $this->input->post('authorizationletter'),
									'country' => $this->input->post('country'),
									'town' => $this->input->post('town'),
									'postaladdress' => $this->input->post('postaladdress'),
									'physicaladdress' => $this->input->post('physicaladdress'),
									'salesoutlet' => $this->input->post('salesoutlet'),
									'refferedby' => $refferedby,
									'referrername' => $referrername,
									'bpmobile' => $bpmobile,
									'bppassport' => $bppassport,
									'username' => $this->input->post('username'),
									'password' => md5($this->input->post('password')),
									'role_id' => $this->input->post('role_id'),
									'active' => 0									

									);

									

					$id = $this->user->save($user);
					
				
					
					//give the user a commission
					
					$commuser = $this->user->get_by_id($id)->row();
					
					
					
					if($commuser->refferedby !=0)
					{
						$theuser = $this->user->get_by_id($referredby)->row();
						
						$commission = 500;
					   	$comdata = array(
			               'comission' => $commission,
			               'user_id' => $refuser->id,
			               'commissionfor' => 2,
			               'datereceived' => date('Y-m-d'),
			               'paid' => 0,
			           );
					   
					    $this->db->insert('commissions', $comdata);
					}

		

					// set form input name="id"

					$this->form_validation->id = $id;
					
					$file_element_name = 'userfile';
			
					$config['upload_path'] = './upload';
					$config['allowed_types'] = 'gif|jpg|jpeg|png';
									
					//(‘iso|dmg|zip|rar|doc|docx|xls|xlsx|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|gif|jpg|jpeg|png’)
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name))
		     {
		         $error = $this->upload->display_errors('', '');
				 $this->data['error'] = '<div class="form_error">'.$error.'</div>';
				 
								 
				 
				 
		     } 
			else
			{
			 
				$filedata = $this->upload->data();                           
	            $data = array(
	                    'imagename' => $filedata['file_name'],
						'imagesize' => $filedata['file_type'],
						'imagetype' => $filedata['file_size'],
						'imagelink' => $filedata['full_path'],
						'imgext' => $filedata['file_ext'],
						'user_id' => $id
	            );
				
				$bookid = $this->memberphoto->save($data);
			
				$imagename = $filedata['file_name'];
				
				$rconfig['image_library'] = 'gd2';
				$rconfig['source_image'] = './upload/'.$imagename;
				//$rconfig['create_thumb'] = TRUE;
				$rconfig['maintain_ratio'] = TRUE;
				$rconfig['width'] = 150;
				$rconfig['height'] = 150;
				
				$this->load->library('image_lib', $rconfig);
				
				$this->image_lib->resize();
				
			}
			
			
				$this->email->clear();
				
				$mconfig['protocol'] = 'mail';
				$mconfig['charset'] = 'iso-8859-1';
				$mconfig['wordwrap'] = TRUE;
				$mconfig['mailtype'] = 'html';
				$mconfig['newline'] = '\r\n';
							
				$this->email->initialize($mconfig);
				
				$registered = $this->user->get_by_id($id)->row();
				
				$fullname = $registered->fname.' '.$registered->lname;
				
				$this->email->from($registered->email, $fullname);
				
				$this->email->to('info@onedropperfumes.co.ke');
				
				$this->email->subject('New user registered - One Drop Perfume');
				
				$message = 'Dear Administrator,<br><br>
				
				I have registered on the One Drop Perfumes Website.
				
				My unsigned letter of Agreement can be found on this link:<br>
				
				http://www.dcgprojects.com/2013/ONEDROPPERFUMES/index.php/agreement/pdf/'.$id.'.
				
				';
				
				$this->email->message($message);
												
				$this->email->send();
				
				//send to registered user
				
				$this->email->clear();
				
				$mailconfig['protocol'] = 'mail';
				$mailconfig['charset'] = 'iso-8859-1';
				$mailconfig['wordwrap'] = TRUE;
				$mailconfig['mailtype'] = 'html';
				$mailconfig['newline'] = '\r\n';
							
				$this->email->initialize($mailconfig);
				
				$this->email->from('info@onedropperfumes.co.ke');
				$this->email->to($registered->email, $fullname);
				
				$this->email->subject('Registration - One Drop Perfume');
				
				$usermessage = 'Dear '.$fullname.',<br><br>
				
				Your registration details heve been captured on the onedrop database. You will be contacted with a onedrop representative on the progress of your registration.<br><br>
				
				Onedrop team.
				
				';
				
				$this->email->message($usermessage);
												
				$this->email->send();

					
				redirect(base_url().'index.php/manageusers/letteragreement/'.$id);

		}

}


function letteragreement($id)
{
	$user = $this->user->get_by_id($id)->row();
	
	$data['user'] = $user;
	
	$this->load->view('users/letteragreement', $data);
}


	function view($id){

		

		if (!$this->erkanaauth->try_session_login()) {

    		redirect('login');

  		}

		if (getRole() != 'Admin')

		 {

			redirect('home', 'refresh');

		 }

		 

		if(empty($id) || !is_numeric($id))

		{

			redirect('manageusers', 'refresh');

		}

			// set common properties

			$data['title'] = 'User Details';

			$data['link_back'] = anchor('manageusers/index/','Back to list of users',array('class'=>'back'));

	

			// get person details

			$data['user'] = $this->user->get_by_id($id)->row();

	

	 

			

			$this->load->view('users/userView', $data);

			 

		

	}



	function update($id){

		// set validation properties

		

		if (!$this->erkanaauth->try_session_login()) {

    		redirect('login');

  		}

		if (getRole() != 'Admin')

	    {

			redirect('home', 'refresh');

	    }

		

		if(empty($id) || !is_numeric($id))

		{

			redirect('manageusers', 'refresh');

		}

			

				// prefill form values

				$user = $this->user->get_by_id($id)->row();

				$data['id'] = $id;

				$data['fname'] = $user->fname;

				$data['lname'] = $user->lname;

				$data['email'] = $user->email;
				
				$data['countrycode'] = $user->countrycode;
				$data['mobile'] = $user->mobile;
				$data['telnumber'] = $user->telnumber;
				$data['idno'] = $user->idno;
				$data['authorizationletter'] = $user->authorizationletter;
				$data['country'] = $user->country;
				$data['town'] = $user->town;
				$data['postaladdress'] = $user->postaladdress;
				$data['physicaladdress'] = $user->physicaladdress;
				$data['salesoutlet'] = $user->salesoutlet;
				$data['refferedby'] = $user->refferedby;
				$data['referrername'] = $user->referrername;
				$data['bpmobile'] = $user->bpmobile;
				$data['bppassport'] = $user->bppassport;

				$data['username'] = $user->username;

				$data['password'] = $user->password;

				$data['role_id'] = $user->role_id;

				$data['active'] = $user->active;
				
				$data['memberphoto'] = $this->memberphoto->get_by_user_id($id)->row();

												

				// set common properties

				$data['title'] = 'Update person';

				$data['message'] = '';

				$data['action'] = site_url('manageusers/updateUser');

				$data['link_back'] = anchor('manageusers/index/','Back to list of users',array('class'=>'back'));

				

				//get the roles

			$data['roles']= $this->role->get_list();

						

			

			

				// load view

				$this->load->view('users/userEdit', $data);

			

	}



	function updateUser(){

		

		if (!$this->erkanaauth->try_session_login()) {

    		redirect('login');

  		}

		if (getRole() != 'Admin')

		{

			redirect('home', 'refresh');

		 }

		// set common properties

		$data['title'] = 'Update user';

		$data['action'] = site_url('manageusers/updateUser');

		$data['link_back'] = anchor('manageusers/index/','Back to list of persons',array('class'=>'back'));



		// set validation properties

		

		$this->_set_rules();

		$id = $this->input->post('id');

		// run validation

		if ($this->form_validation->run() == FALSE){

			//$data['message'] = '';

				

			// prefill form values

			$user = $this->user->get_by_id($id)->row();

			$data['id'] = $id;

			$data['fname'] = $user->fname;

			$data['lname'] = $user->lname;

			$data['email'] = $user->email;
			
			$data['countrycode'] = $user->countrycode;
			$data['mobile'] = $user->mobile;
			$data['telnumber'] = $user->telnumber;
			$data['idno'] = $user->idno;
			$data['authorizationletter'] = $user->authorizationletter;
			$data['country'] = $user->country;
			$data['town'] = $user->town;
			$data['postaladdress'] = $user->postaladdress;
			$data['physicaladdress'] = $user->physicaladdress;
			$data['salesoutlet'] = $user->salesoutlet;
			$data['refferedby'] = $user->refferedby;
			$data['referrername'] = $user->referrername;


			$data['username'] = $user->username;

			$data['password'] = $user->password;

			$data['role_id'] = $user->role_id;

			$data['active'] = $user->active;

						

			//get the roles

			$data['roles']= $this->role->get_list();

					

			// set common properties

			$data['title'] = 'Update person';

			$data['message'] = '';

			$data['action'] = site_url('manageusers/updateUser');

			$data['link_back'] = anchor('manageusers/index/','Back to list of users',array('class'=>'back'));

			

			$this->load->view('users/userEdit', $data);

		}else{

			// save data

			

			

			$pass = $this->input->post('password');

			

			if(empty($pass))

			{

				$password = $this->input->post('pword');

			}

			else

			{

				$password = md5($this->input->post('password'));

			}
			
			
			$prevstate = $this->input->post('prevstate');
			
			if($prevstate==0)
			{
				
				$this->email->clear();
				
				$config['protocol'] = 'mail';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = TRUE;
				$config['mailtype'] = 'html';
				$config['newline'] = '\r\n';
							
				$this->email->initialize($config);
				
				$fname = $this->input->post('fname');
				$lname = $this->input->post('lname');
				$email = $this->input->post('email');
				
				$fullname = $fname.' '.$lname;
				
				$this->email->from($email, $fullname);
				
				$this->email->to('info@onedropperfumes.co.ke');
				
				$this->email->subject('Your account at One Drop Perfumes has been activated');
				
				$message = 'Dear '.$fullname.',<br><br>
				
				thank you for registering as Business Partner, you are now a full member and you can login to your Membership Account for One Drop Perfume and view your earned commission reports by clicking on this link: 
				http://www.onedropperfumes.co.ke/.Please use the login details you provide us with below access your account.
				
				';
				
				$this->email->message($message);
												
				$this->email->send();
			}

										
			$user = array('fname' => $this->input->post('fname'),
									'lname' => $this->input->post('lname'),
									'email' => $this->input->post('email'),
									'countrycode' => $this->input->post('countrycode'),
									'mobile' => $this->input->post('mobile'),
									'telnumber' => $this->input->post('telnumber'),
									'idno' => $this->input->post('idno'),
									'authorizationletter' => $this->input->post('authorizationletter'),
									'country' => $this->input->post('country'),
									'town' => $this->input->post('town'),
									'postaladdress' => $this->input->post('postaladdress'),
									'physicaladdress' => $this->input->post('physicaladdress'),
									'salesoutlet' => $this->input->post('salesoutlet'),
									'username' => $this->input->post('username'),
									'password' => $password,
									'role_id' => $this->input->post('role_id'),
									'active' => $this->input->post('active')
									);
			

			$this->user->update($id,$user);
			
			    

			// set user message

			$data['message'] = '<div class="success">update user success</div>';

			// load view

			redirect('manageusers', 'refresh');

			

		}


	}

	function profile($id){

		// set validation properties

		

		if (!$this->erkanaauth->try_session_login()) {

    		redirect('login');

  		}

		
		

		if(empty($id) || !is_numeric($id))

		{

			redirect('home', 'refresh');

		}

			

				// prefill form values

				$user = $this->user->get_by_id($id)->row();

				$data['id'] = $id;

				$data['fname'] = $user->fname;

				$data['lname'] = $user->lname;

				$data['email'] = $user->email;
				
				$data['countrycode'] = $user->countrycode;
				$data['mobile'] = $user->mobile;
				$data['telnumber'] = $user->telnumber;
				$data['idno'] = $user->idno;
				$data['authorizationletter'] = $user->authorizationletter;
				$data['country'] = $user->country;
				$data['town'] = $user->town;
				$data['postaladdress'] = $user->postaladdress;
				$data['physicaladdress'] = $user->physicaladdress;
				$data['salesoutlet'] = $user->salesoutlet;
				$data['refferedby'] = $user->refferedby;
				$data['referrername'] = $user->referrername;

				$data['username'] = $user->username;

				$data['password'] = $user->password;

				$data['role_id'] = $user->role_id;

				$data['active'] = $user->active;

												

				// set common properties

				$data['title'] = 'Update person';

				$data['message'] = '';

				$data['action'] = site_url('manageusers/updateProfile');

				$data['link_back'] = anchor('manageusers/index/','Back to list of users',array('class'=>'back'));

				

				//get the roles

			$data['roles']= $this->role->get_list();

						
				// load view

				$this->load->view('users/profileEdit', $data);

			

	}

	
	function updateProfile(){

		

		if (!$this->erkanaauth->try_session_login()) {

    		redirect('login');

  		}

		if (getRole() != 'Admin')

		{

			redirect('home', 'refresh');

		 }

		// set common properties

		$data['title'] = 'Update user';

		$data['action'] = site_url('manageusers/updateUser');

		$data['link_back'] = anchor('manageusers/index/','Back to list of persons',array('class'=>'back'));



		// set validation properties

		

		$this->_set_rules();

		$id = $this->input->post('id');

		// run validation

		if ($this->form_validation->run() == FALSE){

			//$data['message'] = '';

				

			// prefill form values

			$user = $this->user->get_by_id($id)->row();

			$data['id'] = $id;

			$data['fname'] = $user->fname;

			$data['lname'] = $user->lname;

			$data['email'] = $user->email;
			
			$data['countrycode'] = $user->countrycode;
			$data['mobile'] = $user->mobile;
			$data['telnumber'] = $user->telnumber;
			$data['idno'] = $user->idno;
			$data['authorizationletter'] = $user->authorizationletter;
			$data['country'] = $user->country;
			$data['town'] = $user->town;
			$data['postaladdress'] = $user->postaladdress;
			$data['physicaladdress'] = $user->physicaladdress;
			$data['salesoutlet'] = $user->salesoutlet;
			$data['refferedby'] = $user->refferedby;
			$data['referrername'] = $user->referrername;


			$data['username'] = $user->username;

			$data['password'] = $user->password;

			$data['role_id'] = $user->role_id;

			$data['active'] = $user->active;

						

			//get the roles

			$data['roles']= $this->role->get_list();

					

			// set common properties

			$data['title'] = 'Update person';

			$data['message'] = '';

			$data['action'] = site_url('manageusers/updateUser');

			$data['link_back'] = anchor('manageusers/index/','Back to list of users',array('class'=>'back'));

			

			$this->load->view('users/profileEdit', $data);

		}else{

			// save data

			
			$pass = $this->input->post('password');

			

			if(empty($pass))

			{

				$password = $this->input->post('pword');

			}

			else

			{

				$password = md5($this->input->post('password'));

			}

										
			$user = array('email' => $this->input->post('email'),
									'telnumber' => $this->input->post('telnumber'),
									'authorizationletter' => $this->input->post('authorizationletter'),
									'country' => $this->input->post('country'),
									'town' => $this->input->post('town'),
									'postaladdress' => $this->input->post('postaladdress'),
									'physicaladdress' => $this->input->post('physicaladdress'),
									'salesoutlet' => $this->input->post('salesoutlet'),
									

									'username' => $this->input->post('username'),

									'password' => $password,

									'role_id' => $this->input->post('role_id'),

									'active' => $this->input->post('active')									

									);
			

			$this->user->update($id,$user);



			// set user message

			$data['message'] = '<div class="success">update user success</div>';

			// load view

			redirect('manageusers/profile/'.$id);

			

		}


	}


	function delete($id){

		

		if (!$this->erkanaauth->try_session_login()) {

    		redirect('login');

  		}

		if (getRole() != 'Admin')

	    {

			redirect('home', 'refresh');

	    }

		

		if(empty($id) || !is_numeric($id))

		{

			redirect('manageusers', 'refresh');

		}

		// delete person

		$this->user->delete($id);



		// redirect to person list page

		redirect('manageusers/index/','refresh');

	}



	



	// validation rules

	function _set_rules(){

				

		//$this->form_validation->set_rules($rules);

		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');

	   $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean');

	   $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');

	   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');

	   



		$this->form_validation->set_message('required', '* required');

		$this->form_validation->set_message('isset', '* required');

		$this->form_validation->set_error_delimiters('<p class="error">', '</p>');

	}

	

	function _set_add_rules(){

				

	   $this->form_validation->set_rules('fname', 'First Name', 'trim|required|xss_clean');

	   $this->form_validation->set_rules('lname', 'Last Name', 'trim|required|xss_clean');

	   $this->form_validation->set_rules('email', 'Email', 'trim|required|matches[comemail]');

	   $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');

	   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

	   



		$this->form_validation->set_message('required', '* required');

		$this->form_validation->set_message('isset', '* required');

		$this->form_validation->set_error_delimiters('<div class="alert info">', '</div>');

	}





	// date_validation callback

	function valid_date($str)

	{

		if(!ereg("^(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-([0-9]{4})$", $str))

		{

			$this->form_validation->set_message('valid_date', 'date format is not valid. dd-mm-yyyy');

			return false;

		}

		else

		{

			return true;

		}

	}



}



?>