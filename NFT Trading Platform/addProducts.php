<?php 
extract($_POST);
include "db_config.php";

if (isset($_POST['submit'])) {
	
//	$productName = 
//	$productPrice = 
	
  	// Get image name
  	$image = $_FILES['image']['name'];

  	// image file directory
  	$target = "image/".basename($image);

  	$sql = "INSERT INTO `produce`(`product_id`, `product_name`, `product_price`, `product_owner`, `product_key`, `product_dir`) VALUES ('', '$productName', '$productPrice', '', '', '$image')";
	

  	// execute query
  	$rs = mysqli_query($conn, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  mysqli_close($conn);



include "db_config.php";
$sql = "SELECT * FROM `produce` order by product_id desc limit 1";
mysqli_query($conn, $sql);
$rs = mysqli_query($conn, $sql);
while($rc = mysqli_fetch_assoc($rs)){
	extract($rc);
	$id = $product_id;
}
mysqli_close($conn);


include "db_config.php";
$sql = "SELECT `user_name` FROM `user` WHERE `user_email` = '{$_COOKIE['email']}'";
$rs = mysqli_query($conn, $sql);
while($rc = mysqli_fetch_assoc($rs)){
	extract($rc);
	$username = $user_name;
}
mysqli_close($conn);


$str = rand();
$key = md5($str);
$data = "$username#$id";

//ENCRYPT FUNCTION
function encrypt($data, $key) {
$encryption_key = base64_decode($key);
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
return base64_encode($encrypted . '::' . $iv);
}

$encrypteddata = encrypt($data, $key);


include "db_config.php";
$sql = "UPDATE `produce` SET `product_owner` = '$encrypteddata', `product_key` = '$key' WHERE `produce`.`product_id` = '$id';";
mysqli_query($conn, $sql);
mysqli_close($conn);



echo '<script type="text/javascript">';
echo "alert('The product has been added successfully.')";
echo '</script>';
header("Refresh:0.1;url=index.php");

?>
