<?php


/** Validate the cnpj by regex (pattern only).
* @param string $cnpj_candidate the cnpj to check if its valid.
* @return bool the value of the validation (ok or not ok)
*/
function validate_cnpj(string $cnpj_candidate): bool {
	return preg_match('/^[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}-?[0-9]{2}$/', $cnpj_candidate);
}

/** Validate the mail by regex (pattern only).
* @param string $mail_candidate the mail to check if it's valid.
* @return bool the value of the validation (ok or not ok).
*/
function validate_mail(string $mail_candidate): bool {
	return preg_match('/^[\w\.-]+@[\w\.-]+\.\w{2,}$/', $mail_candidate);
}

?>
