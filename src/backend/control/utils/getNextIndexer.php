<?php

/** Pega os dados de um indexador.
* $types: o indexador ao qual se refere, clients ou tickets.
*/
function get_next_indexer($type) {
	require_once 'loadEnv.php';
	include 'redirect.php';
	// Verifica se a é de um tipo que há indexador.
	if (!in_array($type, ['clients', 'tickets'])) {
		redirect(code_error: 400);
	}
	// Pega os dados do indexador.
	$path = $_ENV['ROOT_PATH'].'assets/data/'.$type.'/'.$type.'_indexer.json';
	$file = file_get_contents($path);
	if ($file === false) {
		redirect(code_error: 404);
	}
	$json = json_decode($file, true);
	// Verifica se a transformação em json aconteceu direito.
	if ($json == null) {
		//redirect(code_error: 500);
	}
	$next = $json['next'];
	// Verifica se o indexador foi estourado.
	if ($next > $json['max']) {
		redirect(code_error: 500);
	}
	// Atualiza o indexador.
	$json['next'] += 1;
	file_put_contents($path, json_encode($json, JSON_PRETTY_PRINT));
	return str_pad($next, strlen((string) $json['max']), "0", STR_PAD_LEFT);
}

?>
