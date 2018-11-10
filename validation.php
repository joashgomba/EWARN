<script type="text/javascript">
var counter = 0;
function addInput(divName){
counter++; 
var Ai8ousa = document.createElement('div'); 
 Ai8ousa.innerHTML = "Field: "+(counter +1) + "<input type='text' name='field[]'>";   
document.getElementById(divName).appendChild(Ai8ousa);

}

function validations(form){
var field;
var i=0;
do{
     field=form[i];
       if (field.value=='')
          {
            alert('The field is null!!!'+i);
            return false;
          }
		  
		  i++;
}while(i<=counter);
}
</script>


<form action="" method="post" onSubmit="return validations(this)" >
<div id="dynamicInput">
Field : <input type="text" name="field[]" />  <br />
</div>
<input type="button" value="New field" onClick="addInput('dynamicInput');">
<input type="submit" value="Submit" />

</form>

<?php


$t1 = StrToTime ( '2014-03-03 11:30:00' );
$t2 = StrToTime ( '2014-03-02 12:30:00' );
$diff = $t1 - $t2;
$hours = $diff / ( 60 * 60 );

//echo $hours;

$date = date('Y-m-d h:i:s ', time());

//echo $date;

$str="20";

$str = ltrim($str, '0');

echo $str;

?>

<?php
$temp = 345;
$res = base64_encode($temp);
echo $res;echo "<br>";
$result = base64_decode($res);
echo $result;
?>
<br />
<?php

$zone_code = substr("Central",0,2); 
$reg_code = substr("Galgadud",0,2);
$dist_code = substr("Abudwak",0,2);


$hf_code = strtoupper($zone_code).'/'.strtoupper($reg_code).'/'.strtoupper($dist_code).'/HF-283';

echo 'Central: '.strtoupper($zone_code).'-1';

echo '<br>';

echo 'Galgadud: '.strtoupper($zone_code).'/'.strtoupper($reg_code).'-2';

echo '<br>';

echo 'Abudwak: '.strtoupper($zone_code).'/'.strtoupper($reg_code).'/'.strtoupper($dist_code).'-25';

echo '<br>';

echo '1st July HC: '.$hf_code;


?>
