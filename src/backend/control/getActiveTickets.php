<?php
include 'utils/showErrors.php';
include 'utils/logged.php';
include '../model/getDocuments.php';
include 'utils/loadEnv.php';
include 'utils/loadSession.php';
include '../model/getTicketInfo.php';

function tickets_info() {
	return get_tickets_info($_SESSION['USER_MAIL']);
}

function get_ticket_docs($ticket) {
	return get_document($_ENV['ROOT_PATH'].'assets/data/tickets/'.$_SESSION['USER_MAIL'].'/'.$ticket.'.json');
}

function get_client_from_id($client) {
	return get_document($_ENV['ROOT_PATH'].'assets/data/clients/'.$client.'.json');
}

function get_active_tickets() {
	$info = tickets_info();
	$tickets = [];
	foreach($info['open']['tickets'] as $ticket) {
		$ticket_doc= get_ticket_docs($ticket.'/ticket_base');
		$ticket_doc['client_name'] = ucwords(get_client_from_id($ticket_doc['client'])['name']);
		$ticket_doc['type'] = ($ticket_doc['type'] == 'recomendation')? 'Recomendação': 'Reclamação';
		$ticket_doc['reason'] = urldecode($ticket_doc['reason']);
		for ($i = 0; $i < count($ticket_doc['chat']); $i++) {
			$ticket_doc['chat'][$i][2] = urldecode($ticket_doc['chat'][$i][2]);	
		}
		$tickets[] = $ticket_doc;
	}
	return $tickets;
}

$data = get_active_tickets();
echo json_encode($data);

?>
