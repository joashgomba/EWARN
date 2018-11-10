<?php

class Datalist extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('regionsmodel');
   }

   public function index()
   {
        //ensure that the user is logged in
	  if (!$this->erkanaauth->try_session_login()) {

    	redirect('login','refresh');

  	  }

	 $level = $this->erkanaauth->getField('level');
	 
	  if(getRole() != 'SuperAdmin' &&  $level !=2)

	  {

		redirect('home', 'refresh');

	  }
	   $data = array();
	   
	   $data['regions'] = $this->regionsmodel->get_list();
	   
	    $healthfacility_id = $this->erkanaauth->getField('healthfacility_id');
	   
	   $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row(); 
	   $district = $this->districtsmodel->get_by_id($healthfacility->district_id)->row();
	   
	   $region = $this->regionsmodel->get_by_id($district->region_id)->row();
	   
	    $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
	   
	   if(getRole() == 'SuperAdmin')
	   {
		   
		    $data['districts'] = $this->districtsmodel->get_list();
			
	   }
	   else
	   {
		  $data['districts'] = $this->districtsmodel-> get_by_region($region->id);
	   }
	   
	   $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
	   
	   
       $this->load->view('reportingforms/datalist', $data);
   }
   
   function getlist()
   {
	   $reporting_year = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year']))));
	   $reporting_year2 = trim(addslashes(htmlspecialchars(rawurldecode($_POST['reporting_year2']))));
	   $from = trim(addslashes(htmlspecialchars(rawurldecode($_POST['from']))));
	   $to = trim(addslashes(htmlspecialchars(rawurldecode($_POST['to']))));
	   $district_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
	   $healthfacility_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['healthfacility_id']))));
	   
	   if(empty($reporting_year) || empty($reporting_year2) || empty($from) || empty($to) || empty($district_id)){
			echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">Please select all the required data</div></td></tr>
                              </tbody>
                            </table>';
		}
		else
		{
		
			if($from>$to || $reporting_year>$reporting_year2)
			{
				echo '<table id="customers">
                             <tbody>
                             <tr><td><div class="alert alert-danger">The from year/week value cannot be greater than the to year/week value</div></td></tr>
                              </tbody>
                            </table>';
			}
			else
			{
				
				if(empty($healthfacility_id))
				{
					
					$lists = $this->reportingformsmodel->get_data_list($reporting_year,$reporting_year2,$from,$to);
				}
				else
				{
					$lists = $this->reportingformsmodel->get_hf_data_list($reporting_year,$reporting_year2,$from,$to,$healthfacility_id);
				}
				
								
				
				$table = '   <style>
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
				</style>';
				$table .= '<table id="listtable">';
				$table .= '<thead>';
				$table .= '<tr border><th>Week</th><th>HFC Name</th><th colspan="2">SARI <5yr</th><th colspan="2">SARI >5yr</th><th colspan="2">ILI <5yr</th><th colspan="2">ILI >5yr</th><th colspan="2">AWD <5yr</th><th colspan="2">AWD >5yr</th><th colspan="2">BD <5yr</th><th colspan="2">BD >5yr</th><th colspan="2">OAD <5yr</th><th colspan="2">OAD >5yr</th><th colspan="2">Diph</th><th colspan="2">WC</th><th colspan="2">Meas</th><th colspan="2">NNT</th><th colspan="2">AFP</th><th colspan="2">AJS</th><th colspan="2">VHF</th><th colspan="2">Mal >5yr</th><th colspan="2">Mal <5yr</th><th colspan="2">Men</th><th colspan="2">UnDis</th><th colspan="2">UnDis</th><th colspan="2">OC</th><th>SRE</th><th>Pf</th>
				<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
				</tr>';
				$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
				</tr>';
				$table .= '</thead>';
				$table .= '<tbody>';
				
				$class = 'class="alt"';
				
				if(empty($lists))
				{
					$table .= '<tr><td colspan="55">No Data Submitted from HFCs</td></tr>';
				}
				else
				{
				foreach ($lists as $key => $list) {
					
					$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
					$user = $this->usersmodel->get_by_id($list->user_id)->row();
					
					if($class == 'class="alt"')
					{
						$class = '';
					}
					else
					{
						$class = 'class="alt"';
					}
					
					//$alerts = $this->alertsmodel->get_list_report($list->id,$healthfacility_id);
					$sari = $this->alertsmodel->get_by_name_reporting_form('SARI',$list->id)->row();
					$ili = $this->alertsmodel->get_by_name_reporting_form('ILI',$list->id)->row();
					$awd = $this->alertsmodel->get_by_name_reporting_form('AWD',$list->id)->row();
					$bd = $this->alertsmodel->get_by_name_reporting_form('BD',$list->id)->row();
					$oad = $this->alertsmodel->get_by_name_reporting_form('OAD',$list->id)->row();
					$diph = $this->alertsmodel->get_by_name_reporting_form('Diph',$list->id)->row();
					$wc = $this->alertsmodel->get_by_name_reporting_form('WC',$list->id)->row();
					$meas = $this->alertsmodel->get_by_name_reporting_form('Meas',$list->id)->row();
					$nnt = $this->alertsmodel->get_by_name_reporting_form('NNT',$list->id)->row();
					$afp = $this->alertsmodel->get_by_name_reporting_form('AFP',$list->id)->row();
					$ajs = $this->alertsmodel->get_by_name_reporting_form('AJS',$list->id)->row();
					$vhf = $this->alertsmodel->get_by_name_reporting_form('VHF',$list->id)->row();
					$mal = $this->alertsmodel->get_by_name_reporting_form('Mal',$list->id)->row();
					$men = $this->alertsmodel->get_by_name_reporting_form('Men',$list->id)->row();
					$undis = $this->alertsmodel->get_by_name_reporting_form('UnDis',$list->id)->row();
					 
					if(empty($sari))
					{
						$saribg = '';
					}
					else
					{
						$saribg = 'bgcolor="#FF0000"';
					}
					
					if(empty($ili))
					{
						$ilibg = '';
					}
					else
					{
						$ilibg = 'bgcolor="#FF0000"';
					}
					
					if(empty($awd))
					{
						$awdbg = '';
					}
					else
					{
						$awdbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($bd))
					{
						$bdbg = '';
					}
					else
					{
						$bdbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($oad))
					{
						$oadbg = '';
					}
					else
					{
						$oadbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($diph))
					{
						$diphbg = '';
					}
					else
					{
						$diphbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($wc))
					{
						$wcbg = '';
					}
					else
					{
						$wcbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($meas))
					{
						$measbg = '';
					}
					else
					{
						$measbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($nnt))
					{
						$nntbg = '';
					}
					else
					{
						$nntbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($afp))
					{
						$afpbg = '';
					}
					else
					{
						$afpbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($ajs))
					{
						$ajsbg = '';
					}
					else
					{
						$ajsbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($vhf))
					{
						$vhfbg = '';
					}
					else
					{
						$vhfbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($mal))
					{
						$malbg = '';
					}
					else
					{
						$malbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($men))
					{
						$menbg = '';
					}
					else
					{
						$menbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($undis))
					{
						$undisbg = '';
					}
					else
					{
						$undisbg = 'bgcolor="#FF0000"';
					}
					
					
										
						$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
						$table .= '<td '.$saribg.'>'.$list->sariufivemale.'</td><td '.$saribg.'>'.$list->sariufivefemale.'</td><td '.$saribg.'>'.$list->sariofivemale.'</td><td '.$saribg.'>'.$list->sariofivefemale.'</td>';
						$table .= '<td '.$ilibg.'>'.$list->iliufivemale.'</td><td '.$ilibg.'>'.$list->iliufivefemale.'</td><td '.$ilibg.'>'.$list->iliofivemale.'</td><td '.$ilibg.'>'.$list->iliofivefemale.'</td>';
						$table .= '<td '.$awdbg.'>'.$list->awdufivemale.'</td><td '.$awdbg.'>'.$list->awdufivefemale.'</td><td '.$awdbg.'>'.$list->awdofivemale.'</td><td '.$awdbg.'>'.$list->awdofivefemale.'</td>';
						$table .= '<td '.$bdbg.'>'.$list->bdufivemale.'</td><td '.$bdbg.'>'.$list->bdufivefemale.'</td><td '.$bdbg.'>'.$list->bdofivemale.'</td><td '.$bdbg.'>'.$list->bdofivefemale.'</td>';
						$table .= '<td '.$oadbg.'>'.$list->oadufivemale.'</td><td '.$oadbg.'>'.$list->oadufivefemale.'</td><td '.$oadbg.'>'.$list->oadofivemale.'</td><td '.$oadbg.'>'.$list->oadofivefemale.'</td>';
						$table .= '<td '.$diphbg.'>'.$list->diphmale.'</td><td '.$diphbg.'>'.$list->diphfemale.'</td><td '.$wcbg.'>'.$list->wcmale.'</td><td '.$wcbg.'>'.$list->wcfemale.'</td>';
						$table .= '<td '.$measbg.'>'.$list->measmale.'</td><td '.$measbg.'>'.$list->measfemale.'</td><td '.$nntbg.'>'.$list->nntmale.'</td><td '.$nntbg.'>'.$list->nntfemale.'</td>';
						$table .= '<td '.$afpbg.'>'.$list->afpmale.'</td><td '.$afpbg.'>'.$list->afpfemale.'</td><td '.$ajsbg.'>'.$list->ajsmale.'</td><td '.$ajsbg.'>'.$list->ajsfemale.'</td>';
						$table .= '<td '.$vhfbg.'>'.$list->vhfmale.'</td><td '.$vhfbg.'>'.$list->vhffemale.'</td><td '.$malbg.'>'.$list->malufivemale.'</td><td '.$malbg.'>'.$list->malufivefemale.'</td>';
						$table .= '<td '.$malbg.'>'.$list->malofivemale.'</td><td '.$malbg.'>'.$list->malofivefemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitismale.'</td><td '.$menbg.'>'.$list->suspectedmenegitisfemale.'</td>';
						$table .= '<td '.$undisbg.'>'.$list->undismale.'</td><td '.$undisbg.'>'.$list->undisfemale.'</td><td '.$undisbg.'>'.$list->undismaletwo.'</td><td '.$undisbg.'>'.$list->undisfemaletwo.'</td>';
						$table .= '<td>'.$list->ocmale.'</td><td>'.$list->ocfemale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
						$table .= '<td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
						$table .= '<td>'.$user->username.'</td>';
						if($list->approved_regional==0)
						{
							$table .= '<td><a href="javascript:void(0)" class="btn btn-app radius-4">SMS</a> &nbsp;<a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-app radius-4">Validate</a></td>';
						}
						else
						{
							$table .= '<td><a href="javascript:void(0)" class="btn btn-app radius-4">SMS</a> &nbsp;<a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-app radius-4">Invalidate</a></td>';
						}
						$table .= '</tr>';
					}
				}
				$table .= '</tbody>';
				$table .= '</table>';
				
				echo $table;
				
			}
		}
   }
   
   function validate($id,$reporting_year,$reporting_year2,$from,$to,$district_id,$healthfacility_id)
   {
	     
		 $data = array(
		 	   'approved_hf' => 1,
               'approved_regional' => 1,
               'approved_zone' => 0,
           );
           $this->db->where('id', $id);
           $this->db->update('reportingforms', $data);
		   
		   if(empty($healthfacility_id))
				{
					
					$lists = $this->reportingformsmodel->get_data_list($reporting_year,$reporting_year2,$from,$to);
				}
				else
				{
					$lists = $this->reportingformsmodel->get_hf_data_list($reporting_year,$reporting_year2,$from,$to,$healthfacility_id);
				}
				
				
				$table = '   <style>
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
				</style>';
				$table .= '<table id="listtable">';
				$table .= '<thead>';
				$table .= '<tr border><th>Week</th><th>HFC Name</th><th colspan="2">SARI <5yr</th><th colspan="2">SARI >5yr</th><th colspan="2">ILI <5yr</th><th colspan="2">ILI >5yr</th><th colspan="2">AWD <5yr</th><th colspan="2">AWD >5yr</th><th colspan="2">BD <5yr</th><th colspan="2">BD >5yr</th><th colspan="2">OAD <5yr</th><th colspan="2">OAD >5yr</th><th colspan="2">Diph</th><th colspan="2">WC</th><th colspan="2">Meas</th><th colspan="2">NNT</th><th colspan="2">AFP</th><th colspan="2">AJS</th><th colspan="2">VHF</th><th colspan="2">Mal >5yr</th><th colspan="2">Mal <5yr</th><th colspan="2">Men</th><th colspan="2">UnDis</th><th colspan="2">UnDis</th><th colspan="2">OC</th><th>SRE</th><th>Pf</th>
				<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
				</tr>';
				$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
				</tr>';
				$table .= '</thead>';
				$table .= '<tbody>';
				
				$class = 'class="alt"';
				
				if(empty($lists))
				{
					$table .= '<tr><td colspan="55">No Data Submitted from HFCs</td></tr>';
				}
				else
				{
				foreach ($lists as $key => $list) {
					
					$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
					$user = $this->usersmodel->get_by_id($list->user_id)->row();
					
					if($class == 'class="alt"')
					{
						$class = '';
					}
					else
					{
						$class = 'class="alt"';
					}
					
					//$alerts = $this->alertsmodel->get_list_report($list->id,$healthfacility_id);
					$sari = $this->alertsmodel->get_by_name_reporting_form('SARI',$list->id)->row();
					$ili = $this->alertsmodel->get_by_name_reporting_form('ILI',$list->id)->row();
					$awd = $this->alertsmodel->get_by_name_reporting_form('AWD',$list->id)->row();
					$bd = $this->alertsmodel->get_by_name_reporting_form('BD',$list->id)->row();
					$oad = $this->alertsmodel->get_by_name_reporting_form('OAD',$list->id)->row();
					$diph = $this->alertsmodel->get_by_name_reporting_form('Diph',$list->id)->row();
					$wc = $this->alertsmodel->get_by_name_reporting_form('WC',$list->id)->row();
					$meas = $this->alertsmodel->get_by_name_reporting_form('Meas',$list->id)->row();
					$nnt = $this->alertsmodel->get_by_name_reporting_form('NNT',$list->id)->row();
					$afp = $this->alertsmodel->get_by_name_reporting_form('AFP',$list->id)->row();
					$ajs = $this->alertsmodel->get_by_name_reporting_form('AJS',$list->id)->row();
					$vhf = $this->alertsmodel->get_by_name_reporting_form('VHF',$list->id)->row();
					$mal = $this->alertsmodel->get_by_name_reporting_form('Mal',$list->id)->row();
					$men = $this->alertsmodel->get_by_name_reporting_form('Men',$list->id)->row();
					$undis = $this->alertsmodel->get_by_name_reporting_form('UnDis',$list->id)->row();
					 
					if(empty($sari))
					{
						$saribg = '';
					}
					else
					{
						$saribg = 'bgcolor="#FF0000"';
					}
					
					if(empty($ili))
					{
						$ilibg = '';
					}
					else
					{
						$ilibg = 'bgcolor="#FF0000"';
					}
					
					if(empty($awd))
					{
						$awdbg = '';
					}
					else
					{
						$awdbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($bd))
					{
						$bdbg = '';
					}
					else
					{
						$bdbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($oad))
					{
						$oadbg = '';
					}
					else
					{
						$oadbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($diph))
					{
						$diphbg = '';
					}
					else
					{
						$diphbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($wc))
					{
						$wcbg = '';
					}
					else
					{
						$wcbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($meas))
					{
						$measbg = '';
					}
					else
					{
						$measbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($nnt))
					{
						$nntbg = '';
					}
					else
					{
						$nntbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($afp))
					{
						$afpbg = '';
					}
					else
					{
						$afpbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($ajs))
					{
						$ajsbg = '';
					}
					else
					{
						$ajsbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($vhf))
					{
						$vhfbg = '';
					}
					else
					{
						$vhfbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($mal))
					{
						$malbg = '';
					}
					else
					{
						$malbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($men))
					{
						$menbg = '';
					}
					else
					{
						$menbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($undis))
					{
						$undisbg = '';
					}
					else
					{
						$undisbg = 'bgcolor="#FF0000"';
					}
					
					
										
						$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
						$table .= '<td '.$saribg.'>'.$list->sariufivemale.'</td><td '.$saribg.'>'.$list->sariufivefemale.'</td><td '.$saribg.'>'.$list->sariofivemale.'</td><td '.$saribg.'>'.$list->sariofivefemale.'</td>';
						$table .= '<td '.$ilibg.'>'.$list->iliufivemale.'</td><td '.$ilibg.'>'.$list->iliufivefemale.'</td><td '.$ilibg.'>'.$list->iliofivemale.'</td><td '.$ilibg.'>'.$list->iliofivefemale.'</td>';
						$table .= '<td '.$awdbg.'>'.$list->awdufivemale.'</td><td '.$awdbg.'>'.$list->awdufivefemale.'</td><td '.$awdbg.'>'.$list->awdofivemale.'</td><td '.$awdbg.'>'.$list->awdofivefemale.'</td>';
						$table .= '<td '.$bdbg.'>'.$list->bdufivemale.'</td><td '.$bdbg.'>'.$list->bdufivefemale.'</td><td '.$bdbg.'>'.$list->bdofivemale.'</td><td '.$bdbg.'>'.$list->bdofivefemale.'</td>';
						$table .= '<td '.$oadbg.'>'.$list->oadufivemale.'</td><td '.$oadbg.'>'.$list->oadufivefemale.'</td><td '.$oadbg.'>'.$list->oadofivemale.'</td><td '.$oadbg.'>'.$list->oadofivefemale.'</td>';
						$table .= '<td '.$diphbg.'>'.$list->diphmale.'</td><td '.$diphbg.'>'.$list->diphfemale.'</td><td '.$wcbg.'>'.$list->wcmale.'</td><td '.$wcbg.'>'.$list->wcfemale.'</td>';
						$table .= '<td '.$measbg.'>'.$list->measmale.'</td><td '.$measbg.'>'.$list->measfemale.'</td><td '.$nntbg.'>'.$list->nntmale.'</td><td '.$nntbg.'>'.$list->nntfemale.'</td>';
						$table .= '<td '.$afpbg.'>'.$list->afpmale.'</td><td '.$afpbg.'>'.$list->afpfemale.'</td><td '.$ajsbg.'>'.$list->ajsmale.'</td><td '.$ajsbg.'>'.$list->ajsfemale.'</td>';
						$table .= '<td '.$vhfbg.'>'.$list->vhfmale.'</td><td '.$vhfbg.'>'.$list->vhffemale.'</td><td '.$malbg.'>'.$list->malufivemale.'</td><td '.$malbg.'>'.$list->malufivefemale.'</td>';
						$table .= '<td '.$malbg.'>'.$list->malofivemale.'</td><td '.$malbg.'>'.$list->malofivefemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitismale.'</td><td '.$menbg.'>'.$list->suspectedmenegitisfemale.'</td>';
						$table .= '<td '.$undisbg.'>'.$list->undismale.'</td><td '.$undisbg.'>'.$list->undisfemale.'</td><td '.$undisbg.'>'.$list->undismaletwo.'</td><td '.$undisbg.'>'.$list->undisfemaletwo.'</td>';
						$table .= '<td>'.$list->ocmale.'</td><td>'.$list->ocfemale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
						$table .= '<td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
						$table .= '<td>'.$user->username.'</td>';
						if($list->approved_regional==0)
						{
							$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-app radius-4">Validate</a></td>';
						}
						else
						{
							$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-app radius-4">Invalidate</a></td>';
						}
						$table .= '</tr>';
					}
				}
				$table .= '</tbody>';
				$table .= '</table>';
				
				echo $table;
				
   }
   
   function invalidate($id,$reporting_year,$reporting_year2,$from,$to,$district_id,$healthfacility_id)
   {
	     
		 $data = array(
		 	   'approved_hf' => 0,
               'approved_regional' => 0,
               'approved_zone' => 0,
           );
           $this->db->where('id', $id);
           $this->db->update('reportingforms', $data);
		   
		   if(empty($healthfacility_id))
				{
					
					$lists = $this->reportingformsmodel->get_data_list($reporting_year,$reporting_year2,$from,$to);
				}
				else
				{
					$lists = $this->reportingformsmodel->get_hf_data_list($reporting_year,$reporting_year2,$from,$to,$healthfacility_id);
				}
				
				
				$table = '   <style>
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
				</style>';
				$table .= '<table id="listtable">';
				$table .= '<thead>';
				$table .= '<tr border><th>Week</th><th>HFC Name</th><th colspan="2">SARI <5yr</th><th colspan="2">SARI >5yr</th><th colspan="2">ILI <5yr</th><th colspan="2">ILI >5yr</th><th colspan="2">AWD <5yr</th><th colspan="2">AWD >5yr</th><th colspan="2">BD <5yr</th><th colspan="2">BD >5yr</th><th colspan="2">OAD <5yr</th><th colspan="2">OAD >5yr</th><th colspan="2">Diph</th><th colspan="2">WC</th><th colspan="2">Meas</th><th colspan="2">NNT</th><th colspan="2">AFP</th><th colspan="2">AJS</th><th colspan="2">VHF</th><th colspan="2">Mal >5yr</th><th colspan="2">Mal <5yr</th><th colspan="2">Men</th><th colspan="2">UnDis</th><th colspan="2">UnDis</th><th colspan="2">OC</th><th>SRE</th><th>Pf</th>
				<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
				</tr>';
				$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>M</th><th>F</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
				</tr>';
				$table .= '</thead>';
				$table .= '<tbody>';
				
				$class = 'class="alt"';
				
				if(empty($lists))
				{
					$table .= '<tr><td colspan="55">No Data Submitted from HFCs</td></tr>';
				}
				else
				{
				foreach ($lists as $key => $list) {
					
					$healthfacility = $this->healthfacilitiesmodel->get_by_id($list->healthfacility_id)->row();
					$user = $this->usersmodel->get_by_id($list->user_id)->row();
					
					if($class == 'class="alt"')
					{
						$class = '';
					}
					else
					{
						$class = 'class="alt"';
					}
					
					//$alerts = $this->alertsmodel->get_list_report($list->id,$healthfacility_id);
					$sari = $this->alertsmodel->get_by_name_reporting_form('SARI',$list->id)->row();
					$ili = $this->alertsmodel->get_by_name_reporting_form('ILI',$list->id)->row();
					$awd = $this->alertsmodel->get_by_name_reporting_form('AWD',$list->id)->row();
					$bd = $this->alertsmodel->get_by_name_reporting_form('BD',$list->id)->row();
					$oad = $this->alertsmodel->get_by_name_reporting_form('OAD',$list->id)->row();
					$diph = $this->alertsmodel->get_by_name_reporting_form('Diph',$list->id)->row();
					$wc = $this->alertsmodel->get_by_name_reporting_form('WC',$list->id)->row();
					$meas = $this->alertsmodel->get_by_name_reporting_form('Meas',$list->id)->row();
					$nnt = $this->alertsmodel->get_by_name_reporting_form('NNT',$list->id)->row();
					$afp = $this->alertsmodel->get_by_name_reporting_form('AFP',$list->id)->row();
					$ajs = $this->alertsmodel->get_by_name_reporting_form('AJS',$list->id)->row();
					$vhf = $this->alertsmodel->get_by_name_reporting_form('VHF',$list->id)->row();
					$mal = $this->alertsmodel->get_by_name_reporting_form('Mal',$list->id)->row();
					$men = $this->alertsmodel->get_by_name_reporting_form('Men',$list->id)->row();
					$undis = $this->alertsmodel->get_by_name_reporting_form('UnDis',$list->id)->row();
					 
					if(empty($sari))
					{
						$saribg = '';
					}
					else
					{
						$saribg = 'bgcolor="#FF0000"';
					}
					
					if(empty($ili))
					{
						$ilibg = '';
					}
					else
					{
						$ilibg = 'bgcolor="#FF0000"';
					}
					
					if(empty($awd))
					{
						$awdbg = '';
					}
					else
					{
						$awdbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($bd))
					{
						$bdbg = '';
					}
					else
					{
						$bdbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($oad))
					{
						$oadbg = '';
					}
					else
					{
						$oadbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($diph))
					{
						$diphbg = '';
					}
					else
					{
						$diphbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($wc))
					{
						$wcbg = '';
					}
					else
					{
						$wcbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($meas))
					{
						$measbg = '';
					}
					else
					{
						$measbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($nnt))
					{
						$nntbg = '';
					}
					else
					{
						$nntbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($afp))
					{
						$afpbg = '';
					}
					else
					{
						$afpbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($ajs))
					{
						$ajsbg = '';
					}
					else
					{
						$ajsbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($vhf))
					{
						$vhfbg = '';
					}
					else
					{
						$vhfbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($mal))
					{
						$malbg = '';
					}
					else
					{
						$malbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($men))
					{
						$menbg = '';
					}
					else
					{
						$menbg = 'bgcolor="#FF0000"';
					}
					
					if(empty($undis))
					{
						$undisbg = '';
					}
					else
					{
						$undisbg = 'bgcolor="#FF0000"';
					}
					
					
										
						$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
						$table .= '<td '.$saribg.'>'.$list->sariufivemale.'</td><td '.$saribg.'>'.$list->sariufivefemale.'</td><td '.$saribg.'>'.$list->sariofivemale.'</td><td '.$saribg.'>'.$list->sariofivefemale.'</td>';
						$table .= '<td '.$ilibg.'>'.$list->iliufivemale.'</td><td '.$ilibg.'>'.$list->iliufivefemale.'</td><td '.$ilibg.'>'.$list->iliofivemale.'</td><td '.$ilibg.'>'.$list->iliofivefemale.'</td>';
						$table .= '<td '.$awdbg.'>'.$list->awdufivemale.'</td><td '.$awdbg.'>'.$list->awdufivefemale.'</td><td '.$awdbg.'>'.$list->awdofivemale.'</td><td '.$awdbg.'>'.$list->awdofivefemale.'</td>';
						$table .= '<td '.$bdbg.'>'.$list->bdufivemale.'</td><td '.$bdbg.'>'.$list->bdufivefemale.'</td><td '.$bdbg.'>'.$list->bdofivemale.'</td><td '.$bdbg.'>'.$list->bdofivefemale.'</td>';
						$table .= '<td '.$oadbg.'>'.$list->oadufivemale.'</td><td '.$oadbg.'>'.$list->oadufivefemale.'</td><td '.$oadbg.'>'.$list->oadofivemale.'</td><td '.$oadbg.'>'.$list->oadofivefemale.'</td>';
						$table .= '<td '.$diphbg.'>'.$list->diphmale.'</td><td '.$diphbg.'>'.$list->diphfemale.'</td><td '.$wcbg.'>'.$list->wcmale.'</td><td '.$wcbg.'>'.$list->wcfemale.'</td>';
						$table .= '<td '.$measbg.'>'.$list->measmale.'</td><td '.$measbg.'>'.$list->measfemale.'</td><td '.$nntbg.'>'.$list->nntmale.'</td><td '.$nntbg.'>'.$list->nntfemale.'</td>';
						$table .= '<td '.$afpbg.'>'.$list->afpmale.'</td><td '.$afpbg.'>'.$list->afpfemale.'</td><td '.$ajsbg.'>'.$list->ajsmale.'</td><td '.$ajsbg.'>'.$list->ajsfemale.'</td>';
						$table .= '<td '.$vhfbg.'>'.$list->vhfmale.'</td><td '.$vhfbg.'>'.$list->vhffemale.'</td><td '.$malbg.'>'.$list->malufivemale.'</td><td '.$malbg.'>'.$list->malufivefemale.'</td>';
						$table .= '<td '.$malbg.'>'.$list->malofivemale.'</td><td '.$malbg.'>'.$list->malofivefemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitismale.'</td><td '.$menbg.'>'.$list->suspectedmenegitisfemale.'</td>';
						$table .= '<td '.$undisbg.'>'.$list->undismale.'</td><td '.$undisbg.'>'.$list->undisfemale.'</td><td '.$undisbg.'>'.$list->undismaletwo.'</td><td '.$undisbg.'>'.$list->undisfemaletwo.'</td>';
						$table .= '<td>'.$list->ocmale.'</td><td>'.$list->ocfemale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
						$table .= '<td>'.$list->pv.'</td><td>'.$list->pmix.'</td><td>'.$list->total_consultations.'</td>';
						$table .= '<td>'.$user->username.'</td>';
						if($list->approved_regional==0)
						{
							$table .= '<td><a href="javascript:void(0)" onclick="validateEntry('.$list->id.')" class="btn btn-app radius-4">Validate</a></td>';
						}
						else
						{
							$table .= '<td><a href="javascript:void(0)" onclick="invalidateEntry('.$list->id.')" class="btn btn-app radius-4">Invalidate</a></td>';
						}
						$table .= '</tr>';
					}
				}
				$table .= '</tbody>';
				$table .= '</table>';
				
				echo $table;
				
   }

  function gethealthfacilities()
   {
	   $district_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
	   
	   $healthfailities = $this->healthfacilitiesmodel->get_by_district($district_id);
	  	   
	   $facilityselect = '<select name="healthfacility_id" id="healthfacility_id">';
	    $facilityselect .= '<option value="0">All Health Facilities</option>';
	   
	   foreach($healthfailities as $key => $healthfacility)
       {
		   $facilityselect .= '<option value="'.$healthfacility['id'].'">'.$healthfacility['health_facility'].'</option>';
	   }
	   
	   $facilityselect .= '</select>';
	   
	   echo $facilityselect;
									
   }

}
