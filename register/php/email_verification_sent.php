<?
$username=$_GET["username"];
require('../../global/php/get_user_data.php');
require('../../global/php/database_connect.php');
require('../../global/php/encrypt_decrypt.php');
$conn=OpenCon();
$email=get_email_uid($username,$conn);

?>
<!DOCTYPE html>
<html id="mainfile">
<head>
  <title>Logicstics</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<link rel="stylesheet" href="\register\css\email_verification_sent_style.css">
</head>
<body onhashchange="hash_change()">
  <div id="preloader"></div>
<div id="nav-placeholder"></div>
    <div id="general-placeholder">
        <div id="grad1">
        <div class="container">
           <div id="capdiv">
                 <div class="column1">
                    <img id="imail" src="../media/alert.gif"/>
                 </div>
           <div class="column2">
             <div>
                 <h1>Please Verify Your Email</h1>
                 <p>A verification email has been sent to your registered mail id</p>

                 <div  id="mail"style="color:#333;text-align:center"><?php echo $email;?></div>
             </div>
           </div>
         </div>
      <hr>

      <div  id="mail2">Not Recieved <a id="resend" class="disabled"href="" disabled>Resend?</a>
        <div id="time" style="float:right;">2:00</div>
      </div>
  </div>
  </div>
</div>
<div style="flex-grow:1;width:100%;"></div>
<div id="footer-placeholder" ></div>
</body>
<script src="\global\script\basic_script.js"></script>
<script src="\register\script\email_verification_script.js"></script>
</html>
<div id="extra"></div>
<script>
    function send_verification_mail(){
        var phpadd= <?php require('../../register/php/send_verification_mail.php');  echo initiaize_mail_send($username);?>
    }
</script>