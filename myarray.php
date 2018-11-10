<?php
error_reporting(0);

$val = '1_u_f_m-23#1_u_f_f-34#1_o_f_m-3#1_o_f_f-4#2_u_f_m-5#2_u_f_f-53#2_o_f_m-353#2_o_f_f-4#3_u_f_m-45#3_u_f_f-5#3_o_f_m-6#3_o_f_f-66#4_u_f_m-0#4_u_f_f-56#4_o_f_m-0#4_o_f_f-56#5_u_f_m-0#5_u_f_f-0#5_o_f_m-0#5_o_f_f-0#6_u_f_m-0#6_u_f_f-0#6_o_f_m-0#6_o_f_f-0#7_u_f_m-0#7_u_f_f-0#7_o_f_m-0#7_o_f_f-0#8_u_f_m-0#8_u_f_f-0#8_o_f_m-0#8_o_f_f-0#9_u_f_m-0#9_u_f_f-0#9_o_f_m-0#9_o_f_f-0#10_u_f_m-0#10_u_f_f-0#10_o_f_m-0#10_o_f_f-0#11_u_f_m-0#11_u_f_f-0#11_o_f_m-0#11_o_f_f-0#12_u_f_m-0#12_u_f_f-0#12_o_f_m-0#12_o_f_f-0#13_u_f_m-0#13_u_f_f-0#13_o_f_m-0#13_o_f_f-0#14_u_f_m-0#14_u_f_f-0#14_o_f_m-0#14_o_f_f-0#';

$arr = array();
//$arr["disease_data"]=array();

if( strpos( $val, "#" ) === false ) 
{
	echo "NO HASH !";
}
else 
{
	$j=0;
	
	for($i=0;$i<=55;$i++)
	{
		//echo "HASH IS: #".explode( "#", $val )[$i]."<br>"; // arrays are indexed from 0
		
		$str = explode( "#", $val )[$i];
		preg_match_all('!\d+!', $str, $matches);
		//print_r($matches);
		
		$words = preg_replace('/[0-9]+/', '', $str);
		
		//$under_five_male = 0;
		//$under_five_female = 0;
		
		echo 'Category: '.$words.' Disease_id:'.$matches[0][0].', Value:'.$matches[0][1].'<br>';
		
		$j++;
		
		if($words=='_u_f_m-')
		{
			$under_five_male = $matches[0][1];
				
			//echo $under_five_male.'<br>';
		}
		else
		{
			//$under_five_male = '';
		}
		
		$total_under_five =0;
		
		if($j<=4){
		
			if($words=='_u_f_f-')
			{
				$under_five_female = 0+$matches[0][1];
				
			}
			
			else
			{
				//$under_five_female = '';
			}
			
			if($words=='_o_f_m-')
			{
				$over_five_male = 0+$matches[0][1];
			}
			else
			{
				//$over_five_male = '';
			}
			
			if($words=='_o_f_f-')
			{
				$over_five_female = 0+$matches[0][1];
			}
			
			else
			{
				//$over_five_female = '';
			}
			
			$total_under_five = ($under_five_male+$under_five_female);
			$total_over_five = ($over_five_male+$over_five_female);
			$total_disease = ($total_under_five+$total_over_five);
			
			if($j==4)
			{
			$sql = "INSERT INTO formsdata (id,disease_id,male_under_five,female_under_five, male_over_five,female_over_five,total_under_five,total_over_five,total_disease) VALUES(-1,-".$matches[0][0].",".$under_five_male.",".$under_five_female.", ".$over_five_male.",".$over_five_female.",".$total_under_five.",".$total_over_five.",".$total_disease.");";
			
			echo $sql."<br>";
			
			
			
			}
		
		
		
	    }
		else
		{
			$j=1;
		}
			
		
				
		$arr[] = $matches;
		
		
	}
}


//print_r(json_encode($arr));

//print_r($arr);

//print_r(json_encode($matches));

foreach ($arr as $key => &$value) {
   // var_dump($key, $value); 
	
	
}



?>