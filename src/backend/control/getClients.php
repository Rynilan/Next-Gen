<?php
/*
* Entrada: sem parâmetros de entrada.
* Saída:
* 	clients: array contendo todos os objetos de clientes
* 	- cliente: um objeto com nome e id
*/

include '../model/getFiles.php';
include 'utils/formatToDocuments.php';

function get_clients() {
	$data = ['clients' => []];
	$files = get_files('clients');
	$documents = files_to_documents($files);
	$data['clients'] = filter_fields($documents, ['id', 'name']);
	return $data;
}

echo json_encode(get_clients());
?>
