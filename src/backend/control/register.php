<?php

require_once 'utils/getAcess.php';
require_once '../model/usersHandler.php';
require_once '../model/agentsHandler.php';

function set_error(&$array, $message) {
	$array['success'] = false;
	$array['error'] = $message;
}

function format_cnpj($cnpj) {
	$numbersOnly = preg_replace('/\D/', '', $cnpj);
   	return $numbersOnly; 
}

/** Register a user after all the data was validated, compared and formatted */
function register($credential, $pass, $name, $real_name, $according) {

	$result = ['success' => true];
	if ($according != 'true') {
		set_error($result, 'Concorde com nossas políticas de privacidade.');
	}

	if ($result['success']) {
		$pass = password_hash($pass, PASSWORD_DEFAULT);
		if (get_acess($credential) == 'user') {
			$name = strtoupper($name);
			$credential = strtolower($credential);
			$result['success'] = $result['success'] && insert_user($credential, $pass, $name) > 0;
		} else {
			$credential = format_cnpj($credential);
			$ch = curl_init("https://open.cnpja.com/office/".$credential);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($httpCode === 200) {
				$data = json_decode($response, true);
				$name = $data['alias'];
				$real_name = $data['company']['name'];
			} else {
				set_error($result, 'Erro ao pegar os dados do CNPJ, verifique o valor digitado.');
			}

			if ($result['success']) {
				$result['success'] = $result['success'] &&insert_agent($credential, $pass, $name, $real_name) > 0;	
			}
		}

		if (!$result['success']) {
			$result['error'] = error_get_last();
		}
	}

	return $result;
}

echo json_encode(register(
	$_GET['credential'], $_GET['pass'], $_GET['name'], $_GET['real_name'], $_GET['according']	
));
?>
