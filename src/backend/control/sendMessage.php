<?php
include 'utils/logged.php';
include 'utils/getAcess.php';
include '../model/ticketsHandler.php';

function message($message, $ticket_id) {
	if (str_starts_with($message, '<file name=')) return ['success' => false, 'error' => 'Mensagem inválida.'];

	$author = get_acess();
	$author = ($author == 'user')? $author: 'support';
	$result = ['success' => insert_chat_message($ticket_id, $author, $message) > 0];
	if (!$result['success']) {
		$result['error'] = error_get_last();
	} else {
		$result['message'] = array_slice(chat_fetch($ticket_id), -1)[0];
		$result['logged'] = get_acess();
		$result['logged'] = ($result['logged'] == 'agent')? 'support': $result['logged'];
	}
	return $result;
}

echo json_encode(message($_GET['message'], $_GET['ticket_id']));

?>
