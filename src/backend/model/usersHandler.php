
<?php
require_once 'database/crud.php';

/** Fetch a user by their email.
* @param string $mail The user's email address.
* @return array<string,mixed> The user row as an associative array, or empty array if not found.
*/
function fetch_user($mail) {
    return select('users', ['mail' => $mail])[0] ?? [];
}

/** Check whether a user exists by their email.
* @param string $mail The user's email address.
* @return bool True if the user exists, false otherwise.
*/
function user_exist($mail) {
    return !empty(fetch_user($mail));
}

/** Retrieve a user by their email.
* @param string $mail The user's email address.
* @return array<string,mixed> The user row as an associative array, or empty array if not found.
*/
function get_user($mail) {
    return fetch_user($mail);
}

/** Update a user's data.
* @param string $mail The user's email address.
* @param array<string,string|int> $data Associative array of column => new value pairs.
* @return int|false Number of affected rows if update succeeded, false otherwise.
*/
function update_user($mail, $data) {
    return (user_exist($mail))? update('users', $data, 'mail', $mail): false;
}

/** Insert a new user.
* @param string $mail The user's email address.
* @param string $pass The user's password.
* @param string $name The user's name.
* @return int|false The new user ID if inserted successfully, false otherwise.
*/
function insert_user($mail, $pass, $name) {
    if (user_exist($mail)) return false;
    $data = [
        'mail' => $mail,
        'name' => $name,
        'pass' => $pass 
    ];
    return insert('users', $data);
}
?>

