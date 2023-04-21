<?php

if (isset($_POST['submit'])) {
	if($_POST['g-recaptcha-response'] != ""){
		 include "db_config.php";
		$secret = '6Lc5t10fAAAAAJkYkoBik3z3kil9S9QILaS7ucs4';
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
		$responseData = json_decode($verifyResponse);
		if ($responseData->success) {

			$a = mysqli_real_escape_string($conn,$_POST['user_name']);
			$b = mysqli_real_escape_string($conn,$_POST['user_password']);

			$res = mysqli_query($conn, "select* from user where user_name='$a'and user_password='$b'");
			$result = mysqli_fetch_array($res);
			mysqli_close($conn);

			include "db_config.php";
			$sql = "SELECT * FROM user WHERE user_name = '$a' and user_password = '$b'";
			mysqli_query($conn, $sql);
			$rs = mysqli_query($conn, $sql);
			while ($rc = mysqli_fetch_assoc($rs)) {
				extract($rc);
				$c = $user_email;
			}
			mysqli_close($conn);


			if ($result) {
				if (isset($_REQUEST["remember"]) && $_REQUEST["remember"] == 1){
					setcookie("login", "1", time() + 60 * 60); // second on page time 
					setcookie("email", "$c", time() + 60 * 60);
				}else{
					setcookie("login", "1");
					setcookie("email", "$c");
				}
			} else {
				header("location:login.php?err=1");
			}
		}
		echo '<script type="text/javascript">';
		echo "alert('Login successfully')";
		echo '</script>';
		header("Refresh:0.1;url=index.php");
	} else {
		echo '<script type="text/javascript">';
		echo "alert('Please pass the recaptcha.')";
		echo '</script>';
		header("Refresh:0.1;url=login.php");
	}
   
}
?>
