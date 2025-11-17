<?php
require_once 'loadSession.php';
echo json_encode([
	'logged' => $_SESSION['LOGGED'],
	'mail' => $_SESSION['USER_MAIL'],
	'name' => $_SESSION['USER_NAME']
]);
?>
