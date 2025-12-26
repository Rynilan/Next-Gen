<?php
require_once 'database/crud.php';
require_once 'agentsHandler.php';

/** Fetch tickets from the database with optional status filtering.
* @param array<string,string|int> $args Associative array of column => value conditions.
* @param bool|null $only_open If true, fetch only open tickets; if false, only closed; if null, all.
* @return array<int,array<string,mixed>> Array of ticket rows.
*/
function ticket_fetch($args, $only_open = null) {
    if (!is_null($only_open)) {
        $args['status'] = ($only_open) ? 'open' : 'closed';
    }
	$ticket = select('tickets', $args);
	return $ticket;
}

/** Fetch chat messages associated with a given ticket.
* @param int $ticket_id The ID of the ticket.
* @return array<int,array<string,mixed>> Array of chat rows.
*/
function chat_fetch($ticket_id) {
    return select('ticket_chat', ['ticket_id' => $ticket_id]);
}

/** Retrieve a single ticket by its ID.
* @param int $ticket_id The ID of the ticket.
* @return array<string,mixed> The ticket row as an associative array, or empty array if not found.
*/
function get_ticket($ticket_id) {
    return ticket_fetch(['id' => $ticket_id])[0] ?? [];
}

/** Retrieve all tickets assigned to a given agent.
* @param string $agent_cnpj The agent's CNPJ identifier.
* @return array<int,array<string,mixed>> Array of ticket rows.
*/
function get_ticket_agent($agent_cnpj) {
    return ticket_fetch(['agent_cnpj' => $agent_cnpj]) ?? [];
}

/** Retrieve all tickets created by a given user.
* @param string $user_mail The user's email address.
* @return array<int,array<string,mixed>> Array of ticket rows.
*/
function get_ticket_user($user_mail) {
    return ticket_fetch(['user_mail' => $user_mail]);
}

/** Retrieve tickets filtered by both user and agent.
* @param string $user_mail The user's email address.
* @param string $agent_cnpj The agent's CNPJ identifier.
* @return array<int,array<string,mixed>> Array of ticket rows.
*/
function get_ticket_agent_user($user_mail, $agent_cnpj) {
    return ticket_fetch(['user_mail' => $user_mail, 'agent_cnpj' => $agent_cnpj]);
}

/** Retrieve all open tickets for a given user.
* @param string $user_mail The user's email address.
* @return array<int,array<string,mixed>> Array of ticket rows.
*/
function get_open_ticket_user($user_mail) {
    return ticket_fetch(['user_mail' => $user_mail], true);
}

/** Retrieve all open tickets for a given agent.
* @param string $agent_cnpj The agent's CNPJ identifier.
* @return array<int,array<string,mixed>> Array of ticket rows.
*/
function get_open_ticket_agent($agent_cnpj) {
    return ticket_fetch(['agent_cnpj' => $agent_cnpj], true);
}

/** Check whether a ticket exists by its ID.
* @param int $ticket_id The ID of the ticket.
* @return bool True if the ticket exists, false otherwise.
*/
function ticket_exist($ticket_id) {
    return !empty(get_ticket($ticket_id));
}

/** Update a ticket. 
* @param int $ticket_id the id of the ticket.
* @param array<string:string|int> $data the data to be updated.
* @return int|false the num of affected rows.
*/
function update_ticket($ticket_id, $data) {
	if (!ticket_exist($ticket_id)) return false;
	return update('tickets', $data, 'id', $ticket_id);
}

/** Close a ticket
* @param int $ticket_id the id of the ticket that 'll be closed.
* @param string $finish how the ticket ended;
* @return int|false the num of affected rows.
*/
function close_ticket($ticket_id, $finish) {
	$ticket = get_ticket($ticket_id);
	if (isset($ticket['closed']) && !is_null($ticket['closed'])) return 0;
	return update_ticket($ticket_id, [
		'status' => 'closed',
		'closed' => (new DateTime('now', new DateTimeZone('UTC')))->format('Y-m-d H:i:s'),
		'finish' => $finish
	]);
}

/** Insert a chat message associated with a ticket.
* @param int $ticket_id The ID of the ticket.
* @param string $author The author of the message (e.g., 'user' or 'agent').
* @param string $message The message content.
* @return int|false The inserted chat message ID if successful, false otherwise.
*/
function insert_chat_message($ticket_id, $author, $message) {
	if (!ticket_exist($ticket_id)) return false;
	return insert('ticket_chat', ['ticket_id' => $ticket_id, 'author' => $author, 'message' => $message]); 
}

/** Insert a new ticket and its initial chat message.
* @param string $user_mail The user's email address.
* @param string $agent_cnpj The agent's CNPJ identifier.
* @param string $reason The reason for opening the ticket.
* @param string $type The type/category of the ticket.
* @return int|false The new ticket ID if the ticket and initial message were inserted successfully, false otherwise.
*/
function insert_ticket($user_mail, $agent_cnpj, $reason, $type) {
	$ticket_id = insert('tickets', ['user_mail' => $user_mail, 'agent_cnpj' => $agent_cnpj, 'reason' => $reason, 'type' => $type]);
	insert_chat_message($ticket_id, 'user', $reason);
	return $ticket_id;
}

?>
