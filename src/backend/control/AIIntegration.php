<?php

include 'utils/showErrors.php';
include 'utils/logged.php';
include 'utils/getAcess.php';
include 'utils/loadEnv.php';
require_once '../model/ticketsHandler.php';
require_once '../model/agentsHandler.php';
require_once '../model/usersHandler.php';

function call_ai($ticket_id) {
	$ticket = get_ticket($ticket_id);
	$agent = get_agent($ticket['agent_cnpj'])['real_name'];
	$user = get_user($ticket['user_mail'])['name'];
	$apiKey = $_ENV['AI_KEY'];
	$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent";
	$data = [
		"contents" => [
			[
				"parts" => [
					["text" => "
						Tendo o seguinte chamado: ".json_encode($ticket)." 
						da empresa ".$agent." e usuário ".$user." continue a conversa com uma resposta 
						adequada, e se limite SOMENTE a responder a mensagem como IA de suporte
						e se limite a 200 caracteres no máximo, mas tente usar o mínimo. 
						"
					]
				]
			]
		]
	];

	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		"x-goog-api-key: $apiKey",
		"Content-Type: application/json"
	]);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

	$response = curl_exec($ch);

	$result = ["success" => false];
	if (!curl_errno($ch)) {
		$ai_response = json_decode($response, true);
		$result['success'] = true;
	}

	// Enviar a resposta.	
	$message = isset($ai_response['candidates'][0]['content']['parts'][0]['text'])?
	$ai_response['candidates'][0]['content']['parts'][0]['text']:
	"Algum erro aconteceu";
	$result['success'] = $result['success'] && insert_chat_message($ticket_id, 'ai', $message) > 0;
	if (!$result['success']) {
		$new_message['error'] = error_get_last();
	} else {
		$result['message'] = array_slice(chat_fetch($ticket_id), -1)[0];
		$result['logged'] = get_acess();
		$result['logged'] = ($result['logged'] == 'agent')? 'support': $result['logged'];
	}

	return $result;
}

echo json_encode(call_ai($_GET['ticket_id']));
