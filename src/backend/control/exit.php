<?php
require_once 'utils/loadSession.php';

$_SESSION['USER_CREDENTIAL'] = null;
$_SESSION['USER_NAME'] = null;
$_SESSION['LOGGED'] = false;

echo json_encode(['success' => true]);
?>
