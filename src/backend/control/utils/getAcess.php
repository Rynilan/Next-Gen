<?php
require_once 'loadSession.php';

/** Return the acess of the current logged user (or to the given value).
* @param string|null $credential the credential to be analized.
* @return agent|user the acess.
*/
function get_acess($credential = null) {
	$credential = (is_null($credential))? $_SESSION['USER_CREDENTIAL']: $credential;
	return (preg_match('/^[\w\.-]+@[\w\.-]+\.\w{2,}$/', $credential))? 'user': 'agent';
}

?>
