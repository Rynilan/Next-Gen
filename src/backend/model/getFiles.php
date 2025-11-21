<?php
function get_files($type) {
	$files;
	if ($type == 'tickets') {
		// Não é a função correta para conseguir dados dos tickets.
		echo 'ticket';
		$files = null;
	} else {
		$path = __DIR__.'/../../../assets/data/'.$type;
		if (!is_dir($path)) {
			echo $path;
			$files = null;
		} else {
			$files = glob($path.'/*.json');
		}
	}
	return $files;
}
?>
