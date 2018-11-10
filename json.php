<?php
$json = '{
    "zone_id": "1",
    "region_id": "2",
    "district_id": "3",
    "health_facility_id": "4",
    "reporting_year": "2017",
    "reporting_week": "41",
    "reporting_date": "2017-04-09",
    "reporter_id": "1",
    "health_events": {
        "1_u_f_m": "1",
        "1_u_f_f": "2",
		"1_o_f_m": "3",
		"1_o_f_f": "4",
		"2_u_f_m": "5",
        "2_u_f_f": "6",
		"2_o_f_m": "7",
		"2_o_f_f": "8",
		"3_u_f_m": "9",
        "3_u_f_f": "10",
		"3_o_f_m": "11",
		"3_o_f_f": "12"
     
    },
    "other_unusual_diseases": {
         "description_one": "N/A", 
		 "male_one": "0", 
		 "female_one": "0",
		 "description_two": "N/A", 
		 "male_two": "0", 
		 "female_two": "0",
		 "oc_male": "5", 
		 "oc_female": "10"
     
    },
	"malaria_tests": {
        "rdt_examined": "0",
        "falciparum_positive": "0",
        "vivax_positive": "0",
        "mixed_positive": "0"
    }
}';
	

$arr = json_decode($json,true);//decode object

//print_r($arr);

$zone_id = $arr['zone_id'];
echo 'Zone ID: '.$zone_id.'<br>';

$region_id = $arr['region_id'];
echo 'Region ID: '.$region_id.'<br>';

$district_id = $arr['district_id'];
echo 'District ID: '.$district_id.'<br>';

$health_facility_id = $arr['health_facility_id'];
echo 'HF ID: '.$health_facility_id.'<br>';

$reporting_year = $arr['reporting_year'];
echo 'Reporting Year: '.$reporting_year.'<br>';

$reporting_week = $arr['reporting_week'];
echo 'reporting week: '.$reporting_week.'<br>';

$reporting_date = $arr['reporting_date'];
echo 'reporting date: '.$reporting_date.'<br>';

$reporter_id = $arr['reporter_id'];
echo 'reporter id: '.$reporter_id.'<br>';
echo '<br>';
$health_events = $arr['health_events'];
echo 'health_events:';
//print_r($health_events);
echo '<br>----------------<br>';

echo '<br>';

for($i=1;$i<=3;$i++)
{
	$male_u_f = $i.'_u_f_m';
	$female_u_f = $i.'_u_f_f';
	$male_o_f = $i.'_o_f_m';
	$female_o_f = $i.'_o_f_f';
	
	$under_five_male =  $health_events["".$male_u_f.""];
	$under_five_female =  $health_events["".$female_u_f.""];
	$over_five_male =  $health_events["".$male_o_f.""];
	$over_five_female =  $health_events["".$female_o_f.""];
	$total_under_five = ($under_five_male+$under_five_female);
	$total_over_five = ($over_five_male+$over_five_female);
	$total_disease = ($total_under_five+$total_over_five);
	
	echo 'Disease ID: '.$i.' Male < Five: '.$under_five_male.'<br>';
	echo 'Disease ID: '.$i.' Female < Five: '.$under_five_female.'<br>';
	echo 'Disease ID: '.$i.' Male > Five: '.$over_five_male.'<br>';
	echo 'Disease ID: '.$i.' Female > Five: '.$over_five_female.'<br>';
	echo '---------------------------<br>';
	echo 'Disease ID: '.$i.' Total < Five: '.$total_under_five.'<br>';
	echo 'Disease ID: '.$i.' Total > Five: '.$total_over_five.'<br>';
	echo 'Disease ID: '.$i.' Total Disease: '.$total_disease.'<br>';
	echo '<hr>';
	
	
}


echo '<br>';
echo '<br>';

$other_unusual_diseases = $arr['other_unusual_diseases'];
echo 'UnDis:';
echo '<br>----------------<br>';
echo '<br>';

echo 'description one: '.$other_unusual_diseases['description_one'].'<br>';
echo 'description one: '.$other_unusual_diseases['male_one'].'<br>';
echo 'description one: '.$other_unusual_diseases['female_one'].'<br>';
echo 'description two: '.$other_unusual_diseases['description_two'].'<br>';
echo 'male two: '.$other_unusual_diseases['male_two'].'<br>';
echo 'female two: '.$other_unusual_diseases['female_two'].'<br>';
echo 'OC Male: '.$other_unusual_diseases['oc_male'].'<br>';
echo 'OC Female: '.$other_unusual_diseases['oc_female'].'<br>';

$malaria_tests = $arr['malaria_tests'];
echo '<br>malaria_tests:';
echo '<br>----------------<br>';

echo 'rdt examined: '.$malaria_tests['rdt_examined'].'<br>';
echo 'falciparum positive: '.$malaria_tests['falciparum_positive'].'<br>';
echo 'vivax positive: '.$malaria_tests['vivax_positive'].'<br>';
echo 'mixed positive: '.$malaria_tests['mixed_positive'].'<br>';


echo '<br>';
echo '<br>';

$emjson = '{
    "zone_id": "45",
    "region_id": "1",
    "district_id": "1",
    "health_facility_id": "100",
    "reporting_year": "2017",
    "reporting_week": "26",
    "reporting_date": "2017-05-05",
    "reporter_id": "1",
    "disease": "14",
    "male_under_5": "10",
    "female_under_5": "5",
    "male_over_5": "3",
    "female_over_5": "6",
    "deaths": "15"
}';

$emarr = json_decode($emjson,true);//decode object

//print_r($emarr);

echo 'Emergency Alerts';
echo '<br>----------------<br>';
$zone_id = $emarr['zone_id'];
echo 'Zone ID: '.$zone_id.'<br>';
$region_id = $emarr['region_id'];
echo 'Region ID: '.$region_id.'<br>';
$district_id = $emarr['district_id'];
echo 'District ID: '.$district_id.'<br>';
$health_facility_id = $emarr['health_facility_id'];
echo 'HF ID: '.$health_facility_id.'<br>';

$reporting_year = $emarr['reporting_year'];
echo 'Reporting Year: '.$reporting_year.'<br>';

$reporting_week = $emarr['reporting_week'];
echo 'reporting week: '.$reporting_week.'<br>';

$reporting_date = $emarr['reporting_date'];
echo 'reporting date: '.$reporting_date.'<br>';

$disease = $emarr['disease'];
echo 'disease: '.$disease.'<br>';

$male_under_5 = $emarr['male_under_5'];
echo 'male_under_5: '.$male_under_5.'<br>';

$female_under_5 = $emarr['female_under_5'];
echo 'female_under_5: '.$female_under_5.'<br>';

$male_over_5 = $emarr['male_over_5'];
echo 'male_over_5: '.$male_over_5.'<br>';

$female_over_5 = $emarr['female_over_5'];
echo 'female_over_5: '.$female_over_5.'<br>';

$deaths = $emarr['deaths'];
echo 'deaths: '.$deaths.'<br>';
