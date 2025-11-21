<?php
/*
* Entrada: Sem entrada
* Saída: {
*   root_url: uma string contendo a url base do sistema (contida no .env).
* }
*/
require_once 'utils/loadEnv.php';

echo json_encode(['root_url' => $_ENV['ROOT_URL']]);
?>
