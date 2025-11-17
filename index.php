<?php
require_once 'src/backend/control/loadEnv.php';
require_once 'src/backend/control/loadSession.php';

$_SESSION['USER_MAIL'] = null;
$_SESSION['USER_NAME'] = null;
$_SESSION['LOGGED'] = false;

header('Location: '.$_ENV['ROOT_PATH'].'frontend/view/loader.php?page_name=login&code_error='); 
?>
