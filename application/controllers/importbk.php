<?php

class Import extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('exportmodel');
	   $this->load->library("Excel");
   }

   public function index()
   {
     

	$this->uploadpage();
	 
  
	  
   }

  function uploadpage(){
  	 $data = array();
       $this->load->view('imports/uploadpage', $data);
  }
  
  function importcoords()
  {
	  $file_element_name = 'userfile';
	  
	  $config['upload_path'] = './excelsheets/';
	  //$config['allowed_types'] = 'xls|xlxs';
	  $config['allowed_types'] = '*';
	  $this->load->library('upload', $config);
	  
	  if (!$this->upload->do_upload($file_element_name))
	 {
		 
	 }
	 else
	 {
		   //here i used microsoft excel 2007
		  $objReader = PHPExcel_IOFactory::createReader('Excel2007');
		  //set to read only
		  $objReader->setReadDataOnly(true);
		  
		  $filedata = $this->upload->data();
		  $filename = $filedata['file_name'];
		  
		  $excelfile = "./excelsheets/".$filename;
		  //load excel file
		  $objPHPExcel = $objReader->load("".$excelfile."");
		  $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
		  
		  for($i=2; $i<=100; $i++){
			  
			  $district_id = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
			   $lat = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
			   $long = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
			   
			   
			    $data = array(
               'lat' => $lat,
               'long' => $long,
              
           );
           $this->db->where('id', $district_id);
           $this->db->update('districts', $data);
			  
		  }
		 
	 }
  }
  
  function importfile()
  {
	   $file_element_name = 'userfile';
	  
	  $config['upload_path'] = './excelsheets/';
	  //$config['allowed_types'] = 'xls|xlxs';
	  $config['allowed_types'] = '*';
	  $this->load->library('upload', $config);
	  
	  if (!$this->upload->do_upload($file_element_name))
	 {
		 
	 }
	 else
	 {
		  //here i used microsoft excel 2007
		  $objReader = PHPExcel_IOFactory::createReader('Excel2007');
		  //set to read only
		  $objReader->setReadDataOnly(true);
		  
		  $filedata = $this->upload->data();
		  $filename = $filedata['file_name'];
		  
		  $excelfile = "./excelsheets/".$filename;
		  //load excel file
		  $objPHPExcel = $objReader->load("".$excelfile."");
		  $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
		  //load model
		 
		  //loop from first data until last data
		  for($i=2; $i<=14; $i++){
			   $zone_id = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
			   $region_id = $objWorksheet->getCellByColumnAndRow(1,$i)->getValue();
			   $district_id = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
			   $organization = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
			   $email = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
			   $contact_number = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
			   $firstname = $objWorksheet->getCellByColumnAndRow(6,$i)->getValue();
			   $lastname = $objWorksheet->getCellByColumnAndRow(7,$i)->getValue();
			   $level = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue();
			   $username = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue();
			   $password = $objWorksheet->getCellByColumnAndRow(10,$i)->getValue();
			   
			    $data = array(
               'fname' => $firstname,
               'lname' => $lastname,
               'healthfacility_id' => 0,
			   'organization' => $organization,
			   'email' => $email,
			   'contact_number' => $contact_number,
               'username' => $username,
               'password' => md5($password),
               'role_id' => 3,
               'active' => 1,
			   'level' =>$level,
			   'zone_id' => $zone_id,
			   'region_id' => $region_id,
			   'district_id' => $district_id,
           );
           $this->db->insert('users', $data);
		   
		   
	 }
   }
  }

}
