<?php

function redirect($page_name = null, $code_error = null) {
	require_once 'loadEnv.php';
	if ($code_error != null) {
		$page_name = 'error';
		http_response_code($code_error);
	}
	header('Location: '.$_ENV['ROOT_URL'].'src/frontend/view/loader.php?page_name='.$page_name.'&code_error='.$code_error);
	exit();
}

?>
