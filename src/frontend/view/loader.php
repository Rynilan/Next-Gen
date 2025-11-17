<?php

$template = file_get_contents('html/template.html');
$page = $_GET['page_name'];
$content = '';

if ($page === 'error') {
	$content = file_get_contents('html/errors/'.basename($_GET['code_error']).'.html');
} else {
	$content = file_get_contents('html/pages/'.basename($page).'.html');
}
if ($content === false) {
	require_once '../../backend/control/loadEnv.php';
	header('Location: '.$_ENV['ROOT_PATH'].'frontend/view/loader.php?page_name=error&code_error=404');
	exit();
}

$finalPage = str_replace('<!-- Main Content -->', $content, $template);

echo $finalPage;

?>
