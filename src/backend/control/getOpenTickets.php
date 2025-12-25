<?php
include 'utils/showErrors.php';
include 'utils/logged.php';
include 'utils/getAcess.php';
include 'utils/loadSession.php';

require_once '../model/ticketsHandler.php';
require_once '../model/usersHandler.php';
require_once '../model/agentsHandler.php';

function open_tickets() {
	$credential = $_SESSION['USER_CREDENTIAL'];

	$data = [];
	$name = function() {};
	if (get_acess($credential) === 'user') {
		$data = get_open_ticket_user($credential);
		$name = function($data) {return get_agent($data['agent_cnpj'])['real_name'];};
	} else {
		$data = get_open_ticket_agent($credential);
		$name = function($data) {return get_user($data['user_mail'])['name'];};
	}

	for ($i = 0; $i < sizeof($data); $i++) {
		$data[$i]['counterpart_name'] = $name($data[$i]);	
	}

	return $data;
}

echo json_encode(open_tickets())

?>
