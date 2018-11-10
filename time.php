<?php
//echo  date("Y-m-d H:i:s");

//loop to get EPI values from the first entry
for($i=1;$i<=52;$i++)
{
	//echo '2012 - '.$i.'<br>';
}

/**
SQL code for the seconh selection

SELECT * 
FROM  `epdcalendar` 
WHERE  `epdyear` =  '2013'
AND week_no <=1

**/


$data = array();
	$gps = array();
	$points = array();
	
	//$points = array();

		 for($i=0;$i<1;$i++)
		 {
		   $gps['lat'] = '-1.112982366348';
		   $gps['lng'] = '36.635627746582';
		   
		   $data['position'] = $gps;
		   
		   $data['icon'] = 'img/pin2.png';
		   $data['info'] = 'Hello Joash!';
		   
		   $points[] = $data;
		   
		   $gps['lat'] = '-1.3930664629646';
		   $gps['lng'] = '36.691761016846';
		   
		   $data['position'] = $gps;
		   
		   $data['icon'] = 'img/pin2.png';
		   $data['info'] = 'Hello World!!';
		   
		   $points[] = $data;
		  
		   
		  
		 }
	 
 //print_r($points);
 
 
 echo substr('254721937404', 0, 3);
 
 
?>
<style>
p.page { page-break-after: always; }
</style>
<body>
content on page 1
<p class="page"></p>
content on page 2

 <script>
						Date.prototype.yyyymmdd = function() {         
                                
        var yyyy = this.getFullYear().toString();                                    
        var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based         
        var dd  = this.getDate().toString();             
                            
        return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
   }; 

d = new Date();
today = d.yyyymmdd();


function formatDate(d){
   function pad(n){return n<10 ? '0'+n : n}
   return [d.getUTCFullYear(),'-',
          pad(d.getUTCMonth()+1),'-',
          pad(d.getUTCDate()),' ',
          pad(d.getUTCHours()),':',
          pad(d.getUTCMinutes()),':',
          pad(d.getUTCSeconds())].join("");
  }

  var dt = new Date();
  var formattedDate = formatDate(dt); 
						 
  //document.write("<input type='text' name='time' value='" + today + "'><br>")
  document.write("<input type='text' name='time' value='" +formattedDate+ "'>")
							</script>
                            
                            <?php
$ddate = "2014-03-05";
$duedt = explode("-", $ddate);
$date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
$week  = (int)date('W', $date);
echo "Weeknummer: " . $week;
?>

</body>