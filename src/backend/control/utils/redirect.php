<?php

/** Redireciona o usuário para a dada página.
* @param string $page_name o nome da página o qual este será redirecionado.
* @param string $code_error o possível código de erro lançado, caso haja.
* @param string|null $extra qualquer outro parâmetro necessário.
* @returm void
*/
function redirect($page_name = null, $code_error = null, $extra = null) {
	require_once 'loadEnv.php';
	$response['success'] = true;
	if ($code_error != null) {
		$page_name = 'error';
		$response['error_messsage'] = $extra;
		http_response_code($code_error);
		//echo json_encode($response, JSON_PRETTY_PRINT);
	}
	header('Location: '.$_ENV['ROOT_URL'].'src/frontend/view/loader.php?page_name='.$page_name.'&code_error='.$code_error.'&extra='.$extra);
	exit();
}

?>
