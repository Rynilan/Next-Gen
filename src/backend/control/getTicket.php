<?php

include 'utils/logged.php';
include 'utils/getAcess.php';
require_once '../model/ticketsHandler.php';
require_once '../model/usersHandler.php';
require_once '../model/agentsHandler.php';

/** Return the ticket info of a specific ticket
* @param string $ticket_id the id of the ticket to get the info.
* @return array the ticket info
*/
function ticket($ticket_id) {
	$ticket = get_ticket($ticket_id);
	$ticket['chat'] = chat_fetch($ticket_id);
	$ticket['logged'] = get_acess();
	$ticket['logged'] = ($ticket['logged'] == 'agent')? 'support': $ticket['logged'];
	if ($ticket['logged'] === 'user') {
		$name = get_agent($ticket['agent_cnpj'])['real_name'];
	} else {
		$name = get_user($ticket['user_mail'])['name'];
	}
	$ticket['counterpart_name'] = $name;
	return $ticket;
}

echo json_encode(ticket($_GET['ticket']));

?>
