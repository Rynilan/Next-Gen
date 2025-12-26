async function createTicket() {
	let agentCnpj = encodeURIComponent(document.getElementById('agent').value);
	let type = encodeURIComponent(document.getElementById('ticketType').value);
	let reason = encodeURIComponent(document.getElementById('description').value);
	let file = document.getElementById('fileAttached').files;
	file = (file.length > 0)? file[0]: null;

	const data = new FormData();
	data.append('file', file);
	data.append('agent', agentCnpj);
	data.append('type', type);
	data.append('reason', reason);

	let result = await (await fetch(
		absoluteUrl('src/backend/control/newTicket.php'), {
			method: 'POST',
			body: data
		})
	).json();

	alert(result.message);
	if (result.success) {
		window.location.href = absoluteUrl('src/frontend/view/loader.php?page_name=chat&extra=' + result.ticket_id);
	}
}

document.getElementById('createTicket').addEventListener('click', () => {createTicket();});
