async function AIResponse() {
	let ticketId = (new URLSearchParams(window.location.search)).get('extra');
	let result = await (await fetch(absoluteUrl("src/backend/control/AIIntegration.php?ticket_id=" + ticketId))).json();
	if (result.success) {
		createMessage(result.message, ticketId, result.logged);
	} else {
		if (result.message != 'atum com maionese') {
			alert(result.error_message);
		}
	}
}

async function sendMessage() {
	let message = encodeURIComponent(document.getElementById('message').value.trim());
	if (message == '') {
		return;
	}

	let ticketId = (new URLSearchParams(window.location.search)).get('extra');
	let result = await (await fetch(absoluteUrl('src/backend/control/sendMessage.php?message=' + message + '&ticket_id=' + ticketId))).json();

	if (result.success) {
		createMessage(result.message, ticketId, result.logged);
		document.getElementById('message').value = '';
		if (result.logged == 'user') {
			AIResponse();
		}
	} else {
		alert(result.error_message);
	}
}

document.getElementById('send').addEventListener('click', () => {sendMessage();});
