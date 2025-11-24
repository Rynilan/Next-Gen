<?php

function get_client_from_id($client) {
	return get_document($_ENV['ROOT_PATH'].'assets/data/clients/'.$client.'.json');
}

function format_ticket(&$ticket) {
		$ticket['client_name'] = ucwords(get_client_from_id($ticket['client'])['name']);
		$ticket['type'] = ($ticket['type'] == 'recomendation')? 'Recomendação': 'Reclamação';
		$ticket['reason'] = urldecode($ticket['reason']);
		for ($i = 0; $i < count($ticket['chat']); $i++) {
			$ticket['chat'][$i][2] = urldecode($ticket['chat'][$i][2]);	
		}
}

?>
