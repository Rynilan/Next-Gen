<?php

include 'utils/logged.php';
require_once 'utils/loadSession.php';
require_once '../model/ticketsHandler.php';
require_once 'utils/getAcess.php';

/** Get a resume of all the tickets of the current logged user */
function get_tickets_resume() {
	$tickets = [];
	
	if (get_acess() == 'agent') {
		$tickets = get_ticket_agent($_SESSION['USER_CREDENTIAL']);
	} else {
		$tickets = get_ticket_user($_SESSION['USER_CREDENTIAL']);
	} 

	$resume = [
		'openAmount' => 0,		
		'closedAmount' => -0,		
		'totalAmount' => +0		
	];
	foreach ($tickets as $index => $ticket) {
		if ($ticket['status'] == 'open') {
			$resume['openAmount']++;
		} else {
			$resume['closedAmount']++;
		}
		$resume['totalAmount']++;
	}
	
	return $resume;
}

echo json_encode(get_tickets_resume());

?>
