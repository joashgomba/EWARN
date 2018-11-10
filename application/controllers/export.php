<?php

class Export extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('exportmodel');
   }

   public function index()
   {
         //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 $level = $this->erkanaauth->getField('level');
	 
	  if(getRole() != 'SuperAdmin' &&  $level !=2 &&  $level !=1 &&  $level !=6)
	  {

		redirect('home', 'refresh');

	  }
	   $data = array();
	   
	   $data['regions'] = $this->regionsmodel->get_list();
	   
	   $data['level'] = $level;
	   
	  if(getRole() == 'SuperAdmin')
	  {

		$data['regions'] = $this->regionsmodel->get_list();
		$data['districts'] = $this->districtsmodel->get_list();
		$data['zones'] = $this->zonesmodel->get_list();
		$data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();

	  }
	  
	  if($level==2)//Regional FP
	   {
		   	   
		   $region_id = $this->erkanaauth->getField('region_id');		   
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
		   $data['districts'] = $this->districtsmodel->get_by_region($region->id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);
		   
	   }
	   
	    if($level==6)//district
	   {
		   	   
		   $district_id = $this->erkanaauth->getField('district_id');
		   $district = $this->districtsmodel->get_by_id($district_id)->row();		   
		   		   
		   $region = $this->regionsmodel->get_by_id($district->region_id)->row();
		   $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
		   $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
		   $data['district'] = $district;
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district($district->id);
		   
	   }
	   
	    if($level==1)//zonal
	   {
		   $zone_id = $this->erkanaauth->getField('zone_id');
		   $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
		   $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
		   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone->id);
	   }
	   
	   if($level==4)//national
	   {
		 $data['regions'] = $this->regionsmodel->get_list();
		  $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
		 $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   }
	   		
	  		   
       $this->load->view('reportingforms/exportlist', $data);
   }
   
   function exportlist()
   {
	   $region_id = $this->input->post('region_id');
	   $district_id = $this->input->post('district_id');
	   $healthfacility_id = $this->input->post('healthfacility_id');
	   
	   $reporting_year = $this->input->post('reporting_year');
	   $from = $this->input->post('from');
	   $reporting_year2 = $this->input->post('reporting_year2');
	   $to = $this->input->post('to');
	   
	   if(empty($region_id))
	   {
		   $reg_id = 0;
	   }
	   else
	   {
		   $reg_id = $region_id;
	   }
	   
	   if(empty($district_id))
	   {
		   $dist_id = 0;
	   }
	   else
	   {
		   $dist_id = $district_id;
	   }
	   
	   if(empty($healthfacility_id))
	   {
		   $hf_id = 0;
	   }
	   else
	   {
		   $hf_id = $healthfacility_id;
	   }
	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	   
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	    $forms = $this->exportmodel->get_export_records($reg_id,$dist_id,$hf_id,$period_one,$period_two,$reporting_year,$reporting_year2);
	  	   
	   $table = '
		<style>
				#listtable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#listtable td, #listtable th 
				{
				font-size:1.0em;
				border:1px solid #999999;
				padding:3px 7px 2px 7px;
				}
				#listtable th 
				{
				font-size:1.0em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#0000CC;
				color:#fff;
				}
				#listtable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="listtable" border="1"><thead>';
		$table .= '<tr><th>week_year</th><th>week_no</th><th>Zon_name</th><th>reg_name</th><th>d_name</th>
		<th>org_name</th><th>hf_name</th><th>hft</th><th>hfc</th><th>ili_lt_5</th><th>ili_gt_5</th><th>sari_lt_5</th><th>sari_gt_5</th>
		<th>awd_lt_5</th><th>awd_gt_5</th><th>bd_lt_5</th><th>bd_gt_5</th><th>oad_lt_5</th><th>oad_gt_5</th><th>diph_lt_5</th><th>diph_gt_5</th><th>wc_lt_5</th><th>wc_gt_5</th><th>meas_lt_5</th><th>meas_gt_5</th><th>nnt</th><th>afp_lt_5</th><th>afp_gt_5</th><th>ajs</th><th>vhf</th><th>mal_lt_5</th><th>mal_gt_5</th><th>men_lt_5</th><th>men_gt_5</th><th>unDis_name</th><th>unDis_num</th><th>unDis_name</th><th>unDis_num</th><th>oc</th><th>total_cons_disease</th><th>sre</th><th>pf</th><th>pv</th><th>pmix</th><th>zon_code</th>
		<th>reg_code</th><th>dis_code</th><th>Entry_Date</th><th>Entry_Time</th><th>User_ID</th><th>con_number</th><th>Edit_Date</th><th>Edit_Time</th>
		</tr>';
		$table .= '</thead><tbody>';
		
		foreach($forms as $key=>$form)
		{
		
			$sariutot = $form->sariufivemale+$form->sariufivefemale;
						$sariotot = $form->sariofivemale + $form->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $form->iliufivemale + $form->iliufivefemale;
						$iliotot = $form->iliofivemale + $form->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $form->awdufivemale + $form->awdufivefemale;
						$awdotot = $form->awdofivemale + $form->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $form->bdufivemale + $form->bdufivefemale;
						$bdotot = $form->bdofivemale + $form->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $form->oadufivemale + $form->oadufivefemale;
						$oadotot = $form->oadofivemale + $form->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $form->diphmale + $form->diphfemale;
						$diphofivetot = $form->diphofivemale + $form->diphofivefemale;
						$wctot = $form->wcmale + $form->wcfemale;
						$wcofivetot = $form->wcofivemale + $form->wcofivefemale;
						$meastot = $form->measmale + $form->measfemale;						
						$measofivetot = $form->measofivemale + $form->measofivefemale;						
						$nnttot = $form->nntmale + $form->nntfemale;
						$afptot = $form->afpmale + $form->afpfemale;
						$afpofivetot = $form->afpofivemale + $form->afpofivefemale;
						$ajstot = $form->ajsmale + $form->ajsfemale;
						$vhftot = $form->vhfmale + $form->vhffemale;
						$malutot = $form->malufivemale + $form->malufivefemale;
						$malotot = $form->malofivemale+$form->malofivefemale;
						$mentot = $form->suspectedmenegitismale + $form->suspectedmenegitisfemale;
						$menofivetot = $form->suspectedmenegitisofivemale + $form->suspectedmenegitisofivefemale;
						$undistot = $form->undismale + $form->undisfemale;
						$undistwotot = $form->undismaletwo + $form->undisfemaletwo;
						$octot = $form->ocmale + $form->ocfemale;
						
			$table .= '<tr><td>'.$form->reporting_year.'</td><td>'.$form->week_no.'</td><td>'.$form->zone.'</td><td>'.$form->region.'</td><td>'.$form->district.'</td>
		<td>'.$form->organization.'</td><td>'.$form->health_facility.'</td><td>'.$form->health_facility_type.'</td><td>'.$form->hf_code.'</td><td>'.$iliutot.'</td><td>'.$iliotot.'</td><td>'.$sariutot.'</td><td>'.$sariotot.'</td>
		<td>'.$awdutot.'</td><td>'.$awdotot.'</td><td>'.$bdutot.'</td><td>'.$bdotot.'</td><td>'.$oadutot.'</td><td>'.$oadotot.'</td><td>'.$diphtot.'</td><td>'.$diphofivetot.'</td><td>'.$wctot.'</td><td>'.$wcofivetot.'</td><td>'.$meastot.'</td><td>'.$measofivetot.'</td><td>'.$nnttot.'</td><td>'.$afptot.'</td><td>'.$afpofivetot.'</td><td>'.$ajstot.'</td><td>'.$vhftot.'</td><td>'.$malutot.'</td><td>'.$malotot.'</td><td>'.$mentot.'</td><td>'.$menofivetot.'</td><td>'.$form->undisonedesc.'</td><td>'.$undistot.'</td><td>'.$form->undissecdesc.'</td><td>'.$undistwotot.'</td><td>'.$octot.'</td><td>'.$form->total_consultations.'</td><td>'.$form->sre.'</td><td>'.$form->pf.'</td><td>'.$form->pv.'</td><td>'.$form->pmix.'</td><td>'.$form->zonal_code.'</td>
		<td>'.$form->regional_code.'</td><td>'.$form->district_code.'</td><td>'.$form->entry_date.'</td><td>'.$form->entry_time.'</td><td>'.$form->username.'</td><td>'.$form->User_Contact.'</td><td>'.$form->edit_date.'</td><td>'.$form->edit_time.'</td>
		</tr>';
		
		}
		
		$table .= '</tbody></table>';
		
	
		$filename = "Weekly_Reporting_Forms_".date('dmY-his').".xls";
		
		$this->output->set_header("Content-Type: application/vnd.ms-word");
		$this->output->set_header("Expires: 0");
		$this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header("content-disposition: attachment;filename=".$filename."");
		
		
		$this->output->append_output($table);
		
	
   }

  function get_report(){
  
  $this->load->dbutil();
  $this->load->helper('file');
  // get the object
  $report = $this->exportmodel->index();
  //pass it to db utility function
  $new_report = $this->dbutil->csv_from_result($report);
 //Now use it to write file. write_file helper function will do it
 write_file('./csvfiles/csv_file.csv',$new_report);
 //Done
 
 
 $data = array();
 $this->load->view('reportingforms/exportretrieve', $data);
}

 function getdistricts()
   {
	   $region_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['region_id']))));
	   
	   $districts = $this->districtsmodel->get_by_region($region_id);
	   
	   $level = $this->erkanaauth->getField('level');
	   $reg_id = $this->erkanaauth->getField('region_id');
	  	   
	   $districtselect = '<select name="district_id" id="district_id" onChange="GetHealthFacilities(this)">';
	    	$districtselect .= '<option value="">Select District</option>';   
			$districtselect .= '<option value="">All Districts</option>';
		if(empty($districts))
		{
			/**
		   if($level==2)
		   {
			   $districtdata = $this->districtsmodel->get_by_region($reg_id);
			   foreach($districtdata as $dkey => $districtdatum)
			   {
				   $districtselect .= '<option value="'.$districtdatum['id'].'">'.$districtdatum['district'].'</option>';
			   }
		   }
		   elseif($level==1)
		   {
			   $zone_id = $this->erkanaauth->getField('zone_id');
			   $districtdata = $this->districtsmodel->get_zone_districts($zone_id);
			   foreach($districtdata as $dkey => $districtdatum)
			   {
				   $districtselect .= '<option value="'.$districtdatum->district_id.'">'.$districtdatum->district.'</option>';
			   }
		   }
		   else
		   {
			   
			   $districtdata = $this->districtsmodel->get_list();
				foreach($districtdata as $dkey => $districtdatum)
			   {
				   $districtselect .= '<option value="'.$districtdatum['id'].'">'.$districtdatum['district'].'</option>';
			   }
		   }
		   
		   **/
		   
		}
		else
		{
			foreach($districts as $key => $district)
		   {
			   $districtselect .= '<option value="'.$district['id'].'">'.$district['district'].'</option>';
		   }
		}
	   
	   $districtselect .= '</select>';
	   
	   echo $districtselect;
   }

}
