<?php
function randomHex() {
   $chars = 'ABCDEF0123456789';
   $color = '#';
   for ( $i = 0; $i < 6; $i++ ) {
      $color .= $chars[rand(0, strlen($chars) - 1)];
   }
   return $color;
}

$colors = "";

for($i=1; $i<=14; $i++)
{
	//$colors .= "'".randomHex()."',";
	
	$hex = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
	
	$colors .= "'".$hex."',";
}

echo $colors;
?>