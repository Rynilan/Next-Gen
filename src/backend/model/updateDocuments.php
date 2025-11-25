<?php

function update_document($path, $json_content) {
	file_put_contents($path, $json_content);
}

?>
