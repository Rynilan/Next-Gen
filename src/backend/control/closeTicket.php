<?php

include 'utils/logged.php';
include '../model/ticketsHandler.php';

/** Register the closure of a ticket
* @param string $ticket_id the id of the ticket to be closed;
* @param string $finish the final situation of the ticket
* @return array if there's success and if there's some error
*/
function close($ticket_id, $finish) {
	$result = ['success' => close_ticket((int) $ticket_id, $finish)];
	if (!$result['success']) {
		$result['error'] = error_get_last();
	}
	return $result;
}

echo json_encode(close($_GET['ticket_id'], $_GET['finish']));
