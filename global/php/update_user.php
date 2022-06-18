<?php
require '../global/php/database_connect.php';
function upload_user_data($f_name,$l_name,$email_address,$password_hash,$access_token,$hash_key,$username)
{
$email_verify="0";
$conn=OpenCon();
$sql = "INSERT INTO users (first_name, last_name, email_address,password_hash,access_token,hash_key,username,email_verify) VALUES ('$f_name', '$l_name', '$email_address','$password_hash','$access_token','$hash_key','$username','$email_verify')";

if ($conn->query($sql) === TRUE) {
  return "1";
} else {
  return "Error: " . $sql . "<br>" . $conn->error;
}
}

function update_email_verification_token($username,$token)
{
  $conn=OpenCon();
  $sql = "";
}

?>