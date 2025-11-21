<?php

require_once 'loadSession.php';
if (!$_SESSION['LOGGED']) {
	include 'redirect.php';
	redirect(code_error: 401);
}

?>
