<?php
include 'utils/logged.php';
require_once 'utils/loadEnv.php';

function validate_data($data) {
	return $data != '-';
}

function check_active_tickets($user) {
	return json_decode(
		file_get_contents($_ENV['ROOT_PATH'].'assets/data/tickets/'.$user.'/tickets_info.json'),
		true)['open']['amount'];
}

function new_ticket() {
	require_once 'utils/loadSession.php';
	include 'utils/getDateNow.php';

	$result = ['success' => true, 'message' => 'Chamado aberto'];

	$type = $_POST['type'];
	$client = $_POST['client'];
	if (!(validate_data($type) && validate_data($client))) {
		$result['success'] = false;
		$result['message'] = 'Preencha empresa e tipo adequadamente.';	
	} 
	
	$user = $_SESSION['USER_MAIL'];
	if (check_active_tickets($user) >= 5) {
		$result['success'] = false;
		$result['message'] = 'Você atingiu o número máximo de chamados ativos (5).';
	}
	

	$creation = get_date_now();
	$reason = $_POST['reason'];
	$chat = [];
	$has_file = false;
	if (isset($_FILES['file'])) {
		$has_file = true;
		$file_name = $_FILES['file']['name'];
		$chat[] = [0, $creation, '<file name='.$file_name.'>'];
	}
	$chat[] = [0, $creation, 'Olá gostaria de falar sobre '.$reason];
	
	$status = 'open';
	$progress = 'sent';

	include 'utils/getNextIndexer.php';
	include '../model/createDocument.php';
	if ($result['success']) {
		$id = get_next_indexer('tickets');	
		create_document(
			'tickets/'.$user.'/'.$client.'/'.$id,
			'ticket_base',
			json_encode([
				"id" => $id,
				"user" => $user,
				"client" => $client,
				"type" => $type,
				"reason" => $reason,
				"status" => $status,
				"progress" => $progress,
				"creation" => $creation,
				"chat" => $chat
			], JSON_PRETTY_PRINT)
		);
		update_ticket_info($user, $client, $id, 'create_ticket');
		if ($has_file) {
			move_uploaded_file(
				$_FILES['file']['tmp_name'],
				$_ENV['ROOT_PATH'].'assets/data/tickets/'.$user.'/'.$client.'/'.$id.'/'.basename($_FILES['file']['name'])
			);
		}
	}
	return $result;
}

echo json_encode(new_ticket());
?>
