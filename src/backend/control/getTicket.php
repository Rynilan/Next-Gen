<?php

include 'utils/logged.php';
include 'utils/loadEnv.php';
include 'utils/formatTicket.php';
include '../model/getDocuments.php';

function get_ticket() {
	$ticket = $_GET['ticket'];
	$ticket = get_document($_ENV['ROOT_PATH'].'assets/data/tickets/'.urldecode($ticket).'/ticket_base.json');
	format_ticket($ticket);
	return $ticket;
}

$data = get_ticket();
echo json_encode($data);
?>
