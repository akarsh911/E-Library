<?php
$error=0;
$uid="";
$pass="";
readfile("./html/register.html");
if($error==0)
{
    require ("/global/php/encrypt_decrypt.php");
    $key=generate_random_key();
    $token=generate_random_token();
    $encrypted=encrypt_password($uid,$token,$key,$pass);
    require ("global/php/update_user.php");
   

}
?>