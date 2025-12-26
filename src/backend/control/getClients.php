<?php

include 'logged.php';
include '../model/clientsHandler.php';

function get_clients() {
	return get_all_clients();
}

echo json_encode(get_all_clients());
