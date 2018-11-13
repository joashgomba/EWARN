<?php

class Analytics extends CI_Controller {

   function __construct()
   {
       parent::__construct();
       $this->load->model('reportsmodel');
   }

   public function index()
   {
       if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }

       $data = array();

       $level = $this->erkanaauth->getField('level');
       $country_id = $this->erkanaauth->getField('country_id');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

       if($level==2)//FP
       {

           $region_id = $this->erkanaauth->getField('region_id');
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['districts'] = $this->districtsmodel->get_by_region($region->id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

       }
       if($level==1)//zonal
       {
           $zone_id = $this->erkanaauth->getField('zone_id');
           $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
           $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;

       $diseasecount = $this->diseasesmodel->get_country_list($country_id);
       $limit = count($diseasecount);

       $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
       $data['diseases'] = $diseases;


       $this->load->view('analytics/index', $data);
   }

   public function epicurve(){

       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $data = array();

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reporting_year');
       $from = $this->input->post('week_no');
       $reporting_year2 = $this->input->post('reporting_year2');
       $to = $this->input->post('week_no2');


       $country_id = $this->erkanaauth->getField('country_id');

       $level = $this->erkanaauth->getField('level');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

       if($level==2)//FP
       {

           $region_id = $this->erkanaauth->getField('region_id');
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['districts'] = $this->districtsmodel->get_by_region($region->id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

       }
       if($level==1)//zonal
       {
           $zone_id = $this->erkanaauth->getField('zone_id');
           $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
           $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;

       $diseasecount = $this->diseasesmodel->get_country_list($country_id);
       $limit = count($diseasecount);

       $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
       $data['diseases'] = $diseases;


       if(empty($zone_id))
       {
           $zon_id = 0;
           $data['thezone'] = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['thezone'] = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $data['theregion'] = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['theregion'] = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $data['thedistrict'] = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $data['thedistrict'] = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $data['thehealthfacility'] = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $data['thehealthfacility'] = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $start_date = $reportingperiod_one->from;

       $end_date = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

       $epicalendaridArray = array();

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;

       }

       $diseseinterestarray = array();

       $mydiseases = $this->input->post('disease');

       if(empty($mydiseases))
       {
           $diseseinterestarray[] = 1;
       }
       else{
           foreach ($mydiseases as $key=>$mydisease):

               $diseseinterestarray[] = $mydisease;

           endforeach;

       }


       //$interest_lists = $this->formsdatamodel->disease_interest_epi_numbers($epicalendaridArray,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);
       //$interest_lists = $this->reportsmodel->get_full_list_case_epi_week($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);
       $interestseries = '';
       $interestcategory = '';


       foreach($diseseinterestarray as $key=>$diseaseinterestcode):


           $interestseries .= '{';
           $interestseries .= "name: '".$diseaseinterestcode."',";
           $interestseries .= 'data: [';

           $diseaselists = $this->reportsmodel->get_list_disease_sum($epicalendaridArray, $dist_id, $reg_id, $zon_id, $hf_id,$diseaseinterestcode);
           foreach($diseaselists as $key=>$diseaselist)
           {
               $interestseries .= $diseaselist->Disease_Total.',';
           }

           $interestseries .= ']';

           $interestseries .= '},';

       endforeach;


       $lists = $this->reportsmodel->get_full_list_case_epi_week($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);

       $table = '<table id="datatable" border="1"><thead>';
       $table .= '
		<tr>
		<th>&nbsp;</th>';

       foreach ($mydiseases as $key=>$mydisease):

           $table .= '<th>'.$mydisease.'</th>';

       endforeach;


       $table .= '</tr>
		</thead>
		<tbody>';

       $bgcolor = 'bgcolor="#CCCCCC"';
       foreach ($lists as $key => $list) {

           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }

           $table .= '<tr '.$bgcolor.'>';

           $table .= '<th>Wk'.$list->week_no.' '.$list->reporting_year.'</th>';
           $interestcategory .= "'WK.".$list->week_no."',";

           foreach ($mydiseases as $key=>$mydisease):
               $disease_element = $mydisease;
               $table .= '<td>'.$list->$disease_element.'</td>';

               unset($disease_element);

           endforeach;


           $table .= '</tr>';

       }


       $table .= '
		</tbody>
		</table>';

       unset($bgcolor);

       $data['interestseries'] = $interestseries;
       $data['interestcategory'] = $interestcategory;
       $data['diseases'] = $diseases;
       $data['reporting_year'] = $reporting_year;
       $data['from'] = $from;
       $data['reporting_year2'] = $reporting_year2;
       $data['to'] = $to;
       $data['table'] = $table;

       $data['zone_id'] = $zon_id;
       $data['region_id'] = $reg_id;
       $data['district_id'] = $dist_id;
       $data['healthfacility_id'] = $hf_id;
       $data['mydiseases'] = $mydiseases;


       $this->load->view('analytics/epicurve', $data);


   }

   public function exportcurve()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login', 'refresh');

       }

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reportingyear');
       $from = $this->input->post('from');
       $reporting_year2 = $this->input->post('reportingyear2');
       $to = $this->input->post('to');


       $country_id = $this->erkanaauth->getField('country_id');

       if(empty($zone_id))
       {
           $zon_id = 0;
           $thezone = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $thezone = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $theregion = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $theregion = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $thedistrict = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $thedistrict = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $thehealthfacility = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $thehealthfacility = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $start_date = $reportingperiod_one->from;

       $end_date = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

       $epicalendaridArray = array();

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;

       }

       $diseseinterestarray = array();

       $mydiseases = $this->input->post('mydisease');

       foreach ($mydiseases as $key=>$mydisease):

           $diseseinterestarray[] = $mydisease;

       endforeach;

       $count = count($mydiseases);
       $colspan = $count+1;


       $lists = $this->reportsmodel->get_full_list_case_epi_week($reporting_year,$reporting_year2,$epicalendaridArray,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);


       $table = '<table id="datatable" border="1" width="100%"><thead>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="'.$colspan.'"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="'.$colspan.'">Breakdown of diseases from '.$reporting_year.' week '.$from.' to '.$reporting_year2.' week '.$to.'</th></tr>';
       $table .= '
		<tr bgcolor="#13C3E6">
		<th>EPI Week</th>';

       foreach ($mydiseases as $key=>$mydisease):

           $table .= '<th>'.$mydisease.'</th>';

       endforeach;


       $table .= '</tr>
		</thead>
		<tbody>';

       $bgcolor = 'bgcolor="#CCCCCC"';
       foreach ($lists as $key => $list) {

           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }

           $table .= '<tr '.$bgcolor.'>';

           $table .= '<td>Wk'.$list->week_no.' '.$list->reporting_year.'</td>';

           foreach ($mydiseases as $key=>$mydisease):
               $disease_element = $mydisease;
               $table .= '<td>'.$list->$disease_element.'</td>';

               unset($disease_element);

           endforeach;


           $table .= '</tr>';

       }


       $table .= '
		</tbody>
		</table>';

       unset($bgcolor);


       $filename = "Disease_EPI_Curve_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");


       $this->output->append_output($table);

   }

   public function consultations()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login', 'refresh');

       }

       $data = array();

       $level = $this->erkanaauth->getField('level');
       $country_id = $this->erkanaauth->getField('country_id');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

       if($level==2)//FP
       {

           $region_id = $this->erkanaauth->getField('region_id');
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['districts'] = $this->districtsmodel->get_by_region($region->id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

       }
       if($level==1)//zonal
       {
           $zone_id = $this->erkanaauth->getField('zone_id');
           $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
           $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;

       $diseasecount = $this->diseasesmodel->get_country_list($country_id);
       $limit = count($diseasecount);

       $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
       $data['diseases'] = $diseases;


       $this->load->view('analytics/consultations', $data);
   }

   public function consultationsreport()
   {

       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $data = array();

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reporting_year');
       $from = $this->input->post('week_no');
       $reporting_year2 = $this->input->post('reporting_year2');
       $to = $this->input->post('week_no2');


       $country_id = $this->erkanaauth->getField('country_id');

       $level = $this->erkanaauth->getField('level');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

       if($level==2)//FP
       {

           $region_id = $this->erkanaauth->getField('region_id');
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['districts'] = $this->districtsmodel->get_by_region($region->id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

       }
       if($level==1)//zonal
       {
           $zone_id = $this->erkanaauth->getField('zone_id');
           $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
           $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;


       if(empty($zone_id))
       {
           $zon_id = 0;
           $data['thezone'] = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['thezone'] = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $data['theregion'] = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['theregion'] = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $data['thedistrict'] = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $data['thedistrict'] = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $data['thehealthfacility'] = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $data['thehealthfacility'] = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $start_date = $reportingperiod_one->from;

       $end_date = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

       $epicalendaridArray = array();

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;

       }

       $categories = '';
       $consultations_column = '';
       $reporting_sites_column = '';

       $table = '<table id="datatable" border="1"><thead>';
       $table .= '<tr><th>Week No.</th><th>Reporting Sites</th><th>Consultations</th></tr></thead>';

       $bgcolor = 'bgcolor="#CCCCCC"';

       foreach($epilists as $key=>$epi_list)
       {
           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }

           $consultations = $this->formsmodel->getconsultations($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);
           $reporting_sites = $this->formsmodel->getreportingsites($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);

           $categories .=  "'WK.".$epi_list->week_no."',";
           $consultations_column .= $consultations.',';
           $reporting_sites_column .= $reporting_sites.',';

           $table .= '<tr '.$bgcolor.'><td>WK.'.$epi_list->week_no.'</td><td>'.$reporting_sites.'</td><td>'.$consultations.'</td></tr>';

       }

       $healthfacilities = $this->healthfacilitiesmodel->get_list_by_country($country_id);

       $total_facilities = count($healthfacilities);

       $table .= '</table>';

       //$lists = $this->reportsmodel->get_full_list_case_epi_week($epicalendaridArray,$dist_id,$reg_id,$zon_id);

       $data['table'] = $table;
       $data['total_facilities'] = $total_facilities;
       $data['categories'] = $categories;
       $data['consultations_column'] = $consultations_column;
       $data['reporting_sites_column'] = $reporting_sites_column;
       $data['reporting_year'] = $reporting_year;
       $data['from'] = $from;
       $data['reporting_year2'] = $reporting_year2;
       $data['to'] = $to;
       $data['zone_id'] = $zon_id;
       $data['region_id'] = $reg_id;
       $data['district_id'] = $dist_id;

       $this->load->view('analytics/consultationsreport', $data);

   }

   public function exportconsultation()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $reporting_year = $this->input->post('reportingyear');
       $from = $this->input->post('from');
       $reporting_year2 = $this->input->post('reportingyear2');
       $to = $this->input->post('to');

       $country_id = $this->erkanaauth->getField('country_id');

       if(empty($zone_id))
       {
           $zon_id = 0;
           $thezone = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $thezone = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $theregion = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $theregion = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $thedistrict = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $thedistrict = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $thehealthfacility = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $thehealthfacility = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $start_date = $reportingperiod_one->from;

       $end_date = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

       $epicalendaridArray = array();

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;

       }


       $table = '<table id="datatable" border="1" width="100%"><thead>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="3"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="3">Breakdown of reporting sites and consultations from '.$reporting_year.' week '.$from.' to '.$reporting_year2.' week '.$to.'</th></tr>';
       $table .= '<tr><th>Week No.</th><th>Reporting Sites</th><th>Consultations</th></tr></thead>';

       $bgcolor = 'bgcolor="#CCCCCC"';

       foreach($epilists as $key=>$epi_list)
       {
           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }

           $consultations = $this->formsmodel->getconsultations($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);
           $reporting_sites = $this->formsmodel->getreportingsites($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);

           $table .= '<tr '.$bgcolor.'><td>WK.'.$epi_list->week_no.'</td><td>'.$reporting_sites.'</td><td>'.$consultations.'</td></tr>';

       }

       $table .= '</table>';


       unset($bgcolor);


       $filename = "Consultations_vs_Reporting_Sites_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");


       $this->output->append_output($table);
   }

   public function caseproportion()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login', 'refresh');

       }

       $data = array();

       $level = $this->erkanaauth->getField('level');
       $country_id = $this->erkanaauth->getField('country_id');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

       if($level==2)//FP
       {

           $region_id = $this->erkanaauth->getField('region_id');
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['districts'] = $this->districtsmodel->get_by_region($region->id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

       }
       if($level==1)//zonal
       {
           $zone_id = $this->erkanaauth->getField('zone_id');
           $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
           $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;

       $diseasecount = $this->diseasesmodel->get_country_list($country_id);
       $limit = count($diseasecount);

       $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
       $data['diseases'] = $diseases;


       $this->load->view('analytics/caseproportion', $data);
   }

   public function caseproportionreport()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $data = array();

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reporting_year');
       $from = $this->input->post('week_no');
       $reporting_year2 = $this->input->post('reporting_year2');
       $to = $this->input->post('week_no2');


       $country_id = $this->erkanaauth->getField('country_id');

       $level = $this->erkanaauth->getField('level');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

       if($level==2)//FP
       {

           $region_id = $this->erkanaauth->getField('region_id');
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['districts'] = $this->districtsmodel->get_by_region($region->id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

       }
       if($level==1)//zonal
       {
           $zone_id = $this->erkanaauth->getField('zone_id');
           $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
           $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;

       $diseasecount = $this->diseasesmodel->get_country_list($country_id);
       $limit = count($diseasecount);

       $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
       $data['diseases'] = $diseases;


       if(empty($zone_id))
       {
           $zon_id = 0;
           $data['thezone'] = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['thezone'] = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $data['theregion'] = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['theregion'] = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $data['thedistrict'] = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $data['thedistrict'] = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $data['thehealthfacility'] = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $data['thehealthfacility'] = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $start_date = $reportingperiod_one->from;

       $end_date = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

       $epicalendaridArray = array();

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;

       }

       $categories = '';

       foreach($epilists as $key=>$epi_list)
       {
           $categories .=  "'WK.".$epi_list->week_no."',";

       }


       $diseseinterestarray = array();

       $mydiseases = $this->input->post('disease');

       $label = '';

       if(empty($mydiseases))
       {
           $diseseinterestarray[] = 1;
       }
       else{
           foreach ($mydiseases as $key=>$mydisease):

               $diseseinterestarray[] = $mydisease;
               $label .= $mydisease.", ";

           endforeach;

       }


       $series = '';



       $average_lists = $this->formsmodel->get_diseases_average($start_date,$end_date,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);

       foreach($diseseinterestarray as $key=>$mydiseasecode):

           $series .= '{';
           $series .= "name: '".$mydiseasecode."',";
           $series .= 'data: [';

           $average = $mydiseasecode.'_average';

           foreach($average_lists as $key=>$average_list)
           {
               $series .= number_format($average_list->$average).',';

           }


           $series .= ']';

           $series .= '},';

       endforeach;

       $render = $this->input->post('render');

       $table = '<table id="datatable" border="1"><thead>';
       $table .= '
		<tr>
		<th>EPI Week</th>';

       foreach ($mydiseases as $key=>$mydisease):

           $table .= '<th>'.$mydisease.'</th>';

       endforeach;


       $table .= '</tr>
		</thead>
		<tbody>';


       $bgcolor = 'bgcolor="#CCCCCC"';
       foreach($epilists as $key=>$epi_list)
       {
           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }

           $table .=  "<tr ".$bgcolor."><td>WK.".$epi_list->week_no."</td>";


           foreach($diseseinterestarray as $key=>$mydiseasecode):

               $average = $mydiseasecode.'_average';

               foreach($average_lists as $key=>$average_list)
               {
                   if($epi_list->week_no==$average_list->week_no)
                   {
                       $table .= '<td>'.number_format($average_list->$average).'%</td>';
                   }

               }

           endforeach;

       }

       $table .= '</tr>';

       $table .= '</tbody></table>';

       $data['series'] = $series;
       $data['label'] = $label;
       $data['categories'] = $categories;
       $data['diseases'] = $diseases;
       $data['reporting_year'] = $reporting_year;
       $data['from'] = $from;
       $data['reporting_year2'] = $reporting_year2;
       $data['to'] = $to;
       $data['render'] = $render;

       $data['zone_id'] = $zon_id;
       $data['region_id'] = $reg_id;
       $data['district_id'] = $dist_id;
       $data['healthfacility_id'] = $hf_id;
       $data['mydiseases'] = $mydiseases;
       $data['table'] = $table;

       $this->load->view('analytics/caseproportionreport', $data);


   }

   public function exportcaseproportion()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $data = array();

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reportingyear');
       $from = $this->input->post('from');
       $reporting_year2 = $this->input->post('reportingyear2');
       $to = $this->input->post('to');


       $country_id = $this->erkanaauth->getField('country_id');


       if(empty($zone_id))
       {
           $zon_id = 0;
           $thezone = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $thezone = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $theregion = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $theregion = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $thedistrict = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $thedistrict = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $thehealthfacility = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $thehealthfacility = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $start_date = $reportingperiod_one->from;

       $end_date = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

       $epicalendaridArray = array();

       foreach($epilists as $key=>$epilist)
       {
           $epicalendaridArray[] =  $epilist->id;

       }

       $categories = '';

       foreach($epilists as $key=>$epi_list)
       {
           $categories .=  "'WK.".$epi_list->week_no."',";

       }


       $diseseinterestarray = array();

       $mydiseases = $this->input->post('mydisease');


       if(empty($mydiseases))
       {
           $diseseinterestarray[] = 1;
       }
       else{
           foreach ($mydiseases as $key=>$mydisease):

               $diseseinterestarray[] = $mydisease;

           endforeach;

       }


       $average_lists = $this->formsmodel->get_diseases_average($start_date,$end_date,$country_id,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);

       $count = count($mydiseases);
       $table = '<table id="datatable" border="1" width="100%"><thead>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="'.$count.'"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="'.$count.'">Breakdown of proportion of cases by EPI week from '.$reporting_year.' week '.$from.' to '.$reporting_year2.' week '.$to.'</th></tr>';

       $table .= '
		<tr bgcolor="#13C3E6">
		<th>EPI Week</th>';

       foreach ($mydiseases as $key=>$mydisease):

           $table .= '<th>'.$mydisease.'</th>';

       endforeach;


       $table .= '</tr>
		</thead>
		<tbody>';


       $bgcolor = 'bgcolor="#CCCCCC"';
       foreach($epilists as $key=>$epi_list)
       {
           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }

           $table .=  "<tr ".$bgcolor."><td>WK.".$epi_list->week_no."</td>";


           foreach($diseseinterestarray as $key=>$mydiseasecode):

               $average = $mydiseasecode.'_average';

               foreach($average_lists as $key=>$average_list)
               {
                   if($epi_list->week_no==$average_list->week_no)
                   {
                       $table .= '<td>'.number_format($average_list->$average).'%</td>';
                   }

               }

           endforeach;

       }

       $table .= '</tr>';

       $table .= '</tbody></table>';


       $filename = "Propotion_morbidity_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");
       $this->output->append_output($table);


   }

    public function completeness()
    {
        if (!$this->erkanaauth->try_session_login()) {

            redirect('login', 'refresh');

        }

        $data = array();

        $level = $this->erkanaauth->getField('level');
        $country_id = $this->erkanaauth->getField('country_id');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;

        $diseasecount = $this->diseasesmodel->get_country_list($country_id);
        $limit = count($diseasecount);

        $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
        $data['diseases'] = $diseases;


        $this->load->view('analytics/completeness', $data);
    }

   public function completenessreport()
   {

       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $data = array();

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reporting_year');
       $from = $this->input->post('week_no');
       $reporting_year2 = $this->input->post('reporting_year2');
       $to = $this->input->post('week_no2');


       $country_id = $this->erkanaauth->getField('country_id');

       $level = $this->erkanaauth->getField('level');

       if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

           redirect('home', 'refresh');

       }

       if ($level == 6) {//District
           $district_id = $this->erkanaauth->getField('district_id');
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $region = $this->regionsmodel->get_by_id($district->region_id)->row();
           $data['district'] = $district;
           $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
       }

       if($level==2)//FP
       {

           $region_id = $this->erkanaauth->getField('region_id');
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
           $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
           $data['districts'] = $this->districtsmodel->get_by_region($region->id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

       }
       if($level==1)//zonal
       {
           $zone_id = $this->erkanaauth->getField('zone_id');
           $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
           $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
       }

       if($level==4)//national
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_country_list($country_id);
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       if($level==5)//stakeholder
       {
           $data['regions'] = $this->regionsmodel->get_list();
           $data['districts'] = $this->districtsmodel->get_list();
           $data['zones'] = $this->zonesmodel->get_list();
           $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
       }

       $data['level'] = $level;


       if(empty($zone_id))
       {
           $zon_id = 0;
           $data['thezone'] = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $data['thezone'] = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $data['theregion'] = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $data['theregion'] = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $data['thedistrict'] = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $data['thedistrict'] = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $data['thehealthfacility'] = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $data['thehealthfacility'] = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $start_date = $reportingperiod_one->from;

       $end_date = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

       $epicalendaridArray = array();

       $healthfacilities = $this->healthfacilitiesmodel->get_list_by_admin_regions($country_id,$zone_id,$region_id,$district_id);

       $total_facilities = count($healthfacilities);

       $categories = '';
       $reporting_sites_column = '';
       $timeliness_column = '';
       $completeness_column = '';
       $table = '<table id="datatable" border="1"><thead>';
       $table .= '<tr><th>EPI Week</th><th>Sentinal Sites</th><th>Timeliness</th><th>Compliteness</th></tr>';
       $table .= '</theaad>';
       $table .= '</tbody>';

       $bgcolor = 'bgcolor="#CCCCCC"';

       foreach($epilists as $key=>$epilist)
       {
           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }

           $epicalendaridArray[] =  $epilist->id;
           $categories .=  "'WK.".$epilist->week_no."',";

           $reporting_sites = $this->formsmodel->getreportingsites($epilist->id, $dist_id,$reg_id,$zon_id,$hf_id);

           $timely_reporting_sites = $this->formsmodel->gettimelyreportingsites($epilist->id, $dist_id,$reg_id,$zon_id,$hf_id);

           if($reporting_sites==0)
           {
               $percentage_timeliness = 0;
           }
           else{
               $percentage_timeliness = ($timely_reporting_sites/$reporting_sites)*100;
           }

           $percentage_completeness = ($reporting_sites/$total_facilities)*100;

           $reporting_sites_column .= $reporting_sites.',';
           $timeliness_column .= number_format($percentage_timeliness).',';
           $completeness_column .= number_format($percentage_completeness).',';

           $table .= '<tr '.$bgcolor.'><td>Wk.'.$epilist->week_no.'</td><td>'.$reporting_sites .'</td><td>'.number_format($percentage_timeliness).'%</td><td>'.number_format($percentage_completeness).'%</td></tr>';

       }

       $table .= '</tbody></table>';


       $data['reporting_year'] = $reporting_year;
       $data['from'] = $from;
       $data['reporting_year2'] = $reporting_year2;
       $data['to'] = $to;
       $data['reporting_sites_column'] = $reporting_sites_column;
       $data['categories'] = $categories;
       $data['timeliness_column'] = $timeliness_column;
       $data['completeness_column'] = $completeness_column;
       $data['zone_id'] = $zon_id;
       $data['region_id'] = $reg_id;
       $data['district_id'] = $dist_id;
       $data['healthfacility_id'] = $hf_id;
       $data['table'] = $table;

       $this->load->view('analytics/completenessreport', $data);

   }

   public function exportcompleteness()
   {
       if (!$this->erkanaauth->try_session_login()) {

           redirect('login','refresh');

       }

       $data = array();

       $zone_id = $this->input->post('zone_id');
       $region_id = $this->input->post('region_id');
       $district_id = $this->input->post('district_id');
       $healthfacility_id = $this->input->post('healthfacility_id');

       $reporting_year = $this->input->post('reportingyear');
       $from = $this->input->post('from');
       $reporting_year2 = $this->input->post('reportingyear2');
       $to = $this->input->post('to');


       $country_id = $this->erkanaauth->getField('country_id');

       if(empty($zone_id))
       {
           $zon_id = 0;
           $thezone = 'All';
       }
       else
       {
           $zon_id = $zone_id;
           $zone = $this->zonesmodel->get_by_id($zone_id)->row();
           $thezone = $zone->zone;
       }

       if(empty($region_id))
       {
           $reg_id = 0;
           $theregion = 'All';
       }
       else
       {
           $reg_id = $region_id;
           $region = $this->regionsmodel->get_by_id($region_id)->row();
           $theregion = $region->region;
       }

       if(empty($district_id))
       {
           $dist_id = 0;
           $thedistrict = 'All';
       }
       else
       {
           $dist_id = $district_id;
           $district = $this->districtsmodel->get_by_id($district_id)->row();
           $thedistrict = $district->district;
       }

       if(empty($healthfacility_id))
       {
           $hf_id = 0;
           $thehealthfacility = 'All';
       }
       else
       {
           $hf_id = $healthfacility_id;
           $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
           $thehealthfacility = $healthfacility->health_facility;
       }

       $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
       $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

       $start_date = $reportingperiod_one->from;

       $end_date = $reportingperiod_two->to;

       $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);


       $healthfacilities = $this->healthfacilitiesmodel->get_list_by_admin_regions($country_id,$zone_id,$region_id,$district_id);

       $total_facilities = count($healthfacilities);


       $table = '<table id="datatable" border="1" width="100%"><thead>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="4"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
       $table .= '<tr bgcolor="#13C3E6"><th colspan="4">Breakdown of reporting rates and timeliness from '.$reporting_year.' week '.$from.' to '.$reporting_year2.' week '.$to.'</th></tr>';
       $table .= '<tr bgcolor="#13C3E6"><th>EPI Week</th><th>Sentinal Sites</th><th>Timeliness</th><th>Compliteness</th></tr>';
       $table .= '</theaad>';
       $table .= '</tbody>';

       $bgcolor = 'bgcolor="#CCCCCC"';

       foreach($epilists as $key=>$epilist)
       {
           if($bgcolor == 'bgcolor="#CCCCCC"')
           {
               $bgcolor = '';
           }
           else
           {
               $bgcolor = 'bgcolor="#CCCCCC"';
           }


           $reporting_sites = $this->formsmodel->getreportingsites($epilist->id, $dist_id,$reg_id,$zon_id,$hf_id);

           $timely_reporting_sites = $this->formsmodel->gettimelyreportingsites($epilist->id, $dist_id,$reg_id,$zon_id,$hf_id);

           if($reporting_sites==0)
           {
               $percentage_timeliness = 0;
           }
           else{
               $percentage_timeliness = ($timely_reporting_sites/$reporting_sites)*100;
           }

           $percentage_completeness = ($reporting_sites/$total_facilities)*100;


           $table .= '<tr '.$bgcolor.'><td>Wk.'.$epilist->week_no.'</td><td>'.$reporting_sites .'</td><td>'.number_format($percentage_timeliness).'%</td><td>'.number_format($percentage_completeness).'%</td></tr>';

       }

       $table .= '</tbody></table>';

       $filename = "Completeness_Timeliness_".date('dmY-his').".xls";

       $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
       $this->output->set_header("Expires: 0");
       $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
       $this->output->set_header("content-disposition: attachment;filename=".$filename."");


       $this->output->append_output($table);

   }

    public function reportingrates()
    {
        if (!$this->erkanaauth->try_session_login()) {

            redirect('login', 'refresh');

        }

        $data = array();

        $level = $this->erkanaauth->getField('level');
        $country_id = $this->erkanaauth->getField('country_id');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;

        $diseasecount = $this->diseasesmodel->get_country_list($country_id);
        $limit = count($diseasecount);

        $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
        $data['diseases'] = $diseases;


        $this->load->view('analytics/reportingrates', $data);
    }

    public function reportingratesreport()
    {

        if (!$this->erkanaauth->try_session_login()) {

            redirect('login','refresh');

        }

        $data = array();

        $zone_id = $this->input->post('zone_id');
        $region_id = $this->input->post('region_id');
        $district_id = $this->input->post('district_id');
        $healthfacility_id = $this->input->post('healthfacility_id');

        $reporting_year = $this->input->post('reporting_year');
        $from = $this->input->post('week_no');
        $reporting_year2 = $this->input->post('reporting_year2');
        $to = $this->input->post('week_no2');


        $country_id = $this->erkanaauth->getField('country_id');

        $level = $this->erkanaauth->getField('level');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;


        if(empty($zone_id))
        {
            $zon_id = 0;
            $data['thezone'] = 'All';
        }
        else
        {
            $zon_id = $zone_id;
            $zone = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['thezone'] = $zone->zone;
        }

        if(empty($region_id))
        {
            $reg_id = 0;
            $data['theregion'] = 'All';
        }
        else
        {
            $reg_id = $region_id;
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['theregion'] = $region->region;
        }

        if(empty($district_id))
        {
            $dist_id = 0;
            $data['thedistrict'] = 'All';
        }
        else
        {
            $dist_id = $district_id;
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $data['thedistrict'] = $district->district;
        }

        if(empty($healthfacility_id))
        {
            $hf_id = 0;
            $data['thehealthfacility'] = 'All';
        }
        else
        {
            $hf_id = $healthfacility_id;
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $data['thehealthfacility'] = $healthfacility->health_facility;
        }

        $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
        $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

        $start_date = $reportingperiod_one->from;

        $end_date = $reportingperiod_two->to;

        $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

        $epicalendaridArray = array();

        foreach($epilists as $key=>$epilist)
        {
            $epicalendaridArray[] =  $epilist->id;

        }

        $healthfacilities = $this->healthfacilitiesmodel->get_list_by_admin_regions($country_id,$zone_id,$region_id,$district_id);

        $total_facilities = count($healthfacilities);

        $categories = '';
        $consultations_column = '';
        $completeness_column = '';


        $table = '<table id="datatable" border="1"><thead>';
        $table .= '<tr><th>Week No.</th><th>Completeness</th><th>Consultations</th></tr></thead>';

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($epilists as $key=>$epi_list)
        {
            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $consultations = $this->formsmodel->getconsultations($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);
            $reporting_sites = $this->formsmodel->getreportingsites($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);

            $categories .=  "'WK.".$epi_list->week_no."',";
            $consultations_column .= $consultations.',';


            $percentage_completeness = ($reporting_sites/$total_facilities)*100;
            $completeness_column .= number_format($percentage_completeness).',';

            $table .= '<tr '.$bgcolor.'><td>WK.'.$epi_list->week_no.'</td><td>'.number_format($percentage_completeness).'%</td><td>'.$consultations.'</td></tr>';

        }

        $healthfacilities = $this->healthfacilitiesmodel->get_list_by_country($country_id);

        $total_facilities = count($healthfacilities);

        $table .= '</table>';

        //$lists = $this->reportsmodel->get_full_list_case_epi_week($epicalendaridArray,$dist_id,$reg_id,$zon_id);

        $data['table'] = $table;
        $data['total_facilities'] = $total_facilities;
        $data['categories'] = $categories;
        $data['consultations_column'] = $consultations_column;
        $data['completeness_column'] = $completeness_column;
        $data['reporting_year'] = $reporting_year;
        $data['from'] = $from;
        $data['reporting_year2'] = $reporting_year2;
        $data['to'] = $to;
        $data['zone_id'] = $zon_id;
        $data['region_id'] = $reg_id;
        $data['district_id'] = $dist_id;

        $this->load->view('analytics/reportingratesreport', $data);

    }

    public function exportreportingrates()
    {
        if (!$this->erkanaauth->try_session_login()) {

            redirect('login','refresh');

        }

        $zone_id = $this->input->post('zone_id');
        $region_id = $this->input->post('region_id');
        $district_id = $this->input->post('district_id');
        $healthfacility_id = $this->input->post('healthfacility_id');

        $reporting_year = $this->input->post('reportingyear');
        $from = $this->input->post('from');
        $reporting_year2 = $this->input->post('reportingyear2');
        $to = $this->input->post('to');


        $country_id = $this->erkanaauth->getField('country_id');

        if(empty($zone_id))
        {
            $zon_id = 0;
            $thezone = 'All';
        }
        else
        {
            $zon_id = $zone_id;
            $zone = $this->zonesmodel->get_by_id($zone_id)->row();
            $thezone = $zone->zone;
        }

        if(empty($region_id))
        {
            $reg_id = 0;
            $theregion = 'All';
        }
        else
        {
            $reg_id = $region_id;
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $theregion = $region->region;
        }

        if(empty($district_id))
        {
            $dist_id = 0;
            $thedistrict = 'All';
        }
        else
        {
            $dist_id = $district_id;
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $thedistrict = $district->district;
        }

        if(empty($healthfacility_id))
        {
            $hf_id = 0;
            $thehealthfacility = 'All';
        }
        else
        {
            $hf_id = $healthfacility_id;
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $thehealthfacility = $healthfacility->health_facility;
        }

        $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
        $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

        $start_date = $reportingperiod_one->from;

        $end_date = $reportingperiod_two->to;

        $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

        $epicalendaridArray = array();

        foreach($epilists as $key=>$epilist)
        {
            $epicalendaridArray[] =  $epilist->id;

        }

        $healthfacilities = $this->healthfacilitiesmodel->get_list_by_admin_regions($country_id,$zone_id,$region_id,$district_id);

        $total_facilities = count($healthfacilities);

        $categories = '';
        $consultations_column = '';
        $completeness_column = '';


        $table = '<table id="datatable" border="1" width="100%"><thead>';
        $table .= '<tr bgcolor="#13C3E6"><th colspan="3"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
        $table .= '<tr bgcolor="#13C3E6"><th colspan="3">Breakdown of reporting rates and consultations from '.$reporting_year.' week '.$from.' to '.$reporting_year2.' week '.$to.'</th></tr>';
        $table .= '<tr><th>Week No.</th><th>Completeness</th><th>Consultations</th></tr></thead>';

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($epilists as $key=>$epi_list)
        {
            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $consultations = $this->formsmodel->getconsultations($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);
            $reporting_sites = $this->formsmodel->getreportingsites($epi_list->id, $dist_id,$reg_id,$zon_id,$hf_id);

            $categories .=  "'WK.".$epi_list->week_no."',";
            $consultations_column .= $consultations.',';


            $percentage_completeness = ($reporting_sites/$total_facilities)*100;
            $completeness_column .= number_format($percentage_completeness).',';

            $table .= '<tr '.$bgcolor.'><td>WK.'.$epi_list->week_no.'</td><td>'.number_format($percentage_completeness).'%</td><td>'.$consultations.'</td></tr>';

        }

        $table .= '</table>';

        $filename = "Consultations_vs_completeness_".date('dmY-his').".xls";

        $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        $this->output->set_header("Expires: 0");
        $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header("content-disposition: attachment;filename=".$filename."");


        $this->output->append_output($table);
    }

    public function ageandsex(){

        if (!$this->erkanaauth->try_session_login()) {

            redirect('login', 'refresh');

        }

        $data = array();

        $level = $this->erkanaauth->getField('level');
        $country_id = $this->erkanaauth->getField('country_id');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;

        $diseasecount = $this->diseasesmodel->get_country_list($country_id);
        $limit = count($diseasecount);

        $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
        $data['diseases'] = $diseases;


        $this->load->view('analytics/ageandsex', $data);

    }

    public function ageandsexreport()
    {
        if (!$this->erkanaauth->try_session_login()) {

            redirect('login','refresh');

        }

        $data = array();

        $zone_id = $this->input->post('zone_id');
        $region_id = $this->input->post('region_id');
        $district_id = $this->input->post('district_id');
        $healthfacility_id = $this->input->post('healthfacility_id');

        $reporting_year = $this->input->post('reporting_year');
        $from = $this->input->post('week_no');


        $country_id = $this->erkanaauth->getField('country_id');

        $level = $this->erkanaauth->getField('level');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;

        $diseasecount = $this->diseasesmodel->get_country_list($country_id);
        $limit = count($diseasecount);

        $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);


        if(empty($zone_id))
        {
            $zon_id = 0;
            $data['thezone'] = 'All';
        }
        else
        {
            $zon_id = $zone_id;
            $zone = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['thezone'] = $zone->zone;
        }

        if(empty($region_id))
        {
            $reg_id = 0;
            $data['theregion'] = 'All';
        }
        else
        {
            $reg_id = $region_id;
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['theregion'] = $region->region;
        }

        if(empty($district_id))
        {
            $dist_id = 0;
            $data['thedistrict'] = 'All';
        }
        else
        {
            $dist_id = $district_id;
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $data['thedistrict'] = $district->district;
        }

        if(empty($healthfacility_id))
        {
            $hf_id = 0;
            $data['thehealthfacility'] = 'All';
        }
        else
        {
            $hf_id = $healthfacility_id;
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $data['thehealthfacility'] = $healthfacility->health_facility;
        }

        $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();

        $diseseinterestarray = array();

        $mydiseases = $this->input->post('disease');

        if(empty($mydiseases))
        {
            $diseseinterestarray[] = 1;
        }
        else{
            foreach ($mydiseases as $key=>$mydisease):

                $diseseinterestarray[] = $mydisease;

            endforeach;

        }

        $table = '<table id="datatable" border="1">';

        $table .= '<thead>';
        $table .= '<tr><th>&nbsp;</th><th colspan="2">Age</th><th colspan="2">Gender</th></tr>';
        $table .= '<tr><th>Disease</th><th><5 Years</th><th>>5 Years</th><th>Male</th><th>Female</th></tr>';

        $table .= '</thead>';

        $series = '';

        $caselists = $this->reportsmodel->get_full_list_case_week($reporting_year,$reporting_year,$reportingperiod_one->id,$reportingperiod_one->id,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($diseseinterestarray as $key=>$highestdiseasecode) {

            $series .= '{
            ';

            $series .= "name: '".$highestdiseasecode."',
            ";

            $series .= 'data: [';


            foreach ($caselists as $key => $caselist):

                $under_five_element = $highestdiseasecode.'_T_U_F';
                $over_five_element = $highestdiseasecode.'_T_O_F';

                $male_under_five = $highestdiseasecode.'_M_U_F';
                $male_over_five = $highestdiseasecode.'_M_O_F';
                $female_under_five = $highestdiseasecode.'_F_U_F';
                $female_over_five = $highestdiseasecode.'_F_O_F';
                $total_male = ($caselist->$male_under_five+$caselist->$male_over_five);
                $total_female = ($caselist->$female_under_five+$caselist->$female_over_five);

                $series .= $caselist->$under_five_element.',';
                $series .= $caselist->$over_five_element.',';
                $series .= $total_male.',';
                $series .= $total_female.',';

                if($bgcolor == 'bgcolor="#CCCCCC"')
                {
                    $bgcolor = '';
                }
                else
                {
                    $bgcolor = 'bgcolor="#CCCCCC"';
                }

                $table .= '<tr '.$bgcolor.'><td>'.$highestdiseasecode.'</td><td>'.$caselist->$under_five_element.'</td><td>'.$caselist->$over_five_element.'</td><td>'.$total_male.'</td><td>'.$total_female.'</td></tr>';


            endforeach;

            $series .= ']
            ';


            $series .= '},';
        }


        $table .= '</table>';

        $data['table'] = $table;
        $data['reporting_year'] = $reporting_year;
        $data['from'] = $from;
        $data['zone_id'] = $zon_id;
        $data['region_id'] = $reg_id;
        $data['district_id'] = $dist_id;
        $data['diseases'] = $diseases;
        $data['mydiseases'] = $mydiseases;
        $data['series'] = $series;

        $this->load->view('analytics/ageandsexreport', $data);

    }

    public function exportageandsex()
    {

        if (!$this->erkanaauth->try_session_login()) {

            redirect('login','refresh');

        }

        $zone_id = $this->input->post('zone_id');
        $region_id = $this->input->post('region_id');
        $district_id = $this->input->post('district_id');
        $healthfacility_id = $this->input->post('healthfacility_id');

        $reporting_year = $this->input->post('reportingyear');
        $from = $this->input->post('from');

        if(empty($zone_id))
        {
            $zon_id = 0;
            $thezone = 'All';
        }
        else
        {
            $zon_id = $zone_id;
            $zone = $this->zonesmodel->get_by_id($zone_id)->row();
            $thezone = $zone->zone;
        }

        if(empty($region_id))
        {
            $reg_id = 0;
            $theregion = 'All';
        }
        else
        {
            $reg_id = $region_id;
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $theregion = $region->region;
        }

        if(empty($district_id))
        {
            $dist_id = 0;
            $thedistrict = 'All';
        }
        else
        {
            $dist_id = $district_id;
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $thedistrict = $district->district;
        }

        if(empty($healthfacility_id))
        {
            $hf_id = 0;
            $thehealthfacility = 'All';
        }
        else
        {
            $hf_id = $healthfacility_id;
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $thehealthfacility = $healthfacility->health_facility;
        }

        $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();

        $diseseinterestarray = array();

        $mydiseases = $this->input->post('mydisease');

        if(empty($mydiseases))
        {
            $diseseinterestarray[] = 1;
        }
        else{
            foreach ($mydiseases as $key=>$mydisease):

                $diseseinterestarray[] = $mydisease;

            endforeach;

        }

        $table = '<table id="datatable" border="1" width="100%">';

        $table .= '<thead>';
        $table .= '<tr bgcolor="#13C3E6"><th colspan="5"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
        $table .= '<tr bgcolor="#13C3E6"><th colspan="5">Age and sex distribution of diseases by cases EPI week '.$from.' '.$reporting_year.'</th></tr>';
        $table .= '<tr  bgcolor="#13C3E6"><th>&nbsp;</th><th colspan="2">Age</th><th colspan="2">Gender</th></tr>';
        $table .= '<tr  bgcolor="#13C3E6"><th>Disease</th><th><5 Years</th><th>>5 Years</th><th>Male</th><th>Female</th></tr>';

        $table .= '</thead>';


        $caselists = $this->reportsmodel->get_full_list_case_week($reporting_year,$reporting_year,$reportingperiod_one->id,$reportingperiod_one->id,$dist_id,$reg_id,$zon_id,$hf_id,$diseseinterestarray);

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($diseseinterestarray as $key=>$highestdiseasecode) {

            foreach ($caselists as $key => $caselist):

                $under_five_element = $highestdiseasecode.'_T_U_F';
                $over_five_element = $highestdiseasecode.'_T_O_F';

                $male_under_five = $highestdiseasecode.'_M_U_F';
                $male_over_five = $highestdiseasecode.'_M_O_F';
                $female_under_five = $highestdiseasecode.'_F_U_F';
                $female_over_five = $highestdiseasecode.'_F_O_F';
                $total_male = ($caselist->$male_under_five+$caselist->$male_over_five);
                $total_female = ($caselist->$female_under_five+$caselist->$female_over_five);


                if($bgcolor == 'bgcolor="#CCCCCC"')
                {
                    $bgcolor = '';
                }
                else
                {
                    $bgcolor = 'bgcolor="#CCCCCC"';
                }

                $table .= '<tr '.$bgcolor.'><td>'.$highestdiseasecode.'</td><td>'.$caselist->$under_five_element.'</td><td>'.$caselist->$over_five_element.'</td><td>'.$total_male.'</td><td>'.$total_female.'</td></tr>';


            endforeach;


        }

        $table .= '</table>';

        $filename = "Age_and_Sex_Distribution_".date('dmY-his').".xls";

        $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        $this->output->set_header("Expires: 0");
        $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header("content-disposition: attachment;filename=".$filename."");


        $this->output->append_output($table);

    }

    public function diseasetrend()
    {
        if (!$this->erkanaauth->try_session_login()) {

            redirect('login', 'refresh');

        }

        $data = array();

        $level = $this->erkanaauth->getField('level');
        $country_id = $this->erkanaauth->getField('country_id');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;

        $diseasecount = $this->diseasesmodel->get_country_list($country_id);
        $limit = count($diseasecount);

        $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
        $data['diseases'] = $diseases;


        $this->load->view('analytics/diseasetrend', $data);
    }


    public function diseasetrendreport()
    {
        if (!$this->erkanaauth->try_session_login()) {

            redirect('login','refresh');

        }

        $data = array();

        $zone_id = $this->input->post('zone_id');
        $region_id = $this->input->post('region_id');
        $district_id = $this->input->post('district_id');
        $healthfacility_id = $this->input->post('healthfacility_id');

        $reporting_year = $this->input->post('reporting_year');
        $from = $this->input->post('week_no');
        $reporting_year2 = $this->input->post('reporting_year2');
        $to = $this->input->post('week_no2');
        $disease_id = $this->input->post('disease_id');


        $country_id = $this->erkanaauth->getField('country_id');

        $level = $this->erkanaauth->getField('level');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;


        if(empty($zone_id))
        {
            $zon_id = 0;
            $data['thezone'] = 'All';
        }
        else
        {
            $zon_id = $zone_id;
            $zone = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['thezone'] = $zone->zone;
        }

        if(empty($region_id))
        {
            $reg_id = 0;
            $data['theregion'] = 'All';
        }
        else
        {
            $reg_id = $region_id;
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['theregion'] = $region->region;
        }

        if(empty($district_id))
        {
            $dist_id = 0;
            $data['thedistrict'] = 'All';
        }
        else
        {
            $dist_id = $district_id;
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $data['thedistrict'] = $district->district;
        }

        if(empty($healthfacility_id))
        {
            $hf_id = 0;
            $data['thehealthfacility'] = 'All';
        }
        else
        {
            $hf_id = $healthfacility_id;
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $data['thehealthfacility'] = $healthfacility->health_facility;
        }

        $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
        $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

        $start_date = $reportingperiod_one->from;

        $end_date = $reportingperiod_two->to;

        $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

        $epicalendaridArray = array();
        //previous year EPI calendar array
        $previousepiarray = array();
        $previous_year = ($reporting_year-1);
        $category = '';

        foreach($epilists as $key=>$epilist)
        {
            $epicalendaridArray[] =  $epilist->id;

            $previousepicalendar = $this->epdcalendarmodel->get_by_year_week_country($previous_year,$epilist->week_no,$country_id)->row();
            $previousepiarray[] =  $previousepicalendar->id;
            $category .= "'WK.".$epilist->week_no."',";


        }


        $table = '<table id="datatable" border="1"><thead>';
        $table .= '<tr><th colspan="3">'.$reporting_year.'</th></tr>';
        $table .= '<tr><th>EPI Week</th><th>Cases</th><th>Percentage</th></tr>';
        $table .= '</theaad>';
        $table .= '<tbody>';

        $disease = $this->diseasesmodel->get_by_id($disease_id)->row();

        $measleslists = $this->reportsmodel->get_list_disease_sum($epicalendaridArray, $dist_id, $reg_id, $zon_id, $hf_id,$disease->disease_code);
        $measseries = '{';
        $measseries .= "name: '".$reporting_year."',";
        $measseries .= 'data: [';

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($measleslists as $key=>$measleslist)
        {
            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $table .=  '<tr '.$bgcolor.'><td>Week '.$measleslist->week_no.'</td>';
            $weekcases = $this->reportsmodel->get_list_sum($measleslist->epicalendar_id, $dist_id, $reg_id, $zon_id, $hf_id);
            $measpercent = ($measleslist->Disease_Total/$weekcases)*100;
            $measseries .= number_format($measpercent).',';

            $table .=  '<td>'.$measleslist->Disease_Total.'</td><td>'.number_format($measpercent).'%</td></tr>';

            unset($weekcases);

        }

        unset($measleslists);
        unset($bgcolor);


        $measseries .= ']';

        $measseries .= '},';

        $table .= '</tbody>';
        $table .= '</table>';


        $prevtable = '<table id="datatable" border="1"><thead>';
        $prevtable .= '<tr><th colspan="3">'.$previous_year.'</th></tr>';
        $prevtable .= '<tr><th>EPI Week</th><th>Cases</th><th>Percentage</th></tr>';
        $prevtable .= '</theaad>';
        $prevtable .= '<tbody>';


        $prevmeaslists = $this->reportsmodel->get_list_disease_sum($previousepiarray, $dist_id, $reg_id, $zon_id, $hf_id,$disease->disease_code);

        $measseries .= '{';
        $measseries .= "name: '".$previous_year."',";
        $measseries .= 'data: [';

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($prevmeaslists as $key=>$prevmeaslist)
        {

            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $prevtable .=  '<tr '.$bgcolor.'><td>Week '.$prevmeaslist->week_no.'</td>';

            $prevweekcases = $this->reportsmodel->get_list_sum($prevmeaslist->epicalendar_id, $dist_id, $reg_id, $zon_id, $hf_id);
            $measprevpercent = ($prevmeaslist->Disease_Total/$prevweekcases)*100;
            $measseries .= number_format($measprevpercent).',';

            $prevtable .=  '<td>'.$prevmeaslist->Disease_Total.'</td><td>'.number_format($measprevpercent).'%</td></tr>';

            unset($prevweekcases);

        }
        unset($prevmeaslists);

        $measseries .= ']';

        $measseries .= '},';

        $prevtable .= '</tbody>';

        $prevtable .= '</table>';


        $diseasecount = $this->diseasesmodel->get_country_list($country_id);
        $limit = count($diseasecount);

        $diseases = $this->db->get_where('diseases', array('country_id' => $country_id),$limit);
        $data['diseases'] = $diseases;

        $data['reporting_year'] = $reporting_year;
        $data['from'] = $from;
        $data['reporting_year2'] = $reporting_year2;
        $data['to'] = $to;
        $data['zone_id'] = $zon_id;
        $data['region_id'] = $reg_id;
        $data['district_id'] = $dist_id;
        $data['healthfacility_id'] = $hf_id;
        $data['category'] = $category;
        $data['measseries'] = $measseries;
        $data['disease_id'] = $disease_id;
        $data['previous_year'] = $previous_year;
        $data['mydisease'] = $disease;
        $data['table'] = $table;
        $data['prevtable'] = $prevtable;

        $this->load->view('analytics/diseasetrendreport', $data);


    }

    public function exportdiseasetrend()
    {
        if (!$this->erkanaauth->try_session_login()) {

            redirect('login','refresh');

        }

        $zone_id = $this->input->post('zone_id');
        $region_id = $this->input->post('region_id');
        $district_id = $this->input->post('district_id');
        $healthfacility_id = $this->input->post('healthfacility_id');

        $reporting_year = $this->input->post('reportingyear');
        $from = $this->input->post('from');
        $reporting_year2 = $this->input->post('reportingyear2');
        $to = $this->input->post('to');

        $disease_id = $this->input->post('mydisease_id');


        $country_id = $this->erkanaauth->getField('country_id');

        if(empty($zone_id))
        {
            $zon_id = 0;
            $thezone = 'All';
        }
        else
        {
            $zon_id = $zone_id;
            $zone = $this->zonesmodel->get_by_id($zone_id)->row();
            $thezone = $zone->zone;
        }

        if(empty($region_id))
        {
            $reg_id = 0;
            $theregion = 'All';
        }
        else
        {
            $reg_id = $region_id;
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $theregion = $region->region;
        }

        if(empty($district_id))
        {
            $dist_id = 0;
            $thedistrict = 'All';
        }
        else
        {
            $dist_id = $district_id;
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $thedistrict = $district->district;
        }

        if(empty($healthfacility_id))
        {
            $hf_id = 0;
            $thehealthfacility = 'All';
        }
        else
        {
            $hf_id = $healthfacility_id;
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $thehealthfacility = $healthfacility->health_facility;
        }

        $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
        $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

        $start_date = $reportingperiod_one->from;

        $end_date = $reportingperiod_two->to;

        $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

        $epicalendaridArray = array();
        //previous year EPI calendar array
        $previousepiarray = array();
        $previous_year = ($reporting_year-1);

        foreach($epilists as $key=>$epilist)
        {
            $epicalendaridArray[] =  $epilist->id;

            $previousepicalendar = $this->epdcalendarmodel->get_by_year_week_country($previous_year,$epilist->week_no,$country_id)->row();
            $previousepiarray[] =  $previousepicalendar->id;


        }

        $disease = $this->diseasesmodel->get_by_id($disease_id)->row();

        $table = '<table id="datatable" border="1"><thead>';
        $table .= '<tr bgcolor="#13C3E6"><th colspan="3"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
        $table .= '<tr bgcolor="#13C3E6"><th colspan="3">Weekly disease trends of '.$disease->disease_name.' EPI week '.$from.' to '.$to.', '.$reporting_year.' &amp; '.$previous_year.'</th></tr>';
        $table .= '<tr><th colspan="3">'.$reporting_year.'</th></tr>';
        $table .= '<tr><th>EPI Week</th><th>Cases</th><th>Percentage</th></tr>';
        $table .= '</theaad>';
        $table .= '<tbody>';

        $measleslists = $this->reportsmodel->get_list_disease_sum($epicalendaridArray, $dist_id, $reg_id, $zon_id, $hf_id,$disease->disease_code);

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($measleslists as $key=>$measleslist)
        {
            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $table .=  '<tr '.$bgcolor.'><td>Week '.$measleslist->week_no.'</td>';
            $weekcases = $this->reportsmodel->get_list_sum($measleslist->epicalendar_id, $dist_id, $reg_id, $zon_id, $hf_id);
            $measpercent = ($measleslist->Disease_Total/$weekcases)*100;

            $table .=  '<td>'.$measleslist->Disease_Total.'</td><td>'.number_format($measpercent).'%</td></tr>';

            unset($weekcases);

        }

        unset($measleslists);
        unset($bgcolor);

        $table .= '</tbody>';
        $table .= '</table>';


        $prevtable = '<table id="datatable" border="1"><thead>';
        $prevtable .= '<tr><th colspan="3">'.$previous_year.'</th></tr>';
        $prevtable .= '<tr><th>EPI Week</th><th>Cases</th><th>Percentage</th></tr>';
        $prevtable .= '</theaad>';
        $prevtable .= '<tbody>';


        $prevmeaslists = $this->reportsmodel->get_list_disease_sum($previousepiarray, $dist_id, $reg_id, $zon_id, $hf_id,$disease->disease_code);


        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($prevmeaslists as $key=>$prevmeaslist)
        {

            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $prevtable .=  '<tr '.$bgcolor.'><td>Week '.$prevmeaslist->week_no.'</td>';

            $prevweekcases = $this->reportsmodel->get_list_sum($prevmeaslist->epicalendar_id, $dist_id, $reg_id, $zon_id, $hf_id);
            $measprevpercent = ($prevmeaslist->Disease_Total/$prevweekcases)*100;

            $prevtable .=  '<td>'.$prevmeaslist->Disease_Total.'</td><td>'.number_format($measprevpercent).'%</td></tr>';

            unset($prevweekcases);

        }
        unset($prevmeaslists);

        $prevtable .= '</tbody>';

        $prevtable .= '</table>';

        $output = $table.''.$prevtable;


        $filename = "Week_Disease_Trends_".$disease->disease_code."_".date('dmY-his').".xls";

        $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        $this->output->set_header("Expires: 0");
        $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header("content-disposition: attachment;filename=".$filename."");

        $this->output->append_output($output);
    }

    public function weeklytrends(){

        if (!$this->erkanaauth->try_session_login()) {

            redirect('login', 'refresh');

        }

        $data = array();

        $level = $this->erkanaauth->getField('level');
        $country_id = $this->erkanaauth->getField('country_id');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;

        $diseasecategories = $this->diseasecategoriesmodel->get_list();
        $data['diseasecategories'] = $diseasecategories;

        $this->load->view('analytics/weeklytrends', $data);

    }

    public function weeklytrendsreport()
    {
        if (!$this->erkanaauth->try_session_login()) {

            redirect('login','refresh');

        }

        $data = array();

        $zone_id = $this->input->post('zone_id');
        $region_id = $this->input->post('region_id');
        $district_id = $this->input->post('district_id');
        $healthfacility_id = $this->input->post('healthfacility_id');

        $reporting_year = $this->input->post('reporting_year');
        $from = $this->input->post('week_no');
        $reporting_year2 = $this->input->post('reporting_year2');
        $to = $this->input->post('week_no2');
        $diseasecategory_id = $this->input->post('diseasecategory_id');


        $country_id = $this->erkanaauth->getField('country_id');

        $level = $this->erkanaauth->getField('level');

        if (getRole() != 'SuperAdmin' && getRole() != 'Admin' && $level != 2 && $level != 1 && $level != 4 && $level != 5) {

            redirect('home', 'refresh');

        }

        if ($level == 6) {//District
            $district_id = $this->erkanaauth->getField('district_id');
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $region = $this->regionsmodel->get_by_id($district->region_id)->row();
            $data['district'] = $district;
            $data['zone']     = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_district_list($district_id);
        }

        if($level==2)//FP
        {

            $region_id = $this->erkanaauth->getField('region_id');
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone'] = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region'] = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_region($region->id);

        }
        if($level==1)//zonal
        {
            $zone_id = $this->erkanaauth->getField('zone_id');
            $data['zone'] = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions'] = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_by_zone($zone_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_by_zone($zone_id);
        }

        if($level==4)//national
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_country_list($country_id);
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        if($level==5)//stakeholder
        {
            $data['regions'] = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones'] = $this->zonesmodel->get_list();
            $data['healthfacilities'] = $this->healthfacilitiesmodel->get_list();
        }

        $data['level'] = $level;


        if(empty($zone_id))
        {
            $zon_id = 0;
            $data['thezone'] = 'All';
        }
        else
        {
            $zon_id = $zone_id;
            $zone = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['thezone'] = $zone->zone;
        }

        if(empty($region_id))
        {
            $reg_id = 0;
            $data['theregion'] = 'All';
        }
        else
        {
            $reg_id = $region_id;
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $data['theregion'] = $region->region;
        }

        if(empty($district_id))
        {
            $dist_id = 0;
            $data['thedistrict'] = 'All';
        }
        else
        {
            $dist_id = $district_id;
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $data['thedistrict'] = $district->district;
        }

        if(empty($healthfacility_id))
        {
            $hf_id = 0;
            $data['thehealthfacility'] = 'All';
        }
        else
        {
            $hf_id = $healthfacility_id;
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $data['thehealthfacility'] = $healthfacility->health_facility;
        }

        $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
        $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

        $start_date = $reportingperiod_one->from;

        $end_date = $reportingperiod_two->to;

        $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

        $epicalendaridArray = array();
        //previous year EPI calendar array
        $previousepiarray = array();
        $previous_year = ($reporting_year-1);
        $category = '';

        foreach($epilists as $key=>$epilist)
        {
            $epicalendaridArray[] =  $epilist->id;

            $previousepicalendar = $this->epdcalendarmodel->get_by_year_week_country($previous_year,$epilist->week_no,$country_id)->row();
            $previousepiarray[] =  $previousepicalendar->id;
            $category .= "'WK.".$epilist->week_no."',";

        }

        $resplists = $this->reportsmodel->get_list_category_sum($epicalendaridArray, $dist_id, $reg_id, $zon_id, $hf_id,$diseasecategory_id);
        $respseries = '{';
        $respseries .= "name: '".$reporting_year."',";
        $respseries .= 'data: [';

        $table = '<table id="datatable" border="1"><thead>';
        $table .= '<tr><th colspan="3">'.$reporting_year.'</th></tr>';
        $table .= '<tr><th>EPI Week</th><th>Cases</th><th>Percentage</th></tr>';
        $table .= '</theaad>';
        $table .= '<tbody>';

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($resplists as $key=>$resplist)
        {
            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $table .=  '<tr '.$bgcolor.'><td>Week '.$resplist->week_no.'</td>';

            $weekcases = $this->reportsmodel->get_list_sum($resplist->epicalendar_id, $dist_id, $reg_id, $zon_id, $hf_id);
            $resppercent = ($resplist->Category_Total/$weekcases)*100;
            $respseries .= number_format($resppercent).',';


            $table .=  '<td>'.$resplist->Category_Total.'</td><td>'.number_format($resppercent).'%</td></tr>';

            unset($weekcases);

        }

        unset($resplists);
        unset($bgcolor);

        $respseries .= ']';

        $respseries .= '},';

        $table .= '</tbody>';
        $table .= '</table>';

        $data['table'] = $table;

        $respprevlists = $this->reportsmodel->get_list_category_sum($previousepiarray, $dist_id, $reg_id, $zon_id, $hf_id,$diseasecategory_id);
        $respseries .= '{';
        $respseries .= "name: '".$previous_year."',";
        $respseries .= 'data: [';

        $prevtable = '<table id="datatable" border="1"><thead>';
        $prevtable .= '<tr><th colspan="3">'.$previous_year.'</th></tr>';
        $prevtable .= '<tr><th>EPI Week</th><th>Cases</th><th>Percentage</th></tr>';
        $prevtable .= '</theaad>';
        $prevtable .= '<tbody>';

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($respprevlists as $key=>$respprevlist)
        {
            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $prevtable .=  '<tr '.$bgcolor.'><td>Week '.$respprevlist->week_no.'</td>';

            $prevweekcases = $this->reportsmodel->get_list_sum($respprevlist->epicalendar_id, $dist_id, $reg_id, $zon_id, $hf_id);
            $respprevpercent = ($respprevlist->Category_Total/$prevweekcases)*100;
            $respseries .= number_format($respprevpercent).',';

            $prevtable .=  '<td>'.$respprevlist->Category_Total.'</td><td>'.number_format($respprevpercent).'%</td></tr>';

            unset($prevweekcases);
        }

        unset($respprevlists);
        unset($bgcolor);

        $respseries .= ']';

        $respseries .= '},';

        $prevtable .= '</tbody>';
        $prevtable .= '</table>';


        $diseasecategories = $this->diseasecategoriesmodel->get_list();
        $data['diseasecategories'] = $diseasecategories;

        $thecategory = $this->diseasecategoriesmodel->get_by_id($diseasecategory_id)->row();

        $data['thecategory'] = $thecategory;

        $data['reporting_year'] = $reporting_year;
        $data['from'] = $from;
        $data['reporting_year2'] = $reporting_year2;
        $data['to'] = $to;
        $data['zone_id'] = $zon_id;
        $data['region_id'] = $reg_id;
        $data['district_id'] = $dist_id;
        $data['healthfacility_id'] = $hf_id;
        $data['category'] = $category;
        $data['respseries'] = $respseries;
        $data['diseasecategory_id'] = $diseasecategory_id;
        $data['previous_year'] = $previous_year;
        $data['prevtable'] = $prevtable;

        $this->load->view('analytics/weeklytrendsreport', $data);

    }

    public function exportweeklytrend()
    {

        if (!$this->erkanaauth->try_session_login()) {

            redirect('login','refresh');

        }


        $zone_id = $this->input->post('zone_id');
        $region_id = $this->input->post('region_id');
        $district_id = $this->input->post('district_id');
        $healthfacility_id = $this->input->post('healthfacility_id');

        $reporting_year = $this->input->post('reportingyear');
        $from = $this->input->post('from');
        $reporting_year2 = $this->input->post('reportingyear2');
        $to = $this->input->post('to');
        $diseasecategory_id = $this->input->post('mydiseasecategory_id');

        $thecategory = $this->diseasecategoriesmodel->get_by_id($diseasecategory_id)->row();

        $country_id = $this->erkanaauth->getField('country_id');

        if(empty($zone_id))
        {
            $zon_id = 0;
            $thezone = 'All';
        }
        else
        {
            $zon_id = $zone_id;
            $zone = $this->zonesmodel->get_by_id($zone_id)->row();
            $thezone = $zone->zone;
        }

        if(empty($region_id))
        {
            $reg_id = 0;
            $theregion = 'All';
        }
        else
        {
            $reg_id = $region_id;
            $region = $this->regionsmodel->get_by_id($region_id)->row();
            $theregion = $region->region;
        }

        if(empty($district_id))
        {
            $dist_id = 0;
            $thedistrict = 'All';
        }
        else
        {
            $dist_id = $district_id;
            $district = $this->districtsmodel->get_by_id($district_id)->row();
            $thedistrict = $district->district;
        }

        if(empty($healthfacility_id))
        {
            $hf_id = 0;
            $thehealthfacility = 'All';
        }
        else
        {
            $hf_id = $healthfacility_id;
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($healthfacility_id)->row();
            $thehealthfacility = $healthfacility->health_facility;
        }

        $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reporting_year,$from)->row();
        $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reporting_year2,$to)->row();

        $start_date = $reportingperiod_one->from;

        $end_date = $reportingperiod_two->to;

        $epilists = $this->epdcalendarmodel->get_list_by_date($start_date,$end_date,$country_id);

        $epicalendaridArray = array();
        //previous year EPI calendar array
        $previousepiarray = array();
        $previous_year = ($reporting_year-1);

        foreach($epilists as $key=>$epilist)
        {
            $epicalendaridArray[] =  $epilist->id;

            $previousepicalendar = $this->epdcalendarmodel->get_by_year_week_country($previous_year,$epilist->week_no,$country_id)->row();
            $previousepiarray[] =  $previousepicalendar->id;

        }

        $resplists = $this->reportsmodel->get_list_category_sum($epicalendaridArray, $dist_id, $reg_id, $zon_id, $hf_id,$diseasecategory_id);

        $table = '<table id="datatable" border="1"><thead>';
        $table .= '<tr bgcolor="#13C3E6"><th colspan="3"><div align="center">Zone: '.$thezone.' Region: '.$theregion.' District: '.$thedistrict.' Health Facility: '.$thehealthfacility.'</div></th></tr>';
        $table .= '<tr bgcolor="#13C3E6"><th colspan="3">Weekly disease trends of '.$thecategory->category_name.' EPI week '.$from.' to '.$to.', '.$reporting_year.' &amp; '.$previous_year.'</th></tr>';
        $table .= '<tr><th colspan="3">'.$reporting_year.'</th></tr>';
        $table .= '<tr><th>EPI Week</th><th>Cases</th><th>Percentage</th></tr>';
        $table .= '</theaad>';
        $table .= '<tbody>';

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($resplists as $key=>$resplist)
        {
            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $table .=  '<tr '.$bgcolor.'><td>Week '.$resplist->week_no.'</td>';

            $weekcases = $this->reportsmodel->get_list_sum($resplist->epicalendar_id, $dist_id, $reg_id, $zon_id, $hf_id);
            $resppercent = ($resplist->Category_Total/$weekcases)*100;

            $table .=  '<td>'.$resplist->Category_Total.'</td><td>'.number_format($resppercent).'%</td></tr>';

            unset($weekcases);

        }

        unset($resplists);
        unset($bgcolor);


        $table .= '</tbody>';
        $table .= '</table>';

        $data['table'] = $table;

        $respprevlists = $this->reportsmodel->get_list_category_sum($previousepiarray, $dist_id, $reg_id, $zon_id, $hf_id,$diseasecategory_id);

        $prevtable = '<table id="datatable" border="1"><thead>';
        $prevtable .= '<tr><th colspan="3">'.$previous_year.'</th></tr>';
        $prevtable .= '<tr><th>EPI Week</th><th>Cases</th><th>Percentage</th></tr>';
        $prevtable .= '</theaad>';
        $prevtable .= '<tbody>';

        $bgcolor = 'bgcolor="#CCCCCC"';

        foreach($respprevlists as $key=>$respprevlist)
        {
            if($bgcolor == 'bgcolor="#CCCCCC"')
            {
                $bgcolor = '';
            }
            else
            {
                $bgcolor = 'bgcolor="#CCCCCC"';
            }

            $prevtable .=  '<tr '.$bgcolor.'><td>Week '.$respprevlist->week_no.'</td>';

            $prevweekcases = $this->reportsmodel->get_list_sum($respprevlist->epicalendar_id, $dist_id, $reg_id, $zon_id, $hf_id);
            $respprevpercent = ($respprevlist->Category_Total/$prevweekcases)*100;

            $prevtable .=  '<td>'.$respprevlist->Category_Total.'</td><td>'.number_format($respprevpercent).'%</td></tr>';

            unset($prevweekcases);
        }

        unset($respprevlists);
        unset($bgcolor);

        $prevtable .= '</tbody>';
        $prevtable .= '</table>';


        $output = $table.''.$prevtable;


        $filename = "Week_Disease_Trends_".trim($thecategory->category_name)."_".date('dmY-his').".xls";

        $this->output->set_header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        $this->output->set_header("Expires: 0");
        $this->output->set_header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header("content-disposition: attachment;filename=".$filename."");

        $this->output->append_output($output);

    }


}
