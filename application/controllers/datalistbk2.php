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
	 
	  if(getRole() != 'SuperAdmin' &&  $level !=2 && $level !=1 && $level !=4)
	  {

		redirect('home', 'refresh');

	  }
	   $data = array();
	   
		$data['level'] = $level;
		
		if(getRole() == 'SuperAdmin')
	  {

		$data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		  $data['zones'] = $this->zonesmodel->get_list();

	  }
	   
	   
	   if($level==2)//FP
	   {
		   $region_id = $this->erkanaauth->getField('region_id');
		   $region = $this->regionsmodel->get_by_id($region_id)->row();
		   $data['zone'] = $this->regionsmodel->get_by_id($region->zone_id)->row();
		   $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
		   $data['districts'] = $this->districtsmodel->get_by_region($region->id);
	   }
	   if($level==1)//zonal
	   {
		   $zone_id = $this->erkanaauth->getField('zone_id');
		   $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
		   $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
		   $data['districts'] = $this->districtsmodel->get_list();
	   }
	   
	   if($level==4)//national
	   {
		   $data['regions'] = $this->regionsmodel->get_list();
		 $data['districts'] = $this->districtsmodel->get_list();
		 $data['zones'] = $this->zonesmodel->get_list();
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
	   $gender = trim(addslashes(htmlspecialchars(rawurldecode($_POST['gender']))));
	   
	   //if(empty($reporting_year) || empty($reporting_year2) || empty($from) || empty($to) || empty($district_id)){
		   if(empty($reporting_year) || empty($reporting_year2) || empty($from) || empty($to)){
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
					
					if(!empty($district_id))
					{
						$lists = $this->reportingformsmodel->get_dist_list($reporting_year,$reporting_year2,$from,$to,$district_id);
					}
					else
					{
						$lists = $this->reportingformsmodel->get_data_list($reporting_year,$reporting_year2,$from,$to);
					}
				}
				else
				{
					if(empty($district_id))
					{
						$lists = $this->reportingformsmodel->get_hf_data_list($reporting_year,$reporting_year2,$from,$to,$healthfacility_id);
					}
					else
					{
						$lists = $this->reportingformsmodel->get_hf_dist_data_list($reporting_year,$reporting_year2,$from,$to,$healthfacility_id,$district_id);
					}
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
				
				if($gender==1)
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th >SARI >5yr</th><th >ILI <5yr</th><th >ILI >5yr</th><th >AWD <5yr</th><th >AWD >5yr</th><th >BD <5yr</th><th >BD >5yr</th><th >OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th >WC</th><th >Meas</th><th >NNT</th><th >AFP</th><th >AJS</th><th>VHF</th><th>Mal >5yr</th><th >Mal <5yr</th><th >Men</th><th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
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
						 
						
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
						
									
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$sariutot.'</td><td '.$saribg.'>'.$sariotot.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$iliutot.'</td><td '.$ilibg.'>'.$iliotot.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$awdutot.'</td><td '.$awdbg.'>'.$awdotot.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$bdutot.'</td><td '.$bdbg.'>'.$bdotot.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$oadutot.'</td><td '.$oadbg.'>'.$oadotot.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$diphtot.'</td><td '.$wcbg.'>'.$wctot.'</td>';
							
							$table .= '<td '.$measbg.'>'.$meastot.'</td><td '.$nntbg.'>'.$nnttot.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$afptot.'</td><td '.$ajsbg.'>'.$ajstot.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$vhftot.'</td><td '.$malbg.'>'.$malutot.'</td>';
							
							$table .= '<td '.$malbg.'>'.$malotot.'</td><td '.$menbg.'>'.$mentot.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$undistot.'</td><td '.$undisbg.'>'.$undistwotot.'</td>';
							
							$table .= '<td>'.$octot.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				else if($gender==2)
				{
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
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
				
				}
				else if($gender==3)//male
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th>SARI >5yr</th><th>ILI <5yr</th><th>ILI >5yr</th><th>AWD <5yr</th><th>AWD >5yr</th><th>BD <5yr</th><th>BD >5yr</th><th>OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th>WC</th><th>Meas</th><th>NNT</th><th>AFP</th><th>AJS</th><th>VHF</th><th>Mal >5yr</th><th>Mal <5yr</th><th>Men</th><th>UnDis</th><th>UnDis</th><th>OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
					</tr>';
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
						
											
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$list->sariufivemale.'</td><td '.$saribg.'>'.$list->sariofivemale.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$list->iliufivemale.'</td><td '.$ilibg.'>'.$list->iliofivemale.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$list->awdufivemale.'</td><td '.$awdbg.'>'.$list->awdofivemale.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$list->bdufivemale.'</td><td '.$bdbg.'>'.$list->bdofivemale.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$list->oadufivemale.'</td><td '.$oadbg.'>'.$list->oadofivemale.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$list->diphmale.'</td><td '.$wcbg.'>'.$list->wcmale.'</td>';
							
							$table .= '<td '.$measbg.'>'.$list->measmale.'</td><td '.$nntbg.'>'.$list->nntmale.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$list->afpmale.'</td><td '.$ajsbg.'>'.$list->ajsmale.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$list->vhfmale.'</td><td '.$malbg.'>'.$list->malufivemale.'</td>';
							
							$table .= '<td '.$malbg.'>'.$list->malofivemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitismale.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$list->undismale.'</td><td '.$undisbg.'>'.$list->undismaletwo.'</td>';
							
							$table .= '<td>'.$list->ocmale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				else //gender is female
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th>SARI >5yr</th><th>ILI <5yr</th><th>ILI >5yr</th><th>AWD <5yr</th><th>AWD >5yr</th><th>BD <5yr</th><th>BD >5yr</th><th>OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th>WC</th><th>Meas</th><th>NNT</th><th>AFP</th><th>AJS</th><th>VHF</th><th>Mal >5yr</th><th>Mal <5yr</th><th>Men</th><th>UnDis</th><th>UnDis</th><th>OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
					</tr>';
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
						
						
											
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$list->sariufivefemale.'</td><td '.$saribg.'>'.$list->sariofivefemale.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$list->iliufivefemale.'</td><td '.$ilibg.'>'.$list->iliofivefemale.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$list->awdufivefemale.'</td><td '.$awdbg.'>'.$list->awdofivefemale.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$list->bdufivefemale.'</td><td '.$bdbg.'>'.$list->bdofivefemale.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$list->oadufivefemale.'</td><td '.$oadbg.'>'.$list->oadofivefemale.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$list->diphfemale.'</td><td '.$wcbg.'>'.$list->wcfemale.'</td>';
							
							$table .= '<td '.$measbg.'>'.$list->measfemale.'</td><td '.$nntbg.'>'.$list->nntfemale.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$list->afpfemale.'</td><td '.$ajsbg.'>'.$list->ajsfemale.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$list->vhffemale.'</td><td '.$malbg.'>'.$list->malufivefemale.'</td>';
							
							$table .= '<td '.$malbg.'>'.$list->malofivefemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitisfemale.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$list->undisfemale.'</td><td '.$undisbg.'>'.$list->undisfemaletwo.'</td>';
							
							$table .= '<td>'.$list->ocfemale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				
				echo $table;
				
			}
		}
   }
   
   function validate($id,$reporting_year,$reporting_year2,$from,$to,$district_id,$gender)
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
				if($gender==1)
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th >SARI >5yr</th><th >ILI <5yr</th><th >ILI >5yr</th><th >AWD <5yr</th><th >AWD >5yr</th><th >BD <5yr</th><th >BD >5yr</th><th >OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th >WC</th><th >Meas</th><th >NNT</th><th >AFP</th><th >AJS</th><th>VHF</th><th>Mal >5yr</th><th >Mal <5yr</th><th >Men</th><th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
											
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$sariutot.'</td><td '.$saribg.'>'.$sariotot.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$iliutot.'</td><td '.$ilibg.'>'.$iliotot.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$awdutot.'</td><td '.$awdbg.'>'.$awdotot.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$bdutot.'</td><td '.$bdbg.'>'.$bdotot.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$oadutot.'</td><td '.$oadbg.'>'.$oadotot.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$diphtot.'</td><td '.$wcbg.'>'.$wctot.'</td>';
							
							$table .= '<td '.$measbg.'>'.$meastot.'</td><td '.$nntbg.'>'.$nnttot.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$afptot.'</td><td '.$ajsbg.'>'.$ajstot.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$vhftot.'</td><td '.$malbg.'>'.$malutot.'</td>';
							
							$table .= '<td '.$malbg.'>'.$malotot.'</td><td '.$menbg.'>'.$mentot.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$undistot.'</td><td '.$undisbg.'>'.$undistwotot.'</td>';
							
							$table .= '<td>'.$octot.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				else if($gender==2)
				{
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
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
				
				}
				else if($gender==3)//male
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th>SARI >5yr</th><th>ILI <5yr</th><th>ILI >5yr</th><th>AWD <5yr</th><th>AWD >5yr</th><th>BD <5yr</th><th>BD >5yr</th><th>OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th>WC</th><th>Meas</th><th>NNT</th><th>AFP</th><th>AJS</th><th>VHF</th><th>Mal >5yr</th><th>Mal <5yr</th><th>Men</th><th>UnDis</th><th>UnDis</th><th>OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
					</tr>';
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
											
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$list->sariufivemale.'</td><td '.$saribg.'>'.$list->sariofivemale.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$list->iliufivemale.'</td><td '.$ilibg.'>'.$list->iliofivemale.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$list->awdufivemale.'</td><td '.$awdbg.'>'.$list->awdofivemale.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$list->bdufivemale.'</td><td '.$bdbg.'>'.$list->bdofivemale.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$list->oadufivemale.'</td><td '.$oadbg.'>'.$list->oadofivemale.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$list->diphmale.'</td><td '.$wcbg.'>'.$list->wcmale.'</td>';
							
							$table .= '<td '.$measbg.'>'.$list->measmale.'</td><td '.$nntbg.'>'.$list->nntmale.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$list->afpmale.'</td><td '.$ajsbg.'>'.$list->ajsmale.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$list->vhfmale.'</td><td '.$malbg.'>'.$list->malufivemale.'</td>';
							
							$table .= '<td '.$malbg.'>'.$list->malofivemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitismale.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$list->undismale.'</td><td '.$undisbg.'>'.$list->undismaletwo.'</td>';
							
							$table .= '<td>'.$list->ocmale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				else //gender is female
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th>SARI >5yr</th><th>ILI <5yr</th><th>ILI >5yr</th><th>AWD <5yr</th><th>AWD >5yr</th><th>BD <5yr</th><th>BD >5yr</th><th>OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th>WC</th><th>Meas</th><th>NNT</th><th>AFP</th><th>AJS</th><th>VHF</th><th>Mal >5yr</th><th>Mal <5yr</th><th>Men</th><th>UnDis</th><th>UnDis</th><th>OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
					</tr>';
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
						
											
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$list->sariufivefemale.'</td><td '.$saribg.'>'.$list->sariofivefemale.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$list->iliufivefemale.'</td><td '.$ilibg.'>'.$list->iliofivefemale.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$list->awdufivefemale.'</td><td '.$awdbg.'>'.$list->awdofivefemale.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$list->bdufivefemale.'</td><td '.$bdbg.'>'.$list->bdofivefemale.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$list->oadufivefemale.'</td><td '.$oadbg.'>'.$list->oadofivefemale.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$list->diphfemale.'</td><td '.$wcbg.'>'.$list->wcfemale.'</td>';
							
							$table .= '<td '.$measbg.'>'.$list->measfemale.'</td><td '.$nntbg.'>'.$list->nntfemale.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$list->afpfemale.'</td><td '.$ajsbg.'>'.$list->ajsfemale.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$list->vhffemale.'</td><td '.$malbg.'>'.$list->malufivefemale.'</td>';
							
							$table .= '<td '.$malbg.'>'.$list->malofivefemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitisfemale.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$list->undisfemale.'</td><td '.$undisbg.'>'.$list->undisfemaletwo.'</td>';
							
							$table .= '<td>'.$list->ocfemale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				
				echo $table;
				
				
				
   }
   
   function invalidate($id,$reporting_year,$reporting_year2,$from,$to,$district_id,$gender)
   {
	     
		 $data = array(
		 	   'approved_hf' => 0,
               'approved_regional' => 0,
               'approved_zone' => 0,
           );
           $this->db->where('id', $id);
           $this->db->update('reportingforms', $data);
		   
		   echo $reporting_year;
		  
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
				if($gender==1)
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th >SARI >5yr</th><th >ILI <5yr</th><th >ILI >5yr</th><th >AWD <5yr</th><th >AWD >5yr</th><th >BD <5yr</th><th >BD >5yr</th><th >OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th >WC</th><th >Meas</th><th >NNT</th><th >AFP</th><th >AJS</th><th>VHF</th><th>Mal >5yr</th><th >Mal <5yr</th><th >Men</th><th>UnDis</th><th >UnDis</th><th >OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
											
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$sariutot.'</td><td '.$saribg.'>'.$sariotot.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$iliutot.'</td><td '.$ilibg.'>'.$iliotot.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$awdutot.'</td><td '.$awdbg.'>'.$awdotot.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$bdutot.'</td><td '.$bdbg.'>'.$bdotot.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$oadutot.'</td><td '.$oadbg.'>'.$oadotot.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$diphtot.'</td><td '.$wcbg.'>'.$wctot.'</td>';
							
							$table .= '<td '.$measbg.'>'.$meastot.'</td><td '.$nntbg.'>'.$nnttot.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$afptot.'</td><td '.$ajsbg.'>'.$ajstot.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$vhftot.'</td><td '.$malbg.'>'.$malutot.'</td>';
							
							$table .= '<td '.$malbg.'>'.$malotot.'</td><td '.$menbg.'>'.$mentot.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$undistot.'</td><td '.$undisbg.'>'.$undistwotot.'</td>';
							
							$table .= '<td>'.$octot.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				else if($gender==2)
				{
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
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
				
				}
				else if($gender==3)//male
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th>SARI >5yr</th><th>ILI <5yr</th><th>ILI >5yr</th><th>AWD <5yr</th><th>AWD >5yr</th><th>BD <5yr</th><th>BD >5yr</th><th>OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th>WC</th><th>Meas</th><th>NNT</th><th>AFP</th><th>AJS</th><th>VHF</th><th>Mal >5yr</th><th>Mal <5yr</th><th>Men</th><th>UnDis</th><th>UnDis</th><th>OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
					</tr>';
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>M</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
						
											
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$list->sariufivemale.'</td><td '.$saribg.'>'.$list->sariofivemale.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$list->iliufivemale.'</td><td '.$ilibg.'>'.$list->iliofivemale.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$list->awdufivemale.'</td><td '.$awdbg.'>'.$list->awdofivemale.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$list->bdufivemale.'</td><td '.$bdbg.'>'.$list->bdofivemale.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$list->oadufivemale.'</td><td '.$oadbg.'>'.$list->oadofivemale.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$list->diphmale.'</td><td '.$wcbg.'>'.$list->wcmale.'</td>';
							
							$table .= '<td '.$measbg.'>'.$list->measmale.'</td><td '.$nntbg.'>'.$list->nntmale.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$list->afpmale.'</td><td '.$ajsbg.'>'.$list->ajsmale.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$list->vhfmale.'</td><td '.$malbg.'>'.$list->malufivemale.'</td>';
							
							$table .= '<td '.$malbg.'>'.$list->malofivemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitismale.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$list->undismale.'</td><td '.$undisbg.'>'.$list->undismaletwo.'</td>';
							
							$table .= '<td>'.$list->ocmale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				else //gender is female
				{
					$table .= '<table id="listtable">';
					$table .= '<thead>';
					$table .= '<tr border><th>Week</th><th>HFC Name</th><th>SARI <5yr</th><th>SARI >5yr</th><th>ILI <5yr</th><th>ILI >5yr</th><th>AWD <5yr</th><th>AWD >5yr</th><th>BD <5yr</th><th>BD >5yr</th><th>OAD <5yr</th><th>OAD >5yr</th><th>Diph</th><th>WC</th><th>Meas</th><th>NNT</th><th>AFP</th><th>AJS</th><th>VHF</th><th>Mal >5yr</th><th>Mal <5yr</th><th>Men</th><th>UnDis</th><th>UnDis</th><th>OC</th><th>SRE</th><th>Pf</th>
					<th>Pv</th><th>Pmix</th><th>Cons</th><th>User</th><th>Validate</th>
					</tr>';
					$table .= '<tr><th>&nbsp;</th><th>&nbsp;</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>F</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th>
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
						 
						if(empty($oad))
						{
							$oadbg = '';
						}
						else
						{
							$oadbg = 'bgcolor="#FF0000"';
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
						
						
					
						$sariutot = $list->sariufivemale+$list->sariufivefemale;
						$sariotot = $list->sariofivemale + $list->sariofivefemale;
						$saritot =  $sariutot + $sariutot;
						$iliutot = $list->iliufivemale + $list->iliufivefemale;
						$iliotot = $list->iliofivemale + $list->iliofivefemale;
						$ilitot = $iliutot + $iliotot;
						$awdutot = $list->awdufivemale + $list->awdufivefemale;
						$awdotot = $list->awdofivemale + $list->awdofivefemale;
						$awdtot = $awdotot + $awdutot;
						$bdutot = $list->bdufivemale + $list->bdufivefemale;
						$bdotot = $list->bdofivemale + $list->bdofivefemale;
						$bdtot = $bdutot + $bdotot;
						$oadutot = $list->oadufivemale + $list->oadufivefemale;
						$oadotot = $list->oadofivemale + $list->oadofivefemale;
						$oadtot = $oadotot + $oadutot;
						$diphtot = $list->diphmale + $list->diphfemale;
						$wctot = $list->wcmale + $list->wcfemale;
						$meastot = $list->measmale + $list->measfemale;
						$nnttot = $list->nntmale + $list->nntfemale;
						$afptot = $list->afpmale + $list->afpfemale;
						$ajstot = $list->ajsmale + $list->ajsfemale;
						$vhftot = $list->vhfmale + $list->vhffemale;
						$malutot = $list->malufivemale + $list->malufivefemale;
						$malotot = $list->malofivemale+$list->malofivefemale;
						$mentot = $list->suspectedmenegitismale + $list->suspectedmenegitisfemale;
						$undistot = $list->undismale + $list->undisfemale;
						$undistwotot = $list->undismaletwo + $list->undisfemaletwo;
						$octot = $list->ocmale + $list->ocfemale;
						
						if($saritot>0)
						{
							
							$saribg = 'bgcolor="#FF0000"';
						}
						else
						{
							$saribg = '';
						}
						
						if(empty($ili))
						{
							$ilibg = '';
						}
						else
						{
							$ilibg = 'bgcolor="#FF0000"';
						}
						
						if($awdtot>0)
						{
							
							$awdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$awdbg = '';
						}
						
						if($bdtot>0)
						{
							
							$bdbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$bdbg = '';
						}
						
						if($diphtot>0)
						{
							
							$diphbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$diphbg = '';
						}
						
						if($wctot>4)
						{
							
							$wcbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$wcbg = '';
						}
						
						
						if($meastot>0)
						{
							
							$measbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$measbg = '';
						}
						
						if($nnttot>0)
						{
							$nntbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$nntbg = '';							
						}
						
						if($afptot>0)
						{
							
							$afpbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$afpbg = '';
						}
						
						if($ajstot>4)
						{
							
							$ajsbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$ajsbg = '';
						}
						
						if($vhftot>0)
						{
							
							$vhfbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$vhfbg = '';
						}
						
						
						if($mentot>1)
						{
							
							$menbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$menbg = '';
						}
						
						if($undistot>2)
						{
							
							$undisbg = 'bgcolor="#FF0000"';
						}
						else
						{
							$undisbg = '';
						}
						
											
							$table .= '<tr '.$class.'><td>'.$list->week_no.'/'.$list->reporting_year.'</td><td>'.$healthfacility->health_facility.'</td>';
							$table .= '<td '.$saribg.'>'.$list->sariufivefemale.'</td><td '.$saribg.'>'.$list->sariofivefemale.'</td>';
							
							$table .= '<td '.$ilibg.'>'.$list->iliufivefemale.'</td><td '.$ilibg.'>'.$list->iliofivefemale.'</td>';
							
							$table .= '<td '.$awdbg.'>'.$list->awdufivefemale.'</td><td '.$awdbg.'>'.$list->awdofivefemale.'</td>';
							
							$table .= '<td '.$bdbg.'>'.$list->bdufivefemale.'</td><td '.$bdbg.'>'.$list->bdofivefemale.'</td>';
							
							$table .= '<td '.$oadbg.'>'.$list->oadufivefemale.'</td><td '.$oadbg.'>'.$list->oadofivefemale.'</td>';
							
							$table .= '<td '.$diphbg.'>'.$list->diphfemale.'</td><td '.$wcbg.'>'.$list->wcfemale.'</td>';
							
							$table .= '<td '.$measbg.'>'.$list->measfemale.'</td><td '.$nntbg.'>'.$list->nntfemale.'</td>';
							
							$table .= '<td '.$afpbg.'>'.$list->afpfemale.'</td><td '.$ajsbg.'>'.$list->ajsfemale.'</td>';
							
							$table .= '<td '.$vhfbg.'>'.$list->vhffemale.'</td><td '.$malbg.'>'.$list->malufivefemale.'</td>';
							
							$table .= '<td '.$malbg.'>'.$list->malofivefemale.'</td><td '.$menbg.'>'.$list->suspectedmenegitisfemale.'</td>';
							
							$table .= '<td '.$undisbg.'>'.$list->undisfemale.'</td><td '.$undisbg.'>'.$list->undisfemaletwo.'</td>';
							
							$table .= '<td>'.$list->ocfemale.'</td><td>'.$list->sre.'</td><td>'.$list->pf.'</td>';
							
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
				}
				
				echo $table;
				
   }

  function gethealthfacilities()
   {
	   $district_id = trim(addslashes(htmlspecialchars(rawurldecode($_POST['district_id']))));
	   
	   $healthfailities = $this->healthfacilitiesmodel->get_by_district($district_id);
	  	   
	   $facilityselect = '<select name="healthfacility_id" id="healthfacility_id">';
	    $facilityselect .= '<option value="0">All Health Facilities</option>';
	   
	   if(empty($healthfacilities))
	   {
		   $healthfacilitydata = $this->healthfacilitiesmodel->get_list();
		   foreach($healthfacilitydata as $hkey => $healthfacilitydatum)
		   {
			   $facilityselect .= '<option value="'.$healthfacilitydatum['id'].'">'.$healthfacilitydatum['health_facility'].'</option>';
		   }
	   }
	   else
	   {
		   foreach($healthfailities as $key => $healthfacility)
		   {
			   $facilityselect .= '<option value="'.$healthfacility['id'].'">'.$healthfacility['health_facility'].'</option>';
		   }
	   }
	   
	   $facilityselect .= '</select>';
	   
	   echo $facilityselect;
									
   }

}
