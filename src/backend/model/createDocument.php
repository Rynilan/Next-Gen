<?php

require_once '../control/utils/loadEnv.php';
function create_document($local, $name, $json_content) {
	require_once '../control/utils/redirect.php';
	$local = $_ENV['ROOT_PATH'].'assets/data/'.$local;
	if (!is_dir($local)) {
		if (!create_local($local)) {
			redirect(code_error: 500, extra: 'Não foi possível criar o local');
		}
	}
	$file = $local.'/'.$name.'.json';
	$result = file_put_contents($file, $json_content);
	if ($result === false) {
		redirect(code_error: 500);
	}
}

function create_local($local) {
	return mkdir($local, 0775, true);
}

function update_ticket_info($user, $client, $id, $action) {
	$ticket = $client.'/'.$id;
	$file = $_ENV['ROOT_PATH'].'assets/data/tickets/'.$user.'/tickets_info.json';
	$json = json_decode(file_get_contents($file), true);
	switch ($action) {
		case 'create_ticket':
			$json['open']['amount'] += 1;
			$json['open']['tickets'][] = $ticket;
			$json['total'] += 1;
			break;
		case 'finish_ticket':
			$json['open']['amount'] -= 1;
			unset($json['open']['tickets'][array_search($ticket, $json)]);
	}
	$json = json_encode($json, JSON_PRETTY_PRINT); 	
	file_put_contents($file, $json);
}
?>
