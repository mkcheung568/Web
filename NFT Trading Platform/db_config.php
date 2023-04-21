<?php
    $servername='localhost';
    $username='root';
    $password='';
    $dbname = "comp3334_group2";
    $conn=mysqli_connect($servername,$username,$password,"$dbname");
      if(!$conn){
          die('Could not Connect MySql Server:' .mysql_error());
        }
?>