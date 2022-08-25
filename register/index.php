
  <?php

    readfile("./html/register.html");
    $error_message = array("", "", "", "");
    $err = 0;
    $f_name = $email =  $username = $l_name = $website = "";
    $id = array('sname', 'semail', 'susername', 'spassword');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $rcv = array($_POST["f_name"], $_POST["l_name"], $_POST["email"], $_POST["username"], $_POST["psw"], $_POST["psw-repeat"]);
        $rcv_id = array("f_name", "l_name", "email", "username", "psw", "psw-repeat");
        echo '<script>var loader = document.getElementById("preloader");
    window.addEventListener("load", function () { loader.classList.remove("inv"); });</script>';
        if (empty($_POST["f_name"])) {
            $err = 1;
            $nameErr = "Please enter a valid name";
            $error_message[0] = $nameErr;
        } else {
            $f_name = test_input($_POST["f_name"]);
            if (!preg_match("/^[a-zA-Z-']*$/", $f_name)) {
                $err = 1;
                $nameErr = "Only letters and white space allowed";
                $error_message[0] = $nameErr;
            }
        }
        if (empty($_POST["l_name"])) {
            $err = 1;
            $nameErr = "Please enter a valid name";
            $error_message[0] = $nameErr;
        } else {
            $l_name = test_input($_POST["l_name"]);
            if (!preg_match("/^[a-zA-Z-']*$/", $l_name)) {
                $err = 1;
                $nameErr = "Only letters and white space allowed";
                $error_message[0] = $nameErr;
            }
        }


        if (empty($_POST["email"])) {
            $err = 1;
            $emailErr = "valid Email address";
            $error_message[1] = $emailErr;
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $err = 1;
                $emailErr = "The email address is incorrect";
                $error_message[1] = $emailErr;
            }
        }
        if (empty($_POST["username"])) {
            $err = 1;
            $usernameErr = "Please enter a valid name";
            $error_message[2] = $usernameErr;
        } else {
            $username = test_input($_POST["username"]);
            if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
                $err = 1;
                $usernameErr = "Only letters and white space allowed";
                $error_message[2] = $usernameErr;
            }
        }
        if (empty($_POST["psw"])) {
            $err = 1;
            $pswErr = "Enter a valid Password";
            $error_message[3] = $pswErr;
        } else {

            $password = test_input($_POST["psw"]);
            if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/", $password)) {
                $err = 1;
                $pswErr = "Password must be atleast 8 characters long with atleast 1 lowercase one uppercase 1 number and 1 special character";
                $error_message[3] = $pswErr;
            }
        }

        if (empty($_POST["psw-repeat"])) {
            $err = 1;
            $pswErr = "Please enter a valid password";
            $error_message[3] = $pswErr;
        } else {

            $c_password = test_input($_POST["psw-repeat"]);
            if ($c_password != $password) {
                $err = 1;
                $pswErr = "Confirm password and Password must match";
                $error_message[3] = $pswErr;
            }
        }
        for ($i = 0; $i <= 5; $i++) {
            echo "<script>insert_value('" . $rcv[$i] . "','" . $rcv_id[$i] . "');</script>";
        }

        if ($err == 0) {
            echo "<script>alert('maje m?');</script>";
            require("../global/php/encrypt_decrypt.php");
            $key = generate_random_key();
            $token = generate_random_token();
            $encrypted = encrypt_password($username, $token, $key, $password);
            require("../global/php/update_user.php");
            require("../global/php/database_connect.php");
            $conn = OpenCon();
            $resp = upload_user_data($f_name, $l_name, $email, $encrypted, $token, $key, $username, $conn);
            if ($resp == 1) {
                require("../register/php/send_verification_mail.php");
                $mail_resp=initiaize_mail_send($username);
                if($mail_resp==1)
                {
                    
                }
                else{
                    echo "<script>Error Sending verification mail Kindly try to login </script>";

                }
            } else {
            }
        } else {
            for ($i = 0; $i <= 3; $i++) {
                if ($error_message[$i] != "") {
                    echo "<script>insert_error('" . $error_message[$i] . "','" . $id[$i] . "');</script>";
                }
            }
        }
    }

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>