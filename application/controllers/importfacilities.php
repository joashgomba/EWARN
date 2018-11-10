<?php

class Importfacilities extends CI_Controller {

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

               $hf_code = $objWorksheet->getCellByColumnAndRow(0,$i)->getValue();
			   $district_name = $objWorksheet->getCellByColumnAndRow(2,$i)->getValue();
			   $health_facility = $objWorksheet->getCellByColumnAndRow(3,$i)->getValue();
			   $health_facility_type = $objWorksheet->getCellByColumnAndRow(4,$i)->getValue();
               $organization = $objWorksheet->getCellByColumnAndRow(5,$i)->getValue();
               $focal_person_name = $objWorksheet->getCellByColumnAndRow(8,$i)->getValue();
               $contact_number = $objWorksheet->getCellByColumnAndRow(9,$i)->getValue();

               $healthfacility = $this->healthfacilitiesmodel->get_by_name($health_facility)->row();

               $district = $this->districtsmodel->get_by_name($district_name)->row();

              if(empty($district))
              {
                  $district_id = 0;
              }
              else
              {
                  $district_id = $district->id;
              }

               if(empty($healthfacility))
               {

                   $data = array(
                       'health_facility' => $health_facility,
                       'hf_code' => $hf_code,
                       'district_id' => $district_id,
                       'organization' => $organization,
                       'health_facility_type' => $health_facility_type,
                       'catchment_population' => 0,
                       'focal_person_name' => $focal_person_name,
                       'contact_number' => $contact_number,
                       'email' => '',
                       'activated' => 1,
                       'otherval' => '',
                   );

                   $this->db->insert('healthfacilities', $data);
               }
               else{
                   //The health facility exists. Update the contact person's details
               }



			  
		  }
		 
	 }
  }



}
