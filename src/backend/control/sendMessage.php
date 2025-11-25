<?php

include 'utils/showErrors.php';
function send_message() {
	include 'utils/getDateNow.php';
	include '../model/appendMessage.php';
	$result = ['success' => true, 'error_message' => ''];

	$message = urldecode($_GET['message']);
	$ticket_id = strtolower(ucwords($_GET['ticket_id']));
	$human = (int) $_GET['human'];
	$time = get_date_now();
	append_message($human, $message, $time, $ticket_id.'/ticket_base.json');
	$result['message'] = [
		$human, $time, $message	
	];
	return $result;
}

echo json_encode(send_message());
?>
