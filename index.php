<?php
include 'src/backend/control/utils/redirect.php';
require_once 'src/backend/control/utils/loadSession.php';

$_SESSION['USER_MAIL'] = null;
$_SESSION['USER_NAME'] = null;
$_SESSION['LOGGED'] = false;

redirect('login');
?>
