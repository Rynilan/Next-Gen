
<?php
require_once 'database/crud.php';

/** Fetch an agent by its CNPJ.
* @param string $cnpj The agent's CNPJ identifier.
* @return array<string,mixed> The agent row as an associative array, or empty array if not found.
*/
function fetch_agent($cnpj) {
    return select('agents', ['cnpj' => $cnpj])[0] ?? [];
}

/** Check whether an agent exists by its CNPJ.
* @param string $cnpj The agent's CNPJ identifier.
* @return bool True if the agent exists, false otherwise.
*/
function agent_exist($cnpj) {
    return !empty(fetch_agent($cnpj));
}

/** Retrieve an agent by its CNPJ.
* @param string $cnpj The agent's CNPJ identifier.
* @return array<string,mixed> The agent row as an associative array, or empty array if not found.
*/
function get_agent($cnpj) {
    return fetch_agent($cnpj);
}

/** Retrieve all agents.
* @return array<int,array<string,mixed>> Array of agent rows.
*/
function get_all_agents() {
    return select('agents', ['cnpj' => '%']);
}

/** Update an agent's data.
* @param string $cnpj The agent's CNPJ identifier.
* @param array<string,string|int> $data Associative array of column => new value pairs.
* @return int|false Number of affected rows if update succeeded, false otherwise.
*/
function update_agent($cnpj, $data) {
    return (agent_exist($cnpj))? update('agents', $data, 'cnpj', $cnpj): false;
}

/** Insert a new agent.
* @param string $cnpj The agent's CNPJ identifier.
* @param string $pass The agent's password.
* @param string $fantasy_name The agent's fantasy name.
* @param string $real_name The agent's real/legal name.
* @return int|false The new agent ID if inserted successfully, false otherwise.
*/
function insert_agent($cnpj, $pass, $fantasy_name, $real_name) {
    if (agent_exist($cnpj)) return false;
    $data = [
        'cnpj' => $cnpj,
        'pass' => $pass,
        'fantasy_name' => $fantasy_name,
        'real_name' => $real_name   
    ];
    return insert('agents', $data);
}
?>
