<?php

include 'getDocuments.php';
include 'updateDocuments.php';
require_once '../control/utils/loadEnv.php';
function append_message($ai, $message, $date, $ticket) {
	$document = get_document($_ENV['ROOT_PATH'].'assets/data/tickets/'.$ticket);
	$document['chat'][] = [$ai, $date, $message];
	update_document($_ENV['ROOT_PATH'].'assets/data/tickets/'.$ticket, json_encode($document, JSON_PRETTY_PRINT));
}

?>
