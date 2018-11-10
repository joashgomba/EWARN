<?php
/**
$data = array(
                'week_no' => '20',
                'reporting_year' => '2017',
                'reporting_date' => '2017-05-16',
                'epdcalendar_id' => 1,
                'user_id' => 1,
                'healthfacility_id' => 1,
                'contact_number' => '254721937404',
                'health_facility_code' => '222',
                'supporting_ngo' => 'WHO',
                'region_id' => 1,
                'sariufivemale' => '0',
                'sariufivefemale' => '0',
                'sariofivemale' => '0',
                'sariofivefemale' => '0',
                'iliufivemale' => '0',
                'iliufivefemale' => '0',
                'iliofivemale' => '0',
                'iliofivefemale' => '0',
                'awdufivemale' => '0',
                'awdufivefemale' => '0',
                'awdofivemale' => '0',
                'awdofivefemale' => '0',
                'bdufivemale' => '0',
                'bdufivefemale' => '0',
                'bdofivemale' => '0',
                'bdofivefemale' => '0',
                'oadufivemale' => '0',
                'oadufivefemale' => '0',
                'oadofivemale' => '0',
                'oadofivefemale' => '0',
                'diphmale' => '0',
                'diphfemale' => '0',
                'wcmale' => '0',
                'wcfemale' => '0',
                'measmale' => '0',
                'measfemale' => '0',
                'nntmale' => '0',
                'nntfemale' => '0',
                'afpmale' => '0',
                'afpfemale' => '0',
                'ajsmale' => '0',
                'ajsfemale' => '0',
                'vhfmale' => '0',
                'vhffemale' => '0',
                'malufivemale' => '0',
                'malufivefemale' => '0',
                'malofivemale' => '0',
                'malofivefemale' => '0',
                'suspectedmenegitismale' => '0',
                'suspectedmenegitisfemale' => '0',
                'undisonedesc' => '0',
                'undismale' => '0',
                'undisfemale' => '0',
                'undissecdesc' => '0',
                'undismaletwo' => '0',
                'undisfemaletwo' => '0',
                'ocmale' => '0',
                'ocfemale' => '0',
                'total_consultations' => 0,
                'sre' => '0',
                'pf' => '0',
                'pv' => '0',
                'pmix' => '0',
                'totalnegative' => 0,
                'total_positive' => 0,
                'approved_hf' => 0,
                'approved_regional' => 0,
                'approved_zone' => 0,
                'draft' => 0,
                'alert_sent' => 0,
                'entry_date' => '2017-05-16',
                'entry_time' => '0',
                'edit_date' => '2017-05-16',
				'edit_time' => '0',
                'diphofivemale' => '0',
				'diphofivefemale' => '0',
				'wcofivemale' => '0',
				'wcofivefemale' => '0',
				'measofivemale' => '0',
				'measofivefemale' => '0',
				'afpofivemale' => '0',
				'afpofivefemale' => '0',
				'suspectedmenegitisofivemale' => '0',
				'suspectedmenegitisofivefemale' => '0'
				
            );
			
			**/
			
			$data = '{"week_no":"1","reporting_year":"2013","reporting_date":"2013-10-30","epdcalendar_id":"1","user_id":"1","healthfacility_id":"1","contact_number":"123654","health_facility_code":"111101","supporting_ngo":"WHO","region_id":"1","sariufivemale":"4","sariufivefemale":"1","sariofivemale":"0","sariofivefemale":"0","iliufivemale":"0","iliufivefemale":"0","iliofivemale":"0","iliofivefemale":"0","awdufivemale":"0","awdufivefemale":"0","awdofivemale":"0","awdofivefemale":"0","bdufivemale":"0","bdufivefemale":"0","bdofivemale":"0","bdofivefemale":"0","oadufivemale":"0","oadufivefemale":"0","oadofivemale":"0","oadofivefemale":"0","diphmale":"0","diphfemale":"0","wcmale":"0","wcfemale":"0","measmale":"0","measfemale":"0","nntmale":"0","nntfemale":"0","afpmale":"0","afpfemale":"0","ajsmale":"0","ajsfemale":"0","vhfmale":"0","vhffemale":"0","malufivemale":"0","malufivefemale":"0","malofivemale":"0","malofivefemale":"0","suspectedmenegitismale":"0","suspectedmenegitisfemale":"0","undisonedesc":"  0","undismale":"1","undisfemale":"0","undissecdesc":"none","undismaletwo":"0","undisfemaletwo":"0","ocmale":"0","ocfemale":"0","total_consultations":"6","sre":"10","pf":"2","pv":"1","pmix":"1","totalnegative":"6","total_positive":"4","approved_hf":"1","approved_regional":"0","approved_zone":"0","draft":"0","alert_sent":"1","entry_date":"2013-12-08","entry_time":"2013-12-08 03:18:29","edit_date":"2013-12-14","edit_time":"2013-12-14 09:17:46","diphofivemale":"0","diphofivefemale":"0","wcofivemale":"0","wcofivefemale":"0","measofivemale":"0","measofivefemale":"0","afpofivemale":"0","afpofivefemale":"0","suspectedmenegitisofivemale":"0","suspectedmenegitisofivefemale":"0"}';
$curl_handle = curl_init(); 
curl_setopt($curl_handle, CURLOPT_URL, "http://localhost:81/who/api/form/create.php"); 
curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1); 
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl_handle, CURLOPT_POST, 1); 
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data); 
$response = curl_exec($curl_handle) or die("Connection error."); 
curl_close($curl_handle);

echo $response;




