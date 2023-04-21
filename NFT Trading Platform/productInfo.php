<?php session_start(); ?>

<!DOCTYPE html>
<html>
<title>Product Info</title>

<head>
	<link rel="stylesheet" href="css/menu.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/button.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<script>
		function check() {
			<?php
			$id = $_POST['id'];
			$email = $_COOKIE['email'];
			
			include "db_config.php";
			$sql = "SELECT * FROM `produce` WHERE `product_id` = '$id'";
			mysqli_query($conn, $sql);
			$rs = mysqli_query($conn, $sql);
			while($rc = mysqli_fetch_assoc($rs)){
				extract($rc);
				$price = $product_price;
				echo"
				var vprice = $price;
				";
			}
			mysqli_close($conn);
			
			include "db_config.php";
			$sql = "SELECT * FROM `user` WHERE `user_email` = '$email'";
			mysqli_query($conn, $sql);
			$rs = mysqli_query($conn, $sql);
			while($rc = mysqli_fetch_assoc($rs)){
				extract($rc);
				$coin = $polycoin;
				echo"
				var vcoin = $coin;
				";
			}
			mysqli_close($conn);
			?>

			if (vcoin <= vprice) {
				alert('Not enough money, please another product');
				window.location.replace('index.php');
				return false;
			}
			return true;
		}

	</script>

<body>
	<!-- the title-->
	<div id="title">
		<h1>NFT Product Information</h1>
	</div>

	<!--the menu-->

	<div class="menu">
		<li class="item" id='home'>
			<a href="index.php" class="btn"><i class="fas fa-home"></i>Home</a>
		</li>

		<?php
		if (isset($_COOKIE['email']))
			echo "
					<li class='item' id='product'>
					  <a href='uploadProducts.php' class='btn'><i class='fas fa-shopping-bag'></i>Product</a>
					</li>
				";
		?>

		<li class="item" id="settings">
			<a href="#settings" class="btn"><i class="fa fa-user-secret" aria-hidden="true"></i>Account</a>
			<div class="smenu">
				<?php
				if (!isset($_COOKIE['email']))
					echo "<a href=\"register.php\" class=\"sbtn\">Register</a>";
				if (!isset($_COOKIE['email']))
					echo "<a href=\"login.php\" class=\"sbtn\">Login</a>";
				if (isset($_COOKIE['email']))
					echo "<a href=\"logout.php\" class=\"sbtn\">Logout</a>";
				?>
			</div>
		</li>
	</div>

	<!--  the image/information-->
	<div class="info">
		<table border="1" class="productTable">
			<tr>
				<td>
					<?php
					$id = $_POST['id'];
					include "db_config.php";
					$sql = "SELECT `product_dir` FROM `produce` WHERE `product_id` = '$id'";
					$rs = mysqli_query($conn, $sql);

					while ($rc = mysqli_fetch_assoc($rs)) {
						extract($rc);
						echo "<div><img id='imgLink' src='image/$product_dir'></div>";
					}

					mysqli_free_result($rs);
					mysqli_close($conn);
					?>

				</td>
				<td>
					<h3>Information</h3>

					<?php
					//						$id = $_POST['id'];
					include "db_config.php";
					$sql = "SELECT `product_id`, `product_name`, `product_price` FROM `produce` WHERE `product_id` = '$id'";
					$rs = mysqli_query($conn, $sql);

					while ($rc = mysqli_fetch_assoc($rs)) {
						extract($rc);
						echo "<div>NFT Poduct Name: $product_name</div>";
						$price = $product_price;
			
						echo "<div>Price: $product_price</div>";
						$_SESSION['productId'] = $product_id;
					}
					mysqli_free_result($rs);
				
					?>
					<form method="post" action="#">
						<div>
							<input type="submit" class="submit" value="Buy" onclick="return check()" name="buy">
						</div>
					</form>
				</td>
			</tr>
		</table>
	</div>

	<?php
	if (isset($_POST["buy"])) {

			$email = $_COOKIE['email'];

			$otp = rand(100000, 999999);
			$_SESSION['otp'] = $otp;
			var_dump($otp);
			$_SESSION['mail'] = $email;
			require "Mail/phpmailer/PHPMailerAutoload.php";
			$mail = new PHPMailer;

			$mail->isSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 587;
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'tls';

			$mail->Username = 'aabc35429@gmail.com';
			$mail->Password = 'qwer4321fdsa';

			$mail->setFrom('aabc35429@gmail.com', 'OTP Verification');
			$mail->addAddress($email);

			$mail->isHTML(true);
			$mail->Subject = "Verity code";
			$mail->Body = "<p>Dear User,</p> <h3>Your verify code is $otp<br></h3> ";
			if (!$mail->send()) {
				echo "
				<script>
					alert('Failed, Please login first.');
					window.location.replace('index.php');
				</script>
				";
			} else {
				echo "
			<script>
				alert('Request Successfully, OTP sent');
				window.location.replace('inputOTP.php');
			</script>
			";
			}
		}	
	?>
</body>

</html>
