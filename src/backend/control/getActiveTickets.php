<?php
include 'utils/logged.php';
include 'utils/loadEnv.php';
include 'utils/loadSession.php';
include 'utils/formatTicket.php';
include '../model/getDocuments.php';
include '../model/getTicketInfo.php';
include 'utils/showErrors.php';
function tickets_info() {
	return get_tickets_info($_SESSION['USER_MAIL']);
}

function get_ticket_docs($ticket) {
	return get_document($_ENV['ROOT_PATH'].'assets/data/tickets/'.$_SESSION['USER_MAIL'].'/'.$ticket.'.json');
}

function get_active_tickets() {
	$info = tickets_info();
	$tickets = [];
	foreach($info['open']['tickets'] as $ticket) {
		$ticket_doc= get_ticket_docs($ticket.'/ticket_base');
		format_ticket($ticket_doc);
		$tickets[] = $ticket_doc;
	}
	return $tickets;
}

$data = get_active_tickets();
echo json_encode($data);

?>
