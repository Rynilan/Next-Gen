<?php
require_once 'loadEnv.php';

echo json_encode(['root_url' => $_ENV['ROOT_URL']]);
?>
