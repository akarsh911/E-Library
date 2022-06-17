<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "connection";
 $dbpass = "ork9Ld-dB7A3p(6M";
 $db = "user_data";
 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

 return $conn;
 }

function CloseCon($conn)
 {
 $conn -> close();
 }

?>
