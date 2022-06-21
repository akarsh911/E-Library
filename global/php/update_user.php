<?php

function upload_user_data($f_name,$l_name,$email_address,$password_hash,$access_token,$hash_key,$username,$conn)
{
$email_verify="0";
$sql = "INSERT INTO users (first_name, last_name, email_address,password_hash,access_token,hash_key,username,email_verify) VALUES ('$f_name', '$l_name', '$email_address','$password_hash','$access_token','$hash_key','$username','$email_verify')";
if ($conn->query($sql) === TRUE) {
  return "1";
} else {
  return "Error: " . $sql . "<br>" . $conn->error;
}
}

function update_email_verification_token($username,$token,$conn)
{  
    $sql="UPDATE users SET email_verify='$token' WHERE username='$username'";
  
  if ($conn->query($sql) === TRUE) {
    return "1";
  } else {
    return "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}

function save_short_url($main,$short,$username,$conn)
{
  $date= date("Y-m-d h:i:sa");
  $id=get_url_uid($username,$conn);
  if($id==0)
  {
    $sql = "INSERT INTO short_url (base_url, coded_url, date_created,username) VALUES ('$main', '$short', '$date','$username')";
  }
  else
  {
    $sql="UPDATE short_url SET base_url='$main',coded_url='$short',date_created='$date' WHERE id='$id'";
  }
  if ($conn->query($sql) === TRUE) {
    return "1";
  } else {
    return "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
}
function get_url($short,$conn)
{
  $sql="SELECT base_url FROM short_url WHERE coded_url='$short'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["base_url"];
  }
  }
 else {
  return 0;
  }
  $conn->close();
}

function get_url_uid($username,$conn)
{

  $sql="SELECT base_url,id FROM short_url WHERE username='$username'";
  $result = $conn->query($sql);
  $id=0;
  if ($result->num_rows > 0) {
    $c=0;
  while($row = $result->fetch_assoc()) {
    $c++;
    if($c==1)
    {
      $id=$row["id"];
    }
  
  }
  if($c<5)
  {  return 0;}
  else
  { 
    return $id;
  }
  }
 else {
  return 0;
  }
  $conn->close();
}
?>