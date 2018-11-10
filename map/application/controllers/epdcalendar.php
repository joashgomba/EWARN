<?php

class Epdcalendar extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('epdcalendarmodel');
   }

   public function index()
   {
       
	      //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	   $data = array(
           'rows' => $this->db->get('epdcalendar'),
       );
       $this->load->view('epdcalendar/index', $data);
   }

   public function add()
   {
	      //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	   
	   $data = array();
	   
	   $data['error'] = '';
       $this->load->view('epdcalendar/add',$data);
   }

   public function add_validate()
   {
          //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	  $epdyear = $this->input->post('epdyear');	  
	  $reportingperiod = $this->epdcalendarmodel->get_by_reporting_year($epdyear)->row();
	  
	  if(!empty($reportingperiod))
	  {
		  $data = array();
	   
	   	  $data['error'] = 'The reporting year you selected i.e '.$epdyear.', already has an Epi calendar added on the database.';
		  $this->load->view('epdcalendar/add',$data);
	  }
	  else
	  {
	  
	 
		  if(!empty($_POST['week_no']))
		  {
			  foreach ($_POST['week_no'] as $rrow=>$rid)
			  {
				
				$week_no = $rid;
				$from = $_POST['from'][$rrow];
				$to = $_POST['to'][$rrow];
							
				$data = array(
					'epdyear' => $epdyear,
					'week_no' => $week_no,
					'from' => $from,
					'to' => $to,
				);
				
				$this->db->insert('epdcalendar', $data);
				
			  }
		  }
		  
		  redirect('epdcalendar/add', 'refresh');
	  }
	   /**
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('epdyear', 'Epdyear', 'trim|required');
       $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
       $this->form_validation->set_rules('from', 'From', 'trim|required');
       $this->form_validation->set_rules('to', 'To', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->add();
       } else {
           $data = array(
               'epdyear' => $this->input->post('epdyear'),
               'week_no' => $this->input->post('week_no'),
               'from' => $this->input->post('from'),
               'to' => $this->input->post('to'),
           );
           $this->db->insert('epdcalendar', $data);
           redirect('epdcalendar', 'refresh');
       }
	   
	   **/
   }
   
   public function view()
   {
	   if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	  
	  $data = array();
	  $this->load->view('epdcalendar/view', $data);
   }
   
   function findcalendars()
   {
	   $reporting_year = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
	   if(empty($reporting_year))
	   {
		   echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">Please select the year.</div></td></tr>
                              </tbody>
                            </table>';
	   }
	   else
	   {
		   $calendarlists = $this->epdcalendarmodel->get_list_by_year($reporting_year);
		   
		   if(empty($calendarlists))
		   {
			    echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">There is no EPI calendar for the year '.$reporting_year.'</div></td></tr>
                              </tbody>
                            </table>';
		   }
		   else
		   {
			   	$table = '<table id="listtable">';
				$table .= '<thead>';
				$table .='<tr><th>Week No.</th><th>From</th><th>To</th></tr>';
				$table .= '</thead>';
				$table .= '<tbody>';
				
				$class = 'class="alt"';
				
				foreach($calendarlists as $key=> $calendarlist)
				{
					if($class == 'class="alt"')
					{
						$class = '';
					}
					else
					{
						$class = 'class="alt"';
					}
					
					$table .='<tr '.$class.'><td>'.$calendarlist['week_no'].'</td><td>'.date("d F Y", strtotime($calendarlist['from'])).'</td><td>'.date("d F Y", strtotime($calendarlist['to'])).'</td></tr>';
				}
				$table .= '</tbody>';
				$table .= '</table>';
				
				echo $table;
		   }
	   }
   }

   public function edit($id)
   {
          //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	   
	   $row = $this->db->get_where('epdcalendar', array('id' => $id))->row();
       $data = array(
           'row' => $row,
       );
       $this->load->view('epdcalendar/edit', $data);
   }

   public function edit_validate($id)
   {
          //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin')

	  {

		redirect('home', 'refresh');

	  }
	   
	   $this->load->library('form_validation');
       $this->form_validation->set_rules('epdyear', 'Epdyear', 'trim|required');
       $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
       $this->form_validation->set_rules('from', 'From', 'trim|required');
       $this->form_validation->set_rules('to', 'To', 'trim|required');
       if ($this->form_validation->run() == false) {
           $this->edit($id);
       } else {
           $data = array(
               'epdyear' => $this->input->post('epdyear'),
               'week_no' => $this->input->post('week_no'),
               'from' => $this->input->post('from'),
               'to' => $this->input->post('to'),
           );
           $this->db->where('id', $id);
           $this->db->update('epdcalendar', $data);
           redirect('epdcalendar', 'refresh');
       }
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
	   
	   $this->db->delete('epdcalendar', array('id' => $id));
       redirect('epdcalendar', 'refresh');
   }

}
