<?php
/*
* Entrada: 
* 	mail: o email do usuário que está tentando logar.
* 	password: a senha do usuário que está tentando logar.
* 	according: valor lógico (0 ou 1) se o usuário concorda com a política de privacidade.
* Saída: {
* 	sucess: valor lógico indicando se a operação foi um sucesso.
* 	redirect: string com link de destino em caso de sucesso, vazio caso contrário.
* 	error_message: string com saída de erro do código, vazio em caso de sucesso.
* 	name: string contendo nome do usuário logado, em caso de sucesso, vazio caso contrário.
* }
*/
require_once 'utils/loadEnv.php';
$mail = $_GET['mail'];
$pass = $_GET['password'];
$okay = $_GET['according'];

function valid_data($mail, $pass, $okay) {
	$code = 0;
	if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $mail)) {
		$code = 1;
	} else if ($okay == 'false') {
		$code = 2;
	} else if (!preg_match('/^[A-Za-z0-9]{8,}$/', $pass)) {
		$code = 3;
	}
	return $code;
}

function format_data(&$mail) {
	$mail = strtolower(str_replace(['.', '@'], ['-dot-', '-at-'], $mail));
}

function compare_data($pass, $stored_pass) {
	return (
		password_verify($pass, $stored_pass)
	);
}

function set_session_and_get_redirect($mail, $name) {
	require_once 'utils/loadSession.php';

	$_SESSION['USER_MAIL'] = $mail;
	$_SESSION['USER_NAME'] = $name;
	$_SESSION['LOGGED'] = true;
	return $_ENV['ROOT_URL'].'src/frontend/view/loader.php?page_name=main&code_error=';
}

function login($mail, $pass, $okay) {
	$data = ["success" => true, "error_message" => '', "name" => '', 'mail' => ''];
	switch (valid_data($mail, $pass, $okay)) {
		case 0:
			break;
		case 1:
			$data['success'] = false;
			$data['error_message'] = 'Email inválido';
			break;
		case 2:
			$data['success'] = false;
			$data['error_message'] = 'Concorde com os termos de privacidade';
			break;
		case 3:
			$data['success'] = false;
			$data['error_message'] = 'Credenciais inválidas';
			break;
	}
	$stored_data = [];
	if ($data['success']) {
		format_data($mail);
		include '../model/getUserByMail.php';
		$stored_data = get_user_by_mail($mail);
		$data['success'] = $stored_data != null;
		if (!$data['success']) {
			$data['error_message'] = 'Usuário inexistente';
		}
	}
	if ($data['success']) {
		if (!compare_data($pass, $stored_data['password'])) {
			$data['success'] = false;
			$data['error_message'] = 'Credenciais incorretas';
		} else {
			$data['name'] = $stored_data['name'];
			$data['mail'] = $stored_data['mail'];	
		}
	}
	return $data;
}

$result = login($mail, $pass, $okay);
if ($result['success']) {
	$result['redirect'] = set_session_and_get_redirect($result['mail'], $result['name']);
}
echo json_encode($result);

?>
