<?php

class Dataimport extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('formsmodel');
	   $this->load->library("Excel");
	   $this->text = "Loading...";
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
		
	   $data = array(
           'rows' => $this->db->get('alerts'),
       );
	   
	   $dataerror['error'] = '';
       $this->load->view('alerts/import', $data);
   }
   
   
   public function uploadold()
   {
	   $file_element_name = 'userfile';
		   $config['upload_path'] = './uploads/';
		   $config['allowed_types'] = 'xls|xlsx|csv';
		   $dataerror = array();
		$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name))
			{
				$error = $this->upload->display_errors('', '');
				$dataerror['error'] = '<div class="form_error">'.$error.'</div>';
					 
				$this->load->view('alerts/import',$dataerror);
			}
			else
			{
				$filedata = $this->upload->data();
				$filename = $filedata['file_name'];
			  
			    $excelfile = "./uploads/".$filename;
				
					//$obj = PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$objReader = PHPExcel_IOFactory::createReaderForFile($excelfile);
					
					 //set to read only
				  $objReader->setReadDataOnly(true);
				  
				  
				  $objPHPExcel = $objReader->load("".$excelfile."");
				  $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				  $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				  
				  for($i=4; $i<=4; $i++){
					  
					  $reported_by = $objWorksheet->getCellByColumnAndRow(7,$i)->getValue();
					  $healthfacility_name = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
					  $contact_number = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue();
					  $supporting_ngo = $objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
					  $region_cell = $objWorksheet->getCellByColumnAndRow(10,$i)->getValue();
					  $district_cell = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
					  $health_facility_type = 'MCH';
					  $hf_code = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
					  $email = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue();
					  
					  
					  
					  $date_of_entry = date('m/d/Y',PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(12, $i)->getFormattedValue()));
					   $date = DateTime::createFromFormat('m/d/Y',  $date_of_entry);
					   $reporting_date = $date->format('Y-m-d');
					   
					   $week_no = $objWorksheet->getCellByColumnAndRow(13,$i)->getValue();
					   
					   //for 2013
					   $reportingperiod = $this->epdcalendarmodel->get_by_year_week('2014',$week_no)->row();
					  
					  					  
					   /**
					  Central 1
					  Puntland 2
					  Southern 3
					  Somaliland 4
					  **/
					  
					  $theregion = $this->regionsmodel->get_by_name($region_cell)->row();
					  
					  if(empty($region_cell))
					  {
						   //nothing
					  }
					  else
					  {
					  
					  if(empty($theregion))
					  {
						  $regiondata = array(
							   'region' => $region_cell,
							   'regional_code' => 'N/A',
							   'zone_id' => 1,
						   );
						   $this->db->insert('regions', $regiondata);
						   
						   $region_id = $this->db->insert_id();
					  }
					  else
					  {
						  $region_id = $theregion->id;
						  
					  }
					  
					  $district = $this->districtsmodel->get_by_name($district_cell)->row();
						  
					  if(empty($district))
					  {
							  $districtdata = array(
								   'district' => $district_cell,
								   'district_code' => 'N/A',
								   'region_id' => $region_id,
							   );
							   $this->db->insert('districts', $districtdata);
							   $district_id = $this->db->insert_id();
					  }
					  else
					  {
							  $district_id = $district->id;
					  }
					  
					  $healthfacility = $this->healthfacilitiesmodel->get_by_name($healthfacility_name)->row();
					  
					  if(empty($healthfacility))
					  {
							  $hfdata = array(
								   'health_facility' => $healthfacility_name,
								   'hf_code' => $hf_code,
								   'district_id' => $district_id,
								   'organization' => $healthfacility_name,
								   'health_facility_type' => $health_facility_type,
								   'catchment_population' => '0',
								   'focal_person_name' => $reported_by,
								   'contact_number' => $contact_number,
								   'email' => $email,
								   'activated' => 1,
								   'otherval' => 'N/A',
							   );
							   $this->db->insert('healthfacilities', $hfdata);
							   $healthfacility_id = $this->db->insert_id();
					  }
					  else
					  {
							  $healthfacility_id = $healthfacility->id;
					  }
					  
					  $iliufive = 0;
					  $iliofive = 0;
					  $sariufive = 0;
					  $sariofive = 0;
					  $awdufive = $objWorksheet->getCellByColumnAndRow(17,$i)->getValue();
					  $awdofive = $objWorksheet->getCellByColumnAndRow(18,$i)->getValue();
					  $bdufive = $objWorksheet->getCellByColumnAndRow(23,$i)->getValue();
					  $bdofive = $objWorksheet->getCellByColumnAndRow(24,$i)->getValue();
					  $oadufive = 0;
					  $oadofive = 0;
					  $diphufive = $objWorksheet->getCellByColumnAndRow(41,$i)->getValue();
					  $diphofive = $objWorksheet->getCellByColumnAndRow(42,$i)->getValue();
					  $wcufive = $objWorksheet->getCellByColumnAndRow(47,$i)->getValue();
					  $wcofive = $objWorksheet->getCellByColumnAndRow(48,$i)->getValue();
					  $measufive = $objWorksheet->getCellByColumnAndRow(29,$i)->getValue();
					  $measofive = $objWorksheet->getCellByColumnAndRow(30,$i)->getValue();					  
					  $tetufive = $objWorksheet->getCellByColumnAndRow(59,$i)->getValue();					  
					  $tetofive = $objWorksheet->getCellByColumnAndRow(60,$i)->getValue();
					  $nnt = ($tetufive + $tetofive);
					  $afpufive = $objWorksheet->getCellByColumnAndRow(35,$i)->getValue();
					  $afpofive = $objWorksheet->getCellByColumnAndRow(36,$i)->getValue();
					  $ajs = 0;
					  $vhf = 0;
					  $malufive = $objWorksheet->getCellByColumnAndRow(53,$i)->getValue();
					  $malofive = $objWorksheet->getCellByColumnAndRow(54,$i)->getValue();
					  $menufive = 0;
					  $menofive = 0;
					  $undisone = 0;
					  $undis = 0;
					  $ocmale = $objWorksheet->getCellByColumnAndRow(63,$i)->getValue();
					  $ocfemale = $objWorksheet->getCellByColumnAndRow(64,$i)->getValue();
					  $othercons = $ocmale+$ocfemale;
					  $sre = 0;
					  $pf = 0;
					  $pv = 0;
					  $pmix = 0;
					  
					  $key = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
					  
					  $total_consultations = $iliufive+$iliofive + $sariufive + $sariofive + $awdufive + $awdofive + $bdufive + $bdofive + $oadufive + $oadofive + $diphufive + $diphofive + $wcufive + $wcofive + $measufive + $measofive + $nnt + $afpufive + $afpofive + $ajs + $vhf + $malufive + $malofive + $menufive + $menofive + $undisone + $undis + $othercons + $sre + $pf + $pv + $pmix;
					  
					  $comment = $objWorksheet->getCellByColumnAndRow(76,$i)->getValue();
					  $reported_alerts = $objWorksheet->getCellByColumnAndRow(77,$i)->getValue();
					  
					  $notes = 'Comment: '.$comment.'. Reported Alerts: '.$reported_alerts;
					  
					   $reportingperiod = $this->epdcalendarmodel->get_by_year_week('2014',$week_no)->row();
					  
						   $data = array(
						   'week_no' => $week_no,
						   'reporting_year' => '2014',
						   'reporting_date' => $reporting_date,
						   'epicalendar_id' => $reportingperiod->id,
						   'user_id' => 1,
						   'healthfacility_id' => $healthfacility_id,
						   'district_id' => $district_id,
						   'region_id' => $region_id,
						   'zone_id' => 1,
						   'contact_number' => $contact_number,
						   'supporting_ngo' => $supporting_ngo,
						   'undisonedesc' => 'NA',
						   'undismale' => $undisone,
						   'undisfemale' => $undis,
						   'undissecdesc' => 'NA',
						   'undismaletwo' => '0',
						   'undisfemaletwo' => '0',
						   'ocmale' => $ocmale,
						   'ocfemale' => $ocfemale,
						   'total_consultations' => $total_consultations,
						   'sre' => $sre,
						   'pf' => $pf,
						   'pv' => $pv,
						   'pmix' => $pmix,
						   'total_positive' => 0,
						   'total_negative' => 0,
						   'approved_dist' => 1,
						   'approved_region' => 1,
						   'approved_zone' => 1,
						   'approved_national' => 1,
						   'draft' => 0,
						   'alert_sent' => 1,
						   'entry_date' => $reporting_date,
						   'entry_time' => $reporting_date.'00:00',
						   'edit_date' => $reporting_date,
						   'edit_time' => $reporting_date.'00:00',
						   'key' => $key,
					   );
					   $this->db->insert('forms', $data);
					   
					   $form_id = $this->db->insert_id();//get the ID of the saved record 
					   
					   $country_id = 1;
					   
					   
					   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id));
					   
					   foreach ($diseases->result() as $disease):
					  
							  $under_five_male = 0;
							  $under_five_female = 0;
							  $over_five_male = 0;
							  $over_five_female = 0;
							  
							  if($disease->disease_code=='SARI')
							  {
								  $total_under_five = 0 + $sariufive;
								  $total_over_five = 0 + $sariofive;
								  $total_disease = $sariufive + $sariofive;
							  }
							  
							  if($disease->disease_code=='ILI')
							  {
								  $total_under_five = 0+ $iliufive;
								  $total_over_five = 0 + $iliofive;
								  $total_disease = $iliufive + $iliofive;
							  }
							  
							  if($disease->disease_code=='AWD')
							  {
								  $total_under_five = 0 + $awdufive;
								  $total_over_five = 0 + $awdofive;
								  $total_disease = $awdufive + $awdofive;
							  }
							  
							  if($disease->disease_code=='BD')
							  {
								  $total_under_five = 0 + $bdufive;
								  $total_over_five = 0 + $bdofive;
								  $total_disease = $bdufive + $bdofive;
							  }
							  
							  if($disease->disease_code=='OAD')
							  {
								 $total_under_five = 0 + $oadufive;
								  $total_over_five = 0 + $oadofive;
								  $total_disease = $oadufive + $oadofive;
							  }
							  
							  if($disease->disease_code=='Diph')
							  {
								 $total_under_five = 0 + $diphufive;
								  $total_over_five = 0 + $diphofive;
								  $total_disease = $diphufive + $diphofive;
							  }
							  
							  if($disease->disease_code=='WC')
							  {
								  $total_under_five = 0 + $wcufive;
								  $total_over_five = 0 + $wcofive;
								  $total_disease = $wcufive + $wcofive;
							  }
							  
							  if($disease->disease_code=='Meas')
							  {
								  $total_under_five = 0 + $measufive;
								  $total_over_five = 0 + $measofive;
								  $total_disease = $measufive + $measofive;
							  }
							  
							  if($disease->disease_code=='NNT')
							  {
								 $total_under_five = 0;
								 $total_over_five = 0;
								 $total_disease = $nnt;
							  }
							  
							  if($disease->disease_code=='AFP')
							  {
								  $total_under_five = 0 + $afpufive;
								  $total_over_five = 0 + $afpofive;
								  $total_disease = $afpufive + $afpofive;
							  }
							  
							  if($disease->disease_code=='AJS')
							  {
								  $total_under_five = 0;
								  $total_over_five = 0;
								  $total_disease = $ajs;
							  }
							  
							  if($disease->disease_code=='VHF')
							  {
								 $total_under_five = 0;
								  $total_over_five = 0;
								  $total_disease = $vhf;
							  }
							  
							  if($disease->disease_code=='Mal')
							  {
								  $total_under_five = 0 + $malufive;
								  $total_over_five = 0 + $malofive;
								  $total_disease = $malufive + $malofive;
							  }
							  
							  if($disease->disease_code=='Men')
							  {
								  $total_under_five = 0 + $menufive;
								  $total_over_five = 0 + $menofive;
								  $total_disease = $menufive + $menofive;
							  }
					   
							$formdata = array(
							   'form_id' => $form_id,
							   'epicalendar_id' => $reportingperiod->id,
							   'healthfacility_id' => $healthfacility_id,
							   'district_id' => $district_id,
							   'region_id' => $region_id,
							   'zone_id' => 1,
							   'disease_id' => $disease->id,
							   'disease_name' => $disease->disease_code,
							   'male_under_five' => $under_five_male,
							   'female_under_five' => $under_five_female,
							   'male_over_five' => $over_five_male,
							   'female_over_five' => $over_five_female,
							   'total_under_five' => 0,
							   'total_over_five' => 0,
							   'total_disease' => $total_disease,
						   );
						   
						   $this->db->insert('formsdata', $formdata);
						   
						   
						   //alerts
						   if($disease->alert_type==1)
						   {
							   if($disease->alert_threshold==0)
							   {
								  $threshold = $disease->alert_threshold;
							   }
							   else
							   {
								  $threshold = ($disease->alert_threshold-1);
							   }
							   
							   if ($total_disease > $threshold) {
								   
								   $alertdata = array(
										'reportingform_id' => $form_id,
										'reportingperiod_id' => $reportingperiod->id,
										'disease_id' => $disease->id,
										'disease_name' => $disease->disease_code,
										'healthfacility_id' => $healthfacility_id,
										'district_id' => $district_id,
										'region_id' => $region_id,
										'zone_id' => 1,
										'cases' => $total_disease,
										'deaths' => 0,
										'notes' => $notes,
										'verification_status' => 0,
										'include_bulletin' => 0
									);
									$this->db->insert('formalerts', $alertdata);
								   
							   }
						   }
					   		
						   $under_five_male = NULL;
						   $under_five_female = NULL;
						   $over_five_male = NULL;
						   $over_five_female = NULL;
						   $total_disease = NULL;
					   
					   endforeach;
					   
					   
					   $country_id = NULL;
					   $week_no = NULL;
						$data_of_entry = NULL;
						$date = NULL;
						$reported_by = NULL;
						$reporting_date = NULL;
						$healthfacility_name = NULL;
						$contact_number = NULL;
						$supporting_ngo = NULL;
						$district_cell = NULL;
						$region_cell = NULL;
						$theregion = NULL;
						$region_id = NULL;
						$district_id = NULL;
						$healthfacility = NULL;
						$healthfacility_id = NULL;
						$districtdata = NULL;
						$regiondata = NULL;
						$hfdata = NULL;
						$reportingperiod = NULL;
						$data = NULL;
						$form_id = NULL;
						$iliufive=NULL;
						$iliofive =NULL;
						 $sariufive =NULL;
						 $sariofive =NULL;
						 $awdufive =NULL;
						 $awdofive =NULL;
						 $bdufive =NULL;
						 $bdofive =NULL;
						 $oadufive =NULL;
						 $oadofive =NULL;
						 $diphufive =NULL;
						 $diphofive =NULL;
						 $wcufive =NULL;
						 $wcofive =NULL;
						 $measufive =NULL;
						 $measofive =NULL;
						 $nnt =NULL;
						 $afpufive =NULL;
						 $afpofive =NULL;
						 $ajs =NULL;
						 $vhf =NULL;
						 $malufive =NULL;
						 $malofive =NULL;
						 $menufive =NULL;
						 $menofive =NULL;
						 $undis =NULL;
						 $undis =NULL;
						 $othercons =NULL;
						 $sre =NULL;
						 $pf =NULL;
						 $pv =NULL;
						 $pmix =NULL;
						 $tetufive = NULL;					  
					     $tetofive = NULL;
						 $comment = NULL;
					     $reported_alerts = NULL;
						 $notes = NULL;
						 
					  }
					  
				  }//end for
					
					
			}
   }
   
   
  	public function import()
	{
		 $file_element_name = 'userfile';
		   $config['upload_path'] = './uploads/';
		   $config['allowed_types'] = 'xls|xlsx|csv';
		   $dataerror = array();
		
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload($file_element_name))
			{
				$error = $this->upload->display_errors('', '');
				$dataerror['error'] = '<div class="form_error">'.$error.'</div>';
					 
				$this->load->view('alerts/import',$dataerror);
			}
			else
			{
				$filedata = $this->upload->data();
				   $filename = $filedata['file_name'];
			  
					$excelfile = "./uploads/".$filename;
					//$obj = PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
					//$objReader = PHPExcel_IOFactory::createReader('Excel2007');
					$objReader = PHPExcel_IOFactory::createReaderForFile($excelfile);
					
					 //set to read only
				  $objReader->setReadDataOnly(true);
				  
				  
				  $objPHPExcel = $objReader->load("".$excelfile."");
				  $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
				  $highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
				  
				  for($i=1501; $i<=1590; $i++){
					  
					
					   //$week_no = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
					   
					   $week_cell = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
					   
					   $res = preg_replace("/[^0-9,.]/", "", $week_cell);
					   $str = ltrim($res, '0');
					   
					   $week_no = $str;
					 
					 					  
					   $date_of_entry = date('m/d/Y',PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(3, $i)->getFormattedValue()));
					   $date = DateTime::createFromFormat('m/d/Y', $date_of_entry);
					   //$reporting_date = $date->format('Y-m-d');
					  
					  $reported_by = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
					 
					  $healthfacility_name = $objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
					  $contact_number = $objWorksheet->getCellByColumnAndRow(7,$i)->getValue();
					
					  $supporting_ngo = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue();
					  $region_cell = $objWorksheet->getCellByColumnAndRow(10,$i)->getValue();
					  $district_cell = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
					  					  
					  
					  $theregion = $this->regionsmodel->get_by_name($region_cell)->row();
					  
					  /**
					  Central 1
					  Puntland 2
					  Southern 3
					  Somaliland 4
					  **/
					  
					  $zone_id = 4;
					  $reporting_year = 2017;
					  
					  if(empty($theregion))
					  {
						  $regiondata = array(
							   'region' => $region_cell,
							   'regional_code' => 'N/A',
							   'zone_id' => $zone_id,
						   );
						   $this->db->insert('regions', $regiondata);
						   
						   $region_id = $this->db->insert_id();
					  }
					  else
					  {
						  $region_id = $theregion->id;
						  
					  }
					  
					  $district = $this->districtsmodel->get_by_name($district_cell)->row();
						  
					  if(empty($district))
					  {
							  $districtdata = array(
								   'district' => $district_cell,
								   'district_code' => 'N/A',
								   'region_id' => $region_id,
							   );
							   $this->db->insert('districts', $districtdata);
							   $district_id = $this->db->insert_id();
					  }
					  else
					  {
							  $district_id = $district->id;
					  }
					  
					  $healthfacility = $this->healthfacilitiesmodel->get_by_name($healthfacility_name)->row();
					  
					  if(empty($healthfacility))
					  {
							  $hfdata = array(
								   'health_facility' => $healthfacility_name,
								   'hf_code' => 'N/A',
								   'district_id' => $district_id,
								   'organization' => $healthfacility_name,
								   'health_facility_type' => 'MCH',
								   'catchment_population' => '0',
								   'focal_person_name' => $reported_by,
								   'contact_number' => $contact_number,
								   'email' => 'N/A',
								   'activated' => 1,
								   'otherval' => 'N/A',
							   );
							   $this->db->insert('healthfacilities', $hfdata);
							   $healthfacility_id = $this->db->insert_id();
					  }
					  else
					  {
							  $healthfacility_id = $healthfacility->id;
					  }
					  
					  $iliufive = $objWorksheet->getCellByColumnAndRow(11,$i)->getValue();
					  $iliofive = $objWorksheet->getCellByColumnAndRow(12,$i)->getValue();
					  $sariufive = $objWorksheet->getCellByColumnAndRow(13,$i)->getValue();
					  $sariofive = $objWorksheet->getCellByColumnAndRow(14,$i)->getValue();
					  $awdufive = $objWorksheet->getCellByColumnAndRow(15,$i)->getValue();
					  $awdofive = $objWorksheet->getCellByColumnAndRow(16,$i)->getValue();
					  $bdufive = $objWorksheet->getCellByColumnAndRow(17,$i)->getValue();
					  $bdofive = $objWorksheet->getCellByColumnAndRow(18,$i)->getValue();
					  $oadufive = $objWorksheet->getCellByColumnAndRow(19,$i)->getValue();
					  $oadofive = $objWorksheet->getCellByColumnAndRow(20,$i)->getValue();
					  $diphufive = $objWorksheet->getCellByColumnAndRow(21,$i)->getValue();
					  $diphofive = $objWorksheet->getCellByColumnAndRow(22,$i)->getValue();
					  $wcufive = $objWorksheet->getCellByColumnAndRow(23,$i)->getValue();
					  $wcofive = $objWorksheet->getCellByColumnAndRow(24,$i)->getValue();
					  $measufive = $objWorksheet->getCellByColumnAndRow(25,$i)->getValue();
					  $measofive = $objWorksheet->getCellByColumnAndRow(26,$i)->getValue();
					  $nnt = $objWorksheet->getCellByColumnAndRow(27,$i)->getValue();
					  $afpufive = $objWorksheet->getCellByColumnAndRow(28,$i)->getValue();
					  $afpofive = $objWorksheet->getCellByColumnAndRow(29,$i)->getValue();
					  $ajsufive = $objWorksheet->getCellByColumnAndRow(30,$i)->getValue();
					  $ajsofive = $objWorksheet->getCellByColumnAndRow(31,$i)->getValue();
					  $vhfufive = $objWorksheet->getCellByColumnAndRow(32,$i)->getValue();
					  $vhfofive = $objWorksheet->getCellByColumnAndRow(33,$i)->getValue();
					  $malufive = $objWorksheet->getCellByColumnAndRow(34,$i)->getValue();
					  $malofive = $objWorksheet->getCellByColumnAndRow(35,$i)->getValue();
					  $menufive = $objWorksheet->getCellByColumnAndRow(36,$i)->getValue();
					  $menofive = $objWorksheet->getCellByColumnAndRow(37,$i)->getValue();
					  $undisone = $objWorksheet->getCellByColumnAndRow(38,$i)->getValue();
					  $undis = $objWorksheet->getCellByColumnAndRow(39,$i)->getValue();
					  $othercons = $objWorksheet->getCellByColumnAndRow(40,$i)->getValue();
					  $sre = $objWorksheet->getCellByColumnAndRow(42,$i)->getValue();
					  $pf = $objWorksheet->getCellByColumnAndRow(43,$i)->getValue();
					  $pv = $objWorksheet->getCellByColumnAndRow(44,$i)->getValue();
					  $pmix = $objWorksheet->getCellByColumnAndRow(45,$i)->getValue();
					  $total_consultations = $objWorksheet->getCellByColumnAndRow(41,$i)->getValue();
					 /**
					$total_consultations = $iliufive+$iliofive + $sariufive + $sariofive + $awdufive + $awdofive + $bdufive + $bdofive + $oadufive + $oadofive + $diphufive + $diphofive + $wcufive + $wcofive + $measufive + $measofive + $nnt + $afpufive + $afpofive + $ajsufive + $ajsofive + $vhfufive + $vhfofive + $malufive + $malofive + $menufive + $menofive + $undisone + $undis + $othercons;
					**/
					
											  
					  $undisone = $undisone+0;
					  $undis = $undis+0;
					  $othercons = $othercons + 0;
					  
					  $total_consultations = $total_consultations + 0;
					  
					  $reportingperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year,$week_no)->row();
					  $reporting_date = $reportingperiod->to;
					  
								  
						   $data = array(
						   'week_no' => $week_no,
						   'reporting_year' => $reporting_year,
						   'reporting_date' => $reporting_date,
						   'epicalendar_id' => $reportingperiod->id,
						   'user_id' => 1,
						   'healthfacility_id' => $healthfacility_id,
						   'district_id' => $district_id,
						   'region_id' => $region_id,
						   'zone_id' => $zone_id,
						   'contact_number' => $contact_number,
						   'supporting_ngo' => $supporting_ngo,
						   'undisonedesc' => 'NA',
						   'undismale' => $undisone,
						   'undisfemale' => $undis,
						   'undissecdesc' => 'NA',
						   'undismaletwo' => '0',
						   'undisfemaletwo' => '0',
						   'ocmale' => $othercons,
						   'ocfemale' => '0',
						   'total_consultations' => $total_consultations,
						   'sre' => $sre,
						   'pf' => $pf,
						   'pv' => $pv,
						   'pmix' => $pmix,
						   'total_positive' => 0,
						   'total_negative' => 0,
						   'approved_dist' => 1,
						   'approved_region' => 1,
						   'approved_zone' => 1,
						   'approved_national' => 1,
						   'draft' => 0,
						   'alert_sent' => 1,
						   'entry_date' => $reporting_date,
						   'entry_time' => $reporting_date.' 00:00',
						   'edit_date' => $reporting_date,
						   'edit_time' => $reporting_date.' 00:00',
						   'key' => $i,
					   );
					   
					   $this->db->insert('forms', $data);
					   
					   $form_id = $this->db->insert_id();//get the ID of the saved record 
					  
					   
					   $country_id = 1;
					   
					   
					   $diseases = $this->db->get_where('diseases', array('country_id' => $country_id));
					   
					   foreach ($diseases->result() as $disease):
					  
							  $under_five_male = 0;
							  $under_five_female = 0;
							  $over_five_male = 0;
							  $over_five_female = 0;
							  
							  if($disease->disease_code=='SARI')
							  {
								  $total_under_five = 0 + $sariufive;
								  $total_over_five = 0 + $sariofive;
								  $total_disease = $sariufive + $sariofive + 0;
							  }
							  
							  if($disease->disease_code=='ILI')
							  {
								  $total_under_five = 0+ $iliufive;
								  $total_over_five = 0 + $iliofive;
								  $total_disease = $iliufive + $iliofive + 0;
							  }
							  
							  if($disease->disease_code=='AWD')
							  {
								  $total_under_five = 0 + $awdufive;
								  $total_over_five = 0 + $awdofive;
								  $total_disease = $awdufive + $awdofive + 0;
							  }
							  
							  if($disease->disease_code=='BD')
							  {
								  $total_under_five = 0 + $bdufive;
								  $total_over_five = 0 + $bdofive;
								  $total_disease = $bdufive + $bdofive + 0;
							  }
							  
							  if($disease->disease_code=='OAD')
							  {
								 $total_under_five = 0 + $oadufive;
								  $total_over_five = 0 + $oadofive;
								  $total_disease = $oadufive + $oadofive + 0;
							  }
							  
							  if($disease->disease_code=='Diph')
							  {
								 $total_under_five = 0 + $diphufive;
								  $total_over_five = 0 + $diphofive;
								  $total_disease = $diphufive + $diphofive + 0;
							  }
							  
							  if($disease->disease_code=='WC')
							  {
								  $total_under_five = 0 + $wcufive;
								  $total_over_five = 0 + $wcofive;
								  $total_disease = $wcufive + $wcofive + 0;
							  }
							  
							  if($disease->disease_code=='Meas')
							  {
								  $total_under_five = 0 + $measufive;
								  $total_over_five = 0 + $measofive;
								  $total_disease = $measufive + $measofive + 0;
							  }
							  
							  if($disease->disease_code=='NNT')
							  {
								 $total_under_five = 0;
								 $total_over_five = 0;
								 $total_disease = $nnt + 0;
							  }
							  
							  if($disease->disease_code=='AFP')
							  {
								  $total_under_five = 0 + $afpufive;
								  $total_over_five = 0 + $afpofive;
								  $total_disease = $afpufive + $afpofive + 0;
							  }
							  
							  if($disease->disease_code=='AJS')
							  {
								  $total_under_five = 0 + $ajsufive;
								  $total_over_five = 0 + $ajsofive;
								  $total_disease = $ajsufive + +$ajsofive + 0;
							  }
							  
							  if($disease->disease_code=='VHF')
							  {
								 $total_under_five = 0 + $vhfufive;
								  $total_over_five = 0 + $vhfofive;
								  $total_disease = $vhfufive + $vhfofive + 0;
							  }
							  
							  if($disease->disease_code=='Mal')
							  {
								  $total_under_five = 0 + $malufive;
								  $total_over_five = 0 + $malofive;
								  $total_disease = $malufive + $malofive + 0;
							  }
							  
							  if($disease->disease_code=='Men')
							  {
								  $total_under_five = 0 + $menufive;
								  $total_over_five = 0 + $menofive;
								  $total_disease = $menufive + $menofive + 0;
							  }
					   
							$formdata = array(
							   'form_id' => $form_id,
							   'epicalendar_id' => $reportingperiod->id,
							   'healthfacility_id' => $healthfacility_id,
							   'district_id' => $district_id,
							   'region_id' => $region_id,
							   'zone_id' => $zone_id,
							   'disease_id' => $disease->id,
							   'disease_name' => $disease->disease_code,
							   'male_under_five' => $under_five_male,
							   'female_under_five' => $under_five_female,
							   'male_over_five' => $over_five_male,
							   'female_over_five' => $over_five_female,
							   'total_under_five' => $total_under_five,
							   'total_over_five' => $total_over_five,
							   'total_disease' => $total_disease,
						   );
						   
						   $this->db->insert('formsdata', $formdata);
						   
						   //alerts
						   if($disease->alert_type==1)
						   {
							   if($disease->alert_threshold==0)
							   {
								  $threshold = $disease->alert_threshold;
							   }
							   else
							   {
								  $threshold = ($disease->alert_threshold-1);
							   }
							   
							   if ($total_disease > $threshold) {
								   
								   $alertdata = array(
										'reportingform_id' => $form_id,
										'reportingperiod_id' => $reportingperiod->id,
										'disease_id' => $disease->id,
										'disease_name' => $disease->disease_code,
										'healthfacility_id' => $healthfacility_id,
										'district_id' => $district_id,
										'region_id' => $region_id,
										'zone_id' => $zone_id,
										'cases' => $total_disease,
										'deaths' => 0,
										'notes' => '-',
										'verification_status' => 0,
										'include_bulletin' => 0
									);
									$this->db->insert('formalerts', $alertdata);
								   
							   }
						   }
					   		
						   $under_five_male = NULL;
						   $under_five_female = NULL;
						   $over_five_male = NULL;
						   $over_five_female = NULL;
						   $total_disease = NULL;
					   
					   endforeach;
					   
					   
					   $country_id = NULL;
					   $week_no = NULL;
						$data_of_entry = NULL;
						$date = NULL;
						$reported_by = NULL;
						$reporting_date = NULL;
						$healthfacility_name = NULL;
						$contact_number = NULL;
						$supporting_ngo = NULL;
						$district_cell = NULL;
						$region_cell = NULL;
						$theregion = NULL;
						$region_id = NULL;
						$district_id = NULL;
						$healthfacility = NULL;
						$healthfacility_id = NULL;
						$districtdata = NULL;
						$regiondata = NULL;
						$hfdata = NULL;
						$reportingperiod = NULL;
						$data = NULL;
						$form_id = NULL;
						$iliufive=NULL;
						$iliofive =NULL;
						 $sariufive =NULL;
						 $sariofive =NULL;
						 $awdufive =NULL;
						 $awdofive =NULL;
						 $bdufive =NULL;
						 $bdofive =NULL;
						 $oadufive =NULL;
						 $oadofive =NULL;
						 $diphufive =NULL;
						 $diphofive =NULL;
						 $wcufive =NULL;
						 $wcofive =NULL;
						 $measufive =NULL;
						 $measofive =NULL;
						 $nnt =NULL;
						 $afpufive =NULL;
						 $afpofive =NULL;
						 $ajs =NULL;
						 $vhf =NULL;
						 $malufive =NULL;
						 $malofive =NULL;
						 $menufive =NULL;
						 $menofive =NULL;
						 $undis =NULL;
						 $undis =NULL;
						 $othercons =NULL;
						 $sre =NULL;
						 $pf =NULL;
						 $pv =NULL;
						 $pmix =NULL;
						 
						//sleep(3); // this should halt for 3 seconds for every loop
					  
				  }
				
			}
			
			delete_files('./uploads/');
	}
	
	
	public function alerts()
	{
		$reporting_year = '2015'; //261
		$country_id = 1;
		$id = 10513;
		
		//target -> 10518
		$forms = $this->db->get_where('forms', array('reporting_year' => $reporting_year, 'id >' => $id));
		//$diseases = $this->db->get_where('diseases', array('country_id' => $country_id));
		
		foreach ($forms->result() as $form):
		
			$formsdata = $this->db->get_where('formsdata', array('form_id' => $form->id));
		
			 foreach ($formsdata->result() as $formdata){
				 
				 $disease = $this->diseasesmodel->get_by_id($formdata->disease_id)->row();
				 if($disease->alert_type==1)
						   {
							   if($disease->alert_threshold==0)
							   {
								  $threshold = $disease->alert_threshold;
							   }
							   else
							   {
								  $threshold = ($disease->alert_threshold-1);
							   }
							   
							   if ($formdata->total_disease > $threshold) {
								   
								   $alertdata = array(
										'reportingform_id' => $formdata->form_id,
										'reportingperiod_id' => $formdata->epicalendar_id,
										'disease_id' => $disease->id,
										'disease_name' => $disease->disease_code,
										'healthfacility_id' => $formdata->healthfacility_id,
										'district_id' => $formdata->district_id,
										'region_id' => $formdata->region_id,
										'zone_id' => $formdata->zone_id,
										'cases' => $formdata->total_disease,
										'deaths' => 0,
										'notes' => '-',
										'verification_status' => 0,
										'include_bulletin' => 0
									);
									$this->db->insert('formalerts', $alertdata);
								   
							   }
						   }//end alert check
				 
			 }// end forms data
			 
		
		
		endforeach;
	}

}
