<?php
/*
* Entrada: Sem entrada.
* Saída: Sem saída.
* Apenas torna acessível os dados do .env aos arquivos .php.
*/
require __DIR__ . '/../../../vendor/autoload.php';

$env = Dotenv\Dotenv::createImmutable(__DIR__.'/../../../');
$env->load();
?>
