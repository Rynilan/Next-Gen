<?php
include '../model/usersHandler.php';
include '../model/agentsHandler.php';
require_once 'utils/loadEnv.php';
require_once 'utils/validate.php';

/** Validate, compare and assert login when tried */

function set_error(&$array, $error_message) {
	$array['success'] = false;
	$array['error_message'] = $error_message;
	$array['redirect'] = null;
}

function format_cnpj($cnpj) {
	$numbersOnly = preg_replace('/\D/', '', $cnpj);
   	return $numbersOnly; 
}

function login($login, $password) {
	$result = [
		'success' => true,
		'error_message' => '',
		'redirect' => 'main'
	];

	$stored = [];
	$login = strtolower($login);
	if (validate_mail($login)) {
		$stored = get_user($login);
	} else {
		$login = format_cnpj($login);
		if (validate_cnpj($login)) {
			$stored = get_agent($login);
		}
	}
   	if (empty($stored)) {
		set_error($result, 'Credenciais inválidas.');
	}

	if (empty($stored)) {
		set_error($result, 'Usuário inexistente');
	}
	if ($result['success'] && !password_verify($password, $stored['pass'])) {
		set_error($result, 'Credenciais não correspondem.');
	}

	if ($result['success']) {
		include 'utils/loadSession.php';
		$_SESSION['USER_CREDENTIAL'] = $login;
		$_SESSION['USER_NAME'] = (isset($stored['name']))? $stored['name']: $stored['real_name'];
		$_SESSION['LOGGED'] = true;
	}

	return $result;
}

$data = [];
if ($_GET['according'] == 'true') {
	$mail = $_GET['login'];
	$password = $_GET['password'];
	$data = login($mail, $password);
} else {
	$data = ['success' => false, 'error_message' => ''];
}
echo json_encode($data, JSON_PRETTY_PRINT);
?>
