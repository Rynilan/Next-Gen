<?php
function get_user_by_mail($mail) {
	require_once '../control/utils/loadEnv.php';
	$path = $_ENV['ROOT_PATH'].'assets/data/users/'.$mail.'.json';
	return json_decode(file_get_contents($path), true);;
}

?>
