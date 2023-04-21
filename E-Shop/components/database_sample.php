<?php
/**
 * Note: 
 * DO NOT USE THIS FILE AS A TEMPLATE FOR YOUR OWN PROJECT.
 * Please duplicate this file and rename it to database.php, then
 * update the database name, username, and password.
 */
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'comp3421_final_project';
$pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
?>