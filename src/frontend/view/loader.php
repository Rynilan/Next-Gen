<?php

include '../../backend/control/utils/redirect.php';
$template = file_get_contents('html/template.html');
$page = $_GET['page_name'];
$content = '';

// Checa se a página requere login.
require_once '../../backend/control/utils/loadSession.php';
$logged_pages = json_decode(file_get_contents('../../../assets/data/app/needLogged.json'), true)['true'];
if (in_array($page, $logged_pages) && !$_SESSION['LOGGED']) {
	redirect(code_error: '401');
}

// Pega o conteúdo html.
if ($page === 'error') {
	$content = file_get_contents('html/errors/'.basename($_GET['code_error']).'.html');
} else {
	$content = file_get_contents('html/pages/'.basename($page).'.html');
}

// Verifica se a página existe.
if ($content === false) {
	redirect(code_error: '404');
}

// Carrega a página.
$finalPage = str_replace('<!-- Main Content -->', $content, $template);
echo $finalPage;

?>
