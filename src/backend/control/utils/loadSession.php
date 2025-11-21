<?php
/*
* Entrada: Sem entrada.
* Saída: Sem saída.
* Apenas torna acessível os dados da sessão aos arquivos .php.
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
