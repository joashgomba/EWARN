<?php
$link = @mysql_connect('localhost', 'root', 'test');
$item = $_POST['itemName'];

foreach( $item as $key => $val ) {
 $sql = "INSERT INTO cart (element) VALUES ('".$val."')";
}