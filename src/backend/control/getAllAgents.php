<?php

include 'utils/logged.php';
require_once '../model/ticketsHandler.php';

/** @inheritdoc */
function all_agents() {
	return get_all_agents();
}

echo json_encode(all_agents());
