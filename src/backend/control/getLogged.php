<?php
/*
* Entrada: Sem entrada
* Saída: 
* {
*   logged: valor lógico indicando se o usuário está logado.
*   mail: string com o email do usuário logado, null em caso de não ter.
*   name: string com o nome do usuário logado, null em caso de não ter.
* }
*/
require_once 'loadSession.php';
echo json_encode([
	'logged' => $_SESSION['LOGGED'],
	'mail' => $_SESSION['USER_MAIL'],
	'name' => $_SESSION['USER_NAME']
]);
