<?php
$username=$_GET['username'];
require ('../../global/php/database_connect.php');
require ('../../global/php/get_user_data.php');
$conn=OpenCon();
$em=get_uid_availaibility($username,$conn);
if($em==0) {
    echo 1;
}
else {
    echo 0;
}

?>