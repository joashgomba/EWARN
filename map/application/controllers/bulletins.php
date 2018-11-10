<?php

class Bulletins extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'url',
            'my_path'
        ));
        $this->load->model('bulletinsmodel');
		$this->load->model('reportsmodel');
        $this->load->library('Pdf');
    }
    
    public function index()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 4) {
            redirect('home', 'refresh');
        }
        
        $data = array(
            'rows' => $this->bulletinsmodel->get_by_level($level)
        );
        $this->load->view('bulletins/index', $data);
    }
    
    public function add()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        /**
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 4) {
            redirect('home', 'refresh');
        }
		
		**/
        
        $data = array();
        
        if (getRole() == 'SuperAdmin' && $level == 4) {
            $data['regions']   = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones']     = $this->zonesmodel->get_list();
            
        }
        
        if ($level == 2) //regional
            {
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region            = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']      = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']    = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
        }
        
        if ($level == 1) //zonal
            {
            $zone_id = $this->erkanaauth->getField('zone_id');
            
            
            $data['zone']      = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions']   = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_list();
        }
        
        $data['level'] = $level;
        
        $this->load->view('bulletins/add', $data);
    }
    
    public function add_validate()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        /**
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 4) {
            redirect('home', 'refresh');
        }
		
		**/
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
        $this->form_validation->set_rules('week_year', 'Week year', 'trim|required');
        $this->form_validation->set_rules('issue_no', 'Issue No.', 'trim|required');
        
        if ($this->form_validation->run() == false) {
            $this->add();
        } else {
            
            $week_no        = $this->input->post('week_no');
            $reporting_year = $this->input->post('week_year');
            
            $reportperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
            
            $reportingforms = $this->reportingformsmodel->get_by_period_list($reportperiod->id, 0);
            
            $reporting_hf_count = count($reportingforms);
            
            $consultations = array();
            
            foreach ($reportingforms as $key => $reportingform) {
                $consultations[] = $reportingform['total_consultations'];
            }
            
            $total_consultation = array_sum($consultations);
            
            $data = array(
                'reportingperiod_id' => $reportperiod->id,
                'week_no' => $this->input->post('week_no'),
                'week_year' => $this->input->post('week_year'),
                'period_from' => $reportperiod->from,
                'period_to' => $reportperiod->to,
                'issue_no' => $this->input->post('issue_no'),
                'zone_id' => $this->input->post('zone_id'),
                'region_id' => $this->input->post('region_id'),
                'district_id' => $this->input->post('district_id'),
                'highlight' => '',
                'title' => '',
                'narrative' => '',
                'creation_date' => date('Y-m-d'),
                'creation_date_time' => date("Y-m-d H:i:s"),
                'level' => $level,
                'reportscount' => 0,
                'reporting_hf_count' => $reporting_hf_count,
                'total_consultation' => $total_consultation
            );
            
            $this->db->insert('bulletins', $data);
            
            $bulletin_id = $this->db->insert_id();
            
            redirect('bulletins/edit/' . $bulletin_id, 'refresh');
            
        }
    }
    
    public function edit($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        /**
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 4) {
            redirect('home', 'refresh');
        }
        **/
        $row  = $this->db->get_where('bulletins', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        $this->load->view('bulletins/edit', $data);
    }
    
    public function edit_validate($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
       /**
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 4) {
            redirect('home', 'refresh');
        }
        **/
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('highlight', 'Highlight', 'trim|required');
       // $this->form_validation->set_rules('title', 'Leading Disease Title', 'trim|required');
        //$this->form_validation->set_rules('narrative', 'Leading Disease Text', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->edit($id);
        } else {
            $data = array(
                'highlight' => $this->input->post('highlight'),
                'title' => $this->input->post('title'),
                'narrative' => $this->input->post('narrative')
            );
            $this->db->where('id', $id);
            $this->db->update('bulletins', $data);
            redirect('bulletins', 'refresh');
        }
    }
    
    public function nationalbulletin($id)
    {
        $row  = $this->db->get_where('bulletins', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
           
        
		$reportingperiod_id = $row->reportingperiod_id;
        $zone_id          = $row->zone_id;
		
		       
        $alerts = $this->alertsmodel->get_by_period_status($reportingperiod_id,0);
        
        //highlights section calculations
        //total zones
        $zones      = $this->zonesmodel->get_list();
        $totalzones = count($zones);
        
        //reporting health facilities
        $reportinghfs          = $this->reportingformsmodel->get_reporting_hf_by_period($reportingperiod_id);
        $totalhealthfacilities = $this->healthfacilitiesmodel->get_list();
        
        //health facilities percentage
        $totalreportinghf      = count($reportinghfs);
        $healthfacilitiescount = count($totalhealthfacilities);
        $percentagereporting   = ($totalreportinghf / $healthfacilitiescount) * 100;
        
        //current week consultations
        $consultations = $this->reportingformsmodel->sum_total_consultations($reportingperiod_id);
        foreach ($consultations as $ckey => $consultation):
            $totalconsultations = $consultation->Consultations;
        endforeach;
        
        if ($row->reportingperiod_id == 1) {
            $previousreporintperiod_id = 53;
        } else {
            $previousreporintperiod_id = ($reportingperiod_id - 1);
        }
        
        //get all the previous 10 reporting periods
        $periodthree_id = ($previousreporintperiod_id - 1);
        $periodfour_id  = ($periodthree_id - 1);
        $periodfive_id  = ($periodfour_id - 1);
        $periodsix_id   = ($periodfive_id - 1);
        $periodseven_id = ($periodsix_id - 1);
        $periodeight_id = ($periodseven_id - 1);
        $periodnine_id  = ($periodeight_id - 1);
        $periodten_id   = ($periodnine_id - 1);
        
        
        $reportingperiodone   = $this->epdcalendarmodel->get_by_id($reportingperiod_id)->row();
        $reportingperiodtwo   = $this->epdcalendarmodel->get_by_id($previousreporintperiod_id)->row();
        $reportingperiodthree = $this->epdcalendarmodel->get_by_id($periodthree_id)->row();
        $reportingperiodfour  = $this->epdcalendarmodel->get_by_id($periodfour_id)->row();
        $reportingperiodfive  = $this->epdcalendarmodel->get_by_id($periodfive_id)->row();
        $reportingperiodsix   = $this->epdcalendarmodel->get_by_id($periodsix_id)->row();
        $reportingperiodseven = $this->epdcalendarmodel->get_by_id($periodseven_id)->row();
        $reportingperiodeight = $this->epdcalendarmodel->get_by_id($periodeight_id)->row();
        $reportingperiodnine  = $this->epdcalendarmodel->get_by_id($periodnine_id)->row();
        $reportingperiodten   = $this->epdcalendarmodel->get_by_id($periodten_id)->row();
        
        //previous week consultations
        $previousconsultations = $this->reportingformsmodel->sum_total_consultations($previousreporintperiod_id);
        foreach ($previousconsultations as $pckey => $previousconsultation):
            $totalpreviousconsultations = $previousconsultation->Consultations;
        endforeach;
        
        //last 10 weeks consultations
        $weekthreeconsultations = $this->reportingformsmodel->sum_total_consultations($periodthree_id);
        foreach ($weekthreeconsultations as $wtkey => $weekthreeconsultation):
            $totalthreeconsultations = $weekthreeconsultation->Consultations;
        endforeach;
        
        $weekfourconsultations = $this->reportingformsmodel->sum_total_consultations($periodfour_id);
        foreach ($weekfourconsultations as $wfkey => $weekfourconsultation):
            $totalfourconsultations = $weekfourconsultation->Consultations;
        endforeach;
        
        $weekfiveconsultations = $this->reportingformsmodel->sum_total_consultations($periodfive_id);
        foreach ($weekfiveconsultations as $wkfkey => $weekfiveconsultation):
            $totalfiveconsultations = $weekfiveconsultation->Consultations;
        endforeach;
        
        $weeksixconsultations = $this->reportingformsmodel->sum_total_consultations($periodsix_id);
        foreach ($weeksixconsultations as $wskey => $weeksixconsultation):
            $totalsixconsultations = $weeksixconsultation->Consultations;
        endforeach;
        
        $weeksevenconsultations = $this->reportingformsmodel->sum_total_consultations($periodseven_id);
        foreach ($weeksevenconsultations as $wksevkey => $weeksevenconsultation):
            $totalsevenconsultations = $weeksevenconsultation->Consultations;
        endforeach;
        
        $weekeightconsultations = $this->reportingformsmodel->sum_total_consultations($periodeight_id);
        foreach ($weekeightconsultations as $wekey => $weekeightconsultation):
            $totaleightconsultations = $weekeightconsultation->Consultations;
        endforeach;
        
        $weeknineconsultations = $this->reportingformsmodel->sum_total_consultations($periodnine_id);
        foreach ($weeknineconsultations as $wknkey => $weeknineconsultation):
            $totalnineconsultations = $weeknineconsultation->Consultations;
        endforeach;
        
        $weektenconsultations = $this->reportingformsmodel->sum_total_consultations($periodten_id);
        foreach ($weektenconsultations as $wktkey => $weektenconsultation):
            $totaltenconsultations = $weektenconsultation->Consultations;
        endforeach;
        
        //get diseases from previous reportingperiod
        $previoussums = $this->reportingformsmodel->sum_diseases_by_period($previousreporintperiod_id);
        
        
        foreach ($previoussums as $pskey => $previoussum) {
            $prevsaritotal = $previoussum->sari_lt_5 + $previoussum->sari_gt_5;
            $previlitotal  = $previoussum->ili_lt_5 + $previoussum->ili_gt_5;
            $prevawdtotal  = $previoussum->awd_lt_5 + $previoussum->awd_gt_5;
            $prevbdtotal   = $previoussum->bd_lt_5 + $previoussum->bd_gt_5;
            $prevoadtotal  = $previoussum->oad_lt_5 + $previoussum->oad_gt_5;
            $prevdiphtotal = $previoussum->diph;
            $prevwctotal   = $previoussum->wc;
            $prevmeastotal = $previoussum->meas;
            $prevnnttotal  = $previoussum->nnt;
            $prevafptotal  = $previoussum->afp;
            $prevajstotal  = $previoussum->ajs;
            $prevvhftotal  = $previoussum->vhf;
            $prevmaltotal  = $previoussum->mal_lt_5 + $previoussum->mal_gt_5;
            $prevmentotal  = $previoussum->men;
            
            $previousdiseases = array(
                'SARI' => $prevsaritotal,
                'ILI' => $previlitotal,
                'AWD' => $prevawdtotal,
                'BD' => $prevbdtotal,
                'OAD' => $prevoadtotal,
                'Diph' => $prevdiphtotal,
                'WC' => $prevwctotal,
                'Meas' => $prevmeastotal,
                'NNT' => $prevnnttotal,
                'AFP' => $prevafptotal,
                'AJS' => $prevajstotal,
                'VHF' => $prevvhftotal,
                'Mal' => $prevmaltotal,
                'Men' => $prevmentotal
            );
            
        }
        
        
        $sumtables = $this->reportingformsmodel->sum_diseases_by_period($reportingperiod_id);
        
        foreach ($sumtables as $skey => $sumtable) {
            $saritotal = $sumtable->sari_lt_5 + $sumtable->sari_gt_5;
            $ilitotal  = $sumtable->ili_lt_5 + $sumtable->ili_gt_5;
            $awdtotal  = $sumtable->awd_lt_5 + $sumtable->awd_gt_5;
            $bdtotal   = $sumtable->bd_lt_5 + $sumtable->bd_gt_5;
            $oadtotal  = $sumtable->oad_lt_5 + $sumtable->oad_gt_5;
            $diphtotal = $sumtable->diph;
            $wctotal   = $sumtable->wc;
            $meastotal = $sumtable->meas;
            $nnttotal  = $sumtable->nnt;
            $afptotal  = $sumtable->afp;
            $ajstotal  = $sumtable->ajs;
            $vhftotal  = $sumtable->vhf;
            $maltotal  = $sumtable->mal_lt_5 + $sumtable->mal_gt_5;
            $mentotal  = $sumtable->men;
			
			$ocarr = array('Oc'=> $sumtable->oc);
            
            $agedist = array(
                'awd_lt_5' => $sumtable->awd_lt_5,
                'awd_gt_5' => $sumtable->awd_gt_5,
                'mal_lt_5' => $sumtable->mal_lt_5,
                'mal_gt_5' => $sumtable->mal_gt_5,
                'bd_lt_5' => $sumtable->bd_lt_5,
                'bd_gt_5' => $sumtable->bd_gt_5,
                'oad_lt_5' => $sumtable->oad_lt_5,
                'oad_gt_5' => $sumtable->oad_gt_5
            );
            
            $diseases = array(
                'SARI' => $saritotal,
                'ILI' => $ilitotal,
                'AWD' => $awdtotal,
                'BD' => $bdtotal,
                'OAD' => $oadtotal,
                'Diph' => $diphtotal,
                'WC' => $wctotal,
                'Meas' => $meastotal,
                'NNT' => $nnttotal,
                'AFP' => $afptotal,
                'AJS' => $ajstotal,
                'VHF' => $vhftotal,
                'Mal' => $maltotal,
                'Men' => $mentotal
            );
            
        }
        
        $totaldiseases     = array_sum($diseases);
        $highestdisease    = max($diseases);
        $percentagehighest = ($highestdisease / $totaldiseases) * 100;
        
        
        
        if ($highestdisease == $diseases['SARI']) {
            $leadingdisease = 'SARI';
        }
        
        if ($highestdisease == $diseases['ILI']) {
            $leadingdisease = 'ILI';
        }
        
        if ($highestdisease == $diseases['AWD']) {
            $leadingdisease = 'AWD';
        }
        
        if ($highestdisease == $diseases['BD']) {
            $leadingdisease = 'BD';
        }
        
        if ($highestdisease == $diseases['OAD']) {
            $leadingdisease = 'OAD';
        }
        
        if ($highestdisease == $diseases['Diph']) {
            $leadingdisease = 'Diph';
        }
        
        if ($highestdisease == $diseases['WC']) {
            $leadingdisease = 'WC';
        }
        
        if ($highestdisease == $diseases['Meas']) {
            $leadingdisease = 'Meas';
        }
        
        if ($highestdisease == $diseases['NNT']) {
            $leadingdisease = 'NNT';
        }
        
        if ($highestdisease == $diseases['AFP']) {
            $leadingdisease = 'AFP';
        }
        
        if ($highestdisease == $diseases['AJS']) {
            $leadingdisease = 'AJS';
        }
        
        if ($highestdisease == $diseases['VHF']) {
            $leadingdisease = 'VHF';
        }
        
        if ($highestdisease == $diseases['Men']) {
            $leadingdisease = 'Men';
        }
        
        if ($highestdisease == $diseases['Mal']) {
            $leadingdisease = 'Malaria';
        }
        
        
        if (empty($totalpreviousconsultations)) {
            $lastconsultations = 0;
        } else {
            $lastconsultations = $totalpreviousconsultations;
        }
        
        
        //get all the previous weeks percentages
        $reportinghfstwo = $this->reportingformsmodel->get_reporting_hf_by_period($previousreporintperiod_id);
        
        //health facilities percentage
        $totalreportinghftwo = count($reportinghfstwo);
        if ($totalreportinghftwo == 0) {
            $percentagereportingtwo = 0;
        } else {
            $percentagereportingtwo = ($totalreportinghftwo / $healthfacilitiescount) * 100;
        }
        
        $reportinghfsthree = $this->reportingformsmodel->get_reporting_hf_by_period($periodthree_id);
        
        //health facilities percentage
        $totalreportinghfthree = count($reportinghfsthree);
        if ($totalreportinghfthree == 0) {
            $percentagereportingthree = 0;
        } else {
            $percentagereportingthree = ($totalreportinghfthree / $healthfacilitiescount) * 100;
        }
        
        $reportinghfsfour = $this->reportingformsmodel->get_reporting_hf_by_period($periodfour_id);
        
        //health facilities percentage
        $totalreportinghffour = count($reportinghfsfour);
        if ($totalreportinghffour == 0) {
            $percentagereportingfour = 0;
        } else {
            $percentagereportingfour = ($totalreportinghffour / $healthfacilitiescount) * 100;
        }
        
        $reportinghfsfive = $this->reportingformsmodel->get_reporting_hf_by_period($periodfive_id);
        
        //health facilities percentage
        $totalreportinghffive = count($reportinghfsfive);
        if ($totalreportinghffive == 0) {
            $percentagereportingfive = 0;
        } else {
            $percentagereportingfive = ($totalreportinghffive / $healthfacilitiescount) * 100;
        }
        
        $reportinghfssix = $this->reportingformsmodel->get_reporting_hf_by_period($periodsix_id);
        
        //health facilities percentage
        $totalreportinghfsix = count($reportinghfssix);
        if ($totalreportinghfsix == 0) {
            $percentagereportingsix = 0;
        } else {
            $percentagereportingsix = ($totalreportinghfsix / $healthfacilitiescount) * 100;
        }
        
        $reportinghfsseven = $this->reportingformsmodel->get_reporting_hf_by_period($periodseven_id);
        
        //health facilities percentage
        $totalreportinghfseven = count($reportinghfsseven);
        if ($totalreportinghfseven == 0) {
            $percentagereportingseven = 0;
        } else {
            $percentagereportingseven = ($totalreportinghfseven / $healthfacilitiescount) * 100;
        }
        
        $reportinghfseight = $this->reportingformsmodel->get_reporting_hf_by_period($periodeight_id);
        
        //health facilities percentage
        $totalreportinghfeight = count($reportinghfseight);
        if ($totalreportinghfeight == 0) {
            $percentagereportingeight = 0;
        } else {
            $percentagereportingeight = ($totalreportinghfeight / $healthfacilitiescount) * 100;
        }
        
        $reportinghfsnine = $this->reportingformsmodel->get_reporting_hf_by_period($periodnine_id);
        
        //health facilities percentage
        $totalreportinghfnine = count($reportinghfsnine);
        if ($totalreportinghfnine == 0) {
            $percentagereportingnine = 0;
        } else {
            $percentagereportingnine = ($totalreportinghfnine / $healthfacilitiescount) * 100;
        }
        
        $reportinghfsten = $this->reportingformsmodel->get_reporting_hf_by_period($periodten_id);
        
        //health facilities percentage
        $totalreportinghften = count($reportinghfsten);
        if ($totalreportinghften == 0) {
            $percentagereportingten = 0;
        } else {
            $percentagereportingten = ($totalreportinghften / $healthfacilitiescount) * 100;
        }
        
        
        $percentagedata = number_format($percentagereportingten) . ',' . number_format($percentagereportingnine) . ',' . number_format($percentagereportingeight) . ',' . number_format($percentagereportingseven) . ',' . number_format($percentagereportingsix) . ',' . number_format($percentagereportingfive) . ',' . number_format($percentagereportingfour) . ',' . number_format($percentagereportingthree) . ',' . number_format($percentagereportingtwo) . ',' . number_format($percentagereporting);
        
        
        //the second graph
        
        $zonecategories    = "";
        $zonereportingrate = "";
        
        $allzones = $this->zonesmodel->get_list();
        foreach ($allzones as $azkey => $thezone) {
            $thezonehf          = $this->healthfacilitiesmodel->get_by_zone($thezone['id']);
            $zonereportinghfs   = $this->reportingformsmodel->get_reporting_hf_by_period_zone($row->reportingperiod_id, $thezone['id']);
            $hfsreportinginzone = count($zonereportinghfs);
            $hfsinzone          = count($thezonehf->result());
            if ($hfsreportinginzone == 0) {
                $percentagezonereporting = 0;
            } else {
                $percentagezonereporting = ($hfsreportinginzone / $hfsinzone) * 100;
            }
            
            $zonecategories .= "'" . $thezone['zone'] . "',";
            
            $zonereportingrate .= number_format($percentagezonereporting, 1) . ", ";
            
        }
        
        
        $epicalendar          = $this->epdcalendarmodel->get_by_id($previousreporintperiod_id)->row();
        $tenthreportingperiod = $this->epdcalendarmodel->get_by_id($periodten_id)->row();
        
        $static_highlight = '<div align="justify"><ul>';
        $static_highlight .= '<li>During Epi week ' . $row->week_no . '-' . $row->week_year . ', ' . number_format($percentagereporting) . '% (' . $totalreportinghf . '/' . $healthfacilitiescount . ') health facilities from ' . $totalzones . ' zones provided valid surveillance data.</li>';
        
        $static_highlight .= '<li>The total number of consultatations reported during the reporting week was ' . $totalconsultations . ' compared to ' . $lastconsultations . ' consultations during week ' . $epicalendar->week_no . '. The leading cause of mobirdity was ' . $leadingdisease . ', with over ' . $highestdisease . ' cases (' . number_format($percentagehighest, 1) . '%).</li>';
        
        $static_highlight .= '</ul></div>';
        
        //end highlights section
        //leading disease text
        $leadingdiseasetext = '<ul><li>';
        arsort($diseases);
        
        $totalleadingdiseases = 0;
        
        $j = 0;
        
        foreach ($diseases as $key => $value) {
            $j++;
            if ($j > 3) {
                
            } else {
                
                $totalleadingdiseases = $totalleadingdiseases + $value;
                
                if ($value == 0) {
                    $diseasepercentage = 0;
                } else {
                    $diseasepercentage = ($value / $totalconsultations) * 100;
                }
                
                if ($j == 3) {
                    $comma = '';
                } else {
                    $comma = ',';
                }
                $leadingdiseasetext .= $key . ' (' . number_format($diseasepercentage, 1) . '%)' . $comma . ' ';
                //echo $j.". ".$key." reported ".$value." cases <br />";
                
            }
            
            
        }
        
        if ($totalleadingdiseases == 0) {
            $totaldiseasepercent = 0;
        } else {
            $totaldiseasepercent = ($totalleadingdiseases / $totalconsultations) * 100;
        }
        
        $leadingdiseasetext .= 'remain the leading causes of morbidity representing a total of ' . number_format($totaldiseasepercent, 1) . '%.</li>';
        
        if ($diseases['SARI'] == 0) {
            $saripercentage = 0;
        } else {
            $saripercentage = ($diseases['SARI'] / $totalconsultations) * 100;
        }
        
        if ($diseases['AWD'] == 0) {
            $awdpercentage = 0;
        } else {
            $awdpercentage = ($diseases['AWD'] / $totalconsultations) * 100;
        }
        
        if ($diseases['AJS'] == 0) {
            $ajspercentage = 0;
        } else {
            $ajspercentage = ($diseases['AJS'] / $totalconsultations) * 100;
        }
        
        if ($diseases['BD'] == 0) {
            $bdpercentage = 0;
        } else {
            $bdpercentage = ($diseases['BD'] / $totalconsultations) * 100;
        }
        
        $diseasearray = array(
            'saripercentage' => $saripercentage,
            'awdpercentage' => $awdpercentage,
            'ajspercentage' => $ajspercentage
        );
        
        $highestpercentage = max($diseasearray);
        
        $alldiarrhea = ($diseases['AWD'] + $diseases['BD'] + $diseases['OAD']);
        
        if ($alldiarrhea == 0) {
            $alldiarrheapercentage = 0;
        } else {
            $alldiarrheapercentage = ($alldiarrhea / $totalconsultations) * 100;
        }
        
        if ($diseases['ILI'] == 0) {
            $ilipercentage = 0;
        } else {
            $ilipercentage = ($diseases['ILI'] / $totalconsultations) * 100;
        }
        
        $leadingdiseasetext .= '<li>SARI, acute watery diarrhea and AJS represented less than ' . number_format($highestpercentage, 1) . '% of total morbidity in reporting period. Bloody  diarrhea represented ' . number_format($bdpercentage, 1) . '% of this morbidity.</li>';
        
        $leadingdiseasetext .= '<li>All diarrheal diseases comprised ' . number_format($alldiarrheapercentage, 1) . '% and ILI ' . number_format($ilipercentage, 1) . '% of total morbidity in all zones this week.</li>';
        $leadingdiseasetext .= '</ul>';
        
        
        //leading disease table
        $leadingdiseasetable = '
		<style>
				#datatable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#datatable td, #listtable th 
				{
				font-size:0.9em;
				border:1px solid #892A24;
				padding:3px 7px 2px 7px;
				}
				#datatable th 
				{
				font-size:0.9em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#892A24;
				color:#fff;
				}
				#datatable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>';
        
        $leadingdiseasetable .= '<table border="1" id="datatable">';
        $leadingdiseasetable .= '<tr bgcolor="#892A24" bordercolor="#892A24"><td><font color="#FFFFFF">Leading Diseases</font></td><td colspan="2"><center><font color="#FFFFFF">Epi week ' . $row->week_no . '</font></center></td><td colspan="2"><center><font color="#FFFFFF">Epi week ' . $epicalendar->week_no . '</font></center></td></tr>';
        $leadingdiseasetable .= '<tr bgcolor="#892A24"><td>&nbsp;</td><td><font color="#FFFFFF">Cases</font></td><td><font color="#FFFFFF">Percentage</font></td><td><font color="#FFFFFF">Cases</font></td><td><font color="#FFFFFF">Percentage</font></td></tr>';
        
        //add the previous Epi week's disease data
        $diseasekey                   = array_keys($previousdiseases);
        $totalprevdiseases            = array_sum($previousdiseases);
        $totalleadingoreviousdiseases = 0;
        //the disease keys are 0-13
        //Array ( [0] => SARI [1] => ILI [2] => AWD [3] => BD [4] => OAD [5] => Diph [6] => WC [7] => Meas [8] => NNT [9] => AFP [10] => AJS [11] => VHF [12] => Mal [13] => Men )
        $x                            = 0;
        foreach ($diseases as $key => $value) {
            $x++;
            if ($x > 3) {
                
            } else {
                if ($value == 0) {
                    $diseasepercentage = 0;
                } else {
                    $diseasepercentage = ($value / $totalconsultations) * 100;
                }
                
                //compare with previous diseases keys and display on table
                if ($key == $diseasekey[0]) {
                    if ($previousdiseases['SARI'] == 0 && empty($previousdiseases['SARI'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['SARI'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['SARI'];
                    $prevsection                  = '<td><center>' . $previousdiseases['SARI'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[1]) {
                    if ($previousdiseases['ILI'] == 0 && empty($previousdiseases['ILI'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['ILI'] / $totalprevdiseases) * 100;
                    }
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['ILI'];
                    $prevsection                  = '<td><center>' . $previousdiseases['ILI'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[2]) {
                    if ($previousdiseases['AWD'] == 0 && empty($previousdiseases['AWD'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['AWD'] / $totalprevdiseases) * 100;
                    }
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['AWD'];
                    $prevsection                  = '<td><center>' . $previousdiseases['AWD'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[3]) {
                    if ($previousdiseases['BD'] == 0 && empty($previousdiseases['BD'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['BD'] / $totalprevdiseases) * 100;
                    }
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['BD'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['BD'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[4]) {
                    if ($previousdiseases['OAD'] == 0 && empty($previousdiseases['OAD'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['OAD'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['OAD'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['OAD'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[5]) {
                    if ($previousdiseases['Diph'] == 0 && empty($previousdiseases['Diph'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['Diph'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['Diph'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['Diph'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[6]) {
                    if ($previousdiseases['WC'] == 0 && empty($previousdiseases['WC'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['WC'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['WC'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['WC'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[7]) {
                    if ($previousdiseases['Meas'] == 0 && empty($previousdiseases['Meas'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['Meas'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['Meas'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['Meas'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[8]) {
                    if ($previousdiseases['NNT'] == 0 && empty($previousdiseases['NNT'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['NNT'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['NNT'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['NNT'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[9]) {
                    if ($previousdiseases['AFP'] == 0 && empty($previousdiseases['AFP'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['AFP'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['AFP'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['AFP'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[10]) {
                    if ($previousdiseases['AJS'] == 0 && empty($previousdiseases['AJS'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['AJS'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['AJS'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['AJS'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[11]) {
                    if ($previousdiseases['VHF'] == 0 && empty($previousdiseases['VHF'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['VHF'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['VHF'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['VHF'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[12]) {
                    if ($previousdiseases['Mal'] == 0 && empty($previousdiseases['Mal'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['Mal'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['Mal'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['Mal'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                if ($key == $diseasekey[13]) {
                    if ($previousdiseases['Men'] == 0 && empty($previousdiseases['Men'])) {
                        $prevdiseasepercentage = 0;
                    } else {
                        $prevdiseasepercentage = ($previousdiseases['Men'] / $totalprevdiseases) * 100;
                    }
                    
                    $totalleadingoreviousdiseases = $totalleadingoreviousdiseases + $previousdiseases['Men'];
                    
                    $prevsection = '<td><center>' . $previousdiseases['Men'] . '</center></td><td><center>' . number_format($prevdiseasepercentage, 1) . '%</center></td>';
                }
                
                $leadingdiseasetable .= '<tr><td>' . $key . '</td><td><center>' . $value . '</center></td><td><center>' . number_format($diseasepercentage, 1) . '%</center></td>' . $prevsection . '</td></tr>';
            }
        }
        
        //print_r($previousdiseases);
		
		        
        $otherconsultations = ($totalconsultations - $totalleadingdiseases);
        if ($otherconsultations == 0) {
            $otherconsultpercentage = 0;
        } else {
            $otherconsultpercentage = ($otherconsultations / $totalconsultations) * 100;
        }
        
		//this calculates the other consultations values for the leading diseases table
        $otherprevconsultations = ($totalpreviousconsultations - $totalleadingoreviousdiseases);
        if ($otherprevconsultations == 0) {
            $otherprevconsultationspercentage = 0;
        } else {
            $otherprevconsultationspercentage = ($otherprevconsultations / $totalpreviousconsultations) * 100;
        }
		
		if(empty($totalpreviousconsultations))
		{
			$totalpreviousdiseases = 0;
		}
		else
		{
			$totalpreviousdiseases = $totalpreviousconsultations;
		}
	
        
        $leadingdiseasetable .= '<tr><td>Other Consultations</td><td><center>' . $otherconsultations . '</center></td><td><center>' . number_format($otherconsultpercentage, 1) . '%</center></td><td><center>' . $otherprevconsultations . '</center></td><td><center>' . number_format($otherprevconsultationspercentage, 1) . '%</center></td></tr>';
        $leadingdiseasetable .= '<tr bgcolor="#892A24"><td><font color="#FFFFFF">Total Consultations</font></td><td><font color="#FFFFFF">' . $totalconsultations . '</font></td><td><font color="#FFFFFF">100%</font></td><td><font color="#FFFFFF">' . $totalpreviousdiseases . '</font></td><td><font color="#FFFFFF">100%</font></td></tr>';
        $leadingdiseasetable .= '</table>';
        //end leading disease section
		
		
		//map section
	   
	   $weekNumber = date("W");
	   $reportingyear = date('Y');
	   
	   if($weekNumber > 3)
	   {
		   $firstreporingyear = date('Y');
		   $lastthreeweeks = $weekNumber-3;
	   }
	   else
	   {
		   $thisyear =  date('Y');
		   $lastyear = $thisyear-1;
		   $firstreporingyear = $lastyear;
		   
		   if($weekNumber==3)
		   {
			   $lastthreeweeks = 1;
		   }
		   
		   if($weekNumber==2)
		   {
			   $lastthreeweeks = 52;
		   }
		   
		   if($weekNumber==1)
		   {
			   $lastthreeweeks = 51;
		   }
		    
	   }
	   
	   $data['lastthreeweeks'] = $lastthreeweeks;
	   
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($firstreporingyear,$lastthreeweeks)->row();
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reportingyear,$weekNumber)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	   
	   $rows = $this->alertsmodel->get_by_locations(0,0,0,$period_one,$period_two,$reportingyear, $reportingyear,0);
	   
	   foreach ($rows as $key=>$alertrow): 
		
			$district = $this->districtsmodel->get_by_id($alertrow->district_id)->row();
			$healthfacility = $this->healthfacilitiesmodel->get_by_id($alertrow->healthfacility_id)->row();
			$alertzone = $this->zonesmodel->get_by_id($alertrow->zone_id)->row();
			$alertregion = $this->regionsmodel->get_by_id($alertrow->region_id)->row();
			$reportingform = $this->reportingformsmodel->get_by_id($alertrow->reportingform_id)->row();
			$user = $this->usersmodel->get_by_id($reportingform->user_id)->row();
			
			if(empty($user))
			{
				$reporter = '';
				$contacts = '';
			}
			else
			{
				$reporter =$user->username;
				$contacts = $user->contact_number;
			}
			
						
			if(!empty($district->lat))
			{
			   $gps['lat'] = $district->lat;
			   $gps['lng'] = $district->long;
			   
			   $mapdata['position'] = $gps;
			   
			   if($alertrow->disease_name=='SARI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vbd.png';
			   }
			   
			   if($alertrow->disease_name=='ILI')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vbd.png';
			   }
			   
			   if($alertrow->disease_name=='AWD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   if($alertrow->disease_name=='BD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   
			   if($alertrow->disease_name=='OAD')
			   {
				   $mapdata['icon'] = ''.base_url().'img/wbd.png';
			   }
			   
			   if($alertrow->disease_name=='Diph')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($alertrow->disease_name=='WC')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($alertrow->disease_name=='Meas')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($alertrow->disease_name=='NNT')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($alertrow->disease_name=='AFP')
			   {
				   $mapdata['icon'] = ''.base_url().'img/vpd.png';
			   }
			   
			   if($alertrow->disease_name=='AJS')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($alertrow->disease_name=='VHF')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($alertrow->disease_name=='Mal')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($alertrow->disease_name=='Men')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   
			   if($alertrow->disease_name=='UnDis')
			   {
				   $mapdata['icon'] = ''.base_url().'img/other.png';
			   }
			   			   
			   $mapdata['info'] = '
			   Zone: '.$alertzone->zone.'<br>
			   Region: '.$alertregion->region.'<br>
			   District: '.$district->district.'<br>
			   Health Facility: '.$healthfacility->health_facility.'<br>
			   Alert: '.$alertrow->disease_name.'<br>
			   Cases: '.$alertrow->cases.'<br>
			   Date Reported: '.date("d F Y", strtotime($reportingform->entry_date)).'<br>
			   Time reported: '.$reportingform->entry_time.'<br>
			   Reported by: '.$reporter.'<br>
			   Contacts: '.$contacts.'';
			   
			   $points[] = $mapdata;
			}
		
		endforeach;
		
		$data['points'] = $points;
		
		  
        
        //proportioanl morbidity
        $proportionalmorbiditytable = '
		<style>
				#zonedist
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#zonedist td, #zonedist th 
				{
				font-size:0.7em;
				border:1px solid #892A24;
				padding:3px 7px 2px 7px;
				}
				#zonedist th 
				{
				font-size:0.7em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#892A24;
				color:#fff;
				}
				#zonedist tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>';
        
        
        $proportionalmorbiditytable .= '<table id="zonedist">';
        $proportionalmorbiditytable .= '<tr bgcolor="#892A24"><td><font color="#FFFFFF"><strong>Priority Diseases under surveillance</strong></font></td>';
        foreach ($allzones as $azkey => $thezone) {
            $proportionalmorbiditytable .= '<td valign="top"><font color="#FFFFFF"><strong>' . $thezone['zone'] . '</strong></font></td>';
        }
        $proportionalmorbiditytable .= '</tr>';
        
        $zonealconsultations = array();
      
        foreach ($diseases as $key => $value) {
			if($key=='BD'||$key=='AWD'||$key=='Meas'||$key=='AFP'||$key=='WC'||$key=='Mal'||$key=='NNT')
			{
            $proportionalmorbiditytable .= '<tr><td>' . $key . '</td>';
            foreach ($allzones as $azkey => $thezone) {
                
                $zonalsums = $this->reportingformsmodel->sum_diseases_by_period_zone($row->reportingperiod_id, $thezone['id']);
                
                foreach ($zonalsums as $skey => $zonalsums) {
                    $sari_total = $zonalsums->sari_lt_5 + $zonalsums->sari_gt_5;
                    $ili_total  = $zonalsums->ili_lt_5 + $zonalsums->ili_gt_5;
                    $awd_total  = $zonalsums->awd_lt_5 + $zonalsums->awd_gt_5;
                    $bd_total   = $zonalsums->bd_lt_5 + $zonalsums->bd_gt_5;
                    $oad_total  = $zonalsums->oad_lt_5 + $zonalsums->oad_gt_5;
                    $diph_total = $zonalsums->diph;
                    $wc_total   = $zonalsums->wc;
                    $meas_total = $zonalsums->meas;
                    $nnt_total  = $zonalsums->nnt;
                    $afp_total  = $zonalsums->afp;
                    $ajs_total  = $zonalsums->ajs;
                    $vhf_total  = $zonalsums->vhf;
                    $mal_total  = $zonalsums->mal_lt_5 + $zonalsums->mal_gt_5;
                    $men_total  = $zonalsums->men;
					$oc_total  = $zonalsums->oc;
					
					$consarray = array('Cons' => $zonalsums->Cons);
                    
                    $zonaldiseases = array(
                        'SARI' => $sari_total,
                        'ILI' => $ili_total,
                        'AWD' => $awd_total,
                        'BD' => $bd_total,
                        'OAD' => $oad_total,
                        'Diph' => $diph_total,
                        'WC' => $wc_total,
                        'Meas' => $meas_total,
                        'NNT' => $nnt_total,
                        'AFP' => $afp_total,
                        'AJS' => $ajs_total,
                        'VHF' => $vhf_total,
                        'Mal' => $mal_total,
                        'Men' => $men_total
						
                    );
                    
                }
                //calculate consultation for each zone
                //$totalzonalconsult = array_sum($zonaldiseases);
				if(empty($consarray['Cons']))
				{
					$totalzonalconsult =0;
				}
				else
				{
					$totalzonalconsult = $consarray['Cons'];
				}
				
												
				$zonealconsultations[] = $totalzonalconsult;
				
				$prioritydiseasestotal = $zonaldiseases['BD'] + $zonaldiseases['AWD'] +$zonaldiseases['Meas'] + $zonaldiseases['AFP']+$zonaldiseases['WC']+$zonaldiseases['Mal']+$zonaldiseases['NNT'];
				
				$otherzonalconsultations[] = ($totalzonalconsult-$prioritydiseasestotal);
									
                //get the diseases for each zone and calculate percentages
                foreach ($zonaldiseases as $zonkey => $zonaldisease) {
                    if ($zonkey == $key) {
                        if (empty($zonaldisease)) {
                            $proportionalmorbiditytable .= '<td>0 (0.0%)</td>';
                        } else {
                            if ($zonaldisease == 0) {
                                $percentagedisease = 0;
                            } else {
                                $percentagedisease = ($zonaldisease / $totalzonalconsult) * 100;
                                
                                $proportionalmorbiditytable .= '<td>' . $zonaldisease . ' (' . number_format($percentagedisease, 1) . '%)</td>';
                            }
                        }
                    }
                }
                
                
            }
            $proportionalmorbiditytable .= '</tr>';
			}
        }
		
		$uppervalue = $totalzones - 1;
		$proportionalmorbiditytable .= '<tr><td>Other consultatioins</td>';
		 for ($oi = 0; $oi <= $uppervalue; $oi++) {
			
			if($otherzonalconsultations[$oi]==0)
			{
				$otherzonalconsultpercent = 0;
			}
			else
			{
				$otherzonalconsultpercent = ($otherzonalconsultations[$oi]/$zonealconsultations[$oi])*100;
			}
			
			
			$proportionalmorbiditytable .= '<td>'.$otherzonalconsultations[$oi].' ('.number_format($otherzonalconsultpercent,1).'%)</td>';
		}
		
		$proportionalmorbiditytable .= '</tr>';
				
        $proportionalmorbiditytable .= '<tr bgcolor="#892A24"><td><font color="#FFFFFF"><strong>Total consultations</strong></font></td>';
        //display the total consultation for each zone
        
        for ($zi = 0; $zi <= $uppervalue; $zi++) {
            $proportionalmorbiditytable .= '<td><font color="#FFFFFF"><strong>' . $zonealconsultations[$zi] . '</strong></font></td>';
        }
        $proportionalmorbiditytable .= '</tr>';
        $proportionalmorbiditytable .= '</table>';
        
        //trends for leading priority diseases
        /**
        This is the section for calculating the trends for leading priority diseases
        **/
        $weekonedd = $diseases['AWD'] + $diseases['BD'] + $diseases['OAD'];
        if ($weekonedd == 0) {
            $weekoneddpercentage = 0;
        } else {
            $weekoneddpercentage = ($weekonedd / $totalconsultations) * 100;
        }
        
        $weekoneili = $diseases['ILI'];
        $weekonemal = $diseases['Mal'];
        
        if ($weekoneili == 0) {
            $weekoneilipercentage = 0;
        } else {
            $weekoneilipercentage = ($weekoneili / $totalconsultations) * 100;
        }
        
        if ($weekonemal == 0) {
            $weekonemalpercentage = 0;
        } else {
            $weekonemalpercentage = ($weekonemal / $totalconsultations) * 100;
        }
        
        //previous week diseases
        $previousdiseases = $this->reportingformsmodel->disease_sum_period($previousreporintperiod_id);
        foreach ($previousdiseases as $pvdkey => $previousdisease):
            $sari_prevtotal = $previousdisease->sari_lt_5 + $previousdisease->sari_gt_5;
            $ili_prevtotal  = $previousdisease->ili_lt_5 + $previousdisease->ili_gt_5;
            $awd_prevtotal  = $previousdisease->awd_lt_5 + $previousdisease->awd_gt_5;
            $bd_prevtotal   = $previousdisease->bd_lt_5 + $previousdisease->bd_gt_5;
            $oad_prevtotal  = $previousdisease->oad_lt_5 + $previousdisease->oad_gt_5;
            $diph_prevtotal = $previousdisease->diph;
            $wc_prevtotal   = $previousdisease->wc;
            $meas_prevtotal = $previousdisease->meas;
            $nnt_prevtotal  = $previousdisease->nnt;
            $afp_prevtotal  = $previousdisease->afp;
            $ajs_prevtotal  = $previousdisease->ajs;
            $vhf_prevtotal  = $previousdisease->vhf;
            $mal_prevtotal  = $previousdisease->mal_lt_5 + $previousdisease->mal_gt_5;
            $men_prevtotal  = $previousdisease->men;
            $wktwodiseases = array(
                'SARI' => $sari_prevtotal,
                'ILI' => $ili_prevtotal,
                'AWD' => $awd_prevtotal,
                'BD' => $bd_prevtotal,
                'OAD' => $oad_prevtotal,
                'Diph' => $diph_prevtotal,
                'WC' => $wc_prevtotal,
                'Meas' => $meas_prevtotal,
                'NNT' => $nnt_prevtotal,
                'AFP' => $afp_prevtotal,
                'AJS' => $ajs_prevtotal,
                'VHF' => $vhf_prevtotal,
                'Mal' => $mal_prevtotal,
                'Men' => $men_prevtotal
            );
        endforeach;
        
        $weektwodd = $wktwodiseases['AWD'] + $wktwodiseases['BD'] + $wktwodiseases['OAD'];
        
        if ($weektwodd == 0) {
            $weektwoddpercentage = 0;
        } else {
            $weektwoddpercentage = ($weektwodd / $totalpreviousconsultations) * 100;
        }
        
        $weektwoili = $wktwodiseases['ILI'];
        $weektwomal = $wktwodiseases['Mal'];
        
        if ($weektwoili == 0) {
            $weektwoilipercentage = 0;
        } else {
            $weektwoilipercentage = ($weektwoili / $totalpreviousconsultations) * 100;
        }
        
        if ($weektwomal == 0) {
            $weektwomalpercentage = 0;
        } else {
            $weektwomalpercentage = ($weektwomal / $totalconsultations) * 100;
        }
        
        //last 10 weeks diseases
        $weekthreediseases = $this->reportingformsmodel->disease_sum_period($periodthree_id);
        foreach ($weekthreediseases as $wktkey => $weekthreedisease):
            $sari_threetotal = $weekthreedisease->sari_lt_5 + $weekthreedisease->sari_gt_5;
            $ili_threetotal  = $weekthreedisease->ili_lt_5 + $weekthreedisease->ili_gt_5;
            $awd_threetotal  = $weekthreedisease->awd_lt_5 + $weekthreedisease->awd_gt_5;
            $bd_threetotal   = $weekthreedisease->bd_lt_5 + $weekthreedisease->bd_gt_5;
            $oad_threetotal  = $weekthreedisease->oad_lt_5 + $weekthreedisease->oad_gt_5;
            $diph_threetotal = $weekthreedisease->diph;
            $wc_threetotal   = $weekthreedisease->wc;
            $meas_threetotal = $weekthreedisease->meas;
            $nnt_threetotal  = $weekthreedisease->nnt;
            $afp_threetotal  = $weekthreedisease->afp;
            $ajs_threetotal  = $weekthreedisease->ajs;
            $vhf_threetotal  = $weekthreedisease->vhf;
            $mal_threetotal  = $weekthreedisease->mal_lt_5 + $weekthreedisease->mal_gt_5;
            $men_threetotal  = $weekthreedisease->men;
            $wkthreediseases = array(
                'SARI' => $sari_threetotal,
                'ILI' => $ili_threetotal,
                'AWD' => $awd_threetotal,
                'BD' => $bd_threetotal,
                'OAD' => $oad_threetotal,
                'Diph' => $diph_threetotal,
                'WC' => $wc_threetotal,
                'Meas' => $meas_threetotal,
                'NNT' => $nnt_threetotal,
                'AFP' => $afp_threetotal,
                'AJS' => $ajs_threetotal,
                'VHF' => $vhf_threetotal,
                'Mal' => $mal_threetotal,
                'Men' => $men_threetotal
            );
        endforeach;
        
        $weekthreedd = $wkthreediseases['AWD'] + $wkthreediseases['BD'] + $wkthreediseases['OAD'];
        if ($weekonedd == 0) {
            $weekthreeddpercentage = 0;
        } else {
            $weekthreeddpercentage = ($weekthreedd / $totalthreeconsultations) * 100;
        }
        
        $weekthreeili = $wkthreediseases['ILI'];
        $weekthreemal = $wkthreediseases['Mal'];
        
        if ($weekthreeili == 0) {
            $weekthreeilipercentage = 0;
        } else {
            $weekthreeilipercentage = ($weekthreeili / $totalpreviousconsultations) * 100;
        }
        
        if ($weekthreemal == 0) {
            $weekthreemalpercentage = 0;
        } else {
            $weekthreemalpercentage = ($weekthreemal / $totalconsultations) * 100;
        }
        
        
        $weekfourdiseases = $this->reportingformsmodel->disease_sum_period($periodfour_id);
        foreach ($weekfourdiseases as $wkfkey => $weekfourdisease):
            $sari_fourtotal = $weekfourdisease->sari_lt_5 + $weekfourdisease->sari_gt_5;
            $ili_fourtotal  = $weekfourdisease->ili_lt_5 + $weekfourdisease->ili_gt_5;
            $awd_fourtotal  = $weekfourdisease->awd_lt_5 + $weekfourdisease->awd_gt_5;
            $bd_fourtotal   = $weekfourdisease->bd_lt_5 + $weekfourdisease->bd_gt_5;
            $oad_fourtotal  = $weekfourdisease->oad_lt_5 + $weekfourdisease->oad_gt_5;
            $diph_fourtotal = $weekfourdisease->diph;
            $wc_fourtotal   = $weekfourdisease->wc;
            $meas_fourtotal = $weekfourdisease->meas;
            $nnt_fourtotal  = $weekfourdisease->nnt;
            $afp_fourtotal  = $weekfourdisease->afp;
            $ajs_fourtotal  = $weekfourdisease->ajs;
            $vhf_fourtotal  = $weekfourdisease->vhf;
            $mal_fourtotal  = $weekfourdisease->mal_lt_5 + $weekfourdisease->mal_gt_5;
            $men_fourtotal  = $weekfourdisease->men;
            $wkfourdiseases = array(
                'SARI' => $sari_fourtotal,
                'ILI' => $ili_fourtotal,
                'AWD' => $awd_fourtotal,
                'BD' => $bd_fourtotal,
                'OAD' => $oad_fourtotal,
                'Diph' => $diph_fourtotal,
                'WC' => $wc_fourtotal,
                'Meas' => $meas_fourtotal,
                'NNT' => $nnt_fourtotal,
                'AFP' => $afp_fourtotal,
                'AJS' => $ajs_fourtotal,
                'VHF' => $vhf_fourtotal,
                'Mal' => $mal_fourtotal,
                'Men' => $men_fourtotal
            );
        endforeach;
        $weekfourdd = $wkfourdiseases['AWD'] + $wkfourdiseases['BD'] + $wkfourdiseases['OAD'];
        
        if ($weekfourdd == 0) {
            $weekfourpercentage = 0;
        } else {
            $weekfourpercentage = ($weekfourdd / $totalfourconsultations) * 100;
        }
        
        $weekfourili = $wkfourdiseases['ILI'];
        $weekfourmal = $wkfourdiseases['Mal'];
        
        if ($weekfourili == 0) {
            $weekfourilipercentage = 0;
        } else {
            $weekfourilipercentage = ($weekfourili / $totalpreviousconsultations) * 100;
        }
        
        if ($weekfourmal == 0) {
            $weekfourmalpercentage = 0;
        } else {
            $weekfourmalpercentage = ($weekfourmal / $totalconsultations) * 100;
        }
        
        $weekfivediseases = $this->reportingformsmodel->disease_sum_period($periodfive_id);
        foreach ($weekfivediseases as $wkfvkey => $weekfivedisease):
            $sari_fivetotal = $weekfivedisease->sari_lt_5 + $weekfivedisease->sari_gt_5;
            $ili_fivetotal  = $weekfivedisease->ili_lt_5 + $weekfivedisease->ili_gt_5;
            $awd_fivetotal  = $weekfivedisease->awd_lt_5 + $weekfivedisease->awd_gt_5;
            $bd_fivetotal   = $weekfivedisease->bd_lt_5 + $weekfivedisease->bd_gt_5;
            $oad_fivetotal  = $weekfivedisease->oad_lt_5 + $weekfivedisease->oad_gt_5;
            $diph_fivetotal = $weekfivedisease->diph;
            $wc_fivetotal   = $weekfivedisease->wc;
            $meas_fivetotal = $weekfivedisease->meas;
            $nnt_fivetotal  = $weekfivedisease->nnt;
            $afp_fivetotal  = $weekfivedisease->afp;
            $ajs_fivetotal  = $weekfivedisease->ajs;
            $vhf_fivetotal  = $weekfivedisease->vhf;
            $mal_fivetotal  = $weekfivedisease->mal_lt_5 + $weekfivedisease->mal_gt_5;
            $men_fivetotal  = $weekfivedisease->men;
            $wkfivediseases = array(
                'SARI' => $sari_fivetotal,
                'ILI' => $ili_fivetotal,
                'AWD' => $awd_fivetotal,
                'BD' => $bd_fivetotal,
                'OAD' => $oad_fivetotal,
                'Diph' => $diph_fivetotal,
                'WC' => $wc_fivetotal,
                'Meas' => $meas_fivetotal,
                'NNT' => $nnt_fivetotal,
                'AFP' => $afp_fivetotal,
                'AJS' => $ajs_fivetotal,
                'VHF' => $vhf_fivetotal,
                'Mal' => $mal_fivetotal,
                'Men' => $men_fivetotal
                
            );
        endforeach;
        $weekfivedd = $wkfivediseases['AWD'] + $wkfivediseases['BD'] + $wkfivediseases['OAD'];
        if ($weekfivedd == 0) {
            $weekfivepercentage = 0;
        } else {
            $weekfivepercentage = ($weekfivedd / $totalfiveconsultations) * 100;
        }
        
        $weekfiveili = $wkfivediseases['ILI'];
        $weekfivemal = $wkfivediseases['Mal'];
        
        if ($weekfiveili == 0) {
            $weekfiveilipercentage = 0;
        } else {
            $weekfiveilipercentage = ($weekfiveili / $totalpreviousconsultations) * 100;
        }
        
        if ($weekfivemal == 0) {
            $weekfivemalpercentage = 0;
        } else {
            $weekfivemalpercentage = ($weekfivemal / $totalconsultations) * 100;
        }
        
        $weeksixdiseases = $this->reportingformsmodel->disease_sum_period($periodsix_id);
        foreach ($weeksixdiseases as $wkskey => $weeksixdisease):
            $sari_sixtotal = $weeksixdisease->sari_lt_5 + $weeksixdisease->sari_gt_5;
            $ili_sixtotal  = $weeksixdisease->ili_lt_5 + $weeksixdisease->ili_gt_5;
            $awd_sixtotal  = $weeksixdisease->awd_lt_5 + $weeksixdisease->awd_gt_5;
            $bd_sixtotal   = $weeksixdisease->bd_lt_5 + $weeksixdisease->bd_gt_5;
            $oad_sixtotal  = $weeksixdisease->oad_lt_5 + $weeksixdisease->oad_gt_5;
            $diph_sixtotal = $weeksixdisease->diph;
            $wc_sixtotal   = $weeksixdisease->wc;
            $meas_sixtotal = $weeksixdisease->meas;
            $nnt_sixtotal  = $weeksixdisease->nnt;
            $afp_sixtotal  = $weeksixdisease->afp;
            $ajs_sixtotal  = $weeksixdisease->ajs;
            $vhf_sixtotal  = $weeksixdisease->vhf;
            $mal_sixtotal  = $weeksixdisease->mal_lt_5 + $weeksixdisease->mal_gt_5;
            $men_sixtotal  = $weeksixdisease->men;
            $wksixdiseases = array(
                'SARI' => $sari_sixtotal,
                'ILI' => $ili_sixtotal,
                'AWD' => $awd_sixtotal,
                'BD' => $bd_sixtotal,
                'OAD' => $oad_sixtotal,
                'Diph' => $diph_sixtotal,
                'WC' => $wc_sixtotal,
                'Meas' => $meas_sixtotal,
                'NNT' => $nnt_sixtotal,
                'AFP' => $afp_sixtotal,
                'AJS' => $ajs_sixtotal,
                'VHF' => $vhf_sixtotal,
                'Mal' => $mal_sixtotal,
                'Men' => $men_sixtotal
                
            );
        endforeach;
        $weeksixdd = $wksixdiseases['AWD'] + $wksixdiseases['BD'] + $wksixdiseases['OAD'];
        if ($weeksixdd == 0) {
            $weeksixpercentage = 0;
        } else {
            $weeksixpercentage = ($weeksixdd / $totalsixconsultations) * 100;
        }
        
        $weeksixili = $wksixdiseases['ILI'];
        $weeksixmal = $wksixdiseases['Mal'];
        
        if ($weeksixili == 0) {
            $weeksixilipercentage = 0;
        } else {
            $weeksixilipercentage = ($weeksixili / $totalpreviousconsultations) * 100;
        }
        
        if ($weeksixmal == 0) {
            $weeksixmalpercentage = 0;
        } else {
            $weeksixmalpercentage = ($weeksixmal / $totalconsultations) * 100;
        }
        
        $weeksevendiseases = $this->reportingformsmodel->disease_sum_period($periodseven_id);
        foreach ($weeksevendiseases as $wksevnkey => $weeksevendisease):
            $sari_seventotal = $weeksevendisease->sari_lt_5 + $weeksevendisease->sari_gt_5;
            $ili_seventotal  = $weeksevendisease->ili_lt_5 + $weeksevendisease->ili_gt_5;
            $awd_seventotal  = $weeksevendisease->awd_lt_5 + $weeksevendisease->awd_gt_5;
            $bd_seventotal   = $weeksevendisease->bd_lt_5 + $weeksevendisease->bd_gt_5;
            $oad_seventotal  = $weeksevendisease->oad_lt_5 + $weeksevendisease->oad_gt_5;
            $diph_seventotal = $weeksevendisease->diph;
            $wc_seventotal   = $weeksevendisease->wc;
            $meas_seventotal = $weeksevendisease->meas;
            $nnt_seventotal  = $weeksevendisease->nnt;
            $afp_seventotal  = $weeksevendisease->afp;
            $ajs_seventotal  = $weeksevendisease->ajs;
            $vhf_seventotal  = $weeksevendisease->vhf;
            $mal_seventotal  = $weeksevendisease->mal_lt_5 + $weeksevendisease->mal_gt_5;
            $men_seventotal  = $weeksevendisease->men;
            $wksevendiseases = array(
                'SARI' => $sari_seventotal,
                'ILI' => $ili_seventotal,
                'AWD' => $awd_seventotal,
                'BD' => $bd_seventotal,
                'OAD' => $oad_seventotal,
                'Diph' => $diph_seventotal,
                'WC' => $wc_seventotal,
                'Meas' => $meas_seventotal,
                'NNT' => $nnt_seventotal,
                'AFP' => $afp_seventotal,
                'AJS' => $ajs_seventotal,
                'VHF' => $vhf_seventotal,
                'Mal' => $mal_seventotal,
                'Men' => $men_seventotal
                
            );
        endforeach;
        $weeksevendd = $wksevendiseases['AWD'] + $wksevendiseases['BD'] + $wksevendiseases['OAD'];
        if ($weeksevendd == 0) {
            $weeksevenpercentage = 0;
        } else {
            $weeksevenpercentage = ($weeksevendd / $totalsevenconsultations) * 100;
        }
        
        $weeksevenili = $wksevendiseases['ILI'];
        $weeksevenmal = $wksevendiseases['Mal'];
        
        if ($weeksevenili == 0) {
            $weeksevenilipercentage = 0;
        } else {
            $weeksevenilipercentage = ($weeksevenili / $totalpreviousconsultations) * 100;
        }
        
        if ($weeksevenmal == 0) {
            $weeksevenmalpercentage = 0;
        } else {
            $weeksevenmalpercentage = ($weeksevenmal / $totalconsultations) * 100;
        }
        
        $weekeightdiseases = $this->reportingformsmodel->disease_sum_period($periodeight_id);
        foreach ($weekeightdiseases as $wkekey => $weekeightdisease):
            $sari_eighttotal = $weekeightdisease->sari_lt_5 + $weekeightdisease->sari_gt_5;
            $ili_eighttotal  = $weekeightdisease->ili_lt_5 + $weekeightdisease->ili_gt_5;
            $awd_eighttotal  = $weekeightdisease->awd_lt_5 + $weekeightdisease->awd_gt_5;
            $bd_eighttotal   = $weekeightdisease->bd_lt_5 + $weekeightdisease->bd_gt_5;
            $oad_eighttotal  = $weekeightdisease->oad_lt_5 + $weekeightdisease->oad_gt_5;
            $diph_eighttotal = $weekeightdisease->diph;
            $wc_eighttotal   = $weekeightdisease->wc;
            $meas_eighttotal = $weekeightdisease->meas;
            $nnt_eighttotal  = $weekeightdisease->nnt;
            $afp_eighttotal  = $weekeightdisease->afp;
            $ajs_eighttotal  = $weekeightdisease->ajs;
            $vhf_eighttotal  = $weekeightdisease->vhf;
            $mal_eighttotal  = $weekeightdisease->mal_lt_5 + $weekeightdisease->mal_gt_5;
            $men_eighttotal  = $weekeightdisease->men;
            $wkeightdiseases = array(
                'SARI' => $sari_eighttotal,
                'ILI' => $ili_eighttotal,
                'AWD' => $awd_eighttotal,
                'BD' => $bd_eighttotal,
                'OAD' => $oad_eighttotal,
                'Diph' => $diph_eighttotal,
                'WC' => $wc_eighttotal,
                'Meas' => $meas_eighttotal,
                'NNT' => $nnt_eighttotal,
                'AFP' => $afp_eighttotal,
                'AJS' => $ajs_eighttotal,
                'VHF' => $vhf_eighttotal,
                'Mal' => $mal_eighttotal,
                'Men' => $men_eighttotal
                
            );
        endforeach;
        
        $weekeightdd = $wkeightdiseases['AWD'] + $wkeightdiseases['BD'] + $wkeightdiseases['OAD'];
        if ($weekeightdd == 0) {
            $weekeightpercentage = 0;
        } else {
            $weekeightpercentage = ($weekeightdd / $totaleightconsultations) * 100;
        }
        
        $weekeightili = $wkeightdiseases['ILI'];
        $weekeightmal = $wkeightdiseases['Mal'];
        
        if ($weekeightili == 0) {
            $weekeightilipercentage = 0;
        } else {
            $weekeightilipercentage = ($weekeightili / $totalpreviousconsultations) * 100;
        }
        
        if ($weekeightmal == 0) {
            $weekeightmalpercentage = 0;
        } else {
            $weekeightmalpercentage = ($weekeightmal / $totalconsultations) * 100;
        }
        
        $weekninediseases = $this->reportingformsmodel->disease_sum_period($periodnine_id);
        foreach ($weekninediseases as $wknnkey => $weekninedisease):
            $sari_ninetotal = $weekninedisease->sari_lt_5 + $weekninedisease->sari_gt_5;
            $ili_ninetotal  = $weekninedisease->ili_lt_5 + $weekninedisease->ili_gt_5;
            $awd_ninetotal  = $weekninedisease->awd_lt_5 + $weekninedisease->awd_gt_5;
            $bd_ninetotal   = $weekninedisease->bd_lt_5 + $weekninedisease->bd_gt_5;
            $oad_ninetotal  = $weekninedisease->oad_lt_5 + $weekninedisease->oad_gt_5;
            $diph_ninetotal = $weekninedisease->diph;
            $wc_ninetotal   = $weekninedisease->wc;
            $meas_ninetotal = $weekninedisease->meas;
            $nnt_ninetotal  = $weekninedisease->nnt;
            $afp_ninetotal  = $weekninedisease->afp;
            $ajs_ninetotal  = $weekninedisease->ajs;
            $vhf_ninetotal  = $weekninedisease->vhf;
            $mal_ninetotal  = $weekninedisease->mal_lt_5 + $weekninedisease->mal_gt_5;
            $men_ninetotal  = $weekninedisease->men;
            $wkninediseases = array(
                'SARI' => $sari_ninetotal,
                'ILI' => $ili_ninetotal,
                'AWD' => $awd_ninetotal,
                'BD' => $bd_ninetotal,
                'OAD' => $oad_ninetotal,
                'Diph' => $diph_ninetotal,
                'WC' => $wc_ninetotal,
                'Meas' => $meas_ninetotal,
                'NNT' => $nnt_ninetotal,
                'AFP' => $afp_ninetotal,
                'AJS' => $ajs_ninetotal,
                'VHF' => $vhf_ninetotal,
                'Mal' => $mal_ninetotal,
                'Men' => $men_ninetotal
                
            );
        endforeach;
        $weekninedd = $wkninediseases['AWD'] + $wkninediseases['BD'] + $wkninediseases['OAD'];
        if ($weekninedd == 0) {
            $weekninepercentage = 0;
        } else {
            $weekninepercentage = ($weekninedd / $totalnineconsultations) * 100;
        }
        
        $weeknineili = $wkninediseases['ILI'];
        $weekninemal = $wkninediseases['Mal'];
        
        if ($weeknineili == 0) {
            $weeknineilipercentage = 0;
        } else {
            $weeknineilipercentage = ($weeknineili / $totalpreviousconsultations) * 100;
        }
        
        if ($weekninemal == 0) {
            $weekninemalpercentage = 0;
        } else {
            $weekninemalpercentage = ($weekninemal / $totalconsultations) * 100;
        }
        
        
        $weektendiseases = $this->reportingformsmodel->disease_sum_period($periodten_id);
        foreach ($weektendiseases as $wktnkey => $weektendisease):
            $sari_tentotal = $weektendisease->sari_lt_5 + $weektendisease->sari_gt_5;
            $ili_tentotal  = $weektendisease->ili_lt_5 + $weektendisease->ili_gt_5;
            $awd_tentotal  = $weektendisease->awd_lt_5 + $weektendisease->awd_gt_5;
            $bd_tentotal   = $weektendisease->bd_lt_5 + $weektendisease->bd_gt_5;
            $oad_tentotal  = $weektendisease->oad_lt_5 + $weektendisease->oad_gt_5;
            $diph_tentotal = $weektendisease->diph;
            $wc_tentotal   = $weektendisease->wc;
            $meas_tentotal = $weektendisease->meas;
            $nnt_tentotal  = $weektendisease->nnt;
            $afp_tentotal  = $weektendisease->afp;
            $ajs_tentotal  = $weektendisease->ajs;
            $vhf_tentotal  = $weektendisease->vhf;
            $mal_tentotal  = $weektendisease->mal_lt_5 + $weektendisease->mal_gt_5;
            $men_tentotal  = $weektendisease->men;
            $wktendiseases = array(
                'SARI' => $sari_tentotal,
                'ILI' => $ili_tentotal,
                'AWD' => $awd_tentotal,
                'BD' => $bd_tentotal,
                'OAD' => $oad_tentotal,
                'Diph' => $diph_tentotal,
                'WC' => $wc_tentotal,
                'Meas' => $meas_tentotal,
                'NNT' => $nnt_tentotal,
                'AFP' => $afp_tentotal,
                'AJS' => $ajs_tentotal,
                'VHF' => $vhf_tentotal,
                'Mal' => $mal_tentotal,
                'Men' => $men_tentotal
                
            );
        endforeach;
        $weektendd = $wktendiseases['AWD'] + $wktendiseases['BD'] + $wktendiseases['OAD'];
        if ($weektendd == 0) {
            $weektenpercentage = 0;
        } else {
            $weektenpercentage = ($weektendd / $totaltenconsultations) * 100;
        }
        
        $weektenili = $wktendiseases['ILI'];
        $weektenmal = $wktendiseases['Mal'];
        
        if ($weektenili == 0) {
            $weektenilipercentage = 0;
        } else {
            $weektenilipercentage = ($weektenili / $totalpreviousconsultations) * 100;
        }
        
        if ($weektenmal == 0) {
            $weektenmalpercentage = 0;
        } else {
            $weektenmalpercentage = ($weektenmal / $totalconsultations) * 100;
        }
        
        $dddata = number_format($weektenpercentage, 1) . ', ' . number_format($weekninepercentage, 1) . ', ' . number_format($weekeightpercentage, 1) . ', ' . number_format($weeksevenpercentage, 1) . ', ' . number_format($weeksixpercentage, 1) . ', ' . number_format($weekfivepercentage, 1) . ', ' . number_format($weekfourpercentage, 1) . ', ' . number_format($weekthreeddpercentage, 1) . ', ' . number_format($weektwoddpercentage, 1) . ', ' . number_format($weekoneddpercentage, 1);
        
        $ilidata = number_format($weektenilipercentage, 1) . ', ' . number_format($weeknineilipercentage, 1) . ', ' . number_format($weekeightilipercentage, 1) . ', ' . number_format($weeksevenilipercentage, 1) . ', ' . number_format($weeksixilipercentage, 1) . ', ' . number_format($weekfiveilipercentage, 1) . ', ' . number_format($weekfourilipercentage, 1) . ', ' . number_format($weekthreeilipercentage, 1) . ', ' . number_format($weektwoilipercentage, 1) . ', ' . number_format($weekoneilipercentage, 1);
        
        $maldata = number_format($weektenmalpercentage, 1) . ', ' . number_format($weekninemalpercentage, 1) . ', ' . number_format($weekeightmalpercentage, 1) . ', ' . number_format($weeksevenmalpercentage, 1) . ', ' . number_format($weeksixmalpercentage, 1) . ', ' . number_format($weekfivemalpercentage, 1) . ', ' . number_format($weekfourmalpercentage, 1) . ', ' . number_format($weekthreemalpercentage, 1) . ', ' . number_format($weektwomalpercentage, 1) . ', ' . number_format($weekonemalpercentage, 1);
        //end trends section
        
        //proportional morbidity pie section
        $sari = $diseases['SARI'];
        $oad  = $diseases['OAD'];
        $bd   = $diseases['BD'];
        $awd  = $diseases['AWD'];
        $mal  = $diseases['Mal'];
        $ili  = $diseases['ILI'];
        
        $totalpriority = ($sari + $oad + $bd + $awd + $mal + $ili);
        $totalother    = ($totalconsultations - $totalpriority);
        
        if ($sari == 0) {
            $sari_percent = 0;
        } else {
            $sari_percent = ($sari / $totalconsultations) * 100;
        }
        
        if ($oad == 0) {
            $oad_percent = 0;
        } else {
            $oad_percent = ($oad / $totalconsultations) * 100;
        }
        
        if ($bd == 0) {
            $bd_percent = 0;
        } else {
            $bd_percent = ($bd / $totalconsultations) * 100;
        }
        
        if ($awd == 0) {
            $awd_percent = 0;
        } else {
            $awd_percent = ($awd / $totalconsultations) * 100;
        }
        
        if ($mal == 0) {
            $mal_percent = 0;
        } else {
            $mal_percent = ($mal / $totalconsultations) * 100;
        }
        
        if ($ili == 0) {
            $ili_percent = 0;
        } else {
            $ili_percent = ($ili / $totalconsultations) * 100;
        }
        
        if ($totalother == 0) {
            $other_percent = 0;
        } else {
            $other_percent = ($totalother / $totalconsultations) * 100;
        }
        
        $piesaridata  = $sari;
        $pieoaddata   = $oad;
        $piebddata    = $bd;
        $pieawddata   = $awd;
        $piemaldata   = $mal;
        $pieilidata   = $ili;
        $pieotherdata = $totalother;
        
        //age and sex distribution bar
		//age
        $bdunderfive  = $agedist['bd_lt_5'];
        $bdoverfive   = $agedist['bd_gt_5'];
        $awdunderfive = $agedist['awd_lt_5'];
        $awdoverfive  = $agedist['awd_gt_5'];
        $malunderfive = $agedist['mal_lt_5'];
        $maloverfive  = $agedist['mal_gt_5'];
        $oadunderfive = $agedist['oad_lt_5'];
        $oadoverfive  = $agedist['oad_gt_5'];
		
		//sex
		$sumdiseases = $this->reportingformsmodel->sum_diseases_by_age_period($reportingperiod_id);
        
        foreach ($sumdiseases as $sdkey => $sumdisease) {
			$ili_lt_male = $sumdisease->ili_lt_male;
            $ili_lt_female  = $sumdisease->ili_lt_female;
			$ili_gt_male = $sumdisease->ili_gt_male;
            $ili_gt_female  = $sumdisease->ili_gt_female;
			
			$ilimale = $ili_lt_male+$ili_gt_male;
			$ilifemale = $ili_gt_female + $ili_lt_female;
			
			$awd_lt_male = $sumdisease->awd_lt_male;
            $awd_lt_female  = $sumdisease->awd_lt_female;
			$awd_gt_male = $sumdisease->awd_gt_male;
            $awd_gt_female  = $sumdisease->awd_gt_female;
			
			$awdmale = $awd_lt_male+$awd_gt_male;
			$awdfemale = $awd_lt_female + $awd_gt_female;
			
			$bd_lt_male = $sumdisease->bd_lt_male;
            $bd_lt_female  = $sumdisease->bd_lt_female;
			$bd_gt_male = $sumdisease->bd_gt_male;
            $bd_gt_female  = $sumdisease->bd_gt_female;
			
			$bdmale = $bd_lt_male+$bd_gt_male;
			$bdfemale = $bd_lt_female + $bd_gt_female;
			
			$oad_lt_male = $sumdisease->oad_lt_male;
            $oad_lt_female  = $sumdisease->oad_lt_female;
			$oad_gt_male = $sumdisease->oad_gt_male;
            $oad_gt_female  = $sumdisease->oad_gt_female;
			
			$oadmale = $oad_lt_male+$oad_gt_male;
			$oadfemale = $oad_gt_female + $oad_lt_female;
			
			$mal_lt_male = $sumdisease->mal_lt_male;
            $mal_lt_female  = $sumdisease->mal_lt_female;
			$mal_gt_male = $sumdisease->mal_gt_male;
            $mal_gt_female  = $sumdisease->mal_gt_female;
			
			$malmale = $mal_gt_male+$mal_lt_male;
			$malfemale = $mal_gt_female + $mal_lt_female;
		}
        
		//alerts graph
		 $periodonealerts = $this->alertsmodel->get_sum_by_period_status($reportingperiodone->id,0);
		 $week_one_meas = '';
		 $week_one_afp= '';
		 $week_one_nnt = '';
		 $week_one_awd = '';//cholera
		 $week_one_mal = '';
		 $week_one_sari = '';
		 $week_one_ili = '';
		 
		 foreach ($periodonealerts as $poakey => $periodonealert) {
			 
			 if($periodonealert->disease_name=='Meas')
			 {
				$week_one_meas = $periodonealert->reported_cases;
			 }
			 
			 if($periodonealert->disease_name=='AFP')
			 {
				$week_one_afp = $periodonealert->reported_cases;
			 }
			 
			 if($periodonealert->disease_name=='NNT')
			 {
				$week_one_nnt = $periodonealert->reported_cases;
			 }
			 
			 if($periodonealert->disease_name=='AWD')
			 {
				$week_one_awd = $periodonealert->reported_cases;
			 }
			 
			  if($periodonealert->disease_name=='Mal')
			 {
				$week_one_mal = $periodonealert->reported_cases;
			 }
			 
			 if($periodonealert->disease_name=='SARI')
			 {
				$week_one_sari = $periodonealert->reported_cases;
			 }
			 
			 if($periodonealert->disease_name=='ILI')
			 {
				$week_one_ili = $periodonealert->reported_cases;
			 }
		 
		  }
		  
		  if(empty($week_one_meas))
		  {
			  $data['wk_one_meas'] = 0;
		  }
		  else
		  {
		  	$data['wk_one_meas'] = $week_one_meas;
		  }
		  
		  if(empty($week_one_afp))
		  {
			  $data['week_one_afp'] = 0;
		  }
		  else
		  {
		  	$data['week_one_afp'] = $week_one_afp;
		  }
		  
		  if(empty($week_one_nnt))
		  {
			  $data['week_one_nnt'] = 0;
		  }
		  else
		  {
		  	$data['week_one_nnt'] = $week_one_nnt;
		  }
		  		  
		  if(empty($week_one_awd))
		  {
			  $data['week_one_awd'] = 0;
		  }
		  else
		  {
		  	$data['week_one_awd'] = $week_one_awd;
		  }
		  
		  if(empty($week_one_mal))
		  {
			  $data['week_one_mal'] = 0;
		  }
		  else
		  {
		  	$data['week_one_mal'] = $week_one_mal;
		  }
		  
		   if(empty($week_one_sari))
		  {
			  $data['week_one_sari'] = 0;
		  }
		  else
		  {
		  	$data['week_one_sari'] = $week_one_sari;
		  }
		  
		   if(empty($week_one_ili))
		  {
			  $data['week_one_ili'] = 0;
		  }
		  else
		  {
		  	$data['week_one_ili'] = $week_one_ili;
		  }
		  
		  
		 $periodtwoalerts = $this->alertsmodel->get_sum_by_period_status($reportingperiodtwo->id,0);
		 
		 $week_two_meas = '';
		 $week_two_afp= '';
		 $week_two_nnt = '';
		 $week_two_awd = '';//cholera
		 $week_two_mal = '';
		 $week_two_sari = '';
		 $week_two_ili = '';
		 
		 foreach ($periodtwoalerts as $ptwkey => $periodtwoalert) {
			 
			 if($periodtwoalert->disease_name=='Meas')
			 {
				$week_two_meas = $periodtwoalert->reported_cases;
			 }
			 
			 if($periodtwoalert->disease_name=='AFP')
			 {
				$week_two_afp = $periodtwoalert->reported_cases;
			 }
			 
			 if($periodtwoalert->disease_name=='NNT')
			 {
				$week_two_nnt = $periodtwoalert->reported_cases;
			 }
			 
			 if($periodtwoalert->disease_name=='AWD')
			 {
				$week_two_awd = $periodtwoalert->reported_cases;
			 }
			 
			 if($periodtwoalert->disease_name=='Mal')
			 {
				$week_two_mal = $periodtwoalert->reported_cases;
			 }
			 
			 if($periodtwoalert->disease_name=='SARI')
			 {
				$week_two_sari = $periodtwoalert->reported_cases;
			 }
			 
			 if($periodtwoalert->disease_name=='ILI')
			 {
				$week_two_ili = $periodtwoalert->reported_cases;
			 }
		 
		  }
		  
		  if(empty($week_two_meas))
		  {
			  $data['week_two_meas'] = 0;
		  }
		  else
		  {
		  	$data['week_two_meas'] = $week_two_meas;
		  }
		  
		  if(empty($week_two_afp))
		  {
			  $data['week_two_afp'] = 0;
		  }
		  else
		  {
		  	$data['week_two_afp'] = $week_two_afp;
		  }
		  
		  if(empty($week_two_nnt))
		  {
			  $data['week_two_nnt'] = 0;
		  }
		  else
		  {
		  	$data['week_two_nnt'] = $week_two_nnt;
		  }
		  		  
		  if(empty($week_two_awd))
		  {
			  $data['week_two_awd'] = 0;
		  }
		  else
		  {
		  	$data['week_two_awd'] = $week_two_awd;
		  }
		  
		  if(empty($week_two_mal))
		  {
			  $data['week_two_mal'] = 0;
		  }
		  else
		  {
		  	$data['week_two_mal'] = $week_two_mal;
		  }
		  
		  if(empty($week_two_sari))
		  {
			  $data['week_two_sari'] = 0;
		  }
		  else
		  {
		  	$data['week_two_sari'] = $week_two_sari;
		  }
		  
		  if(empty($week_two_ili))
		  {
			  $data['week_two_ili'] = 0;
		  }
		  else
		  {
		  	$data['week_two_ili'] = $week_two_ili;
		  }
		  
		 $data['period_three'] = $reportingperiodthree->week_no;
		 $periodthreealerts = $this->alertsmodel->get_sum_by_period_status($reportingperiodthree->id,0);
		 $week_three_meas = '';
		 $week_three_afp= '';
		 $week_three_nnt = '';
		 $week_three_awd = '';//cholera
		 $week_three_mal = '';
		 $week_three_sari = '';
		 $week_three_ili = '';
		 
		 foreach ($periodthreealerts as $ptkey => $periodthreealert) {
			 
			 if($periodthreealert->disease_name=='Meas')
			 {
				$week_three_meas = $periodthreealert->reported_cases;
			 }
			 
			 if($periodthreealert->disease_name=='AFP')
			 {
				$week_three_afp = $periodthreealert->reported_cases;
			 }
			 
			 if($periodthreealert->disease_name=='NNT')
			 {
				$week_three_nnt = $periodthreealert->reported_cases;
			 }
			 
			 if($periodthreealert->disease_name=='AWD')
			 {
				$week_three_awd = $periodthreealert->reported_cases;
			 }
			 
			 if($periodthreealert->disease_name=='Mal')
			 {
				$week_three_mal = $periodthreealert->reported_cases;
			 }
			 
			 if($periodthreealert->disease_name=='SARI')
			 {
				$week_three_sari = $periodthreealert->reported_cases;
			 }
			 
			 if($periodthreealert->disease_name=='ILI')
			 {
				$week_three_ili = $periodthreealert->reported_cases;
			 }
		 
		  }
		
		  if(empty($week_three_meas))
		  {
			  $data['week_three_meas'] = 0;
		  }
		  else
		  {
		  	$data['week_three_meas'] = $week_three_meas;
		  }
		  
		  if(empty($week_three_afp))
		  {
			  $data['week_three_afp'] = 0;
		  }
		  else
		  {
		  	$data['week_three_afp'] = $week_three_afp;
		  }
		  
		  if(empty($week_three_nnt))
		  {
			  $data['week_three_nnt'] = 0;
		  }
		  else
		  {
		  	$data['week_three_nnt'] = $week_three_nnt;
		  }
		  		  
		  if(empty($week_three_awd))
		  {
			  $data['week_three_awd'] = 0;
		  }
		  else
		  {
		  	$data['week_three_awd'] = $week_three_awd;
		  }
		  
		  if(empty($week_three_mal))
		  {
			  $data['week_three_mal'] = 0;
		  }
		  else
		  {
		  	$data['week_three_mal'] = $week_three_mal;
		  } 
		  
		  if(empty($week_three_sari))
		  {
			  $data['week_three_sari'] = 0;
		  }
		  else
		  {
		  	$data['week_three_sari'] = $week_three_sari;
		  }
		  
		   if(empty($week_three_ili))
		  {
			  $data['week_three_ili'] = 0;
		  }
		  else
		  {
		  	$data['week_three_ili'] = $week_three_ili;
		  }
		  
		
	        
		//distribution of consultations table
		
		 $distribution_table = '
		<style>
				#disttable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#disttable td, #disttable th 
				{
				font-size:0.8em;
				border:1px solid #892A24;
				padding:3px 7px 2px 7px;
				}
				#disttable th 
				{
				font-size:0.8em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#892A24;
				color:#fff;
				}
				#disttable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>';
        
        
        $distribution_table .= '<table id="disttable">';
        $distribution_table .= '<tr bgcolor="#892A24"><td><font color="#FFFFFF"><strong>Suspected Disease</strong></font></td>';
        foreach ($allzones as $azkey => $thezone) {
            $distribution_table .= '<td valign="top"><font color="#FFFFFF"><strong>' . $thezone['zone'] . '</strong></font></td>';
        }
        $distribution_table .= '<td><font color="#FFFFFF"><strong>Total</strong></font></td></tr>';
        
        $zonealconsultations = array();
      
        foreach ($diseases as $key => $value) {
			
			$total_zonal_disease = 0;
			
            $distribution_table .= '<tr><td>' . $key . '</td>';
            foreach ($allzones as $azkey => $thezone) {
                
                $zonalsums = $this->reportingformsmodel->sum_diseases_by_period_zone($row->reportingperiod_id, $thezone['id']);
                
                foreach ($zonalsums as $skey => $zonalsums) {
                    $sari_total = $zonalsums->sari_lt_5 + $zonalsums->sari_gt_5;
                    $ili_total  = $zonalsums->ili_lt_5 + $zonalsums->ili_gt_5;
                    $awd_total  = $zonalsums->awd_lt_5 + $zonalsums->awd_gt_5;
                    $bd_total   = $zonalsums->bd_lt_5 + $zonalsums->bd_gt_5;
                    $oad_total  = $zonalsums->oad_lt_5 + $zonalsums->oad_gt_5;
                    $diph_total = $zonalsums->diph;
                    $wc_total   = $zonalsums->wc;
                    $meas_total = $zonalsums->meas;
                    $nnt_total  = $zonalsums->nnt;
                    $afp_total  = $zonalsums->afp;
                    $ajs_total  = $zonalsums->ajs;
                    $vhf_total  = $zonalsums->vhf;
                    $mal_total  = $zonalsums->mal_lt_5 + $zonalsums->mal_gt_5;
                    $men_total  = $zonalsums->men;
                    
					$consarray = array('Cons' => $zonalsums->Cons,
					'Oc' => $zonalsums->oc
					);
                    $zonaldiseases = array(
                        'SARI' => $sari_total,
                        'ILI' => $ili_total,
                        'AWD' => $awd_total,
                        'BD' => $bd_total,
                        'OAD' => $oad_total,
                        'Diph' => $diph_total,
                        'WC' => $wc_total,
                        'Meas' => $meas_total,
                        'NNT' => $nnt_total,
                        'AFP' => $afp_total,
                        'AJS' => $ajs_total,
                        'VHF' => $vhf_total,
                        'Mal' => $mal_total,
                        'Men' => $men_total
                    );
                    
                }
                //calculate consultation for each zone
               $totalzonaldiseases = array_sum($zonaldiseases);
				
				if(empty($consarray['Cons']))
				{
					$totalzonalconsult = 0;
				}
				else
				{
					$totalzonalconsult = $consarray['Cons'];
				}
				
				                
                $zonealconsultations[] = $totalzonalconsult;
				
				//$prioritydiseasestotal = $zonaldiseases['BD'] + $zonaldiseases['AWD'] +$zonaldiseases['Meas'] + $zonaldiseases['AFP']+$zonaldiseases['WC']+$zonaldiseases['Mal']+$zonaldiseases['NNT'];
				
				$oc = ($totalzonalconsult-$totalzonaldiseases);
				
				$otherzonalconsultations[] = $oc;
				
				$other_cons[] = $oc;
				
				
                //get the diseases for each zone and calculate percentages
                foreach ($zonaldiseases as $zonkey => $zonaldisease) {
                    if ($zonkey == $key) {
						$total_zonal_disease = ($total_zonal_disease + $zonaldisease);
                        if (empty($zonaldisease)) {
                            $distribution_table .= '<td>0 </td>';
                        } else {
                            if ($zonaldisease == 0) {
                                $percentagedisease = 0;
                            } else {
                                $percentagedisease = ($zonaldisease / $totalzonalconsult) * 100;
                                
                                $distribution_table .= '<td>' . $zonaldisease . ' </td>';
                            }
                        }
                    }
                }
                
                
            }
            $distribution_table .= '<td>'.$total_zonal_disease.'</td></tr>';
			
        }
		
		$uppervalue = $totalzones - 1;
		$total_other_consultations = 0;
		$distribution_table .= '<tr><td>Other consultatioins</td>';
		 for ($oi = 0; $oi <= $uppervalue; $oi++) {
			 
			$total_other_consultations = ($total_other_consultations+$other_cons[$oi]);
			$distribution_table .= '<td>'.$other_cons[$oi].' </td>';
		}
		
		$distribution_table .= '<td>'.$total_other_consultations.'</td></tr>';
						
        $distribution_table .= '<tr bgcolor="#892A24"><td><font color="#FFFFFF"><strong>Total consultations</strong></font></td>';
        //display the total consultation for each zone
        
		$overal_consultations = 0;
        for ($zi = 0; $zi <= $uppervalue; $zi++) {
			
			$overal_consultations = ($overal_consultations +$zonealconsultations[$zi]);
            $distribution_table .= '<td><font color="#FFFFFF"><strong>' . $zonealconsultations[$zi] . '</strong></font></td>';
        }
        $distribution_table .= '<td><font color="#FFFFFF"><strong>'.$overal_consultations.'</strong></font></td></tr>';
        $distribution_table .= '</table>';
		
		//zones table
				
		$zonetable = '';
		
		foreach($zones as $zonekey=>$tzone)
		{
			$zonalalerttext = '';
			$zonetable .= '<tr bgcolor="#892A24">';
			$zonetable .= '<td colspan="2"><font color="#FFFFFF"><strong>'.$tzone['zone'].'</strong></font></td>';
			$zonetable .= '</tr>';
			$zonetable .= '<tr>';
			//get the districts in the zone
			$districts = $this->districtsmodel->get_by_zone($tzone['id']);
			$zonaldistricts = count($districts->result());
			//get the health facilities reporting in the zone
			$zonereporting_hfs   = $this->reportingformsmodel->get_reporting_hf_by_period_zone($row->reportingperiod_id, $tzone['id']);
            $hfs_reporting_in_zone = count($zonereporting_hfs);
			
			$zonesums = $this->reportingformsmodel->sum_diseases_by_period_zone($row->reportingperiod_id, $tzone['id']);
                
                foreach ($zonesums as $zskey => $zonesum) {
                    $sari_ztotal = $zonesum->sari_lt_5 + $zonesum->sari_gt_5;
                    $ili_ztotal  = $zonesum->ili_lt_5 + $zonesum->ili_gt_5;
                    $awd_ztotal  = $zonesum->awd_lt_5 + $zonesum->awd_gt_5;
                    $bd_ztotal   = $zonesum->bd_lt_5 + $zonesum->bd_gt_5;
                    $oad_ztotal  = $zonesum->oad_lt_5 + $zonesum->oad_gt_5;
                    $diph_ztotal = $zonesum->diph;
                    $wc_ztotal   = $zonesum->wc;
                    $meas_ztotal = $zonesum->meas;
                    $nnt_ztotal  = $zonesum->nnt;
                    $afp_ztotal  = $zonesum->afp;
                    $ajs_ztotal  = $zonesum->ajs;
                    $vhf_ztotal  = $zonesum->vhf;
                    $mal_ztotal  = $zonesum->mal_lt_5 + $zonesum->mal_gt_5;
                    $men_ztotal  = $zonesum->men;
					
					$cons_array = array('Cons' => $zonesum->Cons,
					'Oc' => $zonesum->oc
					);
                    
                    $zonaldiseasesconsulted = array(
                       'SARI' => $sari_ztotal,
                        'ILI' => $ili_ztotal,
                        'AWD' => $awd_ztotal,
                        'BD' => $bd_ztotal,
                        'OAD' => $oad_ztotal,
                        'Diph' => $diph_ztotal,
                        'WC' => $wc_ztotal,
                        'Meas' => $meas_ztotal,
                        'NNT' => $nnt_ztotal,
                        'AFP' => $afp_ztotal,
                        'AJS' => $ajs_ztotal,
                        'VHF' => $vhf_ztotal,
                        'Mal' => $mal_ztotal,
                        'Men' => $men_ztotal
                    );
                    
                }
                //calculate consultation for each zone
                $totalzonaldiseasesconsulted = array_sum($zonaldiseasesconsulted);
				
				//alerts for the zone
				$zonalalerts = $this->alertsmodel->get_by_period_zone($row->reportingperiod_id, $tzone['id']);
				//$totalzonalalerts = count($zonalalerts);
				
				$respondedalerts = array();				
				
					$summedalerts = $this->alertsmodel->get_sum_by_period_zone($row->reportingperiod_id,$tzone['id'],0);
					$totalsummedalerts = count($summedalerts);
					if($totalsummedalerts!=0)
					{
						
						$zsi=0;
						foreach($summedalerts as $zskey=>$summedalert)
						{
							$zsi++;
							if($zsi==1)
							{
								$zonalalerttext .= 'Altogether '.$summedalert->reported_cases.' alerts '.$summedalert->disease_name;
							}
							else
							{
								$zonalalerttext .= ', '.$summedalert->reported_cases.' '.$summedalert->disease_name;
							}
							
							$respondedalerts[] = $summedalert->reported_cases;
							
						}
					}
					else
					{
						$zonalalerttext .= 'Altogether no alerts';
						$respondedalerts[] = 0;
					}
			
			$totalzonalalerts = array_sum($respondedalerts);
				
			$zonetable .= '<td colspan="2"> '.$hfs_reporting_in_zone.' health facilities from '.$zonaldistricts.' districts in '.$tzone['zone'].' zone reported to eDEWS with a total of '.$cons_array['Cons'] .' patients consultations in week '.$row->week_no.', '.$row->week_year.'. Total '.$totalzonalalerts.' alerts were reported and appropriate measures taken in week '.$row->week_no.', '.$row->week_year.'. '.$zonalalerttext.' were reported and responded.</td>';
			$zonetable .= '</tr>';
		}
		
        //the alerts table
			
        $alertstable = '<table id="alertstable">';
        $alertstable .= '<tr bgcolor="#1F7EB8"><td><font color="#FFFFFF"><strong>Suspected Disease</strong></font></td><td><font color="#FFFFFF"><strong>Zone</strong></font></td><td><font color="#FFFFFF"><strong>Region</strong></font></td><td><font color="#FFFFFF"><strong>District</strong></font></td><td><font color="#FFFFFF"><strong>HF</strong></font></td><td><font color="#FFFFFF"><strong>Action</strong></font></td><td><font color="#FFFFFF"><strong>Cases</strong></font></td><td><font color="#FFFFFF"><strong>Deaths</strong></font></td></tr>';
		
        foreach ($alerts as $key => $alert) {
            $zone           = $this->zonesmodel->get_by_id($alert['zone_id'])->row();
            $region         = $this->regionsmodel->get_by_id($alert['region_id'])->row();
            $district       = $this->districtsmodel->get_by_id($alert['district_id'])->row();
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($alert['healthfacility_id'])->row();
            
            $alertstable .= '<tr><td>' . $alert['disease_name'] . '</td>
		   <td>' . $zone->zone . '</td>
		   <td>' . $region->region . '</td>
		   <td>' . $district->district . '</td>
		   <td>' . $healthfacility->health_facility . '</td>
		   <td>' . $alert['notes'] . '</td>
		   <td>' . $alert['cases'] . '</td>
		   <td>' . $alert['deaths'] . '</td>
		   </tr>';
        }
        
        $alertstable .= '</table>';
        
        if (empty($totaltenconsultations)) {
            $tenthconsultation = 0;
        } else {
            $tenthconsultation = $totaltenconsultations;
        }
        
        if (empty($totalnineconsultations)) {
            $ninthconsultation = 0;
        } else {
            $ninthconsultation = $totalnineconsultations;
        }
        
        if (empty($totaleightconsultations)) {
            $eightconsultation = 0;
        } else {
            $eightconsultation = $totaleightconsultations;
        }
        
        if (empty($totalsevenconsultations)) {
            $seventhconsultation = 0;
        } else {
            $seventhconsultation = $totalsevenconsultations;
        }
        
        if (empty($totalsixconsultations)) {
            $sixthconsultation = 0;
        } else {
            $sixthconsultation = $totalsixconsultations;
        }
        
        if (empty($totalfiveconsultations)) {
            $fifthconsultation = 0;
        } else {
            $fifthconsultation = $totalfiveconsultations;
        }
        
        if (empty($totalfourconsultations)) {
            $fourthconsultation = 0;
        } else {
            $fourthconsultation = $totalfourconsultations;
        }
        
        if (empty($totalthreeconsultations)) {
            $thirdconsultation = 0;
        } else {
            $thirdconsultation = $totalthreeconsultations;
        }
        
        
        $consultationdata = $tenthconsultation . ',' . $ninthconsultation . ',' . $eightconsultation . ',' . $seventhconsultation . ',' . $sixthconsultation . ',' . $fifthconsultation . ',' . $fourthconsultation . ',' . $thirdconsultation . ',' . $lastconsultations . ',' . $totalconsultations;
        
        $categories = "'wk " . $reportingperiodten->week_no . "','wk " . $reportingperiodnine->week_no . "','wk " . $reportingperiodeight->week_no . "','wk " . $reportingperiodseven->week_no . "','wk " . $reportingperiodsix->week_no . "','wk " . $reportingperiodfive->week_no . "','wk " . $reportingperiodfour->week_no . "','wk " . $reportingperiodthree->week_no . "','wk " . $reportingperiodtwo->week_no . "','wk " . $reportingperiodone->week_no . "'";
		
		//malaria table and data
	 	  
	   $reportingperiod_one = $this->epdcalendarmodel->get_by_year_week($reportingperiodfive->epdyear,$reportingperiodfour->week_no)->row();
	  
	   $reportingperiod_two = $this->epdcalendarmodel->get_by_year_week($reportingperiodone->epdyear,$reportingperiodone->week_no)->row();
	   
	   $period_one = $reportingperiod_one->id;
	   $period_two = $reportingperiod_two->id;
	   
	   $startdate = $reportingperiod_one->from;
	   $enddate = $reportingperiod_two->to;
	   
	   $malariacategories = '';
	   $malariadata = '';
	   $frdata = '';
	   $sprdata = '';
	   $malariaufivedata = '';
	   $malariaofivedata = '';
	   
	   $forms = $this->reportsmodel->malaria_report(0,0,0,0,$period_one,$period_two,$reportingperiodfive->epdyear,$reportingperiodone->epdyear);
	   foreach($forms as $skey=>$form)
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
			$maltot = $malotot + $malutot;
			$mentot = $form->suspectedmenegitismale + $form->suspectedmenegitisfemale;
			$undistot = $form->undismale + $form->undisfemale;
			$undistwotot = $form->undismaletwo + $form->undisfemaletwo;
			$octot = $form->ocmale + $form->ocfemale;
			
				
			$saritotal = $form->sari_lt_5 + $form->sari_gt_5;
			$ilitotal = $form->ili_lt_5 + $form->ili_gt_5;
			$awdtotal = $form->awd_lt_5 + $form->awd_gt_5;
			$bdtotal = $form->bd_lt_5 + $form->bd_gt_5;
			$oadtotal = $form->oad_lt_5 + $form->oad_gt_5;
			$diphtotal = $form->diph;
			$wctotal = $form->wc;
			$meastotal = $form->meas;
			$nnttotal = $form->nnt;
			$afptotal = $form->afp;
			$ajstotal = $form->ajs;
			$vhftotal = $form->vhf;
			$maltotal = $form->mal_lt_5 + $form->mal_gt_5;
			$mentotal = $form->men;
			
			$totalslides = $form->totpv + $form->totpmix + $form->totpf;
			$sre = $form->totsre;
				
			
			if($totalslides==0)
			{
				$spr = 0;
				$fr = 0;
			}
			else
			{
			
				$spr = ($totalslides/$sre) * 100;
				$fr = ($form->totpf/$totalslides) * 100;
			}
			
			$malariacategories .= "'WK".$form->week_no."', ";
			$malariadata .= "".$maltotal.", ";
			$frdata .= "".number_format($fr).", ";
			$sprdata .= "".number_format($spr).", ";
			$malariaufivedata .= "".$form->mal_lt_5.", ";
	   		$malariaofivedata .= "".$form->mal_gt_5.", ";
						
		}
		
		$malariatable = '
		<style>
				#disttable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:80%;
				border-collapse:collapse;
				}
				#disttable td, #disttable th 
				{
				font-size:0.8em;
				border:1px solid #892A24;
				padding:3px 7px 2px 7px;
				}
				#disttable th 
				{
				font-size:0.8em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#892A24;
				color:#fff;
				}
				#disttable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>
		<table id="disttable">';
		$malariatable .= '<tr><th>&nbsp;</th><th>Central</th><th>Puntland</th><th>Southern</th><th>Somaliland</th></tr>';
		
		$zonalsumsone= $this->reportingformsmodel->sum_diseases_by_period_zone($reportingperiod_two->id, 1);
                
                foreach ($zonalsumsone as $skey => $zonalsumone) {
                    $mal_totalone  = $zonalsumone->mal_lt_5 + $zonalsumone->mal_gt_5;
					$sre_totalone = $zonalsumone->toSre;
					$pf_totalone = $zonalsumone->toPf;
					$pv_totalone = $zonalsumone->toPv;
					$pmix_totalone = $zonalsumone->toPmix;
					$total_positiveone = $zonalsumone->toPos;
					
					$totalslidesone = $zonalsumone->toPv + $zonalsumone->toPmix + $zonalsumone->toPf;
					$sreone = $zonalsumone->toSre;
					
					if($totalslidesone==0)
					{
						$sprone = 0;
						$frone = 0;
					}
					else
					{
					
						$sprone = ($totalslides/$sreone) * 100;
						$frone = ($zonalsumone->toPf/$totalslidesone) * 100;
					}
					
					
										
				}
		
		$zonalsums = $this->reportingformsmodel->sum_diseases_by_period_zone($reportingperiod_two->id, 2);
                
                foreach ($zonalsums as $skey => $zonalsums) {
                    $mal_total  = $zonalsums->mal_lt_5 + $zonalsums->mal_gt_5;
					$sre_total = $zonalsums->toSre;
					$pf_total = $zonalsums->toPf;
					$pv_total = $zonalsums->toPv;
					$pmix_total = $zonalsums->toPmix;
					$total_positive = $zonalsums->toPos;
					
					$totalslides = $zonalsums->toPv + $zonalsums->toPmix + $zonalsums->toPf;
					$sre = $zonalsums->toSre;
					
					if($totalslides==0)
					{
						$spr = 0;
						$fr = 0;
					}
					else
					{
					
						$spr = ($totalslides/$sre) * 100;
						$fr = ($zonalsums->toPf/$totalslides) * 100;
					}
					
					
										
				}
				
				$zonalsumstwo= $this->reportingformsmodel->sum_diseases_by_period_zone($reportingperiod_two->id, 3);
                
                foreach ($zonalsumstwo as $skey => $zonalsumtwo) {
                    $mal_totaltwo  = $zonalsumtwo->mal_lt_5 + $zonalsumtwo->mal_gt_5;
					$sre_totaltwo = $zonalsumtwo->toSre;
					$pf_totaltwo = $zonalsumtwo->toPf;
					$pv_totaltwo = $zonalsumtwo->toPv;
					$pmix_totaltwo = $zonalsumtwo->toPmix;
					$total_positivetwo = $zonalsumtwo->toPos;
					
					$totalslidestwo = $zonalsumtwo->toPv + $zonalsumtwo->toPmix + $zonalsumtwo->toPf;
					$sretwo = $zonalsumtwo->toSre;
					
					if($totalslidestwo==0)
					{
						$sprtwo = 0;
						$frtwo = 0;
					}
					else
					{
					
						$sprtwo = ($totalslides/$sretwo) * 100;
						$frtwo = ($zonalsumtwo->toPf/$totalslidestwo) * 100;
					}
					
					
										
				}
				
				$zonalsumsthree= $this->reportingformsmodel->sum_diseases_by_period_zone($reportingperiod_two->id, 1);
                
                foreach ($zonalsumsthree as $skey => $zonalsumthree) {
                    $mal_totalthree  = $zonalsumthree->mal_lt_5 + $zonalsumthree->mal_gt_5;
					$sre_totalthree = $zonalsumthree->toSre;
					$pf_totalthree = $zonalsumthree->toPf;
					$pv_totalthree = $zonalsumthree->toPv;
					$pmix_totalthree = $zonalsumthree->toPmix;
					$total_positivethree = $zonalsumthree->toPos;
					
					$totalslidesthree = $zonalsumthree->toPv + $zonalsumthree->toPmix + $zonalsumthree->toPf;
					$srethree = $zonalsumthree->toSre;
					
					if($totalslidesthree==0)
					{
						$sprthree = 0;
						$frthree = 0;
					}
					else
					{
					
						$sprthree = ($totalslides/$srethree) * 100;
						$frthree = ($zonalsumthree->toPf/$totalslidesthree) * 100;
					}
					
					
										
				}
	  
				$malariatable .= '<tr><td>Pf</td><td>'.number_format($pf_totalone).'</td><td>'.number_format($pf_total).'</td><td>'.number_format($pf_totaltwo).'</td><td>'.number_format($pf_totalthree).'</td></tr>';
				$malariatable .= '<tr><td>Pv</td><td>'.number_format($pv_totalone).'</td><td>'.number_format($pv_total).'</td><td>'.number_format($pv_totaltwo).'</td><td>'.number_format($pv_totalthree).'</td></tr>';
				$malariatable .= '<tr><td>Mixed</td><td>'.number_format($pmix_totalone).'</td><td>'.number_format($pmix_total).'</td><td>'.number_format($pmix_totaltwo).'</td><td>'.number_format($pmix_totalthree).'</td></tr>';
				$malariatable .= '<tr><td>SPR</td><td>'.number_format($sprone).'%</td><td>'.number_format($spr).'%</td><td>'.number_format($sprtwo).'%</td><td>'.number_format($sprthree).'%</td></tr>';
				$malariatable .= '<tr><td>FR</td><td>'.number_format($frone).'%</td><td>'.number_format($fr).'%</td><td>'.number_format($frtwo).'%</td><td>'.number_format($frthree).'%</td></tr>';
				$malariatable .= '<tr><td>Total +ve Slides</td><td>'.number_format($total_positiveone).'</td><td>'.number_format($total_positive).'</td><td>'.number_format($total_positivetwo).'</td><td>'.number_format($total_positivethree).'</td></tr>';
				$malariatable .= '<tr><td>Total Slides Tested</td><td>'.number_format($totalslidesone).'</td><td>'.number_format($totalslides).'</td><td>'.number_format($totalslidestwo).'</td><td>'.number_format($totalslidesthree).'</td></tr>';
				$malariatable .= '<tr><td>Clinically Suspected</td><td>'.$mal_totalone.'</td><td>'.$mal_total.'</td><td>'.$mal_totaltwo.'</td><td>'.$mal_totalthree.'</td></tr>';
		
				
		$malariatable .= '</table>';
		
		
		//alerts and outbreaks
		$alertsouttable = '<style>
				#disttable
				{
				font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
				width:100%;
				border-collapse:collapse;
				}
				#disttable td, #disttable th 
				{
				font-size:0.8em;
				border:1px solid #892A24;
				padding:3px 7px 2px 7px;
				}
				#disttable th 
				{
				font-size:0.8em;
				text-align:left;
				padding-top:5px;
				padding-bottom:4px;
				background-color:#892A24;
				color:#fff;
				}
				#disttable tr.alt td 
				{
				color:#000;
				background-color:#EAF2D3;
				}
				</style>';
				
				$alertsouttable .= '<table id="disttable">
  <thead>
  <tr><th rowspan="2">Diseases</th><th colspan="2"><center>'.$row->week_year.'</center></th><th colspan="2"><center>Current week '.$row->week_no.', '.$row->week_year.'</center></th><th colspan="2"><center>System generated alerts</center></th></tr>
  <tr><th>Alerts</th><th>Outbreaks</th><th>Alerts</th><th>Outbreaks</th><th>TRUE</th><th>FALSE</th></tr>
  </thead>
  <tbody>';
  
  $yearbegin = $this->epdcalendarmodel->get_by_year_week($row->week_year,1)->row();
  $yearend = $this->epdcalendarmodel->get_by_year_week($row->week_year,52)->row();
  
  $currentperiod = $this->epdcalendarmodel->get_by_year_week($row->week_year,$row->week_no)->row();
  
  $reportedalerts = $this->alertsmodel->get_sum_by_period_range($yearbegin->id,$yearend->id);
  
  $tester = $this->alertsmodel->sum_by_disease_outcome(1,52,1,'UnDis');
  
    
  foreach($reportedalerts as $rptalert=>$reportedalert)
  {
	  $yearalerts = $tester = $this->alertsmodel->sum_by_disease_outcome($yearbegin->id,$yearend->id,1,$reportedalert->disease_name);
	  $yearoutbreaks = $tester = $this->alertsmodel->sum_by_disease_outcome($yearbegin->id,$yearend->id,0,$reportedalert->disease_name);
	  
	  $currentalerts = $tester = $this->alertsmodel->sum_by_disease_outcome($currentperiod->id,$currentperiod->id,1,$reportedalert->disease_name);
	  $currentoutbreaks = $tester = $this->alertsmodel->sum_by_disease_outcome($currentperiod->id,$currentperiod->id,0,$reportedalert->disease_name);
	  
	  $truecases =  $this->alertsmodel->sum_by_disease_status($currentperiod->id,$currentperiod->id,1,$reportedalert->disease_name);
	  $falsecases =  $this->alertsmodel->sum_by_disease_status($currentperiod->id,$currentperiod->id,0,$reportedalert->disease_name);
	  
	  if(empty($truecases->alerts_cases))
	  {
		  $true_cases = 0;
	  }
	  else
	  {
		  $true_cases = $truecases->alerts_cases;
	  }
	  
	  if(empty($falsecases->alerts_cases))
	  {
		  $false_cases = 0;
	  }
	  else
	  {
		  $false_cases = $falsecases->alerts_cases;
	  }
	  
	  if(empty($yearalerts->alerts_cases))
	  {
		  $year_alerts = 0;
	  }
	  else
	  {
		  $year_alerts = $yearalerts->alerts_cases;
	  }
	  
	  if(empty($yearoutbreaks->alerts_cases))
	  {
		  $outbreaks = 0;
	  }
	  else
	  {
		  $outbreaks = $yearoutbreaks->alerts_cases;
	  }
	  
	  if(empty($currentoutbreaks->alerts_cases))
	  {
		  $current_outbreaks = 0;
	  }
	  else
	  {
		  $current_outbreaks = $currentoutbreaks->alerts_cases;
	  }
	  
	  if(empty($currentalerts->alerts_cases))
	  {
		  $current_alerts = 0;
	  }
	  else
	  {
		  $current_alerts = $currentalerts->alerts_cases;
	  }
	  
	 
	  
	 $alertsouttable .= '<tr><td>'.$reportedalert->disease_name.'</td><td>'.$year_alerts.'</td><td>'.$outbreaks.'</td><td>'.$current_alerts.'</td><td>'.$current_outbreaks.'</td><td>'.$true_cases.'</td><td>'.$false_cases.'</td></tr>'; 
  }
  
  $alertsouttable .= '</tbody>
  </table>';
	
		$data['alertsouttable'] = $alertsouttable;
		$data['malariatable'] = $malariatable;
		$data['frdata'] = $frdata;
		$data['sprdata'] = $sprdata;
		$data['malariaufivedata']        	= $malariaufivedata;
		$data['malariaofivedata']       	= $malariaofivedata;	   
        $data['malariacategories']        	= $malariacategories;
		$data['malariadata']       			= $malariadata;
        $data['startingweek'] 				= $reportingperiodten->week_no;
        $data['leadingdiseasetable']        = $leadingdiseasetable;
        $data['leadingdiseasetext']         = $leadingdiseasetext;
        $data['percentagedata']             = $percentagedata;
        $data['categories']                 = $categories;
        $data['consultationdata']           = $consultationdata;
        $data['alertstable']                = $alertstable;
        $data['static_highlight']           = $static_highlight;
        $data['zonecategories']             = $zonecategories;
        $data['zonereportingrate']          = $zonereportingrate;
        $data['proportionalmorbiditytable'] = $proportionalmorbiditytable;
        $data['totalzones']                 = $totalzones;
        $data['previous_week']              = $tenthreportingperiod->week_no;
        $data['dddata']                     = $dddata;
        $data['ilidata']                    = $ilidata;
        $data['maldata']                    = $maldata;
        $data['piesaridata']                = $piesaridata;
        $data['pieoaddata']                 = $pieoaddata;
        $data['piebddata']                  = $piebddata;
        $data['pieawddata']                 = $pieawddata;
        $data['piemaldata']                 = $piemaldata;
        $data['pieilidata']                 = $pieilidata;
        $data['pieotherdata']               = $pieotherdata;
		$data['bdunderfive']               = $bdunderfive;
        $data['bdoverfive']                = $bdoverfive;
        $data['awdunderfive']               = $awdunderfive;
        $data['awdoverfive']               = $awdoverfive;
        $data['malunderfive']               = $malunderfive;
        $data['maloverfive']               = $maloverfive;
        $data['oadunderfive']               = $oadunderfive;
        $data['oadoverfive']               = $oadoverfive;
		$data['ilimale']               = $ilimale;
        $data['ilifemale']               = $ilifemale;
		$data['awdmale']               = $awdmale;
        $data['awdfemale']               = $awdfemale;
		$data['bdmale']               = $bdmale;
        $data['bdfemale']               = $bdfemale;
		$data['oadmale']               = $oadmale;
        $data['oadfemale']               = $oadfemale;
		$data['malmale']               = $malmale;
        $data['malfemale']               = $malfemale;
		$data['zonetable']               = $zonetable;
		$data['distribution_table']   = $distribution_table;
		$data['this_week']   = $reportingperiodone->week_no;
        $data['last_week']   = $reportingperiodtwo->week_no;
        $data['last_week_bt_one']   = $reportingperiodthree->week_no;
        
        $this->load->view('bulletins/nationalbulletin', $data);
        
    }
    
    public function regionallist()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 1 && $level != 2) {
            redirect('home', 'refresh');
        }
        
        $region_id = $this->erkanaauth->getField('region_id');
        
        if (getRole() != 'SuperAdmin' && $level != 1) {
            $data = array(
                'rows' => $this->bulletinsmodel->get_combined_list(2, $region_id)
            );
        } else {
            $data = array(
                'rows' => $this->bulletinsmodel->get_combined_list_region(2)
            );
            
        }
        
        $this->load->view('bulletins/regionsindex', $data);
    }
    
    public function addregional()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        $level = $this->erkanaauth->getField('level');
        
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 2 && $level != 1) {
            redirect('home', 'refresh');
        }
        
        
        
        $data = array();
        
        if (getRole() == 'SuperAdmin' && $level == 4) {
            $data['regions']   = $this->regionsmodel->get_list();
            $data['districts'] = $this->districtsmodel->get_list();
            $data['zones']     = $this->zonesmodel->get_list();
            
        }
        
        if ($level == 2) //regional
            {
            $region_id = $this->erkanaauth->getField('region_id');
            
            
            $region            = $this->regionsmodel->get_by_id($region_id)->row();
            $data['zone']      = $this->zonesmodel->get_by_id($region->zone_id)->row();
            $data['region']    = $this->regionsmodel->get_by_id($region->id)->row();
            $data['districts'] = $this->districtsmodel->get_by_region($region->id);
        }
        
        if ($level == 1) //zonal
            {
            $zone_id = $this->erkanaauth->getField('zone_id');
            
            
            $data['zone']      = $this->zonesmodel->get_by_id($zone_id)->row();
            $data['regions']   = $this->regionsmodel->get_by_zone($zone_id);
            $data['districts'] = $this->districtsmodel->get_list();
        }
        
        $data['level'] = $level;
        
        $this->load->view('bulletins/addregional', $data);
    }
    
    public function add_region_validate()
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 2 && $level != 1) {
            redirect('home', 'refresh');
        }
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('week_no', 'Week no', 'trim|required');
        $this->form_validation->set_rules('week_year', 'Week year', 'trim|required');
        $this->form_validation->set_rules('issue_no', 'Issue No.', 'trim|required');
        
        if ($this->form_validation->run() == false) {
            $this->addregional();
        } else {
            
            $week_no        = $this->input->post('week_no');
            $reporting_year = $this->input->post('week_year');
            $region_id      = $this->input->post('region_id');
            
            $reportperiod = $this->epdcalendarmodel->get_by_year_week($reporting_year, $week_no)->row();
            
            $reportingforms = $this->reportingformsmodel->get_by_period_region_list($reportperiod->id, $region_id, 0);
            
            $reporting_hf_count = count($reportingforms);
            
            $consultations = array();
            
            foreach ($reportingforms as $key => $reportingform) {
                $consultations[] = $reportingform['total_consultations'];
            }
            
            $total_consultation = array_sum($consultations);
            
            $data = array(
                'reportingperiod_id' => $reportperiod->id,
                'week_no' => $this->input->post('week_no'),
                'week_year' => $this->input->post('week_year'),
                'period_from' => $reportperiod->from,
                'period_to' => $reportperiod->to,
                'issue_no' => $this->input->post('issue_no'),
                'zone_id' => $this->input->post('zone_id'),
                'region_id' => $this->input->post('region_id'),
                'district_id' => $this->input->post('district_id'),
                'highlight' => '',
                'title' => '',
                'narrative' => '',
                'creation_date' => date('Y-m-d'),
                'creation_date_time' => date("Y-m-d H:i:s"),
                'level' => 2,
                'reportscount' => 0,
                'reporting_hf_count' => $reporting_hf_count,
                'total_consultation' => $total_consultation
            );
            
            $this->db->insert('bulletins', $data);
            
            $bulletin_id = $this->db->insert_id();
            
            redirect('bulletins/editregional/' . $bulletin_id, 'refresh');
            
        }
    }
    
    public function editregional($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 2 && $level != 1) {
            redirect('home', 'refresh');
        }
        
        $row  = $this->db->get_where('bulletins', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        $this->load->view('bulletins/editregional', $data);
    }
    
    public function edit_region_validate($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $level = $this->erkanaauth->getField('level');
        
        //accessible only to super admin and national FP 
        if (getRole() != 'SuperAdmin' && $level != 2 && $level != 1) {
            redirect('home', 'refresh');
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('highlight', 'Highlight', 'trim|required');
        $this->form_validation->set_rules('title', 'Leading Disease Title', 'trim|required');
        $this->form_validation->set_rules('narrative', 'Leading Disease Text', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->editregional($id);
        } else {
            $data = array(
                'highlight' => $this->input->post('highlight'),
                'title' => $this->input->post('title'),
                'narrative' => $this->input->post('narrative')
            );
            $this->db->where('id', $id);
            $this->db->update('bulletins', $data);
            redirect('bulletins/regionallist', 'refresh');
        }
    }
    
    public function regionsbulletin($id)
    {
        $row  = $this->db->get_where('bulletins', array(
            'id' => $id
        ))->row();
        $data = array(
            'row' => $row
        );
        
        $reportingperiod_id = $row->reportingperiod_id;
        $region_id          = $row->region_id;
        
        $alerts = $this->alertsmodel->get_by_period_status_region($reportingperiod_id, 1, $region_id);
        
        $alertstable = '<table id="customers">';
        $alertstable .= '<tr bgcolor="#1F7EB8"><td><font color="#FFFFFF"><strong>Suspected Disease</strong></font></td><td><font color="#FFFFFF"><strong>Zone</strong></font></td><td><font color="#FFFFFF"><strong>Region</strong></font></td><td><font color="#FFFFFF"><strong>District</strong></font></td><td><font color="#FFFFFF"><strong>HF</strong></font></td><td><font color="#FFFFFF"><strong>Action</strong></font></td><td><font color="#FFFFFF"><strong>Cases</strong></font></td><td><font color="#FFFFFF"><strong>Deaths</strong></font></td></tr>';
        
        foreach ($alerts as $key => $alert) {
            $zone           = $this->zonesmodel->get_by_id($alert['zone_id'])->row();
            $region         = $this->regionsmodel->get_by_id($alert['region_id'])->row();
            $district       = $this->districtsmodel->get_by_id($alert['district_id'])->row();
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($alert['healthfacility_id'])->row();
            
            $alertstable .= '<tr><td>' . $alert['disease_name'] . '</td>
		   <td>' . $zone->zone . '</td>
		   <td>' . $region->region . '</td>
		   <td>' . $district->district . '</td>
		   <td>' . $healthfacility->health_facility . '</td>
		   <td>' . $alert['notes'] . '</td>
		   <td>' . $alert['cases'] . '</td>
		   <td>' . $alert['deaths'] . '</td>
		   </tr>';
        }
        
        $alertstable .= '</table>';
        
        $data['alertstable'] = $alertstable;
        
        $this->load->view('bulletins/regionsbulletin', $data);
        
    }
    
    public function national_bulettin_pdf($id)
    {
        // create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('eDEWS Somalia');
        $pdf->SetTitle('National Weekly Bulletin');
        $pdf->SetSubject('National Weekly Bulletin');
        $pdf->SetKeywords('WHO, PDF, Bulettin, eDEWS');
        
        // set default header data
        $pdf->SetHeaderData(false, false, '', '');
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(
            PDF_FONT_NAME_MAIN,
            '',
            PDF_FONT_SIZE_MAIN
        ));
        $pdf->setFooterFont(Array(
            PDF_FONT_NAME_DATA,
            '',
            PDF_FONT_SIZE_DATA
        ));
        
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        //set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        //set some language-dependent strings
        //$pdf->setLanguageArray($l);
        
        // ---------------------------------------------------------
        
        // set font
        $pdf->SetFont('dejavusans', '', 9);
        
        // add a page
        $pdf->AddPage();
        
        $row = $this->db->get_where('bulletins', array(
            'id' => $id
        ))->row();
        
        
        //$html = '<table cellpadding="2" cellspacing="1" border="1"><tr><td><img src="'.absolute_path().'images/Header_title.png"></td></tr>';
        $html = '<table cellpadding="2" cellspacing="1" border="1"><tr><td><img src="http://www.cisp-som.org/edews/images/Header_title.png"></td></tr>';
        $html .= '<tr bgcolor="#1F7EB8"><th><font color="#FFFFFF"><strong>Issue ' . $row->issue_no . ' Epi Week ' . $row->week_no . ', ' . date("d F Y", strtotime($row->period_from)) . ' - ' . date("d F Y", strtotime($row->period_to)) . '</strong></font></th></tr>';
        
        $html .= '<tr><td>
		<table cellpadding="2" cellspacing="3">
		<tr><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>Highlights</strong></font></td><td bgcolor="#892A24" width="50%">&nbsp;</td></tr>
		<tr><td valign="top">' . $row->highlight . '</td><td valign="top">&nbsp;</td></tr>
		<tr><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>' . $row->title . '</strong></font></td><td bgcolor="#892A24" width="50%">&nbsp;</td></tr>
		<tr><td valign="top">' . $row->narrative . '</td><td valign="top">&nbsp;</td></tr>';
        
        $reportingperiod_id = $row->reportingperiod_id;
        
        $alerts = $this->alertsmodel->get_by_period_status($reportingperiod_id, 1);
        
        $alertstable = '<table cellpadding="2" cellspacing="3">';
        $alertstable .= '<tr bgcolor="#1F7EB8"><td><font color="#FFFFFF"><strong>Suspected Disease</strong></font></td><td><font color="#FFFFFF"><strong>Zone</strong></font></td><td><font color="#FFFFFF"><strong>Region</strong></font></td><td><font color="#FFFFFF"><strong>District</strong></font></td><td><font color="#FFFFFF"><strong>HF</strong></font></td><td><font color="#FFFFFF"><strong>Action</strong></font></td><td><font color="#FFFFFF"><strong>Cases</strong></font></td><td><font color="#FFFFFF"><strong>Deaths</strong></font></td></tr>';
        
        foreach ($alerts as $key => $alert) {
            $zone           = $this->zonesmodel->get_by_id($alert['zone_id'])->row();
            $region         = $this->regionsmodel->get_by_id($alert['region_id'])->row();
            $district       = $this->districtsmodel->get_by_id($alert['district_id'])->row();
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($alert['healthfacility_id'])->row();
            
            $alertstable .= '<tr><td>' . $alert['disease_name'] . '</td>
		   <td>' . $zone->zone . '</td>
		   <td>' . $region->region . '</td>
		   <td>' . $district->district . '</td>
		   <td>' . $healthfacility->health_facility . '</td>
		   <td>' . $alert['notes'] . '</td>
		   <td>' . $alert['cases'] . '</td>
		   <td>' . $alert['deaths'] . '</td>
		   </tr>';
        }
        
        $alertstable .= '</table>';
        
        $html .= '<tr bgcolor="#892A24"><td colspan="2"><font color="#FFFFFF"><strong>Alerts/Outbreaks Reported in Epi Week ' . $row->week_no . ', ' . date("d F Y", strtotime($row->period_from)) . ' - ' . date("d F Y", strtotime($row->period_to)) . '</strong></font></td></tr>';
        
        $html .= '<tr><td colspan="2">
				' . $alertstable . '
				</td></tr>';
        
        $html .= '</table>
		</td></tr>';
        
        $html .= '</table>';
        
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $txt = date("m/d/Y h:m:s");
        
        // print a block of text using Write()
        //$pdf->Write($h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // test pre tag
        
        
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        
        // reset pointer to the last page
        $pdf->lastPage();
        
        // ---------------------------------------------------------
        
        //Close and output PDF document
        ob_start();
        $pdf->Output('Weekly_National_bulletin.pdf', 'I');
        ob_end_flush();
        
        //============================================================+
        // END OF FILE                                                
        //============================================================+
    }
    
    
    public function regional_bulettin_pdf($id)
    {
        // create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('eDEWS Somalia');
        $pdf->SetTitle('Regional Weekly Bulletin');
        $pdf->SetSubject('Regional Weekly Bulletin');
        $pdf->SetKeywords('WHO, PDF, Bulettin, eDEWS');
        
        // set default header data
        $pdf->SetHeaderData(false, false, '', '');
        
        // set header and footer fonts
        $pdf->setHeaderFont(Array(
            PDF_FONT_NAME_MAIN,
            '',
            PDF_FONT_SIZE_MAIN
        ));
        $pdf->setFooterFont(Array(
            PDF_FONT_NAME_DATA,
            '',
            PDF_FONT_SIZE_DATA
        ));
        
        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        //set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        //set some language-dependent strings
        //$pdf->setLanguageArray($l);
        
        // ---------------------------------------------------------
        
        // set font
        $pdf->SetFont('dejavusans', '', 9);
        
        // add a page
        $pdf->AddPage();
        
        $row = $this->db->get_where('bulletins', array(
            'id' => $id
        ))->row();
        
        
        $html = '<table cellpadding="2" cellspacing="1" border="1"><tr><td><img src="' . absolute_path() . 'images/Header_title.png"></td></tr>';
        $html .= '<tr bgcolor="#1F7EB8"><th><font color="#FFFFFF"><strong>Issue ' . $row->issue_no . ' Epi Week ' . $row->week_no . ', ' . date("d F Y", strtotime($row->period_from)) . ' - ' . date("d F Y", strtotime($row->period_to)) . '</strong></font></th></tr>';
        
        $html .= '<tr><td>
		<table cellpadding="2" cellspacing="3">
		<tr><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>Highlights</strong></font></td><td bgcolor="#892A24" width="50%">&nbsp;</td></tr>
		<tr><td valign="top">' . $row->highlight . '</td><td valign="top">&nbsp;</td></tr>
		<tr><td bgcolor="#892A24" width="50%"><font color="#FFFFFF"><strong>' . $row->title . '</strong></font></td><td bgcolor="#892A24" width="50%">&nbsp;</td></tr>
		<tr><td valign="top">' . $row->narrative . '</td><td valign="top">&nbsp;</td></tr>';
        
        $reportingperiod_id = $row->reportingperiod_id;
        $region_id          = $row->region_id;
        
        $alerts = $this->alertsmodel->get_by_period_status_region($reportingperiod_id, 1, $region_id);
        
        $alertstable = '<table cellpadding="2" cellspacing="3">';
        $alertstable .= '<tr bgcolor="#1F7EB8"><td><font color="#FFFFFF"><strong>Suspected Disease</strong></font></td><td><font color="#FFFFFF"><strong>Zone</strong></font></td><td><font color="#FFFFFF"><strong>Region</strong></font></td><td><font color="#FFFFFF"><strong>District</strong></font></td><td><font color="#FFFFFF"><strong>HF</strong></font></td><td><font color="#FFFFFF"><strong>Action</strong></font></td><td><font color="#FFFFFF"><strong>Cases</strong></font></td><td><font color="#FFFFFF"><strong>Deaths</strong></font></td></tr>';
        
        foreach ($alerts as $key => $alert) {
            $zone           = $this->zonesmodel->get_by_id($alert['zone_id'])->row();
            $region         = $this->regionsmodel->get_by_id($alert['region_id'])->row();
            $district       = $this->districtsmodel->get_by_id($alert['district_id'])->row();
            $healthfacility = $this->healthfacilitiesmodel->get_by_id($alert['healthfacility_id'])->row();
            
            $alertstable .= '<tr><td>' . $alert['disease_name'] . '</td>
		   <td>' . $zone->zone . '</td>
		   <td>' . $region->region . '</td>
		   <td>' . $district->district . '</td>
		   <td>' . $healthfacility->health_facility . '</td>
		   <td>' . $alert['notes'] . '</td>
		   <td>' . $alert['cases'] . '</td>
		   <td>' . $alert['deaths'] . '</td>
		   </tr>';
        }
        
        $alertstable .= '</table>';
        
        $html .= '<tr bgcolor="#892A24"><td colspan="2"><font color="#FFFFFF"><strong>Alerts/Outbreaks Reported in Epi Week ' . $row->week_no . ', ' . date("d F Y", strtotime($row->period_from)) . ' - ' . date("d F Y", strtotime($row->period_to)) . '</strong></font></td></tr>';
        
        $html .= '<tr><td colspan="2">
				' . $alertstable . '
				</td></tr>';
        
        $html .= '</table>
		</td></tr>';
        
        $html .= '</table>';
        
        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        
        $txt = date("m/d/Y h:m:s");
        
        // print a block of text using Write()
        //$pdf->Write($h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // test pre tag
        
        
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        
        // reset pointer to the last page
        $pdf->lastPage();
        
        // ---------------------------------------------------------
        
        //Close and output PDF document
        ob_start();
        $pdf->Output('Weekly_Regional_bulletin.pdf', 'I');
        ob_end_flush();
        
        //============================================================+
        // END OF FILE                                                
        //============================================================+
    }
	
	public function checkavailability()
	{
		 $week_year           = trim(addslashes(htmlspecialchars(rawurldecode($_POST['week_year']))));
        $week_no    = trim(addslashes(htmlspecialchars(rawurldecode($_POST['week_no']))));
		
		
			$bulletin = $this->bulletinsmodel->get_by_year_week($week_year, $week_no)->row();
						
			
			if (empty($bulletin)) {
                echo '<input type="hidden" name="period_check" id="period_check" value="0">';
            } else {
				 echo '<strong><font color="#FF0000">The bulettin for '.$week_year.' week '.$week_no.' has already been added. </font></strong>';
				 echo '<input type="hidden" name="period_check" id="period_check" value="1">';
			}
		
	}
    
    public function delete($id)
    {
        if (!$this->erkanaauth->try_session_login()) {
            
            redirect('login', 'refresh');
            
        }
        
        $this->db->delete('bulletins', array(
            'id' => $id
        ));
        $this->index();
    }
    
}
