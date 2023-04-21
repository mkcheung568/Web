<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Register</title>
	<!-- CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script>
		function validate() {

			if (!document.getElementById("user_password").value == document.getElementById("cpassword").value)
				alert("Passwords do no match");
			return document.getElementById("user_password").value == document.getElementById("cpassword").value;
			return false;
		}

	</script>
</head>

<body>
	<div class="container">

		<div class="row">
			<div class="col"></div>
			<div class="col-6">
				<div class="card">
					<div class="card-header text-center">
						Register Account
					</div>
					<div class="card-body">
						<form action="validate-captcha.php" method="post">
							<div class="form-group">
								<label for="exampleInputEmail1">Name</label>
								<input type="text" name="user_name" class="form-control" id="user_name" required="" placeholder="Enter Username">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Email address</label>
								<input type="email" name="user_email" class="form-control" id="user_email" aria-describedby="emailHelp" required="" placeholder="Email">
								<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Password</label>
								<input type="password" name="user_password" class="form-control" id="user_password" required="" placeholder="Enter password">
							</div>
							<div class="form-group">
								<label for="exampleInputEmail1">Confirm Password</label>
								<input type="password" name="cpassword" class="form-control" id="cpassword" required="" placeholder="Enter again">
							</div>
							<div class="g-recaptcha" data-sitekey="6Lc5t10fAAAAAE74NpMuYouhHL5j8qKCLYfauhfi"></div>
							<br>
							<input type="submit" name="submit" class="btn btn-primary" onclick="validate()">
						</form>
					</div>
				</div>
			</div>
			<div class="col"></div>
		</div>

	</div>
</body>

</html>
