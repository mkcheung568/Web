<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>NFT Exchange Platform</title>
	<link rel="stylesheet" href="css/menu.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/productList.css">
	<link rel="stylesheet" href="css/button.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<link rel="stylesheet" href="css/Customer/shoppingCartList.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="e2e68e2b28a3e84bcc07583e-text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>

	<!-- the title-->
	<div id="title">
		<h1>NFT Exchange Platform</h1>
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
				include "db_config.php";
				if (!isset($_COOKIE['email']))
					echo "<a href=\"register.php\" class=\"sbtn\">Register</a>";

				if (!isset($_COOKIE['email']))
					echo "<a href=\"login.php\" class=\"sbtn\">Login</a>";

				if (isset($_COOKIE['email']))
					echo "<a href=\"logout.php\" class=\"sbtn\">Logout</a>";
				if (isset($_COOKIE['email'])) {
					$email = $_COOKIE['email'];

					$sql2 = "SELECT * FROM `user` WHERE `user_email` = '$email' ";
					
					$resultsql2 = mysqli_query($conn, $sql2);
					while ($rc = mysqli_fetch_assoc($resultsql2)) {
						
						extract($rc);
						echo "<a class='sbtn'>Poly coin: $polycoin</a>";
					}
					mysqli_free_result($resultsql2);
				mysqli_close($conn);
				}
				
				?>
			</div>
		</li>
	</div>

	<table id="productList">
		<thead>
			<tr>
				<th>Name</th>
				<th>Price</th>
				<th>More Details</th>
			</tr>
		</thead>

		<tbody id="selectLocationTable">


			<?php
			include "db_config.php";
			$sql = "SELECT `product_id`, `product_name`, `product_price` FROM `produce`";
			$rs_goods = mysqli_query($conn, $sql);

			while ($rc = mysqli_fetch_assoc($rs_goods)) {
				extract($rc);

				echo "
						<tr>
							<td id='productName'> $product_name</td >
							<td id='productPrice'> $product_price</td >
							<td>
								<form method='post' action='productInfo.php'>
								<input type='hidden' value='$product_id' name='id'>
								<input class='submit' type='submit' value='More Details' name='send'>
								</form>
							</td>
						</tr>
					";
			}

			mysqli_free_result($rs_goods);
			mysqli_close($conn);
			?>

		</tbody>
	</table>

</body>

</html>