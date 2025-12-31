<?php

include 'utils/logged.php';
include 'utils/getAcess.php';
require_once '../model/ticketsHandler.php';
require_once '../model/agentsHandler.php';
require_once '../model/usersHandler.php';

/** Get all the tickets of the current logged user. */
function all_tickets() {
	$credential = $_SESSION['USER_CREDENTIAL'];

	$data = [];
	$name = function() {};
	if (get_acess($credential) === 'user') {
		$data = get_ticket_user($credential);
		$name = function($data) {return get_agent($data['agent_cnpj'])['real_name'];};
	} else {
		$data = get_ticket_agent($credential);
		$name = function($data) {return get_user($data['user_mail'])['name'];};
	}

	for ($i = 0; $i < sizeof($data); $i++) {
		$data[$i]['counterpart_name'] = $name($data[$i]);	
	}

	return $data;
}

echo json_encode(all_tickets());

?>
