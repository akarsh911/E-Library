<?php

function get_full_name($username,$conn)
{
  $sql="SELECT first_name, last_name FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["first_name"]. " " . $row["last_name"];
  }
} else {
  return "0";
}
$conn->close();
}


function get_first_name($username,$conn)
{
  $sql="SELECT first_name FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["first_name"];
  }
  } else {
  return "0";
  }
  $conn->close();
}




function verify_password($username,$value,$conn)
{
  $sql="SELECT password_hash,access_token,hash_key,username,email_verify FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $pass= $row["password_hash"];
    $token=$row["access_token"];
    $key=$row["hash_key"];
    $uid=$row["username"];
    $encr=get_encrypted_data($uid,$value,$key,$token);
    if($encr==$pass)
    {
      if($row["email_verify"]==1){return "1";}
      else {
      return "3";
      }
      }
    else {
      return "2";
    }

  }
  } else {
  return "0";
  }
  $conn->close();
}

function get_email_verify_status($username,$conn)
{
  $sql="SELECT email_verify FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["email_verify"];
  }
  } else {
  return "0";
  }
  $conn->close();
}


function get_avatar($username,$conn)
{
  $sql="SELECT avatar_url FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["avatar_url"];
  }
  } else {
  return "0";
  }
  $conn->close();
}


function get_email_uid($username,$conn)
{
  $sql="SELECT email_address FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["email_address"];
  }
  } else {
  return "0";
  }
  $conn->close();
}

function get_uid_email($username,$conn)
{
  $sql="SELECT username FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["usename"];
  }
  } else {
  return "0";
  }
  $conn->close();
}


function get_uid_availaibility($username,$conn)
{
  $sql="SELECT username FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["username"];
  }
  }
 else {
  return 0;
  }
  $conn->close();
}

function get_email_availaibility($username,$conn)
{
  $sql="SELECT email_address FROM users WHERE username='$username' || email_address='$username'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    return $row["email_address"];
  }
  } else {
  return "0";
  }
  $conn->close();
}

function get_encrypted_data($uid,$value,$key,$token)
{
  $postdata = http_build_query(
    array(
        'uid' => $uid,
        'value' => $value,
        'key'=> $key,
        'token'=> $token
    )
);
$opts = array('http' =>
    array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$context = stream_context_create($opts);
$result = file_get_contents('http://localhost/return_auth_token.php', false, $context);
return $result;
}
