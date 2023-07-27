<?php
	$host = 'localhost';
	$port = 3306;
	$database = 'reck_club';
	$username = 'reck';
	$password = 'burdell';
	#$username = 'root';
	#$password = 'root';
	
	$dsn = "mysql:host=$host;port=$port;dbname=$database";
	
	$db = new PDO($dsn, $username, $password);
	
?>
