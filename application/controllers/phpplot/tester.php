<?php
include('sender.php');

$gsm = array();

$gsm[] = '254721937404';

//$gsm[] = '252615549888';

//$gsm[] = '252695549888';

//$gsm[] = '254721846099';

//$gsm[] = '254721453042';

//print_r($gsm);

//echo end($gsm);

$limit = (sizeof($gsm) - 1);

$numbers = '';

for($i=0;$i<=$limit;$i++)
{
	if($gsm[$i]==end($gsm))
	{
		$numbers .= $gsm[$i];
	}
	else
	{
		//url encode the comma
		$numbers .= $gsm[$i].urlencode(',');
	}
}

$host = 'smsplus1.routesms.com';
$port = '8080';
$username = 'smartads';
$password = 'sma56rtw';
$sender = 'UNDSSMOG';
$message = 'Testing DSS MOG SMS system. Confirm receipt to jasgomba@yahoo.com';
$mobile = $numbers;
$msgtype = 0;
$dlr = 0;

$obj = new Sender($host,$port,$username,$password,$sender,$message,$mobile,$msgtype,$dlr);

$obj->Submit();