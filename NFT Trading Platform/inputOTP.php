<?php session_start(); ?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>OTP</title>
	<!-- CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
	<div class="container">

		<div class="row">
			<div class="col"></div>
			<div class="col-6">
				<div class="card">
					<div class="card-header text-center">
						Input One-time password
					</div>
					<div class="card-body">
						<form action="#" method="post">
							<div class="form-group">
								<label for="otp">One-time password</label>
								<input type="text" name="otp_code" class="form-control" id="otp" required="" placeholder="otp">
								<br>
								<a href="">send again</a>
							</div>
							<br>
							<input type="submit" value="Verify" name="verify" class="btn btn-primary">

						</form>
					</div>
				</div>
			</div>
			<div class="col"></div>
		</div>
	</div>


	<?php
	if (isset($_POST['verify'])) {
		$otp = $_SESSION['otp'];
		$email = $_COOKIE['email'];
		$otp_code = $_POST['otp_code'];

		if ($otp != $otp_code) {
	?>
			<script>
				alert("Invalid OTP code");
			</script>
		<?php
		} else {
		?>

			<?php
			$id = $_SESSION['productId'];

			include "db_config.php";
			$sql = "SELECT * FROM `produce` WHERE `product_id` = '$id'";
			mysqli_query($conn, $sql);
			$rs = mysqli_query($conn, $sql);
			while ($rc = mysqli_fetch_assoc($rs)) {
				extract($rc);
				$price = (int)$product_price;
				$data = $product_owner;
				$key = $product_key;
			}
			
			mysqli_close($conn);

			include "db_config.php";
			$sql = "SELECT * FROM `user` WHERE `user_email` = '{$_COOKIE['email']}'";
			$rs = mysqli_query($conn, $sql);
			while ($rc = mysqli_fetch_assoc($rs)) {
				extract($rc);
				$username = $user_name;
				$coin = (int)$polycoin;
			}
		
		
		
			mysqli_close($conn);

			//DECRYPT FUNCTION
			function decrypt($data, $key)
			{
				$encryption_key = base64_decode($key);
				list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
				return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
			}

			$decrypteddata = decrypt($data, $key);

			$str_sec = explode("#", $decrypteddata);
			$str_sec[0] = $username;
			$str_sec[1] = $id;

			$str = rand();
			$key = md5($str);
			$data = "$str_sec[0]#$str_sec[1]";

			//ENCRYPT FUNCTION
			function encrypt($data, $key)
			{
				$encryption_key = base64_decode($key);
				$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
				$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
				return base64_encode($encrypted . '::' . $iv);
			}

			$encrypteddata = encrypt($data, $key);


			include "db_config.php";
			$sql = "UPDATE `produce` SET `product_owner` = '$encrypteddata', `product_key` = '$key' WHERE `produce`.`product_id` = '$id';";
			mysqli_query($conn, $sql);
			$result = $coin - $price;
			$sql2 = "UPDATE `user` SET `polycoin` = '$result' WHERE `user`.`user_email` = '$email';";
			mysqli_query($conn, $sql2);
			mysqli_close($conn);
			


			?>




			<script>
				alert("Verify Success, Transaction is done!");
				window.location.replace("index.php");
			</script>
	<?php
		}
	}
	?>
</body>

</html>