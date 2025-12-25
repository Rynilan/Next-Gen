<?php

require_once 'utils/loadSession.php';
echo json_encode([
	'logged' => $_SESSION['LOGGED'],
	'credential' => $_SESSION['USER_CREDENTIAL'],
	'name' => $_SESSION['USER_NAME']
]);

?>
