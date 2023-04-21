<?php

if (isset($_POST['submit']) && $_POST['g-recaptcha-response'] != "") {
    include "db_config.php";
    $secret = '6Lc5t10fAAAAAJkYkoBik3z3kil9S9QILaS7ucs4';
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        
        //first validate then insert in db
        $name = mysqli_real_escape_string($conn, $_POST['user_name']);
        $email = mysqli_real_escape_string($conn,$_POST['user_email']);
        $pass = mysqli_real_escape_string($conn,$_POST['user_password']);
        $sql = "INSERT INTO user(user_email,user_name,user_password,polycoin) VALUES('$email', '$name', '$pass','10000')";
        mysqli_query($conn, $sql);
        //change to next page 
		echo '<script type="text/javascript">';
		echo "alert('Your registration has been successfully done!')";
		echo '</script>';
		mysqli_close($conn);
		header("Refresh:0.1;url=index.php");

    }
}