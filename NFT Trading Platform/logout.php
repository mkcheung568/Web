<?php 
setcookie("login","",time() - 60 * 60);//for delete the cookie //destroy the cookie  
setcookie("email","",time() - 60 * 60); 
header("location:index.php");
?>