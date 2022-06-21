<?php
require('E:\Projects\HTML projects\E-Library\global\php\encrypt_decrypt.php');
require('E:\Projects\HTML projects\E-Library\global\php\update_user.php');
require('E:\Projects\HTML projects\E-Library\global\php\database_connect.php');
require('E:\Projects\HTML projects\E-Library\global\php\get_user_data.php');
$short= $_GET['value'];
$conn=OpenCon();
echo $short;
echo "<br>";
$url=get_url($short,$conn);
echo $url;
$final= str_decryptaesgcm($url, "verifymail", "base64");
echo "<br>";
 echo $final;
$username=substr($final,0,stripos($final,"^$^user^$^") );
$value=substr($final,stripos($final,"^$^user^$^")+10);

$conn=OpenCon();
if(get_uid_availaibility($username,$conn))
if(get_email_verify_status($username,$conn)==$value)
{
    $time1= date('d-m-Y H:i:s',$value);
    $start = strtotime($time1);
$end =strtotime(date('d-m-Y H:i:s'));
$elapsed = $end - $value;
$fg=0;
if($elapsed<=600)
{
    echo "Success";
    update_email_verification_token($username,"true",$conn);
}
else {
  $fg=1;
  echo "time khatam";
  // code...
}
}


?>