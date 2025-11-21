<?php

function get_date_now(DateTime $date = null): string {
    if ($date === null) {
        $date = new DateTime();
    }
    $formatted = $date->format('d-m-Y H:i:s');
    $offset = $date->format('P');
    return $formatted . ' ' . $offset;
}

?>
