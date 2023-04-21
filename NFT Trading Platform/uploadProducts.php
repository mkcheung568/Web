<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>upload product</title>
	<!-- CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
	<div class="container">

		<div class="row">
			<div class="col"></div>
			<div class="col-6">
				<div class="card">
					<div class="card-header text-center">
						Upload NFT product
					</div>
					<div class="card-body">
						<form action="addProducts.php" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<label>NFT Product Name</label>
								<input type="text" name="productName" class="form-control" id="productName" required="">
							</div>
							<div class="form-group">
								<label>NFT Product Price</label>
								<input type="text" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" name="productPrice" class="form-control" id="productPrice" required="">
							</div>
							<div class="form-group">
								<label>NFT Product Photo</label>
								<input type="file" name="image" value="" multiple="" class="form-control-file" id="exampleFormControlFile1">
							</div>
							<br>
							<input type="submit" name="submit" value="Upload" class="btn btn-primary">
						</form>
					</div>
				</div>
			</div>
			<div class="col"></div>
		</div>

	</div>
</body>

</html>
