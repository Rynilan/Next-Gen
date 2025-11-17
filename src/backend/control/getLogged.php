<?php

require_once 'loadSession.php';
echo json_encode(['logged' => $_SESSION['LOGGED']]);
?>
