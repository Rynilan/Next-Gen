<?php

include 'utils/logged.php';
require_once 'utils/loadEnv.php';
require_once 'utils/loadSession.php';
require_once 'utils/getAcess.php';
include '../model/ticketsHandler.php';

function get_open_tickets_amount($mail) {
	return count(get_open_ticket_user($mail));
}

function set_error(&$array, $error) {
	$array['success'] = false;
	$array['message'] = $error;
}

/** Create a new ticket after querying all the data needed */
function new_ticket() {
	$result = ['success' => true, 'message' => 'Chamado aberto'];

	$type = $_POST['type'];
	$agent = $_POST['agent'];
	if (!(in_array($type, ['complaint', 'request', 'recommendation']) && validate_cnpj($agent))) {
		set_error($result, 'Preencha empresa e tipo adequadamente.');	
	} 

	
	$user = $_SESSION['USER_CREDENTIAL'];
	if (get_open_tickets_amount($user) >= 5) {
		set_error($result, 'Você atingiu o número máximo de chamados ativos (5).');
	}
	
	if (get_acess() != 'user') {
		set_error($result, 'Contas de usuários comum que podem abrir chamados.');
	}

	$has_file = false;
	$file_name = '';
	if (isset($_FILES['file'])) {
		$has_file = true;
		$file_name = $_FILES['file']['name'];
		if (str_contains($file_name, '>')) {
			set_error($result, 'Nome do arquivo inválido.');	
		}
	}
	
	if ($result['success']) {
		$reason = urldecode($_POST['reason']);
	
		$ticket_id = insert_ticket($user, $agent, $reason, $type);
		if ($has_file) {
			insert_chat_message($ticket_id, 'user', '<file name='.$file_name.'>');
		}
		mkdir($_ENV['ROOT_PATH'].'assets/data/ticket_files/'.$ticket_id, 0775);

		if ($has_file) {
			move_uploaded_file(
				$_FILES['file']['tmp_name'],
				$_ENV['ROOT_PATH'].'assets/data/ticket_files/'.$ticket_id.'/'.basename($_FILES['file']['name'])
			);
		}
		$result['ticket_id'] = $ticket_id;
	}

	return $result;
}

echo json_encode(new_ticket());
?>
