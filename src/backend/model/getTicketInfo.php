<?php

function get_tickets_info($user) {
	require_once 'utils/loadEnv.php';
	$ticketResume = json_decode(
		file_get_contents($_ENV['ROOT_PATH'].'assets/data/tickets/'.$user.'/tickets_info.json'),
		true
	); 
	return $ticketResume;
}

?>
