<?php

$template = file_get_contents('html/template.html');
$page = $_GET['page_name'];
$content = '';

// Checa se a página requere login.
require_once '../../backend/control/loadSession.php';
$logged_pages = json_decode(file_get_contents('../../../assets/data/app/needLogged.json'), true)['true'];
if (in_array($page, $logged_pages) && !$_SESSION['LOGGED']) {
	require_once '../../backend/control/loadEnv.php';
	http_response_code(401);
	header('Location: '.$_ENV['ROOT_PATH'].'frontend/view/loader.php?page_name=error&code_error=401');
	exit();
}

// Pega o conteúdo html.
if ($page === 'error') {
	$content = file_get_contents('html/errors/'.basename($_GET['code_error']).'.html');
} else {
	$content = file_get_contents('html/pages/'.basename($page).'.html');
}

// Verifica se a página existe.
if ($content === false) {
	require_once '../../backend/control/loadEnv.php';
	http_response_code(404);
	header('Location: '.$_ENV['ROOT_PATH'].'frontend/view/loader.php?page_name=error&code_error=404');
	exit();
}

// Carrega a página.
$finalPage = str_replace('<!-- Main Content -->', $content, $template);
echo $finalPage;

?>
