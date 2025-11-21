<?php
/* Arquivo contendo apenas funções auxiliares para arquivos
 * que precisam pegar os dados dos documentos (arquivos .json).
 */

/**
* Função para filtrar uma lista de arrays associativos para 
* conter apenas os campos desejados.
* $array: o array em si.
* $fields: um array com o nome dos campos desejados.
*/
function filter_fields($array, $fields) {
	$data = [];
	foreach ($array as $element) {
		$line = [];
		foreach ($fields as $field) {
			$line[$field] = $element[$field];
		}
		$data[] = $line;
	}
	return $data;
}

/** 
* Função para pegar todos os documentos (arquivos .json) de 
* uma pasta.
* $type: a pasta, referente ao tipo, users ou clients.
*/
function files_to_documents($files) {
	$documents = [];
	foreach ($files as $file) {
		$documents[] = json_decode(file_get_contents($file), true);
	}
	return $documents;
}

?>
