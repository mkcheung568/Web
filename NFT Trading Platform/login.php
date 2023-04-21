<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Register</title>
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
						Login Account
					</div>
					<div class="card-body">
						<form action="loginprocess.php" method="post">

							<div class="form-group">
								<label for="exampleInputEmail1">User name</label>
								<input type="text" name="user_name" class="form-control" id="user_name"  required="" placeholder="Enter user name">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Password</label>
								<input type="password" name="user_password" class="form-control" id="user_password" required="" placeholder="Enter password">
							</div>
							<div class="form-group">
								<input type="checkbox" value="1" name="remember">
								<label for="exampleInputEmail1">Remember ME</label>
							</div>
							<!-- recaptua -->
							<div class="g-recaptcha" data-sitekey="6Lc5t10fAAAAAE74NpMuYouhHL5j8qKCLYfauhfi"></div>
							<br>
							<input type="submit" name="submit" class="btn btn-primary">
							<?php
                            if (isset($_REQUEST["err"]))
                                $msg = "Invalid username or Password";
                            ?>
							<p style="color:red;">
								<?php if (isset($msg)) {

                                    echo $msg;
                                }
                                ?>
							</p>
						</form>
					</div>
				</div>
			</div>
			<div class="col"></div>
		</div>

	</div>
</body>

</html>
