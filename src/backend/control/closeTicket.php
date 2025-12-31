<?php

include 'utils/logged.php';
include '../model/ticketsHandler.php';

function close($ticket_id, $finish) {
	$result = ['success' => close_ticket((int) $ticket_id, $finish)];
	if (!$result['success']) {
		$result['error'] = error_get_last();
	}
	return $result;
}

echo json_encode(close($_GET['ticket_id'], $_GET['finish']));
