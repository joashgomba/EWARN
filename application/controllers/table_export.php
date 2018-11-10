<?php
class Table_export extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
		$this->load->model('exportmodel');
 
        // Here you should add some sort of user validation
        // to prevent strangers from pulling your table data
    }
 
    function index($table_name='reportingforms')
    {
        //$query = $this->db->get($table_name);
		
		$query = $this->exportmodel->index();
 
        if(!$query)
            return false;
 
        // Starting the PHPExcel library
       // $this->load->library('PHPExcel');
        //$this->load->library('PHPExcel/IOFactory');
		
		
		$this->load->library("Excel");
		
		// $objReader = PHPExcel_IOFactory::createReader('Excel2007');
		  //set to read only
		//  $objReader->setReadDataOnly(true);
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        // Field names in the first row
        $fields = $query->list_fields();
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
 
        // Fetching the table data
        $row = 2;
        foreach($query->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
 
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Weekly_Reporting_Forms_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
    }
	
	function mytest()
	{
		$forms = $this->exportmodel->get_report_records();
		
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
		<th>awd_lt_5</th><th>awd_gt_5</th><th>bd_lt_5</th><th>bd_gt_5</th><th>oad_lt_5</th><th>oad_gt_5</th><th>diph</th><th>wc</th><th>meas</th><th>nnt</th><th>afp</th><th>ajs</th><th>vhf</th><th>mal_lt_5</th><th>mal_gt_5</th><th>men</th><th>unDis_name</th><th>unDis_num</th><th>unDis_name</th><th>unDis_num</th><th>oc</th><th>total_cons_disease</th><th>sre</th><th>pf</th><th>pv</th><th>pmix</th><th>zon_code</th>
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
						$wctot = $form->wcmale + $form->wcfemale;
						$meastot = $form->measmale + $form->measfemale;
						$nnttot = $form->nntmale + $form->nntfemale;
						$afptot = $form->afpmale + $form->afpfemale;
						$ajstot = $form->ajsmale + $form->ajsfemale;
						$vhftot = $form->vhfmale + $form->vhffemale;
						$malutot = $form->malufivemale + $form->malufivefemale;
						$malotot = $form->malofivemale+$form->malofivefemale;
						$mentot = $form->suspectedmenegitismale + $form->suspectedmenegitisfemale;
						$undistot = $form->undismale + $form->undisfemale;
						$undistwotot = $form->undismaletwo + $form->undisfemaletwo;
						$octot = $form->ocmale + $form->ocfemale;
						
			$table .= '<tr><td>'.$form->reporting_year.'</td><td>'.$form->week_no.'</td><td>'.$form->zone.'</td><td>'.$form->region.'</td><td>'.$form->district.'</td>
		<td>'.$form->organization.'</td><td>'.$form->health_facility.'</td><td>'.$form->health_facility_type.'</td><td>'.$form->hf_code.'</td><td>'.$iliutot.'</td><td>'.$iliotot.'</td><td>'.$sariutot.'</td><td>'.$sariotot.'</td>
		<td>'.$awdutot.'</td><td>'.$awdotot.'</td><td>'.$bdutot.'</td><td>'.$bdotot.'</td><td>'.$oadutot.'</td><td>'.$oadotot.'</td><td>'.$diphtot.'</td><td>'.$wctot.'</td><td>'.$meastot.'</td><td>'.$nnttot.'</td><td>'.$afptot.'</td><td>'.$ajstot.'</td><td>'.$vhftot.'</td><td>'.$malutot.'</td><td>'.$malotot.'</td><td>'.$mentot.'</td><td>'.$form->undisonedesc.'</td><td>'.$undistot.'</td><td>'.$form->undissecdesc.'</td><td>'.$undistwotot.'</td><td>'.$octot.'</td><td>'.$form->total_consultations.'</td><td>'.$form->sre.'</td><td>'.$form->pf.'</td><td>'.$form->pv.'</td><td>'.$form->pmix.'</td><td>'.$form->zonal_code.'</td>
		<td>'.$form->regional_code.'</td><td>'.$form->district_code.'</td><td>'.$form->entry_date.'</td><td>'.$form->entry_time.'</td><td>'.$form->username.'</td><td>'.$form->User_Contact.'</td><td>'.$form->edit_date.'</td><td>'.$form->edit_time.'</td>
		</tr>';
		
		}
		
		$table .= '</tbody></table>';
		
		//echo $table;
		$filename = "Weekly_Reporting_Forms_".date('dmY-his').".xls";
		
		$this->output->set_header("Content-Type: application/vnd.ms-word");
		$this->output->set_header("Expires: 0");
		$this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header("content-disposition: attachment;filename=".$filename."");
		
		
		$this->output->append_output($table);
		
		 
		
	}
 
}