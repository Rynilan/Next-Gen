async function AIResponse() {
	let ticketId = getUrlParam('extra');
	let result = await controlFetch("AIIntegration.php?ticket_id=" + ticketId);
	if (result.success) {
		createMessage(result.message, ticketId, result.logged);
	} else {
		alert(result.error_message);
	}
}

async function sendMessage() {
	let message = encodeURIComponent(document.getElementById('message').value.trim());
	if (message == '') {
		return;
	}

	let ticketId = getUrlParam('extra');
	let result = await controlFetch('sendMessage.php?message=' + message + '&ticket_id=' + ticketId);

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

listenClick('send', () => {sendMessage();});
