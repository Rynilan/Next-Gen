<?php
require_once __DIR__.'/../../control/utils/loadEnv.php';

function connect() {
	$hostname = $_ENV['HOSTNAME'];
	$username = $_ENV['USERNAME'];
	$password = $_ENV['PASSWORD'];
	$database = $_ENV['DATABASE'];

	$conn = new mysqli($hostname, $username, $password, $database);
	if ($conn->connect_error) {
		echo "Connection failed: " . $conn->connect_error;
		return null;
	}

	return $conn;
}
?>
