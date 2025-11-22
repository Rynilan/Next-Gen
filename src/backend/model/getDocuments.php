<?php

function get_document($path) {
	return json_decode(file_get_contents($path), true);
}

?>
