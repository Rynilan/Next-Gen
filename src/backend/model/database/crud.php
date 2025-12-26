<?php
require_once 'connect.php';

/** Execute the given query with the respective params.
* @param string $query the query to be executed.
* @param array{placeholder:string, values:array<string|int>} $values of the query params.
* @return int|array<string:mixedring|int> the result of the prepare statement.
*/
function execute(string $query,array $values): array|int{
	$db = connect();
	$prepare = $db->prepare($query);
	if (!empty($values['values']) && !empty($values['placeholder'])) {
		$prepare->bind_param($values['placeholder'], ...$values['values']);
	}

	$prepare->execute();
	$result = $prepare->get_result();
	$data = [];
	$inserted = $db->insert_id;
	$affected = $prepare->affected_rows;

	if ($result && $result->num_rows > 0) {
		while ($register = $result->fetch_assoc()) {
			$data[] = $register;
		}
	}

	$prepare->close();
	$db->close();

	return ($result instanceof mysqli_result)? $data:(($inserted > 0)? $inserted: $affected);
}

/** Return the value of the comparison string, like for string and equal for any other.
* @param mixed $value the value to be analised.
* @return string the string, ' = ' or ' like '.
*/
function comparison(mixed $value): string{
	return (is_string($value))? ' like ': ' = ';
}

/** Return the default structure of a default values of the execute.
* @return array{placeholder: '', values: []} the structure of the values.
*/
function default_param(): array{
	return ['placeholder' => '', 'values' => []];
}

/** Return the result of a query where the identification match.
* @param string $table_name the name of the table to be selected.
* @param array<string:string|int> $delimiters conditions of the where clause.
* @return array<int,string:string|int> the result of the fetch.
*/
function select(string $table_name, array $delimiters): array{
	$where = '';
	$param = default_param();
	foreach ($delimiters as $column => $value) {
		$where .= $column.comparison($value).'? and ';	
		$param['values'][] = $value;
		$param['placeholder'] .= (is_string($value))? 's': 'i';
	}
	$where = substr_replace($where, '', strrpos($where, ' and '), strlen($where));

	return execute('select * from '.$table_name.' where '.$where.';', $param);	
}

/** Insert a value on a table.
* @param string $table_name the name of the table to put data.
* @param array $data the associative array with the data as column => value.
* @return int if it was inserted or not
*/
function insert(string $table_name, array $data): int {
	// Format the fields and params of the insert;
	$fields = '(';
	$ask = '(';
	$params = default_param();
	foreach ($data as $column => $value) {
		$fields .= $column.', ';
		$ask .= '?, ';
		$params['placeholder'] .= (is_string($value))? 's': 'i';
		$params['values'][] = $value;
	}
	$fields = substr_replace($fields, ')', strrpos($fields, ', '), strlen($fields));
	$ask = substr_replace($ask, ')', strrpos($ask, ', '), strlen($ask));
	
	return execute(
		'insert into '.$table_name.' '.$fields.' values '.$ask.';',
		$params
	);
}

/** Update the values of a certain line.
* @param string $table_name the name of the table where the data 'll be updated.
* @param array $updated_data the data to replace, as column => new_value.
* @param string $id_name the name of the identifier of the line.
* @param string|int $id_value the value of the id.
* @return int the num of affected rows.
*/
function update(string $table_name, array $updated_data, string $id_name, string|int $id_value): int {
	$update_string = '';
	$param = default_param();
	foreach ($updated_data as $column => $value) {
		$param['values'][] = $value;
		$param['placeholder'] .= (is_string($value))? 's': 'i';
		$update_string .= $column.' = ?, ';	
	}
	$param['placeholder'] .= (is_string($id_value))? 's': 'i';
	$param['values'][] = $id_value;
	$update_string = substr_replace($update_string, ' ', strrpos($update_string, ', '), strlen($update_string));

	return execute(
		'update '.$table_name.' set '.$update_string.'where '.$id_name.comparison($id_value).'?;',
		$param
	);
}

?>
