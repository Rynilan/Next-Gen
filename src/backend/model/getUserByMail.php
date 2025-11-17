<?php
function get_user_by_mail($mail) {
	require_once '../control/loadEnv.php';
	$path = __DIR__.'/../../../assets/data/users/'.$mail.'.json';
	return json_decode(file_get_contents($path), true);;
}

?>
