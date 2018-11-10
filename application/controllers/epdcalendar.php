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

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

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

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }
	  
	  $country_id = $this->erkanaauth->getField('country_id');
	   
	   $data = array();
	   
	   $data['countries'] = $this->countriesmodel->get_list();
	   
	   $data['error'] = '';
	   $data['country_id'] = $country_id;
       $this->load->view('epdcalendar/add',$data);
   }
   
   public function add_validate()
   {
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	 if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }
	  
	  
	  $this->load->library('form_validation');
      $this->form_validation->set_rules('baseline_date', 'Baseline date', 'trim|required');
	  $this->form_validation->set_rules('epdyear', 'Year', 'trim|required');
	  $this->form_validation->set_rules('country_id', 'Country', 'trim|required');
	  
	  if ($this->form_validation->run() == false) {
           $this->add();
       } else {
	  
		  $epdyear = $this->input->post('epdyear');	 
		  $country_id = $this->input->post('country_id'); 
		  $reportingperiod = $this->epdcalendarmodel->get_by_reporting_year_country($epdyear,$country_id)->row();
		  $country = $this->countriesmodel->get_by_id($country_id)->row();
		  $previous_year = ($epdyear-1);
		  $baseline_date = $this->input->post('baseline_date');
		   $check_date = DateTime::createFromFormat("Y-m-d", $baseline_date);
		   $baseline_year = $check_date->format("Y");
		  
		  if(!empty($reportingperiod))
		  {
			  $data = array();
		   
			  $data['error'] = 'The reporting year you selected i.e '.$epdyear.' for '.$country->country_name.', already has an Epi calendar added on the database.';
			  
			   $data['countries'] = $this->countriesmodel->get_list();
	   			$data['country_id'] = $country_id;
			  
			  $this->load->view('epdcalendar/add',$data);
		  }
		  else
		  {
			  //check if the country already has an epi calendar added. We want to ensure that years are entered sequentially
			  $countryepi = $this->epdcalendarmodel->get_by_country_id($country_id)->row();
			  
			  if(empty($countryepi))
			  {
			  	  //if no calendar has been added for the country then proceed to add the epi calendar
				  //make sure the date entered as the baseline is within the EPI year or the previous year before the selected EPI year for EPI calendars begining the previous year				  
				  if($baseline_year != $epdyear && $baseline_year !=$previous_year)
				  {
					  $data = array();
		   
					  $data['error'] = 'The baseline date you entered cannot fall withing the EPI calendar period.';
					  
					   $data['countries'] = $this->countriesmodel->get_list();
						$data['country_id'] = $country_id;
					  
					  $this->load->view('epdcalendar/add',$data);
				  }
				  else
				  {
				  
					  $date = new DateTime($baseline_date);
						$week_no = 0;
						for ($i=0; $i<52; $i++) {
						   $week_no++;
						   $from = $date->format('Y-m-d');
						   $to =  date('Y-m-d', strtotime('+6 day', strtotime($from)));
										   
						   //add records to the data base
						   $data = array(
							'epdyear' => $epdyear,
							'week_no' => $week_no,
							'from' => $from,
							'to' => $to,
							'country_id' => $country_id,
						 );
						
						 $this->db->insert('epdcalendar', $data);
						   
						   $date->modify('+1 week');
						}
						
						redirect('epdcalendar/view', 'refresh');
				  }
			  }
			  else
			  {
				  /***
				  If the country already has an epi calendar added, check if the year prior to the one selected already has an epi calendar.***/
				  $reporting_period = $this->epdcalendarmodel->get_by_reporting_year_country($previous_year,$country_id)->row();
				  if(empty($reporting_period))
				  {
					  //if the previous year epi calendar was not added prompt the user to add it first before proceeding to add the new epi calendar
					  $data = array();
				   
					  $data['error'] = 'Please add the EPI calendar for the year '.$previous_year.' before you add the EPI for the year '.$epdyear.' for '.$country->country_name.' to ensure that the EPI calendars are added sequentially.';
					  
					   $data['countries'] = $this->countriesmodel->get_list();
						$data['country_id'] = $country_id;
					  
					  $this->load->view('epdcalendar/add',$data);
				  }
				  else
				  {
					   //make sure the date entered as the baseline is within the EPI year or the previous year before the selected EPI year for EPI calendars begining the previous year				  
					  if($baseline_year != $epdyear && $baseline_year !=$previous_year)
					  {
						  $data = array();
			   
						  $data['error'] = 'The baseline date you entered cannot fall withing the EPI calendar period.';
						  
						   $data['countries'] = $this->countriesmodel->get_list();
						   $data['country_id'] = $country_id;
						  
						  $this->load->view('epdcalendar/add',$data);
					  }
					  else
					  {
						  $date = new DateTime($baseline_date);
							$week_no = 0;
							for ($i=0; $i<52; $i++) {
							   $week_no++;
							   $from = $date->format('Y-m-d');
							   $to =  date('Y-m-d', strtotime('+6 day', strtotime($from)));
											   
							   //add records to the data base
							   $data = array(
								'epdyear' => $epdyear,
								'week_no' => $week_no,
								'from' => $from,
								'to' => $to,
								'country_id' => $country_id,
							 );
							
							 $this->db->insert('epdcalendar', $data);
							   
							   $date->modify('+1 week');
							}
							
							redirect('epdcalendar/view', 'refresh');
					  }//end baseline year check
				  }//end check if previous year was entered
			  }
			  
		  }
	  }
	  
   }

   public function add_validate_old()
   {
          //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

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

	 /**
	  if(getRole() != 'SuperAdmin')
	  {

		redirect('home', 'refresh');

	  }
	  **/


	  $data = array();
	  $data['countries'] = $this->countriesmodel->get_list();
	  $this->load->view('epdcalendar/view', $data);
   }
   
   function findcalendars()
   {
	   $reporting_year = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
	   $country_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['country_id']))));
	   if(empty($reporting_year) || empty($country_id))
	   {
		   echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">Please enter all the required information.</div></td></tr>
                              </tbody>
                            </table>';
	   }
	   else
	   {
		   $calendarlists = $this->epdcalendarmodel->get_list_by_year_country($reporting_year,$country_id);
		   $country = $this->countriesmodel->get_by_id($country_id)->row();
		   
		   if(empty($calendarlists))
		   {
			    echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">There is no EPI calendar added for the year '.$reporting_year.' for '.$country->country_name.'</div></td></tr>
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

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

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

	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

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
	 
	  if(getRole() != 'SuperAdmin' && getRole() != 'Admin')

	  {

		redirect('home', 'refresh');

	  }
	   
	   $this->db->delete('epdcalendar', array('id' => $id));
       redirect('epdcalendar', 'refresh');
   }
   
   
   public function cleanrecords()
   {
	   //$calendarlists = $this->epdcalendarmodel->get_list_by_year_country($reporting_year,$country_id);
   }
   
   
   public function getdays()
   {
	   /**
	   $number_of_dates = 52;
	   $startDate = mktime(0, 0, 0, 1, 1, 2018); // May 2, 2012
	   $num = 0;
		for ($i = 0; $i < $number_of_dates; $i++) {
			$num++;
		   $date = strtotime('Wednesday +' . ($i * 1) . ' weeks', $startDate);
		   echo date('Y-m-d', $date). "<br>".PHP_EOL;
		}
		
		**/
		
		$date = new DateTime('2017-01-02');
		$week_no = 0;
		for ($i=0; $i<52; $i++) {
			$week_no++;
		   echo '('.$week_no.') '.$date->format('Y-m-d').''.PHP_EOL;
		   $first_date = $date->format('Y-m-d');
		   $next =  date('Y-m-d', strtotime('+6 day', strtotime($first_date)));
		   echo ' - '.$next.'<br/>';
		   
		   $date->modify('+1 week');
		}
   }

   public function getlist()
   {
       $reporting_year = 2018;
       $country_id = 1;
       $calendarlists = $this->epdcalendarmodel->get_list_by_year_country($reporting_year,$country_id);

       foreach ($calendarlists as $key=>$calendarlist):

           echo '('.$calendarlist['id'].')'.$calendarlist['epdyear'].' - '.$calendarlist['week_no'].'<br>';

       endforeach;
   }


   public function deleterecords($epicalendar_id){

       $sql = 'DELETE FROM forms WHERE epicalendar_id = '.$epicalendar_id.' AND zone_id !=4';
       $this->db->query($sql);

       $thesql = 'DELETE FROM formsdata WHERE epicalendar_id = '.$epicalendar_id.' AND zone_id !=4';
       $this->db->query($thesql);

       $mysql = 'DELETE FROM formalerts WHERE reportingperiod_id = '.$epicalendar_id.' AND zone_id !=4';
       $this->db->query($mysql);

       echo 'SUCCESS';
   }

}
