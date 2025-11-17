<?php

$template = file_get_contents('html/template.html');
$page = $_GET['page_name'];
$content = '';

if ($page === 'error') {
	$content = file_get_contents('html/errors/'.$_GET['code_error'].'.html');
} else {
	$content = file_get_contents('html/pages/'.$page.'.html');
}

$finalPage = str_replace('<!-- Main Content -->', $content, $template);

echo $finalPage;

?>
