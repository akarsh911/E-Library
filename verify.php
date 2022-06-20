<?php
require('E:\Projects\HTML projects\E-Library\global\php\encrypt_decrypt.php');
require('E:\Projects\HTML projects\E-Library\global\php\update_user.php');
$short= $_GET['month'];
echo $short;
echo "<br>";
$url=get_url($short);
echo $url;
$final= str_decryptaesgcm($url, "verifymail", "base64");
echo "<br>";
 echo $final;

?>