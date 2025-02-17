<?php
	$host = 'localhost';
	$port = 3306;
	$database = 'reck_club';
	$username = 'reck';
	$password = 'burdell';

	$dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";

	try {
		$db = new PDO($dsn, $username, $password, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
		]);
	} catch (PDOException $e) {
		die("Database connection failed: " . $e->getMessage());
	}
?>
