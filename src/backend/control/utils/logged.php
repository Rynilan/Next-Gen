<?php

/** Se o usuário não estiver logado redireciona-o para o erro 401 (unauthorized). */

require_once 'loadSession.php';
if (!$_SESSION['LOGGED']) {
	include 'redirect.php';
	redirect(code_error: 401);
}

?>
